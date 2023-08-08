<?php
namespace App\Http\Controllers\Trait;

use App\Models\Item;
use App\Models\Manager;
use App\Models\Shopowner;
use Illuminate\Support\Facades\Auth;

trait UserRole{

    private $role,$role_shop_id,$role_user,$user_lists;

    private function role($user_role)
    {
        $this->role = Auth::guard($user_role)->user()->id;
        $this->role_shop_id = Auth::guard($user_role)->user()->shop_id;
        $this->shop_owner($user_role);
    }

    private function shop_owner($user_role){
        if($user_role == 'shop_owner'){
            $this->shop_owner =  Shopowner::where('id',$this->role)->orderBy('created_at', 'desc')->get();
        }else{
            $this->shop_owner =  Shopowner::where('id',$this->role_shop_id)->orderBy('created_at', 'desc')->get();
        }
    }

    private function role_check_trash($x)
    {
        if($x == 1){
            $this->role_user = Manager::onlyTrashed()->where('shop_id',$this->role_shop_id)->whereIn('role_id',[2,3])->get();
        }elseif($x == 2){
            $this->role_user =Manager::onlyTrashed()->where('shop_id',$this->role_shop_id)->where(['role_id'=>3])->get();

        }
    }

    private function role_check($role)
    {
        if($role == 2){
            $this->user_lists =  Manager::where('shop_id',$this->role_shop_id)->whereIn('role_id',[3])->orderBy('created_at', 'desc')->get();
        }elseif($role == 1){
            $this->user_lists =  Manager::where('shop_id',$this->role_shop_id)->whereIn('role_id',[2,3])->orderBy('created_at', 'desc')->get();
        }elseif($role == 3){
            abort(404);
        }else{
            $this->user_lists = Manager::where('shop_id',$this->shop_owner_id)->get();
        }
    }

    public function isowner(){
        if(Auth::guard('shop_owner')->check()){
            return true;
        }else{
            return false;
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
        if(Auth::guard('shop_role')->check() && (Auth::guard('shop_role')->user()->role_id == 1)){
            return true;
        }else{
            return false;
        }
    }
    public function ismanager(){
        if(Auth::guard('shop_role')->check() && (Auth::guard('shop_role')->user()->role_id == 2)){
            return true;
        }else{
            return false;
        }
    }
    public function isstaff(){
        if(Auth::guard('shop_role')->check() && (Auth::guard('shop_role')->user()->role_id == 3)){
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
        if(!$this->isowner()){
            return Auth::guard('shop_role')->user();
        }else{
            return Auth::guard('shop_owner')->user();
        }
    }
    public function getshopid(){
        if($this->isowner()){
            $shop_id=$this->getcurrentauthdata()->id;

        }else{
            $shop_id=$this->getcurrentauthdata()->shop_id;


        }
        return $shop_id;
    }
}
