<?php

namespace App\Http\Controllers\Shopowner;

use App\Events\Shopownermessage;
use App\Forfirebase;
use App\Http\Controllers\traid\firebase;
use App\Item;
use App\discount;
use App\Facade\TzGate;
use App\Shopowner;
use App\Usernoti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\traid\UserRole;
use FG\ASN1\Universal\Integer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class DiscountController extends Controller
{
    //
    use UserRole;

    public function __construct()
    {
        $this->middleware('auth:shop_owner,shop_role');
    }
    public function validatedis($data){
        $message= [
            'percent.required' => 'Percent တန်ဖိုး ထည့်ပေးရန်',
            'percent.numeric' => 'Percent တန်ဖိုးသည် number ဖြစ်ရမည်',
            'percent.min' => 'Percent တန်ဖိုးသည် 0  ထပ် မငယ်ရ !',
            'percent.max' => 'Percent တန်ဖိုးသည် 100 မဖြစ်ရ !',
        ];
        return Validator::make($data, [
            'percent' => 'required|numeric|min:0|max:99'
        ], $message);
    }

    public function checkpriceafterdiscountclick(Request $request)
    {
        $validator = $this->validatedis($request->all());
        if ($validator->fails()) {
            return response()->json(['status'=>'error','data'=>$validator->errors()]);
        }
        $willupdatepricelist = [];

        foreach($request->id as $key=>$value){
            $item = Item::where('id', $value)->first();
            $disprice=0;
            $olddisprice='----';
            if($item->price == 0){
                $dis_min=$this->percent_calculate($item->min_price,$request->percent);
                $dis_max=$this->percent_calculate($item->max_price,$request->percent);
                $disprice=$dis_min .'--'.$dis_max;
            }else{
                $disprice=$this->percent_calculate($item->price,$request->percent);

            }
            if ($item->ykget_discount !== 0) {
                if($item->ykget_discount->discount_price != 0){
                    $olddisprice=$item->ykget_discount->discount_price;
                }else{
                    $olddisprice=$item->ykget_discount->discount_min.'--'.$item->ykget_discount->discount_max;

                }
            }
            if ($item->price != 0) {
                $willupdatepricelist[$key] = ['fromdisprice' => $olddisprice, 'disprice' => $disprice,  'id' => $item->id, 'name' => $item->name, 'product_code' => $item->product_code, 'orgprice' => $item->price, 'orgmin' => 0, 'orgmax' => 0 ];
            } else {
                $willupdatepricelist[$key] = ['fromdisprice' => $olddisprice, 'disprice' => $disprice,  'id' => $item->id, 'name' => $item->name, 'product_code' => $item->product_code, 'price' => 0,  'orgprice' => 0, 'orgmin' => $item->min_price, 'orgmax' => $item->max_price,];


            }
        }
        return response()->json(['status'=>'success','data'=>$willupdatepricelist]);
    }

    public function list()
    {

        if (isset(Auth::guard('shop_role')->user()->id)) {
            $this->role('shop_role');
            $items = discount::where('shop_id', $this->role_shop_id)->onlyTrashed()->get();
            return view('backend.shopowner.item.discount.list', ['items' => $items, 'shopowner' => $this->shop_owner]);
        } else {
            $this->role('shop_owner');
            $items = discount::where('shop_id', $this->role)->onlyTrashed()->get();
            return view('backend.shopowner.item.discount.list', ['items' => $items, 'shopowner' => $this->shop_owner]);
        }
    }

    public function getDiscountItems(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $shop_id = 1;
        if (Auth::guard('shop_owner')->check()) {
            $shop_id = Auth::guard('shop_owner')->user()->id;

        } else {
            $shop_id = Auth::guard('shop_role')->user()->shop_id;
        }

        $totalRecords = discount::select('count(*) as allcount')
                        ->join('items', 'discount.item_id', '=', 'items.id')
                        ->where('discount.shop_id', $shop_id)
                        ->where('items.product_code', 'like', '%' . $searchValue . '%')
                        ->count();
        $totalRecordswithFilter = $totalRecords;

        $records = discount::orderBy($columnName, $columnSortOrder)
            ->join('items', 'discount.item_id', '=', 'items.id')
            ->where('discount.shop_id', $shop_id)
            ->where('items.product_code', 'like', '%' . $searchValue . '%')
             ->select('discount.*', 'items.product_code', 'items.default_photo', 'items.price', 'items.min_price', 'items.max_price')
            ->skip($start)
            ->take($rowperpage)
            ->get();


        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "product_code" => $record->product_code,
                "image" => $record->default_photo,
                "old_price" => ($record->price != 0) ? $record->price : ($record->min_price . '-' . $record->max_price),
                "new_price" => ($record->discount_price != 0) ? $record->discount_price : ($record->discount_min . '-' . $record->discount_max),
                "date_time" => $record->created_at,
                "unset_discount" => $record->id,
                "item_id"=>$record->item_id
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
    }

    public function discount($id)
    {
        // $item_id = Item::findOrFail($id)->shop_id;
        $role_users = Auth::guard('shop_role')->check();
        if($role_users){
            $hasdiscount = discount::where('item_id', $id);
            if ($hasdiscount->count() > 0) {
                return 'Already Has';
            }
            $item = Item::where('id', $id)->first();
        }
         // if (Auth::guard('shop_role')->check()) {
        //     $this->role('shop_role');
        //     if (TzGate::allows($item_id == $this->role_shop_id)) {
        //         $hasdiscount = discount::where('item_id', $id);
        //         if ($hasdiscount->count() > 0) {
        //             return 'Already Has';
        //         }
        //         $item = Item::where('id', $id)->first();
        //     }
        // } else {
        //     $this->role('shop_owner');
        //     if (TzGate::allows($item_id == $this->role)) {
                $hasdiscount = discount::where('item_id', $id);
                if ($hasdiscount->count() > 0) {
                    return 'Already Has';
                }
                $item = Item::where('id', $id)->first();
        //     }
        // }


        return view('backend.shopowner.item.discount.Setdiscount', ['item' => $item]);
    }

    public function remove(Request $request)
    {

        $item = discount::where('id', $request->id)->forceDelete();
        $discount = Item::where('id',$request->item_id)->with('tagged')->first();
        $discount->untag('Discount');



        Session::flash('message', 'Your Discount Item was successfully unset');

        return redirect()->back();
    }

    //multiple discount unset
    public function multiple_unset_discount(Request $request)
    {
        $change_request_array = explode(",", $request->unsetItems);
        foreach($change_request_array as $unset){
            DB::table('discount')->where('id',$unset)->delete();
        }
        Session::flash('message', 'Your Discount Item was successfully unset');

        return redirect()->back();
    }


    private function percent_calculate($price, $percent): int
    {
        return round($price - ($percent * $price / 100));
    }

    public function multiple_discount(Request $request)
    {
        $plus_price = $request->percent;
        $request->validate([
            'percent' => 'required|numeric|min:0|max:99'
        ],
            [
                'percent.required' => 'Percent တန်ဖိုး ထည့်ပေးရန်',
                'percent.numeric' => 'Percent တန်ဖိုးသည် number ဖြစ်ရမည်',
                'percent.min' => 'Percent တန်ဖိုးသည် 0  ထပ် မငယ်ရ !',
                'percent.max' => 'Percent တန်ဖိုးသည် 100 မဖြစ်ရ !',
            ]
        );

        if (isset(Auth::guard('shop_role')->user()->id)) {
            $shop_id = Auth::guard('shop_role')->user()->shop_id;
        } else {
            $shop_id = Auth::guard('shop_owner')->user()->id;
        }
        foreach ($request->id as $id) {
            //for noti
            $checkShopOwnerFav = DB::table('shop_owners_fav')->where('fav_id', $id)->pluck('user_id');
            $checkManagerFav = DB::table('manager_fav')->where('fav_id', $id)->pluck('user_id');
            $checkUserFav = DB::table('users_fav')->where('fav_id', $id)->pluck('user_id');

            $message = "Item " . $id . " is on discount!";
            $read_by_receiver = 0;
            $item_id = intval($id);
            if (isset(Auth::guard('shop_role')->user()->id)) {
                $sender_id = Auth::guard('shop_role')->user()->shop_id;
            } else {
                $sender_id = Auth::guard('shop_owner')->user()->id;
            };
            if (count($checkShopOwnerFav) != 0) {
                $shop_owners = 'shop_owners';
                for ($i = 0; $i < count($checkShopOwnerFav); $i++) {
                    $receiver_user_id = $checkShopOwnerFav[$i];
                    $Usernoti = Usernoti::where('sender_shop_id', $sender_id)
                        ->where('receiver_user_id', $receiver_user_id)
                        ->where('user_type', $shop_owners);
                    $query = $Usernoti->updateOrInsert([
                        'sender_shop_id' => $sender_id,
                        'receiver_user_id' => $receiver_user_id,
                        'user_type' => $shop_owners,
                        'item_id' => $item_id,
                        'message' => $message,
                        'read_by_receiver' => $read_by_receiver,
                    ]);
                }
            }
            if (count($checkManagerFav) != 0) {
                $manager = 'manager';
                for ($i = 0; $i < count($checkManagerFav); $i++) {
                    $receiver_user_id = $checkManagerFav[$i];
                    $Usernoti = Usernoti::where('sender_shop_id', $sender_id)
                        ->where('receiver_user_id', $receiver_user_id);
                    $query = $Usernoti->updateOrInsert([
                        'sender_shop_id' => $sender_id,
                        'receiver_user_id' => $receiver_user_id,
                        'user_type' => $manager,
                        'item_id' => $item_id,
                        'message' => $message,
                        'read_by_receiver' => $read_by_receiver,
                    ]);

                }
            }
            if (count($checkUserFav) != 0) {
                $users = 'users';
                for ($i = 0; $i < count($checkUserFav); $i++) {
                    $receiver_user_id = $checkUserFav[$i];
                    $Usernoti = Usernoti::where('sender_shop_id', $sender_id)
                        ->where('receiver_user_id', $receiver_user_id);
                    $query = $Usernoti->updateOrInsert([
                        'sender_shop_id' => $sender_id,
                        'receiver_user_id' => $receiver_user_id,
                        'user_type' => $users,
                        'item_id' => $item_id,
                        'message' => $message,
                        'read_by_receiver' => $read_by_receiver,
                    ]);

                }
            }
            $takecheckphoto = Item::where('id', $item_id)->first();
            $link = url($takecheckphoto->withoutspace_shopname . '/product_detail/' . $item_id);
            firebase::send($item_id, 'Discount Product', $message, $link, 'logo', url($takecheckphoto->check_photo));
            //noti end


            $hasdiscount = discount::where('item_id', $id);
            $olddiscount = discount::where('item_id', $id)->get();
            $price = Item::where('id', $id)->get();
            if ($hasdiscount->count() > 0) {
                foreach ($price as $p) {
                    $discount_id = discount::where('item_id', $id)->pluck('id');
                    foreach ($discount_id as $d_id) {
                        $discount = discount::findOrFail($d_id);
                        if ($p->price != 0) {
                            $discount->discount_price = $this->percent_calculate($p->price, $request->percent);
                        } elseif ($p->min_price != 0 && $p->max_price != 0) {
                            $discount->discount_min = $this->percent_calculate($p->min_price, $request->percent);
                            $discount->discount_max = $this->percent_calculate($p->max_price, $request->percent);
                        }
                        $discount->percent = $request->percent;
                        // return dd($discount);
                        $discount->update();
                        \MultipleDiscountLogs:: MultipleDiscountLogs($p,$discount,$olddiscount,$shop_id);
                    }

                }
            } else {
                foreach ($price as $p) {
                    $discount = new discount();
                    if ($p->price != 0) {
                        $discount->discount_price = $this->percent_calculate($p->price, $request->percent);
                    } elseif ($p->min_price != 0 && $p->max_price != 0) {
                        $discount->discount_min = $this->percent_calculate($p->min_price, $request->percent);
                        $discount->discount_max = $this->percent_calculate($p->max_price, $request->percent);
                    }
                    $discount->item_id = $id;
                    $discount->shop_id = $shop_id;
                    $discount->percent = $request->percent;
                    \MultipleDiscountLogs:: MultipleNoneDiscountLogs($p,$discount,$olddiscount,$shop_id);

                    $discount->save();
                }
            }


        }
        Session::flash('message', 'Your Discount Item was successfully Set');

        return response()->json(['status'=>'success']);
    }

    public function discount_save(Request $request)
    {


        if (empty($request->all()['discount_min']) and empty($request->all()['discount_max']) and empty($request->all()['discount_price'])) {
            return 'error';
        }


        //for noti
        $checkShopOwnerFav = DB::table('shop_owners_fav')->where('fav_id', $request->item_id)->pluck('user_id');
        $checkManagerFav = DB::table('manager_fav')->where('fav_id', $request->item_id)->pluck('user_id');
        $checkUserFav = DB::table('users_fav')->where('fav_id', $request->item_id)->pluck('user_id');

        $message = "Item " . $request->item_id . " is on discount!";
        $read_by_receiver = 0;
        $item_id = intval($request->item_id);
        if (isset(Auth::guard('shop_role')->user()->id)) {
            $sender_id = Auth::guard('shop_role')->user()->shop_id;
        } else {
            $sender_id = Auth::guard('shop_owner')->user()->id;
        };
        if (count($checkShopOwnerFav) != 0) {
            $shop_owners = 'shop_owners';
            for ($i = 0; $i < count($checkShopOwnerFav); $i++) {
                $receiver_user_id = $checkShopOwnerFav[$i];
                $Usernoti = Usernoti::where('sender_shop_id', $sender_id)
                    ->where('receiver_user_id', $receiver_user_id)
                    ->where('user_type', $shop_owners);
                $query = $Usernoti->updateOrInsert([
                    'sender_shop_id' => $sender_id,
                    'receiver_user_id' => $receiver_user_id,
                    'user_type' => $shop_owners,
                    'item_id' => $item_id,
                    'message' => $message,
                    'read_by_receiver' => $read_by_receiver,
                ]);
            }
        }
        if (count($checkManagerFav) != 0) {
            $manager = 'manager';
            for ($i = 0; $i < count($checkManagerFav); $i++) {
                $receiver_user_id = $checkManagerFav[$i];
                $Usernoti = Usernoti::where('sender_shop_id', $sender_id)
                    ->where('receiver_user_id', $receiver_user_id);
                $query = $Usernoti->updateOrInsert([
                    'sender_shop_id' => $sender_id,
                    'receiver_user_id' => $receiver_user_id,
                    'user_type' => $manager,
                    'item_id' => $item_id,
                    'message' => $message,
                    'read_by_receiver' => $read_by_receiver,
                ]);

            }
        }
        if (count($checkUserFav) != 0) {
            $users = 'users';
            for ($i = 0; $i < count($checkUserFav); $i++) {
                $receiver_user_id = $checkUserFav[$i];
                $Usernoti = Usernoti::where('sender_shop_id', $sender_id)
                    ->where('receiver_user_id', $receiver_user_id);
                $query = $Usernoti->updateOrInsert([
                    'sender_shop_id' => $sender_id,
                    'receiver_user_id' => $receiver_user_id,
                    'user_type' => $users,
                    'item_id' => $item_id,
                    'message' => $message,
                    'read_by_receiver' => $read_by_receiver,
                ]);

            }
        }

        //noti end
        $takecheckphoto = Item::where('id', $item_id)->first();
        $link = url($takecheckphoto->withoutspace_shopname . '/product_detail/' . $item_id);
        $test = firebase::send($request->item_id, 'Discount Product', $message, $link, 'logo', url($takecheckphoto->check_photo));
        if (isset(Auth::guard('shop_role')->user()->id)) {
            $input = $request->except('_token');

            $input['shop_id'] = Auth::guard('shop_role')->user()->shop_id;
            if ($input['base'] == 'price') {
                $input['percent'] = $input['percentbyprice'];
                $input['dec_price'] = $input['price'];
            }
            $item = discount::create($input);
             $discount = Item::where('id',$request->item_id)->first();
            if($item){
               $discount->tag('Discount');
            }

            Session::flash('message', 'Your Discount Item was successfully Set');

            return redirect('backside/shop_owner/items/' . $request->item_id);
        }

        $input = $request->except('_token');

        if ($input['base'] == 'price') {
            $input['percent'] = $input['percentbyprice'];
            $input['dec_price'] = $input['price'];
        }

        $input['shop_id'] = Auth::guard('shop_owner')->user()->id;
        $item = discount::create($input);

        $discount = Item::where('id',$request->item_id)->first();

        $discount->tag('Discount');

        if($item){
           Session::flash('message', 'Your Discount Item was successfully Set');
        }

        $getnoti = Usernoti::where([['item_id', '=', $request->item_id], ['read_by_receiver', '=', 0]])->get();
//        foreach ($getnoti as $gn) {
//            event(new Shopownermessage('fefe'));
//
//        }

        return redirect('backside/shop_owner/items/' . $request->item_id);
    }

}
