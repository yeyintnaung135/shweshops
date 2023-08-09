<?php

namespace App\Http\Controllers\ShopOwner;

use App\Models\PosItemPurchase;
use App\Models\PosPurchaseSale;
use App\Models\PosStaff;
use App\Models\State;
use App\Models\Item;
use App\Models\PosDiamond;
use App\Models\Category;
use App\Models\PosGoldSale;
use App\Models\PosPurchase;
use App\Models\PosSupplier;
use App\Models\PosKyoutSale;
use App\Models\Shopowner;
use App\Models\PosQuality;
use App\Models\PosPlatinumSale;
use App\Models\PosKyoutPurchase;
use App\Models\PosWhiteGoldSale;
use App\Models\PosAssignGoldPrice;
use App\Models\PosPlatinumPurchase;
use App\Models\PosWhiteGoldPurchase;
use App\Models\PosAssignPlatinumPrice;
use Illuminate\Http\Request;
use App\Models\PosAssignWhiteGoldPrice;
use App\Models\PosCounterShop;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Trait\YKImage;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Trait\UserRole;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Trait\MultipleItem;
use App\Models\PosCreditList;
use App\Models\PosReturnList;
use Illuminate\Support\Facades\Storage;

class PosController extends Controller
{
    use YKImage, UserRole, MultipleItem;

    public $err_data = [];

    public function __construct()
    {
        $this->middleware('auth:shop_owner,shop_role');
    }

