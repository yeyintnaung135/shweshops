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
    Route::put('ban/{id}', [SuperAdminController::class, 'isBanned']);
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
});
//gold price
Route::get('backside/super_admin/gold_price', [SuperAdminController::class, 'gold_price_get'])->name('superAdmin.gold_price_get');
Route::put('backside/super_admin/gold_price', [SuperAdminController::class, 'gold_price_update'])->name('superAdmin.gold_price_update');

Route::get('backside/super_admin/get_all_ads', [AdsController::class, 'getAllAds'])->name('ads.getAllAds');
Route::get('backside/super_admin/get_ads_activity', [AdsController::class, 'getAdsActivity'])->name('ads.getAdsActivity');
Route::post('backside/super_admin/ads_video', [AdsController::class, 'store_video'])->name('ads.video.create');

// zh for Shop
Route::get('backside/super_admin/shops/all', [ShopController::class, 'all'])->name('shops.all');
Route::get('backside/super_admin/shops/get_all_shops', [ShopController::class, 'getAllShops'])->name('shops.getAllShops');

Route::get('backside/super_admin/shops/create', [ShopownerRegisterController::class, 'create'])->name('shops.create');
Route::get('backside/super_admin/shops/edit/{id}', [ShopownerRegisterController::class, 'edit'])->name('shops.edit');
Route::put('backside/super_admin/shops/edit/{id}', [ShopownerRegisterController::class, 'update'])->name('shops.update');

// for website viewer
Route::get('backside/super_admin/visitorcount/all', [SuperAdminController::class, 'visitor_count'])->name('visitorcount.all');
Route::get('backside/super_admin/visitorcount/get_all_visitor', [SuperAdminController::class, 'getAllVisitor'])->name('visitorcount.getAllVisitor');

// for ads view
Route::get('backside/super_admin/adscount/all', [SuperAdminController::class, 'ads_count'])->name('adscount.all');
Route::get('backside/super_admin/adscount/get_all_adscount', [SuperAdminController::class, 'getAllAdsCount'])->name('adscount.getAllAdsCount');

// for shops viewer
Route::get('backside/super_admin/shopviewercount/all', [SuperAdminController::class, 'shop_viewer_count'])->name('shopviewercount.all');
Route::get('backside/super_admin/shopviewercount/get_all_shopviewercount', [SuperAdminController::class, 'getAllShopViewerCount'])->name('shopviewercount.getAllShopviewerCount');

// for buy now count
Route::get('backside/super_admin/buynowcount/all', [SuperAdminController::class, 'buy_now_count'])->name('buynowcount.all');
Route::get('backside/super_admin/buynowcount/get_all_buynowcount', [SuperAdminController::class, 'getAllBuyNowCount'])->name('buynowcount.getAllBuyNowCount');

// for add to cart count
Route::get('backside/super_admin/addtocartcount/all', [SuperAdminController::class, 'add_to_cart_count'])->name('addtocartcount.all');
Route::get('backside/super_admin/addtocartcount/get_all_addtocartcount', [SuperAdminController::class, 'getAllAddToCartCount'])->name('addtocartcount.getAllAddtocartCount');

// for wish list count
Route::get('backside/super_admin/wishlistcount/all', [SuperAdminController::class, 'wishlist_count'])->name('wishlistcount.all');
Route::get('backside/super_admin/wishlistcount/get_all_wishlistcount', [SuperAdminController::class, 'getAllWishlistCount'])->name('wishlistcount.getAllWishlistCount');

// zh for dailycount
Route::get('backside/super_admin/productdailycount/all', [SuperAdminController::class, 'product_daily_count'])->name('productdailycount.all');
Route::delete('backside/super_admin/productdailycount/clear', [SuperAdminController::class, 'product_daily_count_clear'])->name('productdailycount.clear');
Route::get('backside/super_admin/shopdailycount/all', [SuperAdminController::class, 'shop_daily_count'])->name('shopdailycount.all');
Route::delete('backside/super_admin/shopdailycount/clear', [SuperAdminController::class, 'shop_daily_count_clear'])->name('shopdailycount.clear');
Route::get('backside/super_admin/daily_shop_create_log', [DailyLogsController::class, 'daily_shop_create_log']);
Route::post('backside/super_admin/daily_shop_create_delselected', [DailyLogsController::class, 'daily_shop_create_del_selected']);
Route::post('backside/super_admin/daily_shop_create_delall', [DailyLogsController::class, 'daily_shop_create_del_all']);
Route::post('backside/super_admin/total_create_count', [DailyLogsController::class, 'total_create_count']);

Route::get('backside/super_admin/getalldailyshopcreatecounts', [DailyLogsController::class, 'get_all_daily_shop_create_counts']);

//shop delete section

Route::delete('backside/super_admin/shops/delete/{id}', [ShopController::class, 'trash'])->name('shops.trash');
Route::post('backside/super_admin/shops/multiple_delete/', [ShopController::class, 'shops_multiple_delete'])->name('shops.multiple_delete');
Route::get('backside/super_admin/shops/trash', [ShopController::class, 'get_trash'])->name('shops.all_trash');
Route::get('backside/super_admin/shops/get_all_trash_shop', [ShopController::class, 'get_all_trash_shop'])->name('shops.get_all_trash_shop');
Route::post('backside/super_admin/shops/trash/{id}', [ShopController::class, 'restore'])->name('shops.restore');
Route::delete('backside/super_admin/shops/forceDelete/{id}', [ShopController::class, 'force_delete'])->name('shops.force_delete');
//shop delete section end

