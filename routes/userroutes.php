<?php

Route::group(['prefix' => 'user', 'as' => 'backside.user.'], function () {
    Route::get('profile', ['as' => 'user_profile', 'uses' => 'users\UserController@index']);
    Route::get('profile/edit/{id}', ['as' => 'edit', 'uses' => 'users\UserController@edit']);
    Route::put('profile/update/{id}', ['as' => 'update', 'uses' => 'users\UserController@update']);
    Route::put('profile/birthday_update/{id}', ['as' => 'birthday_update', 'uses' => 'users\UserController@birthday_update']);
    Route::post('user/whilist_point', ['as' => 'whilist.point', 'uses' => 'users\UserController@whislist_point']);
    Route::post('user/buy_now_point', ['as' => 'buy_now.point', 'uses' => 'users\UserController@buy_now_point']);
    Route::post('user/add_to_cart_point', ['as' => 'addtocart.point', 'uses' => 'users\UserController@add_to_cart_point']);
    
    Route::get('/logout', ['as' => 'logout', 'uses' => 'users\UserController@logout']);
    
});