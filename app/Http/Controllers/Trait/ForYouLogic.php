<?php
namespace App\Http\Controllers\Trait;

use App\Models\Ads;
use App\Models\Ajax;
use App\Models\Item;
use App\Models\State;
use App\Models\discount;
use App\Models\Township;
use App\Models\Usernoti;
use App\Models\Contactus;
use App\Models\Shopowner;
use App\Models\UserPoint;
use App\Models\Users_fav;
use Carbon\Carbon;
use App\Models\Collection;
use App\Models\Manager_fav;
use App\Models\foraddtohome;
use App\Models\Facade\Repair;
use App\Models\frontuserlogs;
use App\Models\Guestoruserid;
use App\Models\Shopdirectory;
use App\Models\BuyNowClickLog;
use App\Models\Shop_owners_fav;
use App\Models\WhislistClickLog;
use App\Models\AddToCartClickLog;
use App\Models\VisitorLogActivity;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\traid\logs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\traid\allshops;
use App\Http\Controllers\traid\category;
use App\Http\Controllers\traid\similarlogic;


trait ForYouLogic{


    public function getlogsuserid(){
        $checklogin=Auth::guard('web')->check();
        // if($checklogin){
        //     $idofcurrentuser=Guestoruserid::where('user_id',Auth::guard('web')->user()->id)->first()->id;

        // }else{
        //     $idofcurrentuser=Guestoruserid::where('guest_id',Session::get('guest_id'))->first()->id;

        // }
        // return $idofcurrentuser;

        if($checklogin){
            if(!empty(Guestoruserid::where('user_id',Auth::guard('web')->user()->id)->first())){

            $idofcurrentuser=Guestoruserid::where('user_id',Auth::guard('web')->user()->id)->first()->id;
            return $idofcurrentuser;

            }else{
                return 'random';

            }

        }else{
            if(!empty(Guestoruserid::where('guest_id',Session::get('guest_id'))->first())){
                $idofcurrentuser=Guestoruserid::where('guest_id',Session::get('guest_id'))->first()->id;
                return $idofcurrentuser;

            }else{
                return 'random';

            }

        }

    }
    public function getuserviewlogs(){
        $getdatafromlogs=frontuserlogs::where('userorguestid',$this->getlogsuserid())->whereDate('created_at','>',Carbon::now()->subMonth())->where([['status','!=','homepage'],['status','!=','adsclick']])->get();

    return $getdatafromlogs;

    }
    public function getminprice($itemid){
        $getitem=Item::where('id',$itemid)->first();
        $to_check_dis_first=discount::where('item_id',$itemid);
        if($to_check_dis_first->count() == 0){
         if($getitem->price == 0){
             $min=$getitem->min_price;
         }else{
             $min=$getitem->price;

         }
        }else{
         if($to_check_dis_first->first()->discount_price == 0){
            $min=$to_check_dis_first->first()->discount_min;


         }else{
            $min=$to_check_dis_first->first()->discount_price;

         }

        }
        return $min;

    }
    public function getmaxprice($itemid){
        $getitem=Item::where('id',$itemid)->first();
        $to_check_dis_first=discount::where('item_id',$itemid);
        if($to_check_dis_first->count() == 0){
         if($getitem->price == 0){
             $max=$getitem->max_price;
         }else{
             $max=$getitem->price;

         }
        }else{
         if($to_check_dis_first->first()->discount_price == 0){
            $max=$to_check_dis_first->first()->discount_max;


         }else{
            $max=$to_check_dis_first->first()->discount_price;

         }

        }
        return $max;

    }
    public function getgender(){
        $getmostgenderlist=frontuserlogs::leftjoin('items','items.id','=','front_user_logs.product_id')
        ->select('items.gender',DB::raw('count(*) as total '))
        ->where('front_user_logs.userorguestid',$this->getlogsuserid())
        ->where('items.deleted_at',NULL)
        ->where([['front_user_logs.status','!=','homepage'],['front_user_logs.status','!=','adsclick']])
        ->whereDate('front_user_logs.created_at','>',Carbon::now()->subMonth())
        ->groupBy('items.gender')
        ->orderBy('total','desc')
        ->limit('1')
        ->get();
        return $getmostgenderlist;
    }

    public function foryoupricelogic($getitemdatafromtable){
        if(count($getitemdatafromtable)==0){
            return ['min'=>'Any','max'=>'Any'];
        }else{
            if(count($getitemdatafromtable) == 1){
                $min=$this->getminprice($getitemdatafromtable[0]->id);
                $max=$this->getmaxprice($getitemdatafromtable[0]->id);

                $min=ceil($min - (($min * 20)/100));
                $max=ceil($max + (($max * 20)/100));

                return ['min'=>$min,'max'=>$max];

            }else{
                return ['min'=>$this->getminprice($getitemdatafromtable[0]->id),'max'=>$this->getmaxprice($getitemdatafromtable[count($getitemdatafromtable)-1]->id)];

            }
        }

    }