//Shop Detail
Route::get('backside/super_admin/shop_detail/{id}', [ShopController::class, 'show'])->name('shops.detail');
Route::get('backside/super_admin/shop_update_action', [ShopController::class, 'counts_setting'])->name('shops.update_action');
Route::get('backside/super_admin/shop_update_action_all', [ShopController::class, 'all_counts_setting'])->name('shops.update_action_all');
Route::post('backside/super_admin/save_all_report', [ShopController::class, 'save_all_report'])->name('save_all_report');
Route::get('backside/super_admin/download-zip', [ShopController::class, 'downloadZip'])->name('report_zip');
Route::get('backside/super_admin/all_monthly_report', [ShopController::class, 'all_report'])->name('shop.all_monthly_report');
Route::get('backside/super_admin/monthly_report/{id}', [ShopController::class, 'report'])->name('shop.monthly_report');
Route::post('backside/super_admin/date_filter', [ShopController::class, 'count_date_filter']);

Route::get('backside/super_admin/shops/get_shop_activity', [ShopController::class, 'getShopActivity'])->name('shops.getShopActivity');

// zh for super_admin_role
Route::get('backside/super_admin/admins/all', [SuperAdminRoleController::class, 'list'])->name('super_admin_role.list');
Route::get('backside/super_admin/admins/get_all_admins', [SuperAdminRoleController::class, 'getAllAdmins'])->name('super_admin_role.getAllAdmins');
Route::get('backside/super_admin/admins/get_admin_activity', [SuperAdminRoleController::class, 'etAdminActivity'])->name('super_admin_role.getAdminActivity');
Route::get('backside/super_admin/admins/create', [SuperAdminRoleController::class, 'create'])->name('super_admin_role.create');
Route::post('backside/super_admin/admins/create', [SuperAdminRoleController::class, 'store'])->name('super_admin_role.store');
Route::get('backside/super_admin/admins/edit/{id}', [SuperAdminRoleController::class, 'edit'])->name('super_admin_role.edit');
Route::put('backside/super_admin/admins/edit/{id}', [SuperAdminRoleController::class, 'update'])->name('super_admin_role.update');
Route::delete('backside/super_admin/adminss/delete/{id}', [SuperAdminRoleController::class, 'delete'])->name('super_admin_role.delete');

// Sidebar Activities
Route::get('backside/super_admin/daily_shop_create_log', [DailyLogsController::class, 'daily_shop_create_log']);
Route::get('backside/super_admin/getalldailyshopcreatecounts', [DailyLogsController::class, 'get_all_daily_shop_create_counts']);

Route::get('backside/super_admin/activity_logs/customers', [CustomerController::class, 'activity_index'])->name('activity.customer');
Route::get('backside/super_admin/activity_logs/ads', [AdsController::class, 'activity_index'])->name('activity.ads');
Route::get('backside/super_admin/activity_logs/shop', [ShopownerRegisterController::class, 'activity_index'])->name('activity.shop');
Route::get('backside/super_admin/activity_logs/admin', [SuperAdminRoleController::class, 'activity_index'])->name('activity.admin');

// Customers
Route::get('backside/super_admin/customers', [CustomerController::class, 'index'])->name('customers.index');
Route::get('backside/super_admin/get_customers', [CustomerController::class, 'getCustomers'])->name('customers.getCustomers');
Route::get('backside/super_admin/get_customer_activity', [CustomerController::class, 'getCustomerActivity'])->name('customers.getCustomerActivity');
//contact us
Route::get('backside/super_admin/Contact-us/edit', [SuperAdminController::class, 'contact_us_get'])->name('superAdmin.contactus_get');
Route::put('backside/super_admin/Contact-us/edit', [SuperAdminController::class, 'contact_us_update'])->name('superAdmin.contactus_update');

//site setting
Route::get('backside/super_admin/sitesetting', [SiteSettingController::class, 'index'])->name('superadmin.sitesetting');
Route::get('backside/super_admin/sitesetting/edit', [SiteSettingController::class, 'updateAction'])->name('superadmin.update_action');

//shop_owner_using chat
Route::get('backside/super_admin/shop_owner_using_chat', [ShopController::class, 'show_owner_using_chat']);
Route::get('backside/super_admin/showowner_using_chat_detail/{id}', [ShopController::class, 'show_owner_using_chat_detail'])->name('showowner_using_chat_detail');
Route::get('backside/super_admin/shopowner_chat_count_detail/{id}', [ShopController::class, 'shop_owner_chat_count_detail'])->name('shopowner_chat_count_detail');
Route::get('backside/super_admin/shops/get_all_using_chat', [ShopController::class, 'show_owner_using_chat_all'])->name('shops.showowner_using_chat_all');
Route::get('backside/super_admin/shops/product_code_search', [ShopController::class, 'shop_owner_chat_product_code_search'])->name('shops.shopowner_using_chat_search');
//for superadmin

//points
Route::get('backside/super_admin/point', [CustomerController::class, 'point']);
Route::post('backside/super_admin/point/update', [CustomerController::class, 'point_update']);

Route::get('backside/super_admin/gold_points', [CustomerController::class, 'gold_point'])->name('gold_point');

Route::post('backside/super_admin/gold_point/create', [CustomerController::class, 'gold_point_store']);

Route::get('backside/super_admin/gold_points/edit/{id}', [CustomerController::class, 'gold_point_edit'])->name('gold_point.edit');
Route::put('backside/super_admin/gold_points/update/{id}', [CustomerController::class, 'gold_point_update'])->name('gold_point.update');

// baydin
Route::resource('baydins', SignController::class);

Route::post('/delete_sign', [SignController::class, 'delete_sign'])->name('delete_sign');
