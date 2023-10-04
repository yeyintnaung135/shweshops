<?php

namespace App\Services\PosFilter;

use App\Http\Controllers\Trait\UserRole;
use App\Models\POS\PosPurchaseSale;
use App\Models\POS\PosGoldSale;
use App\Models\POS\PosWhiteGoldPurchase;
use App\Models\POS\PosPlatinumPurchase;
use App\Models\POS\PosKyoutPurchase;
use App\Models\POS\PosPurchase;
use App\Models\POS\PosDiamond;
use App\Models\POS\PosReturnList;
use App\Models\POS\PosCreditList;
//NOTE PosItemFilterService is responsible for filtering item lists' datatables

class PosItemFilterService
{
    use UserRole;

    public function filter_returns($request)
    {
        $shopId = $this->get_shopid();
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $query = PosReturnList::select('id', 'customer_name', 'phone', 'address', 'gold_fee', 'date', 'category_id')
            ->where('shop_owner_id', $shopId);

        if ($fromDate) {
            $query->whereDate('date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('date', '<=', $toDate);
        }

        return $query;
    }
    public function filter_credits($request)
    {
        $shopId = $this->get_shopid();
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $query =  PosCreditList::select('id', 'customer_name', 'phone', 'address', 'purchase_code', 'credit', 'purchase_date')
            ->where('shop_owner_id', $shopId);

        if ($fromDate) {
            $query->whereDate('purchase_date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('purchase_date', '<=', $toDate);
        }

        return $query;
    }
    public function filter_diamonds($request)
    {
        $shopId = $this->get_shopid();
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $query = PosDiamond::select('id', 'code_number', 'diamond_name', 'remark', 'date')
            ->where('shop_owner_id', $shopId);

        if ($fromDate) {
            $query->whereDate('date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('date', '<=', $toDate);
        }

        return $query;
    }

    public function filter_stocks($request){
        $shopId = $this->get_shopid();
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $type = $request->input('type');

        $query1 = PosPurchase::select('id', 'code_number', 'name', 'stock_qty','capital','product_weight', 'date')
                ->where('shop_owner_id', $shopId);

        $query2 = PosKyoutPurchase::select('id', 'code_number', 'name', 'stock_qty','capital','product_weight', 'date')
        ->where('shop_owner_id', $shopId);

        $query3 = PosPlatinumPurchase::select('id', 'code_number', 'name', 'stock_qty','capital','product_weight', 'date')
        ->where('shop_owner_id', $shopId);

        $query4 = PosWhiteGoldPurchase::select('id', 'code_number', 'name', 'stock_qty','capital','product_weight', 'date')
        ->where('shop_owner_id', $shopId);

        if($type == 2){
            return $query1;
        }
        else if($type == 3){
            $query =  $query2;
        }
        else if($type == 4){
            $query =  $query3;
        }
        else if($type == 5){
            $query =  $query4;
        }

        if($type == 1){
            $query = $query1->unionAll($query2)->unionAll($query3)->unionAll($query4);
        }

        return $query;
    }

    public function filter_incomes($request){
        $shopId = $this->get_shopid();
        $type = $request->input('type');

        $query1 = PosPurchase::join('pos_purchase_sales', 'pos_purchase_sales.purchase_id', '=', 'pos_purchases.id')
                ->select('pos_purchases.id', 'pos_purchases.name','pos_purchase_sales.qty','pos_purchases.stock_qty',
                'pos_purchases.code_number', 'pos_purchases.product_weight','pos_purchases.profit')
                ->where('pos_purchases.shop_owner_id', $shopId);

        $query2 = PosKyoutPurchase::join('pos_purchase_sales', 'pos_purchase_sales.purchase_id', '=', 'pos_kyout_purchases.id')
                ->select('pos_kyout_purchases.id', 'pos_kyout_purchases.name','pos_purchase_sales.qty','pos_kyout_purchases.stock_qty',
                'pos_kyout_purchases.code_number', 'pos_kyout_purchases.product_weight','pos_kyout_purchases.profit')
                ->where('pos_kyout_purchases.shop_owner_id', $shopId);

        $query3 = PosPlatinumPurchase::join('pos_purchase_sales', 'pos_purchase_sales.purchase_id', '=', 'pos_platinum_purchases.id')
                ->select('pos_platinum_purchases.id', 'pos_platinum_purchases.name','pos_purchase_sales.qty','pos_platinum_purchases.stock_qty',
                'pos_platinum_purchases.code_number', 'pos_platinum_purchases.product_weight','pos_platinum_purchases.profit')
                ->where('pos_platinum_purchases.shop_owner_id', $shopId);

        $query4 = PosWhiteGoldPurchase::join('pos_purchase_sales', 'pos_purchase_sales.purchase_id', '=', 'pos_white_gold_purchases.id')
                ->select('pos_white_gold_purchases.id', 'pos_white_gold_purchases.name','pos_purchase_sales.qty','pos_white_gold_purchases.stock_qty',
                'pos_white_gold_purchases.code_number', 'pos_white_gold_purchases.product_weight','pos_white_gold_purchases.profit')
                ->where('pos_white_gold_purchases.shop_owner_id', $shopId);

        if($type == 2){
            return $query1;
        }
        else if($type == 3){
            $query =  $query2;
        }
        else if($type == 4){
            $query =  $query3;
        }
        else if($type == 5){
            $query =  $query4;
        }
        else if($type == 6){
            $query6 = $query1->where('pos_purchases.quality_id',1)->where('pos_purchases.shop_owner_id', $shopId);
            $query7 = $query2->where('pos_kyout_purchases.quality_id',1)->where('pos_kyout_purchases.shop_owner_id', $shopId);
            $query = $query6->union($query7);
        }
        else if($type == 7){
            $query6 = $query1->where('pos_purchases.quality_id',2)->orwhere('quality_id',3)->where('pos_purchases.shop_owner_id', $shopId);
            $query7 = $query2->where('pos_kyout_purchases.quality_id',2)->orwhere('quality_id',3)->where('pos_kyout_purchases.shop_owner_id', $shopId);
            $query = $query6->union($query7);
        }
        else if($type == 8){
            $query6 = $query1->where('pos_purchases.quality_id',6)->orwhere('quality_id',7)->where('pos_purchases.shop_owner_id', $shopId);
            $query7 = $query2->where('pos_kyout_purchases.quality_id',6)->orwhere('quality_id',7)->where('pos_kyout_purchases.shop_owner_id', $shopId);
            $query = $query6->union($query7);
        }
        else if($type == 9){
            $query6 = $query1->where('pos_purchases.quality_id',4)->orwhere('quality_id',5)->where('pos_purchases.shop_owner_id', $shopId);
            $query7 = $query2->where('pos_kyout_purchases.quality_id',4)->orwhere('quality_id',5)->where('pos_kyout_purchases.shop_owner_id', $shopId);
            $query = $query6->union($query7);
        }
        else if($type == 10){
            $query6 = $query1->where('pos_purchases.quality_id',8)->orwhere('quality_id',9)->where('pos_purchases.shop_owner_id', $shopId);
            $query7 = $query2->where('pos_kyout_purchases.quality_id',8)->orwhere('quality_id',9)->where('pos_kyout_purchases.shop_owner_id', $shopId);
            $query = $query6->union($query7);
        }
        else if($type == 11){
            $query6 = $query1->where('pos_purchases.quality_id',10)->orwhere('quality_id',11)->where('pos_purchases.shop_owner_id', $shopId);
            $query7 = $query2->where('pos_kyout_purchases.quality_id',10)->orwhere('quality_id',11)->where('pos_kyout_purchases.shop_owner_id', $shopId);
            $query = $query6->union($query7);
        }
        else if($type == 1){
            $query = $query1->unionAll($query2)->unionAll($query3)->unionAll($query4);
        }
        else{
            $cat = explode("12", $type);
            $query8 = $query1->where('pos_purchases.category_id',$cat[1])->where('pos_purchases.shop_owner_id', $shopId);
            $query9 = $query2->where('pos_kyout_purchases.category_id',$cat[1])->where('pos_kyout_purchases.shop_owner_id', $shopId);
            $query10 = $query3->where('pos_platinum_purchases.category_id',$cat[1])->where('pos_platinum_purchases.shop_owner_id', $shopId);
            $query11 = $query4->where('pos_white_gold_purchases.category_id',$cat[1])->where('pos_white_gold_purchases.shop_owner_id', $shopId);
            $query = $query8->unionAll($query9)->unionAll($query10)->unionAll($query11);
        }
        
        return $query;
    }
}
