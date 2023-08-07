<?php
use App\Http\Controllers;


    //superadmin forgot password
    Route::get('/password/reset', [Auth\SuperAdminForgotPasswordController::class,'showLinkRequestForm'])->name('password.request');

    Route::post('/password/email', [Auth\SuperAdminForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');

    Route::get('/password/reset/{token}', [Auth\SuperAdminForgotPasswordController::class,'showResetForm'])->name('password.reset');

    Route::post('/password/reset', [Auth\SuperAdminForgotPasswordController::class,'reset'])->name('password.update');

    //for facebook data
    Route::get('fbdata/messenger/list', [super_admin\FbdataController::class,'list']);
    Route::get('fbdata/messenger/getall', [super_admin\FbdataController::class,'getall']);
    Route::post('fbdata/messenger/getcount', [super_admin\FbdataController::class,'getcount']);
    Route::post('fbdata/messenger/getmsglogcount', [super_admin\FbdataController::class,'getmsglogcount']);
    Route::get('fbdata/messenger/log', [super_admin\FbdataController::class,'getmsglog']);
    Route::get('fbdata/messenger/log/detail', [super_admin\FbdataController::class,'getmsglogdetail']);
    Route::get('activity_logs/messenger/detail/{shopid}', [super_admin\FbdataController::class,'messengerlogdetail']);
    Route::get('activity_logs/messenger', [super_admin\FbdataController::class,'messengerlog'])->name('activity.messenger');
    Route::get('showdeletelogs', [super_admin\DangerzoneController::class,'showdeletelogs']);
    Route::post('deletelogs', [super_admin\DangerzoneController::class,'deletelogs']);


    Route::get('support/cat/create', [super_admin\CatController::class,'createform']);
    Route::post('support/cat/create', [super_admin\CatController::class,'store']);
    Route::get('support/cat/list', [super_admin\CatController::class,'list']);
    Route::post('support/cat/delete', [super_admin\CatController::class,'delete']);
    Route::get('support/cat/edit/{id}', [super_admin\CatController::class,'edit']);
    Route::post('support/cat/edit/{id}', [super_admin\CatController::class,'update']);

    //Android and iOS web apps
    Route::resource('app-files', super_admin\AppFileController::class)->except(['show', 'edit', 'update']);

    //help and support
    Route::get('support/create', [super_admin\SupportController::class,'createform']);
    Route::post('support/create', [super_admin\SupportController::class,'store']);
    Route::get('support/list', [super_admin\SupportController::class,'list']);
    Route::get('support/all', [super_admin\SupportController::class,'all']);
    Route::get('support/detail/{id}', [super_admin\SupportController::class,'detail']);
    Route::post('support/delete/{id}', [super_admin\SupportController::class,'delete']);
    Route::get('support/edit/{id}', [super_admin\SupportController::class,'edit']);
    Route::post('support/update/{id}', [super_admin\SupportController::class,'update']);

    //help and support::clas's,'
    Route::get('tooltips/create', [super_admin\tooltipsController::class,'createform']);
    Route::post('tooltips/create', [super_admin\tooltipsController::class,'store']);
    Route::get('tooltips/list', [super_admin\tooltipsController::class,'list']);
    Route::get('tooltips/all', [super_admin\tooltipsController::class,'all']);
    Route::get('tooltips/detail/{id}', [super_admin\tooltipsController::class,'detail']);
    Route::post('tooltips/delete/{id}', [super_admin\tooltipsController::class,'delete']);
    Route::get('tooltips/edit/{id}',[super_admin\tooltipsController::class,'edit']);
    Route::post('tooltips/update/{id}', [super_admin\tooltipsController::class,'update']);

    Route::post('all_counts', [super_admin\SuperAdminController::class,'all_counts']);

    Route::get('directory/create', [super_admin\DirectoryController::class,'createform']);
    Route::post('directory/create', [super_admin\DirectoryController::class,'store']);
    Route::get('directory/alldirect', [super_admin\DirectoryController::class,'alldirectory']);
    Route::get('directory/detail/{id}', [super_admin\DirectoryController::class,'detail']);
    Route::get('directory/edit/{id}', [super_admin\DirectoryController::class,'editform']);
    Route::post('directory/edit', [super_admin\DirectoryController::class,'update']);
    Route::post('directory/delete', [super_admin\DirectoryController::class,'delete']);
    Route::get('directory/all', [super_admin\DirectoryController::class,'alltable']);
    Route::get('directory/get_township', [super_admin\DirectoryController::class,'gettownship']);
    Route::get('directory/check_shop_directory_name', [super_admin\DirectoryController::class,'check_shop_directory_name']);

    // Route::get('register', ['as' => 'register', 'uses' => 'Auth\SuperadminRegisterController@create']);
    Route::get('register', function () {
        return abort(404);
    });
    // Route::post('register', ['as' => 'registered', 'uses' => 'Auth\SuperadminRegisterController@store']);
    Route::put('approve/{id}', [super_admin\SuperAdminController::class,'approve']);
    Route::put('ban/{id}',  [super_admin\SuperAdminController::class,'isBanned']);
    Route::post('delete',  [super_admin\SuperAdminController::class,'delete']);
    //    auth
    Route::get('login',[Auth\SuperadminLoginController::class,'loginform']);
    Route::post('login', [Auth\SuperadminLoginController::class,'login']);

    Route::post('logout',  [Auth\SuperadminLoginController::class,'logout']);
    Route::get('items/getitemsajax', [super_admin\ItemsController::class,'getitemsajax']);
    Route::post('items/total_create_count', [super_admin\ItemsController::class,'total_create_count']);
    Route::get('items/all', [super_admin\ItemsController::class,'all']);

    Route::resources([
        '/' => super_admin\SuperAdminController::class,
        '/ads' => super_admin\AdsController::class,
        '/promotion' => super_admin\PromotionController::class,
        '/news' => super_admin\NewsController::class,
        '/events' => super_admin\EventsController::class,
    ]);

    //for message
    Route::prefix('messages')->group(function () {
        Route::get('showexpire', [super_admin\SuperadminMessage::class,'showallexpire']);
        Route::get('getexpire', [super_admin\SuperadminMessage::class,'getexpire']);
        Route::delete('deletebyone/{id}', [super_admin\SuperadminMessage::class,'deletebyone'])->name('delete');
        Route::post('deletemultiple', [super_admin\SuperadminMessage::class,'deletebyone']);
    });

//gold price
Route::get('backside/super_admin/gold_price', [super_admin\SuperAdminController::class,'gold_price_get'])->name('superAdmin.gold_price_get');
Route::put('backside/super_admin/gold_price', [super_admin\SuperAdminController::class,'gold_price_update'])->name('superAdmin.gold_price_update');

Route::get('backside/super_admin/get_all_ads', [super_admin\AdsController::class,'getAllAds'])->name('ads.getAllAds');
Route::get('backside/super_admin/get_ads_activity', [super_admin\AdsController::class,'getAdsActivity'])->name('ads.getAdsActivity');
Route::post('backside/super_admin/ads_video', [super_admin\AdsController::class,'store_video'])->name('ads.video.create');

// zh for Shop
Route::get('backside/super_admin/shops/all', [super_admin\ShopController::class,'all'])->name('shops.all');
Route::get('backside/super_admin/shops/get_all_shops', [super_admin\ShopController::class,'getAllShops'])->name('shops.getAllShops');

Route::get('backside/super_admin/shops/create', [Auth\ShopownerRegisterController::class,'create'])->name('shops.create');
Route::get('backside/super_admin/shops/edit/{id}', [Auth\ShopownerRegisterController::class,'edit'])->name('shops.edit');
Route::put('backside/super_admin/shops/edit/{id}', [Auth\ShopownerRegisterController::class,'update'])->name('shops.update');

// for website viewer
Route::get('backside/super_admin/visitorcount/all', [super_admin\SuperAdminController::class,'visitorcount'])->name('visitorcount.all');
Route::get('backside/super_admin/visitorcount/get_all_visitor', [super_admin\SuperAdminController::class,'getAllVisitor'])->name('visitorcount.getAllVisitor');

// for ads view
Route::get('backside/super_admin/adscount/all', [super_admin\SuperAdminController::class,'adscount'])->name('adscount.all');
Route::get('backside/super_admin/adscount/get_all_adscount', [super_admin\SuperAdminController::class,'getAllAdsCount'])->name('adscount.getAllAdsCount');

// for shops viewer
Route::get('backside/super_admin/shopviewercount/all', [super_admin\SuperAdminController::class,'shopviewercount'])->name('shopviewercount.all');
Route::get('backside/super_admin/shopviewercount/get_all_shopviewercount', [super_admin\SuperAdminController::class,'getAllShopviewerCount'])->name('shopviewercount.getAllShopviewerCount');

// for buy now count
Route::get('backside/super_admin/buynowcount/all', [super_admin\SuperAdminController::class,'buynowcount'])->name('buynowcount.all');
Route::get('backside/super_admin/buynowcount/get_all_buynowcount', [super_admin\SuperAdminController::class,'getAllBuyNowCount'])->name('buynowcount.getAllBuyNowCount');

// for add to cart count
Route::get('backside/super_admin/addtocartcount/all', [super_admin\SuperAdminController::class,'addtocartcount'])->name('addtocartcount.all');
Route::get('backside/super_admin/addtocartcount/get_all_addtocartcount', [super_admin\SuperAdminController::class,'getAllAddtocartCount'])->name('addtocartcount.getAllAddtocartCount');

// for wish list count
Route::get('backside/super_admin/wishlistcount/all', [super_admin\SuperAdminController::class,'wishlistcount'])->name('wishlistcount.all');
Route::get('backside/super_admin/wishlistcount/get_all_wishlistcount', [super_admin\SuperAdminController::class,'getAllWishlistCount'])->name('wishlistcount.getAllWishlistCount');

// zh for dailycount
Route::get('backside/super_admin/productdailycount/all', [super_admin\SuperAdminController::class,'productdailycount'])->name('productdailycount.all');
Route::delete('backside/super_admin/productdailycount/clear', [super_admin\SuperAdminController::class,'productdailycount_clear'])->name('productdailycount.clear');
Route::get('backside/super_admin/shopdailycount/all', [super_admin\SuperAdminController::class,'shopdailycount'])->name('shopdailycount.all');
Route::delete('backside/super_admin/shopdailycount/clear', [super_admin\SuperAdminController::class,'shopdailycount_clear'])->name('shopdailycount.clear');
Route::get('backside/super_admin/daily_shop_create_log', [super_admin\DailyLogsController::class,'daily_shop_create_log']);
Route::post('backside/super_admin/daily_shop_create_delselected', [super_admin\DailyLogsController::class,'daily_shop_create_delselected']);
Route::post('backside/super_admin/daily_shop_create_delall', [super_admin\DailyLogsController::class,'daily_shop_create_delall']);
Route::post('backside/super_admin/total_create_count', [super_admin\DailyLogsController::class,'total_create_count']);

Route::get('backside/super_admin/getalldailyshopcreatecounts', [super_admin\DailyLogsController::class,'getalldailyshopcreatecounts']);

//shop delete section

Route::delete('backside/super_admin/shops/delete/{id}', [super_admin\ShopController::class,'trash'])->name('shops.trash');
Route::post('backside/super_admin/shops/multiple_delete/', [super_admin\ShopController::class,'shops_multiple_delete'])->name('shops.multiple_delete');
Route::get('backside/super_admin/shops/trash', [super_admin\ShopController::class,'get_trash'])->name('shops.all_trash');
Route::get('backside/super_admin/shops/get_all_trash_shop', [super_admin\ShopController::class,'get_all_trash_shop'])->name('shops.get_all_trash_shop');
Route::post('backside/super_admin/shops/trash/{id}', [super_admin\ShopController::class,'restore'])->name('shops.restore');
Route::delete('backside/super_admin/shops/forceDelete/{id}', [super_admin\ShopController::class,'force_delete'])->name('shops.force_delete');
//shop delete section end

//Shop Detail
Route::get('backside/super_admin/shop_detail/{id}', [super_admin\ShopController::class,'show'])->name('shops.detail');
Route::get('backside/super_admin/shop_update_action', [super_admin\ShopController::class,'counts_setting'])->name('shops.update_action');
Route::get('backside/super_admin/shop_update_action_all', [super_admin\ShopController::class,'all_counts_setting'])->name('shops.update_action_all');
Route::post('backside/super_admin/save_all_report', [super_admin\ShopController::class,'save_all_report'])->name('save_all_report');
Route::get('backside/super_admin/download-zip', [super_admin\ShopController::class,'downloadZip'])->name('report_zip');
Route::get('backside/super_admin/all_monthly_report', [super_admin\ShopController::class,'all_report'])->name('shop.all_monthly_report');
Route::get('backside/super_admin/monthly_report/{id}', [super_admin\ShopController::class,'report'])->name('shop.monthly_report');
Route::post('backside/super_admin/date_filter', [super_admin\ShopController::class,'count_date_filter']);

Route::get('backside/super_admin/shops/get_shop_activity', [super_admin\ShopController::class,'getShopActivity'])->name('shops.getShopActivity');

// zh for super_admin_role
Route::get('backside/super_admin/admins/all', [super_admin\Super_admin_roleController::class,'list'])->name('super_admin_role.list');
Route::get('backside/super_admin/admins/get_all_admins', [super_admin\Super_admin_roleController::class,'getAllAdmins'])->name('super_admin_role.getAllAdmins');
Route::get('backside/super_admin/admins/get_admin_activity', [super_admin\Super_admin_roleController::class,'etAdminActivity'])->name('super_admin_role.getAdminActivity');
Route::get('backside/super_admin/admins/create', [super_admin\Super_admin_roleController::class,'create'])->name('super_admin_role.create');
Route::post('backside/super_admin/admins/create', [super_admin\Super_admin_roleController::class,'store'])->name('super_admin_role.store');
Route::get('backside/super_admin/admins/edit/{id}', [super_admin\Super_admin_roleController::class,'edit'])->name('super_admin_role.edit');
Route::put('backside/super_admin/admins/edit/{id}', [super_admin\Super_admin_roleController::class,'update'])->name('super_admin_role.update');
Route::delete('backside/super_admin/adminss/delete/{id}', [super_admin\Super_admin_roleController::class,'delete'])->name('super_admin_role.delete');

// Sidebar Activities
Route::get('backside/super_admin/daily_shop_create_log', [super_admin\DailyLogsController::class,'daily_shop_create_log']);
Route::get('backside/super_admin/getalldailyshopcreatecounts', [super_admin\DailyLogsController::class,'getalldailyshopcreatecounts']);

Route::get('backside/super_admin/activity_logs/customers', [super_admin\CustomerController::class,'activity_index'])->name('activity.customer');
Route::get('backside/super_admin/activity_logs/ads', [super_admin\AdsController::class,'activity_index'])->name('activity.ads');
Route::get('backside/super_admin/activity_logs/shop', [Auth\ShopownerRegisterController::class,'activity_index'])->name('activity.shop');
Route::get('backside/super_admin/activity_logs/admin', [super_admin\Super_admin_roleController::class,'activity_index'])->name('activity.admin');

// Customers
Route::get('backside/super_admin/customers', [super_admin\CustomerController::class,'index'])->name('customers.index');
Route::get('backside/super_admin/get_customers', [super_admin\CustomerController::class,'getCustomers'])->name('customers.getCustomers');
Route::get('backside/super_admin/get_customer_activity', [super_admin\CustomerController::class,'getCustomerActivity'])->name('customers.getCustomerActivity');
//contact us
Route::get('backside/super_admin/Contact-us/edit', [super_admin\SuperAdminController::class,'contactus_get'])->name('superAdmin.contactus_get');
Route::put('backside/super_admin/Contact-us/edit', [super_admin\SuperAdminController::class,'contactus_update'])->name('superAdmin.contactus_update');

//site setting
Route::get('backside/super_admin/sitesetting', [super_admin\SiteSettingController::class,'index'])->name('superadmin.sitesetting');
Route::get('backside/super_admin/sitesetting/edit', [super_admin\SiteSettingController::class,'updateAction'])->name('superadmin.update_action');

//shop_owner_using chat
Route::get('backside/super_admin/shop_owner_using_chat', [super_admin\ShopController::class,'showowner_using_chat']);
Route::get('backside/super_admin/showowner_using_chat_detail/{id}', [super_admin\ShopController::class,'showowner_using_chat_detail'])->name('showowner_using_chat_detail');
Route::get('backside/super_admin/shopowner_chat_count_detail/{id}', [super_admin\ShopController::class,'shopowner_chat_count_detail'])->name('shopowner_chat_count_detail');
Route::get('backside/super_admin/shops/get_all_using_chat', [super_admin\ShopController::class,'showowner_using_chat_all'])->name('shops.showowner_using_chat_all');
Route::get('backside/super_admin/shops/product_code_search', [super_admin\ShopController::class,'shopowner_chat_product_code_search'])->name('shops.shopowner_using_chat_search');
//for superadmin

//points
Route::get('backside/super_admin/point', [super_admin\CustomerController::class,'point']);
Route::post('backside/super_admin/point/update', [super_admin\CustomerController::class,'point_update']);

Route::get('backside/super_admin/gold_points', [super_admin\CustomerController::class,'gold_point'])->name('gold_point');

Route::post('backside/super_admin/gold_point/create', [super_admin\CustomerController::class,'gold_point_store']);

Route::get('backside/super_admin/gold_points/edit/{id}', [super_admin\CustomerController::class,'gold_point_edit'])->name('gold_point.edit');
Route::put('backside/super_admin/gold_points/update/{id}', [super_admin\CustomerController::class,'gold_point_update'])->name('gold_point.update');

// baydin
Route::resource('baydins', super_admin\SignController::class);

Route::post('/delete_sign', [super_admin\SignController::class,'delete_sign'])->name('delete_sign');