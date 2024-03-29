<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\MultipleItem;
use App\Http\Controllers\Trait\UserRole;
use App\Http\Controllers\Trait\YKImage;
use App\Models\Category;
use App\Models\Item;
use App\Models\POS\PosAssignGoldPrice;
use App\Models\POS\PosAssignPlatinumPrice;
use App\Models\POS\PosAssignWhiteGoldPrice;
use App\Models\POS\PosCounterShop;
use App\Models\POS\PosCreditList;
use App\Models\POS\PosDiamond;
use App\Models\POS\PosGoldSale;
use App\Models\POS\PosItemPurchase;
use App\Models\POS\PosKyoutPurchase;
use App\Models\POS\PosKyoutSale;
use App\Models\POS\PosPlatinumPurchase;
use App\Models\POS\PosPlatinumSale;
use App\Models\POS\PosPurchase;
use App\Models\POS\PosPurchaseSale;
use App\Models\POS\PosQuality;
use App\Models\POS\PosReturnList;
use App\Models\POS\PosStaff;
use App\Models\POS\PosSupplier;
use App\Models\POS\PosWhiteGoldPurchase;
use App\Models\POS\PosWhiteGoldSale;
use App\Models\Shops;
use App\Models\State;
use App\Services\PosFilter\PosItemFilterService;
use App\Services\PosFilter\PosPurchaseFilterService;
use App\Services\PosFilter\PosSaleFilterService;
use App\Services\PosFilter\PosShopFilterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class PosController extends Controller
{
    use YKImage, UserRole, MultipleItem;

    public $err_data = [];

    protected $purchaseFilterService, $saleFilterService, $itemFilterService, $shopFilterService;

    public function __construct(PosPurchaseFilterService $purchaseFilterService, PosSaleFilterService $saleFilterService,
        PosItemFilterService $itemFilterService, PosShopFilterService $shopFilterService) {
        $this->middleware('auth:shop_owners_and_staffs');
        $this->purchaseFilterService = $purchaseFilterService;
        $this->saleFilterService = $saleFilterService;
        $this->itemFilterService = $itemFilterService;
        $this->shopFilterService = $shopFilterService;
    }
    public function get_dashboard(): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $gold = 0;
        $kyout = 0;
        $platinum = 0;
        $whitegold = 0;
        $golds = PosPurchase::where('stock_qty', '>', 0)->where('shop_owner_id', $this->get_shopid())->get('stock_qty');
        $kyouts = PosKyoutPurchase::where('stock_qty', '>', 0)->where('shop_owner_id', $this->get_shopid())->get('stock_qty');
        $platinums = PosPlatinumPurchase::where('stock_qty', '>', 0)->where('shop_owner_id', $this->get_shopid())->get('stock_qty');
        $whitegolds = PosWhiteGoldPurchase::where('stock_qty', '>', 0)->where('shop_owner_id', $this->get_shopid())->get('stock_qty');
        foreach ($golds as $gq) {
            $gold = $gold + $gq->stock_qty;
        }
        foreach ($kyouts as $kq) {
            $kyout = $kyout + $kq->stock_qty;
        }
        foreach ($platinums as $pq) {
            $platinum = $platinum + $pq->stock_qty;
        }
        foreach ($whitegolds as $wq) {
            $whitegold = $whitegold + $wq->stock_qty;
        }
        $supplier = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id', $this->get_shopid())->take(3)->get();
        $counts = PosSupplier::skip(2)->take(10000)->where('shop_owner_id', $this->get_shopid())->get();
        $mytime = Carbon::now();
        $gtoday_income = PosGoldSale::where('date', $mytime->toDateString())->where('shop_owner_id', $this->get_shopid())->get();
        $ktoday_income = PosKyoutSale::where('date', $mytime->toDateString())->where('shop_owner_id', $this->get_shopid())->get();
        $ptoday_income = PosPlatinumSale::where('date', $mytime->toDateString())->where('shop_owner_id', $this->get_shopid())->get();
        $wtoday_income = PosWhiteGoldSale::where('date', $mytime->toDateString())->where('shop_owner_id', $this->get_shopid())->get();
        $today = 0;
        $arr = [];
        $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
        if ($assign_gold_price) {
            $gold_price = explode('/', $assign_gold_price->shop_price)[1];
        } else {
            Session::flash('message', '​ရွှေ​စျေး,ပလက်တီနမ်​စျေး,​ရွှေဖြူ​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
            // dd($credits);
            return view('backend.pos.assign_gold_price', ['shopowner' => $shopowner, 'assign_gold_price' => $assign_gold_price]);
        }
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->count();
        $suppliers = DB::table('pos_suppliers')->where('shop_owner_id', $this->get_shopid())->count();
        $return = PosReturnList::where('date', $mytime->toDateString())->where('shop_owner_id', $this->get_shopid())->get()->count();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        foreach ($counters as $counter) {
            $subtotal = 0;
            foreach ($gtoday_income as $g) {
                if ($g->purchase->counter_shop == $counter->shop_name) {
                    $subtotal += $g->amount;
                }
            }
            foreach ($ktoday_income as $k) {
                if ($k->purchase->counter_shop == $counter->shop_name) {
                    $subtotal += $k->amount;
                }
            }
            foreach ($ptoday_income as $p) {
                if ($p->purchase->counter_shop == $counter->shop_name) {
                    $subtotal += $p->amount;
                }
            }
            foreach ($wtoday_income as $w) {
                if ($w->purchase->counter_shop == $counter->shop_name) {
                    $subtotal += $w->amount;
                }
            }
            array_push($arr, $subtotal);
        }

        return view('backend.pos.dashboard', ['shopowner' => $shopowner, 'counters' => $counters, 'arr' => $arr, 'counts' => $counts, 'return' => $return, 'sup' => $suppliers, 'gold_price' => $gold_price, 'staffs' => $staffs, 'today' => $today, 'gold' => $gold, 'kyout' => $kyout, 'platinum' => $platinum, 'whitegold' => $whitegold, 'suppliers' => $supplier]);
    }
    public function get_total_amount(): JsonResponse
    {
        $gjan_income = PosGoldSale::whereMonth('date', '01')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $kjan_income = PosKyoutSale::whereMonth('date', '01')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $pjan_income = PosPlatinumSale::whereMonth('date', '01')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $wjan_income = PosWhiteGoldSale::whereMonth('date', '01')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $jan = 0;
        foreach ($gjan_income as $gj) {
            $jan += $gj->amount;
        }
        foreach ($kjan_income as $kj) {
            $jan += $kj->amount;
        }
        foreach ($pjan_income as $pj) {
            $jan += $pj->amount;
        }
        foreach ($wjan_income as $wj) {
            $jan += $wj->amount;
        }
        $gfeb_income = PosGoldSale::whereMonth('date', '02')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $kfeb_income = PosKyoutSale::whereMonth('date', '02')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $pfeb_income = PosPlatinumSale::whereMonth('date', '02')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $wfeb_income = PosWhiteGoldSale::whereMonth('date', '02')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $feb = 0;
        foreach ($gfeb_income as $gf) {
            $feb += $gf->amount;
        }
        foreach ($kfeb_income as $kf) {
            $feb += $kf->amount;
        }
        foreach ($pfeb_income as $pf) {
            $feb += $pf->amount;
        }
        foreach ($wfeb_income as $wf) {
            $feb += $wf->amount;
        }
        $gmar_income = PosGoldSale::whereMonth('date', '03')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $kmar_income = PosKyoutSale::whereMonth('date', '03')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $pmar_income = PosPlatinumSale::whereMonth('date', '03')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $wmar_income = PosWhiteGoldSale::whereMonth('date', '03')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $mar = 0;
        foreach ($gmar_income as $gm) {
            $mar += $gm->amount;
        }
        foreach ($kmar_income as $km) {
            $mar += $km->amount;
        }
        foreach ($pmar_income as $pm) {
            $mar += $pm->amount;
        }
        foreach ($wmar_income as $wm) {
            $mar += $wm->amount;
        }
        $gapr_income = PosGoldSale::whereMonth('date', '04')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $kapr_income = PosKyoutSale::whereMonth('date', '04')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $papr_income = PosPlatinumSale::whereMonth('date', '04')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $wapr_income = PosWhiteGoldSale::whereMonth('date', '04')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $apr = 0;
        foreach ($gapr_income as $ga) {
            $apr += $ga->amount;
        }
        foreach ($kapr_income as $ka) {
            $apr += $ka->amount;
        }
        foreach ($papr_income as $pa) {
            $apr += $pa->amount;
        }
        foreach ($wapr_income as $wa) {
            $apr += $wa->amount;
        }
        $gmay_income = PosGoldSale::whereMonth('date', '05')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $kmay_income = PosKyoutSale::whereMonth('date', '05')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $pmay_income = PosPlatinumSale::whereMonth('date', '05')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $wmay_income = PosWhiteGoldSale::whereMonth('date', '05')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $may = 0;
        foreach ($gmay_income as $g) {
            $may += $g->amount;
        }
        foreach ($kmay_income as $k) {
            $may += $k->amount;
        }
        foreach ($pmay_income as $p) {
            $may += $p->amount;
        }
        foreach ($wmay_income as $w) {
            $may += $w->amount;
        }
        $gjun_income = PosGoldSale::whereMonth('date', '06')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $kjun_income = PosKyoutSale::whereMonth('date', '06')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $pjun_income = PosPlatinumSale::whereMonth('date', '06')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $wjun_income = PosWhiteGoldSale::whereMonth('date', '06')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $jun = 0;
        foreach ($gjun_income as $gju) {
            $jun += $gju->amount;
        }
        foreach ($kjun_income as $kju) {
            $jun += $kju->amount;
        }
        foreach ($pjun_income as $pju) {
            $jun += $pju->amount;
        }
        foreach ($wjun_income as $wju) {
            $jun += $wju->amount;
        }
        $gjul_income = PosGoldSale::whereMonth('date', '07')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $kjul_income = PosKyoutSale::whereMonth('date', '07')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $pjul_income = PosPlatinumSale::whereMonth('date', '07')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $wjul_income = PosWhiteGoldSale::whereMonth('date', '07')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $jul = 0;
        foreach ($gjul_income as $gjl) {
            $jul += $gjl->amount;
        }
        foreach ($kjul_income as $kjl) {
            $jul += $kjl->amount;
        }
        foreach ($pjul_income as $pjl) {
            $jul += $pjl->amount;
        }
        foreach ($wjul_income as $wjl) {
            $jul += $wjl->amount;
        }
        $gaug_income = PosGoldSale::whereMonth('date', '08')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $kaug_income = PosKyoutSale::whereMonth('date', '08')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $paug_income = PosPlatinumSale::whereMonth('date', '08')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $waug_income = PosWhiteGoldSale::whereMonth('date', '08')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $aug = 0;
        foreach ($gaug_income as $gau) {
            $aug += $gau->amount;
        }
        foreach ($kaug_income as $kau) {
            $aug += $kau->amount;
        }
        foreach ($paug_income as $pau) {
            $aug += $pau->amount;
        }
        foreach ($waug_income as $wau) {
            $aug += $wau->amount;
        }
        $gsep_income = PosGoldSale::whereMonth('date', '09')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $ksep_income = PosKyoutSale::whereMonth('date', '09')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $psep_income = PosPlatinumSale::whereMonth('date', '09')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $wsep_income = PosWhiteGoldSale::whereMonth('date', '09')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $sep = 0;
        foreach ($gsep_income as $gs) {
            $sep += $gs->amount;
        }
        foreach ($ksep_income as $ks) {
            $sep += $ks->amount;
        }
        foreach ($psep_income as $ps) {
            $sep += $ps->amount;
        }
        foreach ($wsep_income as $ws) {
            $sep += $ws->amount;
        }
        $goct_income = PosGoldSale::whereMonth('date', '10')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $koct_income = PosKyoutSale::whereMonth('date', '10')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $poct_income = PosPlatinumSale::whereMonth('date', '10')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $woct_income = PosWhiteGoldSale::whereMonth('date', '10')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $oct = 0;
        foreach ($goct_income as $go) {
            $oct += $go->amount;
        }
        foreach ($koct_income as $ko) {
            $oct += $ko->amount;
        }
        foreach ($poct_income as $po) {
            $oct += $po->amount;
        }
        foreach ($woct_income as $wo) {
            $oct += $wo->amount;
        }
        $gnov_income = PosGoldSale::whereMonth('date', '11')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $knov_income = PosKyoutSale::whereMonth('date', '11')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $pnov_income = PosPlatinumSale::whereMonth('date', '11')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $wnov_income = PosWhiteGoldSale::whereMonth('date', '11')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $nov = 0;
        foreach ($gnov_income as $gno) {
            $nov += $gno->amount;
        }
        foreach ($knov_income as $kno) {
            $nov += $kno->amount;
        }
        foreach ($pnov_income as $pno) {
            $nov += $pno->amount;
        }
        foreach ($wnov_income as $wno) {
            $nov += $wno->amount;
        }
        $gdec_income = PosGoldSale::whereMonth('date', '12')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $kdec_income = PosKyoutSale::whereMonth('date', '12')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $pdec_income = PosPlatinumSale::whereMonth('date', '12')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $wdec_income = PosWhiteGoldSale::whereMonth('date', '12')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->get();
        $dec = 0;
        foreach ($gdec_income as $gde) {
            $dec += $gde->amount;
        }
        foreach ($kdec_income as $kde) {
            $dec += $kde->amount;
        }
        foreach ($pdec_income as $pde) {
            $dec += $pde->amount;
        }
        foreach ($wdec_income as $wde) {
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
    public function get_gold_price(): JsonResponse
    {
        $jan = 0;
        $feb = 0;
        $mar = 0;
        $apr = 0;
        $may = 0;
        $jun = 0;
        $jul = 0;
        $aug = 0;
        $sep = 0;
        $oct = 0;
        $nov = 0;
        $dec = 0;
        $jprice = PosAssignGoldPrice::whereMonth('date', '01')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->orderBy('price_16', 'desc')->first();
        if ($jprice) {$jan = explode('/', $jprice->shop_price)[1];}
        $fprice = PosAssignGoldPrice::whereMonth('date', '02')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->orderBy('price_16', 'desc')->first();
        if ($fprice) {$feb = explode('/', $fprice->shop_price)[1];}
        $mprice = PosAssignGoldPrice::whereMonth('date', '03')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->orderBy('price_16', 'desc')->first();
        if ($mprice) {$mar = explode('/', $mprice->shop_price)[1];}
        $aprice = PosAssignGoldPrice::whereMonth('date', '04')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->orderBy('price_16', 'desc')->first();
        if ($aprice) {$apr = explode('/', $aprice->shop_price)[1];}
        $mayprice = PosAssignGoldPrice::whereMonth('date', '05')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->orderBy('price_16', 'desc')->first();
        if ($mayprice) {$may = explode('/', $mayprice->shop_price)[1];}
        $jprice = PosAssignGoldPrice::whereMonth('date', '06')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->orderBy('price_16', 'desc')->first();
        if ($jprice) {$jun = explode('/', $jprice->shop_price)[1];}
        $jlprice = PosAssignGoldPrice::whereMonth('date', '07')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->orderBy('price_16', 'desc')->first();
        if ($jlprice) {$jul = explode('/', $jlprice->shop_price)[1];}
        $augprice = PosAssignGoldPrice::whereMonth('date', '08')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->orderBy('price_16', 'desc')->first();
        if ($augprice) {$aug = explode('/', $augprice->shop_price)[1];}
        $sprice = PosAssignGoldPrice::whereMonth('date', '09')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->orderBy('price_16', 'desc')->first();
        if ($sprice) {$sep = explode('/', $sprice->shop_price)[1];}
        $oprice = PosAssignGoldPrice::whereMonth('date', '10')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->orderBy('price_16', 'desc')->first();
        if ($oprice) {$oct = explode('/', $oprice->shop_price)[1];}
        $nprice = PosAssignGoldPrice::whereMonth('date', '11')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->orderBy('price_16', 'desc')->first();
        if ($nprice) {$nov = explode('/', $nprice->shop_price)[1];}
        $decprice = PosAssignGoldPrice::whereMonth('date', '12')->whereYear('created_at', date('Y'))->where('shop_owner_id', $this->get_shopid())->orderBy('price_16', 'desc')->first();
        if ($decprice) {$dec = explode('/', $decprice->shop_price)[1];}

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
    public function purchase_list(): View
    {
        $suppliers = PosSupplier::where('shop_owner_id', $this->get_shopid())->select('id', 'name')->get();
        $quals = PosQuality::all();
        $cats = Category::select('id', 'mm_name')->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->select('shop_name')->get();

        if (PosAssignGoldPrice::where('shop_owner_id', $this->get_shopid())->exists()) {
            return view('backend.pos.purchase_list', ['counters' => $counters, 'sups' => $suppliers, 'quals' => $quals, 'cats' => $cats]);
        } else {
            Session::flash('message', '​ရွှေ​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
            return view('backend.pos.assign_gold_price', ['assign_gold_price' => $assign_gold_price]);
        }

    }

    public function get_purchase_list(Request $request)
    {
        $purchases = $this->purchaseFilterService->filter_purchases($request);
        $data=$purchases->orderBy('date','desc')->get();
        $arrleng=count($data);
        $tmpcount = $arrleng+1;
        foreach ($data as $key => $value) {
            $tmpcount=$tmpcount-1;
            $data[$key]['dtid'] = $tmpcount;
        }

        return DataTables::of($data)
            ->addColumn('product_weight_in_gram', function ($data) {
                // Split the 'product_weight' by "/" and return the first part which is gram
                $parts = explode("/", $data->product_weight);
                return isset($parts[0]) ? $parts[0] : '';
            })
            ->editColumn('id', fn ($data) => $data->dtid)

            ->addColumn('supplier', function ($data) {
                if(!empty($data->supplier->name)){
                    return $data->supplier->name;

                }else{
                    return "deleted";
                }
            })
            ->addColumn('actions', function ($data) {
                $urls = [
                    'edit_url' => route('backside.shop_owner.pos.edit_purchase', $data->id),
                    'delete_url' => route('backside.shop_owner.pos.delete_purchase', $data->id),
                    'detail_url' => route('backside.shop_owner.pos.detail_purchase', $data->id),
                ];

                return $urls;
            })
            ->make(true);
    }

    public function create_purchase(): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->first();
        $categories = Category::all();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id', $this->get_shopid())->get();
        $quality = DB::table('pos_qualities')->get();
        $date = Carbon::now();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        if ($price) {
            $shop_price = explode('/', $price->shop_price)[0];
            $out_price = explode('/', $price->shop_price)[1];
            return view('backend.pos.create_purchase', ['shopowner' => $shopowner, 'counters' => $counters, 'categories' => $categories, 'suppliers' => $suppliers, 'quality' => $quality, 'shop_price' => $shop_price, 'out_price' => $out_price, 'staffs' => $staffs]);
        } else {
            Session::flash('message', '​ရွှေ​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
            return view('backend.pos.assign_gold_price', ['shopowner' => $shopowner, 'assign_gold_price' => $assign_gold_price]);
        }
    }
    public function store_purchase(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'code_number' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            if ($request->hasfile('photo')) {
                $image = $request->file('photo');
                $filename = time() . "-" . $image->getClientOriginalName();
                if (env('USE_DO') != 'true') {
                    $get_path = $image->move(public_path('main/images/pos/goldpurchase_photo/'), $filename);
                } else {
                    Storage::disk('digitalocean')->put('/prod/pos/goldpurchase_photo/' . $filename, file_get_contents($image));
                }
            } else {
                $filename = 'default.png';
            }

            $purchase = PosPurchase::create([
                'date' => $request->date,
                'shop_owner_id' => $this->get_shopid(),
                'supplier_id' => $request->supplier_id,
                'quality_id' => $request->quality,
                'staff_id' => $request->staff_id,
                'counter_shop' => $request->counter,
                'color' => $request->color,
                'purchase_price' => $request->purchase_price,
                'category_id' => $request->category_id,
                'code_number' => $request->code_number,
                'product_weight' => $request->product_weight . '/' . $request->product_kyat . '/' . $request->product_pe . '/' . $request->product_yway,
                'decrease_pe_yway' => $request->decrease_pe . '/' . $request->decrease_yway,
                'profit_pe_yway' => $request->profit_pe . '/' . $request->profit_yway,
                'service_pe_yway' => $request->service_pe . '/' . $request->service_yway,
                'decrease_price' => $request->decrease_price . '/' . $request->currency,
                'gold_price' => $request->gold_price,
                'profit' => $request->profit . '/' . $request->currency1,
                'service_fee' => $request->service_fee . '/' . $request->currency2,
                'gold_fee' => $request->gold_fee,
                'capital' => $request->gold_fee,
                'gold_type' => $request->gold_type,
                'name' => $request->name,
                'selling_price' => $request->selling_price,
                'stock_qty' => $request->stock_qty,
                'qty' => $request->stock_qty,
                'remark' => $request->remark,
                'photo' => $filename,
                'barcode_text' => $request->barcode_text,
                'barcode' => $request->code_number . '-' . $request->product_weight,
                'type' => $request->inlineCheckbox,
            ]);

            $count = PosSupplier::find($request->supplier_id);
            $count->count += 1;
            $count->save();

            if ($request->shwe_item == 1) {
                if ($request->hasfile('photo')) {
                    if (env('USE_DO') != 'true') {
                        $oldPath = public_path('main/images/pos/goldpurchase_photo/') . $filename; // publc/images/1.jpg
                        $newPath = public_path('/images/items/') . $filename; // publc/images/2.jpg
                        \File::copy($oldPath, $newPath);
                    } else {
                        Storage::disk('digitalocean')->put('/prod/items/' . $filename, file_get_contents($image));
                    }
                }

                if ($request->inlineCheckbox == 'option1') {$gender = 'Women';}
                if ($request->inlineCheckbox == 'option2') {$gender = 'Men';}
                if ($request->inlineCheckbox == 'option3') {$gender = 'Unisex';}
                if ($request->inlineCheckbox == 'option4') {$gender = 'Kid';}
                $item = Item::create([
                    'shop_id' => $this->get_shopid(),
                    'gold_quality' => $purchase->quality->name,
                    'stock_count' => $request->stock_qty,
                    'stock' => 'In Stock',
                    'gold_colour' => $request->color,
                    'category_id' => $purchase->category->name,
                    'main_category' => 1,
                    'product_code' => $request->code_number,
                    'weight' => '[]',
                    'weight_unit' => 0,
                    'd_gram' => $request->decrease_pe . '/' . $request->decrease_yway,
                    'charge' => $request->service_fee,
                    'name' => $request->name,
                    'price' => $request->selling_price,
                    'description' => $request->remark,
                    'default_photo' => $filename,
                    'gender' => $gender,
                ]);
                PosItemPurchase::create([
                    'item_id' => $item->id,
                    'purchase_id' => $purchase->id,
                    'type' => 1,
                ]);
            }

            Session::flash('message', 'Purchase was successfully Created!');

            return redirect()->route('backside.shop_owner.pos.purchase_list');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back();
        }
    }
    public function get_purchase_code(Request $request): JsonResponse
    {
        try {
            $category = Category::find($request->category_id);
            $letter = strtoupper(mb_substr($category->name, 0, 1));
            if ($request->type == 'gold') {
                $purchase = PosPurchase::where('shop_owner_id', $this->get_shopid())->get();
            }
            if ($request->type == 'kyout') {
                $purchase = PosKyoutPurchase::where('shop_owner_id', $this->get_shopid())->get();
            }
            $count = count($purchase);
            $code = $letter . sprintf("%04s", $count + 1);

            return response()->json([
                'code' => $code,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 0,
            ]);
        }
    }
    public function get_quality_price(Request $request): JsonResponse
    {
        $assign = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
        if ($request->quality_id == 1) {
            $price = $assign->price_16;
        }
        if ($request->quality_id == 2) {
            $price = $assign->outprice_15;
        }
        if ($request->quality_id == 3) {
            $price = $assign->inprice_15;
        }
        if ($request->quality_id == 4) {
            $price = $assign->outprice_14;
        }
        if ($request->quality_id == 5) {
            $price = $assign->inprice_14;
        }
        if ($request->quality_id == 6) {
            $price = $assign->outprice_14_2;
        }
        if ($request->quality_id == 7) {
            $price = $assign->inprice_14_2;
        }
        if ($request->quality_id == 8) {
            $price = $assign->outprice_13;
        }
        if ($request->quality_id == 9) {
            $price = $assign->inprice_13;
        }
        if ($request->quality_id == 10) {
            $price = $assign->outprice_12;
        }
        if ($request->quality_id == 11) {
            $price = $assign->inprice_12;
        }
        if ($request->quality_id == 12) {
            $price = $assign->outprice_12_2;
        }
        if ($request->quality_id == 13) {
            $price = $assign->inprice_12_2;
        }
        $p = explode('/', $price)[0];
        return response()->json($p);
    }

    public function delete_purchase(PosPurchase $purchase): RedirectResponse
    {
        $purchase->delete();
        Session::flash('message', 'Purchase was successfully Deleted!');
        return redirect()->route('backside.shop_owner.pos.purchase_list');
    }

    public function edit_purchase($id): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id', $this->get_shopid())->get();
        $purchase = PosPurchase::find($id);
        $quality = PosQuality::all();
        $date = Carbon::now();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $shop_price = explode('/', $price->shop_price)[0];
        $out_price = explode('/', $price->shop_price)[1];

        return view('backend.pos.edit_purchase', ['shopowner' => $shopowner, 'counters' => $counters, 'categories' => $categories, 'suppliers' => $suppliers, 'purchase' => $purchase, 'quality' => $quality, 'shop_price' => $shop_price, 'out_price' => $out_price, 'staffs' => $staffs]);
    }
    public function update_purchase(Request $request, $id): RedirectResponse
    {
        try {
            $purchase = PosPurchase::find($id);
            if ($request->hasfile('photo')) {
                $image = $request->file('photo');
                $filename = time() . "-" . $image->getClientOriginalName();
                if (env('USE_DO') != 'true') {
                    $get_path = $image->move(public_path('main/images/pos/goldpurchase_photo/'), $filename);
                } else {
                    Storage::disk('digitalocean')->put('/prod/pos/goldpurchase_photo/' . $filename, file_get_contents($image));
                }
            } else {
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
            $purchase->product_weight = $request->product_weight . '/' . $request->product_kyat . '/' . $request->product_pe . '/' . $request->product_yway;
            $purchase->decrease_pe_yway = $request->decrease_pe . '/' . $request->decrease_yway;
            $purchase->profit_pe_yway = $request->profit_pe . '/' . $request->profit_yway;
            $purchase->service_pe_yway = $request->service_pe . '/' . $request->service_yway;
            $purchase->decrease_price = $request->decrease_price . '/' . $request->currency;
            $purchase->gold_price = $request->gold_price;
            $purchase->profit = $request->profit . '/' . $request->currency1;
            $purchase->service_fee = $request->service_fee . '/' . $request->currency2;
            $purchase->gold_fee = $request->gold_fee;
            $purchase->capital = $request->gold_fee;
            $purchase->gold_type = $request->gold_type;
            $purchase->name = $request->name;
            $purchase->selling_price = $request->selling_price;
            $purchase->stock_qty = $request->stock_qty;
            $purchase->remark = $request->remark;
            $purchase->photo = $filename;
            $purchase->barcode = $request->code_number . '-' . $request->product_weight;
            $purchase->barcode_text = $request->barcode_text;
            $purchase->type = $request->inlineCheckbox;
            $purchase->save();
            if ($request->shwe_item == 1) {
                if ($request->hasfile('photo')) {
                    if (env('USE_DO') != 'true') {
                        $oldPath = public_path('main/images/pos/goldpurchase_photo/') . $filename; // publc/images/1.jpg
                        $newPath = public_path('/images/items/') . $filename; // publc/images/2.jpg
                        \File::copy($oldPath, $newPath);
                    } else {
                        Storage::disk('digitalocean')->put('/prod/items/' . $filename, file_get_contents($image));
                    }
                }
                if ($request->inlineCheckbox == 'option1') {$gender = 'Women';}
                if ($request->inlineCheckbox == 'option2') {$gender = 'Men';}
                if ($request->inlineCheckbox == 'option3') {$gender = 'Unisex';}
                if ($request->inlineCheckbox == 'option4') {$gender = 'Kid';}
                $item_purchase = PosItemPurchase::where('type', 1)->where('purchase_id', $purchase->id)->first();
                $item = Item::find($item_purchase->item_id);
                $item->gold_quality = $purchase->quality->name;
                $item->stock_count = $request->stock_qty;
                $item->gold_colour = $request->color;
                $item->category_id = $purchase->category->name;
                $item->product_code = $request->code_number;
                $item->d_gram = $request->decrease_pe . '/' . $request->decrease_yway;
                $item->charge = $request->service_fee;
                $item->name = $request->name;
                $item->price = $request->selling_price;
                $item->description = $request->remark;
                $item->default_photo = $filename;
                $item->gender = $gender;
                $item->save();
            }
            Session::flash('message', 'Purchase was successfully Updated!');
            return redirect()->route('backside.shop_owner.pos.purchase_list');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
    public function detail_purchase($id): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id', $this->get_shopid())->get();
        $purchase = PosPurchase::find($id);
        $quality = PosQuality::all();
        $date = Carbon::now();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $shop_price = explode('/', $price->shop_price)[0];
        $out_price = explode('/', $price->shop_price)[1];

        return view('backend.pos.detail_purchase', ['shopowner' => $shopowner, 'categories' => $categories, 'suppliers' => $suppliers, 'purchase' => $purchase, 'quality' => $quality, 'shop_price' => $shop_price, 'out_price' => $out_price, 'staffs' => $staffs]);
    }

    //kyout
    public function kyout_purchase_list(): View
    {
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->select('shop_name')->get();
        $suppliers = PosSupplier::where('shop_owner_id', $this->get_shopid())->select('id', 'name')->get();
        $dias = PosDiamond::where('shop_owner_id', $this->get_shopid())->select('diamond_name')->get();
        $cats = Category::select('id', 'mm_name')->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->select('shop_name')->get();
        if (PosAssignGoldPrice::where('shop_owner_id', $this->get_shopid())->exists()) {
            return view('backend.pos.kyout_purchase_list', ['counters' => $counters, 'sups' => $suppliers, 'dias' => $dias, 'cats' => $cats]);
        } else {
            Session::flash('message', '​ရွှေ​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
            return view('backend.pos.assign_gold_price', ['assign_gold_price' => $assign_gold_price]);
        }
    }

    public function get_kyout_purchase_list(Request $request): JsonResponse
    {
        $purchases = $this->purchaseFilterService->filter_kyout_purchases($request);
        $data=$purchases->orderBy('id','desc')->get();
        $arrleng=count($data);
        $tmpcount = $arrleng+1;

        foreach ($data as $key => $value) {
            $tmpcount=$tmpcount-1;
            $data[$key]['dtid'] = $tmpcount;
        }
        return DataTables::of($data)
            ->addColumn('supplier', function ($data) {
                return $data->supplier->name;
            })
            ->editColumn('id', fn ($data) => $data->dtid)

            ->addColumn('quality', function ($data) {
                return $data->quality->name;
            })
            ->addColumn('actions', function ($data) {
                $urls = [
                    'edit_url' => route('backside.shop_owner.pos.edit_kyout_purchase', $data->id),
                    'delete_url' => route('backside.shop_owner.pos.delete_kyout_purchase', $data->id),
                    'detail_url' => route('backside.shop_owner.pos.detail_kyout_purchase', $data->id),
                ];

                return $urls;
            })
            ->toJson();
    }

    public function create_kyout_purchase(): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id', $this->get_shopid())->get();
        $quality = DB::table('pos_qualities')->get();
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        $diamonds = PosDiamond::where('shop_owner_id', $this->get_shopid())->get();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
        if ($price) {
            $shop_price = explode('/', $price->shop_price)[0];
            $out_price = explode('/', $price->shop_price)[1];
            return view('backend.pos.create_kyout_purchase', ['shopowner' => $shopowner, 'counters' => $counters, 'categories' => $categories, 'suppliers' => $suppliers, 'quality' => $quality, 'shop_price' => $shop_price, 'out_price' => $out_price, 'staffs' => $staffs, 'diamonds' => $diamonds]);
        } else {
            Session::flash('message', '​ရွှေ​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
            return view('backend.pos.assign_gold_price', ['shopowner' => $shopowner, 'assign_gold_price' => $assign_gold_price]);
        }

    }

    public function get_phone(Request $request): JsonResponse
    {
        $supplier = PosSupplier::find($request->supplier_id);
        return response()->json($supplier);
    }

    public function store_kyout_purchase(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'code_number' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            if ($request->hasfile('photo')) {
                $image = $request->file('photo');
                $filename = time() . "-" . $image->getClientOriginalName();
                if (env('USE_DO') != 'true') {
                    $get_path = $image->move(public_path('main/images/pos/kyoutpurchase_photo/'), $filename);
                } else {
                    Storage::disk('digitalocean')->put('/prod/pos/kyoutpurchase_photo/' . $filename, file_get_contents($image));
                }

            } else {
                $filename = 'default.png';
            }
            $purchase = PosKyoutPurchase::create([
                'date' => $request->date,
                'shop_owner_id' => $this->get_shopid(),
                'supplier_id' => $request->supplier_id,
                'quality_id' => $request->quality,
                'staff_id' => $request->staff_id,
                'counter_shop' => $request->counter,
                'color' => $request->color,
                'purchase_price' => $request->purchase_price,
                'category_id' => $request->category_id,
                'code_number' => $request->code_number,
                'product_weight' => $request->gold_gram . '/' . $request->gold_kyat . '/' . $request->gold_pe . '/' . $request->gold_yway,
                'diamond_gram_kyat_pe_yway' => $request->diamond_gram . '/' . $request->diamond_kyat . '/' . $request->diamond_pe . '/' . $request->diamond_yway,
                'decrease_pe_yway' => $request->decrease_pe . '/' . $request->decrease_yway,
                'profit_pe_yway' => $request->profit_pe . '/' . $request->profit_yway,
                'service_pe_yway' => $request->service_pe . '/' . $request->service_yway,
                'decrease_price' => $request->decrease_price . '/' . $request->currency,
                'gold_price' => $request->gold_price,
                'profit' => $request->profit . '/' . $request->currency1,
                'service_fee' => $request->service_fee . '/' . $request->currency2,
                'gold_fee' => $request->gold_fee,
                'gold_type' => $request->gold_type,
                'name' => $request->name,
                'selling_price' => $request->selling_price,
                'diamond_selling_price' => $request->diamond_selling_price,
                'capital' => $request->capital,
                'stock_qty' => $request->stock_qty,
                'qty' => $request->stock_qty,
                'remark' => $request->remark,
                'photo' => $filename,
                'barcode_text' => $request->barcode_text,
                'barcode' => $request->code_number . '-' . $request->gold_gram,
                'type' => $request->inlineCheckbox,
            ]);
            if ($request->include_diamonds) {
                $diamonds = '';
                foreach ($request->include_diamonds as $diamond) {
                    $diamonds .= $diamond . ',';
                }
                $purchase->diamonds = $diamonds;
                $purchase->save();
            }
            if ($request->counts) {
                $counts = '';
                foreach ($request->counts as $count) {
                    $counts .= $count . ',';
                }
                $purchase->counts = $counts;
                $purchase->save();
            }
            if ($request->carrats) {
                $carrats = '';
                foreach ($request->carrats as $carrat) {
                    $carrats .= $carrat . ',';
                }
                $purchase->carrats = $carrats;
                $purchase->save();
            }
            if ($request->yaties) {
                $yaties = '';
                foreach ($request->yaties as $yatie) {
                    $yaties .= $yatie . ',';
                }
                $purchase->yaties = $yaties;
                $purchase->save();
            }
            if ($request->bes) {
                $bes = '';
                foreach ($request->bes as $be) {
                    $bes .= $be . ',';
                }
                $purchase->bes = $bes;
                $purchase->save();
            }
            if ($request->dprice) {
                $dprice = '';
                foreach ($request->dprice as $dp) {
                    $dprice .= $dp . ',';
                }
                $purchase->diamond_price = $dprice;
                $purchase->save();
            }

            $count = PosSupplier::find($request->supplier_id);
            $count->count += 1;
            $count->save();

            if ($request->shwe_item == 1) {
                if ($request->hasfile('photo')) {
                    if (env('USE_DO') != 'true') {
                        $oldPath = public_path('main/images/pos/kyoutpurchase_photo/') . $filename; // publc/images/1.jpg
                        $newPath = public_path('/images/items/') . $filename; // publc/images/2.jpg
                        \File::copy($oldPath, $newPath);
                    } else {
                        Storage::disk('digitalocean')->put('/prod/items/' . $filename, file_get_contents($image));
                    }
                }

                if ($request->inlineCheckbox == 'option1') {$gender = 'Women';}
                if ($request->inlineCheckbox == 'option2') {$gender = 'Men';}
                if ($request->inlineCheckbox == 'option3') {$gender = 'Unisex';}
                if ($request->inlineCheckbox == 'option4') {$gender = 'Kid';}
                $item = Item::create([
                    'shop_id' => $this->get_shopid(),
                    'gold_quality' => $purchase->quality->name,
                    'stock_count' => $request->stock_qty,
                    'stock' => 'In Stock',
                    'gold_colour' => $request->color,
                    'category_id' => $purchase->category->name,
                    'main_category' => 2,
                    'product_code' => $request->code_number,
                    'weight' => '[]',
                    'weight_unit' => 0,
                    'd_gram' => $request->decrease_pe . '/' . $request->decrease_yway,
                    'charge' => $request->service_fee,
                    'name' => $request->name,
                    'price' => $request->selling_price,
                    'description' => $request->remark,
                    'gender' => $gender,
                    'default_photo' => $filename,
                    'diamond' => $diamonds,
                    'carat' => $carrats,
                    'yati' => $yaties,
                ]);
                PosItemPurchase::create([
                    'item_id' => $item->id,
                    'purchase_id' => $purchase->id,
                    'type' => 2,
                ]);
            }

            Session::flash('message', 'Purchase was successfully Created!');

            return redirect()->route('backside.shop_owner.pos.kyout_purchase_list');
        } catch (\Exception $e) {

            dd($e);
            return redirect()->back();

        }
    }

    public function edit_kyout_purchase($id): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id', $this->get_shopid())->get();
        $purchase = PosKyoutPurchase::find($id);
        $quality = PosQuality::all();
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        $diamonds = PosDiamond::where('shop_owner_id', $this->get_shopid())->get();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
        $shop_price = explode('/', $price->shop_price)[0];
        $out_price = explode('/', $price->shop_price)[1];

        return view('backend.pos.edit_kyout_purchase', ['shopowner' => $shopowner, 'counters' => $counters, 'purchase' => $purchase, 'categories' => $categories, 'suppliers' => $suppliers, 'quality' => $quality, 'shop_price' => $shop_price, 'out_price' => $out_price, 'staffs' => $staffs, 'diamonds' => $diamonds]);
    }

    public function update_kyout_purchase(Request $request, $id): RedirectResponse
    {
        try {
            $purchase = PosKyoutPurchase::find($id);
            if ($request->hasfile('photo')) {
                $image = $request->file('photo');
                $filename = time() . "-" . $image->getClientOriginalName();
                if (env('USE_DO') != 'true') {
                    $get_path = $image->move(public_path('main/images/pos/kyoutpurchase_photo/'), $filename);
                } else {
                    Storage::disk('digitalocean')->put('/prod/pos/kyoutpurchase_photo/' . $filename, file_get_contents($image));
                }
            } else {
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
            $purchase->product_weight = $request->gold_gram . '/' . $request->gold_kyat . '/' . $request->gold_pe . '/' . $request->gold_yway;
            $purchase->diamond_gram_kyat_pe_yway = $request->diamond_gram . '/' . $request->diamond_kyat . '/' . $request->diamond_pe . '/' . $request->diamond_yway;
            $purchase->decrease_pe_yway = $request->decrease_pe . '/' . $request->decrease_yway;
            $purchase->profit_pe_yway = $request->profit_pe . '/' . $request->profit_yway;
            $purchase->service_pe_yway = $request->service_pe . '/' . $request->service_yway;
            $purchase->decrease_price = $request->decrease_price . '/' . $request->currency;
            $purchase->gold_price = $request->gold_price;
            $purchase->profit = $request->profit . '/' . $request->currency1;
            $purchase->service_fee = $request->service_fee . '/' . $request->currency2;
            $purchase->gold_fee = $request->gold_fee;
            $purchase->gold_type = $request->gold_type;
            $purchase->name = $request->name;
            $purchase->selling_price = $request->selling_price;
            $purchase->diamond_selling_price = $request->diamond_selling_price;
            $purchase->capital = $request->capital;
            $purchase->stock_qty = $request->stock_qty;
            $purchase->remark = $request->remark;
            $purchase->photo = $filename;
            $purchase->barcode_text = $request->barcode_text;
            $purchase->barcode = $request->code_number . '-' . $request->gold_gram;
            $purchase->type = $request->inlineCheckbox;
            $purchase->save();
           
            if ($request->diamond_name) {
                $diamonds = '';
                foreach ($request->diamond_name as $diamond) {
                    $diamonds .= $diamond . ',';
                }
                $purchase->diamonds = $diamonds;
                $purchase->save();
            }
            if ($request->counts) {
                $counts = '';
                foreach ($request->counts as $count) {
                    $counts .= $count . ',';
                }
                $purchase->counts = $counts;
                $purchase->save();
            }
            if ($request->carrats) {
                $carrats = '';
                foreach ($request->carrats as $carrat) {
                    $carrats .= $carrat . ',';
                }
                $purchase->carrats = $carrats;
                $purchase->save();
            }
            if ($request->yaties) {
                $yaties = '';
                foreach ($request->yaties as $yatie) {
                    $yaties .= $yatie . ',';
                }
                $purchase->yaties = $yaties;
                $purchase->save();
            }
            if ($request->bes) {
                $bes = '';
                foreach ($request->bes as $be) {
                    $bes .= $be . ',';
                }
                $purchase->bes = $bes;
                $purchase->save();
            }
            if ($request->dprice) {
                $dprice = '';
                foreach ($request->dprice as $dp) {
                    $dprice .= $dp . ',';
                }
                $purchase->diamond_price = $dprice;
                $purchase->save();
            }
            if ($request->shwe_item == 1) {
                if ($request->hasfile('photo')) {
                    if (env('USE_DO') != 'true') {
                        $oldPath = public_path('main/images/pos/kyoutpurchase_photo/') . $filename; // publc/images/1.jpg
                        $newPath = public_path('/images/items/') . $filename; // publc/images/2.jpg
                        \File::copy($oldPath, $newPath);
                    } else {
                        Storage::disk('digitalocean')->put('/prod/items/' . $filename, file_get_contents($image));
                    }
                }
                if ($request->inlineCheckbox == 'option1') {$gender = 'Women';}
                if ($request->inlineCheckbox == 'option2') {$gender = 'Men';}
                if ($request->inlineCheckbox == 'option3') {$gender = 'Unisex';}
                if ($request->inlineCheckbox == 'option4') {$gender = 'Kid';}
                $item_purchase = PosItemPurchase::where('type', 2)->where('purchase_id', $purchase->id)->first();
                $item = Item::find($item_purchase->item_id);
                $item->gold_quality = $purchase->quality->name;
                $item->stock_count = $request->stock_qty;
                $item->gold_colour = $request->color;
                $item->category_id = $purchase->category->name;
                $item->product_code = $request->code_number;
                $item->d_gram = $request->decrease_pe . '/' . $request->decrease_yway;
                $item->charge = $request->service_fee;
                $item->name = $request->name;
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

    public function delete_kyout_purchase(PosKyoutPurchase $purchase): RedirectResponse
    {
        $purchase->delete();
        Session::flash('message', 'Kyout Purchase was successfully Deleted!');
        return redirect()->route('backside.shop_owner.pos.kyout_purchase_list');
    }

    public function detail_kyout_purchase($id): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id', $this->get_shopid())->get();
        $purchase = PosKyoutPurchase::find($id);
        $quality = PosQuality::all();
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $diamonds = PosDiamond::where('shop_owner_id', $this->get_shopid())->get();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
        $shop_price = explode('/', $price->shop_price)[0];
        $out_price = explode('/', $price->shop_price)[1];

        return view('backend.pos.detail_kyout_purchase', ['shopowner' => $shopowner, 'purchase' => $purchase, 'categories' => $categories, 'suppliers' => $suppliers, 'quality' => $quality, 'shop_price' => $shop_price, 'out_price' => $out_price, 'staffs' => $staffs, 'diamonds' => $diamonds]);
    }

    //Platinum
    public function ptm_purchase_list(): View
    {
        $purchases = PosPlatinumPurchase::where('shop_owner_id', $this->get_shopid())
            ->select('product_weight')
            ->get();
        $cats = Category::select('id', 'mm_name')->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->select('shop_name')->get();
        if (PosAssignGoldPrice::where('shop_owner_id', $this->get_shopid())->exists()) {
            return view('backend.pos.platinum_purchase_list', ['counters' => $counters, 'purchases' => $purchases, 'cats' => $cats]);
        } else {
            Session::flash('message', 'ပလက်တီနမ်​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
            return view('backend.pos.assign_platinum_price', ['assign_gold_price' => $assign_gold_price]);
        }

    }

    public function get_ptm_purchase_list(Request $request): JsonResponse
    {
        $purchases = $this->purchaseFilterService->filter_platinum_purchases($request);
        $data=$purchases->orderBy('created_at','desc')->get();
        $arrleng=count($data);
        $tmpcount = $arrleng+1;
        foreach ($data as $key => $value) {
            $tmpcount=$tmpcount-1;
            $data[$key]['dtid'] = $tmpcount;
        }
        return DataTables::of($data)
        ->editColumn('id', fn ($data) => $data->dtid)

            ->addColumn('actions', function ($data) {
                $urls = [
                    'edit_url' => route('backside.shop_owner.pos.edit_ptm_purchase', $data->id),
                    'delete_url' => route('backside.shop_owner.pos.delete_ptm_purchase', $data->id),
                    'detail_url' => route('backside.shop_owner.pos.detail_ptm_purchase', $data->id),
                ];

                return $urls;
            })
            ->toJson();
    }

    public function create_ptm_purchase(): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $date = Carbon::now();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id', $this->get_shopid())->get();
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        $price = PosAssignPlatinumPrice::where('shop_owner_id', $this->get_shopid())->first();
        if ($price) {
            $gradeA = $price->gradeA;
            $gradeB = $price->gradeB;
            return view('backend.pos.create_platinum_purchase', ['shopowner' => $shopowner, 'suppliers' => $suppliers, 'counters' => $counters, 'categories' => $categories, 'gradeA' => $gradeA, 'gradeB' => $gradeB, 'staffs' => $staffs]);
        } else {
            Session::flash('message', 'ပလက်တီနမ်​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
            return view('backend.pos.assign_platinum_price', ['shopowner' => $shopowner, 'assign_gold_price' => $assign_gold_price]);
        }
    }
    public function get_ptm_quality_price(Request $request): JsonResponse
    {
        $assign = PosAssignPlatinumPrice::where('shop_owner_id', $this->get_shopid())->first();
        if ($request->quality == 'Grade A') {
            $price = $assign->gradeA;
        }
        if ($request->quality == 'Grade B') {
            $price = $assign->gradeB;
        }
        if ($request->quality == 'Grade C') {
            $price = $assign->gradeC;
        }
        if ($request->quality == 'Grade D') {
            $price = $assign->gradeD;
        }
        return response()->json($price);
    }
    public function store_ptm_purchase(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'code_number' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            if ($request->hasfile('photo')) {
                $image = $request->file('photo');
                $filename = time() . "-" . $image->getClientOriginalName();
                if (env('USE_DO') != 'true') {
                    $get_path = $image->move(public_path('main/images/pos/platinumpurchase_photo/'), $filename);
                } else {
                    Storage::disk('digitalocean')->put('/prod/pos/platinumpurchase_photo/' . $filename, file_get_contents($image));
                }
            } else {
                $filename = 'default.png';
            }
            $purchase = PosPlatinumPurchase::create([
                'date' => $request->date,
                'shop_owner_id' => $this->get_shopid(),
                'supplier_id' => $request->supplier_id,
                'quality' => $request->quality,
                'staff_id' => $request->staff_id,
                'counter_shop' => $request->counter,
                'color' => $request->color,
                'purchase_price' => $request->purchase_price,
                'category_id' => $request->category_id,
                'code_number' => $request->code_number,
                'product_weight' => $request->product_weight,
                'platinum_price' => $request->ptm_price,
                'profit' => $request->profit . '/' . $request->currency1,
                'platinum_type' => $request->ptm_type,
                'name' => $request->ptm_name,
                'selling_price' => $request->selling_price,
                'stock_qty' => $request->stock_qty,
                'qty' => $request->stock_qty,
                'remark' => $request->remark,
                'photo' => $filename,
                'capital' => $request->capital,
                'barcode_text' => $request->barcode_text,
                'barcode' => $request->code_number . '-' . $request->product_weight,
                'type' => $request->inlineCheckbox,
            ]);

            if ($request->shwe_item == 1) {
                if ($request->hasfile('photo')) {
                    if (env('USE_DO') != 'true') {
                        $oldPath = public_path('main/images/pos/platinumpurchase_photo/') . $filename; // publc/images/1.jpg
                        $newPath = public_path('/images/items/') . $filename; // publc/images/2.jpg
                        \File::copy($oldPath, $newPath);
                    } else {
                        Storage::disk('digitalocean')->put('/prod/items/' . $filename, file_get_contents($image));
                    }
                }

                if ($request->inlineCheckbox == 'option1') {$gender = 'Women';}
                if ($request->inlineCheckbox == 'option2') {$gender = 'Men';}
                if ($request->inlineCheckbox == 'option3') {$gender = 'Unisex';}
                if ($request->inlineCheckbox == 'option4') {$gender = 'Kid';}
                $item = Item::create([
                    'shop_id' => $this->get_shopid(),
                    'gold_quality' => $request->quality,
                    'stock_count' => $request->stock_qty,
                    'stock' => 'In Stock',
                    'gold_colour' => $request->color,
                    'category_id' => $purchase->category->name,
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
                    'type' => 3,
                ]);
            }

            Session::flash('message', 'Purchase was successfully Created!');

            return redirect()->route('backside.shop_owner.pos.ptm_purchase_list');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
    public function edit_ptm_purchase($id): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $date = Carbon::now();
        $purchase = PosPlatinumPurchase::find($id);
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        $price = PosAssignPlatinumPrice::where('shop_owner_id', $this->get_shopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.edit_platinum_purchase', ['shopowner' => $shopowner, 'counters' => $counters, 'categories' => $categories, 'gradeA' => $gradeA, 'gradeB' => $gradeB, 'purchase' => $purchase, 'staffs' => $staffs]);
    }

    public function delete_ptm_purchase(PosPlatinumPurchase $purchase): RedirectResponse
    {
        $purchase->delete();
        Session::flash('message', 'Platinum Purchase was successfully Deleted!');
        return redirect()->route('backside.shop_owner.pos.ptm_purchase_list');
    }

    public function update_ptm_purchase(Request $request, $id): RedirectResponse
    {
        try {
            $purchase = PosPlatinumPurchase::find($id);
            if ($request->hasfile('photo')) {
                $image = $request->file('photo');
                $filename = time() . "-" . $image->getClientOriginalName();
                if (env('USE_DO') != 'true') {
                    $get_path = $image->move(public_path('main/images/pos/platinumpurchase_photo/'), $filename);
                } else {
                    Storage::disk('digitalocean')->put('/prod/pos/platinumpurchase_photo/' . $filename, file_get_contents($image));
                }
            } else {
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
            $purchase->product_weight = $request->product_weight;
            $purchase->platinum_price = $request->ptm_price;
            $purchase->profit = $request->profit . '/' . $request->currency1;
            $purchase->platinum_type = $request->ptm_type;
            $purchase->name = $request->ptm_name;
            $purchase->selling_price = $request->selling_price;
            $purchase->stock_qty = $request->stock_qty;
            $purchase->remark = $request->remark;
            $purchase->photo = $filename;
            $purchase->capital = $request->capital;
            $purchase->barcode_text = $request->barcode_text;
            $purchase->barcode = $request->code_number . '-' . $request->product_weight;
            $purchase->type = $request->inlineCheckbox;
            $purchase->save();
            if ($request->shwe_item == 1) {
                if ($request->hasfile('photo')) {
                    if (env('USE_DO') != 'true') {
                        $oldPath = public_path('main/images/pos/platinumpurchase_photo/') . $filename; // publc/images/1.jpg
                        $newPath = public_path('/images/items/') . $filename; // publc/images/2.jpg
                        \File::copy($oldPath, $newPath);
                    } else {
                        Storage::disk('digitalocean')->put('/prod/items/' . $filename, file_get_contents($image));
                    }
                }

                if ($request->inlineCheckbox == 'option1') {$gender = 'Women';}
                if ($request->inlineCheckbox == 'option2') {$gender = 'Men';}
                if ($request->inlineCheckbox == 'option3') {$gender = 'Unisex';}
                if ($request->inlineCheckbox == 'option4') {$gender = 'Kid';}
                $item_purchase = PosItemPurchase::where('type', 3)->where('purchase_id', $purchase->id)->first();
                $item = Item::find($item_purchase->item_id);
                $item->gold_quality = $request->quality;
                $item->stock_count = $request->stock_qty;
                $item->gold_colour = $request->color;
                $item->category_id = $purchase->category->name;
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

    public function detail_ptm_purchase($id): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $date = Carbon::now();
        $purchase = PosPlatinumPurchase::find($id);
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $price = PosAssignPlatinumPrice::where('shop_owner_id', $this->get_shopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.detail_platinum_purchase', ['shopowner' => $shopowner, 'categories' => $categories, 'gradeA' => $gradeA, 'gradeB' => $gradeB, 'purchase' => $purchase, 'staffs' => $staffs]);
    }

    //WhiteGold
    public function wg_purchase_list(): View
    {
        $purchases = PosWhiteGoldPurchase::where('shop_owner_id', $this->get_shopid())
            ->select('product_weight')
            ->get();
        $cats = Category::select('id', 'mm_name')->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->select('shop_name')->get();
        if (PosAssignGoldPrice::where('shop_owner_id', $this->get_shopid())->exists()) {
            return view('backend.pos.whitegold_purchase_list', ['counters' => $counters, 'purchases' => $purchases, 'cats' => $cats]);
        } else {
            Session::flash('message', 'ရွှေဖြူ​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
            return view('backend.pos.assign_whitegold_price', ['assign_gold_price' => $assign_gold_price]);
        }

    }

    public function get_wg_purchase_list(Request $request): JsonResponse
    {
        $purchases = $this->purchaseFilterService->filter_white_gold_purchases($request);
        $data=$purchases->orderBy('created_at','desc')->get();
        $arrleng=count($data);
        $tmpcount = $arrleng+1;
        foreach ($data as $key => $value) {
            $tmpcount=$tmpcount-1;
            $data[$key]['dtid'] = $tmpcount;
        }
        return DataTables::of($data)
        ->editColumn('id', fn ($data) => $data->dtid)

            ->addColumn('actions', function ($data) {
                $urls = [
                    'edit_url' => route('backside.shop_owner.pos.edit_wg_purchase', $data->id),
                    'delete_url' => route('backside.shop_owner.pos.delete_wg_purchase', $data->id),
                    'detail_url' => route('backside.shop_owner.pos.detail_wg_purchase', $data->id),
                ];
                return $urls;
            })
            ->toJson();
    }

    public function create_wg_purchase(): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $date = Carbon::now();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id', $this->get_shopid())->get();
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        $price = PosAssignWhiteGoldPrice::where('shop_owner_id', $this->get_shopid())->first();
        if ($price) {
            $gradeA = $price->gradeA;
            $gradeB = $price->gradeB;
            return view('backend.pos.create_whitegold_purchase', ['shopowner' => $shopowner, 'suppliers' => $suppliers, 'counters' => $counters, 'categories' => $categories, 'gradeA' => $gradeA, 'gradeB' => $gradeB, 'staffs' => $staffs]);
        } else {
            Session::flash('message', 'ရွှေဖြူစျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
            return view('backend.pos.assign_whitegold_price', ['shopowner' => $shopowner, 'assign_gold_price' => $assign_gold_price]);
        }
    }
    public function get_wg_quality_price(Request $request): JsonResponse
    {
        $assign = PosAssignWhiteGoldPrice::where('shop_owner_id', $this->get_shopid())->first();
        if ($request->quality == 'Grade A') {
            $price = $assign->gradeA;
        }
        if ($request->quality == 'Grade B') {
            $price = $assign->gradeB;
        }
        if ($request->quality == 'Grade C') {
            $price = $assign->gradeC;
        }
        if ($request->quality == 'Grade D') {
            $price = $assign->gradeD;
        }
        return response()->json($price);
    }
    public function store_wg_purchase(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'code_number' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            if ($request->hasfile('photo')) {
                $image = $request->file('photo');
                $filename = strtolower($image->getClientOriginalName());
                if (env('USE_DO') != 'true') {
                    $get_path = $image->move(public_path('main/images/pos/whitegoldpurchase_photo/'), $filename);
                } else {
                    Storage::disk('digitalocean')->put('/prod/pos/whitegoldpurchase_photo/' . $filename, file_get_contents($image));
                }
            } else {
                $filename = 'default.png';
            }

            $purchase = PosWhiteGoldPurchase::create([
                'date' => $request->date,
                'shop_owner_id' => $this->get_shopid(),
                'supplier_id' => $request->supplier_id,
                'quality' => $request->quality,
                'staff_id' => $request->staff_id,
                'counter_shop' => $request->counter,
                'color' => $request->color,
                'purchase_price' => $request->purchase_price,
                'category_id' => $request->category_id,
                'code_number' => $request->code_number,
                'product_weight' => $request->product_weight,
                'whitegold_price' => $request->wg_price,
                'profit' => $request->profit . '/' . $request->currency1,
                'whitegold_type' => $request->wg_type,
                'name' => $request->wg_name,
                'selling_price' => $request->selling_price,
                'stock_qty' => $request->stock_qty,
                'qty' => $request->stock_qty,
                'remark' => $request->remark,
                'photo' => $filename,
                'capital' => $request->capital,
                'barcode_text' => $request->barcode_text,
                'barcode' => $request->code_number . '-' . $request->product_weight,
                'type' => $request->inlineCheckbox,
            ]);

            if ($request->shwe_item == 1) {
                if ($request->hasfile('photo')) {
                    if (env('USE_DO') != 'true') {
                        $oldPath = public_path('main/images/pos/whitegoldpurchase_photo/') . $filename; // publc/images/1.jpg
                        $newPath = public_path('/images/items/') . $filename; // publc/images/2.jpg
                        \File::copy($oldPath, $newPath);
                    } else {
                        Storage::disk('digitalocean')->put('/prod/items/' . $filename, file_get_contents($image));
                    }
                }

                if ($request->inlineCheckbox == 'option1') {$gender = 'Women';}
                if ($request->inlineCheckbox == 'option2') {$gender = 'Men';}
                if ($request->inlineCheckbox == 'option3') {$gender = 'Unisex';}
                if ($request->inlineCheckbox == 'option4') {$gender = 'Kid';}
                $item = Item::create([
                    'shop_id' => $this->get_shopid(),
                    'gold_quality' => $request->quality,
                    'stock_count' => $request->stock_qty,
                    'stock' => 'In Stock',
                    'gold_colour' => $request->color,
                    'category_id' => $purchase->category->name,
                    'main_category' => 3,
                    'product_code' => $request->code_number,
                    'weight' => '[]',
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
                    'type' => 4,
                ]);
            }

            Session::flash('message', 'Purchase was successfully Created!');

            return redirect()->route('backside.shop_owner.pos.wg_purchase_list');
        } catch (\Exception $e) {
            return redirect()->back();
        }

    }
    public function edit_wg_purchase($id): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $date = Carbon::now();
        $purchase = PosWhiteGoldPurchase::find($id);
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        $price = PosAssignWhiteGoldPrice::where('shop_owner_id', $this->get_shopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.edit_whitegold_purchase', ['shopowner' => $shopowner, 'counters' => $counters, 'categories' => $categories, 'gradeA' => $gradeA, 'gradeB' => $gradeB, 'purchase' => $purchase, 'staffs' => $staffs]);
    }
    public function delete_wg_purchase(PosWhiteGoldPurchase $purchase): RedirectResponse
    {
        $purchase->delete();
        Session::flash('message', 'Purchase was successfully Deleted!');
        return redirect()->route('backside.shop_owner.pos.wg_purchase_list');
    }
    public function update_wg_purchase(Request $request, $id): RedirectResponse
    {
        try {
            $purchase = PosWhiteGoldPurchase::find($id);
            if ($request->hasfile('photo')) {
                $image = $request->file('photo');
                $filename = strtolower($image->getClientOriginalName());
                if (env('USE_DO') != 'true') {
                    $get_path = $image->move(public_path('main/images/pos/whitegoldpurchase_photo/'), $filename);
                } else {
                    Storage::disk('digitalocean')->put('/prod/pos/whitegoldpurchase_photo/' . $filename, file_get_contents($image));
                }
            } else {
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
            $purchase->product_weight = $request->product_weight;
            $purchase->whitegold_price = $request->wg_price;
            $purchase->profit = $request->profit . '/' . $request->currency1;
            $purchase->whitegold_type = $request->wg_type;
            $purchase->name = $request->wg_name;
            $purchase->selling_price = $request->selling_price;
            $purchase->stock_qty = $request->stock_qty;
            $purchase->remark = $request->remark;
            $purchase->photo = $filename;
            $purchase->capital = $request->capital;
            $purchase->barcode_text = $request->barcode_text;
            $purchase->barcode = $request->code_number . '-' . $request->product_weight;
            $purchase->type = $request->inlineCheckbox;
            $purchase->save();
            if ($request->shwe_item == 1) {
                if ($request->hasfile('photo')) {
                    if (env('USE_DO') != 'true') {
                        $oldPath = public_path('main/images/pos/whitegoldpurchase_photo/') . $filename; // publc/images/1.jpg
                        $newPath = public_path('/images/items/') . $filename; // publc/images/2.jpg
                        \File::copy($oldPath, $newPath);
                    } else {
                        Storage::disk('digitalocean')->put('/prod/items/' . $filename, file_get_contents($image));
                    }
                }

                if ($request->inlineCheckbox == 'option1') {$gender = 'Women';}
                if ($request->inlineCheckbox == 'option2') {$gender = 'Men';}
                if ($request->inlineCheckbox == 'option3') {$gender = 'Unisex';}
                if ($request->inlineCheckbox == 'option4') {$gender = 'Kid';}
                $item_purchase = PosItemPurchase::where('type', 4)->where('purchase_id', $purchase->id)->first();
                $item = Item::find($item_purchase->item_id);
                $item->gold_quality = $request->quality;
                $item->stock_count = $request->stock_qty;
                $item->gold_colour = $request->color;
                $item->category_id = $purchase->category->name;
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

    public function detail_wg_purchase($id): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $date = Carbon::now();
        $purchase = PosWhiteGoldPurchase::find($id);
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $price = PosAssignWhiteGoldPrice::where('shop_owner_id', $this->get_shopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.detail_whitegold_purchase', ['shopowner' => $shopowner, 'categories' => $categories, 'gradeA' => $gradeA, 'gradeB' => $gradeB, 'purchase' => $purchase, 'staffs' => $staffs]);
    }

    //Sale
    //Gold
    public function sale_gold_list(): View
    {
        $suppliers = PosSupplier::where('shop_owner_id', $this->get_shopid())->select('id', 'name')->get();
        $quals = PosQuality::all();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->select('shop_name')->get();
        $cats = Category::select('id', 'mm_name')->get();

        return view('backend.pos.sale_gold_list', ['counters' => $counters, 'sups' => $suppliers, 'quals' => $quals, 'cats' => $cats]);
    }

    public function get_sale_gold_list(Request $request): JsonResponse
    {
        $purchases = $this->saleFilterService->filterGoldSales($request);
        $data=$purchases->orderBy('id','desc')->get();
        $arrleng=count($data);
        $tmpcount = $arrleng+1;
        foreach ($data as $key => $value) {
            $tmpcount=$tmpcount-1;
            $data[$key]['dtid'] = $tmpcount;
        }
        $dataTable = DataTables::of($data)
        ->editColumn('id', fn ($data) => $data->dtid)

            ->addColumn('stock_qty', function ($data) {
                return 1;
            })
            ->addColumn('actions', function ($data) {
                $urls = [
                    'edit_url' => route('backside.shop_owner.pos.edit_goldsale', $data->id),
                    'delete_url' => route('backside.shop_owner.pos.delete_goldsale', $data->id),
                    'detail_url' => route('backside.shop_owner.pos.detail_goldsale', $data->id),
                ];
                return $urls;
            })
            ->toJson();
        return $dataTable;
    }

    public function edit_gold_sale($id): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosPurchase::where('shop_owner_id', $this->get_shopid())->get();
        $sale = PosGoldSale::where('id', $id)->first();
        $date = Carbon::now();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        $shop_price = explode('/', $price->shop_price)[0];
        $out_price = explode('/', $price->shop_price)[1];

        return view('backend.pos.edit_sale_purchase', ['shopowner' => $shopowner, 'counters' => $counters, 'sale' => $sale, 'shop_price' => $shop_price, 'out_price' => $out_price, 'staffs' => $staffs, 'purchases' => $purchases]);
    }
    public function update_gold_sale(Request $request, $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
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

    public function delete_gold_sale($id): RedirectResponse
    {
        $diamond = PosGoldSale::find($id);
        $diamond->delete();
        Session::flash('message', 'Gold Sale was successfully Deleted!');
        return redirect()->route('backside.shop_owner.pos.gold_sale_list');
    }
    public function detail_gold_sale($id): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id', $this->get_shopid())->get();
        $purchase = PosGoldSale::find($id);
        $quality = PosQuality::all();
        $date = Carbon::now();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $shop_price = explode('/', $price->shop_price)[0];
        $out_price = explode('/', $price->shop_price)[1];

        return view('backend.pos.detail_gold_sale', ['shopowner' => $shopowner, 'categories' => $categories, 'suppliers' => $suppliers, 'purchase' => $purchase, 'quality' => $quality, 'shop_price' => $shop_price, 'out_price' => $out_price, 'staffs' => $staffs]);
    }

    public function sale_purchase(): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosPurchase::where('shop_owner_id', $this->get_shopid())->get();
        $date = Carbon::now();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $categories = Category::all();
        $quality = DB::table('pos_qualities')->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        if ($price) {
            $shop_price = explode('/', $price->shop_price)[0];
            $out_price = explode('/', $price->shop_price)[1];

            return view('backend.pos.sale_purchase', ['shopowner' => $shopowner, 'counters' => $counters, 'shop_price' => $shop_price, 'out_price' => $out_price, 'staffs' => $staffs, 'purchases' => $purchases, 'categories' => $categories, 'quality' => $quality]);
        } else {
            Session::flash('message', '​ရွှေ​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
            return view('backend.pos.assign_gold_price', ['shopowner' => $shopowner, 'assign_gold_price' => $assign_gold_price]);
        }

    }
    public function get_sale_values(Request $request): JsonResponse
    {
        $purchase = PosPurchase::where('id', $request->purchase_id)->where('shop_owner_id', $this->get_shopid())->with('quality')->with('category')->first();
        $product_weight = explode('/', $purchase->product_weight);
        $service_pe_yway = explode('/', $purchase->service_pe_yway);
        $decrease_pe_yway = explode('/', $purchase->decrease_pe_yway);
        $profit_pe_yway = explode('/', $purchase->profit_pe_yway);
        $decrease_price = explode('/', $purchase->decrease_price);
        $profit = explode('/', $purchase->profit);
        $service_fee = explode('/', $purchase->service_fee);
        return response()->json([
            'purchase' => $purchase,
            'product' => $product_weight,
            'service' => $service_pe_yway,
            'decrease' => $decrease_pe_yway,
            'profitt' => $profit_pe_yway,
            'decrease_price' => $decrease_price,
            'profit' => $profit,
            'service_fee' => $service_fee,
        ]);
    }
    public function store_gold_sale(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required',
            'staff_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $gold_sale = PosGoldSale::create([
                'date' => $request->date,
                'shop_owner_id' => $this->get_shopid(),
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
            if ($request->credit != 0) {

                $credit = PosCreditList::create([
                    'purchase_date' => $request->date,
                    'shop_owner_id' => $this->get_shopid(),
                    'purchase_code' => $request->code_number,
                    'credit' => $request->credit,
                    'customer_name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
            }
            $purchase = PosPurchase::find($request->purchase_id);
            $purchase->stock_qty -= 1;
            $purchase->sell_flag = 1;
            $purchase->save();

            $sold = PosPurchaseSale::where('purchase_id', $request->purchase_id)->where('type', 1)->count();
            if ($sold < 1) {
                PosPurchaseSale::create([
                    'purchase_id' => $request->purchase_id,
                    'shop_owner_id' => $this->get_shopid(),
                    'sale_id' => $gold_sale->id,
                    'qty' => 1,
                    'type' => 1,
                ]);
            } else {
                $exit = PosPurchaseSale::where('purchase_id', $request->purchase_id)->first();
                $exit->qty += 1;
                $exit->save();
            }

            $shopowner = Shops::find($this->get_shopid());
            Session::flash('message', 'Gold Sale was successfully Created!');
            $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
            $price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
            $shop_price = explode('/', $price->shop_price)[0];
            $price15 = explode('/', $price->inprice_15)[0];
            return view('backend.pos.sale_voucher_list', ['shopowner' => $shopowner, 'sale' => $gold_sale, 'counters' => $counters, 'gold_fee' => $request->price, 'service_fee' => $request->service_fee, 'diamond_fee' => 0, 'shop_price' => $shop_price, 'price15' => $price15, 'cancel' => 1]);
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
    //Kyout
    public function sale_kyout_list(): View
    {
        $suppliers = PosSupplier::where('shop_owner_id', $this->get_shopid())->select('id', 'name')->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->select('shop_name')->get();
        $cats = Category::select('id', 'mm_name')->get();
        $dias = PosDiamond::where('shop_owner_id', $this->get_shopid())->get();
        return view('backend.pos.kyout_sale_list', ['counters' => $counters, 'sups' => $suppliers, 'dias' => $dias, 'cats' => $cats]);
    }

    public function get_sale_kyout_list(Request $request): JsonResponse
    {
        $purchases = $this->saleFilterService->filterKyoutSales($request);
        $data=$purchases->orderBy('id','desc')->get();
        $arrleng=count($data);
        $tmpcount = $arrleng+1;
        foreach ($data as $key => $value) {
            $tmpcount=$tmpcount-1;
            $data[$key]['dtid'] = $tmpcount;
        }
        $dataTable = DataTables::of($data)
        ->editColumn('id', fn ($data) => $data->dtid)

            ->addColumn('stock_qty', function ($data) {
                return 1;
            })
            ->addColumn('actions', function ($data) {
                $urls = [
                    'edit_url' => route('backside.shop_owner.pos.edit_kyoutsale', $data->id),
                    'delete_url' => route('backside.shop_owner.pos.delete_kyoutsale', $data->id),
                    'detail_url' => route('backside.shop_owner.pos.detail_kyoutsale', $data->id),
                ];
                return $urls;
            })
            ->toJson();
        return $dataTable;
    }
    public function kyoutsaletypeFilter(Request $request): JsonResponse
    {
        if ($request->type == 2) {
            $data = PosKyoutSale::whereBetween('date', [$request->start_date, $request->end_date])->where('shop_owner_id', $this->get_shopid())->with('purchase')->get();
        }
        return response()->json([
            'data' => $data,
        ]);
    }

    public function edit_kyout_sale($id): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosKyoutPurchase::where('shop_owner_id', $this->get_shopid())->get();
        $date = Carbon::now();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
        $sale = PosKyoutSale::find($id);
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        $shop_price = explode('/', $price->shop_price)[0];
        $out_price = explode('/', $price->shop_price)[1];

        return view('backend.pos.edit_kyout_sale', ['shopowner' => $shopowner, 'counters' => $counters, 'sale' => $sale, 'shop_price' => $shop_price, 'out_price' => $out_price, 'staffs' => $staffs, 'purchases' => $purchases]);
    }
    public function update_kyout_sale(Request $request, $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
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

    public function delete_kyout_sale($id): RedirectResponse
    {
        $diamond = PosKyoutSale::find($id);
        $diamond->delete();
        Session::flash('message', 'Kyout Sale was successfully Deleted!');
        return redirect()->route('backside.shop_owner.pos.sale_kyout_list');
    }
    public function sale_kyout_purchase(): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosKyoutPurchase::where('shop_owner_id', $this->get_shopid())->get();
        $date = Carbon::now();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        $categories = Category::all();
        $quality = DB::table('pos_qualities')->get();
        if ($price) {
            $shop_price = explode('/', $price->shop_price)[0];
            $out_price = explode('/', $price->shop_price)[1];

            return view('backend.pos.sale_kyout_purchase', ['shopowner' => $shopowner, 'counters' => $counters, 'shop_price' => $shop_price, 'out_price' => $out_price, 'staffs' => $staffs, 'purchases' => $purchases, 'categories' => $categories, 'quality' => $quality]);
        } else {
            Session::flash('message', '​ရွှေ​စျေးများကို ဦးစွာသတ်မှတ်ရန်လိုအပ်ပါသည်!');

            $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
            $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
            return view('backend.pos.assign_gold_price', ['shopowner' => $shopowner, 'assign_gold_price' => $assign_gold_price]);
        }

    }
    public function get_sale_kyout_values(Request $request): JsonResponse
    {
        $purchase = PosKyoutPurchase::where('id', $request->purchase_id)->where('shop_owner_id', $this->get_shopid())->with('quality')->with('category')->first();
        $product_weight = explode('/', $purchase->product_weight);
        $service_pe_yway = explode('/', $purchase->service_pe_yway);
        $decrease_pe_yway = explode('/', $purchase->decrease_pe_yway);
        $profit_pe_yway = explode('/', $purchase->diamond_gram_kyat_pe_yway);
        $decrease_price = explode('/', $purchase->decrease_price);
        $service_fee = explode('/', $purchase->service_fee);
        return response()->json([
            'purchase' => $purchase,
            'product' => $product_weight,
            'service' => $service_pe_yway,
            'decrease' => $decrease_pe_yway,
            'diamond' => $profit_pe_yway,
            'decrease_price' => $decrease_price,
            'service_fee' => $service_fee,
        ]);
    }
    public function detail_kyout_sale($id): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $suppliers = PosSupplier::orderBy('count', 'desc')->where('shop_owner_id', $this->get_shopid())->get();
        $purchase = PosKyoutSale::find($id);
        $quality = PosQuality::all();
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $diamonds = PosDiamond::where('shop_owner_id', $this->get_shopid())->get();
        $price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
        $shop_price = explode('/', $price->shop_price)[0];
        $out_price = explode('/', $price->shop_price)[1];

        return view('backend.pos.detail_kyout_sale', ['shopowner' => $shopowner, 'purchase' => $purchase, 'categories' => $categories, 'suppliers' => $suppliers, 'quality' => $quality, 'shop_price' => $shop_price, 'out_price' => $out_price, 'staffs' => $staffs, 'diamonds' => $diamonds]);
    }
    public function store_kyout_sale(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required',
            'staff_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $kyout_sale = PosKyoutSale::create([
                'date' => $request->date,
                'shop_owner_id' => $this->get_shopid(),
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
            if ($request->credit != 0) {

                $credit = PosCreditList::create([
                    'purchase_date' => $request->date,
                    'shop_owner_id' => $this->get_shopid(),
                    'purchase_code' => $request->code_number,
                    'credit' => $request->credit,
                    'customer_name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
            }
            $purchase = PosKyoutPurchase::find($request->purchase_id);
            $purchase->stock_qty -= 1;
            $purchase->sell_flag = 1;
            $purchase->save();

            $sold = PosPurchaseSale::where('purchase_id', $request->purchase_id)->where('type', 2)->count();
            if ($sold < 1) {
                PosPurchaseSale::create([
                    'purchase_id' => $request->purchase_id,
                    'shop_owner_id' => $this->get_shopid(),
                    'sale_id' => $kyout_sale->id,
                    'qty' => 1,
                    'type' => 2,
                ]);
            } else {
                $exit = PosPurchaseSale::where('purchase_id', $request->purchase_id)->first();
                $exit->qty += 1;
                $exit->save();
            }

            $shopowner = Shops::find($this->get_shopid());
            Session::flash('message', 'Kyout Sale was successfully Created!');
            $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
            $price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
            $shop_price = explode('/', $price->shop_price)[0];
            $price15 = explode('/', $price->inprice_15)[0];
            return view('backend.pos.sale_voucher_list', ['shopowner' => $shopowner, 'sale' => $kyout_sale, 'counters' => $counters, 'gold_fee' => $request->price, 'service_fee' => $request->service_fee, 'diamond_fee' => $request->diamond_fee, 'shop_price' => $shop_price, 'price15' => $price15, 'cancel' => 2]);

        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
    //Platinum
    public function sale_ptm_list(): View
    {
        $suppliers = PosSupplier::where('shop_owner_id', $this->get_shopid())->select('id', 'name')->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->select('shop_name')->get();
        $cats = Category::select('id', 'mm_name')->get();
        $quals = PosQuality::all();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        return view('backend.pos.sale_platinum_list', ['counters' => $counters, 'sups' => $suppliers, 'quals' => $quals, 'cats' => $cats]);
    }

    public function get_sale_ptm_list(Request $request): JsonResponse
    {
        $purchases = $this->saleFilterService->filterPlatinumSales($request);
        $data=$purchases->orderBy('id','desc')->get();
        $arrleng=count($data);
        $tmpcount = $arrleng+1;
        foreach ($data as $key => $value) {
            $tmpcount=$tmpcount-1;
            $data[$key]['dtid'] = $tmpcount;
        }
        $dataTable = DataTables::of($data)
            ->addColumn('stock_qty', function ($data) {
                return 1;
            })            ->editColumn('id', fn ($data) => $data->dtid)

            ->addColumn('actions', function ($data) {
                $urls = [
                    'edit_url' => route('backside.shop_owner.pos.edit_ptmsale', $data->id),
                    'delete_url' => route('backside.shop_owner.pos.delete_ptm_sale', $data->id),
                    'detail_url' => route('backside.shop_owner.pos.detail_ptmsale', $data->id),
                ];
                return $urls;
            })
            ->toJson();
        return $dataTable;
    }
    public function delete_ptm_sale($id): RedirectResponse
    {
        $purchase = PosPlatinumSale::find($id);
        $purchase->delete();
        Session::flash('message', 'Platinum Sale was successfully Deleted!');
        return redirect('backside/shop_owner/ptm_sale_list');
    }
    public function edit_ptm_sale($id): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosPlatinumSale::where('shop_owner_id', $this->get_shopid())->get();
        $sale = PosPlatinumSale::find($id);
        $date = Carbon::now();
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        $price = PosAssignPlatinumPrice::where('shop_owner_id', $this->get_shopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.edit_platinum_sale', ['shopowner' => $shopowner, 'counters' => $counters, 'sale' => $sale, 'gradeA' => $gradeA, 'gradeB' => $gradeB, 'staffs' => $staffs, 'purchases' => $purchases]);
    }
    public function sale_ptm_purchase(): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosPlatinumPurchase::where('shop_owner_id', $this->get_shopid())->get();
        $date = Carbon::now();
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        $categories = Category::all();
        $quality = DB::table('pos_qualities')->get();
        $price = PosAssignPlatinumPrice::where('shop_owner_id', $this->get_shopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.sale_platinum_purchase', ['shopowner' => $shopowner, 'counters' => $counters, 'gradeA' => $gradeA, 'gradeB' => $gradeB, 'staffs' => $staffs, 'purchases' => $purchases, 'categories' => $categories, 'quality' => $quality]);
    }
    public function get_sale_ptm_values(Request $request): JsonResponse
    {
        $purchase = PosPlatinumPurchase::where('id', $request->purchase_id)->where('shop_owner_id', $this->get_shopid())->with('category')->first();
        return response()->json([
            'purchase' => $purchase,
        ]);
    }
    public function store_platinum_sale(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required',
            'staff_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $gold_sale = PosPlatinumSale::create([
                'date' => $request->date,
                'shop_owner_id' => $this->get_shopid(),
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
            if ($request->credit != 0) {

                $credit = PosCreditList::create([
                    'purchase_date' => $request->date,
                    'shop_owner_id' => $this->get_shopid(),
                    'purchase_code' => $request->code_number,
                    'credit' => $request->credit,
                    'customer_name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
            }
            $purchase = PosPlatinumPurchase::find($request->purchase_id);
            $purchase->stock_qty -= 1;
            $purchase->sell_flag = 1;
            $purchase->save();

            $sold = PosPurchaseSale::where('purchase_id', $request->purchase_id)->where('type', 3)->count();
            if ($sold < 1) {
                PosPurchaseSale::create([
                    'purchase_id' => $request->purchase_id,
                    'shop_owner_id' => $this->get_shopid(),
                    'sale_id' => $gold_sale->id,
                    'qty' => 1,
                    'type' => 3,
                ]);
            } else {
                $exit = PosPurchaseSale::where('purchase_id', $request->purchase_id)->first();
                $exit->qty += 1;
                $exit->save();
            }

            $shopowner = Shops::find($this->get_shopid());
            Session::flash('message', 'Gold Sale was successfully Created!');
            $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
            $price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
            $shop_price = explode('/', $price->shop_price)[0];
            $price15 = explode('/', $price->inprice_15)[0];
            return view('backend.pos.sale_voucher_list', ['shopowner' => $shopowner, 'sale' => $gold_sale, 'counters' => $counters, 'gold_fee' => $request->price, 'service_fee' => 0, 'diamond_fee' => 0, 'shop_price' => $shop_price, 'price15' => $price15, 'cancel' => 3]);
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
    public function update_platinum_sale(Request $request, $id): RedirectResponse
    {
        try {
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
    public function detail_platinum_sale($id): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $date = Carbon::now();
        $purchase = PosPlatinumSale::find($id);
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $price = PosAssignPlatinumPrice::where('shop_owner_id', $this->get_shopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.detail_platinum_sale', ['shopowner' => $shopowner, 'categories' => $categories, 'gradeA' => $gradeA, 'gradeB' => $gradeB, 'purchase' => $purchase, 'staffs' => $staffs]);
    }
    //WhiteGold
    public function sale_wg_list(): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosWhiteGoldSale::where('shop_owner_id', $this->get_shopid())->get();
        $suppliers = PosSupplier::where('shop_owner_id', $this->get_shopid())->get();
        $quals = PosQuality::all();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        $cats = Category::all();
        return view('backend.pos.sale_whitegold_list', ['shopowner' => $shopowner, 'counters' => $counters, 'purchases' => $purchases, 'sups' => $suppliers, 'quals' => $quals, 'cats' => $cats]);
    }
    public function get_sale_wg_list(Request $request): JsonResponse
    {
        $purchases = $this->saleFilterService->filterWhiteGoldSales($request);
        $data=$purchases->orderBy('id','desc')->get();
        $arrleng=count($data);
        $tmpcount = $arrleng+1;
        foreach ($data as $key => $value) {
            $tmpcount=$tmpcount-1;
            $data[$key]['dtid'] = $tmpcount;
        }

        $dataTable = DataTables::of($data)
            ->addColumn('stock_qty', function ($data) {
                return 1;
            })
            ->editColumn('id', fn ($data) => $data->dtid)

            ->addColumn('actions', function ($data) {
                $urls = [
                    'edit_url' => route('backside.shop_owner.pos.edit_wgsale', $data->id),
                    'delete_url' => route('backside.shop_owner.pos.delete_wg_sale', $data->id),
                    'detail_url' => route('backside.shop_owner.pos.detail_wg_sale', $data->id),
                ];
                return $urls;
            })
            ->toJson();
        return $dataTable;
    }
    public function delete_wg_sale($id): RedirectResponse
    {
        $purchase = PosWhiteGoldSale::find($id);
        $purchase->delete();
        Session::flash('message', 'White Gold Sale was successfully Deleted!');
        return redirect('backside/shop_owner/wg_sale_list');
    }

    public function detail_whitegold_sale($id): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        $date = Carbon::now();
        $purchase = PosWhiteGoldSale::find($id);
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $price = PosAssignWhiteGoldPrice::where('shop_owner_id', $this->get_shopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.detail_whitegold_sale', ['shopowner' => $shopowner, 'categories' => $categories, 'gradeA' => $gradeA, 'gradeB' => $gradeB, 'purchase' => $purchase, 'staffs' => $staffs]);
    }
    public function edit_wg_sale($id): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosWhiteGoldSale::where('shop_owner_id', $this->get_shopid())->get();
        $sale = PosWhiteGoldSale::find($id);
        $date = Carbon::now();
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        $price = PosAssignWhiteGoldPrice::where('shop_owner_id', $this->get_shopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.edit_whitegold_sale', ['shopowner' => $shopowner, 'counters' => $counters, 'sale' => $sale, 'gradeA' => $gradeA, 'gradeB' => $gradeB, 'staffs' => $staffs, 'purchases' => $purchases]);
    }
    public function sale_wg_purchase(): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $purchases = PosWhiteGoldPurchase::where('shop_owner_id', $this->get_shopid())->get();
        $date = Carbon::now();
        $staffs = PosStaff::where('shop_id', $this->get_shopid())->get();
        $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
        $categories = Category::all();
        $quality = DB::table('pos_qualities')->get();
        $price = PosAssignWhiteGoldPrice::where('shop_owner_id', $this->get_shopid())->first();
        $gradeA = $price->gradeA;
        $gradeB = $price->gradeB;

        return view('backend.pos.sale_whitegold_purchase', ['shopowner' => $shopowner, 'counters' => $counters, 'gradeA' => $gradeA, 'gradeB' => $gradeB, 'staffs' => $staffs, 'purchases' => $purchases, 'categories' => $categories, 'quality' => $quality]);
    }
    public function get_sale_wg_values(Request $request): JsonResponse
    {
        $purchase = PosWhiteGoldPurchase::where('id', $request->purchase_id)->where('shop_owner_id', $this->get_shopid())->with('category')->first();
        return response()->json([
            'purchase' => $purchase,
        ]);
    }
    public function store_whitegold_sale(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purchase_id' => 'required',
            'staff_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $gold_sale = PosWhiteGoldSale::create([
                'date' => $request->date,
                'shop_owner_id' => $this->get_shopid(),
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
            if ($request->credit != 0) {
                $credit = PosCreditList::create([
                    'purchase_date' => $request->date,
                    'shop_owner_id' => $this->get_shopid(),
                    'purchase_code' => $request->code_number,
                    'credit' => $request->credit,
                    'customer_name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                ]);
            }
            $purchase = PosWhiteGoldPurchase::find($request->purchase_id);
            $purchase->stock_qty -= 1;
            $purchase->sell_flag = 1;
            $purchase->save();

            $sold = PosPurchaseSale::where('purchase_id', $request->purchase_id)->where('type', 4)->count();
            if ($sold < 1) {
                PosPurchaseSale::create([
                    'purchase_id' => $request->purchase_id,
                    'shop_owner_id' => $this->get_shopid(),
                    'sale_id' => $gold_sale->id,
                    'qty' => 1,
                    'type' => 4,
                ]);
            } else {
                $exit = PosPurchaseSale::where('purchase_id', $request->purchase_id)->first();
                $exit->qty += 1;
                $exit->save();
            }

            $shopowner = Shops::find($this->get_shopid());
            // dd($shopowner);
            Session::flash('message', 'Gold Sale was successfully Created!');
            $counters = PosCounterShop::where('shop_owner_id', $this->get_shopid())->get();
            $price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
            $shop_price = explode('/', $price->shop_price)[0];
            $price15 = explode('/', $price->inprice_15)[0];
            return view('backend.pos.sale_voucher_list', ['shopowner' => $shopowner, 'sale' => $gold_sale, 'counters' => $counters, 'gold_fee' => $request->price, 'service_fee' => 0, 'diamond_fee' => 0, 'shop_price' => $shop_price, 'price15' => $price15, 'cancel' => 4]);
        } catch (\Exception $e) {
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
    public function update_whitegold_sale(Request $request, $id): RedirectResponse
    {
        try {
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
    public function diamond_list(): View
    {
        return view('backend.pos.diamond_list');
    }

    public function get_diamond_list(Request $request): JsonResponse
    {
        $diamonds = $this->itemFilterService->filter_diamonds($request);
        $data=$diamonds->orderBy('id','desc')->get();
        $arrleng=count($data);
        $tmpcount = $arrleng+1;
        foreach ($data as $key => $value) {
            $tmpcount=$tmpcount-1;
            $data[$key]['dtid'] = $tmpcount;
        }
        return DataTables::of($data)
        ->editColumn('id', fn ($data) => $data->dtid)

            ->addColumn('actions', function ($data) {
                $urls = [
                    'edit_url' => route('backside.shop_owner.pos.edit_diamond', $data->id),
                    'delete_url' => route('backside.shop_owner.pos.delete_diamond', $data->id),
                ];

                return $urls;
            })
            ->toJson();
    }

    public function get_create_diamond(): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        return view('backend.pos.create_diamond', ['shopowner' => $shopowner]);
    }

    public function diamond_type_filter(Request $request): JsonResponse
    {
        $data = PosDiamond::whereBetween('date', [$request->start_date, $request->end_date])->where('shop_owner_id', $this->get_shopid())->get();
        return response()->json($data);
    }

    public function store_diamond(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'code_number' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $diamond = PosDiamond::create([
            'date' => $request->date,
            'shop_owner_id' => $this->get_shopid(),
            'code_number' => $request->code_number,
            'diamond_name' => $request->diamond_name,
            'carrat_price' => $request->carrat,
            'yati_price' => $request->yati,
            'remark' => $request->remark,
        ]);

        Session::flash('message', 'Supplier was successfully Created!');

        return redirect()->route('backside.shop_owner.pos.diamond_list');
    }

    public function edit_diamond($id): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $diamond = PosDiamond::find($id);
        return view('backend.pos.edit_diamond', ['shopowner' => $shopowner, 'diamond' => $diamond]);
    }

    public function update_diamond(Request $request, $id): RedirectResponse
    {
        try {
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

    public function delete_diamond(PosDiamond $diamond): RedirectResponse
    {
        $diamond->delete();
        Session::flash('message', 'Diamond was successfully Deleted!');
        return redirect()->route('backside.shop_owner.pos.diamond_list');
    }

    //Counter List
    public function counter_list(): View
    {
        return view('backend.pos.counter_list');
    }

    public function get_counter_list(Request $request): JsonResponse
    {
        $counters = $this->shopFilterService->filter_counter_shops($request);
        $data=$counters->orderBy('id','desc')->get();
        $arrleng=count($data);
        $tmpcount = $arrleng+1;
        foreach ($data as $key => $value) {
            $tmpcount=$tmpcount-1;
            $data[$key]['dtid'] = $tmpcount;
        }
        return DataTables::of($data)
        ->editColumn('id', fn ($data) => $data->dtid)

            ->addColumn('actions', function ($data) {
                $urls = [
                    'edit_url' => route('backside.shop_owner.pos.edit_counter', $data->id),
                    'delete_url' => route('backside.shop_owner.pos.delete_counter', $data->id),
                ];

                return $urls;
            })
            ->toJson();
    }

    public function create_counter(): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $state = State::all();
        return view('backend.pos.create_counter', ['shopowner' => $shopowner, 'state' => $state]);
    }
    public function store_counter(Request $request): RedirectResponse
    {
        $counter = PosCounterShop::create([
            'date' => $request->date,
            'shop_owner_id' => $this->get_shopid(),
            'shop_name' => $request->shop_name,
            'counter_name' => $request->counter_name,
            'staff_no' => $request->staff_no,
            'phno' => $request->phno,
            'otherno' => $request->otherno,
            'address' => $request->address,
            'remark' => $request->remark,
            'terms' => $request->terms,
            'offdays' => $request->offdays,
            'state_id' => $request->state,
        ]);

        Session::flash('message', 'Counter Shop was successfully Created!');

        return redirect()->route('backside.shop_owner.pos.counter_list');
    }
    public function edit_counter($id): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $counter = PosCounterShop::find($id);
        $state = State::all();
        return view('backend.pos.edit_counter', ['shopowner' => $shopowner, 'counter' => $counter, 'state' => $state]);
    }
    public function counter_type_filter(Request $request): JsonResponse
    {
        $data = DB::table('pos_counter_shops')->whereBetween('date', [$request->start_date, $request->end_date])->where('shop_owner_id', $this->get_shopid())->get();
        return response()->json($data);
    }
    public function update_counter(Request $request, $id): RedirectResponse
    {
        try {
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

    public function delete_counter(PosCounterShop $counterShop): RedirectResponse
    {
        $counterShop->delete();
        Session::flash('message', 'Counter Shop was successfully Deleted!');
        return redirect()->route('backside.shop_owner.pos.counter_list');
    }

    //Assign Gold
    public function get_assign_gold(): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $assign_gold_price = PosAssignGoldPrice::latest()->where('shop_owner_id', $this->get_shopid())->first();
        // dd($credits);
        return view('backend.pos.assign_gold_price', ['shopowner' => $shopowner, 'assign_gold_price' => $assign_gold_price]);
    }

    public function get_assign_gold_price(Request $request): RedirectResponse
    {
        $assign = PosAssignGoldPrice::create([
            'date' => $request->date,
            'shop_owner_id' => $this->get_shopid(),
            'shop_price' => $request->shop_price . '/' . $request->out_shop_price,
            'price_16' => $request->price_16,
            'outprice_15' => $request->outprice_15 . '/' . $request->out_outprice_15,
            'inprice_15' => $request->inprice_15 . '/' . $request->out_inprice_15,
            'outprice_14' => $request->outprice_14 . '/' . $request->out_outprice_14,
            'inprice_14' => $request->inprice_14 . '/' . $request->out_inprice_14,
            'outprice_14_2' => $request->outprice_14_2 . '/' . $request->out_outprice_14_2,
            'inprice_14_2' => $request->inprice_14_2 . '/' . $request->out_inprice_14_2,
            'outprice_13' => $request->outprice_13 . '/' . $request->out_outprice_13,
            'inprice_13' => $request->inprice_13 . '/' . $request->out_inprice_13,
            'outprice_12' => $request->outprice_12 . '/' . $request->out_outprice_12,
            'inprice_12' => $request->inprice_12 . '/' . $request->out_inprice_12,
            'outprice_12_2' => $request->outprice_12_2 . '/' . $request->out_outprice_12_2,
            'inprice_12_2' => $request->inprice_12_2 . '/' . $request->out_inprice_12_2,
        ]);
        Session::flash('message', 'Gold Price was successfully Assigned for today!');
        return redirect()->back();
    }

    public function update_assign_gold_price(Request $request, $id): RedirectResponse
    {
        // dd($request->all());
        try {
            $assign = PosAssignGoldPrice::find($id);
            $assign->date = $request->date;
            $assign->shop_price = $request->shop_price . '/' . $request->out_shop_price;
            $assign->price_16 = $request->price_16;
            $assign->outprice_15 = $request->outprice_15 . '/' . $request->out_outprice_15;
            $assign->inprice_15 = $request->inprice_15 . '/' . $request->out_inprice_15;
            $assign->outprice_14 = $request->outprice_14 . '/' . $request->out_outprice_14;
            $assign->inprice_14 = $request->inprice_14 . '/' . $request->out_inprice_14;
            $assign->outprice_14_2 = $request->outprice_14_2 . '/' . $request->out_outprice_14_2;
            $assign->inprice_14_2 = $request->inprice_14_2 . '/' . $request->out_inprice_14_2;
            $assign->outprice_13 = $request->outprice_13 . '/' . $request->out_outprice_13;
            $assign->inprice_13 = $request->inprice_13 . '/' . $request->out_inprice_13;
            $assign->outprice_12 = $request->outprice_12 . '/' . $request->out_outprice_12;
            $assign->inprice_12 = $request->inprice_12 . '/' . $request->out_inprice_12;
            $assign->outprice_12_2 = $request->outprice_12_2 . '/' . $request->out_outprice_12_2;
            $assign->inprice_12_2 = $request->inprice_12_2 . '/' . $request->out_inprice_12_2;
            $assign->save();
            Session::flash('message', 'Gold Price was successfully Assigned for today!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back();
        }

    }

    //Assign Platinum
    public function get_assign_platinum(): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $assign_gold_price = PosAssignPlatinumPrice::where('shop_owner_id', $this->get_shopid())->first();
        return view('backend.pos.assign_platinum_history', ['shopowner' => $shopowner, 'assign_gold_price' => $assign_gold_price]);
    }
    public function get_assign_platinum_price(): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $assign_gold_price = PosAssignPlatinumPrice::where('shop_owner_id', $this->get_shopid())->first();
        return view('backend.pos.assign_platinum_price', ['shopowner' => $shopowner, 'assign_gold_price' => $assign_gold_price]);
    }
    public function store_assign_platinum_price(Request $request): RedirectResponse
    {
        $assign = PosAssignPlatinumPrice::create([
            'date' => $request->date,
            'shop_owner_id' => $this->get_shopid(),
            'gradeA' => $request->gradeA,
            'gradeB' => $request->gradeB,
            'gradeC' => $request->gradeC,
            'gradeD' => $request->gradeD,
        ]);
        Session::flash('message', 'Platinum Price was successfully Assigned for today!');
        return redirect()->back();
    }
    public function update_assign_platinum_price(Request $request, $id): RedirectResponse
    {
        try {
            $assign = PosAssignPlatinumPrice::find($id);
            $assign->date = $request->date;
            $assign->gradeA = $request->gradeA;
            $assign->gradeB = $request->gradeB;
            $assign->gradeC = $request->gradeC;
            $assign->gradeD = $request->gradeD;
            $assign->save();
            Session::flash('message', 'Platinum Price was successfully Assigned for today!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back();
        }

    }

    //Assign WhiteGold
    public function get_assign_whitegold(): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $assign_gold_price = PosAssignWhiteGoldPrice::where('shop_owner_id', $this->get_shopid())->first();
        return view('backend.pos.assign_whitegold_history', ['shopowner' => $shopowner, 'assign_gold_price' => $assign_gold_price]);
    }
    public function get_assign_whitegold_price(): View
    {
        $shopowner = Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        $assign_gold_price = PosAssignWhiteGoldPrice::where('shop_owner_id', $this->get_shopid())->first();
        return view('backend.pos.assign_whitegold_price', ['shopowner' => $shopowner, 'assign_gold_price' => $assign_gold_price]);
    }
    public function store_assign_whitegold_price(Request $request): RedirectResponse
    {
        $assign = PosAssignWhiteGoldPrice::create([
            'date' => $request->date,
            'shop_owner_id' => $this->get_shopid(),
            'gradeA' => $request->gradeA,
            'gradeB' => $request->gradeB,
            'gradeC' => $request->gradeC,
            'gradeD' => $request->gradeD,
        ]);
        Session::flash('message', 'WhiteGold Price was successfully Assigned for today!');
        return redirect()->back();
    }
    public function update_assign_whitegold_price(Request $request, $id): RedirectResponse
    {
        try {
            $assign = PosAssignWhiteGoldPrice::find($id);
            $assign->date = $request->date;
            $assign->gradeA = $request->gradeA;
            $assign->gradeB = $request->gradeB;
            $assign->gradeC = $request->gradeC;
            $assign->gradeD = $request->gradeD;
            $assign->save();
            Session::flash('message', 'White Gold Price was successfully Assigned for today!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back();
        }

    }
}
