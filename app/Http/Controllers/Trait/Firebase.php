<?php

namespace App\Http\Controllers\Trait;

use App\Models\ForFirebase;

trait Firebase
{
    public static function send($itemid, $title, $body, $link, $logo, $image)
    {
        $items = \App\Models\UserNoti::select('*')->join('items', 'user_noti.item_id', '=', 'items.id')->join('firebase', 'user_noti.receiver_user_id', '=', 'firebase.userid')->where('items.id', $itemid)->where('read_by_receiver', '!=', 1)->get();
        if (!empty($items)) {
            $res = \Illuminate\Support\Facades\Http::withHeaders([
                //  'Authorization' => 'key=AAAAh_UhvDE:APA91bHwGqI5w4cFSYGjp1tCdJoshLNS58u8NFv5tMJBbV4X5rDp6K_WqP_CxyitkG4i_95OIhMzCgWaJK_AhiErPiE2V-tE4u7J77naN78B-t-BAAQ4hzCjFaJ_Fz3iSCZFIx_ZD18j',
                // Added by Swe
                'Authorization' => 'key=AAAAs3L7Dpk:APA91bHW_87I0M2LIU2dKyOhYbmkxcFFXH8xNasjpaUqNBtLqx73vmaQ8wcAIsl3T7b0tTF7fqLJDUCQFmqqnf1Duv6j4LaSl28dBaWyTxv5zuJUzTt4yl9HZjqZXm9VgCG2axNu_tSE',
                'Content-Type' => 'application/json',
            ])->post("https://fcm.googleapis.com/fcm/send", [
                'registration_ids' => $items->pluck('token'),

                'data' => ['title' => $title, 'body' => $body, 'link' => $link, 'photo' => $image, 'logo' => $logo, 'type' => 'discount'],
                //'notification'  => $msg, (this caused the notification to deliver twice)

            ]);

            if ($items->pluck('androidtoken')) {
                $res = \Illuminate\Support\Facades\Http::withHeaders([
                    'Authorization' => 'key=AAAAs3L7Dpk:APA91bHW_87I0M2LIU2dKyOhYbmkxcFFXH8xNasjpaUqNBtLqx73vmaQ8wcAIsl3T7b0tTF7fqLJDUCQFmqqnf1Duv6j4LaSl28dBaWyTxv5zuJUzTt4yl9HZjqZXm9VgCG2axNu_tSE',
                    'Content-Type' => 'application/json',
                ])->post("https://fcm.googleapis.com/fcm/send", [
                    'registration_ids' => $items->pluck('androidtoken'),

                    // 'data' => ['title' => $title, 'body' => $body,'link'=>$link,'logo'=>$logo],
                    'notification' => ['title' => $title, 'body' => $body, 'logo' => $logo],
                ]);
            }

            return $res;
        }
    }

