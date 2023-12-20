<?php

use App\Http\Controllers\Auth\ShopOwnerLoginController;
use App\Http\Controllers\Auth\ShopownerRegisterController;
use App\Http\Controllers\Auth\YkforgotpasswordController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\message\MessageController;
use App\Http\Controllers\message\UsermessageController;
use App\Http\Controllers\ShopOwner\CollectionController;
use App\Http\Controllers\ShopOwner\DiscountController;
use App\Http\Controllers\ShopOwner\EventController;
use App\Http\Controllers\ShopOwner\ItemsController;
use App\Http\Controllers\ShopOwner\ManagerController;
use App\Http\Controllers\ShopOwner\NewsController;
use App\Http\Controllers\ShopOwner\OpeningTimesController;
use App\Http\Controllers\ShopOwner\PopupAdsController;
use App\Http\Controllers\ShopOwner\ShopOwnerController;
use App\Http\Controllers\ShopOwner\ShopOwnerSupportController;
use App\Http\Controllers\ShopOwner\TemplateController;
use App\Http\Controllers\UpdatePasswordController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'backside/shop_owner', 'as' => 'backside.shop_owner.'], function () {

    // Authentication Routes
    // Route::get('register', [ShopownerRegisterController::class, 'create'])->name('register');
    // Route::middleware(['guest:shop_owners_and_staffs'])->group(function () {
    Route::post('register', [ShopownerRegisterController::class, 'store'])->name('registered');

    Route::get('/login/{from?}', [ShopOwnerLoginController::class, 'loginform'])->name('login');
    Route::post('login', [ShopOwnerLoginController::class, 'login'])->name('login.post');

    //shop owner order lists routes by wlk
    Route::get('orders', [ShopOwnerController::class, 'orderList'])->name('orders');
    Route::get('orders/detail/{id}', [ShopOwnerController::class, 'orderDetail'])->name('orderDetail');
    Route::get('get_orders', [ShopOwnerController::class, 'get_orders']);
    //shop owner routes

    // POS login & register form
    // Route::get('/pos/login', [ShopOwnerLoginController::class, 'pos_login_form'])->name('pos.login');
    // Route::post('/pos/login', [ShopOwnerLoginController::class, 'pos_login'])->name('pos_logined');
    // });

    Route::middleware(['auth:shop_owners_and_staffs'])->group(function () {

        // Update only price
        Route::post('/price_only_update', [ItemsController::class, 'only_price_update'])->name('price_only_update');

        //forgot password owner
        Route::get('pos/forgot_password', [YkforgotpasswordController::class, 'showLinkRequestForm'])->name('forgot_password');
        Route::post('forgot_password', [YkforgotpasswordController::class, 'send_reset_code_form'])->name('send_reset_code');
        Route::put('forgot_password', [YkforgotpasswordController::class, 'codeCheck'])->name('send_reset_code');
        Route::post('add_new_password', [YkforgotpasswordController::class, 'add_new_password'])->name('add_new_password');

        //reg ph confirmation
        Route::get('/support', [ShopOwnerSupportController::class, 'index'])->name('support');
        Route::post('/get_support_by_cat', [ShopOwnerSupportController::class, 'get_support_by_cat']);
        Route::post('/get_support', [ShopOwnerSupportController::class, 'get_support']);
        Route::resource('/', ShopOwnerController::class);
        Route::resource('items', ItemsController::class);

        Route::get('/get_item_activity_log', [ItemsController::class, 'get_item_activity_log'])->name('items.getitems_activity_log');
        Route::get('/unique_get_item_activity_log', [ShopOwnerController::class, 'unique_get_item_activity_log'])->name('items.uniquegetitems_activity_log');
        Route::get('/get_multiple_price_activity_log', [ItemsController::class, 'get_multiple_price_activity_log'])->name('items.getmultiple_price_activity_log');
        Route::get('/get_multiple_discount_activity_log', [ItemsController::class, 'get_multiple_discount_activity_log'])->name('items.getmultiple_discount_activity_log');
        Route::get('/get_multiple_damage_activity_log', [ItemsController::class, 'get_multiple_damage_activity_log'])->name('items.getmultiple_damage_activity_log');
        Route::get('/get_items', [ItemsController::class, 'get_items'])->name('items.getItems');
        Route::post('/getproductcodebytyping', [ItemsController::class, 'get_product_code_by_typing']);

        Route::get('/items_trash', [ItemsController::class, 'trash'])->name('items.trash');
        Route::get('/get_items_trash', [ItemsController::class, 'get_items_trash']);
        Route::get('/items_trash/{id}', [ItemsController::class, 'restore'])->name('items.restore');
        Route::delete('/items_trash_delete/{id}', [ItemsController::class, 'force_delete'])->name('items.forcedelete');

        Route::post('/multipe_discount', [DiscountController::class, 'multiple_discount'])->name('items.multiple.discount');
        Route::post('/multipe_unset_discount', [DiscountController::class, 'multiple_unset_discount']);
        Route::post('/multiple/plus', [ItemsController::class, 'multiple_update_plus'])->name('multiple_items.update_plus');
        Route::post('/multiple/minus', [ItemsController::class, 'multiple_update_minus'])->name('multiple_items.update_minus');
        Route::post('/multiple/recap', [ItemsController::class, 'multiple_update_recap'])->name('multiple_items.update_recap');
        Route::post('/multiple/stock', [ItemsController::class, 'multiple_stock'])->name('multiple.stock.items');
        Route::post('/multiple/checkpriceafterupdateclick', [ItemsController::class, 'check_price_after_update_click'])->name('multiple_items.checkpriceafterupdateclick');
        Route::post('/multiple/checkpriceafterdiscountclick', [DiscountController::class, 'check_price_after_discount_click'])->name('multiple_items.checkpriceafterdiscountclick');

        //template
        Route::get('/template/create', [TemplateController::class, 'create'])->name('items.template.create');
        Route::get('/template/get_template', [TemplateController::class, 'get_template'])->name('template.get_template');
        Route::get('/templates', [TemplateController::class, 'index'])->name('items.template.list');
        Route::post('/template/create', [TemplateController::class, 'store'])->name('items.template.store');
        Route::get('/templates/edit/{id}', [TemplateController::class, 'edit'])->name('template.edit');
        Route::patch('/templates/update/{id}', [TemplateController::class, 'update'])->name('items.template.update');
        Route::get('/templates/trash/{id}', [TemplateController::class, 'destroy'])->name('template.destroy');

        // manager
        Route::get('/users', [ManagerController::class, 'list']);

        // for user datable
        Route::get('/get_users_activity_log', [ManagerController::class, 'get_users_activity_log'])->name('users.getusers_activity_Log');
        Route::get('/get_backrole', [ManagerController::class, 'get_back_role_activity'])->name('getbackrole');
        Route::get('/get_backrole/detail', [ManagerController::class, 'get_back_role_activity_detail'])->name('getbackrole.detail');
        Route::get('/get_itemedit/detail', [ManagerController::class, 'get_item_edit_activity_detail'])->name('getitemedit.detail');
        Route::get('/get_backroleedit/{id}', [ManagerController::class, 'back_role_edit_detail'])->name('backroleedit');
        Route::get('/get_users', [ManagerController::class, 'get_users'])->name('getUsers');
        Route::get('/users/create', [ManagerController::class, 'create']);
        Route::post('/users/create', [ManagerController::class, 'store']);
        Route::get('/users/edit/{id}', [ManagerController::class, 'edit'])->name('managers.edit');
        Route::put('/users/edit/{id}', [ManagerController::class, 'update'])->name('managers.update');
        Route::get('/users/detail/{id}', [ManagerController::class, 'detail'])->name('managers.detail');
        Route::delete('/users/remove_user/{id}', [ManagerController::class, 'remove_user'])->name('managers.remove_user');
        Route::get('/users/trash', [ManagerController::class, 'trash'])->name('managers.restore_list');
        Route::get('/users/restore/{id}', [ManagerController::class, 'restore'])->name('managers.restore');

        Route::get('/detail', [ShopOwnerController::class, 'detail'])->name('detail');
        Route::get('/detail/shop_view', [ShopOwnerController::class, 'shop_view'])->name('detail.shop_view');
        Route::get('/detail/product_view', [ShopOwnerController::class, 'product_view'])->name('detail.product_view');
        Route::get('/detail/buy_now_click', [ShopOwnerController::class, 'buy_now_click'])->name('detail.buy_now_click');
        Route::get('/detail/unique_add_to_cart_click', [ShopOwnerController::class, 'unique_add_to_cart_click'])->name('detail.unique_add_to_cart_click');
        Route::get('/detail/unique_whishlist_click', [ShopOwnerController::class, 'unique_whish_list_click'])->name('detail.unique_whishlist_click');
        Route::get('/detail/unique_ads_view', [ShopOwnerController::class, 'unique_ads_view'])->name('detail.unique_ads_view');
        Route::get('/detail/unique_product_view', [ShopOwnerController::class, 'unique_product_view'])->name('detail.unique_product_view');
        Route::get('/detail/product_discount_view', [ShopOwnerController::class, 'discount_product_view'])->name('detail.product_discount_view');
        Route::get('/detail/get_shop_view', [ShopOwnerController::class, 'get_shop_owner_view'])->name('detail.get_shop_view');
        Route::get('/detail/get_buy_now_click', [ShopOwnerController::class, 'get_buy_now_click'])->name('detail.get_buy_now_click');
        Route::get('/detail/get_unique_add_to_cart_click', [ShopOwnerController::class, 'get_unique_add_to_cart_click'])->name('detail.get_unique_add_to_cart_click');
        Route::get('/detail/get_unique_wishlist_click', [ShopOwnerController::class, 'get_unique_whish_list_click'])->name('detail.get_unique_wishlist_click');
        Route::get('/detail/get_unique_ads_view', [ShopOwnerController::class, 'get_unique_ads_view'])->name('detail.get_unique_ads_view');
        Route::get('/detail/get_discount_product_view', [ShopOwnerController::class, 'get_discount_product_view'])->name('detail.get_discount_product_view');
        Route::get('/shop', [ShopOwnerController::class, 'shop_detail'])->name('shop_detail');
        Route::put('/detail', [ItemsController::class, 'from_detail_edit'])->name('detail.update');

        Route::get('/edit', [ShopOwnerController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [ShopOwnerController::class, 'update'])->name('update');

        Route::post('editajax', [ItemsController::class, 'edit_ajax'])->name('editajax');

        Route::post('customedit', [ItemsController::class, 'custom_edit'])->name('customedit');
        Route::post('removeimage', [ItemsController::class, 'remove_image'])->name('removeimage');

        Route::get('change-password', [ChangePasswordController::class, 'index']);
        Route::post('change-password', [ChangePasswordController::class, 'store'])->name('change.password');

        Route::get('update-password', [UpdatePasswordController::class, 'index']);
        Route::post('update-password', [UpdatePasswordController::class, 'store'])->name('update.password');

        Route::get('/item/discount/{id}', [DiscountController::class, 'discount']);
        Route::post('/item/discount/{id}', [DiscountController::class, 'discount_save']);
        Route::get('/item/discount_list', [DiscountController::class, 'list']);

        // Route::get('/item/discount_list', 'Shopowner\DiscountController@getDiscountItems')->name('discount.getDiscountItems');

        Route::delete('/item/discount_remove', [DiscountController::class, 'remove']);
        Route::get('/item/get_discount_items', [DiscountController::class, 'get_discount_items'])->name('getDiscountItems');

        //INFO Premium Features
        //collection
        Route::get('/collections/items/{collection}', [CollectionController::class, 'collection_items'])
            ->name('collections.items');

        Route::post('/collections/items/add/{collection}', [CollectionController::class, 'add_item'])
            ->name('collections.item.add');

        Route::delete('/collections/remove-item', [CollectionController::class, 'remove_item'])
            ->name('collections.remove.item');

        //collection datatable
        Route::get('/collections/get-collections', [CollectionController::class, 'get_collections'])
            ->name('collections.getCollections');

        Route::get('/collections/get-collection-items', [CollectionController::class, 'get_collection_items'])
            ->name('collections.getCollectionItems');

        Route::get('/collections/get-items', [CollectionController::class, 'get_items'])
            ->name('collections.getItems');

        //news datatable
        Route::get('/news/get-all-news', [NewsController::class, 'get_all_news'])
            ->name('news.getAllNews');

        //event datatable
        Route::get('/events/get-events', [EventController::class, 'get_events'])
            ->name('events.getEvents');

        Route::resources([
            'collections' => CollectionController::class,
            'news' => NewsController::class,
            'events' => EventController::class,
        ]);

        /** Point System */
        // Route::get('/user_points/add_price/','Shopowner\ShopownerController@add_price')->name('add_price');
        Route::post('/user_points/add_price/', [ShopOwnerController::class, 'add_price_create'])->name('add_price.create');

        // Activity
        Route::get('/product/activity/item', [ItemsController::class, 'item_activity_index'])->name('so_activity.p_product');
        Route::get('/product/activity/multiprice', [ItemsController::class, 'multiprice_activity_index'])->name('so_activity.p_multiprice');
        Route::get('/product/activity/multidiscount', [ItemsController::class, 'multidiscount_activity_index'])->name('so_activity.p_multidiscount');
        Route::get('/product/activity/multipercent', [ItemsController::class, 'multipercent_activity_index'])->name('so_activity.p_multipercent');

        Route::get('/user/activity/product', [ManagerController::class, 'user_activity_product'])->name('so_activity.u_product');
        Route::get('/user/activity/role', [ManagerController::class, 'user_activity_role'])->name('so_activity.u_role');

        // Popup Ads
        Route::get('/ads/main_popup', [PopupAdsController::class, 'main_popup'])->name('ads.main_popup');
        Route::post('/ads/main_popup/upload', [PopupAdsController::class, 'main_popup_upload'])->name('ads.main_popup_upload');
        Route::get('/ads/main_popup/delete', [PopupAdsController::class, 'main_popup_delete'])->name('ads.main_popup_delete');

        // Opening Times
        Route::get('/opening_times', [OpeningTimesController::class, 'opening_times'])->name('opening_times');
        Route::post('/opening_times/upload', [OpeningTimesController::class, 'opening_times_upload'])->name('opening_times_upload');
        Route::get('/opening_times/delete', [OpeningTimesController::class, 'opening_times_delete'])->name('opening_times_delete');

        /** Point System */
        // Route::get('/user_points/add_price/','Shopowner\ShopownerController@add_price')->name('add_price');
        // Add Price
        Route::post('/user_points/add_price/', [ShopOwnerController::class, 'add_price_create'])->name('add_price.create');

        // Logout
        Route::post('logout', [ShopOwnerLoginController::class, 'logout'])->name('logout');

        // App File Download
        //INFO currently disabled because the application is not available yet
        // Route::get('/app-files/android', [AppDownloadController::class, 'android'])->name('app-files.android');
        // Route::get('/app-files/download/{appFile}', [AppDownloadController::class, 'download'])->name('app-files.download');

        // Chat Panel
        Route::get('/chatpannel', [MessageController::class, 'chatpannel']);
        Route::post('/sendmessagetouser', [MessageController::class, 'sendmessagetouser']);
        Route::post('/sendimagemessagetouser', [MessageController::class, 'sendimagemessagetouser']);

        Route::get('/getshopschatslist', [MessageController::class, 'getshopschatslist']);
        Route::get('gettotalchatcountforshop', [MessageController::class, 'gettotalchatcountforshop']);
        Route::get('getspecificchatcountforshop/{user_id}', [MessageController::class, 'getspecificchatcountforshop']);
        Route::post('/getcurrentchatuser', [MessageController::class, 'getcurrentchatuser']);
        Route::post('/sendwhatshopisactive', [MessageController::class, 'sendwhatshopisactive']);
        Route::post('/setreadbyshop', [MessageController::class, 'setreadbyshop']);
        Route::post('/sendwhatshopisoffline', [MessageController::class, 'sendwhatshopisoffline']);
        Route::post('/sendwhatshopisofflinefromcustomer', [UsermessageController::class, 'sendwhatshopisoffline']);

        // Firebase Notifications
        Route::post('/storefirebasetokenforshop', [MessageController::class, 'storefirebasetokenforshop']);

        // Point System
        // Route::get('/user_points/add_price/', [ShopownerController::class, 'add_price'])->name('add_price');
        Route::post('/user_points/add_price/', [ShopOwnerController::class, 'add_price_create'])->name('add_price.create');
    });
});
