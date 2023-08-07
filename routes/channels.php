<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('yankee.shopowner.channel.{to}', function ($user,$to) {
     return true;
},['guards'=>['shop_role','shop_owner']]);


Broadcast::channel('user.channel.{to}', function ($user) {
    return $user;
});
