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
use App\Http\Controllers\ShopOwner\PosController;
use App\Http\Controllers\ShopOwner\PosSecondPhaseController;
use App\Http\Controllers\ShopOwner\ShopOwnerController;
use App\Http\Controllers\ShopOwner\ShopOwnerSupportController;
use App\Http\Controllers\ShopOwner\TemplateController;
use App\Http\Controllers\UpdatePasswordController;

Route::group(['prefix' => 'backside/shop_owner', 'as' => 'backside.shop_owner.'], function () {

    // Authentication Routes
    // Route::get('register', [ShopownerRegisterController::class, 'create'])->name('register');
    Route::post('register', [ShopownerRegisterController::class, 'store'])->name('registered');

    Route::get('/login/{from?}', [ShopownerLoginController::class, 'loginform'])->name('login');
    Route::post('login', [ShopownerLoginController::class, 'login'])->name('logined');

    // POS login & register form
    Route::get('/pos/login', [ShopownerLoginController::class, 'pos_login_form'])->name('pos.login');
    Route::post('/pos/login', [ShopownerLoginController::class, 'pos_login'])->name('pos_logined');

    // Keep the commented line as is
    // Route::post('/pos/register', ['as' => 'pos_registered', 'uses' => 'Auth\ShopownerLoginController@pos_register']);

    // Update only price
    Route::post('/price_only_update', [ItemsController::class, 'only_price_update'])->name('price_only_update');

    //forgot password owner
    Route::get('pos/forgot_password', [YkforgotpasswordController::class, 'showLinkRequestForm'])->name('forgot_password');
    Route::post('forgot_password', [YkforgotpasswordController::class, 'send_reset_code_form'])->name('send_reset_code');
    Route::put('forgot_password', [YkforgotpasswordController::class, 'codeCheck'])->name('send_reset_code');
    Route::post('add_new_password', [YkforgotpasswordController::class, 'add_new_password'])->name('add_new_password');

    //reg ph confirmation
    Route::get('/support', [ShopOwnerSupportController::class, 'index']);
    Route::post('/get_support_by_cat', [ShopOwnerSupportController::class, 'get_support_by_cat']);
    Route::post('/get_support', [ShopOwnerSupportController::class, 'get_support']);
    Route::resource('/', ShopOwnerController::class);
    Route::resource('/items', ItemsController::class);

    Route::get('/get_item_activity_log', [ItemsController::class, 'getItemActivityLog'])->name('items.getitems_activity_log');
    Route::get('/unique_get_item_activity_log', [ShopOwnerController::class, 'uniquegetItemActivityLog'])->name('items.uniquegetitems_activity_log');
    Route::get('/get_multiple_price_activity_log', [ItemsController::class, 'getMultiplePriceActivityLog'])->name('items.getmultiple_price_activity_log');
    Route::get('/get_multiple_discount_activity_log', [ItemsController::class, 'getMultipleDiscountActivityLog'])->name('items.getmultiple_discount_activity_log');
    Route::get('/get_multiple_damage_activity_log', [ItemsController::class, 'getMultipleDamageActivityLog'])->name('items.getmultiple_damage_activity_log');
    Route::get('/get_items', [ItemsController::class, 'getItems'])->name('items.getItems');
    Route::post('/getproductcodebytyping', [ItemsController::class, 'getproductcodebytyping']);

    Route::get('/items_trash', [ItemsController::class, 'trash'])->name('items.trash');
    Route::get('/get_items_trash', [ItemsController::class, 'getitemsTrash'])->name('items.getitemsTrash');
    Route::get('/items_trash/{id}', [ItemsController::class, 'restore'])->name('items.restore');
    Route::delete('/items_trash_delete/{id}', [ItemsController::class, 'forceDelete'])->name('items.forcedelete');

    // Route::get('/items_trash','Shopowner\ItemsController@trash')->name('items.trash');
    // Route::get('/items_trash/{id}','Shopowner\ItemsController@restore')->name('items.restore');
    // Route::get('/items_trash_delete/{id}','Shopowner\ItemsController@forceDelete')->name('items.forcedelete');

    Route::post('/multipe_discount', [DiscountController::class, 'multiple_discount'])->name('items.multiple.discount');
    Route::post('/multipe_unset_discount', [DiscountController::class, 'multiple_unset_discount']);
    Route::post('/multiple/plus', [ItemsController::class, 'multiple_update_plus'])->name('multiple_items.update_plus');
    Route::post('/multiple/minus', [ItemsController::class, 'multiple_update_minus'])->name('multiple_items.update_minus');
    Route::post('/multiple/recap', [ItemsController::class, 'multiple_update_recap'])->name('multiple_items.update_recap');
    Route::post('/multiple/stock', [ItemsController::class, 'multiple_stock'])->name('multiple.stock.items');
    Route::post('/multiple/checkpriceafterupdateclick', [ItemsController::class, 'checkpriceafterupdateclick'])->name('multiple_items.checkpriceafterupdateclick');
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
    Route::get('/get_backrole/detail', [ManagerController::class, 'get_backrole_activity_detail'])->name('getbackrole.detail');
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
    Route::get('/detail/shop_view', [ShopOwnerController::class, 'shopview'])->name('detail.shop_view');
    Route::get('/detail/product_view', [ShopOwnerController::class, 'productview'])->name('detail.product_view');
    Route::get('/detail/buy_now_click', [ShopOwnerController::class, 'buynowclick'])->name('detail.buy_now_click');
    Route::get('/detail/unique_add_to_cart_click', [ShopOwnerController::class, 'uniqueaddtocartclick'])->name('detail.unique_add_to_cart_click');
    Route::get('/detail/unique_whishlist_click', [ShopOwnerController::class, 'uniquewhishlistclick'])->name('detail.unique_whishlist_click');
    Route::get('/detail/unique_ads_view', [ShopOwnerController::class, 'uniqueadsview'])->name('detail.unique_ads_view');
    Route::get('/detail/unique_product_view', [ShopOwnerController::class, 'uniqueproductview'])->name('detail.unique_product_view');
    Route::get('/detail/product_discount_view', [ShopOwnerController::class, 'discountproductview'])->name('detail.product_discount_view');
    Route::get('/detail/get_shop_view', [ShopOwnerController::class, 'getshopownerview'])->name('detail.get_shop_view');
    Route::get('/detail/get_buy_now_click', [ShopOwnerController::class, 'getbuynowclick'])->name('detail.get_buy_now_click');
    Route::get('/detail/get_unique_add_to_cart_click', [ShopOwnerController::class, 'getuniqueaddtocartclick'])->name('detail.get_unique_add_to_cart_click');
    Route::get('/detail/get_unique_whishlist_click', [ShopOwnerController::class, 'getuniquewhishlistclick'])->name('detail.get_unique_whishlist_click');
    Route::get('/detail/get_unique_ads_view', [ShopOwnerController::class, 'getuniqueadsview'])->name('detail.get_unique_ads_view');
    Route::get('/detail/get_discount_product_view', [ShopOwnerController::class, 'getdiscountproductview'])->name('detail.get_discount_product_view');
    Route::get('/shop', [ShopOwnerController::class, 'shopdetail'])->name('shop_detail');
    Route::put('/detail', [ItemsController::class, 'fromDetailEdit'])->name('detail.update');

    Route::get('/edit', [ShopOwnerController::class, 'edit'])->name('edit');
    Route::put('/edit/{id}', [ShopOwnerController::class, 'update'])->name('update');

    Route::post('editajax', [ItemsController::class, 'editajax'])->name('editajax');

    Route::post('customedit', [ItemsController::class, 'customedit'])->name('customedit');
    Route::post('removeimage', [ItemsController::class, 'removeimage'])->name('removeimage');

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

    //Premium Features
    Route::middleware(['auth:shop_owner,shop_role'])->group(function () {
        //collection
        Route::get('/collections/items/{collection}', [CollectionController::class, 'collection_items'])
            ->name('collections.items');

        Route::post('/collections/items/add/{collection}', [CollectionController::class, 'add_item'])->name('collections.item.add');

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

        //activity
        Route::get('/product/activity/item', [ItemsController::class, 'item_activity_index'])->name('so_activity.p_product');
        Route::get('/product/activity/multiprice', [ItemsController::class, 'multiprice_activity_index'])->name('so_activity.p_multiprice');
        Route::get('/product/activity/multidiscount', [ItemsController::class, 'multidiscount_activity_index'])->name('so_activity.p_multidiscount');
        Route::get('/product/activity/multipercent', [ItemsController::class, 'multipercent_activity_index'])->name('so_activity.p_multipercent');

        Route::get('/user/activity/product', [ManagerController::class, 'u_product'])->name('so_activity.u_product');
        Route::get('/user/activity/role', [ManagerController::class, 'u_role'])->name('so_activity.u_role');

        /** Point System */
        // Route::get('/user_points/add_price/','Shopowner\ShopownerController@add_price')->name('add_price');
        Route::post('/user_points/add_price/', [ShopOwnerController::class, 'add_price_create'])->name('add_price.create');
    });
    //Start POS//
    Route::middleware(['web', 'foratc'])->group(function () {
        Route::get('/dashboard', [PosController::class, 'getDashBoard'])->name('pos.dashboard');
        Route::post('/totalamount', [PosController::class, 'getTotalAmount'])->name('pos.totalamount');
        Route::post('/goldprice', [PosController::class, 'getGoldPrice'])->name('pos.goldprice');

        //Purchase
        //gold
        Route::get('/purchase_list', [PosController::class, 'getPurchaseList'])->name('pos.purchase_list');
        Route::post('/gold_type_filter', [PosController::class, 'goldtypeFilter'])->name('pos.gold_type_filter');
        Route::post('/gold_advance_filter', [PosController::class, 'goldadvanceFilter'])->name('pos.gold_advance_filter');
        Route::get('/create_purchase', [PosController::class, 'createPurchase'])->name('pos.create_purchase');
        Route::post('/store_purchase', [PosController::class, 'storePurchase'])->name('pos.store_purchase');
        Route::post('/puchase_code', [PosController::class, 'getPurchaseCode'])->name('pos.codegenerate');
        Route::post('/quality_price', [PosController::class, 'getQualityPrice'])->name('pos.quality_gold_price');
        Route::post('/delete_purchase', [PosController::class, 'deletePurchase'])->name('pos.delete_purchase');
        Route::get('/edit_purchase/{id}', [PosController::class, 'editPurchase'])->name('pos.edit_purchase');
        Route::post('/update_purchase/{id}', [PosController::class, 'updatePurchase'])->name('pos.update_purchase');
        Route::get('/detail_purchase/{id}', [PosController::class, 'detailPurchase'])->name('pos.detail_purchase');

        //kyout
        Route::get('/kpurchase_list', [PosController::class, 'getKyoutPurchaseList'])->name('pos.kyout_purchase_list');
        Route::post('/kyout_type_filter', [PosController::class, 'kyouttypeFilter'])->name('pos.kyout_type_filter');
        Route::post('/kyout_advance_filter', [PosController::class, 'kyoutadvanceFilter'])->name('pos.kyout_advance_filter');
        Route::get('/create_kpurchase', [PosController::class, 'createKyoutPurchase'])->name('pos.create_kyout_purchase');
        Route::post('/store_kpurchase', [PosController::class, 'storeKyoutPurchase'])->name('pos.store_kyout_purchase');
        Route::post('/fill_phno', [PosController::class, 'getPhone'])->name('pos.fill_phno');
        Route::post('/delete_kyout_purchase', [PosController::class, 'deleteKyoutPurchase'])->name('pos.delete_kyout_purchase');
        Route::get('/edit_kyout_purchase/{id}', [PosController::class, 'editKyoutPurchase'])->name('pos.edit_kyout_purchase');
        Route::post('/update_kyout_purchase/{id}', [PosController::class, 'updateKyoutPurchase'])->name('pos.update_kyout_purchase');
        Route::get('/detail_kyout_purchase/{id}', [PosController::class, 'detailKyoutPurchase'])->name('pos.detail_kyout_purchase');

        //platinum
        Route::get('/ptmpurchase_list', [PosController::class, 'getPtmPurchaseList'])->name('pos.ptm_purchase_list');
        Route::post('/platinum_type_filter', [PosController::class, 'ptmtypeFilter'])->name('pos.ptm_type_filter');
        Route::post('/platinum_advance_filter', [PosController::class, 'platinumadvanceFilter'])->name('pos.platinum_advance_filter');
        Route::get('/create_platinum_purchase', [PosController::class, 'createPtmPurchase'])->name('pos.create_ptm_purchase');
        Route::post('/quality_ptm_price', [PosController::class, 'getPtmQualityPrice'])->name('pos.quality_ptm_price');
        Route::post('/store_platinum_purchase', [PosController::class, 'storePtmPurchase'])->name('pos.store_ptm_purchase');
        Route::post('/delete_ptm_purchase', [PosController::class, 'deletePtmPurchase'])->name('pos.delete_ptm_purchase');
        Route::get('/edit_platinum_purchase/{id}', [PosController::class, 'editPtmPurchase'])->name('pos.edit_ptm_purchase');
        Route::post('/update_platinum_purchase/{id}', [PosController::class, 'updatePtmPurchase'])->name('pos.update_ptm_purchase');
        Route::get('/detail_platinum_purchase/{id}', [PosController::class, 'detailPtmPurchase'])->name('pos.detail_ptm_purchase');

        //whitegold
        Route::get('/wgpurchase_list', [PosController::class, 'getWgPurchaseList'])->name('pos.wg_purchase_list');
        Route::post('/whitegold_type_filter', [PosController::class, 'wgtypeFilter'])->name('pos.wg_type_filter');
        Route::post('/whitegold_advance_filter', [PosController::class, 'whitegoldadvanceFilter'])->name('pos.whitegold_advance_filter');
        Route::get('/create_whitegold_purchase', [PosController::class, 'createWgPurchase'])->name('pos.create_wg_purchase');
        Route::post('/quality_wg_price', [PosController::class, 'getWgQualityPrice'])->name('pos.quality_wg_price');
        Route::post('/store_whitegold_purchase', [PosController::class, 'storeWgPurchase'])->name('pos.store_wg_purchase');
        Route::post('/delete_wg_purchase', [PosController::class, 'deleteWgPurchase'])->name('pos.delete_wg_purchase');
        Route::get('/edit_whitegold_purchase/{id}', [PosController::class, 'editWgPurchase'])->name('pos.edit_wg_purchase');
        Route::post('/update_whitegold_purchase/{id}', [PosController::class, 'updateWgPurchase'])->name('pos.update_wg_purchase');
        Route::get('/detail_whitegold_purchase/{id}', [PosController::class, 'detailWgPurchase'])->name('pos.detail_wg_purchase');

        //Sale
        //gold
        Route::get('/gold_sale_list', [PosController::class, 'saleGoldList'])->name('pos.gold_sale_list');
        Route::post('/goldsale_type_filter', [PosController::class, 'goldsaletypeFilter'])->name('pos.goldsale_type_filter');
        Route::post('/goldsale_advance_filter', [PosController::class, 'goldsaleadvanceFilter'])->name('pos.goldsale_advance_filter');
        Route::get('/edit_goldsale/{id}', [PosController::class, 'editGoldSale'])->name('pos.edit_goldsale');
        Route::post('/update_sale_gold/{id}', [PosController::class, 'updateGoldSale'])->name('pos.update_sale_gold');
        Route::post('/delete_goldsale', [PosController::class, 'deleteGoldSale'])->name('pos.delete_goldsale');
        Route::get('/sale_purchase', [PosController::class, 'salePurchase'])->name('pos.slae_purchase');
        Route::post('/get_sale_values', [PosController::class, 'getSaleValues'])->name('pos.getSaleValues');
        Route::post('/sale_gold', [PosController::class, 'storeGoldSale'])->name('pos.store_sale_gold');
        Route::get('/detail_goldsale/{id}', [PosController::class, 'detailGoldSale'])->name('pos.detail_goldsale');

        //kyout
        Route::get('/sale_kyout_list', [PosController::class, 'saleKyoutList'])->name('pos.sale_kyout_list');
        Route::post('/kyoutsale_type_filter', [PosController::class, 'kyoutsaletypeFilter'])->name('pos.kyoutsale_type_filter');
        Route::post('/kyoutsale_advance_filter', [PosController::class, 'kyoutsaleadvanceFilter'])->name('pos.kyoutsale_advance_filter');
        Route::get('/edit_kyoutsale/{id}', [PosController::class, 'editKyoutSale'])->name('pos.edit_kyoutsale');
        Route::post('/update_sale_kyout/{id}', [PosController::class, 'updateKyoutSale'])->name('pos.update_sale_kyout');
        Route::post('/delete_kyoutsale', [PosController::class, 'deleteKyoutSale'])->name('pos.delete_kyoutsale');
        Route::get('/sale_kyout_purchase', [PosController::class, 'saleKPurchase'])->name('pos.sale_kyout_purchase');
        Route::post('/get_sale_kvalues', [PosController::class, 'getSaleKValues'])->name('pos.getSaleKValues');
        Route::post('/sale_kyout', [PosController::class, 'storeKyoutSale'])->name('pos.store_sale_kyout');
        Route::get('/detail_kyoutsale/{id}', [PosController::class, 'detailKyoutSale'])->name('pos.detail_kyoutsale');

        //platinum
        Route::get('/ptm_sale_list', [PosController::class, 'salePtmList'])->name('pos.ptm_sale_list');
        Route::post('/delete_ptm_sale', [PosController::class, 'deletePtmSale'])->name('pos.delete_ptm_sale');
        Route::post('/update_sale_platinum/{id}', [PosController::class, 'updatePlatinumSale'])->name('pos.update_sale_platinum');
        Route::get('/edit_ptmsale/{id}', [PosController::class, 'editPtmSale'])->name('pos.edit_ptmsale');
        Route::post('/platinumsale_advance_filter', [PosController::class, 'platinumsaleadvanceFilter'])->name('pos.platinumsale_advance_filter');
        Route::post('/platinumsale_type_filter', [PosController::class, 'ptmsaletypeFilter'])->name('pos.ptmsale_type_filter');
        Route::get('/sale_platinum_purchase', [PosController::class, 'salePtmPurchase'])->name('pos.sale_ptm_purchase');
        Route::post('/get_sale_pvalues', [PosController::class, 'getSalePtmValues'])->name('pos.getSalePtmValues');
        Route::post('/sale_platinum', [PosController::class, 'storePlatinumSale'])->name('pos.store_sale_platinum');
        Route::get('/detail_ptmsale/{id}', [PosController::class, 'detailPlatinumSale'])->name('pos.detail_ptmsale');

        //whitegold
        Route::get('/wg_sale_list', [PosController::class, 'saleWgList'])->name('pos.wg_sale_list');
        Route::post('/delete_wg_sale', [PosController::class, 'deleteWgSale'])->name('pos.delete_wg_sale');
        Route::post('/update_sale_whitegold/{id}', [PosController::class, 'updateWhiteGoldSale'])->name('pos.update_sale_whitegold');
        Route::get('/edit_wgsale/{id}', [PosController::class, 'editWgSale'])->name('pos.edit_wgsale');
        Route::post('/whitegoldsale_advance_filter', [PosController::class, 'whitegoldsaleadvanceFilter'])->name('pos.whitegoldsale_advance_filter');
        Route::post('/whitegoldsale_type_filter', [PosController::class, 'wgsaletypeFilter'])->name('pos.wgsale_type_filter');
        Route::get('/sale_whitegold_purchase', [PosController::class, 'saleWgPurchase'])->name('pos.sale_wg_purchase');
        Route::post('/get_sale_wgvalues', [PosController::class, 'getSaleWgValues'])->name('pos.getSaleWgValues');
        Route::post('/sale_whitegold', [PosController::class, 'storeWhiteGoldSale'])->name('pos.store_sale_whitegold');
        Route::get('/detail_wgsale/{id}', [PosController::class, 'detailWhiteGoldSale'])->name('pos.detail_wg_sale');

        //Diamond List
        Route::get('/diamond_list', [PosController::class, 'getDiamondList'])->name('pos.diamond_list');
        Route::get('/create_diamond', [PosController::class, 'getCreateDiamond'])->name('pos.create_diamond');
        Route::post('/diamond_type_filter', [PosController::class, 'diamondtypeFilter'])->name('pos.diamond_type_filter');
        Route::post('/store_diamond', [PosController::class, 'storeDiamond'])->name('pos.store_diamond');
        Route::get('/edit_diamond/{id}', [PosController::class, 'editDiamond'])->name('pos.edit_diamond');
        Route::post('/update_diamond/{id}', [PosController::class, 'updateDiamond'])->name('pos.update_diamond');
        Route::post('/delete_diamond', [PosController::class, 'deleteDiamond'])->name('pos.delete_diamond');

        //Counter Shop List
        Route::get('/countershop_list', [PosController::class, 'getCounterList'])->name('pos.counter_list');
        Route::get('/create_counter', [PosController::class, 'createCounter'])->name('pos.create_counter');
        Route::post('/counter_type_filter', [PosController::class, 'counterTypeFilter'])->name('pos.counter_type_filter');
        Route::post('/store_counter', [PosController::class, 'storeCounter'])->name('pos.store_counter');
        Route::get('/edit_counter/{id}', [PosController::class, 'editCounter'])->name('pos.edit_counter');
        Route::post('/update_counter/{id}', [PosController::class, 'updateCounter'])->name('pos.update_counter');
        Route::post('/delete_counter', [PosController::class, 'deleteCounter'])->name('pos.delete_counter');

        //Assign Gold Price
        Route::get('/assign_gold', [PosController::class, 'getAssignGold'])->name('pos.assign_gold_list');
        Route::post('/assign_gold_price', [PosController::class, 'getAssignGoldPrice'])->name('pos.assign_gold_price');
        Route::post('/update_assign_gold_price/{id}', [PosController::class, 'updateAssignGoldPrice'])->name('pos.update_assign_gold_price');

        //Assign Platinum
        Route::get('/assign_platinum', [PosController::class, 'getAssignPlatinum'])->name('pos.assign_platinum_list');
        Route::get('/assign_platinum_price', [PosController::class, 'getAssignPlatinumPrice'])->name('pos.assign_platinum_price');
        Route::post('/store_assign_platinum_price', [PosController::class, 'storeAssignPlatinumPrice'])->name('pos.store_assign_platinum_price');
        Route::post('/update_assign_platinum_price/{id}', [PosController::class, 'updateAssignPlatinumPrice'])->name('pos.update_assign_platinum_price');

        //Assign WhiteGold
        Route::get('/assign_whitegold', [PosController::class, 'getAssignWhiteGold'])->name('pos.assign_whitegold_list');
        Route::get('/assign_whitegold_price', [PosController::class, 'getAssignWhiteGoldPrice'])->name('pos.assign_whitegold_price');
        Route::post('/store_assign_whitegold_price', [PosController::class, 'storeAssignWhiteGoldPrice'])->name('pos.store_assign_whitegold_price');
        Route::post('/update_assign_whitegold_price/{id}', [PosController::class, 'updateAssignWhiteGoldPrice'])->name('pos.update_assign_whitegold_price');

        //Staff List
        Route::get('/staff_list', [PosSecondPhaseController::class, 'getStaffList'])->name('pos.staff_list');
        Route::get('/create_staff', [PosSecondPhaseController::class, 'getCreateStaff'])->name('pos.create_staff');
        Route::post('/staff_type_filter', [PosSecondPhaseController::class, 'staffTypeFilter'])->name('pos.staff_type_filter');
        Route::post('/store_staff', [PosSecondPhaseController::class, 'storeStaff'])->name('pos.store_staff');
        Route::get('/edit_staff/{id}', [PosSecondPhaseController::class, 'editStaff'])->name('pos.edit_staff');
        Route::post('/update_staff/{id}', [PosSecondPhaseController::class, 'updateStaff'])->name('pos.update_staff');
        Route::post('/delete_staff', [PosSecondPhaseController::class, 'deleteStaff'])->name('pos.delete_staff');
        Route::post('/check_staff_code', [PosSecondPhaseController::class, 'checkStaffCode'])->name('pos.check_staff_code');

        //Supplier
        Route::get('/supplier_list', [PosSecondPhaseController::class, 'getSupplierList'])->name('pos.supplier_list');
        Route::get('/create_supplier', [PosSecondPhaseController::class, 'getCreateSupplier'])->name('pos.create_supplier');
        Route::post('/change_state', [PosSecondPhaseController::class, 'changeState'])->name('pos.change_state');
        Route::post('/type_filter', [PosSecondPhaseController::class, 'typeFilter'])->name('pos.type_filter');
        Route::post('/store_supplier', [PosSecondPhaseController::class, 'storeSupplier'])->name('pos.store_supplier');
        Route::get('/edit_supplier/{id}', [PosSecondPhaseController::class, 'editSupplier'])->name('pos.edit_supplier');
        Route::post('/update_supplier/{id}', [PosSecondPhaseController::class, 'updateSupplier'])->name('pos.update_supplier');
        Route::post('/delete_supplier', [PosSecondPhaseController::class, 'deleteSupplier'])->name('pos.delete_supplier');

        //Return List
        Route::get('/return_list', [PosSecondPhaseController::class, 'ReturnList'])->name('pos.return_list');
        Route::get('/return_create', [PosSecondPhaseController::class, 'CreateReturn'])->name('pos.return_create');
        Route::post('/return_type_filter', [PosSecondPhaseController::class, 'returnTypeFilter'])->name('pos.return_type_filter');
        Route::post('/store_return', [PosSecondPhaseController::class, 'storeReturn'])->name('pos.store_return');
        Route::post('/delete_return', [PosSecondPhaseController::class, 'deleteReturn'])->name('pos.delete_return');
        Route::get('/edit_return/{id}', [PosSecondPhaseController::class, 'editReturn'])->name('pos.edit_return');
        Route::post('/update_return/{id}', [PosSecondPhaseController::class, 'updateReturn'])->name('pos.update_return');
        Route::post('/add_purchase_return', [PosSecondPhaseController::class, 'addPurchaseReturn'])->name('pos.add_purchase_return');

        // Filter
        Route::post('/sell_flag_filter', [PosSecondPhaseController::class, 'filterSellFlag'])->name('pos.sell_flag_filter');
        Route::post('/sold_filter', [PosSecondPhaseController::class, 'filterSold'])->name('pos.sold_filter');

        // Credit List
        Route::get('/credit_list', [PosSecondPhaseController::class, 'CreditList'])->name('pos.credit_list');
        Route::post('/credit_type_filter', [PosSecondPhaseController::class, 'credittypeFilter'])->name('pos.credit_type_filter');
        Route::post('/delete_credit', [PosSecondPhaseController::class, 'deleteCredit'])->name('pos.delete_credit');

        // Second Phase
        // Purchases
        Route::get('/purchase_lists', [PosSecondPhaseController::class, 'getPurchaseLists'])->name('pos.purchase_lists');

        // Sales
        Route::get('/sale_lists', [PosSecondPhaseController::class, 'getSaleLists'])->name('pos.sale_lists');
        Route::get('/famous_sale_lists', [PosSecondPhaseController::class, 'getFamousSaleLists'])->name('pos.famous_sale_lists');
        Route::post('/date_famous', [PosSecondPhaseController::class, 'filterFamousSaleLists'])->name('pos.date_famous');
        Route::get('/income_lists', [PosSecondPhaseController::class, 'getIncomeLists'])->name('pos.income_lists');
        Route::post('/tab_salelists', [PosSecondPhaseController::class, 'tabSaleLists'])->name('pos.tab_salelists');
        Route::post('/tab_incomelists', [PosSecondPhaseController::class, 'tabIncomeLists'])->name('pos.tab_incomelists');

        // Stock List
        Route::get('/stock_lists', [PosSecondPhaseController::class, 'getStockLists'])->name('pos.stock_lists');
        Route::post('/tab_stocklists', [PosSecondPhaseController::class, 'tabStockLists'])->name('pos.tab_stocklists');

        // Shop Profile
        Route::get('/shop_profile', [PosSecondPhaseController::class, 'getShopProfile'])->name('pos.shop_profile');
        Route::get('/shop_edit', [PosSecondPhaseController::class, 'getShopEdit'])->name('pos.shop_edit');
        Route::put('/shop_edit/{id}', [PosSecondPhaseController::class, 'ShopUpdate'])->name('pos.shop_update');
        Route::get('pos-change-password', [PosSecondPhaseController::class, 'getPassword']);
        Route::post('pos-change-password', [PosSecondPhaseController::class, 'changePassword'])->name('pos.change.password');
        Route::get('pos-update-password', [PosSecondPhaseController::class, 'editPassword']);
        Route::post('pos-update-password', [PosSecondPhaseController::class, 'storeNewPassword'])->name('pos.update.password');

    });

    // Activity
    Route::get('/product/activity/item', [ItemsController::class, 'item_activity_index'])->name('so_activity.p_product');
    Route::get('/product/activity/multiprice', [ItemsController::class, 'multiprice_activity_index'])->name('so_activity.p_multiprice');
    Route::get('/product/activity/multidiscount', [ItemsController::class, 'multidiscount_activity_index'])->name('so_activity.p_multidiscount');
    Route::get('/product/activity/multipercent', [ItemsController::class, 'multipercent_activity_index'])->name('so_activity.p_multipercent');

    Route::get('/user/activity/product', [ManagerController::class, 'u_product'])->name('so_activity.u_product');
    Route::get('/user/activity/role', [ManagerController::class, 'u_role'])->name('so_activity.u_role');

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


// Activity
Route::get('/product/activity/item', [ItemsController::class, 'item_activity_index'])->name('so_activity.p_product');
Route::get('/product/activity/multiprice', [ItemsController::class, 'multiprice_activity_index'])->name('so_activity.p_multiprice');
Route::get('/product/activity/multidiscount', [ItemsController::class, 'multidiscount_activity_index'])->name('so_activity.p_multidiscount');
Route::get('/product/activity/multipercent', [ItemsController::class, 'multipercent_activity_index'])->name('so_activity.p_multipercent');

Route::get('/user/activity/product', [ManagerController::class, 'u_product'])->name('so_activity.u_product');
Route::get('/user/activity/role', [ManagerController::class, 'u_role'])->name('so_activity.u_role');

// Point System
// Route::get('/user_points/add_price/', [ShopownerController::class, 'add_price'])->name('add_price');
Route::post('/user_points/add_price/', [ShopOwnerController::class, 'add_price_create'])->name('add_price.create');

});
