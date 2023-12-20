<?php

namespace App\Http\Controllers\ShopOwner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\FacebookTrait;
use App\Http\Controllers\Trait\Logs\MultipleDamageLogsTrait;
use App\Http\Controllers\Trait\Logs\MultiplePriceLogsTrait;
use App\Http\Controllers\Trait\Logs\ShopOwnerLogActivityTrait;
use App\Http\Controllers\Trait\MultipleItem;
use App\Http\Controllers\Trait\UserRole;
use App\Http\Controllers\Trait\YKImage;
use App\Http\Requests\ShopOwner\ItemCreateRequest;
use App\Http\Requests\ShopOwner\ItemEditRequest;
use App\Http\Requests\ShopOwner\ItemsRecapUpdateRequest;
use App\Http\Requests\ShopOwner\MultiplePriceUpdateRequest;
use App\Models\Collection;
use App\Models\Discount;
use App\Models\FrontUserLogs;
use App\Models\Gems;
use App\Models\Item;
use App\Models\ItemLogActivity;
use App\Models\MainCategory;
use App\Models\MultipleDamageLogs;
use App\Models\MultipleDiscountLogs;
use App\Models\MultiplePriceLogs;
use App\Models\PercentTemplate;
use App\Models\Shops;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ItemsController extends Controller
{
    use YKImage,
        UserRole,
        FacebookTrait,
        ShopOwnerLogActivityTrait,
        MultipleItem,
        MultipleDamageLogsTrait,
        MultiplePriceLogsTrait;

    public $err_data = [];

    public function __construct()
    {
        $this->middleware('auth:shop_owners_and_staffs');
    }

    public function index(): View
    {
        return view('backend.shopowner.item.list');
    }

    public function item_activity_index(): View
    {
        return view('backend.shopowner.activity.product.item');
    }

    public function multiprice_activity_index(): View
    {
        return view('backend.shopowner.activity.product.multiprice');
    }

    public function multidiscount_activity_index(): View
    {
        return view('backend.shopowner.activity.product.multidis');
    }

    public function multipercent_activity_index(): View
    {
        return view('backend.shopowner.activity.product.multipercent');
    }

    public function get_item_activity_log(Request $request)
    {
        $shop_id = $this->get_shopid();
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        $query = FrontUserLogs::where('shop_id', $shop_id)->where('status','product_detail')
            ->when($searchByFromdate, fn ($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn ($query) => $query->whereDate('created_at', '<=', $searchByTodate));
        
        return DataTables::of($query)
            ->editColumn('created_at', fn ($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->editColumn('item_code', function ($record){
                if(empty( $record->item)){
                  return 'deleted item';
                }else{
                   return $record->item->product_code;
                }
            })            ->editColumn('name', function ($record){
                if(empty( $record->item)){
                  return 'deleted item';
                }else{
                   return $record->item->name;
                }
            })
            ->editColumn('user_name', function($record){
                if(empty($record->guest_or_user) or $record->guest_or_user->user_id == '0'){
                    return 'GUEST';
                }else{
                   return User::where('id',$record->guest_or_user->user_id)->first()->username;
                }
            })


            ->toJson();
    }

    public function get_multiple_price_activity_log(Request $request): JsonResponse
    {

        $shop_id = $this->get_shopid();
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        $query = MultiplePriceLogs::select(
            'id',
            'product_code',
            'name',
            'user_id',
            'user_name',
            'user_role',
            'old_price',
            'new_price',
            'min_price',
            'max_price',
            'new_min_price',
            'new_max_price',
            'created_at'
        )
            ->where('shop_id', $shop_id)
            ->when($searchByFromdate, fn ($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn ($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::of($query)
            ->editColumn('created_at', fn ($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->toJson();
    }

    public function get_multiple_discount_activity_log(Request $request): JsonResponse
    {
        $shop_id = $this->get_shopid();
        $searchByFromdate = $request->input('searchByFromdate', '0-0-0 00:00:00');
        $searchByTodate = $request->input('searchByTodate', now());

        $query = MultipleDiscountLogs::select(
            'id',
            'product_code',
            'name',
            'user_name',
            'user_role',
            'old_price',
            'old_min_price',
            'old_max_price',
            'percent',
            'old_discount_price',
            'new_discount_price',
            'old_discount_min',
            'old_discount_max',
            'new_discount_min',
            'new_discount_max',
            'created_at'
        )
            ->where('shop_id', $shop_id)
            ->when($searchByFromdate, fn ($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn ($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::of($query)
            ->editColumn('created_at', fn ($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->toJson();
    }

    public function get_multiple_damage_activity_log(Request $request): JsonResponse
    {
        $shop_id = $this->get_shopid();
        $searchByFromdate = $request->input('searchByFromdate', '0-0-0 00:00:00');
        $searchByTodate = $request->input('searchByTodate', now());

        $query = MultipleDamageLogs::select(
            'id',
            'product_code',
            'name',
            'user_name',
            'user_role',
            'name',
            'decrease',
            'fee',
            'undamage',
            'damage',
            'expensive_thing',
            'new_decrease',
            'new_fee',
            'new_undamage',
            'new_damage',
            'new_expensive_thing',
            'created_at'
        )
            ->where('shop_id', $shop_id)
            ->when($searchByFromdate, fn ($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn ($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::of($query)
            ->editColumn('created_at', fn ($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->toJson();
    }
    //show create form
    //Process Ajax request
    public function get_items(Request $request): JsonResponse
    {
        $shop_id = $this->get_shopid();
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        $items = Item::select(
            'id',
            'product_code',
            'default_photo',
            'name',
            'shop_id',
            'price',
            'min_price',
            'max_price',
            'created_at'
        )
            ->where('shop_id', $shop_id)
            ->when($searchByFromdate, fn ($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn ($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::of($items)
            ->addColumn('checkbox', fn ($item) => $item->id)
            ->addColumn('price_formatted', fn ($item) => [($item->price != 0) ? $item->price : $item->min_price . '-' . $item->max_price, $item->id])
            ->addColumn('action', fn ($item) => $item->id)
            ->editColumn('created_at', fn ($item) => $item->created_at->format('F d, Y ( h:i A )'))
            ->toJson();
    }

    public function export_excel(): View
    {
        return view('backend.shopowner.item.exportexcel');
    }

    public function post_export_excel(Request $request): JsonResponse
    {
        $shop_id = $this->get_shopid();
        $searchByFromdate = $request->input('searchByFromdate', '0-0-0 00:00:00');
        $searchByTodate = $request->input('searchByTodate', now());

        $query = Item::query()
            ->orderByDesc('created_at')
            ->where('shop_id', $shop_id)
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->select(
                'id',
                'product_code',
                'default_photo',
                'name',
                'description',
                'price',
                'min_price',
                'max_price',
                'created_at'
            );

        return DataTables::of($query)
            ->addColumn('check_discount', fn ($record) => $record->YkGetDiscount)
            ->addColumn('price_formatted', function ($record) {
                return ($record->price != 0) ? $record->price : $record->min_price . '-' . $record->max_price;
            })
            ->addColumn('action', fn ($record) => $record->id)
            ->addColumn('created_at_formatted', fn ($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->toJson();
    }

    public function get_product_code_by_typing(Request $request)
    {
        $result = Item::orderBy('product_code', 'asc')
            ->where('shop_id', $request->shop_id)
            ->where('product_code', 'like', $request->chatdatabytyping . '%')
            ->select('*')
            ->take(5)
            ->get();
        echo json_encode($result);
    }

    //show create form
    public function create(): View
    {
        //tz
        $shop_id = $this->get_shopid();
        $collection = Collection::where('shop_id', $shop_id)->get();
        $somedatafromshop = Shops::where('id', $shop_id)->first();
        $percenttemplate = PercentTemplate::where('shop_id', $shop_id)->get();
        $main_cat = MainCategory::get();
        $cat_list = DB::table('categories')->leftjoin('items', 'categories.name', '=', 'items.category_id')->select('categories.*')->groupBy('categories.name')->orderByRaw("CASE
                        WHEN count(items.category_id) = 0 THEN categories.id END ASC,
            case when count(items.category_id) != 0 then count(categories.name) end DESC")->get();

        return view('backend.shopowner.item.create', ['main_cat' => $main_cat, 'cat_list' => $cat_list, 'shopowner' => $this->current_shop_data(), 'collection' => $collection, 'product_details' => [], 'somedatafromshop' => $somedatafromshop, 'percenttemplate' => $percenttemplate]);
    }

    //start storing data
    public function store(ItemcreateRequest $request): JsonResponse
    {
        // $this->ShopsaddToLog($id);
        $input = $request->except('_token');
        if ($input['price'] > 9999999999 or $input['min_price'] > 9999999999 or $input['max_price'] > 9999999999 or ($input['min_price'] > $input['max_price'])) {
            return response()->json(['msg' => 'error', 'error_msg' => 'Wrong Price']);
        }

        $jdmidimage = json_decode($input['formidphotos'], true);
        $jdthumbimage = json_decode($input['forthumbphotos'], true);
        $statictimestamp = Carbon::now()->timestamp;

        foreach ($request->file('file') as $key => $value) {
            $file = $request->file('file')[$key];

            $imageName[$key] = strtolower($statictimestamp . '_' . $key . '.' . $file->getClientOriginalExtension());
            if ($input['default_photo'] == $file->getClientOriginalName()) {
                $input['default_photo'] = $imageName[$key];
            }
            $get_path = $this->save_image($file, $imageName[$key], 'items/');
        }
        foreach ($jdmidimage as $key => $value) {
            $this->base64_to_image($value['data'], 'items/mid/' . $imageName[$key]);
        }
        foreach ($jdthumbimage as $key => $value) {
            $this->base64_to_image($value['data'], 'items/thumbs/' . $imageName[$key]);
        }
        if (!empty($imageName[0])) {
            $input['photo_one'] = $imageName[0];
        } else {
            $input['photo_one'] = '';
        }
        if (!empty($imageName[1])) {
            $input['photo_two'] = $imageName[1];
        } else {
            $input['photo_two'] = '';
        }
        if (!empty($imageName[2])) {
            $input['photo_three'] = $imageName[2];
        } else {
            $input['photo_three'] = '';
        }
        if (!empty($imageName[3])) {
            $input['photo_four'] = $imageName[3];
        } else {
            $input['photo_four'] = '';
        }
        if (!empty($imageName[4])) {
            $input['photo_five'] = $imageName[4];
        } else {
            $input['photo_five'] = '';
        }
        if (!empty($imageName[5])) {
            $input['photo_six'] = $imageName[5];
        } else {
            $input['photo_six'] = '';
        }
        if (!empty($imageName[6])) {
            $input['photo_seven'] = $imageName[6];
        } else {
            $input['photo_seven'] = '';
        }
        if (!empty($imageName[7])) {
            $input['photo_eight'] = $imageName[7];
        } else {
            $input['photo_eight'] = '';
        }
        if (!empty($imageName[8])) {
            $input['photo_nine'] = $imageName[8];
        } else {
            $input['photo_nine'] = '';
        }
        if (!empty($imageName[9])) {
            $input['photo_ten'] = $imageName[9];
        } else {
            $input['photo_ten'] = '';
        }

        //set id for manager
        $input['shop_id'] = $this->get_shopid();
        $input['user_id'] = $this->get_currentauthdata()->id;
        $input['review'] = 'default';
        $input['sizing_guide'] = 'default';

        $input['default_photo'] = strtolower($input['default_photo']);
        $input['view_count'] = 0;
        if ($input['diamond'] == 'No') {
            $input['carat'] = 0;
            $input['yati'] = 0;
            $input['pwint'] = 0;
            $input['d_gram'] = 0;
        }

        $input['weight_unit'] = 0;

        $itemupload = Item::create($input);
        $this->shop_owner_item_create_log($itemupload, $this->get_shopid());
        if ($itemupload) {
            Gems::create(['gems' => $input['gems'], 'item_id' => $itemupload->id]);
            $itemupload->tag($request->tags);
        }
        // if ($input['price'] != 0) {
        //     $toshowprice = $input['price'];
        // } else {
        //     $toshowprice = $input['min_price'] . '-' . $input['max_price'];
        // }
        // $data = $input['name'] . ' (' . $toshowprice . ')' . $input['description'];
        // $getfbdata = facebooktable::where('shop_id', $input['shop_id'])->first();
        // if (!empty($getfbdata)) {
        //     $this->posttofbpage($input['shop_id'], $data, $itemupload->check_photo);
        // }

        Session::flash('message', 'Your item was successfully uploaded');

        return response()->json(['msg' => 'success', 'id' => $itemupload->id]);
    }
    //edit function
    public function edit_ajax(Request $request)
    {
        //        if (!$this->itisowneritem($request->id)) {
        //            return $this->unauthorize();
        //        }
        $old_tags = DB::table('tagging_tagged')->where('taggable_id', $request->id)->get();
        $item_tag = Item::where('id', $request->id)->first();
        $item_tagarray = explode(',', $item_tag->tags);
        $collection = collect($item_tagarray);
        $output = $collection->implode(',');
        $current_item = Item::where('id', $request->id)->first();
        $old_gem = Gems::where('item_id', $request->id)->first();

        $all_image_fields = ['photo_one', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_six', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten'];
        $input = $request->except('_token', 'id', 'gems', 'tags', 'file', 'formidphotos', 'forthumbphotos', 'discount', 'unsetdiscount');

        if ($input['price'] > 9999999999 or $input['min_price'] > 9999999999 or $input['max_price'] > 9999999999 or ($input['min_price'] > $input['max_price'])) {
            return response()->json(['msg' => 'error', 'error_msg' => 'Wrong Price']);
        }
        $forphotos = $request->except('_token', 'id', 'gems', 'tags', 'file');
        $imageName = [];
        if ($input['diamond'] == 'No') {
            $input['carat'] = 0;
            $input['yati'] = 0;
            $input['pwint'] = 0;
            $input['d_gram'] = 0;
        }
        $input['weight_unit'] = 0;
        $input['sizing_guide'] = 'default';

        $jdmidimage = json_decode($forphotos['formidphotos'], true);
        $jdthumbimage = json_decode($forphotos['forthumbphotos'], true);
        $statictimestamp = Carbon::now()->timestamp;

        foreach ($request->file('file') as $key => $value) {
            $file = $request->file('file')[$key];

            $imageName[$key] = strtolower($statictimestamp . '_' . $key . '.' . $file->getClientOriginalExtension());
            if ($input['default_photo'] == $file->getClientOriginalName()) {
                $input['default_photo'] = $imageName[$key];
            }
            $get_path = $this->save_image($file, $imageName[$key], 'items/');

            //for thumbnail

            //$this->setthumbs($get_path, $imageName[$key]);
            //for thumbnail

        }
        foreach ($jdmidimage as $key => $value) {
            $this->base64_to_image($value['data'], 'items/mid/' . $imageName[$key]);
        }
        foreach ($jdthumbimage as $key => $value) {
            $this->base64_to_image($value['data'], 'items/thumbs/' . $imageName[$key]);
        }
        foreach ($imageName as &$imn) {
            foreach ($all_image_fields as $af) {
                if (empty($input[$af])) {

                    if ($current_item[$af] == '') {

                        $input[$af] = $imn;

                        break;
                    } else {
                        continue;
                    }
                } else {
                    continue;
                }
            }
        }
        $change = Item::where('id', $request->id)->first();
        $input['review'] = 'default';

        // return dd($change);
        if ($change->update($input)) {

            $shop_id = $this->get_shopid();

            $shopownerlogid = $this->shop_owner_item_edit_log($change, $shop_id);
            Item::find($request->id)->retag($request->all()['tags']);

            $checkgcount = Gems::where('item_id', $request->id)->count();
            if ($checkgcount == 0) {
                Gems::create(['gems' => $request->all()['gems'], 'item_id' => $request->id]);
            } else {
                Gems::where('item_id', $request->id)->update(['gems' => $request->all()['gems']]);
            }

            $tmpdis = json_decode($request->all()['discount'], true);
            if ($tmpdis['show'] == 'yes' and $request->all()['unsetdiscount'] == 'false') {
                discount::where('item_id', $request->id)->update(['discount_price' => $tmpdis['newprice'], 'discount_min' => $tmpdis['newmin'], 'discount_max' => $tmpdis['newmax']]);
            } else if ($tmpdis['show'] == 'yes' and $request->all()['unsetdiscount'] == 'true') {
                discount::where('item_id', $request->id)->delete();
            } else {
            }

            //            $dis = discount::where('item_id', $request->id)->get();
            //            foreach ($dis as $d) {
            //                $percent = $input['price'] - ($input['price'] * $d->percent / 100);
            //                discount::where('item_id', $request->id)->update(['discount_price' => $percent]);
            //            }

        }
        // else {
        //     return dd($input);

        // }

        $this->save_items_edit_detail_logs($current_item, $change, $shopownerlogid, $old_gem, $request->id, $request->tags, $output);

        Session::flash('message', 'Your item was successfully updated');
        return response()->json(['msg' => 'success', 'id' => $request->id]);
    }

    //show edit form
    public function edit($id): View
    {

        $shop_id = $this->get_shopid();
        $collection = Collection::where('shop_id', $shop_id)->get();

        $item = Item::where('shop_id', $shop_id)->where('id', $id)->with('tagged')->first();

        if ($item->weight_unit != '0') {
            $item->weight = 'temp';
        }

        $cat_list = DB::table('categories')->leftjoin('items', 'categories.name', '=', 'items.category_id')->select('categories.*')->groupBy('categories.name')->orderByRaw("CASE
                                WHEN count(items.category_id) = 0 THEN categories.id END ASC,
                    case when count(items.category_id) != 0 then count(categories.name) end DESC")->get();
        $main_cat = MainCategory::get();

        return view('backend.shopowner.item.edit', ['cat_list' => $cat_list, 'main_cat' => $main_cat, 'shopowner' => $this->current_shop_data(), 'item' => $item, 'collection' => $collection]);
    }
    public function items_photos_delete($id): string
    {
        $all_image_fields = ['photo_one', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_six', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten'];
        $item = Item::onlyTrashed()->findOrFail($id);

        foreach ($all_image_fields as $image_field) {
            if (dofile_exists('/items/' . $item->$image_field)) {

                if (env('USE_DO') == 'true') {
                    Storage::disk('digitalocean')->delete('/prod/items/' . $item->$image_field);
                    if (Storage::disk('digitalocean')->exists('/prod/items/thumbs/' . $item->$image_field)) {
                        Storage::disk('digitalocean')->delete('/prod/items/thumbs/' . $item->$image_field);
                    }
                    if (Storage::disk('digitalocean')->exists('/prod/items/mid/' . $item->$image_field)) {
                        Storage::disk('digitalocean')->delete('/prod/items/mid/' . $item->$image_field);
                    }
                } else {
                    Storage::disk('public_image')->delete('/items/' . $item->$image_field);
                    if (Storage::disk('public_image')->exists('/items/thumbs/' . $item->$image_field)) {
                        Storage::disk('public_image')->delete('/items/thumbs/' . $item->$image_field);
                    }
                    if (Storage::disk('public_image')->exists('/items/mid/' . $item->$image_field)) {
                        Storage::disk('public_image')->delete('/items/mid/' . $item->$image_field);
                    }
                }
            }
        }
        return 'done';
    }
    public function remove_image(Request $request): JsonResponse
    {
        $itemquery = Item::where('id', $request->id)->where('shop_id', $this->get_shopid());
        if (empty($itemquery->count())) {
            return response()->json(['success' => false]);
        }
        $checkimagehasintable = $itemquery->where($request->column_name, $request->name)->first();
        if (!empty($checkimagehasintable) && !empty($request->column_name)) {

            if (dofile_exists('/items/' . $request->name)) {
                // if (env('USE_DO') == 'true') {
                    Storage::disk('digitalocean')->delete('/prod/items/' . $request->name);
                    if (Storage::disk('digitalocean')->exists('/prod/items/thumbs/' . $request->name)) {
                        Storage::disk('digitalocean')->delete('/prod/items/thumbs/' . $request->name);
                    }
                    if (Storage::disk('digitalocean')->exists('/prod/items/mid/' . $request->name)) {
                        Storage::disk('digitalocean')->delete('/prod/items/mid/' . $request->name);
                    }
                // } else {
                    // Storage::disk('public_image')->delete('/items/' . $request->name);
                    // if (Storage::disk('public_image')->exists('/items/thumbs/' . $request->name)) {
                    //     Storage::disk('public_image')->delete('/items/thumbs/' . $request->name);
                    // }
                    // if (Storage::disk('public_image')->exists('/items/mid/' . $request->name)) {
                    //     Storage::disk('public_image')->delete('/items/mid/' . $request->name);
                    // }
                // }

                $itemquery->update(array($request->column_name => ''));
                return response()->json('success');
            } else {

                Item::where('id', $request->id)->update(array($request->column_name => ''));

                return response()->json($request);
            }
        } else {
            return response()->json(['success' => false]);
        }
    }

    //edit but custom upload not from dropzone
    public function custom_edit(ItemEditRequest $request): JsonResponse
    {
        // if (!$this->itisowneritem($request->id)) {
        //      return $this->unauthorize();
        //  }
        $all_image_fields = ['photo_one', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_six', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten'];
        $current_item = Item::where('id', $request->id)->first();
        $input = $request->except('_token', 'id', 'gems', 'tags', 'file', 'formidphotos', 'forthumbphotos', 'discount', 'unsetdiscount');
        if ($input['price'] > 9999999999 or $input['min_price'] > 9999999999 or $input['max_price'] > 9999999999 or ($input['min_price'] > $input['max_price'])) {
            return response()->json(['msg' => 'error', 'error_msg' => 'Wrong Price']);
        }

        if ($input['diamond'] == 'No') {
            $input['carat'] = 0;
            $input['yati'] = 0;
            $input['pwint'] = 0;
            $input['d_gram'] = 0;
        }
        $input['weight_unit'] = 0;
        $input['sizing_guide'] = 'default';

        $change = Item::where('id', $request->id)->first();
        $old = $change->getOriginal();
        $old_gem = Gems::where('item_id', $request->id)->first();
        $input['review'] = 'default';

        if ($change->update($input)) {

            $shop_id = $this->get_shopid();
            $shopownerlogid = $this->shop_owner_item_edit_log($change, $shop_id);

            $old_tags = DB::table('tagging_tagged')->where('taggable_id', $request->id)->get();
            $item_tag = Item::where('id', $request->id)->first();
            $item_tagarray = explode(',', $item_tag->tags);
            $collection = collect($item_tagarray);
            $output = $collection->implode(',');

            // $item_tagarray = implode(',',$item_tag->tags);

            Item::find($request->id)->retag($request->all()['tags']);

            $checkgcount = Gems::where('item_id', $request->id)->count();
            if ($checkgcount == 0) {
                $n_gems = Gems::create(['gems' => $request->all()['gems'], 'item_id' => $request->id]);
            } else {
                $n_gems = Gems::where('item_id', $request->id);
                $n_gems->update(['gems' => $request->all()['gems']]);
            }
            $tmpdis = json_decode($request->all()['discount'], true);
            if ($tmpdis['show'] == 'yes' and $request->all()['unsetdiscount'] == 'false') {
                discount::where('item_id', $request->id)->update(['discount_price' => $tmpdis['newprice'], 'discount_min' => $tmpdis['newmin'], 'discount_max' => $tmpdis['newmax']]);
            } else if ($tmpdis['show'] == 'yes' and $request->all()['unsetdiscount'] == 'true') {
                discount::where('item_id', $request->id)->delete();
            } else {
            }
        }

        $this->save_items_edit_detail_logs($current_item, $change, $shopownerlogid, $old_gem, $request->id, $request->tags, $output);

        Session::flash('message', 'Your item was successfully updated');
        return response()->json(['msg' => 'success', 'id' => $request->id]);
    }

    public function multiple_update_minus(MultiplePriceUpdateRequest $request): JsonResponse
    {
        $plus_price = $request->price;

        foreach ($request->id as $id) {
            $item = Item::findOrfail($id);
            $shop_id = $this->get_shopid();

            $this->MultipleMinusPriceLogs($item, $plus_price, $shop_id);
            $this->minus($item, $request);
        }
        $items = Item::whereIn('id', $request->id)->get();
        Session::flash('message', 'Your items were successfully edited');

        return response()->json(
            [
                'data' => $this->err_data,
                'items' => $items,
            ]
        );
    }

    public function multiple_update_recap(ItemsRecapUpdateRequest $request): JsonResponse
    {
        $old_percent = $request;
        foreach ($request->id as $id) {
            $item = Item::findOrfail($id);
            $shop_id = $this->get_shopid();

            // return dd($item);
            $this->MultipleDamageLogs($item, $old_percent, $shop_id);
            // $item->user_id = $user_id;
            $this->get_multiple_recap($item, $old_percent);
        }

        $items = Item::whereIn('id', $request->id)->get();

        Session::flash('message', 'Your items were successfully edited');

        return response()->json(
            [
                'items' => $items,
            ]
        );
    }

    public function multiple_update_plus(MultiplePriceUpdateRequest $request): JsonResponse
    {

        $plus_price = $request->price;
        foreach ($request->id as $id) {
            $item = Item::findOrfail($id);
            $shop_id = $this->get_shopid();

            $this->MultiplePlusPriceLogs($item, $plus_price, $shop_id);
            $this->plus($item, $request);
        }
        $items = Item::whereIn('id', $request->id)->get();

        Session::flash('message', 'Your items were successfully edited');
        return response()->json(
            [
                'success' => true,
                'data' => $request->data,
                'items' => $items,
            ],

        );
    }

    public function multiple_stock(Request $request): RedirectResponse
    {

        if ($request->stock === "In Stock") {

            $request->validate([
                "count" => "required|integer|min:0|max:1000",
            ]);
        }

        $change_request_array = explode(",", $request->multipleStockId);

        foreach ($change_request_array as $id) {

            $items = Item::find($id);
            $items->stock = $request->stock;
            if ($request->count) {
                $items->stock_count = $request->count;
            }
            $items->update();
        }
        //  Session::flash('message', 'Your Discount Item was successfully unset');

        return redirect()->back();
    }

    public function validatorformultiupdate($data): ValidationValidator
    {
        $message = [
            'price.min' => 'Price သည် 1 ထပ် မငယ်ရ', 'price.numeric' => 'Price သည် number ဖြစ်ရမည်', 'အလျော့တွက်.min' => 'အလျော့တွက်သည် 0 ထပ် မငယ်ရ',
            'အလျော့တွက်.numeric' => 'အလျော့တွက်သည် number ဖြစ်ရမည်',

            'လက်ခ.min' => 'လက်ခသည် 0 ထပ် မငယ်ရ',
            'လက်ခ.numeric' => 'လက်ခသည် number ဖြစ်ရမည်',

            'undamaged_product.min' => 'အထည်မပျက်ပြန်သွင်းသည် 0 ထပ် မငယ်ရ',
            'undamaged_product.numeric' => 'အထည်မပျက်ပြန်သွင်းသည် number ဖြစ်ရမည်',

            'damaged_product.min' => 'အထည်ပျက်စီးချို့ယွင်းသည် 0 ထပ် မငယ်ရ',
            'damaged_product.numeric' => 'အထည်ပျက်စီးချို့ယွင်းသည် number ဖြစ်ရမည်',

            'valuable_product.min' => 'တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲသည် 0 ထပ် မငယ်ရ',
            'valuable_product.numeric' => 'တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲသည် number ဖြစ်ရမည်',
        ];

        return Validator::make($data, [
            'price' => ['numeric', 'min:1'],
            'အလျော့တွက်' => ['numeric', 'min:0', 'max:90'],
            'လက်ခ' => ['numeric', 'min:0', 'max:90'],
            'undamaged_product' => ['numeric', 'min:0', 'max:90'],
            'damaged_product' => ['numeric', 'min:0', 'max:90'],
            'valuable_product' => ['numeric', 'min:0', 'max:90'],
        ], $message);
    }

    public function check_price_after_update_click(Request $request): JsonResponse
    {

        $validator = $this->validatorformultiupdate($request->all());
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'data' => $validator->errors()]);
        }

        $willupdatepricelist = [];
        if ($request->price != '') {

            foreach ($request->id as $key => $value) {
                $item = Item::where('id', $value)->first();
                $disitem = 'no';
                $disprice = 0;
                $dismin = 0;
                $dismax = 0;
                $plus_price = 0;
                $minPrice = 0;
                $maxPrice = 0;
                $fromdisprice = '----';

                if ($request->oper == 'plus') {
                    $plus_price = $item->price + $request->price;
                    $minPrice = $item->min_price + $request->price;
                    $maxPrice = $item->max_price + $request->price;
                } else {
                    $plus_price = $item->price - $request->price;
                    $minPrice = $item->min_price - $request->price;
                    $maxPrice = $item->max_price - $request->price;
                }
                if ($item->ykget_discount !== 0) {
                    $disitem = 'yes';
                    if ($item->ykget_discount->base == 'price') {
                        if ($item->ykget_discount->discount_price != 0) {
                            $fromdisprice = $item->ykget_discount->discount_price;

                            $disprice = $plus_price - $item->ykget_discount->dec_price;
                            $dismin = 0;
                            $dismax = 0;
                        } else {
                            $fromdisprice = $item->ykget_discount->discount_min . '--' . $item->ykget_discount->discount_max;

                            $disprice = 0;
                            $dismin = $minPrice - $item->ykget_discount->dec_price;
                            $dismax = $maxPrice - $item->ykget_discount->dec_price;
                        }
                    } else {
                        if ($item->ykget_discount->discount_price != 0) {
                            $fromdisprice = $item->ykget_discount->discount_price;
                            $disprice = round($plus_price - (($plus_price * $item->ykget_discount->percent) / 100));
                            $dismin = 0;
                            $dismax = 0;
                        } else {
                            $fromdisprice = $item->ykget_discount->discount_min . '--' . $item->ykget_discount->discount_max;

                            $disprice = 0;
                            $dismin = round($minPrice - (($minPrice * $item->ykget_discount->percent) / 100));
                            $dismax = round($maxPrice - (($maxPrice * $item->ykget_discount->percent) / 100));
                        }
                    }
                }

                if ($item->price != 0) {
                    $willupdatepricelist[$key] = ['fromdisprice' => $fromdisprice, 'disitem' => $disitem, 'disprice' => $disprice, 'dismin' => $dismin, 'dismax' => $dismax, 'id' => $item->id, 'name' => $item->name, 'product_code' => $item->product_code, 'orgprice' => $item->price, 'orgmin' => 0, 'orgmax' => 0, 'price' => $plus_price, 'min' => 0, 'max' => 0];
                } else {
                    $willupdatepricelist[$key] = ['fromdisprice' => $fromdisprice, 'disitem' => $disitem, 'disprice' => $disprice, 'dismin' => $dismin, 'dismax' => $dismax, 'id' => $item->id, 'name' => $item->name, 'product_code' => $item->product_code, 'price' => 0, 'min' => $minPrice, 'max' => $maxPrice, 'orgprice' => 0, 'orgmin' => $item->min_price, 'orgmax' => $item->max_price];
                }
            }
            return response()->json(['status' => 'success', 'data' => $willupdatepricelist]);
        } else {
            return response()->json(['status' => 'onlypercent']);
        }
    }

    //for detail of specified item
    public function show($id): View
    {
        $slides = Item::select('photo_one', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_six', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten')->get();
        $photo = Item::where('id', $id)->get(['photo_one', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_six', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten']);
        $photos = $photo;
        $item_id = Item::findOrFail($id)->shop_id;

        $item = Item::where('id', $id)->first();

        return view('backend.shopowner.item.detail', ['shopowner' => $this->current_shop_data(), 'item' => $item, 'photos' => $photos, 'slides' => $slides]);
    }

    //for delete function of specified item
    public function destroy($id): RedirectResponse
    {
        $shop_id = $this->get_shopid();
        $item = Item::where('id', $id)->where('shop_id', $shop_id)->first();
        $item->delete();
        $this->shop_owner_item_delete_log($item, $shop_id);
        // $shopowner_log = Item::where('id', $id)->get();

        // $item_log = ItemLogActivity::where('item_id', $id);

        if (discount::where('item_id', $id)->count() > 0) {
            discount::where('item_id', $id)->delete();
        }
        // if (Auth::guard('shop_role')->check()) {
        //     $this->role('shop_role');
        //     if (TzGate::allows($item_id == $this->role_shop_id)) {
        //         $item->delete();
        //         $item_log->delete();
        //     }
        //     $shop_id = $this->role_shop_id;
        // } else {
        //     $this->role('shop_owner');

        //     if (TzGate::allows($item_id == $this->role)) {
        //         $item->delete();
        //         $item_log->delete();
        //     }
        //     $shop_id = "yahoo";
        // }
        // $shopownerlogid = $this->shop_owner_item_delete_log($shopowner_log, $shop_id);

        return redirect(url('backside/shop_owner/items'))->with(['status' => 'success', 'message' => 'Your Item was successfully Deleted']);
    }

    public function trash(): View
    {
        return view('backend.shopowner.item.trash');
    }

    public function get_items_trash(Request $request): JsonResponse
    {
        $shop_id = $this->get_shopid();

        $records = Item::select('id', 'product_code', 'default_photo', 'price', 'deleted_at')
            ->where('shop_id', $shop_id)->onlyTrashed();

        return DataTables::of($records)
            ->addColumn('price_formatted', function ($record) {
                return ($record->price != 0) ? $record->price : $record->short_price;
            })
            ->addColumn('action', fn ($record) => $record->id)
            ->editColumn('deleted_at', fn ($item) => $item->deleted_at->format('F d, Y ( h:i A )'))
            ->toJson();
    }

    public function restore($id): RedirectResponse
    {

        Item::onlyTrashed()->where('id', $id)->where('shop_id', $this->get_shopid())->restore();
        discount::onlyTrashed()->where('item_id', $id)->where('shop_id', $this->get_shopid())->restore();
        Session::flash('message', 'Your item was successfully restored');

        return redirect('backside/shop_owner/items_trash');
    }

    public function force_delete($id): RedirectResponse
    {

        discount::onlyTrashed()->where('item_id', $id)->where('shop_id', $this->get_shopid())->forceDelete();
        $this->items_photos_delete($id);
        $forceDeletedItem = Item::onlyTrashed()->where('id', $id)->where('shop_id', $this->get_shopid())->first();
        $forceDeletedItem->forceDelete();
        $this->shop_owner_item_force_delete_log($forceDeletedItem, $this->get_shopid());

        Session::flash('message', 'Your item was successfully hard deleted ');

        return redirect()->back();
    }

    public function from_detail_edit(Request $request)
    {
        $input = $request->except('_token', '_method', 'id');
        $id = $request->input('id');
        if (($request->input('price')) != null) {
            $this->validate($request, [
                'product_code' => 'required|gt:0',
                'stock_count' => 'required|numeric|gt:0',
                'price' => 'required|numeric',
            ]);
        } elseif (($request->input('max_price')) != null) {
            $this->validate($request, [
                'product_code' => 'required|gt:0',
                'stock_count' => 'required|numeric|gt:0',
                'min_price' => 'required|numeric',
                'max_price' => 'required|numeric',
            ]);
        }
        $item = DB::table('items')->where('id', $id);
        $query = $item->update($input);
        Session::flash('message', 'Your item was successfully updated');
        return redirect()->back();
    }

    public function only_price_update(Request $request): JsonResponse
    {

        $request->validate([
            'price' => 'required',
        ]);

        $price = explode("-", $request->price);

        $item = Item::find($request->id);
        if (count($price) > 1) {
            if ($price[0] < $price[1]) {
                $item->price = 0;
                $item->min_price = $price[0];
                $item->max_price = $price[1];
                $item->update();
            } else {
                return redirect()->back()->withErrors('wrong_price', 'In Valid Price');
            }
        } else {
            $item->price = $request->price;
            $item->update();
        }

        return response()->json([
            'success' => true,
            'data' => $price,
        ]);
    }
}
