<?php
Route::group(['prefix' => 'webservice', 'as' => 'backside.super_admin.'], function () {

    Route::post('storewspushapi', 'WebserviceController@storewspushapi');
    Route::get('checkhavefromserver', 'WebserviceController@checkhavefromserver');
    Route::get('checkhavefromserverfirebase', 'WebserviceController@checkhavefromserverfirebase');
    Route::post('storefirebasetoken', 'WebserviceController@storefirebasetoken');

});
?>
