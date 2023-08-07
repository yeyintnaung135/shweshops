<?php
//for superadmin

Route::group(['prefix' => 'backside/pos_super_admin', 'as' => 'backside.pos_super_admin.'], function () {
   
//    auth
Route::get('login', ['as' => 'login', 'uses' => 'Shopowner\PosSuperAdminController@loginform']);
Route::post('login', ['as' => 'logined', 'uses' => 'Shopowner\PosSuperAdminController@login']);
Route::post('logout', ['as' => 'logout', 'uses' => 'Shopowner\PosSuperAdminController@logout']);
// Dashboard
Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'Shopowner\PosSuperAdminController@getdashboard']);

});

//for shweshops_pos & pos_only shops 
Route::get('backside/pos_super_admin/shops/all','Shopowner\PosSuperAdminController@all')->name('pos_super_admin_shops.all');
Route::post('backside/pos_super_admin/shops/get_all_shops', 'Shopowner\PosSuperAdminController@getAllShops')->name('pos_super_admin_shops.dateFilterShops');
Route::get('backside/pos_super_admin/shops/create','Shopowner\PosSuperAdminController@shopcreate')->name('pos_super_admin_shops.create');
Route::post('backside/pos_super_admin/shops/register', 'Shopowner\PosSuperAdminController@shopstore')->name('pos_super_admin_shops.store');
Route::get('backside/pos_super_admin/shops/edit/{id}','Shopowner\PosSuperAdminController@shopedit')->name('pos_super_admin_shops.edit');
Route::put('backside/pos_super_admin/shops/edit/{id}','Shopowner\PosSuperAdminController@shopupdate')->name('pos_super_admin_shops.update');
Route::delete('backside/pos_super_admin/shops/delete/{id}','Shopowner\PosSuperAdminController@shoptrash')->name('pos_super_admin_shops.trash');
Route::get('backside/pos_super_admin/shop_detail/{id}','Shopowner\PosSuperAdminController@shopshow')->name('pos_super_admin_shops.detail');
Route::get('backside/pos_super_admin/get_township', 'Shopowner\PosSuperAdminController@gettownship');

//for pos_super_admin_role
Route::get('backside/pos_super_admin/admins/all','Shopowner\PosSuperAdminController@list')->name('pos_super_admin_role.list');
Route::get('backside/pos_super_admin/admins/create','Shopowner\PosSuperAdminController@create')->name('pos_super_admin_role.create');
Route::post('backside/pos_super_admin/admins/create','Shopowner\PosSuperAdminController@store')->name('pos_super_admin_role.store');
Route::get('backside/pos_super_admin/admins/edit/{id}','Shopowner\PosSuperAdminController@edit')->name('pos_super_admin_role.edit');
Route::put('backside/pos_super_admin/admins/edit/{id}','Shopowner\PosSuperAdminController@update')->name('pos_super_admin_role.update');
Route::delete('backside/pos_super_admin/admins/delete/{id}','Shopowner\PosSuperAdminController@delete')->name('pos_super_admin_role.delete');
?>
