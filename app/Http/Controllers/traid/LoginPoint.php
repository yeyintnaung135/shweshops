<?php
namespace App\Http\Controllers\traid;

use App\Models\UserPoint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


trait LoginPoint{

    protected $is_user_register_point,$is_user_register_time,$is_user_login_time;

    private function get_user_point()
    {
        $this->is_user_register_point = UserPoint::where('user_id', Auth::guard('web')->id())->where('point_id',1)->count();
        $this->is_user_register_time= UserPoint::where('user_id', Auth::guard('web')->id())
        ->where('point_id',1)
        ->where('login_expired','>',Carbon::now())
        ->count();
        $this->is_user_login_time = UserPoint::where('user_id', Auth::guard('web')->id())->where('point_id',4)
        ->where('login_expired','>',Carbon::now())
        ->count();
    }


    private function delete_login_expired_point()
    {
        return UserPoint::where('user_id',Auth::guard('web')->id())->where('point_id',4)->delete();
    }

    /** 
     *  @check Login or Register insert Point
     * 
     * 
     */

     public function check_login_or_register_point()
     {
      
        $user_point = new UserPoint();
        if($this->is_user_register_point >= 0){
            if($this->is_user_register_time <= 0 || $this->is_user_login_time <= 0){
                $this->delete_login_expired_point();
                
                $user_point->user_id = Auth::guard('web')->id();
                $user_point->login_expired = Carbon::now()->addDay(1);
                $user_point->point_id = 4;
                $user_point->save();
            }
        }else{
            $user_point->user_id = Auth::guard('web')->id();
            $user_point->login_expired = Carbon::now()->addDay(1);
            $user_point->point_id = 1;
            $user_point->save();
        }
     }

     public function check_daily_login_expired()
     {
        if(Auth::guard('web')->check()){
            if($this->is_user_login_time <= 0){
                $this->delete_login_expired_point();

                $user_point = new UserPoint();
                $user_point->user_id = Auth::guard('web')->id();
                $user_point->login_expired = Carbon::now()->addDay(1);
                $user_point->point_id = 4;
                $user_point->save();
            }
        }
     }


}