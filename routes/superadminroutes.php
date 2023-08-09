<?php
//for superadmin

use App\Http\Controllers\Auth\ShopownerRegisterController;
use App\Http\Controllers\Auth\SuperAdminForgotPasswordController;
use App\Http\Controllers\Auth\SuperadminLoginController;
use App\Http\Controllers\SuperAdmin\AdsController;
use App\Http\Controllers\SuperAdmin\AppFileController;
use App\Http\Controllers\SuperAdmin\CatController;
use App\Http\Controllers\SuperAdmin\CustomerController;
use App\Http\Controllers\SuperAdmin\DailyLogsController;
use App\Http\Controllers\SuperAdmin\DangerZoneController;
use App\Http\Controllers\SuperAdmin\DirectoryController;
use App\Http\Controllers\SuperAdmin\EventsController;
use App\Http\Controllers\SuperAdmin\FacebookDataController;
use App\Http\Controllers\SuperAdmin\ItemsController;
use App\Http\Controllers\SuperAdmin\NewsController;
use App\Http\Controllers\SuperAdmin\PromotionController;
use App\Http\Controllers\SuperAdmin\ShopController;
use App\Http\Controllers\SuperAdmin\SignController;
use App\Http\Controllers\SuperAdmin\SiteSettingController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\SuperAdmin\SuperAdminMessage;
use App\Http\Controllers\SuperAdmin\SuperAdminRoleController;
use App\Http\Controllers\SuperAdmin\SupportController;
use App\Http\Controllers\SuperAdmin\TooltipsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'backside/super_admin', 'as' => 'backside.super_admin.'], function () {

    //superadmin forgot password
    Route::middleware('guest')->group(function () {
        Route::get('/password/reset', [SuperAdminForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('/password/email', [SuperAdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('/password/reset/{token}', [SuperAdminForgotPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('/password/reset', [SuperAdminForgotPasswordController::class, 'reset'])->name('password.update');
    });

    //for facebook data
    Route::get('fbdata/messenger/list', [FacebookDataController::class, 'list']);
    Route::get('fbdata/messenger/getall', [FacebookDataController::class, 'get_all']);
    Route::post('fbdata/messenger/getcount', [FacebookDataController::class, 'get_count']);
    Route::post('fbdata/messenger/getmsglogcount', [FacebookDataController::class, 'get_msg_log_count']);
    Route::get('fbdata/messenger/log', [FacebookDataController::class, 'get_msg_log']);
    Route::get('fbdata/messenger/log/detail', [FacebookDataController::class, 'get_msg_log_detail']);
    Route::get('activity_logs/messenger/detail/{shopid}', [FacebookDataController::class, 'messenger_log_detail']);
    Route::get('activity_logs/messenger', [FacebookDataController::class, 'messenger_log'])->name('activity.messenger');

    Route::get('showdeletelogs', [DangerZoneController::class, 'show_delete_logs']);
    Route::post('deletelogs', [DangerZoneController::class, 'delete_logs']);

    Route::get('support/cat/create', [CatController::class, 'create_form']);
    Route::post('support/cat/create', [CatController::class, 'store']);
    Route::get('support/cat/list', [CatController::class, 'list']);
    Route::post('support/cat/delete', [CatController::class, 'delete']);
    Route::get('support/cat/edit/{id}', [CatController::class, 'edit']);
    Route::post('support/cat/edit/{id}', [CatController::class, 'update']);

    //Android and iOS web apps
    Route::resource('app-files', AppFileController::class)->except(['show', 'edit', 'update']);

    //help and support
    Route::get('support/create', [SupportController::class, 'create_form']);
    Route::post('support/create', [SupportController::class, 'store']);
    Route::get('support/list', [SupportController::class, 'list']);
    Route::get('support/all', [SupportController::class, 'all']);
    Route::get('support/detail/{id}', [SupportController::class, 'detail']);
    Route::post('support/delete/{id}', [SupportController::class, 'delete']);
    Route::get('support/edit/{id}', [SupportController::class, 'edit']);
    Route::post('support/update/{id}', [SupportController::class, 'update']);

    //help and support::clas's,'
    Route::get('tooltips/create', [TooltipsController::class, 'create_form']);
    Route::post('tooltips/create', [TooltipsController::class, 'store']);
    Route::get('tooltips/list', [TooltipsController::class, 'list']);
    Route::get('tooltips/all', [TooltipsController::class, 'all']);
    Route::get('tooltips/detail/{id}', [TooltipsController::class, 'detail']);
    Route::post('tooltips/delete/{id}', [TooltipsController::class, 'delete']);
    Route::get('tooltips/edit/{id}', [TooltipsController::class, 'edit']);
    Route::post('tooltips/update/{id}', [TooltipsController::class, 'update']);

    Route::post('all_counts', [SuperAdminController::class, 'all_counts']);

    Route::get('directory/create', [DirectoryController::class, 'create_form']);
    Route::post('directory/create', [DirectoryController::class, 'store']);
    Route::get('directory/alldirect', [DirectoryController::class, 'all_directory']);
    Route::get('directory/detail/{id}', [DirectoryController::class, 'detail']);
    Route::get('directory/edit/{id}', [DirectoryController::class, 'edit_form']);
    Route::post('directory/edit', [DirectoryController::class, 'update']);
    Route::post('directory/delete', [DirectoryController::class, 'delete']);
    Route::get('directory/all', [DirectoryController::class, 'all_table']);
    Route::get('directory/get_township', [DirectoryController::class, 'get_township']);
    Route::get('directory/check_shop_directory_name', [DirectoryController::class, 'check_shop_directory_name']);

    // Route::get('register', ['as' => 'register', 'uses' => 'Auth\SuperadminRegisterController@create']);
    Route::get('register', function () {
        return abort(404);
    });
    // Route::post('register', ['as' => 'registered', 'uses' => 'Auth\SuperadminRegisterController@store']);
    Route::put('approve/{id}', [SuperAdminController::class, 'approve']);
    Route::put('ban/{id}', [SuperAdminController::class, 'is_banned']);
    Route::post('delete', [SuperAdminController::class, 'delete']);
    //    auth
    Route::get('login', [SuperadminLoginController::class, 'loginform']);
    Route::post('login', [SuperadminLoginController::class, 'login'])->name('login');

    Route::post('logout', [SuperadminLoginController::class, 'logout']);
    Route::get('items/getitemsajax', [ItemsController::class, 'get_items_ajax']);
    Route::post('items/total_create_count', [ItemsController::class, 'total_create_count']);
    Route::get('items/all', [ItemsController::class, 'all']);

    Route::resources([
        '/' => SuperAdminController::class,
        '/ads' => AdsController::class,
        '/promotion' => PromotionController::class,
        '/news' => NewsController::class,
        '/events' => EventsController::class,
    ]);

    //for message
    Route::prefix('messages')->group(function () {
        Route::get('showexpire', [SuperAdminMessage::class, 'show_all_expire']);
        Route::get('getexpire', [SuperAdminMessage::class, 'get_expire']);
        Route::delete('deletebyone/{id}', [SuperAdminMessage::class, 'delete_by_one'])->name('delete');
        Route::post('deletemultiple', [SuperAdminMessage::class, 'delete_by_one']);
    });

    //gold price
    Route::get('gold_price', [SuperAdminController::class, 'gold_price_get'])->name('superAdmin.gold_price_get');
    Route::put('gold_price', [SuperAdminController::class, 'gold_price_update'])->name('superAdmin.gold_price_update');

    Route::get('get_all_ads', [AdsController::class, 'get_all_ads'])->name('ads.getAllAds');
    Route::get('get_ads_activity', [AdsController::class, 'get_ads_activity'])->name('ads.getAdsActivity');
    Route::post('ads_video', [AdsController::class, 'store_video'])->name('ads.video.create');

// zh for Shop
    Route::get('shops/all', [ShopController::class, 'all'])->name('shops.all');
    Route::get('shops/get_all_shops', [ShopController::class, 'get_all_shops'])->name('shops.getAllShops');

    Route::get('shops/create', [ShopownerRegisterController::class, 'create'])->name('shops.create');
    Route::get('shops/edit/{id}', [ShopownerRegisterController::class, 'edit'])->name('shops.edit');
    Route::put('shops/edit/{id}', [ShopownerRegisterController::class, 'update'])->name('shops.update');

// for website viewer
    Route::get('visitorcount/all', [SuperAdminController::class, 'visitor_count'])->name('visitorcount.all');
    Route::get('visitorcount/get_all_visitor', [SuperAdminController::class, 'get_all_visitor'])->name('visitorcount.getAllVisitor');

// for ads view
    Route::get('adscount/all', [SuperAdminController::class, 'ads_count'])->name('adscount.all');
    Route::get('adscount/get_all_adscount', [SuperAdminController::class, 'get_all_ads_count'])->name('adscount.getAllAdsCount');

// for shops viewer
    Route::get('shopviewercount/all', [SuperAdminController::class, 'shop_viewer_count'])->name('shopviewercount.all');
    Route::get('shopviewercount/get_all_shopviewercount', [SuperAdminController::class, 'getAllShopViewerCount'])->name('shopviewercount.getAllShopviewerCount');

// for buy now count
    Route::get('buynowcount/all', [SuperAdminController::class, 'buy_now_count'])->name('buynowcount.all');
    Route::get('buynowcount/get_all_buynowcount', [SuperAdminController::class, 'get_all_buy_now_count'])->name('buynowcount.getAllBuyNowCount');

// for add to cart count
    Route::get('addtocartcount/all', [SuperAdminController::class, 'add_to_cart_count'])->name('addtocartcount.all');
    Route::get('addtocartcount/get_all_addtocartcount', [SuperAdminController::class, 'get_all_add_to_cart_count'])->name('addtocartcount.getAllAddtocartCount');

// for wish list count
    Route::get('wishlistcount/all', [SuperAdminController::class, 'wishlist_count'])->name('wishlistcount.all');
    Route::get('wishlistcount/get_all_wishlistcount', [SuperAdminController::class, 'get_all_wishlist_count'])->name('wishlistcount.getAllWishlistCount');

// zh for dailycount
    Route::get('productdailycount/all', [SuperAdminController::class, 'product_daily_count'])->name('productdailycount.all');
    Route::delete('productdailycount/clear', [SuperAdminController::class, 'product_daily_count_clear'])->name('productdailycount.clear');
    Route::get('shopdailycount/all', [SuperAdminController::class, 'shop_daily_count'])->name('shopdailycount.all');
    Route::delete('shopdailycount/clear', [SuperAdminController::class, 'shop_daily_count_clear'])->name('shopdailycount.clear');
    Route::get('daily_shop_create_log', [DailyLogsController::class, 'daily_shop_create_log']);
    Route::post('daily_shop_create_delselected', [DailyLogsController::class, 'daily_shop_create_del_selected']);
    Route::post('daily_shop_create_delall', [DailyLogsController::class, 'daily_shop_create_del_all']);
    Route::post('total_create_count', [DailyLogsController::class, 'total_create_count']);

    Route::get('getalldailyshopcreatecounts', [DailyLogsController::class, 'get_all_daily_shop_create_counts']);

//shop delete section

    Route::delete('shops/delete/{id}', [ShopController::class, 'trash'])->name('shops.trash');
    Route::post('shops/multiple_delete/', [ShopController::class, 'shops_multiple_delete'])->name('shops.multiple_delete');
    Route::get('shops/trash', [ShopController::class, 'get_trash'])->name('shops.all_trash');
    Route::get('shops/get_all_trash_shop', [ShopController::class, 'get_all_trash_shop'])->name('shops.get_all_trash_shop');
    Route::post('shops/trash/{id}', [ShopController::class, 'restore'])->name('shops.restore');
    Route::delete('shops/forceDelete/{id}', [ShopController::class, 'force_delete'])->name('shops.force_delete');
//shop delete section end

//Shop Detail
    Route::get('shop_detail/{id}', [ShopController::class, 'show'])->name('shops.detail');
    Route::get('shop_update_action', [ShopController::class, 'counts_setting'])->name('shops.update_action');
    Route::get('shop_update_action_all', [ShopController::class, 'all_counts_setting'])->name('shops.update_action_all');
    Route::post('save_all_report', [ShopController::class, 'save_all_report'])->name('save_all_report');
    Route::get('download-zip', [ShopController::class, 'download_zip'])->name('report_zip');
    Route::get('all_monthly_report', [ShopController::class, 'all_report'])->name('shop.all_monthly_report');
    Route::get('monthly_report/{id}', [ShopController::class, 'report'])->name('shop.monthly_report');
    Route::post('date_filter', [ShopController::class, 'count_date_filter']);

    Route::get('shops/get_shop_activity', [ShopController::class, 'get_shop_activity'])->name('shops.getShopActivity');

// zh for super_admin_role
    Route::get('admins/all', [SuperAdminRoleController::class, 'list'])->name('super_admin_role.list');
    Route::get('admins/get_all_admins', [SuperAdminRoleController::class, 'get_all_admins'])->name('super_admin_role.getAllAdmins');
    Route::get('admins/get_admin_activity', [SuperAdminRoleController::class, 'get_admin_activity'])->name('super_admin_role.getAdminActivity');
    Route::get('admins/create', [SuperAdminRoleController::class, 'create'])->name('super_admin_role.create');
    Route::post('admins/create', [SuperAdminRoleController::class, 'store'])->name('super_admin_role.store');
    Route::get('admins/edit/{id}', [SuperAdminRoleController::class, 'edit'])->name('super_admin_role.edit');
    Route::put('admins/edit/{id}', [SuperAdminRoleController::class, 'update'])->name('super_admin_role.update');
    Route::delete('adminss/delete/{id}', [SuperAdminRoleController::class, 'delete'])->name('super_admin_role.delete');

// Sidebar Activities
    Route::get('daily_shop_create_log', [DailyLogsController::class, 'daily_shop_create_log']);
    Route::get('getalldailyshopcreatecounts', [DailyLogsController::class, 'get_all_daily_shop_create_counts']);

    Route::get('activity_logs/customers', [CustomerController::class, 'activity_index'])->name('activity.customer');
    Route::get('activity_logs/ads', [AdsController::class, 'activity_index'])->name('activity.ads');
    Route::get('activity_logs/shop', [ShopownerRegisterController::class, 'activity_index'])->name('activity.shop');
    Route::get('activity_logs/admin', [SuperAdminRoleController::class, 'activity_index'])->name('activity.admin');

// Customers
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('get_customers', [CustomerController::class, 'get_customers'])->name('customers.getCustomers');
    Route::get('get_customer_activity', [CustomerController::class, 'get_customer_activity'])->name('customers.getCustomerActivity');
//contact us
    Route::get('Contact-us/edit', [SuperAdminController::class, 'contact_us_get'])->name('superAdmin.contactus_get');
    Route::put('Contact-us/edit', [SuperAdminController::class, 'contact_us_update'])->name('superAdmin.contactus_update');

//site setting
    Route::get('sitesetting', [SiteSettingController::class, 'index'])->name('superadmin.sitesetting');
    Route::get('sitesetting/edit', [SiteSettingController::class, 'update_action'])->name('superadmin.update_action');

//shop_owner_using chat
    Route::get('shop_owner_using_chat', [ShopController::class, 'show_owner_using_chat']);
    Route::get('showowner_using_chat_detail/{id}', [ShopController::class, 'show_owner_using_chat_detail'])->name('showowner_using_chat_detail');
    Route::get('shopowner_chat_count_detail/{id}', [ShopController::class, 'shop_owner_chat_count_detail'])->name('shopowner_chat_count_detail');
    Route::get('shops/get_all_using_chat', [ShopController::class, 'show_owner_using_chat_all'])->name('shops.showowner_using_chat_all');
    Route::get('shops/product_code_search', [ShopController::class, 'shop_owner_chat_product_code_search'])->name('shops.shopowner_using_chat_search');
//for superadmin

//points
    Route::get('point', [CustomerController::class, 'point']);
    Route::post('point/update', [CustomerController::class, 'point_update']);

    Route::get('gold_points', [CustomerController::class, 'gold_point'])->name('gold_point');

    Route::post('gold_point/create', [CustomerController::class, 'gold_point_store']);

    Route::get('gold_points/edit/{id}', [CustomerController::class, 'gold_point_edit'])->name('gold_point.edit');
    Route::put('gold_points/update/{id}', [CustomerController::class, 'gold_point_update'])->name('gold_point.update');

// baydin
    Route::resource('baydins', SignController::class);

    Route::post('/delete_sign', [SignController::class, 'delete_sign'])->name('delete_sign');
});
