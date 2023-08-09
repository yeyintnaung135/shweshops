<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\ShopDelete;
use App\Http\Controllers\Trait\UserRole;
use App\Models\AddToCartClickLog;
use App\Models\BuyNowClickLog;
use App\Models\CountSetting;
use App\Models\FeaturesForShops;
use App\Models\FrontUserLogs;
use App\Models\GuestOrUserId;
use App\Models\Item;
use App\Models\Manager;
use App\Models\Messages;
use App\Models\PremiumTemplate;
use App\Models\ShopBanner;
use App\Models\ShopDirectory;
use App\Models\ShopOwner;
use App\Models\State;
use App\Models\SuperAdminLogActivity;
use App\Models\User;
use App\Models\WishlistClickLog;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    use ShopDelete;
    use UserRole;

    public function __construct()
    {
        $this->middleware(['auth:super_admin', 'admin']);
    }

    /**
     * Chat Lists
     *
     * @var array
     */

    public function show_owner_using_chat()
    {

        $shopowner_only_count = Messages::where('from_role', 'shopowner')->groupBy('message_shop_id')->get();
        return view('backend.super_admin.shops.shopowner_chat_using', compact('shopowner_only_count'));
    }

    public function show_owner_using_chat_all(Request $request)
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

        $searchByFromdate = $request->get('searchByFromdate');
        $searchByTodate = $request->get('searchByTodate');

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
    }

    public function show_owner_using_chat_detail($id)
    {
        $get_message_shops = Messages::where('message_shop_id', (int) $id)
            ->groupBy('message_user_id')
            ->get();

        $messages_all_users = $this->paginate($get_message_shops);

        $messages = Messages::where('message_shop_id', (int) $id)->get();
        $shop_owner = Messages::where('message_shop_id', (int) $id)->first();
        $shop_id = ShopOwner::where('id', $id)->first();

        $chat_count = Messages::where('message_shop_id', (int) $id)->groupBy('message_user_id')->get();

        return view('backend.super_admin.shops.shopowner_chat_using_detail', [
            'messages_all_users' => $messages_all_users,
            'messages' => $messages,
            'shop_owner' => $shop_owner,
            'shop_id' => $shop_id,
            'counts' => $chat_count,
        ]);
    }

    public function paginate($messages, $perPage = 10, $page = 1)
    {

        $page = Paginator::resolveCurrentPage();

        $messages = $messages instanceof Collection ? $messages : Collection::make($messages);

        return new LengthAwarePaginator($messages->forPage($page, $perPage), $messages->count(), $perPage, $page, ['path' => Paginator::resolveCurrentPath()]);
    }

    public function shop_owner_chat_product_code_search(Request $request)
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
        $shop_id = ShopOwner::where('id', $request->id)->first();

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

    public function all()
    {
        $shopowner = ShopOwner::all();
        return view('backend.super_admin.shops.all', ['shopowner' => $shopowner]);
    }
    public function get_all_trash_shop(Request $request)
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

        $totalRecords = ShopOwner::onlyTrashed()
            ->where('shop_name', 'like', '%' . $searchValue . '%')
            ->orWhere('shop_name_myan', 'like', '%' . $searchValue . '%')
            ->select('count(*) as allcount')->count();
        $totalRecordswithFilter = ShopOwner::onlyTrashed()->select('count(*) as allcount')->count();

        $records = ShopOwner::orderBy($columnName, $columnSortOrder)
            ->orderBy('created_at', 'desc')
            ->where('deleted_at', '!=', null)
            ->where('shop_name', 'like', '%' . $searchValue . '%')
            ->orWhere('shop_name_myan', 'like', '%' . $searchValue . '%')
            ->onlyTrashed()
            ->skip($start)
            ->take($rowperpage)
            ->get();

        //   ->orderBy('created_at', 'desc')

        $data_arr = array();

        foreach ($records as $record) {
            $deleteDate = Carbon::parse($record->deleted_at);
            $expiredMonth = Carbon::now()->subMonths(3);
            $diff = $expiredMonth->diffInDays($deleteDate);
            $data_arr[] = array(
                "checkbox" => $record->id,
                "id" => $record->id,
                "name" => $record->name,
                "shop_name" => $record->shop_name ? $record->shop_name : '-',
                "shop_name_myan" => $record->shop_name_myan ? $record->shop_name_myan : '-',
                "email" => $record->email,
                "expired" => $record->deleted_at < Carbon::now()->subMonths(3) ? 'expired' : $diff,
                "action" => $record->id,
                "created_at" => $record->created_at,
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
    public function get_all_shops(Request $request)
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

        $searchByFromdate = $request->get('searchByFromdate');
        $searchByTodate = $request->get('searchByTodate');

        if ($searchByFromdate == null) {
            $searchByFromdate = '0-0-0 00:00:00';
        }
        if ($searchByTodate == null) {
            $searchByTodate = Carbon::now();
        }

        $state = State::where('name', 'like', '%' . $searchValue . '%')->value('id');

        $totalRecords = ShopOwner::select('count(*) as allcount')
            ->where(function ($query) use ($searchValue) {
                if (strtolower($searchValue) == "premium") {
                    $premium = '%' . "yes" . '%';
                } elseif (strtolower($searchValue) == "normal") {
                    $premium = '%' . "no" . '%';
                } else {
                    $premium = $searchValue;
                }
                $query->where('premium', 'like', $premium);
            })
            ->orWhere(function ($query) use ($searchValue, $state) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_name_myan', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%')
                    ->orWhere('address', 'like', '%' . $searchValue . '%')
                    ->orWhere('main_phone', 'like', '%' . $searchValue . '%')
                    ->orWhere('state', '=', $state);
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])->count();
        $totalRecordswithFilter = $totalRecords;

        $records = ShopOwner::orderBy($columnName, $columnSortOrder)
            ->where(function ($query) use ($searchValue) {
                if (strtolower($searchValue) == "premium") {
                    $premium = '%' . "yes" . '%';
                } elseif (strtolower($searchValue) == "normal") {
                    $premium = '%' . "no" . '%';
                } else {
                    $premium = $searchValue;
                }
                $query->where('premium', 'like', $premium);
            })
            ->orWhere(function ($query) use ($searchValue, $state) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('shop_name_myan', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%')
                    ->orWhere('address', 'like', '%' . $searchValue . '%')
                    ->orWhere('main_phone', 'like', '%' . $searchValue . '%')
                    ->orWhere('state', '=', $state);
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->select('shop_owners.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $checkbanner = ShopBanner::where('shop_owner_id', $record->id)->first();
            if (empty($checkbanner)) {
            } else {
                $record->shop_banner = ShopBanner::where('shop_owner_id', $record->id)->first()->location;
            }
            $state = State::where('id', $record->state)->value('name');
            $data_arr[] = array(
                "id" => $record->id,
                "name" => $record->name,
                "shop_name_myan" => $record->shop_name_myan ? $record->shop_name_myan : '-',
                "shop_logo" => $record->shop_logo,
                "shop_banner" => $record->shop_banner,
                "premium" => $record->premium,
                "description" => Str::limit($record->description, 50, ' ...'),
                "email" => $record->email,
                "အထည်မပျက်_ပြန်သွင်း" => $record->အထည်မပျက်_ပြန်သွင်း,
                "တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ" => $record->တန်ဖိုးမြင့်အထည်_နှင့်_အထည်မပျက်ပြန်လဲ,
                "အထည်ပျက်စီးချို့ယွင်း" => $record->အထည်ပျက်စီးချို့ယွင်း,
                "messenger_link" => $record->messenger_link,
                "page_link" => $record->page_link,
                "address" => $record->address,
                "main_phone" => $record->main_phone,
                "state" => $state,
                "action" => $record->id,
                "created_at" => $record->created_at,
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

    // datable for shop log activity
    public function get_shop_activity(Request $request)
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

        $searchByFromdate = $request->get('searchByFromdate');
        $searchByTodate = $request->get('searchByTodate');

        if ($searchByFromdate == null) {
            $searchByFromdate = '0-0-0 00:00:00';
        }
        if ($searchByTodate == null) {
            $searchByTodate = Carbon::now();
        }

        $totalRecords = SuperAdminLogActivity::select('count(*) as allcount')
            ->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('type', 'like', '%' . $searchValue . '%')
                    ->orWhere('type_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('type_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('role', 'like', '%' . $searchValue . '%')
                    ->orWhere('status', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->where('type', 'shop')
            ->count();
        $totalRecordswithFilter = $totalRecords;
        $ads = SuperAdminLogActivity::where('type', ['shop'])->orderBy('created_at', 'desc')->get();
        $records = SuperAdminLogActivity::orderBy($columnName, $columnSortOrder)
            ->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('type', 'like', '%' . $searchValue . '%')
                    ->orWhere('type_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('type_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('role', 'like', '%' . $searchValue . '%')
                    ->orWhere('status', 'like', '%' . $searchValue . '%');
            })
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->select('superadmin_log_activities.*')
            ->where('type', 'shop')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "name" => $record->name,
                "type" => $record->type,
                "type_name" => $record->type_name,
                "status" => $record->status,
                "role" => $record->role,
                "created_at" => date('F d, Y ( h:i A )', strtotime($record->created_at)),
                // "created_at" => $record->created_at,
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

    public function show($id)
    {
        $shop = ShopOwner::findOrFail($id);
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

        $premium_template = PremiumTemplate::where('id', $shop->premium_template_id)->first();
        return view('backend.super_admin.shops.detail', [
            'all' => $all,
            'shop' => $shop,
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

    public function counts_setting(Request $request)
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
        }

        return response()->json(['status' => 'success']);
    }

    public function all_counts_setting(Request $request)
    {

        $array = ["item", "users", "shop_view", "items_view", "item_unique_view", "buyNowClick", "addToCartClick", "whislistclick", "discountview", "adsview", "inquiry", "pos"];
        if ($request->action == 0) {
            CountSetting::where('shop_id', $request->id)->forceDelete();
            FeaturesForShops::where([['shop_id', '=', $request->id], ['feature', '=', 'pos']])->forceDelete();
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
                    $count_setting = new CountSetting();
                    $count_setting->name = $value;
                    $count_setting->setting = "on";
                    $count_setting->shop_id = $request->id;
                    $count_setting->save();
                }
            }
        }
        return response()->json(['status' => $request->action]);
    }

    //Shop Owner Monthly Report

    public function report($id)
    {
        $start_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now()->lastOfMonth();
        $shopowner = ShopOwner::findOrFail($id);

        $off_counts = CountSetting::where('shop_id', $id)->get();
        $shop_counts = ShopOwner::all();

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

        $whislistclick = WishlistClickLog::leftjoin('items', 'items.id', '=', 'whislist_click_logs.item_id')->where('items.shop_id', $id)->orderBy('whislist_click_logs.created_at', 'desc')->get();
        $whislistclick_count_setting = CountSetting::where('shop_id', $id)->where('name', 'whislistclick')->get();
        $discountview = FrontUserLogs::join('discount', 'discount.item_id', '=', 'front_user_logs.product_id')->where('front_user_logs.shop_id', $id)->where('front_user_logs.product_id', '!=', 0)->where('front_user_logs.product_id', '!=', null)->where('front_user_logs.status', 'product_detail')->groupBy('front_user_logs.product_id')->get();

        $discountview_count_setting = CountSetting::where('shop_id', $id)->where('name', 'discountview')->get();

        $adsview = FrontUserLogs::join('guestoruserid', 'guestoruserid.id', '=', 'front_user_logs.userorguestid')->where('front_user_logs.status', 'homepage')->where('guestoruserid.user_agent', '!=', 'bot')->groupBy('front_user_logs.userorguestid')->get();
        $adsview_count_setting = CountSetting::where('shop_id', $id)->where('name', 'adsview')->get();

        $users = Manager::where('shop_id', $id)->get();
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

    public function count_date_filter(Request $request)
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
    //        $shopowner = Shopowner::findOrFail($id);
    //
    //        $off_counts =CountSetting::where('shop_id',$id)->get();
    //        $shop_counts = Shopowner::all();
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

    public function trash($id)
    {

        $shop_owner = ShopOwner::findOrFail($id);
        if (isset($shop_owner->getPhotos)) {
            $del = $shop_owner->getPhotos->pluck("id");
            ShopBanner::destroy($del);
        }
        \SuperAdminLogActivity::SuperAdminShopDeleteLog($shop_owner);
        $shop_owner->delete();

        $this->shop_relevant_destroy($id);
        ShopDirectory::where('shop_id', $id)->delete();
        return redirect()->route('shops.all')->with(['status' => 'success', 'message' => 'Your Shop was successfully Deleted']);
    }

    public function get_trash()
    {
        $shop_owners = ShopOwner::onlyTrashed()->get();
        return view('backend.super_admin.shops.trash', compact('shop_owners'));
    }

    public function restore($id)
    {
        $shop_owner = ShopBanner::where('shop_owner_id', $id)->withTrashed()->pluck("id");
        ShopOwner::onlyTrashed()->where('id', $id)->restore();

        if ($shop_owner) {
            foreach ($shop_owner as $i) {
                ShopBanner::withTrashed()->find($i)->restore();
            }
        }
        $this->shop_relevant_restore($id);

        $shop_dir['shop_id'] = $id;
        ShopDirectory::updateOrCreate($shop_dir);

        return redirect()->route('shops.all')->with(['status' => 'success', 'message' => 'Your SHOP was restore']);
    }

    public function force_delete($id)
    {
        $shop_owner = ShopOwner::onlyTrashed()->with('getPhotos')->findOrFail($id);

        if (File::exists('images/logo/' . $shop_owner->shop_logo)) {
            File::delete(public_path('images/logo/' . $shop_owner->shop_logo));
        }
        if (isset($shop_owner->getPhotos)) {
            $re_id = ShopBanner::where('shop_owner_id', $id)->onlyTrashed()->get();

            foreach ($re_id as $i) {
                if (File::exists('images/banner/' . $i->location)) {
                    File::delete(public_path('images/banner/' . $i->location));
                }
                ShopBanner::onlyTrashed()->findOrFail($i->id)->forceDelete();
            }
        }

        $this->shop_relevant_force_delete($id);

        ShopOwner::onlyTrashed()->findOrFail($id)->forceDelete();
        ShopDirectory::where('shop_id', $id)->delete();
        return redirect()->route('shops.all_trash')->with(['status' => 'success', 'message' => 'Your SHOP was Delete']);
    }

    public function shops_multiple_delete(Request $request)
    {

        $change_request_array = explode(",", $request->deleted_shops);
        foreach ($change_request_array as $id) {
            $shop_owner = ShopOwner::onlyTrashed()->with('getPhotos')->findOrFail($id);
            if (File::exists('images/logo/' . $shop_owner->shop_logo)) {
                File::delete(public_path('images/logo/' . $shop_owner->shop_logo));
            }
            if (isset($shop_owner->getPhotos)) {
                $re_id = ShopBanner::where('shop_owner_id', $id)->onlyTrashed()->get();

                foreach ($re_id as $i) {
                    if (File::exists('images/banner/' . $i->location)) {
                        File::delete(public_path('images/banner/' . $i->location));
                    }
                    ShopBanner::onlyTrashed()->findOrFail($i->id)->forceDelete();
                }
            }
            $this->shop_relevant_force_delete($id);

            ShopOwner::onlyTrashed()->findOrFail($id)->forceDelete();
        }
        return redirect()->route('shops.all_trash')->with(['status' => 'success', 'message' => 'Your SHOP was Delete']);
    }
}
