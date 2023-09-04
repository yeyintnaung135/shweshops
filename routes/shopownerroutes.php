<?php

use App\Http\Controllers\Auth\ShopownerLoginController;
use App\Http\Controllers\Auth\ShopownerRegisterController;
use App\Http\Controllers\Auth\YkforgotpasswordController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\message\MessageController;
use App\Http\Controllers\message\UsermessageController;
use App\Http\Controllers\ShopOwner\AppDownloadController;
use App\Http\Controllers\ShopOwner\CollectionController;
use App\Http\Controllers\ShopOwner\DiscountController;
use App\Http\Controllers\ShopOwner\EventController;
use App\Http\Controllers\ShopOwner\ItemsController;
use App\Http\Controllers\ShopOwner\ManagerController;
use App\Http\Controllers\ShopOwner\NewsController;
use App\Http\Controllers\Shopowner\OpeningTimesController;
use App\Http\Controllers\ShopOwner\PopupAdsController;
use App\Http\Controllers\ShopOwner\PosController;
use App\Http\Controllers\ShopOwner\PosSecondPhaseController;
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

    Route::get('/login/{from?}', [ShopownerLoginController::class, 'loginform'])->name('login');
    Route::post('login', [ShopownerLoginController::class, 'login'])->name('login.post');

    // POS login & register form
    Route::get('/pos/login', [ShopownerLoginController::class, 'pos_login_form'])->name('pos.login');
    Route::post('/pos/login', [ShopownerLoginController::class, 'pos_login'])->name('pos_logined');
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

        //Start POS//
        Route::middleware(['web', 'foratc'])->group(function () {
            Route::get('/dashboard', [PosController::class, 'get_dashboard'])->name('pos.dashboard');
            Route::post('/totalamount', [PosController::class, 'get_total_amount'])->name('pos.totalamount');
            Route::post('/goldprice', [PosController::class, 'get_gold_price'])->name('pos.goldprice');

            //Purchase
            //gold
            Route::get('/purchase_list', [PosController::class, 'get_purchase_list'])->name('pos.purchase_list');
            Route::post('/gold_type_filter', [PosController::class, 'gold_type_filter'])->name('pos.gold_type_filter');
            Route::post('/gold_advance_filter', [PosController::class, 'gold_advance_filter'])->name('pos.gold_advance_filter');
            Route::get('/create_purchase', [PosController::class, 'create_purchase'])->name('pos.create_purchase');
            Route::post('/store_purchase', [PosController::class, 'store_purchase'])->name('pos.store_purchase');
            Route::post('/puchase_code', [PosController::class, 'get_purchase_code'])->name('pos.codegenerate');
            Route::post('/quality_price', [PosController::class, 'get_quality_price'])->name('pos.quality_gold_price');
            Route::post('/delete_purchase', [PosController::class, 'delete_purchase'])->name('pos.delete_purchase');
            Route::get('/edit_purchase/{id}', [PosController::class, 'edit_purchase'])->name('pos.edit_purchase');
            Route::post('/update_purchase/{id}', [PosController::class, 'update_purchase'])->name('pos.update_purchase');
            Route::get('/detail_purchase/{id}', [PosController::class, 'detail_purchase'])->name('pos.detail_purchase');

            //kyout
            Route::get('/kpurchase_list', [PosController::class, 'get_kyout_purchase_list'])->name('pos.kyout_purchase_list');
            Route::post('/kyout_type_filter', [PosController::class, 'kyout_type_filter'])->name('pos.kyout_type_filter');
            Route::post('/kyout_advance_filter', [PosController::class, 'kyout_advance_filter'])->name('pos.kyout_advance_filter');
            Route::get('/create_kpurchase', [PosController::class, 'create_kyout_purchase'])->name('pos.create_kyout_purchase');
            Route::post('/store_kpurchase', [PosController::class, 'store_kyout_purchase'])->name('pos.store_kyout_purchase');
            Route::post('/fill_phno', [PosController::class, 'get_phone'])->name('pos.fill_phno');
            Route::post('/delete_kyout_purchase', [PosController::class, 'delete_kyout_purchase'])->name('pos.delete_kyout_purchase');
            Route::get('/edit_kyout_purchase/{id}', [PosController::class, 'edit_kyout_purchase'])->name('pos.edit_kyout_purchase');
            Route::post('/update_kyout_purchase/{id}', [PosController::class, 'update_kyout_purchase'])->name('pos.update_kyout_purchase');
            Route::get('/detail_kyout_purchase/{id}', [PosController::class, 'detail_kyout_purchase'])->name('pos.detail_kyout_purchase');

            //platinum
            Route::get('/ptmpurchase_list', [PosController::class, 'get_ptm_purchase_list'])->name('pos.ptm_purchase_list');
            Route::post('/platinum_type_filter', [PosController::class, 'ptm_type_filter'])->name('pos.ptm_type_filter');
            Route::post('/platinum_advance_filter', [PosController::class, 'platinum_advance_filter'])->name('pos.platinum_advance_filter');
            Route::get('/create_platinum_purchase', [PosController::class, 'create_ptm_purchase'])->name('pos.create_ptm_purchase');
            Route::post('/quality_ptm_price', [PosController::class, 'get_ptm_quality_price'])->name('pos.quality_ptm_price');
            Route::post('/store_platinum_purchase', [PosController::class, 'store_ptm_purchase'])->name('pos.store_ptm_purchase');
            Route::post('/delete_ptm_purchase', [PosController::class, 'delete_ptm_purchase'])->name('pos.delete_ptm_purchase');
            Route::get('/edit_platinum_purchase/{id}', [PosController::class, 'edit_ptm_purchase'])->name('pos.edit_ptm_purchase');
            Route::post('/update_platinum_purchase/{id}', [PosController::class, 'update_ptm_purchase'])->name('pos.update_ptm_purchase');
            Route::get('/detail_platinum_purchase/{id}', [PosController::class, 'detail_ptm_purchase'])->name('pos.detail_ptm_purchase');

            //whitegold
            Route::get('/wgpurchase_list', [PosController::class, 'get_wg_purchase_list'])->name('pos.wg_purchase_list');
            Route::post('/whitegold_type_filter', [PosController::class, 'wg_type_filter'])->name('pos.wg_type_filter');
            Route::post('/whitegold_advance_filter', [PosController::class, 'whitegold_advance_filter'])->name('pos.whitegold_advance_filter');
            Route::get('/create_whitegold_purchase', [PosController::class, 'create_wg_purchase'])->name('pos.create_wg_purchase');
            Route::post('/quality_wg_price', [PosController::class, 'get_wg_quality_price'])->name('pos.quality_wg_price');
            Route::post('/store_whitegold_purchase', [PosController::class, 'store_wg_purchase'])->name('pos.store_wg_purchase');
            Route::post('/delete_wg_purchase', [PosController::class, 'delete_wg_purchase'])->name('pos.delete_wg_purchase');
            Route::get('/edit_whitegold_purchase/{id}', [PosController::class, 'edit_wg_purchase'])->name('pos.edit_wg_purchase');
            Route::post('/update_whitegold_purchase/{id}', [PosController::class, 'update_wg_purchase'])->name('pos.update_wg_purchase');
            Route::get('/detail_whitegold_purchase/{id}', [PosController::class, 'detail_wg_purchase'])->name('pos.detail_wg_purchase');

            //Sale
            //gold
            Route::get('/gold_sale_list', [PosController::class, 'sale_gold_list'])->name('pos.gold_sale_list');
            Route::post('/goldsale_type_filter', [PosController::class, 'gold_sale_type_filter'])->name('pos.goldsale_type_filter');
            Route::post('/goldsale_advance_filter', [PosController::class, 'gold_sale_advance_filter'])->name('pos.goldsale_advance_filter');
            Route::get('/edit_goldsale/{id}', [PosController::class, 'edit_gold_sale'])->name('pos.edit_goldsale');
            Route::post('/update_sale_gold/{id}', [PosController::class, 'update_gold_sale'])->name('pos.update_sale_gold');
            Route::post('/delete_goldsale', [PosController::class, 'delete_gold_sale'])->name('pos.delete_goldsale');
            Route::get('/sale_purchase', [PosController::class, 'sale_purchase'])->name('pos.sale_purchase');
            Route::post('/get_sale_values', [PosController::class, 'get_sale_values'])->name('pos.getSaleValues');
            Route::post('/sale_gold', [PosController::class, 'store_gold_sale'])->name('pos.store_sale_gold');
            Route::get('/detail_goldsale/{id}', [PosController::class, 'detail_gold_sale'])->name('pos.detail_goldsale');

            //kyout
            Route::get('/sale_kyout_list', [PosController::class, 'sale_kyout_list'])->name('pos.sale_kyout_list');
            Route::post('/kyoutsale_type_filter', [PosController::class, 'kyout_sale_type_filter'])->name('pos.kyoutsale_type_filter');
            Route::post('/kyoutsale_advance_filter', [PosController::class, 'kyout_sale_advance_filter'])->name('pos.kyoutsale_advance_filter');
            Route::get('/edit_kyoutsale/{id}', [PosController::class, 'edit_kyout_sale'])->name('pos.edit_kyoutsale');
            Route::post('/update_sale_kyout/{id}', [PosController::class, 'update_kyout_sale'])->name('pos.update_sale_kyout');
            Route::post('/delete_kyoutsale', [PosController::class, 'delete_kyout_sale'])->name('pos.delete_kyoutsale');
            Route::get('/sale_kyout_purchase', [PosController::class, 'sale_kyout_purchase'])->name('pos.sale_kyout_purchase');
            Route::post('/get_sale_kvalues', [PosController::class, 'get_sale_kyout_values'])->name('pos.getSaleKValues');
            Route::post('/sale_kyout', [PosController::class, 'store_kyout_sale'])->name('pos.store_sale_kyout');
            Route::get('/detail_kyoutsale/{id}', [PosController::class, 'detail_kyout_sale'])->name('pos.detail_kyoutsale');

            //platinum
            Route::get('/ptm_sale_list', [PosController::class, 'sale_ptm_list'])->name('pos.ptm_sale_list');
            Route::post('/delete_ptm_sale', [PosController::class, 'delete_ptm_sale'])->name('pos.delete_ptm_sale');
            Route::post('/update_sale_platinum/{id}', [PosController::class, 'update_platinum_sale'])->name('pos.update_sale_platinum');
            Route::get('/edit_ptmsale/{id}', [PosController::class, 'edit_ptm_sale'])->name('pos.edit_ptmsale');
            Route::post('/platinumsale_advance_filter', [PosController::class, 'platinum_sale_advance_filter'])->name('pos.platinumsale_advance_filter');
            Route::post('/platinumsale_type_filter', [PosController::class, 'ptmsale_type_filter'])->name('pos.ptmsale_type_filter');
            Route::get('/sale_platinum_purchase', [PosController::class, 'sale_ptm_purchase'])->name('pos.sale_ptm_purchase');
            Route::post('/get_sale_pvalues', [PosController::class, 'get_sale_ptm_values'])->name('pos.getSalePtmValues');
            Route::post('/sale_platinum', [PosController::class, 'store_platinum_sale'])->name('pos.store_sale_platinum');
            Route::get('/detail_ptmsale/{id}', [PosController::class, 'detail_platinum_sale'])->name('pos.detail_ptmsale');

            //whitegold
            Route::get('/wg_sale_list', [PosController::class, 'sale_wg_list'])->name('pos.wg_sale_list');
            Route::post('/delete_wg_sale', [PosController::class, 'delete_wg_sale'])->name('pos.delete_wg_sale');
            Route::post('/update_sale_whitegold/{id}', [PosController::class, 'update_whitegold_sale'])->name('pos.update_sale_whitegold');
            Route::get('/edit_wgsale/{id}', [PosController::class, 'edit_wg_sale'])->name('pos.edit_wgsale');
            Route::post('/whitegoldsale_advance_filter', [PosController::class, 'whitegold_sale_advance_filter'])->name('pos.whitegoldsale_advance_filter');
            Route::post('/whitegoldsale_type_filter', [PosController::class, 'wgsale_type_filter'])->name('pos.wgsale_type_filter');
            Route::get('/sale_whitegold_purchase', [PosController::class, 'sale_wg_purchase'])->name('pos.sale_wg_purchase');
            Route::post('/get_sale_wgvalues', [PosController::class, 'get_sale_wg_values'])->name('pos.getSaleWgValues');
            Route::post('/sale_whitegold', [PosController::class, 'store_whitegold_sale'])->name('pos.store_sale_whitegold');
            Route::get('/detail_wgsale/{id}', [PosController::class, 'detail_whitegold_sale'])->name('pos.detail_wg_sale');

            //Diamond List
            Route::get('/diamond_list', [PosController::class, 'get_diamond_list'])->name('pos.diamond_list');
            Route::get('/create_diamond', [PosController::class, 'get_create_diamond'])->name('pos.create_diamond');
            Route::post('/diamond_type_filter', [PosController::class, 'diamond_type_filter'])->name('pos.diamond_type_filter');
            Route::post('/store_diamond', [PosController::class, 'store_diamond'])->name('pos.store_diamond');
            Route::get('/edit_diamond/{id}', [PosController::class, 'edit_diamond'])->name('pos.edit_diamond');
            Route::post('/update_diamond/{id}', [PosController::class, 'update_diamond'])->name('pos.update_diamond');
            Route::post('/delete_diamond', [PosController::class, 'delete_diamond'])->name('pos.delete_diamond');

            //Counter Shop List
            Route::get('/countershop_list', [PosController::class, 'get_counter_list'])->name('pos.counter_list');
            Route::get('/create_counter', [PosController::class, 'create_counter'])->name('pos.create_counter');
            Route::post('/counter_type_filter', [PosController::class, 'counter_type_filter'])->name('pos.counter_type_filter');
            Route::post('/store_counter', [PosController::class, 'store_counter'])->name('pos.store_counter');
            Route::get('/edit_counter/{id}', [PosController::class, 'edit_counter'])->name('pos.edit_counter');
            Route::post('/update_counter/{id}', [PosController::class, 'update_counter'])->name('pos.update_counter');
            Route::post('/delete_counter', [PosController::class, 'delete_counter'])->name('pos.delete_counter');

            //Assign Gold Price
            Route::get('/assign_gold', [PosController::class, 'get_assign_gold'])->name('pos.assign_gold_list');
            Route::post('/assign_gold_price', [PosController::class, 'get_assign_gold_price'])->name('pos.assign_gold_price');
            Route::post('/update_assign_gold_price/{id}', [PosController::class, 'update_assign_gold_price'])->name('pos.update_assign_gold_price');

            //Assign Platinum
            Route::get('/assign_platinum', [PosController::class, 'get_assign_platinum'])->name('pos.assign_platinum_list');
            Route::get('/assign_platinum_price', [PosController::class, 'get_assign_platinum_price'])->name('pos.assign_platinum_price');
            Route::post('/store_assign_platinum_price', [PosController::class, 'store_assign_platinum_price'])->name('pos.store_assign_platinum_price');
            Route::post('/update_assign_platinum_price/{id}', [PosController::class, 'update_assign_platinum_price'])->name('pos.update_assign_platinum_price');

            //Assign WhiteGold
            Route::get('/assign_whitegold', [PosController::class, 'get_assign_whitegold'])->name('pos.assign_whitegold_list');
            Route::get('/assign_whitegold_price', [PosController::class, 'get_assign_whitegold_price'])->name('pos.assign_whitegold_price');
            Route::post('/store_assign_whitegold_price', [PosController::class, 'store_assign_whitegold_price'])->name('pos.store_assign_whitegold_price');
            Route::post('/update_assign_whitegold_price/{id}', [PosController::class, 'update_assign_whitegold_price'])->name('pos.update_assign_whitegold_price');

            //Staff List
            Route::get('/staff_list', [PosSecondPhaseController::class, 'get_staff_list'])->name('pos.staff_list');
            Route::get('/create_staff', [PosSecondPhaseController::class, 'get_create_staff'])->name('pos.create_staff');
            Route::post('/staff_type_filter', [PosSecondPhaseController::class, 'staff_type_filter'])->name('pos.staff_type_filter');
            Route::post('/store_staff', [PosSecondPhaseController::class, 'store_staff'])->name('pos.store_staff');
            Route::get('/edit_staff/{id}', [PosSecondPhaseController::class, 'edit_staff'])->name('pos.edit_staff');
            Route::post('/update_staff/{id}', [PosSecondPhaseController::class, 'update_staff'])->name('pos.update_staff');
            Route::post('/delete_staff', [PosSecondPhaseController::class, 'delete_staff'])->name('pos.delete_staff');
            Route::post('/check_staff_code', [PosSecondPhaseController::class, 'check_staff_code'])->name('pos.check_staff_code');

            //Supplier
            Route::get('/supplier_list', [PosSecondPhaseController::class, 'get_supplier_list'])->name('pos.supplier_list');
            Route::get('/create_supplier', [PosSecondPhaseController::class, 'get_create_supplier'])->name('pos.create_supplier');
            Route::post('/change_state', [PosSecondPhaseController::class, 'change_state'])->name('pos.change_state');
            Route::post('/type_filter', [PosSecondPhaseController::class, 'type_filter'])->name('pos.type_filter');
            Route::post('/store_supplier', [PosSecondPhaseController::class, 'store_supplier'])->name('pos.store_supplier');
            Route::get('/edit_supplier/{id}', [PosSecondPhaseController::class, 'edit_supplier'])->name('pos.edit_supplier');
            Route::post('/update_supplier/{id}', [PosSecondPhaseController::class, 'update_supplier'])->name('pos.update_supplier');
            Route::post('/delete_supplier', [PosSecondPhaseController::class, 'delete_supplier'])->name('pos.delete_supplier');

            //Return List
            Route::get('/return_list', [PosSecondPhaseController::class, 'return_list'])->name('pos.return_list');
            Route::get('/return_create', [PosSecondPhaseController::class, 'create_return'])->name('pos.return_create');
            Route::post('/return_type_filter', [PosSecondPhaseController::class, 'return_type_filter'])->name('pos.return_type_filter');
            Route::post('/store_return', [PosSecondPhaseController::class, 'store_return'])->name('pos.store_return');
            Route::post('/delete_return', [PosSecondPhaseController::class, 'delete_return'])->name('pos.delete_return');
            Route::get('/edit_return/{id}', [PosSecondPhaseController::class, 'edit_return'])->name('pos.edit_return');
            Route::post('/update_return/{id}', [PosSecondPhaseController::class, 'update_return'])->name('pos.update_return');
            Route::post('/add_purchase_return', [PosSecondPhaseController::class, 'add_purchase_return'])->name('pos.add_purchase_return');

            // Filter
            Route::post('/sell_flag_filter', [PosSecondPhaseController::class, 'filter_sell_flag'])->name('pos.sell_flag_filter');
            Route::post('/sold_filter', [PosSecondPhaseController::class, 'filter_sold'])->name('pos.sold_filter');

            // Credit List
            Route::get('/credit_list', [PosSecondPhaseController::class, 'credit_list'])->name('pos.credit_list');
            Route::post('/credit_type_filter', [PosSecondPhaseController::class, 'credit_type_filter'])->name('pos.credit_type_filter');
            Route::post('/delete_credit', [PosSecondPhaseController::class, 'delete_credit'])->name('pos.delete_credit');

            // Second Phase
            // Purchases
            Route::get('/purchase_lists', [PosSecondPhaseController::class, 'get_purchase_lists'])->name('pos.purchase_lists');

            // Sales
            Route::get('/sale_lists', [PosSecondPhaseController::class, 'get_sale_lists'])->name('pos.sale_lists');
            Route::get('/famous_sale_lists', [PosSecondPhaseController::class, 'get_famous_sale_lists'])->name('pos.famous_sale_lists');
            Route::post('/date_famous', [PosSecondPhaseController::class, 'filter_famous_sale_lists'])->name('pos.date_famous'); // Filter Famous Sale Lists missing in Controller
            Route::get('/income_lists', [PosSecondPhaseController::class, 'get_income_lists'])->name('pos.income_lists');
            Route::post('/tab_salelists', [PosSecondPhaseController::class, 'tab_sale_lists'])->name('pos.tab_salelists');
            Route::post('/tab_incomelists', [PosSecondPhaseController::class, 'tab_income_lists'])->name('pos.tab_incomelists');

            // Stock List
            Route::get('/stock_lists', [PosSecondPhaseController::class, 'get_stock_lists'])->name('pos.stock_lists');
            Route::post('/tab_stocklists', [PosSecondPhaseController::class, 'tab_stock_lists'])->name('pos.tab_stocklists');

            // Shop Profile
            Route::get('/shop_profile', [PosSecondPhaseController::class, 'get_shop_profile'])->name('pos.shop_profile'); // Get Shop Profile missing in Controller
            Route::get('/shop_edit', [PosSecondPhaseController::class, 'get_shop_edit'])->name('pos.shop_edit'); // Get Shop Edit missing in Controller
            Route::put('/shop_edit/{id}', [PosSecondPhaseController::class, 'shop_update'])->name('pos.shop_update'); // Shop Update missing in Controller
            Route::get('pos-change-password', [PosSecondPhaseController::class, 'get_password']);
            Route::post('pos-change-password', [PosSecondPhaseController::class, 'change_password'])->name('pos.change.password');
            Route::get('pos-update-password', [PosSecondPhaseController::class, 'edit_password']);
            Route::post('pos-update-password', [PosSecondPhaseController::class, 'store_new_password'])->name('pos.update.password');
        });

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
        Route::post('logout', [ShopownerLoginController::class, 'logout'])->name('logout');

        // App File Download
        Route::get('/app-files/android', [AppDownloadController::class, 'android'])->name('app-files.android');
        Route::get('/app-files/download/{appFile}', [AppDownloadController::class, 'download'])->name('app-files.download');

        // User Messages
        Route::post('/sendmessage', [UsermessageController::class, 'sendmessagetoshopowner']);
        Route::post('/sendimagemessage', [UsermessageController::class, 'sendimagemessagetoshopowner']);

        // Chat Panel
        Route::get('/chatpannel', [MessageController::class, 'chatpannel']);
        Route::post('/sendmessagetouser', [MessageController::class, 'sendmessagetouser']);
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