    public function getDashBoard()
    {
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $gold=0; $kyout =0 ; $platinum=0; $whitegold = 0;
        $golds = PosPurchase::where('stock_qty','>',0)->where('shop_owner_id',$this->getshopid())->get('stock_qty');
        $kyouts = PosKyoutPurchase::where('stock_qty','>',0)->where('shop_owner_id',$this->getshopid())->get('stock_qty');
        $platinums = PosPlatinumPurchase::where('stock_qty','>',0)->where('shop_owner_id',$this->getshopid())->get('stock_qty');
        $whitegolds = PosWhiteGoldPurchase::where('stock_qty','>',0)->where('shop_owner_id',$this->getshopid())->get('stock_qty');
        foreach($golds as $gq){
            $gold = $gold + $gq->stock_qty;
        }
        foreach($kyouts as $kq){
            $kyout = $kyout + $kq->stock_qty;
        }
        foreach($platinums as $pq){
            $platinum = $platinum + $pq->stock_qty;
        }
        foreach($whitegolds as $wq){
            $whitegold = $whitegold + $wq->stock_qty;
        }
        $supplier = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id',$this->getshopid())->take(3)->get();
        $counts = PosSupplier::skip(2)->take(10000)->where('shop_owner_id',$this->getshopid())->get();
        $mytime = Carbon::now();
        $gtoday_income = PosGoldSale::where('date', $mytime->toDateString())->where('shop_owner_id',$this->getshopid())->get();
        $ktoday_income = PosKyoutSale::where('date', $mytime->toDateString())->where('shop_owner_id',$this->getshopid())->get();
        $ptoday_income = PosPlatinumSale::where('date', $mytime->toDateString())->where('shop_owner_id',$this->getshopid())->get();
        $wtoday_income = PosWhiteGoldSale::where('date', $mytime->toDateString())->where('shop_owner_id',$this->getshopid())->get();
        $today  = 0;
        $arr = [];
        $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        if($assign_gold_price){
            $gold_price = explode('/',$assign_gold_price->shop_price)[1];
        }
        else{
            Session::flash('message', '​ရွှေ​စျေး,ပလက်တီနမ်​စျေး,​ရွှေဖြူ​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
            // dd($credits);
            return view('backend.pos.assign_gold_price',['shopowner'=>$shopowner,'assign_gold_price'=>$assign_gold_price]);
        }
        $staffs = PosStaff::where('shop_id',$this->getshopid())->count();
        $suppliers = DB::table('pos_suppliers')->where('shop_owner_id',$this->getshopid())->count();
        $return =  PosReturnList::where('date', $mytime->toDateString())->where('shop_owner_id',$this->getshopid())->get()->count();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        foreach($counters as $counter){
            $subtotal = 0;
           foreach($gtoday_income as $g){
            if($g->purchase->counter_shop == $counter->shop_name){
                $subtotal += $g->amount;
            }
           }
           foreach($ktoday_income as $k){
            if($k->purchase->counter_shop == $counter->shop_name){
                $subtotal += $k->amount;
            }
           }
           foreach($ptoday_income as $p){
            if($p->purchase->counter_shop == $counter->shop_name){
                $subtotal += $p->amount;
            }
           }
           foreach($wtoday_income as $w){
            if($w->purchase->counter_shop == $counter->shop_name){
                $subtotal += $w->amount;
            }
           }
           array_push($arr,$subtotal);
        }

        return view('backend.pos.dashboard',['shopowner'=>$shopowner,'counters'=>$counters,'arr'=>$arr,'counts'=>$counts,'return'=>$return,'sup'=>$suppliers,'gold_price'=>$gold_price,'staffs'=>$staffs,'today'=>$today,'gold'=>$gold,'kyout'=>$kyout,'platinum'=>$platinum,'whitegold'=>$whitegold,'suppliers'=>$supplier]);
    }
    public function getTotalAmount(){
        $gjan_income = PosGoldSale::whereMonth('date', '01')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $kjan_income = PosKyoutSale::whereMonth('date', '01')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $pjan_income = PosPlatinumSale::whereMonth('date', '01')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $wjan_income = PosWhiteGoldSale::whereMonth('date', '01')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
       $jan  = 0;
       foreach($gjan_income as $gj){
             $jan += $gj->amount;
       }
       foreach($kjan_income as $kj){
        $jan += $kj->amount;
        }
        foreach($pjan_income as $pj){
            $jan += $pj->amount;
        }
        foreach($wjan_income as $wj){
            $jan += $wj->amount;
        }
        $gfeb_income = PosGoldSale::whereMonth('date', '02')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $kfeb_income = PosKyoutSale::whereMonth('date', '02')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $pfeb_income = PosPlatinumSale::whereMonth('date', '02')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $wfeb_income = PosWhiteGoldSale::whereMonth('date', '02')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
       $feb  = 0;
       foreach($gfeb_income as $gf){
             $feb += $gf->amount;
       }
       foreach($kfeb_income as $kf){
        $feb += $kf->amount;
        }
        foreach($pfeb_income as $pf){
            $feb += $pf->amount;
        }
        foreach($wfeb_income as $wf){
            $feb += $wf->amount;
        }
        $gmar_income = PosGoldSale::whereMonth('date', '03')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $kmar_income = PosKyoutSale::whereMonth('date', '03')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $pmar_income = PosPlatinumSale::whereMonth('date', '03')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $wmar_income = PosWhiteGoldSale::whereMonth('date', '03')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
       $mar  = 0;
       foreach($gmar_income as $gm){
             $mar += $gm->amount;
       }
       foreach($kmar_income as $km){
        $mar += $km->amount;
        }
        foreach($pmar_income as $pm){
            $mar += $pm->amount;
        }
        foreach($wmar_income as $wm){
            $mar += $wm->amount;
        }
        $gapr_income = PosGoldSale::whereMonth('date', '04')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $kapr_income = PosKyoutSale::whereMonth('date', '04')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $papr_income = PosPlatinumSale::whereMonth('date', '04')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $wapr_income = PosWhiteGoldSale::whereMonth('date', '04')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
       $apr  = 0;
       foreach($gapr_income as $ga){
             $apr += $ga->amount;
       }
       foreach($kapr_income as $ka){
        $apr += $ka->amount;
        }
        foreach($papr_income as $pa){
            $apr += $pa->amount;
        }
        foreach($wapr_income as $wa){
            $apr += $wa->amount;
        }
        $gmay_income = PosGoldSale::whereMonth('date', '05')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $kmay_income = PosKyoutSale::whereMonth('date', '05')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $pmay_income = PosPlatinumSale::whereMonth('date', '05')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $wmay_income = PosWhiteGoldSale::whereMonth('date', '05')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
       $may  = 0;
       foreach($gmay_income as $g){
             $may += $g->amount;
       }
       foreach($kmay_income as $k){
        $may += $k->amount;
        }
        foreach($pmay_income as $p){
            $may += $p->amount;
        }
        foreach($wmay_income as $w){
            $may += $w->amount;
        }
        $gjun_income = PosGoldSale::whereMonth('date', '06')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $kjun_income = PosKyoutSale::whereMonth('date', '06')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $pjun_income = PosPlatinumSale::whereMonth('date', '06')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $wjun_income = PosWhiteGoldSale::whereMonth('date', '06')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
       $jun  = 0;
       foreach($gjun_income as $gju){
             $jun += $gju->amount;
       }
       foreach($kjun_income as $kju){
        $jun += $kju->amount;
        }
        foreach($pjun_income as $pju){
            $jun += $pju->amount;
        }
        foreach($wjun_income as $wju){
            $jun += $wju->amount;
        }
        $gjul_income = PosGoldSale::whereMonth('date', '07')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $kjul_income = PosKyoutSale::whereMonth('date', '07')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $pjul_income = PosPlatinumSale::whereMonth('date', '07')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $wjul_income = PosWhiteGoldSale::whereMonth('date', '07')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
       $jul  = 0;
       foreach($gjul_income as $gjl){
             $jul += $gjl->amount;
       }
       foreach($kjul_income as $kjl){
        $jul += $kjl->amount;
        }
        foreach($pjul_income as $pjl){
            $jul += $pjl->amount;
        }
        foreach($wjul_income as $wjl){
            $jul += $wjl->amount;
        }
        $gaug_income = PosGoldSale::whereMonth('date', '08')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $kaug_income = PosKyoutSale::whereMonth('date', '08')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $paug_income = PosPlatinumSale::whereMonth('date', '08')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $waug_income = PosWhiteGoldSale::whereMonth('date', '08')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
       $aug  = 0;
       foreach($gaug_income as $gau){
             $aug += $gau->amount;
       }
       foreach($kaug_income as $kau){
        $aug += $kau->amount;
        }
        foreach($paug_income as $pau){
            $aug += $pau->amount;
        }
        foreach($waug_income as $wau){
            $aug += $wau->amount;
        }
        $gsep_income = PosGoldSale::whereMonth('date', '09')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $ksep_income = PosKyoutSale::whereMonth('date', '09')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $psep_income = PosPlatinumSale::whereMonth('date', '09')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $wsep_income = PosWhiteGoldSale::whereMonth('date', '09')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
       $sep  = 0;
       foreach($gsep_income as $gs){
             $sep += $gs->amount;
       }
       foreach($ksep_income as $ks){
        $sep += $ks->amount;
        }
        foreach($psep_income as $ps){
            $sep += $ps->amount;
        }
        foreach($wsep_income as $ws){
            $sep += $ws->amount;
        }
        $goct_income = PosGoldSale::whereMonth('date', '10')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $koct_income = PosKyoutSale::whereMonth('date', '10')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $poct_income = PosPlatinumSale::whereMonth('date', '10')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $woct_income = PosWhiteGoldSale::whereMonth('date', '10')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
       $oct  = 0;
       foreach($goct_income as $go){
             $oct += $go->amount;
       }
       foreach($koct_income as $ko){
        $oct += $ko->amount;
        }
        foreach($poct_income as $po){
            $oct += $po->amount;
        }
        foreach($woct_income as $wo){
            $oct += $wo->amount;
        }
        $gnov_income = PosGoldSale::whereMonth('date', '11')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $knov_income = PosKyoutSale::whereMonth('date', '11')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $pnov_income = PosPlatinumSale::whereMonth('date', '11')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $wnov_income = PosWhiteGoldSale::whereMonth('date', '11')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
       $nov  = 0;
       foreach($gnov_income as $gno){
             $nov += $gno->amount;
       }
       foreach($knov_income as $kno){
        $nov += $kno->amount;
        }
        foreach($pnov_income as $pno){
            $nov += $pno->amount;
        }
        foreach($wnov_income as $wno){
            $nov += $wno->amount;
        }
        $gdec_income = PosGoldSale::whereMonth('date', '12')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $kdec_income = PosKyoutSale::whereMonth('date', '12')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $pdec_income = PosPlatinumSale::whereMonth('date', '12')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
        $wdec_income = PosWhiteGoldSale::whereMonth('date', '12')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->get();
       $dec  = 0;
       foreach($gdec_income as $gde){
             $dec += $gde->amount;
       }
       foreach($kdec_income as $kde){
        $dec += $kde->amount;
        }
        foreach($pdec_income as $pde){
            $dec += $pde->amount;
        }
        foreach($wdec_income as $wde){
            $dec += $wde->amount;
        }

    return response()->json([
        "jan_income" => $jan,
        "feb_income" => $feb,
        "mar_income" => $mar,
        "apr_income" => $apr,
        "may_income" => $may,
        "jun_income" => $jun,
        "jul_income" => $jul,
        "aug_income" => $aug,
        "sep_income" => $sep,
        "oct_income" => $oct,
        "nov_income" => $nov,
        "dec_income" => $dec,
    ]);
    }
    public function getGoldPrice(){
        $jan=0;$feb=0;$mar=0;$apr=0;$may=0;$jun=0;$jul=0;$aug=0;$sep=0;$oct=0;$nov=0;$dec=0;
        $jprice = PosAssignGoldPrice::whereMonth('date', '01')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->orderBy('price_16','desc')->first();
        if($jprice){ $jan = explode('/',$jprice->shop_price)[1];}
        $fprice = PosAssignGoldPrice::whereMonth('date', '02')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->orderBy('price_16','desc')->first();
        if($fprice){$feb = explode('/',$fprice->shop_price)[1];}
        $mprice = PosAssignGoldPrice::whereMonth('date', '03')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->orderBy('price_16','desc')->first();
        if($mprice){$mar = explode('/',$mprice->shop_price)[1];}
        $aprice = PosAssignGoldPrice::whereMonth('date', '04')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->orderBy('price_16','desc')->first();
        if($aprice){$apr = explode('/',$aprice->shop_price)[1];}
        $mayprice = PosAssignGoldPrice::whereMonth('date', '05')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->orderBy('price_16','desc')->first();
        if($mayprice){$may = explode('/',$mayprice->shop_price)[1];}
        $jprice = PosAssignGoldPrice::whereMonth('date', '06')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->orderBy('price_16','desc')->first();
        if($jprice){$jun = explode('/',$jprice->shop_price)[1];}
        $jlprice = PosAssignGoldPrice::whereMonth('date', '07')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->orderBy('price_16','desc')->first();
        if($jlprice){$jul = explode('/',$jlprice->shop_price)[1];}
        $augprice = PosAssignGoldPrice::whereMonth('date', '08')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->orderBy('price_16','desc')->first();
        if($augprice){$aug = explode('/',$augprice->shop_price)[1];}
        $sprice = PosAssignGoldPrice::whereMonth('date', '09')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->orderBy('price_16','desc')->first();
        if($sprice){$sep = explode('/',$sprice->shop_price)[1];}
        $oprice = PosAssignGoldPrice::whereMonth('date', '10')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->orderBy('price_16','desc')->first();
        if($oprice){$oct = explode('/',$oprice->shop_price)[1];}
        $nprice = PosAssignGoldPrice::whereMonth('date', '11')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->orderBy('price_16','desc')->first();
        if($nprice){$nov = explode('/',$nprice->shop_price)[1];}
        $decprice = PosAssignGoldPrice::whereMonth('date', '12')->whereYear('created_at', date('Y'))->where('shop_owner_id',$this->getshopid())->orderBy('price_16','desc')->first();
        if($decprice){$dec = explode('/',$decprice->shop_price)[1];}

        return response()->json([
            "jan" => $jan,
            "feb" => $feb,
            "mar" => $mar,
            "apr" => $apr,
            "may" => $may,
            "jun" => $jun,
            "jul" => $jul,
            "aug" => $aug,
            "sep" => $sep,
            "oct" => $oct,
            "nov" => $nov,
            "dec" => $dec,
        ]);
    }

    //Purchase
       //gold
    public function getPurchaseList(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosPurchase::where('shop_owner_id',$this->getshopid())->get();
        $suppliers = PosSupplier::where('shop_owner_id',$this->getshopid())->get();
        $quals = PosQuality::all();
        $cats = Category::all();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        if($assign_gold_price){
            return view('backend.pos.purchase_list',['shopowner'=>$shopowner,'counters'=>$counters,'purchases'=>$purchases,'sups'=>$suppliers,'quals'=>$quals,'cats'=>$cats]);
        }
        else{
            Session::flash('message', '​ရွှေ​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
            return view('backend.pos.assign_gold_price',['shopowner'=>$shopowner,'assign_gold_price'=>$assign_gold_price]);
        }

    }
    public function goldtypeFilter(Request $request){
        // dd($request->all());
        if($request->type == 1){
            $type = explode('/',$request->text);
        $types = [];
        foreach($type as $t){
            $sup = PosPurchase::where('type', 'like', '%' . $t . '%')->where('shop_owner_id',$this->getshopid())->with('supplier')->get();
            array_push($types,$sup);
        }
        foreach($types as $tp){
            $data = collect($tp)->unique('id')->all();
        }
        }
        if($request->type == 2){
            $data = PosPurchase::whereBetween('date', [$request->start_date, $request->end_date])->where('shop_owner_id',$this->getshopid())->with('supplier')->get();
        }

        return response()->json([
            'data' => $data,
        ]);
    }
    public function goldadvanceFilter(Request $request){
        $data = $request->all();
        $query = PosPurchase::query();
        if(!empty($data['supid'])) {
            $result = $query->where('supplier_id',$data['supid']);
        }

        if(!empty($data['qualid'])) {
            $result = $query->where('quality_id',$data['qualid']);
        }

        if(!empty($data['catid'])) {
            $result = $query->where('category_id',$data['catid']);
        }
        $results = $query->where('shop_owner_id',$this->getshopid())->with('supplier')->get();

        return response()->json([
            'data' => $results,
        ]);
    }

    public function createPurchase(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id',$this->getshopid())->get();
        $quality = DB::table('pos_qualities')->get();
        $date = Carbon::now();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        if($price){
            $shop_price = explode('/',$price->shop_price)[0];
             $out_price = explode('/',$price->shop_price)[1];
              return view('backend.pos.create_purchase',['shopowner'=>$shopowner,'counters'=>$counters,'categories'=>$categories,'suppliers'=>$suppliers,'quality'=>$quality,'shop_price'=>$shop_price,'out_price'=>$out_price,'staffs'=>$staffs]);
        }
        else{
            Session::flash('message', '​ရွှေ​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
            return view('backend.pos.assign_gold_price',['shopowner'=>$shopowner,'assign_gold_price'=>$assign_gold_price]);
        }
    }
    public function storePurchase(Request $request){
        $validator = Validator::make($request->all(), [
            'code_number' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try{
           if($request->hasfile('photo')){
               $image = $request->file('photo');
               $filename = time()."-".$image->getClientOriginalName();
               if(env('USE_DO') != 'true'){
                $get_path = $image->move(public_path('main/images/pos/goldpurchase_photo/'), $filename);
                }else{
                    Storage::disk('digitalocean')->put('/prod/pos/goldpurchase_photo/'.$filename,file_get_contents($image));
                }
            }else{
                $filename = 'default.png';
            }

            $purchase = PosPurchase::create([
                'date' => $request->date,
                'shop_owner_id' =>$this->getshopid(),
                'supplier_id' => $request->supplier_id,
                'quality_id' => $request->quality,
                'staff_id' => $request->staff_id,
                'counter_shop' => $request->counter,
                'color' => $request->color,
                'purchase_price' => $request->purchase_price,
                'category_id' => $request->category_id,
                'code_number' => $request->code_number,
                'product_gram_kyat_pe_yway' => $request->product_gram.'/'.$request->product_kyat.'/'.$request->product_pe.'/'.$request->product_yway,
                'decrease_pe_yway' => $request->decrease_pe.'/'.$request->decrease_yway,
                'profit_pe_yway' => $request->profit_pe.'/'.$request->profit_yway,
                'service_pe_yway' => $request->service_pe.'/'.$request->service_yway,
                'decrease_price' => $request->decrease_price.'/'.$request->currency,
                'gold_price' => $request->gold_price,
                'profit' => $request->profit.'/'.$request->currency1,
                'service_fee' => $request->service_fee.'/'.$request->currency2,
                'gold_fee' => $request->gold_fee,
                'gold_type' => $request->gold_type,
                'gold_name' => $request->gold_name,
                'selling_price' => $request->selling_price,
                'stock_qty' => $request->stock_qty,
                'qty' => $request->stock_qty,
                'remark' => $request->remark,
                'photo' => $filename,
                'barcode_text' => $request->barcode_text,
                'barcode' => $request->code_number.'-'.$request->product_gram,
                'type' => $request->inlineCheckbox
            ]);

            $count = PosSupplier::find($request->supplier_id);
            $count->count += 1;
            $count->save();

            if($request->shwe_item == 1){
                if($request->hasfile('photo')){
                    if(env('USE_DO') != 'true'){
                    $oldPath = public_path('main/images/pos/goldpurchase_photo/').$filename; // publc/images/1.jpg
                    $newPath = public_path('/images/items/').$filename; // publc/images/2.jpg
                   \File::copy($oldPath , $newPath);
                    }else{
                        Storage::disk('digitalocean')->put('/prod/items/'.$filename,file_get_contents($image));
                    }
                }

                if($request->inlineCheckbox == 'option1'){$gender = 'Women';}
                if($request->inlineCheckbox == 'option2'){$gender = 'Men';}
                if($request->inlineCheckbox == 'option3'){$gender = 'Unisex';}
                if($request->inlineCheckbox == 'option4'){$gender = 'Kid';}
                $item = Item::create([
                    'shop_id' =>$this->getshopid(),
                    'gold_quality' => $purchase->quality->name,
                    'stock_count' => $request->stock_qty,
                    'stock' =>'In Stock',
                    'gold_colour' => $request->color,
                    'category_id' =>  $purchase->category->name,
                    'main_category' => 1,
                    'product_code' => $request->code_number,
                    'weight' => '[]',
                    'weight_unit' => 0,
                    'd_gram' => $request->decrease_pe.'/'.$request->decrease_yway,
                    'charge' => $request->service_fee,
                    'name' => $request->gold_name,
                    'price' => $request->selling_price,
                    'description' => $request->remark,
                    'default_photo' => $filename,
                    'gender' => $gender
                ]);
                PosItemPurchase::create([
                    'item_id' => $item->id,
                    'purchase_id' => $purchase->id,
                    'type' => 1
                ]);
            }

            Session::flash('message', 'Purchase was successfully Created!');

            return redirect()->route('backside.shop_owner.pos.purchase_list');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back();
        }
    }
    public function getPurchaseCode(Request $request){
        try{
        $category = Category::find($request->category_id);
        $letter = strtoupper(mb_substr($category->name, 0, 1));
        if($request->type == 'gold'){
            $purchase = PosPurchase::where('shop_owner_id',$this->getshopid())->get();
        }
        if($request->type == 'kyout'){
            $purchase = PosKyoutPurchase::where('shop_owner_id',$this->getshopid())->get();
        }
        $count = count($purchase);
        $code = $letter.sprintf("%04s", $count+1);

        return response()->json([
            'code' => $code,
        ]);
        } catch (\Exception $e) {
           return response()->json([
            'code' => 0,
           ]);
        }
    }
    public function getQualityPrice(Request $request){
        $assign = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        if($request->quality_id == 1){
            $price = $assign->price_16;
        }
        if($request->quality_id == 2){
            $price = $assign->outprice_15;
        }
        if($request->quality_id == 3){
            $price = $assign->inprice_15;
        }
        if($request->quality_id == 4){
            $price = $assign->outprice_14;
        }
        if($request->quality_id == 5){
            $price = $assign->inprice_14;
        }
        if($request->quality_id == 6){
            $price = $assign->outprice_14_2;
        }
        if($request->quality_id == 7){
            $price = $assign->inprice_14_2;
        }
        if($request->quality_id == 8){
            $price = $assign->outprice_13;
        }
        if($request->quality_id == 9){
            $price = $assign->inprice_13;
        }
        if($request->quality_id == 10){
            $price = $assign->outprice_12;
        }
        if($request->quality_id == 11){
            $price = $assign->inprice_12;
        }
        if($request->quality_id == 12){
            $price = $assign->outprice_12_2;
        }
        if($request->quality_id == 13){
            $price = $assign->inprice_12_2;
        }
        $p = explode('/',$price)[0];
        return response()->json($p);
    }
    public function deletePurchase(Request $request){
        $purchase = PosPurchase::find($request->pid);
        $purchase->delete();
        Session::flash('message', 'Purchase was successfully Deleted!');
        return response()->json([
            'data'=> 'success'
        ],200);
    }
    public function editPurchase($id){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id',$this->getshopid())->get();
        $purchase = PosPurchase::find($id);
        $quality = PosQuality::all();
        $date = Carbon::now();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $shop_price = explode('/',$price->shop_price)[0];
        $out_price = explode('/',$price->shop_price)[1];

        return view('backend.pos.edit_purchase',['shopowner'=>$shopowner,'counters'=>$counters,'categories'=>$categories,'suppliers'=>$suppliers,'purchase'=>$purchase,'quality'=>$quality,'shop_price'=>$shop_price,'out_price'=>$out_price,'staffs'=>$staffs]);
    }
    public function updatePurchase(Request $request,$id){
       try{
        $purchase = PosPurchase::find($id);
        if($request->hasfile('photo')){
            $image = $request->file('photo');
               $filename = time()."-".$image->getClientOriginalName();
               if(env('USE_DO') != 'true'){
                $get_path = $image->move(public_path('main/images/pos/goldpurchase_photo/'), $filename);
                }else{
                    Storage::disk('digitalocean')->put('/prod/pos/goldpurchase_photo/'.$filename,file_get_contents($image));
                }
         }else{
             $filename = $purchase->photo;
         }

        $purchase->date = $request->date;
        $purchase->supplier_id = $request->supplier_id;
        $purchase->quality_id = $request->quality;
        $purchase->staff_id = $request->staff_id;
        $purchase->counter_shop = $request->counter;
        $purchase->color = $request->color;
        $purchase->purchase_price = $request->purchase_price;
        $purchase->category_id = $request->category_id;
        $purchase->code_number = $request->code_number;
        $purchase->product_gram_kyat_pe_yway = $request->product_gram.'/'.$request->product_kyat.'/'.$request->product_pe.'/'.$request->product_yway;
        $purchase->decrease_pe_yway = $request->decrease_pe.'/'.$request->decrease_yway;
        $purchase->profit_pe_yway = $request->profit_pe.'/'.$request->profit_yway;
        $purchase->service_pe_yway = $request->service_pe.'/'.$request->service_yway;
        $purchase->decrease_price = $request->decrease_price.'/'.$request->currency;
        $purchase->gold_price = $request->gold_price;
        $purchase->profit = $request->profit.'/'.$request->currency1;
        $purchase->service_fee = $request->service_fee.'/'.$request->currency2;
        $purchase->gold_fee = $request->gold_fee;
        $purchase->gold_type = $request->gold_type;
        $purchase->gold_name = $request->gold_name;
        $purchase->selling_price = $request->selling_price;
        $purchase->stock_qty = $request->stock_qty;
        $purchase->remark = $request->remark;
        $purchase->photo = $filename;
        $purchase->barcode = $request->code_number.'-'.$request->product_gram;
        $purchase->barcode_text = $request->barcode_text;
        $purchase->type = $request->inlineCheckbox;
        $purchase->save();
        if($request->shwe_item == 1){
            if($request->hasfile('photo')){
                if(env('USE_DO') != 'true'){
                $oldPath = public_path('main/images/pos/goldpurchase_photo/').$filename; // publc/images/1.jpg
                $newPath = public_path('/images/items/').$filename; // publc/images/2.jpg
               \File::copy($oldPath , $newPath);
                }else{
                    Storage::disk('digitalocean')->put('/prod/items/'.$filename,file_get_contents($image));
                }
            }
            if($request->inlineCheckbox == 'option1'){$gender = 'Women';}
            if($request->inlineCheckbox == 'option2'){$gender = 'Men';}
            if($request->inlineCheckbox == 'option3'){$gender = 'Unisex';}
            if($request->inlineCheckbox == 'option4'){$gender = 'Kid';}
            $item_purchase = PosItemPurchase::where('type',1)->where('purchase_id',$purchase->id)->first();
            $item = Item::find($item_purchase->item_id);
            $item->gold_quality =  $purchase->quality->name;
            $item->stock_count =  $request->stock_qty;
            $item->gold_colour =  $request->color;
            $item->category_id =   $purchase->category->name;
            $item->product_code =  $request->code_number;
            $item->d_gram =  $request->decrease_pe.'/'.$request->decrease_yway;
            $item->charge =  $request->service_fee;
            $item->name =  $request->gold_name;
            $item->price =  $request->selling_price;
            $item->description =  $request->remark;
            $item->default_photo =  $filename;
            $item->gender =  $gender;
            $item->save();
        }
        Session::flash('message', 'Purchase was successfully Updated!');
        return redirect()->route('backside.shop_owner.pos.purchase_list');
       } catch (\Exception $e) {
        return redirect()->back();
       }
    }
    public function detailPurchase($id){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id',$this->getshopid())->get();
        $purchase = PosPurchase::find($id);
        $quality = PosQuality::all();
        $date = Carbon::now();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $shop_price = explode('/',$price->shop_price)[0];
        $out_price = explode('/',$price->shop_price)[1];

        return view('backend.pos.detail_purchase',['shopowner'=>$shopowner,'categories'=>$categories,'suppliers'=>$suppliers,'purchase'=>$purchase,'quality'=>$quality,'shop_price'=>$shop_price,'out_price'=>$out_price,'staffs'=>$staffs]);
    }

        //kyout
    public function getKyoutPurchaseList(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosKyoutPurchase::where('shop_owner_id',$this->getshopid())->get();
        $suppliers = PosSupplier::where('shop_owner_id',$this->getshopid())->get();
        $dias = PosDiamond::where('shop_owner_id',$this->getshopid())->get();
        $cats = Category::all();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        if($assign_gold_price){
             return view('backend.pos.kyout_purchase_list',['shopowner'=>$shopowner,'counters'=>$counters,'purchases'=>$purchases,'sups'=>$suppliers,'dias'=>$dias,'cats'=>$cats]);
        }
        else{
            Session::flash('message', '​ရွှေ​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
            return view('backend.pos.assign_gold_price',['shopowner'=>$shopowner,'assign_gold_price'=>$assign_gold_price]);
        }
    }
    public function kyouttypeFilter(Request $request){
        if($request->type == 1){
            $type = explode('/',$request->text);
        $types = [];
        foreach($type as $t){
            $sup = PosKyoutPurchase::where('type', 'like', '%' . $t . '%')->where('shop_owner_id',$this->getshopid())->with('supplier')->get();
            array_push($types,$sup);
        }
        foreach($types as $tp){
            $data = collect($tp)->unique('id')->all();
        }
        }
        if($request->type == 2){
            $data = PosKyoutPurchase::whereBetween('date', [$request->start_date, $request->end_date])->where('shop_owner_id',$this->getshopid())->with('supplier')->with('quality')->get();
        }

        return response()->json([
            'data' => $data,
        ]);
    }
    public function kyoutadvanceFilter(Request $request){
        $data = $request->all();
        $query = PosKyoutPurchase::query();
        if(!empty($data['supid'])) {
            $result = $query->where('supplier_id',$data['supid']);
        }

        if(!empty($data['qualid'])) {
            $result = $query->where('diamonds', 'like', '%' . $data['qualid'] . '%');
        }

        if(!empty($data['catid'])) {
            $result = $query->where('category_id',$data['catid']);
        }
        $results = $query->where('shop_owner_id',$this->getshopid())->with('supplier')->with('quality')->get();
        return response()->json([
            'data' => $results,
        ]);
    }
    public function createKyoutPurchase(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id',$this->getshopid())->get();
        $quality = DB::table('pos_qualities')->get();
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $diamonds = PosDiamond::where('shop_owner_id',$this->getshopid())->get();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        if($price){
            $shop_price = explode('/',$price->shop_price)[0];
            $out_price = explode('/',$price->shop_price)[1];
            return view('backend.pos.create_kyout_purchase',['shopowner'=>$shopowner,'counters'=>$counters,'categories'=>$categories,'suppliers'=>$suppliers,'quality'=>$quality,'shop_price'=>$shop_price,'out_price'=>$out_price,'staffs'=>$staffs,'diamonds'=>$diamonds]);
        }
        else{
            Session::flash('message', '​ရွှေ​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
            return view('backend.pos.assign_gold_price',['shopowner'=>$shopowner,'assign_gold_price'=>$assign_gold_price]);
        }

    }

    public function getPhone(Request $request){
        $supplier = PosSupplier::find($request->supplier_id);
        return response()->json($supplier);
    }

    public function storeKyoutPurchase(Request $request){
        $validator = Validator::make($request->all(), [
            'code_number' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            if($request->hasfile('photo')){
                $image = $request->file('photo');
                $filename = time()."-".$image->getClientOriginalName();
                if(env('USE_DO') != 'true'){
                    $get_path = $image->move(public_path('main/images/pos/kyoutpurchase_photo/'), $filename);
                }else{
                    Storage::disk('digitalocean')->put('/prod/pos/kyoutpurchase_photo/'.$filename,file_get_contents($image));
                }

             }else{
                 $filename = 'default.png';
             }
             $purchase = PosKyoutPurchase::create([
                 'date' => $request->date,
                 'shop_owner_id' =>$this->getshopid(),
                 'supplier_id' => $request->supplier_id,
                 'quality_id' => $request->quality,
                 'staff_id' => $request->staff_id,
                 'counter_shop' => $request->counter,
                 'color' => $request->color,
                 'purchase_price' => $request->purchase_price,
                 'category_id' => $request->category_id,
                 'code_number' => $request->code_number,
                 'gold_gram_kyat_pe_yway' => $request->gold_gram.'/'.$request->gold_kyat.'/'.$request->gold_pe.'/'.$request->gold_yway,
                 'diamond_gram_kyat_pe_yway' => $request->diamond_gram.'/'.$request->diamond_kyat.'/'.$request->diamond_pe.'/'.$request->diamond_yway,
                 'decrease_pe_yway' => $request->decrease_pe.'/'.$request->decrease_yway,
                 'profit_pe_yway' => $request->profit_pe.'/'.$request->profit_yway,
                 'service_pe_yway' => $request->service_pe.'/'.$request->service_yway,
                 'decrease_price' => $request->decrease_price.'/'.$request->currency,
                 'gold_price' => $request->gold_price,
                 'profit' => $request->profit.'/'.$request->currency1,
                 'service_fee' => $request->service_fee.'/'.$request->currency2,
                 'gold_fee' => $request->gold_fee,
                 'gold_type' => $request->gold_type,
                 'gold_name' => $request->gold_name,
                 'selling_price' => $request->selling_price,
                 'diamond_selling_price' => $request->diamond_selling_price,
                 'capital' => $request->capital,
                 'stock_qty' => $request->stock_qty,
                 'qty' => $request->stock_qty,
                 'remark' => $request->remark,
                 'photo' => $filename,
                 'barcode_text' => $request->barcode_text,
                 'barcode' => $request->code_number.'-'.$request->gold_gram,
                 'type' => $request->inlineCheckbox,
             ]);
             if($request->include_diamonds){
                $diamonds = '';
             foreach($request->include_diamonds as $diamond){
                $diamonds .= $diamond.',';
                }
                $purchase->diamonds = $diamonds;
                $purchase->save();
             }
              if($request->counts){
                  $counts = '';
             foreach($request->counts as $count){
                $counts .= $count.',';
             }
             $purchase->counts = $counts;
                $purchase->save();
              }
             if($request->carrats){
                 $carrats = '';
             foreach($request->carrats as $carrat){
                $carrats .= $carrat.',';
             }
             $purchase->carrats = $carrats;
                $purchase->save();
             }
             if($request->yaties){
                 $yaties = '';
             foreach($request->yaties as $yatie){
                $yaties .= $yatie.',';
             }
             $purchase->yaties = $yaties;
                $purchase->save();
             }
             if($request->bes){
                $bes = '';
             foreach($request->bes as $be){
                $bes .= $be.',';
             }
                $purchase->bes = $bes;
                $purchase->save();
             }

             $count = PosSupplier::find($request->supplier_id);
             $count->count += 1;
             $count->save();

             if($request->shwe_item == 1){
                if($request->hasfile('photo')){
                    if(env('USE_DO') != 'true'){
                    $oldPath = public_path('main/images/pos/kyoutpurchase_photo/').$filename; // publc/images/1.jpg
                    $newPath = public_path('/images/items/').$filename; // publc/images/2.jpg
                   \File::copy($oldPath , $newPath);
                    }else{
                        Storage::disk('digitalocean')->put('/prod/items/'.$filename,file_get_contents($image));
                    }
                }

                if($request->inlineCheckbox == 'option1'){$gender = 'Women';}
                if($request->inlineCheckbox == 'option2'){$gender = 'Men';}
                if($request->inlineCheckbox == 'option3'){$gender = 'Unisex';}
                if($request->inlineCheckbox == 'option4'){$gender = 'Kid';}
                $item = Item::create([
                    'shop_id' =>$this->getshopid(),
                    'gold_quality' => $purchase->quality->name,
                    'stock_count' => $request->stock_qty,
                    'stock' =>'In Stock',
                    'gold_colour' => $request->color,
                    'category_id' =>  $purchase->category->name,
                    'main_category' => 2,
                    'product_code' => $request->code_number,
                    'weight' =>   '[]',
                    'weight_unit' => 0,
                    'd_gram' => $request->decrease_pe.'/'.$request->decrease_yway,
                    'charge' => $request->service_fee,
                    'name' => $request->gold_name,
                    'price' => $request->selling_price,
                    'description' => $request->remark,
                    'gender' => $gender,
                    'default_photo' => $filename,
                    'diamond' => $diamonds,
                    'carat' => $carrats,
                    'yati' => $yaties
                ]);
                PosItemPurchase::create([
                    'item_id' => $item->id,
                    'purchase_id' => $purchase->id,
                    'type' => 2
                ]);
            }

             Session::flash('message', 'Purchase was successfully Created!');

             return redirect()->route('backside.shop_owner.pos.kyout_purchase_list');
         } catch (\Exception $e) {

             Session::flash('alert-class', 'Something Wrong!');
             return redirect()->back();

         }
    }

    public function editKyoutPurchase($id){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id',$this->getshopid())->get();
        $purchase = PosKyoutPurchase::find($id);
        $quality = PosQuality::all();
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $diamonds = PosDiamond::where('shop_owner_id',$this->getshopid())->get();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        $shop_price = explode('/',$price->shop_price)[0];
        $out_price = explode('/',$price->shop_price)[1];

        return view('backend.pos.edit_kyout_purchase',['shopowner'=>$shopowner,'counters'=>$counters,'purchase'=>$purchase,'categories'=>$categories,'suppliers'=>$suppliers,'quality'=>$quality,'shop_price'=>$shop_price,'out_price'=>$out_price,'staffs'=>$staffs,'diamonds'=>$diamonds]);
    }

    public function updateKyoutPurchase(Request $request,$id){
        try{
         $purchase = PosKyoutPurchase::find($id);
         if($request->hasfile('photo')){
            $image = $request->file('photo');
            $filename = time()."-".$image->getClientOriginalName();
            if(env('USE_DO') != 'true'){
                $get_path = $image->move(public_path('main/images/pos/kyoutpurchase_photo/'), $filename);
            }else{
                Storage::disk('digitalocean')->put('/prod/pos/kyoutpurchase_photo/'.$filename,file_get_contents($image));
            }
          }else{
              $filename = $purchase->photo;
          }

        $purchase->date = $request->date;
        $purchase->supplier_id = $request->supplier_id;
        $purchase->quality_id = $request->quality;
        $purchase->staff_id = $request->staff_id;
        $purchase->counter_shop = $request->counter;
        $purchase->color = $request->color;
        $purchase->purchase_price = $request->purchase_price;
        $purchase->category_id = $request->category_id;
        $purchase->code_number = $request->code_number;
        $purchase->gold_gram_kyat_pe_yway = $request->gold_gram.'/'.$request->gold_kyat.'/'.$request->gold_pe.'/'.$request->gold_yway;
        $purchase->diamond_gram_kyat_pe_yway = $request->diamond_gram.'/'.$request->diamond_kyat.'/'.$request->diamond_pe.'/'.$request->diamond_yway;
        $purchase->decrease_pe_yway = $request->decrease_pe.'/'.$request->decrease_yway;
        $purchase->profit_pe_yway = $request->profit_pe.'/'.$request->profit_yway;
        $purchase->service_pe_yway = $request->service_pe.'/'.$request->service_yway;
        $purchase->decrease_price = $request->decrease_price.'/'.$request->currency;
        $purchase->gold_price = $request->gold_price;
        $purchase->profit = $request->profit.'/'.$request->currency1;
        $purchase->service_fee = $request->service_fee.'/'.$request->currency2;
        $purchase->gold_fee = $request->gold_fee;
        $purchase->gold_type = $request->gold_type;
        $purchase->gold_name = $request->gold_name;
        $purchase->selling_price = $request->selling_price;
        $purchase->diamond_selling_price = $request->diamond_selling_price;
        $purchase->capital = $request->capital;
        $purchase->stock_qty = $request->stock_qty;
        $purchase->remark = $request->remark;
        $purchase->photo = $filename;
        $purchase->barcode_text = $request->barcode_text;
        $purchase->barcode = $request->code_number.'-'.$request->gold_gram;
        $purchase->type = $request->inlineCheckbox;
        $purchase->save();
         if($request->diamond_name){
                $diamonds = '';
             foreach($request->diamond_name as $diamond){
                $diamonds .= $diamond.',';
                }
                $purchase->diamonds = $diamonds;
                $purchase->save();
             }
              if($request->counts){
                  $counts = '';
             foreach($request->counts as $count){
                $counts .= $count.',';
             }
             $purchase->counts = $counts;
                $purchase->save();
              }
             if($request->carrats){
                 $carrats = '';
             foreach($request->carrats as $carrat){
                $carrats .= $carrat.',';
             }
             $purchase->carrats = $carrats;
                $purchase->save();
             }
             if($request->yaties){
                 $yaties = '';
             foreach($request->yaties as $yatie){
                $yaties .= $yatie.',';
             }
             $purchase->yaties = $yaties;
                $purchase->save();
             }
             if($request->bes){
                $bes = '';
             foreach($request->bes as $be){
                $bes .= $be.',';
             }
                $purchase->bes = $bes;
                $purchase->save();
             }
             if($request->shwe_item == 1){
                if($request->hasfile('photo')){
                    if(env('USE_DO') != 'true'){
                    $oldPath = public_path('main/images/pos/kyoutpurchase_photo/').$filename; // publc/images/1.jpg
                    $newPath = public_path('/images/items/').$filename; // publc/images/2.jpg
                   \File::copy($oldPath , $newPath);
                    }else{
                        Storage::disk('digitalocean')->put('/prod/items/'.$filename,file_get_contents($image));
                    }
                }
                if($request->inlineCheckbox == 'option1'){$gender = 'Women';}
                if($request->inlineCheckbox == 'option2'){$gender = 'Men';}
                if($request->inlineCheckbox == 'option3'){$gender = 'Unisex';}
                if($request->inlineCheckbox == 'option4'){$gender = 'Kid';}
                $item_purchase = PosItemPurchase::where('type',2)->where('purchase_id',$purchase->id)->first();
                $item = Item::find($item_purchase->item_id);
                $item->gold_quality = $purchase->quality->name;
                $item->stock_count = $request->stock_qty;
                $item->gold_colour = $request->color;
                $item->category_id =  $purchase->category->name;
                $item->product_code = $request->code_number;
                $item->d_gram = $request->decrease_pe.'/'.$request->decrease_yway;
                $item->charge = $request->service_fee;
                $item->name = $request->gold_name;
                $item->price = $request->selling_price;
                $item->description = $request->remark;
                $item->gender = $gender;
                $item->default_photo = $filename;
                $item->diamond = $diamonds;
                $item->carat = $carrats;
                $item->yati = $yaties;
                $item->save();
            }
         Session::flash('message', 'Purchase was successfully Updated!');
         return redirect()->route('backside.shop_owner.pos.kyout_purchase_list');
        } catch (\Exception $e) {
         return redirect()->back();
        }
     }

    public function deleteKyoutPurchase(Request $request){
        $purchase = PosKyoutPurchase::find($request->pid);
        $purchase->delete();
        Session::flash('message', 'Kyout Purchase was successfully Deleted!');
        return response()->json([
            'data'=> 'success'
        ],200);
    }
    public function detailKyoutPurchase($id){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id',$this->getshopid())->get();
        $purchase = PosKyoutPurchase::find($id);
        $quality = PosQuality::all();
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $diamonds = PosDiamond::where('shop_owner_id',$this->getshopid())->get();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        $shop_price = explode('/',$price->shop_price)[0];
        $out_price = explode('/',$price->shop_price)[1];

        return view('backend.pos.detail_kyout_purchase',['shopowner'=>$shopowner,'purchase'=>$purchase,'categories'=>$categories,'suppliers'=>$suppliers,'quality'=>$quality,'shop_price'=>$shop_price,'out_price'=>$out_price,'staffs'=>$staffs,'diamonds'=>$diamonds]);
    }

    //Platinum
    public function getPtmPurchaseList(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosPlatinumPurchase::where('shop_owner_id',$this->getshopid())->get();
        $cats = Category::all();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        if($assign_gold_price){
             return view('backend.pos.platinum_purchase_list',['shopowner'=>$shopowner,'counters'=>$counters,'purchases'=>$purchases,'cats'=>$cats]);
        }
        else{
            Session::flash('message', 'ပလက်တီနမ်​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
            return view('backend.pos.assign_platinum_price',['shopowner'=>$shopowner,'assign_gold_price'=>$assign_gold_price]);
        }

    }
    public function createPtmPurchase(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $date = Carbon::now();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id',$this->getshopid())->get();
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $price = PosAssignPlatinumPrice::where('shop_owner_id',$this->getshopid())->first();
        if($price){
            $gradeA = $price->gradeA;
           $gradeB = $price->gradeB;
            return view('backend.pos.create_platinum_purchase',['shopowner'=>$shopowner,'suppliers'=>$suppliers,'counters'=>$counters,'categories'=>$categories,'gradeA'=>$gradeA,'gradeB'=>$gradeB,'staffs'=>$staffs]);
        }
        else{
            Session::flash('message', 'ပလက်တီနမ်​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
            return view('backend.pos.assign_platinum_price',['shopowner'=>$shopowner,'assign_gold_price'=>$assign_gold_price]);
        }
    }
    public function getPtmQualityPrice(Request $request){
        $assign = PosAssignPlatinumPrice::where('shop_owner_id',$this->getshopid())->first();
        if($request->quality == 'Grade A'){
            $price = $assign->gradeA;
        }
        if($request->quality == 'Grade B'){
            $price = $assign->gradeB;
        }
        if($request->quality == 'Grade C'){
            $price = $assign->gradeC;
        }
        if($request->quality == 'Grade D'){
            $price = $assign->gradeD;
        }
        return response()->json($price);
    }
    public function storePtmPurchase(Request $request){
        $validator = Validator::make($request->all(), [
            'code_number' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
           if($request->hasfile('photo')){
               $image = $request->file('photo');
               $filename = time()."-".$image->getClientOriginalName();
                if(env('USE_DO') != 'true'){
                    $get_path = $image->move(public_path('main/images/pos/platinumpurchase_photo/'), $filename);
                }else{
                    Storage::disk('digitalocean')->put('/prod/pos/platinumpurchase_photo/'.$filename,file_get_contents($image));
                }
            }else{
                $filename = 'default.png';
            }
            $purchase = PosPlatinumPurchase::create([
                'date' => $request->date,
                'shop_owner_id' =>$this->getshopid(),
                'supplier_id' => $request->supplier_id,
                'quality' => $request->quality,
                'staff_id' => $request->staff_id,
                'counter_shop' => $request->counter,
                'color' => $request->color,
                'purchase_price' => $request->purchase_price,
                'category_id' => $request->category_id,
                'code_number' => $request->code_number,
                'product_gram' => $request->product_gram,
                'platinum_price' => $request->ptm_price,
                'profit' => $request->profit.'/'.$request->currency1,
                'platinum_type' => $request->ptm_type,
                'platinum_name' => $request->ptm_name,
                'selling_price' => $request->selling_price,
                'stock_qty' => $request->stock_qty,
                'qty' => $request->stock_qty,
                'remark' => $request->remark,
                'photo' => $filename,
                'capital' => $request->capital,
                'barcode_text' => $request->barcode_text,
                'barcode' => $request->code_number.'-'.$request->product_gram,
                'type' => $request->inlineCheckbox
            ]);

             if($request->shwe_item == 1){
                if($request->hasfile('photo')){
                    if(env('USE_DO') != 'true'){
                    $oldPath = public_path('main/images/pos/platinumpurchase_photo/').$filename; // publc/images/1.jpg
                    $newPath = public_path('/images/items/').$filename; // publc/images/2.jpg
                   \File::copy($oldPath , $newPath);
                    }else{
                        Storage::disk('digitalocean')->put('/prod/items/'.$filename,file_get_contents($image));
                    }
                }

                if($request->inlineCheckbox == 'option1'){$gender = 'Women';}
                if($request->inlineCheckbox == 'option2'){$gender = 'Men';}
                if($request->inlineCheckbox == 'option3'){$gender = 'Unisex';}
                if($request->inlineCheckbox == 'option4'){$gender = 'Kid';}
                $item = Item::create([
                    'shop_id' =>$this->getshopid(),
                    'gold_quality' => $request->quality,
                    'stock_count' => $request->stock_qty,
                    'stock' =>'In Stock',
                    'gold_colour' => $request->color,
                    'category_id' =>  $purchase->category->name,
                    'main_category' => 4,
                    'product_code' => $request->code_number,
                    'weight' => '[]',
                    'weight_unit' => 0,
                    'name' => $request->ptm_name,
                    'price' => $request->selling_price,
                    'description' => $request->remark,
                    'default_photo' => $filename,
                    'gender' => $gender,
                ]);
                PosItemPurchase::create([
                    'item_id' => $item->id,
                    'purchase_id' => $purchase->id,
                    'type' => 3
                ]);
            }

            Session::flash('message', 'Purchase was successfully Created!');

            return redirect()->route('backside.shop_owner.pos.ptm_purchase_list');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
    public function editPtmPurchase($id){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $date = Carbon::now();
        $purchase = PosPlatinumPurchase::find($id);
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $price = PosAssignPlatinumPrice::where('shop_owner_id',$this->getshopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.edit_platinum_purchase',['shopowner'=>$shopowner,'counters'=>$counters,'categories'=>$categories,'gradeA'=>$gradeA,'gradeB'=>$gradeB,'purchase'=>$purchase,'staffs'=>$staffs]);
    }
    public function deletePtmPurchase(Request $request){
        $purchase = PosPlatinumPurchase::find($request->pid);
        $purchase->delete();
        Session::flash('message', 'Purchase was successfully Deleted!');
        return response()->json([
            'data'=> 'success'
        ],200);
    }
    public function updatePtmPurchase(Request $request,$id){
        try{
         $purchase = PosPlatinumPurchase::find($id);
         if($request->hasfile('photo')){
            $image = $request->file('photo');
            $filename = time()."-".$image->getClientOriginalName();
             if(env('USE_DO') != 'true'){
                 $get_path = $image->move(public_path('main/images/pos/platinumpurchase_photo/'), $filename);
             }else{
                 Storage::disk('digitalocean')->put('/prod/pos/platinumpurchase_photo/'.$filename,file_get_contents($image));
             }
          }else{
              $filename = $purchase->photo;
          }

         $purchase->date = $request->date;
         $purchase->quality = $request->quality;
         $purchase->staff_id = $request->staff_id;
         $purchase->counter_shop = $request->counter;
         $purchase->color = $request->color;
         $purchase->purchase_price = $request->purchase_price;
         $purchase->category_id = $request->category_id;
         $purchase->code_number = $request->code_number;
         $purchase->product_gram = $request->product_gram;
         $purchase->platinum_price = $request->ptm_price;
         $purchase->profit = $request->profit.'/'.$request->currency1;
         $purchase->platinum_type = $request->ptm_type;
         $purchase->platinum_name = $request->ptm_name;
         $purchase->selling_price = $request->selling_price;
         $purchase->stock_qty = $request->stock_qty;
         $purchase->remark = $request->remark;
         $purchase->photo = $filename;
         $purchase->capital = $request->capital;
         $purchase->barcode_text = $request->barcode_text;
         $purchase->barcode = $request->code_number.'-'.$request->product_gram;
         $purchase->type = $request->inlineCheckbox;
         $purchase->save();
         if($request->shwe_item == 1){
            if($request->hasfile('photo')){
                if(env('USE_DO') != 'true'){
                $oldPath = public_path('main/images/pos/platinumpurchase_photo/').$filename; // publc/images/1.jpg
                $newPath = public_path('/images/items/').$filename; // publc/images/2.jpg
               \File::copy($oldPath , $newPath);
                }else{
                    Storage::disk('digitalocean')->put('/prod/items/'.$filename,file_get_contents($image));
                }
            }

            if($request->inlineCheckbox == 'option1'){$gender = 'Women';}
            if($request->inlineCheckbox == 'option2'){$gender = 'Men';}
            if($request->inlineCheckbox == 'option3'){$gender = 'Unisex';}
            if($request->inlineCheckbox == 'option4'){$gender = 'Kid';}
            $item_purchase = PosItemPurchase::where('type',3)->where('purchase_id',$purchase->id)->first();
            $item = Item::find($item_purchase->item_id);
            $item->gold_quality = $request->quality;
            $item->stock_count = $request->stock_qty;
            $item->gold_colour = $request->color;
            $item->category_id =  $purchase->category->name;
            $item->product_code = $request->code_number;
            $item->name = $request->ptm_name;
            $item->price = $request->selling_price;
            $item->description = $request->remark;
            $item->default_photo = $filename;
            $item->gender = $gender;
            $item->save();
        }
         Session::flash('message', 'Purchase was successfully Updated!');
         return redirect()->route('backside.shop_owner.pos.ptm_purchase_list');
        } catch (\Exception $e) {
         return redirect()->back();
        }
     }
    public function ptmtypeFilter(Request $request){
        if($request->type == 1){
            $type = explode('/',$request->text);
        $types = [];
        foreach($type as $t){
            $sup = PosPlatinumPurchase::where('type', 'like', '%' . $t . '%')->where('shop_owner_id',$this->getshopid())->get();
            array_push($types,$sup);
        }
        foreach($types as $tp){
            $data = collect($tp)->unique('id')->all();
        }
        }
        if($request->type == 2){
            $data = PosPlatinumPurchase::whereBetween('date', [$request->start_date, $request->end_date])->where('shop_owner_id',$this->getshopid())->get();
        }

        return response()->json([
            'data' => $data,
        ]);
    }
    public function platinumadvanceFilter(Request $request){
        $data = $request->all();
        $query = PosPlatinumPurchase::query();

        if(!empty($data['qualid'])) {
            $result = $query->where('quality',$data['qualid']);
        }

        if(!empty($data['catid'])) {
            $result = $query->where('category_id',$data['catid']);
        }
        $results = $query->where('shop_owner_id',$this->getshopid())->get();

        return response()->json([
            'data' => $results,
        ]);
    }
    public function detailPtmPurchase($id){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $date = Carbon::now();
        $purchase = PosPlatinumPurchase::find($id);
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $price = PosAssignPlatinumPrice::where('shop_owner_id',$this->getshopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.detail_platinum_purchase',['shopowner'=>$shopowner,'categories'=>$categories,'gradeA'=>$gradeA,'gradeB'=>$gradeB,'purchase'=>$purchase,'staffs'=>$staffs]);
    }

    //WhiteGold
    public function getWgPurchaseList(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosWhiteGoldPurchase::where('shop_owner_id',$this->getshopid())->get();
        $cats = Category::all();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        if($assign_gold_price){
             return view('backend.pos.whitegold_purchase_list',['shopowner'=>$shopowner,'counters'=>$counters,'purchases'=>$purchases,'cats'=>$cats]);
        }
        else{
            Session::flash('message', 'ရွှေဖြူ​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
            return view('backend.pos.assign_whitegold_price',['shopowner'=>$shopowner,'assign_gold_price'=>$assign_gold_price]);
        }

    }
    public function createWgPurchase(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $date = Carbon::now();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id',$this->getshopid())->get();
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $price = PosAssignWhiteGoldPrice::where('shop_owner_id',$this->getshopid())->first();
        if($price){
            $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;
           return view('backend.pos.create_whitegold_purchase',['shopowner'=>$shopowner,'suppliers'=>$suppliers,'counters'=>$counters,'categories'=>$categories,'gradeA'=>$gradeA,'gradeB'=>$gradeB,'staffs'=>$staffs]);
        }
        else{
            Session::flash('message', 'ရွှေဖြူစျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
            return view('backend.pos.assign_whitegold_price',['shopowner'=>$shopowner,'assign_gold_price'=>$assign_gold_price]);
        }
    }
    public function getWgQualityPrice(Request $request){
        $assign = PosAssignWhiteGoldPrice::where('shop_owner_id',$this->getshopid())->first();
        if($request->quality == 'Grade A'){
            $price = $assign->gradeA;
        }
        if($request->quality == 'Grade B'){
            $price = $assign->gradeB;
        }
        if($request->quality == 'Grade C'){
            $price = $assign->gradeC;
        }
        if($request->quality == 'Grade D'){
            $price = $assign->gradeD;
        }
        return response()->json($price);
    }
    public function storeWgPurchase(Request $request){
        $validator = Validator::make($request->all(), [
            'code_number' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try{
           if($request->hasfile('photo')){
               $image = $request->file('photo');
               $filename = strtolower($image->getClientOriginalName());
               if(env('USE_DO') != 'true'){
                $get_path = $image->move(public_path('main/images/pos/whitegoldpurchase_photo/'), $filename);
                }else{
                    Storage::disk('digitalocean')->put('/prod/pos/whitegoldpurchase_photo/'.$filename,file_get_contents($image));
                }
            }else{
                $filename = 'default.png';
            }

            $purchase = PosWhiteGoldPurchase::create([
                'date' => $request->date,
                'shop_owner_id' =>$this->getshopid(),
                'supplier_id' => $request->supplier_id,
                'quality' => $request->quality,
                'staff_id' => $request->staff_id,
                'counter_shop' => $request->counter,
                'color' => $request->color,
                'purchase_price' => $request->purchase_price,
                'category_id' => $request->category_id,
                'code_number' => $request->code_number,
                'product_gram' => $request->product_gram,
                'whitegold_price' => $request->wg_price,
                'profit' => $request->profit.'/'.$request->currency1,
                'whitegold_type' => $request->wg_type,
                'whitegold_name' => $request->wg_name,
                'selling_price' => $request->selling_price,
                'stock_qty' => $request->stock_qty,
                'qty' => $request->stock_qty,
                'remark' => $request->remark,
                'photo' => $filename,
                'capital' => $request->capital,
                'barcode_text' => $request->barcode_text,
                'barcode' => $request->code_number.'-'.$request->product_gram,
                'type' => $request->inlineCheckbox
            ]);

            if($request->shwe_item == 1){
                if($request->hasfile('photo')){
                    if(env('USE_DO') != 'true'){
                    $oldPath = public_path('main/images/pos/whitegoldpurchase_photo/').$filename; // publc/images/1.jpg
                    $newPath = public_path('/images/items/').$filename; // publc/images/2.jpg
                   \File::copy($oldPath , $newPath);
                    }else{
                        Storage::disk('digitalocean')->put('/prod/items/'.$filename,file_get_contents($image));
                    }
                }

                if($request->inlineCheckbox == 'option1'){$gender = 'Women';}
                if($request->inlineCheckbox == 'option2'){$gender = 'Men';}
                if($request->inlineCheckbox == 'option3'){$gender = 'Unisex';}
                if($request->inlineCheckbox == 'option4'){$gender = 'Kid';}
                $item = Item::create([
                    'shop_id' =>$this->getshopid(),
                    'gold_quality' => $request->quality,
                    'stock_count' => $request->stock_qty,
                    'stock' =>'In Stock',
                    'gold_colour' => $request->color,
                    'category_id' =>  $purchase->category->name,
                    'main_category' => 3,
                    'product_code' => $request->code_number,
                    'weight' =>  '[]',
                    'weight_unit' => 0,
                    'default_photo' => $filename,
                    'name' => $request->wg_name,
                    'price' => $request->selling_price,
                    'description' => $request->remark,
                    'gender' => $gender,
                ]);
                PosItemPurchase::create([
                    'item_id' => $item->id,
                    'purchase_id' => $purchase->id,
                    'type' => 4
                ]);
            }

            Session::flash('message', 'Purchase was successfully Created!');

            return redirect()->route('backside.shop_owner.pos.wg_purchase_list');
        } catch (\Exception $e) {
            return redirect()->back();
        }

    }
    public function editWgPurchase($id){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $date = Carbon::now();
        $purchase = PosWhiteGoldPurchase::find($id);
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $price = PosAssignWhiteGoldPrice::where('shop_owner_id',$this->getshopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.edit_whitegold_purchase',['shopowner'=>$shopowner,'counters'=>$counters,'categories'=>$categories,'gradeA'=>$gradeA,'gradeB'=>$gradeB,'purchase'=>$purchase,'staffs'=>$staffs]);
    }
    public function deleteWgPurchase(Request $request){
        $purchase = PosWhiteGoldPurchase::find($request->pid);
        $purchase->delete();
        Session::flash('message', 'Purchase was successfully Deleted!');
        return response()->json([
            'data'=> 'success'
        ],200);
    }
    public function updateWgPurchase(Request $request,$id){
        try{
         $purchase = PosWhiteGoldPurchase::find($id);
         if($request->hasfile('photo')){
            $image = $request->file('photo');
               $filename = strtolower($image->getClientOriginalName());
               if(env('USE_DO') != 'true'){
                $get_path = $image->move(public_path('main/images/pos/whitegoldpurchase_photo/'), $filename);
                }else{
                    Storage::disk('digitalocean')->put('/prod/pos/whitegoldpurchase_photo/'.$filename,file_get_contents($image));
                }
          }else{
              $filename = $purchase->photo;
          }

         $purchase->date = $request->date;
         $purchase->quality = $request->quality;
         $purchase->staff_id = $request->staff_id;
         $purchase->counter_shop = $request->counter;
         $purchase->color = $request->color;
         $purchase->purchase_price = $request->purchase_price;
         $purchase->category_id = $request->category_id;
         $purchase->code_number = $request->code_number;
         $purchase->product_gram = $request->product_gram;
         $purchase->whitegold_price = $request->wg_price;
         $purchase->profit = $request->profit.'/'.$request->currency1;
         $purchase->whitegold_type = $request->wg_type;
         $purchase->whitegold_name = $request->wg_name;
         $purchase->selling_price = $request->selling_price;
         $purchase->stock_qty = $request->stock_qty;
         $purchase->remark = $request->remark;
         $purchase->photo = $filename;
         $purchase->capital = $request->capital;
         $purchase->barcode_text = $request->barcode_text;
         $purchase->barcode = $request->code_number.'-'.$request->product_gram;
         $purchase->type = $request->inlineCheckbox;
         $purchase->save();
         if($request->shwe_item == 1){
            if($request->hasfile('photo')){
                if(env('USE_DO') != 'true'){
                $oldPath = public_path('main/images/pos/whitegoldpurchase_photo/').$filename; // publc/images/1.jpg
                $newPath = public_path('/images/items/').$filename; // publc/images/2.jpg
               \File::copy($oldPath , $newPath);
                }else{
                    Storage::disk('digitalocean')->put('/prod/items/'.$filename,file_get_contents($image));
                }
            }

            if($request->inlineCheckbox == 'option1'){$gender = 'Women';}
            if($request->inlineCheckbox == 'option2'){$gender = 'Men';}
            if($request->inlineCheckbox == 'option3'){$gender = 'Unisex';}
            if($request->inlineCheckbox == 'option4'){$gender = 'Kid';}
            $item_purchase = PosItemPurchase::where('type',4)->where('purchase_id',$purchase->id)->first();
            $item = Item::find($item_purchase->item_id);
            $item->gold_quality = $request->quality;
            $item->stock_count = $request->stock_qty;
            $item->gold_colour = $request->color;
            $item->category_id =  $purchase->category->name;
            $item->product_code = $request->code_number;
            $item->default_photo = $filename;
            $item->name = $request->wg_name;
            $item->price = $request->selling_price;
            $item->description = $request->remark;
            $item->gender = $gender;
            $item->save();
        }
         Session::flash('message', 'Purchase was successfully Updated!');
         return redirect()->route('backside.shop_owner.pos.wg_purchase_list');
        } catch (\Exception $e) {
         return redirect()->back();
        }
     }
    public function wgtypeFilter(Request $request){
        if($request->type == 1){
            $type = explode('/',$request->text);
        $types = [];
        foreach($type as $t){
            $sup = PosWhiteGoldPurchase::where('type', 'like', '%' . $t . '%')->where('shop_owner_id',$this->getshopid())->get();
            array_push($types,$sup);
        }
        foreach($types as $tp){
            $data = collect($tp)->unique('id')->all();
        }
        }
        if($request->type == 2){
            $data = PosWhiteGoldPurchase::whereBetween('date', [$request->start_date, $request->end_date])->where('shop_owner_id',$this->getshopid())->get();
        }

        return response()->json([
            'data' => $data,
        ]);
    }
    public function whitegoldadvanceFilter(Request $request){
        $data = $request->all();
        $query = PosWhiteGoldPurchase::query();

        if(!empty($data['qualid'])) {
            $result = $query->where('quality',$data['qualid']);
        }

        if(!empty($data['catid'])) {
            $result = $query->where('category_id',$data['catid']);
        }
        $results = $query->where('shop_owner_id',$this->getshopid())->get();

        return response()->json([
            'data' => $results,
        ]);
    }
    public function detailWgPurchase($id){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $date = Carbon::now();
        $purchase = PosWhiteGoldPurchase::find($id);
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $price = PosAssignWhiteGoldPrice::where('shop_owner_id',$this->getshopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.detail_whitegold_purchase',['shopowner'=>$shopowner,'categories'=>$categories,'gradeA'=>$gradeA,'gradeB'=>$gradeB,'purchase'=>$purchase,'staffs'=>$staffs]);
    }

    //Sale
       //Gold
    public function saleGoldList(){
    $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
    $purchases = PosGoldSale::where('shop_owner_id',$this->getshopid())->get();
    $suppliers = PosSupplier::where('shop_owner_id',$this->getshopid())->get();
    $quals = PosQuality::all();
    $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
    $cats = Category::all();

    return view('backend.pos.sale_gold_list',['shopowner'=>$shopowner,'counters'=>$counters,'purchases'=>$purchases,'sups'=>$suppliers,'quals'=>$quals,'cats'=>$cats]);
    }
    public function goldsaletypeFilter(Request $request){
        if($request->type == 2){
            $data = PosGoldSale::whereBetween('date', [$request->start_date, $request->end_date])->where('shop_owner_id',$this->getshopid())->with('purchase')->get();
        }
        return response()->json([
            'data' => $data,
        ]);
    }
    public function goldsaleadvanceFilter(Request $request){
        $data1 = PosGoldSale::where('shop_owner_id',$this->getshopid())->get();
        $arr = [];
        if($request->supid && $request->qualid && $request->catid){
            foreach($data1 as $dt){
                if($dt->purchase->supplier_id == $request->supid && $dt->purchase->quality_id == $request->qualid && $dt->purchase->category_id == $request->catid){
                    array_push($arr,$dt);
                }
            }
        }
        else if($request->supid && $request->qualid){
            foreach($data1 as $dt){
                if($dt->purchase->supplier_id == $request->supid && $dt->purchase->quality_id == $request->qualid){
                    array_push($arr,$dt);
                }
            }
        }else if($request->supid && $request->catid){
            foreach($data1 as $dt){
                if($dt->purchase->supplier_id == $request->supid && $dt->purchase->category_id == $request->catid){
                    array_push($arr,$dt);
                }
            }
        }else if($request->qualid && $request->catid){
            foreach($data1 as $dt){
                if($dt->purchase->quality_id == $request->qualid && $dt->purchase->category_id == $request->catid){
                    array_push($arr,$dt);
                }
            }
        }else if($request->supid){
            foreach($data1 as $dt){
                if($dt->purchase->supplier_id == $request->supid){
                    array_push($arr,$dt);
                }
            }
        }else if($request->qualid){
            foreach($data1 as $dt){
                if($dt->purchase->quality_id == $request->qualid){
                    array_push($arr,$dt);
                }
            }
        }else if($request->catid){
            foreach($data1 as $dt){
                if($dt->purchase->category_id == $request->catid){
                    array_push($arr,$dt);
                }
            }
        }

        return response()->json([
            'data' => $arr,
        ]);
    }
    public function editGoldSale($id){
    $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
    $purchases = PosPurchase::where('shop_owner_id',$this->getshopid())->get();
    $sale = PosGoldSale::where('id',$id)->first();
    $date = Carbon::now();
    $price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
    $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
    $counters  = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
    $shop_price = explode('/',$price->shop_price)[0];
    $out_price = explode('/',$price->shop_price)[1];

    return view('backend.pos.edit_sale_purchase',['shopowner'=>$shopowner,'counters'=>$counters,'sale'=>$sale,'shop_price'=>$shop_price,'out_price'=>$out_price,'staffs'=>$staffs,'purchases'=>$purchases]);
    }
    public function updateGoldSale(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try{
        $gold_sale = PosGoldSale::find($id);
        $gold_sale->date = $request->date;
        $gold_sale->purchase_id = $request->purchase_id;
        $gold_sale->staff_id = $request->staff_id;
        $gold_sale->counter_shop = $request->counter;
        $gold_sale->remark = $request->remark;
        $gold_sale->customer_name = $request->name;
        $gold_sale->phone = $request->phone;
        $gold_sale->address = $request->address;
        $gold_sale->price = $request->price;
        $gold_sale->total_price = $request->total_price;
        $gold_sale->selling_price = $request->selling_price;
        $gold_sale->decrease_price = $request->de_price;
        $gold_sale->amount = $request->amount;
        $gold_sale->prepaid = $request->prepaid;
        $gold_sale->credit = $request->credit;
        $gold_sale->return_price = $request->return_fee;
        $gold_sale->left_price = $request->left_fee;
        $gold_sale->save();
        Session::flash('message', 'Gold Sale was successfully Updated!');
        return redirect()->route('backside.shop_owner.pos.gold_sale_list');
    } catch (\Exception $e) {
        return redirect()->back();
    }
    }

    public function deleteGoldSale(Request $request){
        $diamond = PosGoldSale::find($request->pid);
        $diamond->delete();
        Session::flash('message', 'Gold Sale was successfully Deleted!');
        return response()->json([
            'data'=> 'success'
        ],200);
    }
    public function detailGoldSale($id){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id',$this->getshopid())->get();
        $purchase = PosGoldSale::find($id);
        $quality = PosQuality::all();
        $date = Carbon::now();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $shop_price = explode('/',$price->shop_price)[0];
        $out_price = explode('/',$price->shop_price)[1];

        return view('backend.pos.detail_gold_sale',['shopowner'=>$shopowner,'categories'=>$categories,'suppliers'=>$suppliers,'purchase'=>$purchase,'quality'=>$quality,'shop_price'=>$shop_price,'out_price'=>$out_price,'staffs'=>$staffs]);
    }

    public function salePurchase(){
    $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
    $purchases = PosPurchase::where('shop_owner_id',$this->getshopid())->get();
    $date = Carbon::now();
    $price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
    $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
    $categories = Category::all();
    $quality = DB::table('pos_qualities')->get();
    $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
    if($price){
        $shop_price = explode('/',$price->shop_price)[0];
        $out_price = explode('/',$price->shop_price)[1];

    return view('backend.pos.sale_purchase',['shopowner'=>$shopowner,'counters'=>$counters,'shop_price'=>$shop_price,'out_price'=>$out_price,'staffs'=>$staffs,'purchases'=>$purchases,'categories'=>$categories,'quality'=>$quality]);
    }
    else{
        Session::flash('message', '​ရွှေ​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        return view('backend.pos.assign_gold_price',['shopowner'=>$shopowner,'assign_gold_price'=>$assign_gold_price]);
    }

    }
    public function getSaleValues(Request $request){
        $purchase = PosPurchase::where('id',$request->purchase_id)->where('shop_owner_id',$this->getshopid())->with('quality')->with('category')->first();
        $product_gram_kyat_pe_yway = explode('/',$purchase->product_gram_kyat_pe_yway);
        $service_pe_yway = explode('/',$purchase->service_pe_yway);
        $decrease_pe_yway = explode('/',$purchase->decrease_pe_yway);
        $profit_pe_yway = explode('/',$purchase->profit_pe_yway);
        $decrease_price = explode('/',$purchase->decrease_price);
        $profit = explode('/',$purchase->profit);
        $service_fee = explode('/',$purchase->service_fee);
        return response()->json([
        'purchase' => $purchase,
        'product' => $product_gram_kyat_pe_yway,
        'service' => $service_pe_yway,
        'decrease' => $decrease_pe_yway,
        'profitt' => $profit_pe_yway,
        'decrease_price' => $decrease_price,
        'profit' => $profit,
        'service_fee' => $service_fee,
        ]);
    }
    public function storeGoldSale(Request $request){
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required',
            'staff_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
        $gold_sale = PosGoldSale::create([
            'date' => $request->date,
            'shop_owner_id' =>$this->getshopid(),
            'purchase_id' => $request->purchase_id,
            'staff_id' => $request->staff_id,
            'counter_shop' => $request->counter,
            'remark' => $request->remark,
            'customer_name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'price' => $request->price,
            'amount' => $request->amount,
            'prepaid' => $request->prepaid,
            'credit' => $request->credit,
        ]);
        if($request->credit != 0){

            $credit = PosCreditList::create([
                'purchase_date' => $request->date,
                'shop_owner_id' =>$this->getshopid(),
                'purchase_code' =>$request->code_number,
                'credit' => $request->credit,
                'customer_name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address
            ]);
        }
        $purchase = PosPurchase::find($request->purchase_id);
        $purchase->stock_qty -= 1;
        $purchase->sell_flag = 1;
        $purchase->save();

        $sold = PosPurchaseSale::where('purchase_id',$request->purchase_id)->where('type',1)->count();
        if($sold<1){
            PosPurchaseSale::create([
                'purchase_id' => $request->purchase_id,
                'shop_owner_id' =>$this->getshopid(),
                'sale_id'=> $gold_sale->id,
                'qty' => 1,
                'type' => 1,
            ]);
        }else{
            $exit = PosPurchaseSale::where('purchase_id',$request->purchase_id)->first();
            $exit->qty += 1;
            $exit->save();
        }

        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        Session::flash('message', 'Gold Sale was successfully Created!');
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        $shop_price = explode('/',$price->shop_price)[0];
        $price15 = explode('/',$price->inprice_15)[0];
        return view('backend.pos.sale_voucher_list',['shopowner'=>$shopowner,'sale'=>$gold_sale,'counters'=>$counters,'gold_fee'=>$request->price,'service_fee'=>$request->service_fee,'diamond_fee'=>0,'shop_price'=>$shop_price,'price15'=>$price15,'cancel'=>1]);
    } catch (\Exception $e) {
        return redirect()->back();
    }
    }
       //Kyout
    public function saleKyoutList(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosKyoutSale::where('shop_owner_id',$this->getshopid())->get();
        $suppliers = PosSupplier::where('shop_owner_id',$this->getshopid())->get();
        $dias = PosDiamond::where('shop_owner_id',$this->getshopid())->get();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $cats = Category::all();
        return view('backend.pos.kyout_sale_list',['shopowner'=>$shopowner,'counters'=>$counters,'purchases'=>$purchases,'sups'=>$suppliers,'dias'=>$dias,'cats'=>$cats]);
    }
    public function kyoutsaletypeFilter(Request $request){
        if($request->type == 2){
            $data = PosKyoutSale::whereBetween('date', [$request->start_date, $request->end_date])->where('shop_owner_id',$this->getshopid())->with('purchase')->get();
        }
        return response()->json([
            'data' => $data,
        ]);
    }
    public function kyoutsaleadvanceFilter(Request $request){
        $data1 = PosKyoutSale::where('shop_owner_id',$this->getshopid())->get();
        $data2 = PosKyoutPurchase::where('diamonds', 'like', '%' . $request->qualid . '%')->where('sell_flag',1)->where('shop_owner_id',$this->getshopid())->get();
        $arr = [];
        if($request->supid && $request->qualid && $request->catid){
            foreach($data2 as $dt){
                if($dt->supplier_id == $request->supid  && $dt->category_id == $request->catid){
                    $res = PosKyoutSale::where('purchase_id',$dt->id)->first();
                    array_push($arr,$res);
                }
            }
        }
        else if($request->supid && $request->qualid){
            foreach($data2 as $dt){
                if($dt->supplier_id == $request->supid){
                    $res = PosKyoutSale::where('purchase_id',$dt->id)->first();
                    array_push($arr,$res);
                }
            }
        }else if($request->supid && $request->catid){
            foreach($data1 as $dt){
                if($dt->supplier_id == $request->supid && $dt->category_id == $request->catid){
                    array_push($arr,$dt);
                }
            }
        }else if($request->qualid && $request->catid){
            foreach($data2 as $dt){
                if($dt->category_id == $request->catid){
                    $res = PosKyoutSale::where('purchase_id',$dt->id)->first();
                    array_push($arr,$res);
                }
            }
        }else if($request->supid){
            foreach($data1 as $dt){
                if($dt->purchase->supplier_id == $request->supid){
                    array_push($arr,$dt);
                }
            }
        }else if($request->qualid){
            foreach($data2 as $dt){
                    $res = PosKyoutSale::where('purchase_id',$dt->id)->first();
                    array_push($arr,$res);
            }
        }else if($request->catid){
            foreach($data1 as $dt){
                if($dt->purchase->category_id == $request->catid){
                    array_push($arr,$dt);
                }
            }
        }
        return response()->json([
            'data' => $arr,
        ]);
    }
    public function editKyoutSale($id){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosKyoutPurchase::where('shop_owner_id',$this->getshopid())->get();
        $date = Carbon::now();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        $sale = PosKyoutSale::find($id);
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $shop_price = explode('/',$price->shop_price)[0];
        $out_price = explode('/',$price->shop_price)[1];

        return view('backend.pos.edit_kyout_sale',['shopowner'=>$shopowner,'counters'=>$counters,'sale'=>$sale,'shop_price'=>$shop_price,'out_price'=>$out_price,'staffs'=>$staffs,'purchases'=>$purchases]);
    }
    public function updateKyoutSale(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try{
        $kyout_sale = PosKyoutSale::find($id);
        $kyout_sale->date = $request->date;
        $kyout_sale->purchase_id = $request->purchase_id;
        $kyout_sale->staff_id = $request->staff_id;
        $kyout_sale->counter_shop = $request->counter;
        $kyout_sale->remark = $request->remark;
        $kyout_sale->customer_name = $request->name;
        $kyout_sale->phone = $request->phone;
        $kyout_sale->address = $request->address;
        $kyout_sale->price = $request->price;
        $kyout_sale->total_price = $request->total_price;
        $kyout_sale->selling_price = $request->selling_price;
        $kyout_sale->decrease_price = $request->de_price;
        $kyout_sale->amount = $request->amount;
        $kyout_sale->prepaid = $request->prepaid;
        $kyout_sale->credit = $request->credit;
        $kyout_sale->return_price = $request->return_fee;
        $kyout_sale->left_price = $request->left_fee;
        $kyout_sale->save();
        Session::flash('message', 'Kyout Sale was successfully Updated!');
        return redirect()->route('backside.shop_owner.pos.sale_kyout_list');
    } catch (\Exception $e) {
        return redirect()->back();
    }
    }
    public function deleteKyoutSale(Request $request){
        $diamond = PosKyoutSale::find($request->pid);
        $diamond->delete();
        Session::flash('message', 'Kyout Sale was successfully Deleted!');
        return response()->json([
            'data'=> 'success'
        ],200);
    }
    public function saleKPurchase(){
    $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
    $purchases = PosKyoutPurchase::where('shop_owner_id',$this->getshopid())->get();
    $date = Carbon::now();
    $price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
    $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
    $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
    $categories = Category::all();
    $quality = DB::table('pos_qualities')->get();
     if($price){
      $shop_price = explode('/',$price->shop_price)[0];
    $out_price = explode('/',$price->shop_price)[1];

    return view('backend.pos.sale_kyout_purchase',['shopowner'=>$shopowner,'counters'=>$counters,'shop_price'=>$shop_price,'out_price'=>$out_price,'staffs'=>$staffs,'purchases'=>$purchases,'categories'=>$categories,'quality'=>$quality]);
    }
    else{
        Session::flash('message', '​ရွှေ​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        return view('backend.pos.assign_gold_price',['shopowner'=>$shopowner,'assign_gold_price'=>$assign_gold_price]);
    }

    }
    public function getSaleKValues(Request $request){
        $purchase = PosKyoutPurchase::where('id',$request->purchase_id)->where('shop_owner_id',$this->getshopid())->with('quality')->with('category')->first();
        $product_gram_kyat_pe_yway = explode('/',$purchase->gold_gram_kyat_pe_yway);
        $service_pe_yway = explode('/',$purchase->service_pe_yway);
        $decrease_pe_yway = explode('/',$purchase->decrease_pe_yway);
        $profit_pe_yway = explode('/',$purchase->diamond_gram_kyat_pe_yway);
        $decrease_price = explode('/',$purchase->decrease_price);
        $service_fee = explode('/',$purchase->service_fee);
        return response()->json([
        'purchase' => $purchase,
        'product' => $product_gram_kyat_pe_yway,
        'service' => $service_pe_yway,
        'decrease' => $decrease_pe_yway,
        'diamond' => $profit_pe_yway,
        'decrease_price' => $decrease_price,
        'service_fee' => $service_fee,
        ]);
    }
    public function detailKyoutSale($id){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id',$this->getshopid())->get();
        $purchase = PosKyoutSale::find($id);
        $quality = PosQuality::all();
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $diamonds = PosDiamond::where('shop_owner_id',$this->getshopid())->get();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        $shop_price = explode('/',$price->shop_price)[0];
        $out_price = explode('/',$price->shop_price)[1];

        return view('backend.pos.detail_kyout_sale',['shopowner'=>$shopowner,'purchase'=>$purchase,'categories'=>$categories,'suppliers'=>$suppliers,'quality'=>$quality,'shop_price'=>$shop_price,'out_price'=>$out_price,'staffs'=>$staffs,'diamonds'=>$diamonds]);
    }
    public function storeKyoutSale(Request $request){
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required',
            'staff_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
        $kyout_sale = PosKyoutSale::create([
            'date' => $request->date,
            'shop_owner_id' =>$this->getshopid(),
            'purchase_id' => $request->purchase_id,
            'staff_id' => $request->staff_id,
            'counter_shop' => $request->counter,
            'remark' => $request->remark,
            'customer_name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'price' => $request->price,
            'amount' => $request->amount,
            'prepaid' => $request->prepaid,
            'credit' => $request->credit,
        ]);
        if($request->credit != 0){

            $credit = PosCreditList::create([
                'purchase_date' => $request->date,
                'shop_owner_id' =>$this->getshopid(),
                'purchase_code' =>$request->code_number,
                'credit' => $request->credit,
                'customer_name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address
            ]);
        }
        $purchase = PosKyoutPurchase::find($request->purchase_id);
        $purchase->stock_qty -= 1;
        $purchase->sell_flag = 1;
        $purchase->save();

        $sold = PosPurchaseSale::where('purchase_id',$request->purchase_id)->where('type',2)->count();
        if($sold<1){
            PosPurchaseSale::create([
                'purchase_id' => $request->purchase_id,
                'shop_owner_id' =>$this->getshopid(),
                'sale_id'=> $kyout_sale->id,
                'qty' => 1,
                'type' =>2
            ]);
        }else{
            $exit = PosPurchaseSale::where('purchase_id',$request->purchase_id)->first();
            $exit->qty += 1;
            $exit->save();
        }

        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        Session::flash('message', 'Kyout Sale was successfully Created!');
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        $shop_price = explode('/',$price->shop_price)[0];
        $price15 = explode('/',$price->inprice_15)[0];
        return view('backend.pos.sale_voucher_list',['shopowner'=>$shopowner,'sale'=>$kyout_sale,'counters'=>$counters,'gold_fee'=>$request->price,'service_fee'=>$request->service_fee,'diamond_fee'=>$request->diamond_fee,'shop_price'=>$shop_price,'price15'=>$price15,'cancel'=>2]);

    } catch (\Exception $e) {
        return redirect()->back();
    }
    }
        //Platinum
    public function salePtmList(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosPlatinumSale::where('shop_owner_id',$this->getshopid())->get();
        $suppliers = PosSupplier::where('shop_owner_id',$this->getshopid())->get();
        $quals = PosQuality::all();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $cats = Category::all();
        return view('backend.pos.sale_platinum_list',['shopowner'=>$shopowner,'counters'=>$counters,'purchases'=>$purchases,'sups'=>$suppliers,'quals'=>$quals,'cats'=>$cats]);
    }
    public function deletePtmSale(Request $request){
        $purchase = PosPlatinumSale::find($request->pid);
        $purchase->delete();
        Session::flash('message', 'Platinum Sale was successfully Deleted!');
        return response()->json([
            'data'=> 'success'
        ],200);
    }
    public function ptmsaletypeFilter(Request $request){
        if($request->type == 2){
            $data = PosPlatinumSale::whereBetween('date', [$request->start_date, $request->end_date])->where('shop_owner_id',$this->getshopid())->get();
        }

        return response()->json([
            'data' => $data,
        ]);
    }
    public function platinumsaleadvanceFilter(Request $request){
        $data1 = PosPlatinumSale::where('shop_owner_id',$this->getshopid())->get();
        $arr = [];
        if($request->qualid && $request->catid){
            foreach($data1 as $dt){
                if($dt->purchase->quality == $request->qualid && $dt->purchase->category_id == $request->catid){
                    array_push($arr,$dt);
                }
            }
        }else if($request->qualid){
            foreach($data1 as $dt){
                if($dt->purchase->quality == $request->qualid){
                    array_push($arr,$dt);
                }
            }
        }else if($request->catid){
            foreach($data1 as $dt){
                if($dt->purchase->category_id == $request->catid){
                    array_push($arr,$dt);
                }
            }
        }
        return response()->json([
            'data' => $arr,
        ]);
    }
    public function editPtmSale($id){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosPlatinumSale::where('shop_owner_id',$this->getshopid())->get();
        $sale = PosPlatinumSale::find($id);
        $date = Carbon::now();
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $price = PosAssignPlatinumPrice::where('shop_owner_id',$this->getshopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.edit_platinum_sale',['shopowner'=>$shopowner,'counters'=>$counters,'sale'=>$sale,'gradeA'=>$gradeA,'gradeB'=>$gradeB,'staffs'=>$staffs,'purchases'=>$purchases]);
    }
    public function salePtmPurchase(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosPlatinumPurchase::where('shop_owner_id',$this->getshopid())->get();
        $date = Carbon::now();
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $categories = Category::all();
        $quality = DB::table('pos_qualities')->get();
        $price = PosAssignPlatinumPrice::where('shop_owner_id',$this->getshopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.sale_platinum_purchase',['shopowner'=>$shopowner,'counters'=>$counters,'gradeA'=>$gradeA,'gradeB'=>$gradeB,'staffs'=>$staffs,'purchases'=>$purchases,'categories'=>$categories,'quality'=>$quality]);
    }
    public function getSalePtmValues(Request $request){
        $purchase = PosPlatinumPurchase::where('id',$request->purchase_id)->where('shop_owner_id',$this->getshopid())->with('category')->first();
        return response()->json([
        'purchase' => $purchase,
        ]);
    }
    public function storePlatinumSale(Request $request){
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required',
            'staff_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
        $gold_sale = PosPlatinumSale::create([
            'date' => $request->date,
            'shop_owner_id' =>$this->getshopid(),
            'purchase_id' => $request->purchase_id,
            'staff_id' => $request->staff_id,
            'counter_shop' => $request->counter,
            'remark' => $request->remark,
            'customer_name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'price' => $request->price,
            'amount' => $request->amount,
            'prepaid' => $request->prepaid,
            'credit' => $request->credit,
        ]);
        if($request->credit != 0){

            $credit = PosCreditList::create([
                'purchase_date' => $request->date,
                'shop_owner_id' =>$this->getshopid(),
                'purchase_code' =>$request->code_number,
                'credit' => $request->credit,
                'customer_name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address
            ]);
        }
        $purchase = PosPlatinumPurchase::find($request->purchase_id);
        $purchase->stock_qty -= 1;
        $purchase->sell_flag = 1;
        $purchase->save();

        $sold = PosPurchaseSale::where('purchase_id',$request->purchase_id)->where('type',3)->count();
        if($sold<1){
            PosPurchaseSale::create([
                'purchase_id' => $request->purchase_id,
                'shop_owner_id' =>$this->getshopid(),
                'sale_id'=> $gold_sale->id,
                'qty' => 1,
                'type' => 3,
            ]);
        }else{
            $exit = PosPurchaseSale::where('purchase_id',$request->purchase_id)->first();
            $exit->qty += 1;
            $exit->save();
        }

        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        Session::flash('message', 'Gold Sale was successfully Created!');
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        $shop_price = explode('/',$price->shop_price)[0];
        $price15 = explode('/',$price->inprice_15)[0];
        return view('backend.pos.sale_voucher_list',['shopowner'=>$shopowner,'sale'=>$gold_sale,'counters'=>$counters,'gold_fee'=>$request->price,'service_fee'=>0,'diamond_fee'=>0,'shop_price'=>$shop_price,'price15'=>$price15,'cancel'=>3]);
    } catch (\Exception $e) {
        return redirect()->back();
    }
    }
    public function updatePlatinumSale(Request $request,$id){
        try{
        $gold_sale = PosPlatinumSale::find($id);

            $gold_sale->date = $request->date;
            $gold_sale->purchase_id = $request->purchase_id;
            $gold_sale->staff_id = $request->staff_id;
            $gold_sale->counter_shop = $request->counter;
            $gold_sale->remark = $request->remark;
            $gold_sale->customer_name = $request->name;
            $gold_sale->phone = $request->phone;
            $gold_sale->address = $request->address;
            $gold_sale->price = $request->price;
            $gold_sale->total_price = $request->total_price;
            $gold_sale->selling_price = $request->selling_price;
            $gold_sale->decrease_price = $request->de_price;
            $gold_sale->amount = $request->amount;
            $gold_sale->prepaid = $request->prepaid;
            $gold_sale->credit = $request->credit;
            $gold_sale->save();

        Session::flash('message', 'Platinum Sale was successfully Updated!');
        return redirect()->route('backside.shop_owner.pos.ptm_sale_list');
    } catch (\Exception $e) {
        return redirect()->back();
    }
    }
    public function detailPlatinumSale($id){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $date = Carbon::now();
        $purchase = PosPlatinumSale::find($id);
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $price = PosAssignPlatinumPrice::where('shop_owner_id',$this->getshopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.detail_platinum_sale',['shopowner'=>$shopowner,'categories'=>$categories,'gradeA'=>$gradeA,'gradeB'=>$gradeB,'purchase'=>$purchase,'staffs'=>$staffs]);
    }
        //WhiteGold
    public function saleWgList(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosWhiteGoldSale::where('shop_owner_id',$this->getshopid())->get();
        $suppliers = PosSupplier::where('shop_owner_id',$this->getshopid())->get();
        $quals = PosQuality::all();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $cats = Category::all();
        return view('backend.pos.sale_whitegold_list',['shopowner'=>$shopowner,'counters'=>$counters,'purchases'=>$purchases,'sups'=>$suppliers,'quals'=>$quals,'cats'=>$cats]);
    }
    public function deleteWgSale(Request $request){
        $purchase = PosWhiteGoldSale::find($request->pid);
        $purchase->delete();
        Session::flash('message', 'White Gold Sale was successfully Deleted!');
        return response()->json([
            'data'=> 'success'
        ],200);
    }
    public function wgsaletypeFilter(Request $request){
        if($request->type == 2){
            $data = PosWhiteGoldSale::whereBetween('date', [$request->start_date, $request->end_date])->where('shop_owner_id',$this->getshopid())->get();
        }

        return response()->json([
            'data' => $data,
        ]);
    }
    public function detailWhiteGoldSale($id){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $date = Carbon::now();
        $purchase = PosWhiteGoldSale::find($id);
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $price = PosAssignWhiteGoldPrice::where('shop_owner_id',$this->getshopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.detail_whitegold_sale',['shopowner'=>$shopowner,'categories'=>$categories,'gradeA'=>$gradeA,'gradeB'=>$gradeB,'purchase'=>$purchase,'staffs'=>$staffs]);
    }
    public function whitegoldsaleadvanceFilter(Request $request){
        $data1 = PosWhiteGoldSale::where('shop_owner_id',$this->getshopid())->get();
        $arr = [];
        if($request->qualid && $request->catid){
            foreach($data1 as $dt){
                if($dt->purchase->quality == $request->qualid && $dt->purchase->category_id == $request->catid){
                    array_push($arr,$dt);
                }
            }
        }else if($request->qualid){
            foreach($data1 as $dt){
                if($dt->purchase->quality == $request->qualid){
                    array_push($arr,$dt);
                }
            }
        }else if($request->catid){
            foreach($data1 as $dt){
                if($dt->purchase->category_id == $request->catid){
                    array_push($arr,$dt);
                }
            }
        }
        return response()->json([
            'data' => $arr,
        ]);
    }
    public function editWgSale($id){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosWhiteGoldSale::where('shop_owner_id',$this->getshopid())->get();
        $sale = PosWhiteGoldSale::find($id);
        $date = Carbon::now();
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $price = PosAssignWhiteGoldPrice::where('shop_owner_id',$this->getshopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.edit_whitegold_sale',['shopowner'=>$shopowner,'counters'=>$counters,'sale'=>$sale,'gradeA'=>$gradeA,'gradeB'=>$gradeB,'staffs'=>$staffs,'purchases'=>$purchases]);
    }
    public function saleWgPurchase(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosWhiteGoldPurchase::where('shop_owner_id',$this->getshopid())->get();
        $date = Carbon::now();
        $staffs = PosStaff::where('shop_id',$this->getshopid())->get();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $categories = Category::all();
        $quality = DB::table('pos_qualities')->get();
        $price = PosAssignWhiteGoldPrice::where('shop_owner_id',$this->getshopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.sale_whitegold_purchase',['shopowner'=>$shopowner,'counters'=>$counters,'gradeA'=>$gradeA,'gradeB'=>$gradeB,'staffs'=>$staffs,'purchases'=>$purchases,'categories'=>$categories,'quality'=>$quality]);
    }
    public function getSaleWgValues(Request $request){
        $purchase = PosWhiteGoldPurchase::where('id',$request->purchase_id)->where('shop_owner_id',$this->getshopid())->with('category')->first();
        return response()->json([
        'purchase' => $purchase,
        ]);
    }
    public function storeWhiteGoldSale(Request $request){
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required',
            'staff_id' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try{
        $gold_sale = PosWhiteGoldSale::create([
            'date' => $request->date,
            'shop_owner_id' =>$this->getshopid(),
            'purchase_id' => $request->purchase_id,
            'staff_id' => $request->staff_id,
            'counter_shop' => $request->counter,
            'remark' => $request->remark,
            'customer_name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'price' => $request->price,
            'amount' => $request->amount,
            'prepaid' => $request->prepaid,
            'credit' => $request->credit,
        ]);
        if($request->credit != 0){
            $credit = PosCreditList::create([
                'purchase_date' => $request->date,
                'shop_owner_id' =>$this->getshopid(),
                'purchase_code' =>$request->code_number,
                'credit' => $request->credit,
                'customer_name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address
            ]);
        }
        $purchase = PosWhiteGoldPurchase::find($request->purchase_id);
        $purchase->stock_qty -= 1;
        $purchase->sell_flag = 1;
        $purchase->save();

        $sold = PosPurchaseSale::where('purchase_id',$request->purchase_id)->where('type',4)->count();
        if($sold<1){
            PosPurchaseSale::create([
                'purchase_id' => $request->purchase_id,
                'shop_owner_id' =>$this->getshopid(),
                'sale_id'=> $gold_sale->id,
                'qty' => 1,
                'type' => 4
            ]);
        }else{
            $exit = PosPurchaseSale::where('purchase_id',$request->purchase_id)->first();
            $exit->qty += 1;
            $exit->save();
        }

        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        Session::flash('message', 'Gold Sale was successfully Created!');
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        $shop_price = explode('/',$price->shop_price)[0];
        $price15 = explode('/',$price->inprice_15)[0];
        return view('backend.pos.sale_voucher_list',['shopowner'=>$shopowner,'sale'=>$gold_sale,'counters'=>$counters,'gold_fee'=>$request->price,'service_fee'=>0,'diamond_fee'=>0,'shop_price'=>$shop_price,'price15'=>$price15,'cancel'=>4]);
    } catch (\Exception $e) {
    } catch (\Exception $e) {
        return redirect()->back();
    }
    }
    public function updateWhiteGoldSale(Request $request,$id){
        try{
        $gold_sale = PosWhiteGoldSale::find($id);

            $gold_sale->date = $request->date;
            $gold_sale->purchase_id = $request->purchase_id;
            $gold_sale->staff_id = $request->staff_id;
            $gold_sale->counter_shop = $request->counter;
            $gold_sale->remark = $request->remark;
            $gold_sale->customer_name = $request->name;
            $gold_sale->phone = $request->phone;
            $gold_sale->address = $request->address;
            $gold_sale->price = $request->price;
            $gold_sale->total_price = $request->total_price;
            $gold_sale->selling_price = $request->selling_price;
            $gold_sale->decrease_price = $request->de_price;
            $gold_sale->amount = $request->amount;
            $gold_sale->prepaid = $request->prepaid;
            $gold_sale->credit = $request->credit;
            $gold_sale->save();

        Session::flash('message', 'White Gold Sale was successfully Updated!');
        return redirect()->route('backside.shop_owner.pos.wg_sale_list');
    } catch (\Exception $e) {
        return redirect()->back();
    }
    }

    //Diamond
    public function getDiamondList(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $diamonds = PosDiamond::where('shop_owner_id',$this->getshopid())->get();
        return view('backend.pos.diamond_list',['shopowner'=>$shopowner,'diamonds'=>$diamonds]);
    }

    public function getCreateDiamond(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        return view('backend.pos.create_diamond',['shopowner'=>$shopowner]);
    }

    public function diamondtypeFilter(Request $request){
        $data = PosDiamond::whereBetween('date', [$request->start_date, $request->end_date])->where('shop_owner_id',$this->getshopid())->get();
        return response()->json($data);
    }

    public function storeDiamond(Request $request){
        $validator = Validator::make($request->all(), [
            'code_number' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $diamond = PosDiamond::create([
            'date' => $request->date,
            'shop_owner_id' =>$this->getshopid(),
            'code_number' => $request->code_number,
            'diamond_name' => $request->diamond_name,
            'carrat_price' => $request->carrat,
            'yati_price' => $request->yati,
            'remark' => $request->remark,
        ]);

        Session::flash('message', 'Supplier was successfully Created!');

        return redirect()->route('backside.shop_owner.pos.diamond_list');
    }

    public function editDiamond($id){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $diamond = PosDiamond::find($id);
        return view('backend.pos.edit_diamond',['shopowner'=>$shopowner,'diamond'=>$diamond,]);
    }

    public function updateDiamond(Request $request,$id){
        try{
            $diamond = PosDiamond::find($id);
            $diamond->date = $request->date;
            $diamond->code_number = $request->code_number;
            $diamond->diamond_name = $request->diamond_name;
            $diamond->carrat_price = $request->carrat;
            $diamond->yati_price = $request->yati;
            $diamond->remark = $request->remark;
            $diamond->save();
            Session::flash('message', 'Diamond was successfully Edited!');
            return redirect()->route('backside.shop_owner.pos.diamond_list');
        } catch (\Exception $e) {
            return redirect()->back();
        }
        }

        public function deleteDiamond(Request $request){
            $diamond = PosDiamond::find($request->sid);
            $diamond->delete();
            Session::flash('message', 'Diamond was successfully Deleted!');
            return response()->json([
                'data'=> 'success'
            ],200);
        }

    //Counter List
    public function getCounterList(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $counters = PosCounterShop::where('shop_owner_id',$this->getshopid())->get();
        return view('backend.pos.counter_list',['shopowner'=>$shopowner,'counters'=>$counters]);
    }
    public function createCounter(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $state = State::all();
        return view('backend.pos.create_counter',['shopowner'=>$shopowner,'state'=>$state]);
    }
    public function storeCounter(Request $request){
        $counter = PosCounterShop::create([
            'date' => $request->date,
            'shop_owner_id' =>$this->getshopid(),
            'shop_name' => $request->shop_name,
            'counter_name' => $request->counter_name,
            'staff_no' => $request->staff_no,
            'phno' => $request->phno,
            'otherno' => $request->otherno,
            'address' => $request->address,
            'remark' => $request->remark,
            'terms' => $request->terms,
            'offdays' => $request->offdays,
            'state_id' => $request->state
        ]);

        Session::flash('message', 'Counter Shop was successfully Created!');

        return redirect()->route('backside.shop_owner.pos.counter_list');
    }
    public function editCounter($id){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $counter = PosCounterShop::find($id);
        $state = State::all();
        return view('backend.pos.edit_counter',['shopowner'=>$shopowner,'counter'=>$counter,'state'=>$state]);
    }
    public function counterTypeFilter(Request $request){
        $data = DB::table('pos_counter_shops')->whereBetween('date', [$request->start_date, $request->end_date])->where('shop_owner_id',$this->getshopid())->get();
        return response()->json($data);
    }
    public function updateCounter(Request $request,$id){
    try{
        $counter = PosCounterShop::find($id);
        $counter->date = $request->date;
        $counter->shop_name = $request->shop_name;
        $counter->counter_name = $request->counter_name;
        $counter->staff_no = $request->staff_no;
        $counter->phno = $request->phno;
        $counter->otherno = $request->otherno;
        $counter->address = $request->address;
        $counter->remark = $request->remark;
        $counter->terms = $request->terms;
        $counter->offdays = $request->offdays;
        $counter->state_id = $request->state;
        $counter->save();
        Session::flash('message', 'Counter Shop was successfully Edited!');
        return redirect()->route('backside.shop_owner.pos.counter_list');
    } catch (\Exception $e) {
        return redirect()->back();
    }
    }
    public function deleteCounter(Request $request){
        $staff = DB::table('pos_counter_shops')->where('id',$request->id)->delete();
        Session::flash('message', 'Staff was successfully Deleted!');
        return response()->json([
            'data'=> 'success'
        ],200);
    }

    //Assign Gold
    public function getAssignGold(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id',$this->getshopid())->first();
        // dd($credits);
        return view('backend.pos.assign_gold_price',['shopowner'=>$shopowner,'assign_gold_price'=>$assign_gold_price]);
    }

    public function getAssignGoldPrice(Request $request){
        $assign = PosAssignGoldPrice::create([
            'date' => $request->date,
            'shop_owner_id' =>$this->getshopid(),
            'shop_price' => $request->shop_price.'/'.$request->out_shop_price,
            'price_16' => $request->price_16,
            'outprice_15' => $request->outprice_15.'/'.$request->out_outprice_15,
            'inprice_15' => $request->inprice_15.'/'.$request->out_inprice_15,
            'outprice_14' => $request->outprice_14.'/'.$request->out_outprice_14,
            'inprice_14' => $request->inprice_14.'/'.$request->out_inprice_14,
            'outprice_14_2' => $request->outprice_14_2.'/'.$request->out_outprice_14_2,
            'inprice_14_2' => $request->inprice_14_2.'/'.$request->out_inprice_14_2,
            'outprice_13' => $request->outprice_13.'/'.$request->out_outprice_13,
            'inprice_13' => $request->inprice_13.'/'.$request->out_inprice_13,
            'outprice_12' => $request->outprice_12.'/'.$request->out_outprice_12,
            'inprice_12' => $request->inprice_12.'/'.$request->out_inprice_12,
            'outprice_12_2' => $request->outprice_12_2.'/'.$request->out_outprice_12_2,
            'inprice_12_2' => $request->inprice_12_2.'/'.$request->out_inprice_12_2,
        ]);
        Session::flash('message','Gold Price was successfully Assigned for today!');
        return redirect()->back();
    }

    public function updateAssignGoldPrice(Request $request,$id){
        // dd($request->all());
        try{
            $assign = PosAssignGoldPrice::find($id);
            $assign->date = $request->date;
            $assign->shop_price = $request->shop_price.'/'.$request->out_shop_price;
            $assign->price_16 = $request->price_16;
            $assign->outprice_15 = $request->outprice_15.'/'.$request->out_outprice_15;
            $assign->inprice_15 = $request->inprice_15.'/'.$request->out_inprice_15;
            $assign->outprice_14 = $request->outprice_14.'/'.$request->out_outprice_14;
            $assign->inprice_14 = $request->inprice_14.'/'.$request->out_inprice_14;
            $assign->outprice_14_2 = $request->outprice_14_2.'/'.$request->out_outprice_14_2;
            $assign->inprice_14_2 = $request->inprice_14_2.'/'.$request->out_inprice_14_2;
            $assign->outprice_13 = $request->outprice_13.'/'.$request->out_outprice_13;
            $assign->inprice_13 = $request->inprice_13.'/'.$request->out_inprice_13;
            $assign->outprice_12 = $request->outprice_12.'/'.$request->out_outprice_12;
            $assign->inprice_12 = $request->inprice_12.'/'.$request->out_inprice_12;
            $assign->outprice_12_2 = $request->outprice_12_2.'/'.$request->out_outprice_12_2;
            $assign->inprice_12_2 = $request->inprice_12_2.'/'.$request->out_inprice_12_2;
            $assign->save();
        Session::flash('message','Gold Price was successfully Assigned for today!');
        return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back();
        }

    }

    //Assign Platinum
    public function getAssignPlatinum(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $assign_gold_price = PosAssignPlatinumPrice::where('shop_owner_id',$this->getshopid())->first();
        return view('backend.pos.assign_platinum_history',['shopowner'=>$shopowner,'assign_gold_price'=>$assign_gold_price]);
    }
    public function getAssignPlatinumPrice(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $assign_gold_price = PosAssignPlatinumPrice::where('shop_owner_id',$this->getshopid())->first();
        return view('backend.pos.assign_platinum_price',['shopowner'=>$shopowner,'assign_gold_price'=>$assign_gold_price]);
    }
    public function storeAssignPlatinumPrice(Request $request){
        $assign = PosAssignPlatinumPrice::create([
            'date' => $request->date,
            'shop_owner_id' =>$this->getshopid(),
            'gradeA' => $request->gradeA,
            'gradeB' => $request->gradeB,
            'gradeC' => $request->gradeC,
            'gradeD' => $request->gradeD,
        ]);
        Session::flash('message','Platinum Price was successfully Assigned for today!');
        return redirect()->back();
    }
    public function updateAssignPlatinumPrice(Request $request,$id){
        try{
            $assign = PosAssignPlatinumPrice::find($id);
            $assign->date = $request->date;
            $assign->gradeA = $request->gradeA;
            $assign->gradeB = $request->gradeB;
            $assign->gradeC = $request->gradeC;
            $assign->gradeD = $request->gradeD;
            $assign->save();
        Session::flash('message','Platinum Price was successfully Assigned for today!');
        return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back();
        }

    }

     //Assign WhiteGold
     public function getAssignWhiteGold(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $assign_gold_price = PosAssignWhiteGoldPrice::where('shop_owner_id',$this->getshopid())->first();
        return view('backend.pos.assign_whitegold_history',['shopowner'=>$shopowner,'assign_gold_price'=>$assign_gold_price]);
    }
    public function getAssignWhiteGoldPrice(){
        $shopowner = Shopowner::where('id', $this->getshopid())->orderBy('created_at', 'desc')->get();
        $assign_gold_price = PosAssignWhiteGoldPrice::where('shop_owner_id',$this->getshopid())->first();
        return view('backend.pos.assign_whitegold_price',['shopowner'=>$shopowner,'assign_gold_price'=>$assign_gold_price]);
    }
    public function storeAssignWhiteGoldPrice(Request $request){
        $assign = PosAssignWhiteGoldPrice::create([
            'date' => $request->date,
            'shop_owner_id' =>$this->getshopid(),
            'gradeA' => $request->gradeA,
            'gradeB' => $request->gradeB,
            'gradeC' => $request->gradeC,
            'gradeD' => $request->gradeD,
        ]);
        Session::flash('message','WhiteGold Price was successfully Assigned for today!');
        return redirect()->back();
    }
    public function updateAssignWhiteGoldPrice(Request $request,$id){
        try{
            $assign = PosAssignWhiteGoldPrice::find($id);
            $assign->date = $request->date;
            $assign->gradeA = $request->gradeA;
            $assign->gradeB = $request->gradeB;
            $assign->gradeC = $request->gradeC;
            $assign->gradeD = $request->gradeD;
            $assign->save();
        Session::flash('message','White Gold Price was successfully Assigned for today!');
        return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back();
        }

    }
}