    public function foryoucatlogic(){
        $getuserseecatlist=frontuserlogs::leftjoin('items','items.id','=','front_user_logs.product_id')
        ->select('items.category_id',DB::raw('count(*) as total '))
        ->where('items.id','!=',NULL)

        ->where('front_user_logs.userorguestid',$this->getlogsuserid())
        ->where('items.deleted_at',NULL)
        ->where([['front_user_logs.status','!=','homepage'],['front_user_logs.status','!=','adsclick']])
        ->whereDate('front_user_logs.created_at','>',Carbon::now()->subMonth())

        ->groupBy('items.category_id')
        ->orderBy('total','desc')
        ->limit('2')
        ->get();
        return $getuserseecatlist;

    }

    public function foryoumaincat(){
        $getuserseecatlist=frontuserlogs::leftjoin('items','items.id','=','front_user_logs.product_id')
        ->select('items.main_category',DB::raw('count(*) as total '))
        ->where('items.id','!=',NULL)

        ->where('front_user_logs.userorguestid',$this->getlogsuserid())
        ->where('items.deleted_at',NULL)
        ->where([['front_user_logs.status','!=','homepage'],['front_user_logs.status','!=','adsclick']])
        ->whereDate('front_user_logs.created_at','>',Carbon::now()->subMonth())

        ->groupBy('items.main_category')
        ->orderBy('total','desc')
        ->limit('2')
        ->get();
        return $getuserseecatlist;

    }

    public function getshopsforforyou(){
        $shoplist=frontuserlogs::leftjoin('items','items.id','=','front_user_logs.product_id')
        ->select('items.*',DB::raw('count(*) as total '))
        ->where('items.id','!=',NULL)
        ->where('front_user_logs.userorguestid',$this->getlogsuserid())
        ->where('items.deleted_at',NULL)
        ->where([['front_user_logs.status','!=','homepage'],['front_user_logs.status','!=','adsclick']])
        ->whereDate('front_user_logs.created_at','>',Carbon::now()->subMonth())

        ->groupBy('items.shop_id')
        ->orderBy('total','desc')
        ->limit('5')
        ->get();
        return $shoplist;
    }
    public function getitemidfromlogs(){
        $getitemidfromlogs=$this->getuserviewlogs()->pluck('product_id');
        return $getitemidfromlogs;
    }
    public function getitemdatafromtable(){
        $getitemidfromlogs=$this->getitemidfromlogs();
        $getitemdatafromtable=Item::select('items.*')->leftjoin('discount', 'items.id', '=', 'discount.item_id')
        ->whereIn('items.id',$getitemidfromlogs)
        ->orderByRaw("CASE
        WHEN discount.discount_price = 0 THEN discount.discount_min
        WHEN discount.discount_price !=  0 THEN discount.discount_price
        WHEN items.price=0 THEN min_price
        WHEN items.price!=0 THEN price
        END
        ASC")->get();
        return $getitemdatafromtable;
    }

   public function caculateforyouforcurrentuser()
   {
    if($this->getlogsuserid() != 'random'){
        $getitemdatafromtable=$this->getitemdatafromtable();
        $pricemin=$this->foryoupricelogic($getitemdatafromtable)['min'];
        $pricemax=$this->foryoupricelogic($getitemdatafromtable)['max'];
        $catlistarraywithtotal=$this->foryoucatlogic();

        $catonlyname=[];
        foreach($catlistarraywithtotal as $clawt){
         $catonlyname[]=$clawt->category_id;

        }
        $genderlist=[];
        foreach($this->getgender() as $ge){
            $genderlist[]=$ge->gender;

           }
           $allshoplist=[];
           foreach($this->getshopsforforyou() as $gs){
               $allshoplist[]=$gs->shop_id;

              }
        if($pricemin == 'Any'){
         $pricemin=0;
        }
        if($pricemax == 'Any'){
         $pricemax=1000000000000000000;
        }

        $resultdata=Item::leftjoin('discount', 'items.id', '=', 'discount.item_id')
        ->leftjoin('shop_owners','shop_owners.id','=','items.shop_id')->select('items.*','items.id as item_id')
        ->whereIn('items.category_id',$catonlyname)
        ->whereIn('items.main_category',$this->foryoumaincat()->pluck('main_category'))
        ->where(function ($query) use ($pricemin, $pricemax) {
         $query->where([['items.min_price', '>', $pricemin], ['items.max_price', '<', $pricemax]])
         ->orWhere([['items.price', '>', $pricemin], ['items.price', '<', $pricemax]])
         ->orWhere([['discount.discount_price', '>', $pricemin], ['discount.discount_price', '<', $pricemax]])
         ->orWhere([['discount.discount_min', '>', $pricemin], ['discount.discount_max', '<', $pricemax]]);

        })
        ->whereIn('gender',$genderlist)
        // ->whereIn('items.shop_id',$allshoplist)
        ->whereNotNull('shop_owners.id')
        ->orderByRaw("CASE
        WHEN discount.discount_price = 0 THEN discount.discount_min
        WHEN discount.discount_price !=  0 THEN discount.discount_price
        WHEN items.price=0 THEN min_price
        WHEN items.price!=0 THEN price
        END
        ASC")

        ->limit('20')
        ->get();
        $random='no';
        if(count($resultdata) == 0){
            $resultdata=Item::orderBy('id','desc')->limit('20')->get();
            $random='yes';

        }

    }else{
        $resultdata=Item::orderBy('id','desc')->limit('20')->get();
        $random='yes';

    }



   return [$resultdata,$random];

   }

}
