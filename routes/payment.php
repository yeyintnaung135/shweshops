<?php


Route::group(['prefix' => 'payment', 'as' => 'payment'], function () {

    Route::get('test',function(){
       $data= \Illuminate\Support\Facades\Http::get('https://staging.dinger.asia/payment-gateway-uat/api/token',[
           'projectName'=>'sannkyi staging',
           'apiKey'=>'m7v9vlk.eaOE1x3k9FnSH-Wm6QtdM1xxcEs',
           'merchantName'=>'mtktest'
       ]);
         return $data;
    });

    Route::post('pay','PaymentController@pay');
    Route::post('customizepay','PaymentController@customizepay');
    Route::get('order/{itemid}','PaymentController@order');
    Route::get('returnqrfromdinger/{orderid}','PaymentController@returnqrorappfromdinger');

});
?>
