<?php
namespace App\Http\Controllers\Trait;

use App\Models\Item;
use App\Models\Manager;
use App\Models\Shops;
use Illuminate\Support\Facades\Auth;

trait UserRole{

    private $role,$role_shop_id,$role_user,$user_lists;

    private function get_shopowners_role($user_role)
    {
     return Auth::guard('shop_owners_and_staffs')->user()->role->name;
    }

    public function current_shop_data(){
      
            return Shops::where('id',$this->get_shopid())->orderBy('created_at', 'desc')->get();
        
    }

    private function role_check_trash($x)
    {
        if($x == 1){
            $this->role_user = Manager::onlyTrashed()->where('shop_id',$this->role_shop_id)->whereIn('role_id',[2,3])->get();
        }elseif($x == 2){
            $this->role_user =Manager::onlyTrashed()->where('shop_id',$this->role_shop_id)->where(['role_id'=>3])->get();

        }
    }


    public function itisowneritem($itemid){
         $tmpdata=0;
         if($this->isowner()){
             $tmpdata= Item::where('shop_id',$this->getcurrentauthdata()->id)->first()->count();

         }else{
             $tmpdata= Item::where('user_id',$this->getcurrentauthdata()->id)->first()->count();

         }
        if($tmpdata != 0){
            return true;
        }else{
            return false;
        }

    }
    public function isadmin(){
        if(Auth::guard('shop_owners_and_staffs')->user()->role->id==1){
            return true;
        }else{
            return false;
        }
    }
    public function ismanager(){
        if(Auth::guard('shop_owners_and_staffs')->user()->role->id==2){
            return true;
        }else{
            return false;
        }
    }
    public function isstaff(){
        if(Auth::guard('shop_owners_and_staffs')->user()->role->id==3){
            return true;
        }else{
            return false;
        }
    }
    public function unauthorize(){
        return abort(401);
    }
    public function getuserlistbyrolelevel(){
        if($this->ismanager()){
            return Manager::where('shop_id',$this->getcurrentauthdata()->shop_id)->whereIn('role_id',[3])->orderBy('created_at', 'desc')->get();
        }
        if($this->isadmin()){
            return Manager::where('shop_id',$this->getcurrentauthdata()->shop_id)->whereIn('role_id',[2,3])->orderBy('created_at', 'desc')->get();
        }
        if($this->isowner()){
           return $this->user_lists = Manager::where('shop_id',$this->getcurrentauthdata()->id)->get();

        }
        if($this->isstaff()){

            return Manager::where('shop_id',$this->getcurrentauthdata()->shop_id)->orderBy('created_at', 'desc')->get();

        }
    }
    public function getcurrentauthdata(){
        return Auth::guard('shop_owners_and_staffs')->user();
    }
    public function get_shopid(){
        $shop_id=$this->getcurrentauthdata()->shop_id;

        return $shop_id;
    }
}
