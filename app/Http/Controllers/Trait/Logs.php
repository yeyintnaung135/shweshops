<?php
namespace App\Http\Controllers\Trait;

use App\Http\Controllers\Trait\YKCheckbot;
use App\Models\Bots;
use App\Models\FrontUserLogs;
use App\Models\GuestOrUserId;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

trait Logs
{
    //for logs
    use YKCheckbot;

    public function getidoftable_userorguestid()
    {
        $useragent = \Illuminate\Support\Facades\Request::userAgent();

        if (Session::has('guest_id')) {
            $getguestsession = Session::get('guest_id');
            if (Auth::guard('web')->check()) {
                $checkwehavethisguestid = GuestOrUserId::where('guest_id', $getguestsession)->get();
                if ($checkwehavethisguestid->count() > 0) {
                    $checkwehavebothid = GuestOrUserId::where([['guest_id', '=', $getguestsession], ['user_id', '=', 0]]);
                    if (!empty($checkwehavebothid->first())) {
                        $id_of_table_goruser = GuestOrUserId::where([['guest_id', '=', $getguestsession], ['user_id', '=', 0]])->update(['user_id' => Auth::guard('web')->user()->id]);
                        return GuestOrUserId::where([['guest_id', '=', $getguestsession], ['user_id', '=', Auth::guard('web')->user()->id]])->first()->id;

                    } else {
                        return $checkwehavethisguestid->first()->id;
                    }

                } else {
                    $id_of_table_goruser = GuestOrUserId::create(['guest_id' => $getguestsession, 'user_id' => Auth::guard('web')->user()->id, 'ip' => \Illuminate\Support\Facades\Request::ip(), 'user_agent' => \Illuminate\Support\Facades\Request::userAgent()]);
                    return $id_of_table_goruser->id;
                }
            } else {
                $checkwehavethisguestid = GuestOrUserId::where('guest_id', $getguestsession);
                if ($checkwehavethisguestid->count() > 0) {
                    return GuestOrUserId::where('guest_id', $getguestsession)->first()->id;
                } else {
                    $tmpid = GuestOrUserId::create(['guest_id' => $getguestsession, 'user_id' => 0, 'ip' => \Illuminate\Support\Facades\Request::ip(), 'user_agent' => \Illuminate\Support\Facades\Request::userAgent()]);
                    return $tmpid->id;
                }

            }

        }

    }

    public function addlog($visitedlink, $productid, $shop_id, $status, $ads_id)
    {

        $useragent = \Illuminate\Support\Facades\Request::userAgent();
        if ($this->isbotdetectbyyk($useragent) === 'no') {
            if (!Auth::guard('super_admin')->check() and !Auth::guard('shop_owners_and_staffs')->check()) {

                if (Session::has('guest_id')) {
                    $tableidof_userorguestid = $this->getidoftable_userorguestid();

                    FrontUserLogs::create(['ads_id' => $ads_id, 'userorguestid' => $tableidof_userorguestid, 'visited_link' => $visitedlink, 'product_id' => $productid, 'shop_id' => $shop_id, 'status' => $status]);

                }
            } else {

                if (Session::has('guest_id')) {
                    $this->isbacksideuserdeleterecord();
                }
            }
        } else {
            Bots::create(['ip' => \Illuminate\Support\Facades\Request::ip(), 'user_agent' => $useragent, 'checklink' => $visitedlink]);
        }
        //get id from userorguest table
    }

    public function isbacksideuserdeleterecord()
    {
        $tableidof_userorguestid = $this->getidoftable_userorguestid();
        if (!empty(FrontUserLogs::where('userorguestid', $tableidof_userorguestid)->first())) {
            FrontUserLogs::where('userorguestid', $tableidof_userorguestid)->delete();

        }
        if (!empty(GuestOrUserId::where('id', $tableidof_userorguestid)->first())) {
            GuestOrUserId::where('id', $tableidof_userorguestid)->delete();

        }

    }
    //for logs
}
