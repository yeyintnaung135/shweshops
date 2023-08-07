<?php
Route::group(['prefix' => 'backside/shop_owner', 'as' => 'backside.shop_owner.'], function () {
    //    auth
            // Route::get('register', ['as' => 'register', 'uses' => 'Auth\ShopownerRegisterController@create']);
    Route::post('register', ['as' => 'registered', 'uses' => 'Auth\ShopownerRegisterController@store']);
    
    //    auth
    Route::get('/login/{from?}', ['as' => 'login', 'uses' => 'Auth\ShopownerLoginController@loginform']);

    Route::post('login', ['as' => 'logined', 'uses' => 'Auth\ShopownerLoginController@login']);


        //pos login & register form
    Route::get('/pos/login', ['as' => 'pos_login', 'uses' => 'Auth\ShopownerLoginController@pos_login_form'])->name('pos.login');
    Route::post('/pos/login', ['as' => 'pos_logined', 'uses' => 'Auth\ShopownerLoginController@pos_login']);
   
    // Route::post('/pos/register', ['as' => 'pos_registered', 'uses' => 'Auth\ShopownerLoginController@pos_register']);

    Route::post('/price_only_update', 'Shopowner\ItemsController@only_price_update')->name('price_only_update');

    //forgot password owner

    Route::get('pos/forgot_password', ['as' => 'forgot_password', 'uses' => 'Auth\YkforgotpasswordController@showLinkRequestForm']);
    Route::post('forgot_password', ['as' => 'send_reset_code', 'uses' => 'Auth\YkforgotpasswordController@send_reset_code_form']);

    Route::put('forgot_password', ['as' => 'send_reset_code', 'uses' => 'Auth\YkforgotpasswordController@codeCheck']);
    Route::post('add_new_password', ['as' => 'add_new_password', 'uses' => 'Auth\YkforgotpasswordController@add_new_password']);
    //reg ph confirmation
    Route::get('/support', 'Shopowner\ShopownersupportController@index');

    Route::post('/get_support_by_cat', 'Shopowner\ShopownersupportController@get_support_by_cat');
    Route::post('/get_support', 'Shopowner\ShopownersupportController@get_support');
    Route::resource('/', 'Shopowner\ShopownerController');
    Route::resource('/items', 'Shopowner\ItemsController');
    Route::get('/get_item_activity_log', 'Shopowner\ItemsController@getItemActivityLog')->name('items.getitems_activity_log');
    Route::get('/unique_get_item_activity_log', 'Shopowner\ShopownerController@uniquegetItemActivityLog')->name('items.uniquegetitems_activity_log');
    Route::get('/get_multiple_price_activity_log', 'Shopowner\ItemsController@getMultiplePriceActivityLog')->name('items.getmultiple_price_activity_log');
    Route::get('/get_multiple_discount_activity_log', 'Shopowner\ItemsController@getMultipleDiscountActivityLog')->name('items.getmultiple_discount_activity_log');
    Route::get('/get_multiple_damage_activity_log', 'Shopowner\ItemsController@getMultipleDamageActivityLog')->name('items.getmultiple_damage_activity_log');
    Route::get('/get_items', 'Shopowner\ItemsController@getItems')->name('items.getItems');
    Route::post('/getproductcodebytyping', 'Shopowner\ItemsController@getproductcodebytyping');

    Route::get('/items_trash', 'Shopowner\ItemsController@trash')->name('items.trash');
    Route::get('/get_items_trash', 'Shopowner\ItemsController@getitemsTrash')->name('items.getitemsTrash');
    Route::get('/items_trash/{id}', 'Shopowner\ItemsController@restore')->name('items.restore');
    Route::delete('/items_trash_delete/{id}', 'Shopowner\ItemsController@forceDelete')->name('items.forcedelete');

    // Route::get('/items_trash','Shopowner\ItemsController@trash')->name('items.trash');
    // Route::get('/items_trash/{id}','Shopowner\ItemsController@restore')->name('items.restore');
    // Route::get('/items_trash_delete/{id}','Shopowner\ItemsController@forceDelete')->name('items.forcedelete');
    Route::post('/multipe_discount', 'Shopowner\DiscountController@multiple_discount')->name('items.multiple.discount');
    Route::post('/multipe_unset_discount', 'Shopowner\DiscountController@multiple_unset_discount');
    Route::post('/multiple/plus', 'Shopowner\ItemsController@multiple_update_plus')->name('multiple_items.update_plus');
    Route::post('/multiple/minus', 'Shopowner\ItemsController@multiple_update_minus')->name('multiple_items.update_minus');
    Route::post('/multiple/recap', 'Shopowner\ItemsController@multiple_update_recap')->name('multiple_items.update_recap');
    Route::post('/multiple/stock', 'Shopowner\ItemsController@multiple_stock')->name('multiple.stock.items');
    Route::post('/multiple/checkpriceafterupdateclick', 'Shopowner\ItemsController@checkpriceafterupdateclick')->name('multiple_items.checkpriceafterupdateclick');
    Route::post('/multiple/checkpriceafterdiscountclick', 'Shopowner\DiscountController@checkpriceafterdiscountclick')->name('multiple_items.checkpriceafterdiscountclick');

    //template
    Route::get('/template/create', 'Shopowner\TemplateController@create')->name('items.template.create');
    Route::get('/template/get_template', 'Shopowner\TemplateController@get_template')->name('template.get_template');
    Route::get('/templates', 'Shopowner\TemplateController@index')->name('items.template.list');
    Route::post('/template/create', 'Shopowner\TemplateController@store')->name('items.template.store');
    Route::get('/templates/edit/{id}', 'Shopowner\TemplateController@edit')->name('template.edit');
    Route::patch('/templates/update/{id}', 'Shopowner\TemplateController@update')->name('items.template.update');

    Route::get('/templates/trash/{id}', 'Shopowner\TemplateController@destroy')->name('template.destroy');

    // manager
    Route::get('/users', 'Shopowner\ManagerController@list');
    // for user datable
    Route::get('/get_users_activity_log', 'Shopowner\ManagerController@getUsersActivityLog')->name('users.getusers_activity_Log');
    Route::get('/get_backrole', 'Shopowner\ManagerController@getbackroleActivity')->name('getbackrole');
    Route::get('/get_backrole/detail', 'Shopowner\ManagerController@getbackroleActivityDetail')->name('getbackrole.detail');
    Route::get('/get_itemedit/detail', 'Shopowner\ManagerController@getitemeditActivityDetail')->name('getitemedit.detail');
    Route::get('/get_backroleedit/{id}', 'Shopowner\ManagerController@backRoleEditDetail')->name('backroleedit');
    Route::get('/get_users', 'Shopowner\ManagerController@getUsers')->name('getUsers');
    Route::get('/users/create', 'Shopowner\ManagerController@create');
    Route::post('/users/create', 'Shopowner\ManagerController@store');
    Route::get('/users/edit/{id}', ['as' => 'managers.edit', 'uses' => 'Shopowner\ManagerController@edit']);
    Route::put('/users/edit/{id}', ['as' => 'managers.update', 'uses' => 'Shopowner\ManagerController@update']);
    Route::get('/users/detail/{id}', ['as' => 'managers.detail', 'uses' => 'Shopowner\ManagerController@detail']);
    Route::delete('/users/remove_user/{id}', ['as' => 'managers.remove_user', 'uses' => 'Shopowner\ManagerController@removeuser']);
    Route::get('/users/trash', ['as' => 'managers.restore_list', 'uses' => 'Shopowner\ManagerController@trash']);
    Route::get('/users/restore/{id}', ['as' => 'managers.restore', 'uses' => 'Shopowner\ManagerController@restore']);

    Route::get('/detail', ['as' => 'detail', 'uses' => 'Shopowner\ShopownerController@detail']);
    Route::get('/detail/shop_view', ['as' => 'detail.shop_view', 'uses' => 'Shopowner\ShopownerController@shopview']);
    Route::get('/detail/product_view', ['as' => 'detail.product_view', 'uses' => 'Shopowner\ShopownerController@productview']);
    Route::get('/detail/buy_now_click', ['as' => 'detail.buy_now_click', 'uses' => 'Shopowner\ShopownerController@buynowclick']);
    Route::get('/detail/unique_add_to_cart_click', ['as' => 'detail.unique_add_to_cart_click', 'uses' => 'Shopowner\ShopownerController@uniqueaddtocartclick']);
    Route::get('/detail/unique_whishlist_click', ['as' => 'detail.unique_whishlist_click', 'uses' => 'Shopowner\ShopownerController@uniquewhishlistclick']);
    Route::get('/detail/unique_ads_view', ['as' => 'detail.unique_ads_view', 'uses' => 'Shopowner\ShopownerController@uniqueadsview']);
    Route::get('/detail/unique_product_view', ['as' => 'detail.unique_product_view', 'uses' => 'Shopowner\ShopownerController@uniqueproductview']);
    Route::get('/detail/product_discount_view', ['as' => 'detail.product_discount_view', 'uses' => 'Shopowner\ShopownerController@discountproductview']);
    Route::get('/detail/get_shop_view', ['as' => 'detail.get_shop_view', 'uses' => 'Shopowner\ShopownerController@getshopownerview']);
    Route::get('/detail/get_buy_now_click', ['as' => 'detail.get_buy_now_click', 'uses' => 'Shopowner\ShopownerController@getbuynowclick']);
    Route::get('/detail/get_unique_add_to_cart_click', ['as' => 'detail.get_unique_add_to_cart_click', 'uses' => 'Shopowner\ShopownerController@getuniqueaddtocartclick']);
    Route::get('/detail/get_unique_whishlist_click', ['as' => 'detail.get_unique_whishlist_click', 'uses' => 'Shopowner\ShopownerController@getuniquewhishlistclick']);
    Route::get('/detail/get_unique_ads_view', ['as' => 'detail.get_unique_ads_view', 'uses' => 'Shopowner\ShopownerController@getuniqueadsview']);
    Route::get('/detail/get_discount_product_view', ['as' => 'detail.get_discount_product_view', 'uses' => 'Shopowner\ShopownerController@getdiscountproductview']);
    Route::get('/shop', ['as' => 'shop_detail', 'uses' => 'Shopowner\ShopownerController@shopdetail']);
    Route::put('/detail', ['as' => 'detail.update', 'uses' => 'Shopowner\ItemsController@fromDetailEdit']);

    Route::get('/edit', ['as' => 'edit', 'uses' => 'Shopowner\ShopownerController@edit']);
    Route::put('/edit/{id}', ['as' => 'update', 'uses' => 'Shopowner\ShopownerController@update']);

    Route::post('editajax', ['as' => 'editajax', 'uses' => 'Shopowner\ItemsController@editajax']);

    Route::post('customedit', ['as' => 'customedit', 'uses' => 'Shopowner\ItemsController@customedit']);
    Route::post('removeimage', ['as' => 'removeimage', 'uses' => 'Shopowner\ItemsController@removeimage']);

    Route::get('change-password', 'ChangePasswordController@index');
    Route::post('change-password', 'ChangePasswordController@store')->name('change.password');

    Route::get('update-password', 'UpdatePasswordController@index');
    Route::post('update-password', 'UpdatePasswordController@store')->name('update.password');

    Route::get('/item/discount/{id}', 'Shopowner\DiscountController@discount');
    Route::post('/item/discount/{id}', 'Shopowner\DiscountController@discount_save');
    Route::get('/item/discount_list', 'Shopowner\DiscountController@list');
    // Route::get('/item/discount_list', 'Shopowner\DiscountController@getDiscountItems')->name('discount.getDiscountItems');
    Route::delete('/item/discount_remove', 'Shopowner\DiscountController@remove');
    Route::get('/item/get_discount_items', 'Shopowner\DiscountController@getDiscountItems')->name('getDiscountItems');

    //Premium Features
    Route::group(['middleware' => ['auth:shop_owner,shop_role']], function () {
        //collection
        Route::get('/collections/items/{collection}', 'Shopowner\CollectionController@collectionItems')
            ->name('collections.items');

        Route::post('/collections/items/add/{collection}', 'Shopowner\CollectionController@addItem')->name('collections.item.add');

        Route::delete('/collections/remove-item', 'Shopowner\CollectionController@removeItem')
            ->name('collections.remove.item');

        //collection datatable
        Route::get('/collections/get-collections', 'Shopowner\CollectionController@getCollections')
            ->name('collections.getCollections');

        Route::get('/collections/get-collection-items', 'Shopowner\CollectionController@getCollectionItems')
            ->name('collections.getCollectionItems');

        Route::get('/collections/get-items', 'Shopowner\CollectionController@getItems')
            ->name('collections.getItems');

        //news datatable
        Route::get('/news/get-all-news', 'Shopowner\NewsController@getAllNews')
            ->name('news.getAllNews');

        //event datatable
        Route::get('/events/get-events', 'Shopowner\EventController@getEvents')
            ->name('events.getEvents');

        Route::resources([
            'collections' => 'Shopowner\CollectionController',
            'news' => 'Shopowner\NewsController',
            'events' => 'Shopowner\EventController',
        ]);
        //activity
        Route::get('/product/activity/item', 'Shopowner\ItemsController@item_activity_index')->name('so_activity.p_product');
        Route::get('/product/activity/multiprice', 'Shopowner\ItemsController@multiprice_activity_index')->name('so_activity.p_multiprice');
        Route::get('/product/activity/multidiscount', 'Shopowner\ItemsController@multidiscount_activity_index')->name('so_activity.p_multidiscount');
        Route::get('/product/activity/multipercent', 'Shopowner\ItemsController@multipercent_activity_index')->name('so_activity.p_multipercent');

        Route::get('/user/activity/product', 'Shopowner\ManagerController@u_product')->name('so_activity.u_product');
        Route::get('/user/activity/role', 'Shopowner\ManagerController@u_role')->name('so_activity.u_role');

        /** Point System */
        // Route::get('/user_points/add_price/','Shopowner\ShopownerController@add_price')->name('add_price');
        Route::post('/user_points/add_price/','Shopowner\ShopownerController@add_price_create')->name('add_price.create');
    });
 //Start POS//
 Route::group(['middleware' => ['web', 'foratc']],
    function () {
    Route::get('/dashboard', 'Shopowner\PosController@getDashBoard')->name('pos.dashboard');
    Route::post('/totalamount', 'Shopowner\PosController@getTotalAmount')->name('pos.totalamount');
    Route::post('/goldprice', 'Shopowner\PosController@getGoldPrice')->name('pos.goldprice');

    //Purchase
        //gold
    Route::get('/purchase_list', 'Shopowner\PosController@getPurchaseList')->name('pos.purchase_list');
    Route::post('/gold_type_filter', 'Shopowner\PosController@goldtypeFilter')->name('pos.gold_type_filter');
    Route::post('/gold_advance_filter', 'Shopowner\PosController@goldadvanceFilter')->name('pos.gold_advance_filter');
    Route::get('/create_purchase', 'Shopowner\PosController@createPurchase')->name('pos.create_purchase');
    Route::post('/store_purchase', 'Shopowner\PosController@storePurchase')->name('pos.store_purchase');
    Route::post('/puchase_code', 'Shopowner\PosController@getPurchaseCode')->name('pos.codegenerate');
    Route::post('/quality_price', 'Shopowner\PosController@getQualityPrice')->name('pos.quality_gold_price');
    Route::post('/delete_purchase', 'Shopowner\PosController@deletePurchase')->name('pos.delete_purchase');
    Route::get('/edit_purchase/{id}', 'Shopowner\PosController@editPurchase')->name('pos.edit_purchase');
    Route::post('/update_purchase/{id}', 'Shopowner\PosController@updatePurchase')->name('pos.update_purchase');
    Route::get('/detail_purchase/{id}', 'Shopowner\PosController@detailPurchase')->name('pos.detail_purchase');
        //kyout
    Route::get('/kpurchase_list', 'Shopowner\PosController@getKyoutPurchaseList')->name('pos.kyout_purchase_list');
    Route::post('/kyout_type_filter', 'Shopowner\PosController@kyouttypeFilter')->name('pos.kyout_type_filter');
    Route::post('/kyout_advance_filter', 'Shopowner\PosController@kyoutadvanceFilter')->name('pos.kyout_advance_filter');
    Route::get('/create_kpurchase', 'Shopowner\PosController@createKyoutPurchase')->name('pos.create_kyout_purchase');
    Route::post('/store_kpurchase', 'Shopowner\PosController@storeKyoutPurchase')->name('pos.store_kyout_purchase');
    Route::post('/fill_phno', 'Shopowner\PosController@getPhone')->name('pos.fill_phno');
    Route::post('/delete_kyout_purchase', 'Shopowner\PosController@deleteKyoutPurchase')->name('pos.delete_kyout_purchase');
    Route::get('/edit_kyout_purchase/{id}', 'Shopowner\PosController@editKyoutPurchase')->name('pos.edit_kyout_purchase');
    Route::post('/update_kyout_purchase/{id}', 'Shopowner\PosController@updateKyoutPurchase')->name('pos.update_kyout_purchase');
    Route::get('/detail_kyout_purchase/{id}', 'Shopowner\PosController@detailKyoutPurchase')->name('pos.detail_kyout_purchase');
        //platinum
    Route::get('/ptmpurchase_list', 'Shopowner\PosController@getPtmPurchaseList')->name('pos.ptm_purchase_list');
    Route::post('/platinum_type_filter', 'Shopowner\PosController@ptmtypeFilter')->name('pos.ptm_type_filter');
    Route::post('/platinum_advance_filter', 'Shopowner\PosController@platinumadvanceFilter')->name('pos.platinum_advance_filter');
    Route::get('/create_platinum_purchase', 'Shopowner\PosController@createPtmPurchase')->name('pos.create_ptm_purchase');
    Route::post('/quality_ptm_price', 'Shopowner\PosController@getPtmQualityPrice')->name('pos.quality_ptm_price');
    Route::post('/store_platinum_purchase', 'Shopowner\PosController@storePtmPurchase')->name('pos.store_ptm_purchase');
    Route::post('/delete_ptm_purchase', 'Shopowner\PosController@deletePtmPurchase')->name('pos.delete_ptm_purchase');
    Route::get('/edit_platinum_purchase/{id}', 'Shopowner\PosController@editPtmPurchase')->name('pos.edit_ptm_purchase');
    Route::post('/update_platinum_purchase/{id}', 'Shopowner\PosController@updatePtmPurchase')->name('pos.update_ptm_purchase');
    Route::get('/detail_platinum_purchase/{id}', 'Shopowner\PosController@detailPtmPurchase')->name('pos.detail_ptm_purchase');
        //whitegold
    Route::get('/wgpurchase_list', 'Shopowner\PosController@getWgPurchaseList')->name('pos.wg_purchase_list');
    Route::post('/whitegold_type_filter', 'Shopowner\PosController@wgtypeFilter')->name('pos.wg_type_filter');
    Route::post('/whitegold_advance_filter', 'Shopowner\PosController@whitegoldadvanceFilter')->name('pos.whitegold_advance_filter');
    Route::get('/create_whitegold_purchase', 'Shopowner\PosController@createWgPurchase')->name('pos.create_wg_purchase');
    Route::post('/quality_wg_price', 'Shopowner\PosController@getWgQualityPrice')->name('pos.quality_wg_price');
    Route::post('/store_whitegold_purchase', 'Shopowner\PosController@storeWgPurchase')->name('pos.store_wg_purchase');
    Route::post('/delete_wg_purchase', 'Shopowner\PosController@deleteWgPurchase')->name('pos.delete_wg_purchase');
    Route::get('/edit_whitegold_purchase/{id}', 'Shopowner\PosController@editWgPurchase')->name('pos.edit_wg_purchase');
    Route::post('/update_whitegold_purchase/{id}', 'Shopowner\PosController@updateWgPurchase')->name('pos.update_wg_purchase');
    Route::get('/detail_whitegold_purchase/{id}', 'Shopowner\PosController@detailWgPurchase')->name('pos.detail_wg_purchase');

    //Sale
      //gold
    Route::get('/gold_sale_list', 'Shopowner\PosController@saleGoldList')->name('pos.gold_sale_list');
    Route::post('/goldsale_type_filter', 'Shopowner\PosController@goldsaletypeFilter')->name('pos.goldsale_type_filter');
    Route::post('/goldsale_advance_filter', 'Shopowner\PosController@goldsaleadvanceFilter')->name('pos.goldsale_advance_filter');
    Route::get('/edit_goldsale/{id}', 'Shopowner\PosController@editGoldSale')->name('pos.edit_goldsale');
    Route::post('/update_sale_gold/{id}', 'Shopowner\PosController@updateGoldSale')->name('pos.update_sale_gold');
    Route::post('/delete_goldsale', 'Shopowner\PosController@deleteGoldSale')->name('pos.delete_goldsale');
    Route::get('/sale_purchase', 'Shopowner\PosController@salePurchase')->name('pos.slae_purchase');
    Route::post('/get_sale_values', 'Shopowner\PosController@getSaleValues')->name('pos.getSaleValues');
    Route::post('/sale_gold', 'Shopowner\PosController@storeGoldSale')->name('pos.store_sale_gold');
    Route::get('/detail_goldsale/{id}', 'Shopowner\PosController@detailGoldSale')->name('pos.detail_goldsale');
       //kyout
    Route::get('/sale_kyout_list', 'Shopowner\PosController@saleKyoutList')->name('pos.sale_kyout_list');
    Route::post('/kyoutsale_type_filter', 'Shopowner\PosController@kyoutsaletypeFilter')->name('pos.kyoutsale_type_filter');
    Route::post('/kyoutsale_advance_filter', 'Shopowner\PosController@kyoutsaleadvanceFilter')->name('pos.kyoutsale_advance_filter');
    Route::get('/edit_kyoutsale/{id}', 'Shopowner\PosController@editKyoutSale')->name('pos.edit_kyoutsale');
    Route::post('/update_sale_kyout/{id}', 'Shopowner\PosController@updateKyoutSale')->name('pos.update_sale_kyout');
    Route::post('/delete_kyoutsale', 'Shopowner\PosController@deleteKyoutSale')->name('pos.delete_kyoutsale');
    Route::get('/sale_kyout_purchase', 'Shopowner\PosController@saleKPurchase')->name('pos.sale_kyout_purchase');
    Route::post('/get_sale_kvalues', 'Shopowner\PosController@getSaleKValues')->name('pos.getSaleKValues');
    Route::post('/sale_kyout', 'Shopowner\PosController@storeKyoutSale')->name('pos.store_sale_kyout');
    Route::get('/detail_kyoutsale/{id}', 'Shopowner\PosController@detailKyoutSale')->name('pos.detail_kyoutsale');
       //platinum
    Route::get('/ptm_sale_list', 'Shopowner\PosController@salePtmList')->name('pos.ptm_sale_list');
    Route::post('/delete_ptm_sale', 'Shopowner\PosController@deletePtmSale')->name('pos.delete_ptm_sale');
    Route::post('/update_sale_platinum/{id}', 'Shopowner\PosController@updatePlatinumSale')->name('pos.update_sale_platinum');
    Route::get('/edit_ptmsale/{id}', 'Shopowner\PosController@editPtmSale')->name('pos.edit_ptmsale');
    Route::post('/platinumsale_advance_filter', 'Shopowner\PosController@platinumsaleadvanceFilter')->name('pos.platinumsale_advance_filter');
    Route::post('/platinumsale_type_filter', 'Shopowner\PosController@ptmsaletypeFilter')->name('pos.ptmsale_type_filter');
    Route::get('/sale_platinum_purchase', 'Shopowner\PosController@salePtmPurchase')->name('pos.sale_ptm_purchase');
    Route::post('/get_sale_pvalues', 'Shopowner\PosController@getSalePtmValues')->name('pos.getSalePtmValues');
    Route::post('/sale_platinum', 'Shopowner\PosController@storePlatinumSale')->name('pos.store_sale_platinum');
    Route::get('/detail_ptmsale/{id}', 'Shopowner\PosController@detailPlatinumSale')->name('pos.detail_ptmsale');
       //whitegold
    Route::get('/wg_sale_list', 'Shopowner\PosController@saleWgList')->name('pos.wg_sale_list');
    Route::post('/delete_wg_sale', 'Shopowner\PosController@deleteWgSale')->name('pos.delete_wg_sale');
    Route::post('/update_sale_whitegold/{id}', 'Shopowner\PosController@updateWhiteGoldSale')->name('pos.update_sale_whitegold');
    Route::get('/edit_wgsale/{id}', 'Shopowner\PosController@editWgSale')->name('pos.edit_wgsale');
    Route::post('/whitegoldsale_advance_filter', 'Shopowner\PosController@whitegoldsaleadvanceFilter')->name('pos.whitegoldsale_advance_filter');
    Route::post('/whitegoldsale_type_filter', 'Shopowner\PosController@wgsaletypeFilter')->name('pos.wgsale_type_filter');
    Route::get('/sale_whitegold_purchase', 'Shopowner\PosController@saleWgPurchase')->name('pos.sale_wg_purchase');
    Route::post('/get_sale_wgvalues', 'Shopowner\PosController@getSaleWgValues')->name('pos.getSaleWgValues');
    Route::post('/sale_whitegold', 'Shopowner\PosController@storeWhiteGoldSale')->name('pos.store_sale_whitegold');
    Route::get('/detail_wgsale/{id}', 'Shopowner\PosController@detailWhiteGoldSale')->name('pos.detail_wg_sale');

    //Diamond List
    Route::get('/diamond_list', 'Shopowner\PosController@getDiamondList')->name('pos.diamond_list');
    Route::get('/create_diamond', 'Shopowner\PosController@getCreateDiamond')->name('pos.create_diamond');
    Route::post('/diamond_type_filter', 'Shopowner\PosController@diamondtypeFilter')->name('pos.diamond_type_filter');
    Route::post('/store_diamond', 'Shopowner\PosController@storeDiamond')->name('pos.store_diamond');
    Route::get('/edit_diamond/{id}', 'Shopowner\PosController@editDiamond')->name('pos.edit_diamond');
    Route::post('/update_diamond/{id}', 'Shopowner\PosController@updateDiamond')->name('pos.update_diamond');
    Route::post('/delete_diamond', 'Shopowner\PosController@deleteDiamond')->name('pos.delete_diamond');

    //Counter Shop List
    Route::get('/countershop_list', 'Shopowner\PosController@getCounterList')->name('pos.counter_list');
    Route::get('/create_counter', 'Shopowner\PosController@createCounter')->name('pos.create_counter');
    Route::post('/counter_type_filter', 'Shopowner\PosController@counterTypeFilter')->name('pos.counter_type_filter');
    Route::post('/store_counter', 'Shopowner\PosController@storeCounter')->name('pos.store_counter');
    Route::get('/edit_counter/{id}', 'Shopowner\PosController@editCounter')->name('pos.edit_counter');
    Route::post('/update_counter/{id}', 'Shopowner\PosController@updateCounter')->name('pos.update_counter');
    Route::post('/delete_counter', 'Shopowner\PosController@deleteCounter')->name('pos.delete_counter');

    //Assign Gold Price
    Route::get('/assign_gold', 'Shopowner\PosController@getAssignGold')->name('pos.assign_gold_list');
    Route::post('/assign_gold_price', 'Shopowner\PosController@getAssignGoldPrice')->name('pos.assign_gold_price');
    Route::post('/update_assign_gold_price/{id}', 'Shopowner\PosController@updateAssignGoldPrice')->name('pos.update_assign_gold_price');

    //Assign Platinum
    Route::get('/assign_platinum', 'Shopowner\PosController@getAssignPlatinum')->name('pos.assign_platinum_list');
    Route::get('/assign_platinum_price', 'Shopowner\PosController@getAssignPlatinumPrice')->name('pos.assign_platinum_price');
    Route::post('/store_assign_platinum_price', 'Shopowner\PosController@storeAssignPlatinumPrice')->name('pos.store_assign_platinum_price');
    Route::post('/update_assign_platinum_price/{id}', 'Shopowner\PosController@updateAssignPlatinumPrice')->name('pos.update_assign_platinum_price');

    //Assign WhiteGold
    Route::get('/assign_whitegold', 'Shopowner\PosController@getAssignWhiteGold')->name('pos.assign_whitegold_list');
    Route::get('/assign_whitegold_price', 'Shopowner\PosController@getAssignWhiteGoldPrice')->name('pos.assign_whitegold_price');
    Route::post('/store_assign_whitegold_price', 'Shopowner\PosController@storeAssignWhiteGoldPrice')->name('pos.store_assign_whitegold_price');
    Route::post('/update_assign_whitegold_price/{id}', 'Shopowner\PosController@updateAssignWhiteGoldPrice')->name('pos.update_assign_whitegold_price');

    //Staff List
    Route::get('/staff_list', 'Shopowner\PosSecondPhaseController@getStaffList')->name('pos.staff_list');
    Route::get('/create_staff', 'Shopowner\PosSecondPhaseController@getCreateStaff')->name('pos.create_staff');
    Route::post('/staff_type_filter', 'Shopowner\PosSecondPhaseController@staffTypeFilter')->name('pos.staff_type_filter');
    Route::post('/store_staff', 'Shopowner\PosSecondPhaseController@storeStaff')->name('pos.store_staff');
    Route::get('/edit_staff/{id}', 'Shopowner\PosSecondPhaseController@editStaff')->name('pos.edit_staff');
    Route::post('/update_staff/{id}', 'Shopowner\PosSecondPhaseController@updateStaff')->name('pos.update_staff');
    Route::post('/delete_staff', 'Shopowner\PosSecondPhaseController@deleteStaff')->name('pos.delete_staff');
    Route::post('/check_staff_code', 'Shopowner\PosSecondPhaseController@checkStaffCode')->name('pos.check_staff_code');

    //Supplier
    Route::get('/supplier_list', 'Shopowner\PosSecondPhaseController@getSupplierList')->name('pos.supplier_list');
    Route::get('/create_supplier', 'Shopowner\PosSecondPhaseController@getCreateSupplier')->name('pos.create_supplier');
    Route::post('/change_state', 'Shopowner\PosSecondPhaseController@changeState')->name('pos.change_state');
    Route::post('/type_filter', 'Shopowner\PosSecondPhaseController@typeFilter')->name('pos.type_filter');
    Route::post('/store_supplier', 'Shopowner\PosSecondPhaseController@storeSupplier')->name('pos.store_supplier');
    Route::get('/edit_supplier/{id}', 'Shopowner\PosSecondPhaseController@editSupplier')->name('pos.edit_supplier');
    Route::post('/update_supplier/{id}', 'Shopowner\PosSecondPhaseController@updateSupplier')->name('pos.update_supplier');
    Route::post('/delete_supplier', 'Shopowner\PosSecondPhaseController@deleteSupplier')->name('pos.delete_supplier');

    //Return List
    Route::get('/return_list', 'Shopowner\PosSecondPhaseController@ReturnList')->name('pos.return_list');
    Route::get('/return_create', 'Shopowner\PosSecondPhaseController@CreateReturn')->name('pos.return_create');
    Route::post('/return_type_filter', 'Shopowner\PosSecondPhaseController@returnTypeFilter')->name('pos.return_type_filter');
    Route::post('/store_return', 'Shopowner\PosSecondPhaseController@storeReturn')->name('pos.store_return');
    Route::post('/delete_return', 'Shopowner\PosSecondPhaseController@deleteReturn')->name('pos.delete_return');
    Route::get('/edit_return/{id}', 'Shopowner\PosSecondPhaseController@editReturn')->name('pos.edit_return');
    Route::post('/update_return/{id}', 'Shopowner\PosSecondPhaseController@updateReturn')->name('pos.update_return');
    Route::post('/add_purchase_return', 'Shopowner\PosSecondPhaseController@addPurchaseReturn')->name('pos.add_purchase_return');

    //Filter
    Route::post('/sell_flag_filter', 'Shopowner\PosSecondPhaseController@filterSellFlag')->name('pos.sell_flag_filter');
    Route::post('/sold_filter', 'Shopowner\PosSecondPhaseController@filterSold')->name('pos.sold_filter');

    //Credit List
    Route::get('/credit_list', 'Shopowner\PosSecondPhaseController@CreditList')->name('pos.credit_list');
    Route::post('/credit_type_filter', 'Shopowner\PosSecondPhaseController@credittypeFilter')->name('pos.credit_type_filter');
    Route::post('/delete_credit', 'Shopowner\PosSecondPhaseController@deleteCredit')->name('pos.delete_credit');

    //Second Phase 
    //Purchases
    Route::get('/purchase_lists', 'Shopowner\PosSecondPhaseController@getPurchaseLists')->name('pos.purchase_lists');
    //Sales
    Route::get('/sale_lists', 'Shopowner\PosSecondPhaseController@getSaleLists')->name('pos.sale_lists');
    Route::get('/famous_sale_lists', 'Shopowner\PosSecondPhaseController@getFamousSaleLists')->name('pos.famous_sale_lists');
    Route::post('/date_famous', 'Shopowner\PosSecondPhaseController@filterFamousSaleLists')->name('pos.date_famous');
    Route::get('/income_lists', 'Shopowner\PosSecondPhaseController@getIncomeLists')->name('pos.income_lists');
    Route::post('/tab_salelists', 'Shopowner\PosSecondPhaseController@tabSaleLists')->name('pos.tab_salelists');
    Route::post('/tab_incomelists', 'Shopowner\PosSecondPhaseController@tabIncomeLists')->name('pos.tab_incomelists');
    //Stock List
    Route::get('/stock_lists', 'Shopowner\PosSecondPhaseController@getStockLists')->name('pos.stock_lists');
    Route::post('/tab_stocklists', 'Shopowner\PosSecondPhaseController@tabStockLists')->name('pos.tab_stocklists');
    //Shop Profile
    Route::get('/shop_profile', 'Shopowner\PosSecondPhaseController@getShopProfile')->name('pos.shop_profile');
    Route::get('/shop_edit', 'Shopowner\PosSecondPhaseController@getShopEdit')->name('pos.shop_edit');
    Route::put('/shop_edit/{id}','Shopowner\PosSecondPhaseController@ShopUpdate')->name('pos.shop_update');
    Route::get('pos-change-password', 'Shopowner\PosSecondPhaseController@getPassword');
    Route::post('pos-change-password', 'Shopowner\PosSecondPhaseController@changePassword')->name('pos.change.password');
    Route::get('pos-update-password', 'Shopowner\PosSecondPhaseController@editPassword');
    Route::post('pos-update-password', 'Shopowner\PosSecondPhaseController@storeNewPassword')->name('pos.update.password');
    });

    //activity
    Route::get('/product/activity/item', 'Shopowner\ItemsController@item_activity_index')->name('so_activity.p_product');
    Route::get('/product/activity/multiprice', 'Shopowner\ItemsController@multiprice_activity_index')->name('so_activity.p_multiprice');
    Route::get('/product/activity/multidiscount', 'Shopowner\ItemsController@multidiscount_activity_index')->name('so_activity.p_multidiscount');
    Route::get('/product/activity/multipercent', 'Shopowner\ItemsController@multipercent_activity_index')->name('so_activity.p_multipercent');

    Route::get('/user/activity/product', 'Shopowner\ManagerController@u_product')->name('so_activity.u_product');
    Route::get('/user/activity/role', 'Shopowner\ManagerController@u_role')->name('so_activity.u_role');

    //popup ads
    Route::get('/ads/main_popup', 'Shopowner\PopupAdsController@main_popup')->name('ads.main_popup');
    Route::post('/ads/main_popup/upload', 'Shopowner\PopupAdsController@main_popup_upload')->name('ads.main_popup_upload');
    Route::get('/ads/main_popup/delete', 'Shopowner\PopupAdsController@main_popup_delete')->name('ads.main_popup_delete');
    //opening times
    Route::get('/opening_times', 'Shopowner\OpeningTimesController@opening_times')->name('opening_times');
    Route::post('/opening_times/upload', 'Shopowner\OpeningTimesController@opening_times_upload')->name('opening_times_upload');
    Route::get('/opening_times/delete', 'Shopowner\OpeningTimesController@opening_times_delete')->name('opening_times_delete');

    /** Point System */
    // Route::get('/user_points/add_price/','Shopowner\ShopownerController@add_price')->name('add_price');
    Route::post('/user_points/add_price/', 'Shopowner\ShopownerController@add_price_create')->name('add_price.create');

  

    Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\ShopownerLoginController@logout']);

    //App File Download
    Route::get('/app-files/android', 'Shopowner\AppDownloadController@android')
        ->name('app-files.android');

    Route::get('/app-files/download/{appFile}', 'Shopowner\AppDownloadController@download')->name('app-files.download');

    //message
    Route::post('/sendmessage', 'message\UsermessageController@sendmessagetoshopowner');
    Route::post('/sendimagemessage', 'message\UsermessageController@sendimagemessagetoshopowner');
    Route::get('/chatpannel', 'message\MessageController@chatpannel');
    Route::post('/sendmessagetouser', 'message\MessageController@sendmessagetouser');
    Route::get('/getshopschatslist', 'message\MessageController@getshopschatslist');
    Route::get('gettotalchatcountforshop', 'message\MessageController@gettotalchatcountforshop');
    Route::get('getspecificchatcountforshop/{user_id}', 'message\MessageController@getspecificchatcountforshop');
    Route::post('/getcurrentchatuser', 'message\MessageController@getcurrentchatuser');
    Route::post('/sendwhatshopisactive', 'message\MessageController@sendwhatshopisactive');
    Route::post('/setreadbyshop', 'message\MessageController@setreadbyshop');
    Route::post('/sendwhatshopisoffline', 'message\MessageController@sendwhatshopisoffline');
    Route::post('/sendwhatshopisofflinefromcustomer', 'message\UsermessageController@sendwhatshopisoffline');

    //firebase noti

    Route::post('/storefirebasetokenforshop', 'message\MessageController@storefirebasetokenforshop');

    //activity
    Route::get('/product/activity/item', 'Shopowner\ItemsController@item_activity_index')->name('so_activity.p_product');
    Route::get('/product/activity/multiprice', 'Shopowner\ItemsController@multiprice_activity_index')->name('so_activity.p_multiprice');
    Route::get('/product/activity/multidiscount', 'Shopowner\ItemsController@multidiscount_activity_index')->name('so_activity.p_multidiscount');
    Route::get('/product/activity/multipercent', 'Shopowner\ItemsController@multipercent_activity_index')->name('so_activity.p_multipercent');

    Route::get('/user/activity/product', 'Shopowner\ManagerController@u_product')->name('so_activity.u_product');
    Route::get('/user/activity/role', 'Shopowner\ManagerController@u_role')->name('so_activity.u_role');

    /** Point System */
    // Route::get('/user_points/add_price/','Shopowner\ShopownerController@add_price')->name('add_price');
    Route::post('/user_points/add_price/', 'Shopowner\ShopownerController@add_price_create')->name('add_price.create');


});
