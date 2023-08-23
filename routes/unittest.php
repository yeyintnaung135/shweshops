<?php

use App\frontuserlogs;
use App\Guestoruserid;
use App\Models\ForFirebase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

Route::get('testdigitalocean', function () {
    return Storage::disk('digitalocean')->get('shweshops/images/items/1680587196328_1672231655663_1669198955202_73.jpg');
});

Route::get('push', function () {
    $gettoken = ForFirebase::where('userid', 28)->first();

    $res = \Illuminate\Support\Facades\Http::withHeaders([
        'Authorization' => 'key=AAAAh_UhvDE:APA91bHwGqI5w4cFSYGjp1tCdJoshLNS58u8NFv5tMJBbV4X5rDp6K_WqP_CxyitkG4i_95OIhMzCgWaJK_AhiErPiE2V-tE4u7J77naN78B-t-BAAQ4hzCjFaJ_Fz3iSCZFIx_ZD18j',
        'Content-Type' => 'application/json',
    ])->post("https://fcm.googleapis.com/fcm/send", ['to' => $gettoken->token,

        'data' => ['title' => 'yeee ha', 'body' => 'ya hooo'],
        //'notification'  => $msg, (this caused the notification to deliver twice)

    ]);
    return $res;
});
Route::get('ff', function () {
    $img = Image::make('http://localhost/moe/public/images/items/16411836360.jpg')->resize(320, 240);

    return $img;
});
Route::get('unittest/fbmessenger', function () {

    $response = Http::withHeaders([
        'Content-Type' => "application/json",
    ])->get('https://graph.facebook.com/v16.0/m_hIVdk1rZMxyrvSCyRH08ygUXkRJoc8UfznmoFqUYHidDN7mMc2n2b8XL3yjvR46hKbFhldIt9X9pXOkpK6XWRA/shares?fields=template,link,id,name&access_token=EAAHrG0ta9TIBAGwxlRe42HlwsuqPgWmf2ZAlT0dWgEwzIUZBad5UGItR9Gc1yQTyhoXY85QxTQO9GK01tGyea7YAmt7HmHo9Mql2wMI8YU5evCp69igNq6VyeTb6dpIhZBQ5Ewo535MfGFPIYtXkVhvof1dJnpGtsEFRXwtwxK14YdTu342qmIdKUb5NZARcGGV44FvuhgZDZD');
    return $response;
});
Route::get('unittest/ffflist', function () {

    $response = Http::withHeaders([
        'Content-Type' => "application/json",
    ])->get('https://graph.facebook.com/v16.0/107646812265437/conversations?platform=MESSENGER&user_id=6236802633078602&access_token=EAAHrG0ta9TIBAGwxlRe42HlwsuqPgWmf2ZAlT0dWgEwzIUZBad5UGItR9Gc1yQTyhoXY85QxTQO9GK01tGyea7YAmt7HmHo9Mql2wMI8YU5evCp69igNq6VyeTb6dpIhZBQ5Ewo535MfGFPIYtXkVhvof1dJnpGtsEFRXwtwxK14YdTu342qmIdKUb5NZARcGGV44FvuhgZDZD');
    return $response;
});
Route::get('unittest/ccc', function () {

    $response = Http::withHeaders([
        'Content-Type' => "application/json",
    ])->get('https://graph.facebook.com/v16.0/t_5916880625098872?fields=messages&access_token=EAAHrG0ta9TIBAGwxlRe42HlwsuqPgWmf2ZAlT0dWgEwzIUZBad5UGItR9Gc1yQTyhoXY85QxTQO9GK01tGyea7YAmt7HmHo9Mql2wMI8YU5evCp69igNq6VyeTb6dpIhZBQ5Ewo535MfGFPIYtXkVhvof1dJnpGtsEFRXwtwxK14YdTu342qmIdKUb5NZARcGGV44FvuhgZDZD');
    return $response;
});
Route::get('xx', function () {
    return view('backend.super_admin.test');

});

Route::get('eventtest', function () {
    event(new \App\Events\Shopownermessage(['userid' => 'afefa', 'msg' => 'Hey want to buy this product']));
    return 'done';

});

Route::get('unit/deletebot', function () {
    $getbotf = frontuserlogs::all();
    $getbot = Guestoruserid::get();

//$getbotf=frontuserlogs::leftjoin('guestoruserid','guestoruserid.id','=','front_user_logs.userorguestid')->where('guestoruserid.user_agent','=','bot')->delete();
//    $getbot=Guestoruserid::where('user_agent','=','bot')->delete();

    return count($getbotf) . 'and guest' . count($getbot);

});

Route::get('unit/redistestget/{id}/ff', function ($id) {

    return \Illuminate\Support\Facades\Redis::get($id);

});
Route::get('unit/mongo/{id}/ff', function ($id) {

    $var = \Illuminate\Support\Facades\DB::connection('mongodb')->collection('messages')->insert(['e' => 'fefe']);
    return $var;
});
Route::get('unittest/checkuseragent', function () {

    $var = \Illuminate\Support\Facades\DB::table('guestoruserid')->get();
    foreach ($var as $v) {
        $check = \Illuminate\Support\Facades\DB::table('whatismybrowser_useragent')->where('user_agent', $v->user_agent)->first();

        if (!empty($check)) {
            echo $check->software_type . '<br>';

        } else {
            echo $v->id . '<br>';

        }

    }
});
Route::get('unittest/delete', function () {

    // $var = \Illuminate\Support\Facades\DB::table('front_user_logs')->get();
    // foreach ($var as $v) {
    //     $check = \Illuminate\Support\Facades\DB::table('guestoruserid')->where('id', $v->userorguestid);
    //     if (empty($check->first())) {
    //         \Illuminate\Support\Facades\DB::table('front_user_logs')->where('userorguestid', $v->userorguestid)->delete();
    //     }
    // }
    $unique_productclick = frontuserlogs::where('status', 'product_detail')->where('shop_id', 94)->where('product_id', '!=', 0)->get();
    return count($unique_productclick);
});

//Index static design (Arkar)
Route::get('unittest/index', 'IndexTest@index')->name('frontTest');