    public static function sendformessage($toid, $title, $body, $link, $logo, $image)
    {
        $gettoken = ForFirebase::where('userid', $toid)->first();
        if (!empty($gettoken)) {
            $res = \Illuminate\Support\Facades\Http::withHeaders([
                // 'Authorization' => 'key=AAAAh_UhvDE:APA91bHwGqI5w4cFSYGjp1tCdJoshLNS58u8NFv5tMJBbV4X5rDp6K_WqP_CxyitkG4i_95OIhMzCgWaJK_AhiErPiE2V-tE4u7J77naN78B-t-BAAQ4hzCjFaJ_Fz3iSCZFIx_ZD18j',
                // Added by Swe
                'Authorization' => 'key=AAAAs3L7Dpk:APA91bHW_87I0M2LIU2dKyOhYbmkxcFFXH8xNasjpaUqNBtLqx73vmaQ8wcAIsl3T7b0tTF7fqLJDUCQFmqqnf1Duv6j4LaSl28dBaWyTxv5zuJUzTt4yl9HZjqZXm9VgCG2axNu_tSE',
                'Content-Type' => 'application/json',
            ])->post("https://fcm.googleapis.com/fcm/send", [
                //if u want to send multiple use registration ids
                //'registration_ids' => $gettoken->pluck('androidtoken'),

                //else if u want to send only one device use to
                'to' => $gettoken->token,

                'data' => ['title' => $title, 'body' => $body, 'link' => 'https://test.shweshops.com', 'photo' => $image, 'logo' => $logo],

            ]);

            if ($gettoken->androidtoken) {
                $res = \Illuminate\Support\Facades\Http::withHeaders([
                    'Authorization' => 'key=AAAAs3L7Dpk:APA91bHW_87I0M2LIU2dKyOhYbmkxcFFXH8xNasjpaUqNBtLqx73vmaQ8wcAIsl3T7b0tTF7fqLJDUCQFmqqnf1Duv6j4LaSl28dBaWyTxv5zuJUzTt4yl9HZjqZXm9VgCG2axNu_tSE',
                    'Content-Type' => 'application/json',
                ])->post("https://fcm.googleapis.com/fcm/send", [
                    'to' => $gettoken->androidtoken,
                    // 'data' => ['title' => $title, 'body' => $body,'link'=>$link,'logo'=>$logo],
                    'notification' => ['title' => $title, 'body' => $body, 'logo' => $logo],
                ]);
            }

            return $res;
        }
    }

    public static function sendformessagetoshop($toid, $title, $body, $link, $logo, $image)
    {

        $gettoken = ForFirebase::where('shopid', $toid)->first();
        if (!empty($gettoken)) {

            $res = \Illuminate\Support\Facades\Http::withHeaders([
                // 'Authorization' => 'key=AAAAh_UhvDE:APA91bHwGqI5w4cFSYGjp1tCdJoshLNS58u8NFv5tMJBbV4X5rDp6K_WqP_CxyitkG4i_95OIhMzCgWaJK_AhiErPiE2V-tE4u7J77naN78B-t-BAAQ4hzCjFaJ_Fz3iSCZFIx_ZD18j',
                // Added by Swe
                'Authorization' => 'key=AAAAs3L7Dpk:APA91bHW_87I0M2LIU2dKyOhYbmkxcFFXH8xNasjpaUqNBtLqx73vmaQ8wcAIsl3T7b0tTF7fqLJDUCQFmqqnf1Duv6j4LaSl28dBaWyTxv5zuJUzTt4yl9HZjqZXm9VgCG2axNu_tSE',
                'Content-Type' => 'application/json',
            ])->post("https://fcm.googleapis.com/fcm/send", [
                //if u want to send multiple use registration ids
                //'registration_ids' => $gettoken->pluck('androidtoken'),

                //else if u want to send only one device use to
                'to' => $gettoken->token,
                'data' => ['title' => $title, 'body' => $body, 'link' => 'https://test.shweshops.com', 'photo' => $image, 'logo' => $logo],

            ]);

            if ($gettoken->androidtoken) {
                $res = \Illuminate\Support\Facades\Http::withHeaders([
                    'Authorization' => 'key=AAAAs3L7Dpk:APA91bHW_87I0M2LIU2dKyOhYbmkxcFFXH8xNasjpaUqNBtLqx73vmaQ8wcAIsl3T7b0tTF7fqLJDUCQFmqqnf1Duv6j4LaSl28dBaWyTxv5zuJUzTt4yl9HZjqZXm9VgCG2axNu_tSE',
                    'Content-Type' => 'application/json',
                ])->post("https://fcm.googleapis.com/fcm/send", [
                    'to' => $gettoken->androidtoken,
                    // 'data' => ['title' => $title, 'body' => $body,'link'=>$link,'logo'=>$logo],
                    'notification' => ['title' => $title, 'body' => $body, 'logo' => $logo],
                ]);
            }

            return $res;
        }
    }
}
