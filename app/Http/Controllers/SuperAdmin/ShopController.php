<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\Logs\SuperAdminLogActivityTrait;
use App\Http\Controllers\Trait\ShopDelete;
use App\Http\Controllers\Trait\UserRole;
use App\Http\Controllers\Trait\YKImage;
use App\Http\Requests\SuperAdmin\Shop\ShopCreateRequest;
use App\Http\Requests\SuperAdmin\Shop\ShopUpdateRequest;
use App\Models\AddToCartClickLog;
use App\Models\BuyNowClickLog;
use App\Models\CountSetting;
use App\Models\FeaturesForShops;
use App\Models\FrontUserLogs;
use App\Models\GuestOrUserId;
use App\Models\Item;
use App\Models\Manager;
use App\Models\Messages;
use App\Models\PercentTemplate;
use App\Models\PremiumTemplate;
use App\Models\ShopBanner;
use App\Models\ShopDirectory;
use App\Models\ShopOwnersAndStaffs;
use App\Models\Shops;
use App\Models\State;
use App\Models\SuperAdminLogActivity;
use App\Models\User;
use App\Models\WishlistClickLog;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ShopController extends Controller
{
    use ShopDelete, UserRole, YKImage, SuperAdminLogActivityTrait;

    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }
    public function shops_activity_index()
    {
        $shopowner = Shops::all();
        return view('backend.super_admin.activity_logs.shops', ['shopowner' => $shopowner]);
    }
    public function edit($id)
    {
        $states = State::get();
        $shopowner = Shops::findOrFail($id);
        $premium_templates = PremiumTemplate::get();
        return view('backend.super_admin.shops.edit', ['shopowner' => $shopowner, 'states' => $states, 'premium_templates' => $premium_templates]);
    }

    public function update(ShopUpdateRequest $request, $id)
    {
        
        $input = $request->except('_token', '_method');
        $shopowner = Shops::findOrFail($id);
        //        return $shopowner;

        if ($request->premium == 'no') {
            $input['premium_template_id'] = null;
        }

        $add_ph = json_decode($request->additional_phones);
        $add_ph_array = [];

        if (json_decode($request->additional_phones) !== null) {
            foreach ($add_ph as $k => $v) {
                if (count($add_ph) != 0) {
                    $ph = json_decode(json_encode($v), true);
                    foreach ($ph as $k2 => $v2) {
                        array_push($add_ph_array, $v2);
                    }
                }
            }
        }
        $shopowner->name = $request->name;
        $shopowner->shop_name_url = $request->shop_name_url;
        $shopowner->shop_name = $request->shop_name;
        $shopowner->shop_name_myan = $request->shop_name_myan;
        $shopowner->description = $request->description;
        $shopowner->address = $request->address;
        $shopowner->main_phone = $request->main_phone;
        $shopowner->premium = $request->premium;
        $shopowner->valuable_product = $request->undamaged_product;
        $shopowner->undamaged_product = $request->valuable_product;
        $shopowner->damaged_product = $request->damaged_product;
        $shopowner->messenger_link = $request->messenger_link;
        $shopowner->page_link = $request->page_link;
        $shopowner->map = $request->map;
        $shopowner->additional_phones = json_encode($add_ph_array);
        $shopowner->state = $request->state;
        $shopowner->township = $request->township;
        $shopowner->other_address = $request->other_address;
        $shopowner->premium_template_id = $request->premium_template_id;
        if ($request->file('shop_logo')) {
            $this->delete_all_logo_images($shopowner->shop_logo);

            $shop_logo = time() . '1.' . $request->file('shop_logo')->getClientOriginalExtension();
            $this->save_image_shop_logo($request->file('shop_logo'), $shop_logo, 'shop_owner/logo/');
            // $this->setthumbslogo($get_path, $shop_logo);

            $shopowner->shop_logo = $shop_logo;
        }

        $updateSuccess = $shopowner->update();
        $shopownerandstaff = ShopOwnersAndStaffs::where('shop_id',$id)->where('role_id','4')->update(['phone'=>$request->main_phone]);

        $shop_dir['shop_id'] = $id;
        ShopDirectory::updateOrCreate($shop_dir);

        if ($request->hasFile('banner')) {
            $shop_banner = ShopBanner::where('shop_owner_id', $id)->get();
            foreach ($shop_banner as $b) {
                if (dofile_exists('/shop_owner/banner/' . $b->location)) {
                    $this->delete_image('shop_owner/banner/' . $b->location);
                }
            }
            if (isset($shopowner->getPhotos)) {
                $del = $shopowner->getPhotos->pluck("id");
                ShopBanner::destroy($del);
            }

            //File Restore
            $fileNameArr = [];
            foreach ($request->banner as $b) {
                $newFileName = uniqid() . '_banner' . '.' . $b->getClientOriginalExtension();
                array_push($fileNameArr, $newFileName);
                $this->save_image($b, $newFileName, 'shop_owner/banner/');
            }
            foreach ($fileNameArr as $f) {
                $banner = new ShopBanner();
                $banner->shop_owner_id = $id;
                $banner->location = $f;
                $banner->save();
            }
        }

        if ($updateSuccess) {
            $this->SuperadminShopEditLog($input);
            Session::flash('message', 'Your ads was successfully updated');

            return redirect(url('backside/super_admin/shops/all'));
        }
    }

    protected function create()
    {
        $states = State::get();
        $premium_templates = PremiumTemplate::get();
        return view('backend.super_admin.shops.create', ['states' => $states, 'premium_templates' => $premium_templates]);
    }

    protected function store(ShopCreateRequest $request)
    {
        if ($request->premium == 'yes') {
            if (!$request->hasFile('banner')) {
                return redirect()->back()->withErrors(['banner.*' => 'File Required'])->withInput();
            }
        }

        $fileNameArr = [];
        if ($request->hasFile('banner')) {
            foreach ($request->banner as $b) {

                $newFileName = uniqid() . '_banner' . '.' . $b->getClientOriginalExtension();
                array_push($fileNameArr, $newFileName);
                $this->save_image($b, $newFileName, 'shop_owner/banner/');
            }
        }

        $data = $request->except("_token");

        if ($request->premium == 'no') {
            $data['premium_template_id'] = null;
        }
        $shop_logo = $data['shop_logo'];
        //   $shop_banner = $data['shop_banner'];

        //file upload
        $imageNameone = time() . 'logo' . '.' . $shop_logo->getClientOriginalExtension();

        $this->save_image_shop_logo($shop_logo, $imageNameone, 'shop_owner/logo/');

        // $this->setthumbslogo($lpath, $imageNameone);

        //store database
        $filepath_logo = $imageNameone;
        //   $filepath_banner = $imageNametwo;
        $add_ph = json_decode($request->additional_phones);
        $add_ph_array = [];

        if (json_decode($request->additional_phones) !== null) {
            foreach ($add_ph as $k => $v) {
                if (count($add_ph) != 0) {
                    $ph = json_decode(json_encode($v), true);
                    foreach ($ph as $k2 => $v2) {
                        array_push($add_ph_array, $v2);
                    }
                }
            }
        }

        //data insert
        $data['shop_logo'] = $filepath_logo;
        $data['active'] = 'yes';
        $withouthashpsw = $data['password'];
        $hashpassword = Hash::make($data['password']);
        $data['password'] = $hashpassword;
        $data['additional_phones'] = json_encode($add_ph_array);
        $data['state'] = $request->state;
        $data['township'] = $request->township;
        $shopdata = Shops::create($data);

        foreach ($fileNameArr as $f) {
            $banner = new ShopBanner();
            $banner->shop_owner_id = $shopdata->id;
            $banner->location = $f;
            $banner->save();
        }

        $this->SuperadminShopCreateLog($shopdata);

        if ($shopdata) {
            $shop_id = $shopdata->id;
            $template_percent = [
                'shop_id' => $shop_id,
                'name' => 'default',
                'handmade' => 1,
                'charge' => 1,
                'undamaged_product' => $data['undamaged_product'],
                'damaged_product' => $data['damaged_product'],
                'valuable_product' => $data['valuable_product'],
            ];

            PercentTemplate::create($template_percent);

            $shop_dir['shop_id'] = $shop_id;
            ShopDirectory::updateOrCreate($shop_dir);
            ShopOwnersAndStaffs::create(['name' => $data['name'], 'phone' => $data['main_phone'], 'shop_id' => $shop_id, 'password' => $hashpassword, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'role_id' => 4]);
            Session::flash('message', 'Your Shop was successfully created');

            return redirect(url('backside/super_admin/shops/all'));
        } else {
            return back();
        }
    }
    /**
     * Chat Lists
     *
     * @var array
     */

    public function shop_owner_using_chat(): View
    {
        $shopowner_only_count = Messages::where('from_role', 'shopowner')->groupBy('message_shop_id')->whereBetween('created_at',[Carbon::now()->subdays(60),Carbon::now()])->get();
        return view('backend.super_admin.shops.shopowner_chat_using', compact('shopowner_only_count'));
    }

    // NOTE : This method has a model which uses MongoDB
    public function shop_owner_using_chat_all(Request $request)
    {
        $id = 1;

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
        if(empty($request->get('searchByFromdate'))){
            $searchByFromdate=Carbon::now()->toDateString();
        }else{
            $searchByFromdate = $request->get('searchByFromdate');

        }
        if(empty($request->get('searchByTodate'))){
            $searchByTodate=Carbon::now()->toDateString();
        }else{
            $searchByTodate = $request->get('searchByTodate');

        }

        if (!empty($searchByFromdate) || !empty($searchByTodate)) {
            $totalRecords = Messages::groupBy('message_shop_id')
                ->whereBetween('created_at', array(
                    Carbon::createFromDate($searchByFromdate),
                    Carbon::createFromDate($searchByTodate)->addDays(1),
                ))
                ->get();

            $totalRecordswithFilter = $totalRecords->count();
            $records = Messages::orderBy($columnName, $columnSortOrder)
                ->orderBy('created_at', 'desc')
                ->groupBy('message_shop_id')
                ->whereBetween('created_at', array(
                    Carbon::createFromDate($searchByFromdate),
                    Carbon::createFromDate($searchByTodate)->addDays(1),
                ))
                ->get(['message_shop_id', 'created_at']);
        } else {
            $totalRecords = Messages::groupBy('message_shop_id')->get();

            $totalRecordswithFilter = $totalRecords->count();
            $records = Messages::orderBy($columnName, $columnSortOrder)
                ->groupBy('message_shop_id')
                ->where('from_role', 'regex', '/.*' . $searchValue . '.*/')
                ->orWhere('created_at', 'regex', '/.*' . $searchValue . '.*/')
                ->skip($start)
                ->take($rowperpage)
                ->get(['message_shop_id', 'created_at']);
        }

        $data_arr = array();

        foreach ($records as $record) {
            foreach ($record->ShopName as $shop_name) {
                $owner_chat_count = Messages::where('message_shop_id', (int) $shop_name->id)->where('from_role', 'shopowner')
                    ->groupBy('message_user_id')
                    ->get();
                $user_chat_count = Messages::where('message_shop_id', (int) $shop_name->id)->where('from_role', 'user')
                    ->groupBy('message_user_id')
                    ->get();
                $data_arr[] = array(
                    "id" => $id++,
                    "name" => $shop_name->shop_name,
                    "created_at" => $record->created_at,
                    "owner_chat_count" => count($owner_chat_count),
                    "user_chat_count" => count($user_chat_count),
                    "action" => $shop_name->id,
                );
            }
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);

        //NOTE : This method has a model which uses MongoDB and yajrabox was a little bit harder to implement
        // $searchByFromdate = $request->input('fromDate') ?? '0-0-0 00:00:00';
        // $searchByTodate = $request->input('toDate') ?? Carbon::now();

        // $recordsQuery = Messages::with('user', 'shop')
        //     ->select('id', 'name', 'from_role', 'message_user_id', 'message_shop_id')
        //     ->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
        //     ->when($searchByTodate, fn($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        // return DataTables::eloquent($recordsQuery)
        //     ->addColumn('shop_name', function ($record) {
        //         return $record->shop->shop_name;
        //     })
        //     ->editColumn('created_at', fn($record) => $record->created_at->format('F d, Y ( h:i A )'))
        //     ->toJson();
    }

    public function shop_owner_using_chat_detail($id)
    {
        
        
                if(empty($_GET['from'])){
            $_GET['from']=Carbon::now()->toDateString();
        }
        if(empty($_GET['to'])){
            $_GET['to']=Carbon::now()->toDateString();
        }
        $validator = Validator::make(['id'=>$id,'from'=>$_GET['from'],'to'=>$_GET['to']], [
            'id' => 'required|numeric',
            'from' => 'string|max:20',
            'to' => 'string|max:20',

        ]);
        if($validator->fails()){
            return 'fail';
        }
        $from=Carbon::createFromDate($_GET['from']);
        $to=Carbon::createFromDate($_GET['to'])->addDays(1);
        $get_message_shops = Messages::where('message_shop_id', (int) $id)
            ->groupBy('message_user_id')
            ->whereBetween('created_at', [$from, $to])
            ->get();
            $tmparray=[];
            foreach($get_message_shops as $gms){
                array_push($tmparray,$gms->message_user_id);
            }

        $messages_all_users = $this->paginate($get_message_shops);

        $messages = Messages::whereIn('message_user_id',$tmparray)->where('message_shop_id', (int) $id)->get();
        $shop_owner = Messages::where('message_shop_id', (int) $id)->first();
        $shop_id = Shops::where('id', $id)->first();

        $chat_count =$get_message_shops;

        return view('backend.super_admin.shops.shopowner_chat_using_detail', [
            'messages_all_users' => $messages_all_users,
            'messages' => $messages,
            'shop_owner' => $shop_owner,
            'shop_id' => $shop_id,
            'counts' => $chat_count,
            'from'=>$_GET['from'],
            'to'=>$_GET['to']
        ]);
    }

    public function paginate($messages, $perPage = 10, $page = 1): LengthAwarePaginator
    {

        $page = Paginator::resolveCurrentPage();

        $messages = $messages instanceof Collection ? $messages : Collection::make($messages);

        return new LengthAwarePaginator($messages->forPage($page, $perPage), $messages->count(), $perPage, $page, ['path' => Paginator::resolveCurrentPath()]);
    }

    public function shop_owner_chat_product_code_search(Request $request): View
    {
        // return $request;
        // return Messages::where('message_shop_id',(int)$request->id)->get();
        $messages_all_users = Messages::when(isset(request()->search), function ($q) {
            $search = request()->search;
            $regexQuery = '/.*' . $search . '.*/';
            $q->find([
                '$and' => [

                    ['message' => ['$gt' => $search, '$lt' => $search]],
                ],
            ]);
        })->where('message_shop_id', (int) request()->id)->groupBy('message_user_id')->get();
        return DB::select(DB::raw("SELECT * FROM messages WHERE JSON_EXTRACT(message, '$.product_code') = '123'"));

        // $messages_all_users  = Messages::where('message_shop_id',(int)$request->id)
        // ->whereBetween('created_at',array(
        //          Carbon::createFromDate($request->from),
        //          Carbon::createFromDate($request->to)->addDays(1)
        //      ))
        //      ->groupBy('message_user_id')
        //      ->get();

        $messages = Messages::where('message_shop_id', (int) $request->id)->get();
        $shop_owner = Messages::where('message_shop_id', (int) $request->id)->first();
        $shop_id = Shops::where('id', $request->id)->first();

        return view('backend.super_admin.shops.shop_date_filter', [
            'messages_all_users' => $messages_all_users,
            'messages' => $messages,
            'shop_owner' => $shop_owner,
            'shop_id' => $shop_id,
        ]);
    }

    /**
     * For shops
     *
     * @var array
     */

    public function all(): View
    {
        $shopowner = Shops::all();
        return view('backend.super_admin.shops.all', ['shopowner' => $shopowner]);
    }

    /**
     * super_admin\shops\trash.blade.php
     */
    public function get_all_trash_shop(Request $request): JsonResponse
    {
        $recordsQuery = Shops::select('id', 'name', 'shop_name', 'shop_name_myan', 'created_at', 'email', 'deleted_at')
            ->where('deleted_at', '!=', null)->onlyTrashed();

        return DataTables::of($recordsQuery)
            ->addColumn('checkbox', function ($record) {
                return $record->id;
            })
            ->addColumn('expired', function ($record) {
                $deleteDate = Carbon::parse($record->deleted_at);
                $expiredMonth = Carbon::now()->subMonths(3);
                $diff = $expiredMonth->diffInDays($deleteDate);
                return $record->deleted_at < Carbon::now()->subMonths(3) ? 'expired' : $diff;
            })
            ->editColumn('shop_name', function ($record) {
                return $record->shop_name ?: '-';
            })
            ->editColumn('shop_name_myan', function ($record) {
                return Str::limit($record->shop_name_myan, 14, '...');
            })
            ->addColumn('action', function ($record) {
                return $record->id;
            })
            ->editColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->created_at));
            })
            ->make(true);
    }
    public function get_all_shops(Request $request)
    {
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        $recordsQuery = Shops::select(
            'id',
            'shop_name_myan',
            'shop_logo',
            'shop_banner',
            'premium',
            'email',
            'main_phone',
            'state',
            'pos_only',
            'created_at',
        )->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::of($recordsQuery)
            ->editColumn('shop_banner', function ($record) {
                $checkbanner = ShopBanner::where('shop_owner_id', $record->id)->first();
                return empty($checkbanner) ? '' : $checkbanner->location;
            })
            ->editColumn('shop_name_myan', function ($record) {
                return $record->shop_name_myan ?: '-';
            })
            ->editColumn('state', function ($record) {
                $state = State::where('id', $record->state)->value('name');
                return $state;
            })
            ->editColumn('pos_only', function ($record) {
                return Str::ucfirst($record->pos_only);
            })
            ->addColumn('action', function ($record) {
                return $record->id;
            })
            ->editColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->created_at));
            })
            ->make(true);
    }

    // datable for shop log activity
    public function get_shop_activity(Request $request): JsonResponse
    {
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        $shopActivityQuery = SuperAdminLogActivity::select(
            'id',
            'name',
            'type',
            'type_name',
            'status',
            'role',
            'created_at',
        )
            ->where('type', 'shop')
            ->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::of($shopActivityQuery)
            ->editColumn('created_at', fn($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->make(true);
    }

    public function show($id): View
    {
        $shop = Shops::findOrFail($id);
        $all = CountSetting::where('shop_id', $shop->id)->where('name', 'all')->get();
        $products_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'item')->get();
        $users_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'users')->get();
        $users_inquiry_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'inquiry')->get();
        $shops_view_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'shop_view')->get();
        $items_view_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'items_view')->get();
        $unique_product_click_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'item_unique_view')->get();
        $buy_now_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'buyNowClick')->get();
        $addtocartclick_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'addToCartClick')->get();
        $whislistclick_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'whislistclick')->get();
        $discountview_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'discountview')->get();
        $adsview_count_setting = CountSetting::where('shop_id', $shop->id)->where('name', 'adsview')->get();
        $poson = FeaturesForShops::where([['shop_id', '=', $shop->id], ['feature', '=', 'pos']])->get();
        $custompopular = FeaturesForShops::where([['shop_id', '=', $shop->id], ['feature', '=', 'custom_popular']])->get();

        $premium_template = PremiumTemplate::where('id', $shop->premium_template_id)->first();
        return view('backend.super_admin.shops.detail', [
            'all' => $all,
            'shop' => $shop,
            'custompopular'=>$custompopular,
            'products_count_setting' => $products_count_setting,
            'users_count_setting' => $users_count_setting,
            'users_inquiry_setting' => $users_inquiry_setting,
            'shops_view_count_setting' => $shops_view_count_setting,
            'items_view_count_setting' => $items_view_count_setting,
            'unique_product_click_count_setting' => $unique_product_click_count_setting,
            'buy_now_count_setting' => $buy_now_count_setting,
            'addtocartclick_count_setting' => $addtocartclick_count_setting,
            'whislistclick_count_setting' => $whislistclick_count_setting,
            'discountview_count_setting' => $discountview_count_setting,
            'adsview_count_setting' => $adsview_count_setting,
            'poson' => $poson,
            'premium_template' => $premium_template,
        ]);
    }

    public function counts_setting(Request $request): JsonResponse
    {
        if ($request->setting == 0) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'item')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "item";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 1) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'users')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "users";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 2) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'shop_view')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "shop_view";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 3) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'items_view')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "items_view";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 4) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'item_unique_view')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "item_unique_view";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 5) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'buyNowClick')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "buyNowClick";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 6) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'addToCartClick')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "addToCartClick";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 7) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'whislistclick')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "whislistclick";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 8) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'discountview')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "discountview";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 9) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'adsview')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "adsview";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 10) {
            if ($request->action == 0) {
                CountSetting::where('shop_id', $request->id)->where('name', 'inquiry')->forceDelete();
            } else {
                $count_setting = new CountSetting();
                $count_setting->name = "inquiry";
                $count_setting->setting = "on";
                $count_setting->shop_id = $request->id;
                $count_setting->save();
            }
        } elseif ($request->setting == 111) {
            if ($request->action == 0) {
                FeaturesForShops::where([['shop_id', '=', $request->id], ['feature', '=', 'pos']])->forceDelete();
            } else {
                $count_setting = new FeaturesForShops();
                $count_setting->shop_id = $request->id;
                $count_setting->feature = "pos";

                $count_setting->save();
            }
        }elseif ($request->setting == 112) {
            if ($request->action == 0) {
                FeaturesForShops::where([['shop_id', '=', $request->id], ['feature', '=', 'custom_popular']])->forceDelete();
            } else {
                $count_setting = new FeaturesForShops();
                $count_setting->shop_id = $request->id;
                $count_setting->feature = "custom_popular";

                $count_setting->save();
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function all_counts_setting(Request $request): JsonResponse
    {

        $array = ["item", "users", "shop_view", "items_view", "item_unique_view", "buyNowClick", "addToCartClick", "whislistclick", "discountview", "adsview", "inquiry", "pos","custom_popular"];
        if ($request->action == 0) {
            CountSetting::where('shop_id', $request->id)->forceDelete();
            FeaturesForShops::where([['shop_id', '=', $request->id], ['feature', '=', 'pos']])->forceDelete();
            FeaturesForShops::where([['shop_id', '=', $request->id], ['feature', '=', 'custom_popular']])->forceDelete();

        } else {
            $count_setting = new CountSetting();
            $count_setting->name = "all";
            $count_setting->setting = "on";
            $count_setting->shop_id = $request->id;
            $count_setting->save();

            foreach ($array as $value) {
                if ($value == 'pos') {
                    $count_setting = new FeaturesForShops();
                    $count_setting->shop_id = $request->id;
                    $count_setting->feature = "pos";

                    $count_setting->save();
                } else {
                    if($value=='custom_popular'){
                        $count_setting = new FeaturesForShops();
                        $count_setting->shop_id = $request->id;
                        $count_setting->feature = "custom_popular";
    
                        $count_setting->save();
                    }else{
                        $count_setting = new CountSetting();
                        $count_setting->name = $value;
                        $count_setting->setting = "on";
                        $count_setting->shop_id = $request->id;
                        $count_setting->save();
                    }
                  
                }
            }
        }
        return response()->json(['status' => $request->action]);
    }

    //Shop Owner Monthly Report

    public function report($id): View
    {
        $start_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now()->lastOfMonth();
        $shopowner = Shops::findOrFail($id);

        $off_counts = CountSetting::where('shop_id', $id)->get();
        $shop_counts = Shops::all();

        $items = Item::where('shop_id', $id)->orderBy('created_at', 'desc')->get();
        $products_count_setting = CountSetting::where('shop_id', $id)->where('name', 'item')->get();

        $shopview = FrontUserLogs::join('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->where('guestoruserid.user_agent', '!=', 'bot')->where('front_user_logs.shop_id', $id)->where('front_user_logs.status', 'shopdetail')->get();
        $shops_view_count_setting = CountSetting::where('shop_id', $id)->where('name', 'shop_view')->get();

        $user_inquiry = Messages::where('message_shop_id', (int) $id)->where('from_role', 'user')->get();
        $user_inquiry_count_setting = CountSetting::where('shop_id', $id)->where('name', 'inquiry')->get();

        $productclick = FrontUserLogs::leftjoin('items', 'front_user_logs.product_id', '=', 'items.id')->where('front_user_logs.status', 'product_detail')->where('items.shop_id', $id)->groupBy('front_user_logs.userorguestid')->groupBy('front_user_logs.visited_link')->get();
        $items_view_count_setting = CountSetting::where('shop_id', $id)->where('name', 'items_view')->get();

        $unique_productclick = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->where('guestoruserid.user_agent', '!=', 'bot')->where('front_user_logs.status', 'product_detail')->where('front_user_logs.shop_id', $id)->where('front_user_logs.product_id', '!=', 0)->whereBetween('guestoruserid.created_at', [$start_date, $last_date])->groupBy('front_user_logs.userorguestid')->groupBy('front_user_logs.visited_link')->get();
        $unique_product_click_count_setting = CountSetting::where('shop_id', $id)->where('name', 'item_unique_view')->get();

        $buynowclick = BuyNowClickLog::leftjoin('items', 'items.id', '=', 'buy_now_click_logs.item_id')->where('items.shop_id', $id)->orderBy('buy_now_click_logs.created_at', 'desc')->get();
        $buy_now_count_setting = CountSetting::where('shop_id', $id)->where('name', 'buyNowClick')->get();

        $addtocartclick = AddToCartClickLog::leftjoin('items', 'items.id', '=', 'add_to_cart_click_logs.item_id')->where('items.shop_id', $id)->orderBy('add_to_cart_click_logs.created_at', 'desc')->get()->unique('guest_id', 'user_id');
        $addtocartclick_count_setting = CountSetting::where('shop_id', $id)->where('name', 'addToCartClick')->get();
        $whislistclick = [];

        // $whislistclick = WishlistClickLog::leftjoin('items', 'whislist_click_logs.item_id', '=', 'items.id')->where('items.shop_id', $id)->orderBy('whislist_click_logs.created_at', 'desc')->get();
        $whislistclick_count_setting = CountSetting::where('shop_id', $id)->where('name', 'whislistclick')->get();
        $discountview = FrontUserLogs::join('discount', 'discount.item_id', '=', 'front_user_logs.product_id')->where('front_user_logs.shop_id', $id)->where('front_user_logs.product_id', '!=', 0)->where('front_user_logs.product_id', '!=', null)->where('front_user_logs.status', 'product_detail')->groupBy('front_user_logs.product_id')->get();

        $discountview_count_setting = CountSetting::where('shop_id', $id)->where('name', 'discountview')->get();
        $adsview = [];

        // $adsview = FrontUserLogs::join('guestoruserid', 'guestoruserid.id', '=', 'front_user_logs.userorguestid')->where('front_user_logs.status', 'homepage')->where('guestoruserid.user_agent', '!=', 'bot')->groupBy('front_user_logs.userorguestid')->get();
        $adsview_count_setting = CountSetting::where('shop_id', $id)->where('name', 'adsview')->get();

        $users = ShopOwnersAndStaffs::where('shop_id', $id)->get();
        $users_count_setting = CountSetting::where('shop_id', $id)->where('name', 'users')->get();

        $total_products = Item::all();

        //New Users

        // $newusers=Guestoruserid::whereBetween('created_at', [Carbon::createFromDate($start_date), Carbon::createFromDate($last_date)])->get();

        $newusers = GuestOrUserId::whereBetween('created_at', [$start_date, $last_date])->where('user_agent', '!=', 'bot')->groupBy('ip')->get();

        $total_users = GuestOrUserId::where('user_agent', '!=', 'bot')->groupBy('ip')->get();
        if (count($items) == 0) {
            $user_inquiry = [];
            $unique_productclick = [];
            $whislistclick = [];
            $addtocartclick = [];
            $buynowclick = [];
            $productclick = [];
        }

        return view('backend.super_admin.shops.report', [
            'off_count' => count($off_counts),
            'total_products_count' => count($total_products),
            'total_user_count' => count($total_users),
            'new_users' => count($newusers),

            'shop_counts' => count($shop_counts),

            'inquiry' => count($user_inquiry),
            'inquiry_count_setting' => $user_inquiry_count_setting,

            'unique_productclick' => $unique_productclick,
            'unique_product_click_count_setting' => $unique_product_click_count_setting,

            'adsview' => $adsview,
            'adsview_count_setting' => $adsview_count_setting,

            'discountview' => $discountview,
            'discountview_count_setting' => $discountview_count_setting,

            'whislistclick' => $whislistclick,
            'whislistclick_count_setting' => $whislistclick_count_setting,

            'addtocartclick' => $addtocartclick,
            'addtocartclick_count_setting' => $addtocartclick_count_setting,

            'buynowclick' => $buynowclick,
            'buy_now_count_setting' => $buy_now_count_setting,

            'productclick' => $productclick,
            'items_view_count_setting' => $items_view_count_setting,

            'shopview' => $shopview,
            'shops_view_count_setting' => $shops_view_count_setting,

            'shopid' => $shopowner,

            'items' => $items,
            'products_count_setting' => $products_count_setting,

            'managers' => $users,
            'users_count_setting' => $users_count_setting,

        ]);
    }

    public function count_date_filter(Request $request): JsonResponse
    {

        $id = $request->id;
        $from = $request->from;
        $to = $request->to;

        $total_users = User::whereBetween('created_at', [$from, $to])->get();
        $total_products = Item::whereBetween('created_at', [$from, $to])->get();
        $total_items_all_time = Item::where('shop_id', $id)->get();

        $items = Item::where('shop_id', $id)->whereBetween('created_at', [$from, $to])->get();

        $users = Manager::where('shop_id', $id)->get();

        $productview = FrontUserLogs::where('shop_id', $id)->whereBetween('created_at', [$from, $to])->groupBy('userorguestid')->groupBy('visited_link')->get();
        $user_inquiry = Messages::where('message_shop_id', (int) $id)->where('from_role', 'user')->whereBetween('created_at', array(
            Carbon::createFromDate($from),
            Carbon::createFromDate($to)->addDays(1),
        ))->get();

        // $productview = FrontUserLogs::leftjoin('items','front_user_logs.product_id','=','items.id')->where('front_user_logs.status','product_detail')->where('items.shop_id',$id)->get();

        $shopview = FrontUserLogs::join('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->where('guestoruserid.user_agent', '!=', 'bot')->where('front_user_logs.shop_id', $id)->where('front_user_logs.status', 'shopdetail')->whereBetween('front_user_logs.created_at', [$from, $to])->get();
        $unique_product_view = FrontUserLogs::leftjoin('guestoruserid', 'front_user_logs.userorguestid', '=', 'guestoruserid.id')->where('guestoruserid.user_agent', '!=', 'bot')->where('front_user_logs.status', 'product_detail')->where('front_user_logs.shop_id', $id)->where('front_user_logs.product_id', '!=', 0)->whereBetween('guestoruserid.created_at', [$from, $to])->whereBetween('front_user_logs.created_at', [$from, $to])->groupBy('front_user_logs.userorguestid')->groupBy('front_user_logs.visited_link')->get();

        // $unique_product_view = ItemLogActivity::where('shop_id',$id)->whereBetween('created_at', [$from, $to])->get()->unique('user_id','guest_id');

        $buynowclick = BuyNowClickLog::leftjoin('items', 'items.id', '=', 'buy_now_click_logs.item_id')->where('items.shop_id', $id)->whereBetween('buy_now_click_logs.created_at', [$from, $to])->get();

        $addtocartclick = AddToCartClickLog::leftjoin('items', 'items.id', '=', 'add_to_cart_click_logs.item_id')->where('items.shop_id', $id)->whereBetween('add_to_cart_click_logs.created_at', [$from, $to])->get()->unique('guest_id', 'user_id');

        $whislistclick = WishlistClickLog::leftjoin('items', 'items.id', '=', 'whislist_click_logs.item_id')->where('items.shop_id', $id)->whereBetween('whislist_click_logs.created_at', [$from, $to])->get();
        $adsview = FrontUserLogs::join('guestoruserid', 'guestoruserid.id', '=', 'front_user_logs.userorguestid')->where('front_user_logs.status', 'homepage')->where('guestoruserid.user_agent', '!=', 'bot')->groupBy('front_user_logs.userorguestid')->whereBetween('front_user_logs.created_at', [$from, $to])->get();

        $discountview = FrontUserLogs::join('discount', 'discount.item_id', '=', 'front_user_logs.product_id')->where('front_user_logs.shop_id', $id)->where('front_user_logs.product_id', '!=', 0)->where('front_user_logs.product_id', '!=', null)->where('front_user_logs.status', 'product_detail')->whereBetween('front_user_logs.created_at', [$from, $to])->groupBy('front_user_logs.product_id')->get();

        $newusers = GuestOrUserId::whereBetween('created_at', [$from, $to])->where('user_agent', '!=', 'bot')->groupBy('ip')->get();

        $countnu = 0;
        // $countnu = GuestOrUserId::select( DB::raw("count('*') as total"))->whereBetween('created_at', [Carbon::createFromDate($request->from), Carbon::createFromDate($request->to)])->total;

        if (count($total_items_all_time) == 0) {
            $user_inquiry = [];
            $unique_product_view = [];
            $whislistclick = [];
            $addtocartclick = [];
            $buynowclick = [];
            $productview = [];
        }
        return response()->json([
            'totalusers' => count($total_users),
            'totalproducts' => count($total_products),
            'newusers' => count($newusers),
            'totalitemsalltime' => count($total_items_all_time),

            //Shop Owner
            'itemscount' => count($items),
            'usercounts' => count($users),
            'productviews' => count($productview),
            'shopviewuser' => count($shopview),
            'uniqueproductviews' => count($unique_product_view),
            'buynow' => count($buynowclick),

            'addtocard' => count($addtocartclick),

            'whislistcount' => count($whislistclick),

            'ads' => count($adsview),

            'discount' => count($discountview),
            'inquiry' => count($user_inquiry),
            'for_date_shop' => Carbon::createFromDate($from)->isoFormat('MMM') . ' ' . Carbon::createFromDate($from)->isoFormat('D') . ' မှ ' .
            Carbon::createFromDate($to)->isoFormat('MMM') . ' ' . Carbon::createFromDate($to)->isoFormat('D') . ' အတွင်း ',

        ]);
    }

    //    public function report($id){
    //        $start_date = Carbon::now()->firstOfMonth();
    //        $last_date = Carbon::now()->lastOfMonth();
    //
    //        $shopowner = Shops::findOrFail($id);
    //
    //        $off_counts =CountSetting::where('shop_id',$id)->get();
    //        $shop_counts = Shops::all();
    //
    //
    //        $items = Item::where('shop_id', $id)->orderBy('created_at', 'desc')->get();
    //        $products_count_setting = CountSetting::where('shop_id',$id)->where('name','item')->get();
    //
    //
    //        $shopview = FrontUserLogs::where('shop_id',$id)->where('status','shopdetail')->orderBy('created_at', 'desc')->get()->unique('guest_id');
    //        $shops_view_count_setting = CountSetting::where('shop_id', $id)->where('name','shop_view')->get();
    //
    //        $user_inquiry = Messages::where('message_shop_id',(int)$id)->where('from_role','user')->groupBy('message_user_id')->get();
    //        $user_inquiry_count_setting = CountSetting::where('shop_id', $id)->where('name','inquiry')->get();
    //
    //
    //        $productclick = FrontUserLogs::leftjoin('items','front_user_logs.product_id','=','items.id')->where('front_user_logs.status','product_detail')->where('items.shop_id',$id)->groupBy('front_user_logs.userorguestid')->groupBy('front_user_logs.visited_link')->get();
    //        $items_view_count_setting = CountSetting::where('shop_id', $id)->where('name','items_view')->get();
    //
    //        $unique_productclick = FrontUserLogs::leftjoin('guestoruserid','front_user_logs.userorguestid','=','guestoruserid.id')->where('guestoruserid.user_agent','!=','bot')->where('front_user_logs.status','product_detail')->where('front_user_logs.shop_id',$id)->where('front_user_logs.product_id','!=',0)->whereBetween('guestoruserid.created_at', [$start_date, $last_date])->groupBy('front_user_logs.userorguestid')->groupBy('front_user_logs.visited_link')->get();
    //        $unique_product_click_count_setting = CountSetting::where('shop_id', $id)->where('name','item_unique_view')->get();
    //
    //        $buynowclick = BuyNowClickLog::leftjoin('items','items.id','=','buy_now_click_logs.item_id')->where('items.shop_id',$id)->orderBy('buy_now_click_logs.created_at', 'desc')->get();
    //        $buy_now_count_setting = CountSetting::where('shop_id',$id)->where('name','buyNowClick')->get();
    //
    //        $addtocartclick = AddToCartClickLog::leftjoin('items','items.id','=','add_to_cart_click_logs.item_id')->where('items.shop_id',$id)->orderBy('add_to_cart_click_logs.created_at', 'desc')->get()->unique('guest_id','user_id');
    //        $addtocartclick_count_setting = CountSetting::where('shop_id',$id)->where('name','addToCartClick')->get();
    //
    //        $whislistclick = WishlistClickLog::leftjoin('items','items.id','=','whislist_click_logs.item_id')->where('items.shop_id',$id)->orderBy('whislist_click_logs.created_at', 'desc')->get();
    //        $whislistclick_count_setting = CountSetting::where('shop_id',$id)->where('name','whislistclick')->get();
    //        $discountview = FrontUserLogs::join('discount','discount.item_id','=','front_user_logs.product_id')->where('front_user_logs.shop_id',$id)->where('front_user_logs.product_id','!=',0)->where('front_user_logs.product_id','!=',null)->where('front_user_logs.status','product_detail')->groupBy('front_user_logs.product_id')->get();
    //
    //// return $discountview;
    //        $discountview_count_setting = CountSetting::where('shop_id',$id)->where('name','discountview')->get();
    //
    //        $adsview = FrontUserLogs::join('guestoruserid','guestoruserid.id','=','front_user_logs.userorguestid')->where('front_user_logs.status','homepage')->where('guestoruserid.user_agent','!=','bot')->groupBy('front_user_logs.userorguestid')->get();
    //        $adsview_count_setting = CountSetting::where('shop_id',$id)->where('name','adsview')->get();
    //
    //        $users = Manager::where('shop_id',$id)->get();
    //        $users_count_setting = CountSetting::where('shop_id', $id)->where('name','users')->get();
    //
    //        $total_products = Item::all();
    //
    //        //New Users
    //
    //
    ////        $newusers=GuestOrUserId::whereBetween('created_at', [Carbon::createFromDate($start_date), Carbon::createFromDate($last_date)])->get();
    //
    //        $newusers=GuestOrUserId::whereBetween('created_at', [$start_date, $last_date])->where('user_agent','!=','bot')->groupBy('ip')->get();
    //
    //
    //        $total_users = GuestOrUserId::where('user_agent','!=','bot')->groupBy('ip')->get();
    //
    //
    //        return view('backend.super_admin.shops.report', [
    //            'off_count' => count($off_counts),
    //            'total_products_count' => count($total_products),
    //            'total_user_count' => count($total_users),
    //            'new_users'=>count($newusers),
    //            'shop_counts' => count($shop_counts),
    //
    //            'inquiry' => count($user_inquiry),
    //            'inquiry_count_setting' => $user_inquiry_count_setting,
    //
    //            'unique_productclick' => $unique_productclick,
    //            'unique_product_click_count_setting' => $unique_product_click_count_setting,
    //
    //            'adsview' => $adsview,
    //            'adsview_count_setting' => $adsview_count_setting,
    //
    //            'discountview' => $discountview,
    //            'discountview_count_setting' => $discountview_count_setting,
    //
    //            'whislistclick' => $whislistclick,
    //            'whislistclick_count_setting' => $whislistclick_count_setting,
    //
    //            'addtocartclick' => $addtocartclick,
    //            'addtocartclick_count_setting' => $addtocartclick_count_setting,
    //
    //            'buynowclick' => $buynowclick,
    //            'buy_now_count_setting' => $buy_now_count_setting,
    //
    //            'productclick' => $productclick,
    //            'items_view_count_setting' => $items_view_count_setting,
    //
    //            'shopview' => $shopview,
    //            'shops_view_count_setting' => $shops_view_count_setting,
    //
    //            'shopid' => $shopowner,
    //
    //            'items' => $items,
    //            'products_count_setting'=>$products_count_setting,
    //
    //            'managers' => $users,
    //            'users_count_setting'=>$users_count_setting,
    //
    //        ]);
    //
    //    }
    //
    //    public function count_date_filter(Request $request){
    //
    //        $id = $request->id;
    //        $from = $request->from;
    //        $to = $request->to;
    //
    //        $total_users= User::whereBetween('created_at', [$from,  $to])->get();
    //        $total_products = Item::whereBetween('created_at', [$from,  $to])->get();
    //
    //        $items = Item::where('shop_id', $id)->whereBetween('created_at', [$from, $to])->get();
    //
    //        $users = Manager::where('shop_id',$id)->whereBetween('created_at', [$from, $to])->get();
    //
    //        $productview = FrontUserLogs::where('shop_id',$id)->whereBetween('created_at', [$from,  $to])->groupBy('userorguestid')->groupBy('visited_link')->get();
    //        $user_inquiry = Messages::where('message_shop_id',(int)$id)->where('from_role','user')->groupBy('message_user_id')->get();
    //
    //
    //        // $productview = FrontUserLogs::leftjoin('items','front_user_logs.product_id','=','items.id')->where('front_user_logs.status','product_detail')->where('items.shop_id',$id)->get();
    //
    //        $shopview = FrontUserLogs::where('shop_id',$id)->where('status','shopdetail')->whereBetween('created_at', [$from, $to])->get()->unique('guest_id');
    //        $unique_product_view = FrontUserLogs::leftjoin('guestoruserid','front_user_logs.userorguestid','=','guestoruserid.id')->where('guestoruserid.user_agent','!=','bot')->where('front_user_logs.status','product_detail')->where('front_user_logs.shop_id',$id)->where('front_user_logs.product_id','!=',0)->whereBetween('guestoruserid.created_at', [$from, $to])->whereBetween('front_user_logs.created_at', [$from, $to])->groupBy('front_user_logs.userorguestid')->groupBy('front_user_logs.visited_link')->get();
    //
    //        // $unique_product_view = ItemLogActivity::where('shop_id',$id)->whereBetween('created_at', [$from, $to])->get()->unique('user_id','guest_id');
    //
    //        $buynowclick = BuyNowClickLog::leftjoin('items','items.id','=','buy_now_click_logs.item_id')->where('items.shop_id',$id)->whereBetween('buy_now_click_logs.created_at', [$from, $to])->get();
    //
    //        $addtocartclick = AddToCartClickLog::leftjoin('items','items.id','=','add_to_cart_click_logs.item_id')->where('items.shop_id',$id)->whereBetween('add_to_cart_click_logs.created_at', [$from, $to])->get()->unique('guest_id','user_id');
    //
    //        $whislistclick = WishlistClickLog::leftjoin('items','items.id','=','whislist_click_logs.item_id')->where('items.shop_id',$id)->whereBetween('whislist_click_logs.created_at', [$from, $to])->get();
    //        $adsview = FrontUserLogs::join('guestoruserid','guestoruserid.id','=','front_user_logs.userorguestid')->where('front_user_logs.status','homepage')->where('guestoruserid.user_agent','!=','bot')->groupBy('front_user_logs.userorguestid')->whereBetween('front_user_logs.created_at', [$from, $to])->get();
    //
    //        $discountview = FrontUserLogs::join('discount','discount.item_id','=','front_user_logs.product_id')->where('front_user_logs.shop_id',$id)->where('front_user_logs.product_id','!=',0)->where('front_user_logs.product_id','!=',null)->where('front_user_logs.status','product_detail')->whereBetween('front_user_logs.created_at', [$from,  $to])->groupBy('front_user_logs.product_id')->get();
    //
    //        $newusers=GuestOrUserId::whereBetween('created_at', [$from, $to])->where('user_agent','!=','bot')->groupBy('ip')->get();
    //
    //        $countnu=0;
    //        // $countnu = GuestOrUserId::select( DB::raw("count('*') as total"))->whereBetween('created_at', [Carbon::createFromDate($request->from), Carbon::createFromDate($request->to)])->total;
    //
    //        return response()->json([
    //            'totalusers' => count($total_users),
    //            'totalproducts' => count($total_products),
    //            'newusers'=>count($newusers),
    //
    //            //Shop Owner
    //            'itemscount' => count($items),
    //            'usercounts' => count($users),
    //            'productviews' => count($productview),
    //            'shopviewuser' => count($shopview),
    //            'uniqueproductviews' => count($unique_product_view),
    //            'buynow'=> count($buynowclick),
    //
    //            'addtocard' => count($addtocartclick),
    //
    //            'whislistcount' => count( $whislistclick),
    //
    //            'ads'=> count($adsview),
    //
    //            'discount' => count($discountview)
    //
    //
    //        ]);
    //
    //    }

    /** shop delete section */

    public function trash($id): RedirectResponse
    {

        $shop_owner = Shops::findOrFail($id);
        if (isset($shop_owner->getPhotos)) {
            $del = $shop_owner->getPhotos->pluck("id");
            ShopBanner::destroy($del);
        }
        $this->SuperAdminShopDeleteLog($shop_owner);
        $shop_owner->delete();

        $this->shop_relevant_destroy($id);
        ShopDirectory::where('shop_id', $id)->delete();
        return redirect(url('backside/super_admin/shops/all'))->with(['status' => 'success', 'message' => 'Your Shop was successfully Deleted']);
    }

    public function get_trash(): View
    {
        $shops = Shops::onlyTrashed()->get();
        return view('backend.super_admin.shops.trash', compact('shops'));
    }

    public function restore($id): RedirectResponse
    {
        $shop_owner = ShopBanner::where('shop_owner_id', $id)->withTrashed()->pluck("id");
        Shops::onlyTrashed()->where('id', $id)->restore();

        if ($shop_owner) {
            foreach ($shop_owner as $i) {
                ShopBanner::withTrashed()->find($i)->restore();
            }
        }
        $this->shop_relevant_restore($id);

        $shop_dir['shop_id'] = $id;
        ShopDirectory::updateOrCreate($shop_dir);

        return redirect(url('backside/super_admin/shops/all'))->with(['status' => 'success', 'message' => 'Your SHOP was restore']);
    }
    public function delete_all_logo_images($imagename)
    {
        if (dofile_exists('/shop_owner/logo/' . $imagename)) {
            $this->delete_image('shop_owner/logo/' . $imagename);
        }
        if (dofile_exists('/shop_owner/logo/mid/' . $imagename)) {
            $this->delete_image('shop_owner/logo/mid/' . $imagename);
        }
        if (dofile_exists('/shop_owner/logo/thumbs/' . $imagename)) {
            $this->delete_image('shop_owner/logo/thumbs/' . $imagename);
        }
    }
    public function delete_all_banner_images($imagename)
    {
        if (dofile_exists('/shop_owner/banner/' . $imagename)) {
            $this->delete_image('shop_owner/banner/' . $imagename);
        }

    }

    public function force_delete($id): RedirectResponse
    {
        $shop_owner = Shops::onlyTrashed()->with('getPhotos')->findOrFail($id);

        $this->delete_all_logo_images($shop_owner->shop_logo);
        if (isset($shop_owner->getPhotos)) {
            $re_id = ShopBanner::where('shop_owner_id', $id)->onlyTrashed()->get();

            foreach ($re_id as $i) {
                $this->delete_all_banner_images($i->location);

                ShopBanner::onlyTrashed()->findOrFail($i->id)->forceDelete();
            }
        }

        $this->shop_relevant_force_delete($id);

        Shops::onlyTrashed()->findOrFail($id)->forceDelete();
        ShopDirectory::where('shop_id', $id)->delete();
        return redirect()->route('backside.super_admin.shops.all_trash')->with(['status' => 'success', 'message' => 'Your SHOP was Delete']);
    }

    public function shops_multiple_delete(Request $request): RedirectResponse
    {

        $change_request_array = explode(",", $request->deleted_shops);
        foreach ($change_request_array as $id) {
            $shop_owner = Shops::onlyTrashed()->with('getPhotos')->findOrFail($id);
            $this->delete_all_logo_images($shop_owner->shop_logo);

            if (isset($shop_owner->getPhotos)) {
                $re_id = ShopBanner::where('shop_owner_id', $id)->onlyTrashed()->get();

                foreach ($re_id as $i) {
                    $this->delete_all_banner_images($i->location);

                    ShopBanner::onlyTrashed()->findOrFail($i->id)->forceDelete();
                }
            }
            $this->shop_relevant_force_delete($id);

            Shops::onlyTrashed()->findOrFail($id)->forceDelete();
        }
        return redirect()->route('shops.all_trash')->with(['status' => 'success', 'message' => 'Your SHOP was Delete']);
    }
}
