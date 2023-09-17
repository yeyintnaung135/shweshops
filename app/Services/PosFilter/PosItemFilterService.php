<?php

namespace App\Services\PosFilter;

use App\Http\Controllers\Trait\UserRole;
use App\Models\POS\PosWhiteGoldPurchase;
use App\Models\POS\PosPlatinumPurchase;
use App\Models\POS\PosKyoutPurchase;
use App\Models\POS\PosPurchase;
use App\Models\POS\PosDiamond;
use App\Models\POS\PosReturnList;

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

        $query1 = PosPurchase::select('id', 'code_number', 'gold_name', 'stock_qty','gold_fee','product_gram_kyat_pe_yway', 'date')
                ->where('shop_owner_id', $shopId);

        $query2 = PosKyoutPurchase::select('id', 'code_number', 'gold_name', 'stock_qty','capital','gold_gram_kyat_pe_yway', 'date')
        ->where('shop_owner_id', $shopId);

        $query3 = PosPlatinumPurchase::select('id', 'code_number', 'platinum_name', 'stock_qty','capital','product_gram', 'date')
        ->where('shop_owner_id', $shopId);

        $query4 = PosWhiteGoldPurchase::select('id', 'code_number', 'whitegold_name', 'stock_qty','capital','product_gram', 'date')
        ->where('shop_owner_id', $shopId);

        $query = $query1->unionAll($query2)->unionAll($query3)->unionAll($query4);

        if($type == 1){
            return $query;
        }

        if($type == 2){
            return $query1;
        }

        if($type === 3){
            $query = $query2;
        }

        if($type === 4){
            $query = $query3;
        }

        if($type === 5){
            $query = $query4;
        }

        if ($fromDate) {
            $query->whereDate('date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('date', '<=', $toDate);
        }

        return $query;
    }
}
