<?php

namespace App\Services\PosFilter;

use App\Http\Controllers\Trait\UserRole;
use App\Models\POS\PosDiamond;
use App\Models\POS\PosPlatinumPurchase;
use App\Models\POS\PosReturnList;
use App\Models\POS\PosWhiteGoldPurchase;

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

    public function filter_platinum_purchases($request)
    {
        $shopId = $this->get_shopid();
        $fCounter = $request->input('f_counter');
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $quality = $request->input('qual');
        $catId = $request->input('cat');

        $query = PosPlatinumPurchase::select(
            'id', 'platinum_name', 'quality', 'platinum_type', 'code_number', 'sell_flag',
            'product_gram', 'stock_qty', 'capital', 'date'
        );

        $query->when($fCounter !== null, function ($query) use ($shopId, $fCounter) {
            if ($fCounter === 'all_shops') {
                $query->where('shop_owner_id', $shopId);
            } else {
                $query->where('counter_shop', $fCounter)->where('shop_owner_id', $shopId);
            }
        });

        if ($fromDate) {
            $query->whereDate('date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('date', '<=', $toDate);
        }

        // Additional filters
        if ($quality) {
            $query->where('quality', $quality);
        }

        if ($catId) {
            $query->where('category_id', $catId);
        }

        return $query;
    }

    public function filter_white_gold_purchases($request)
    {
        $shopId = $this->get_shopid();
        $fCounter = $request->input('f_counter');
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $quality = $request->input('qual');
        $catId = $request->input('cat');

        $query = PosWhiteGoldPurchase::select(
            'id', 'whitegold_name', 'quality', 'whitegold_type', 'code_number', 'sell_flag',
            'product_gram', 'stock_qty', 'capital', 'date'
        );

        $query->when($fCounter !== null, function ($query) use ($shopId, $fCounter) {
            if ($fCounter === 'all_shops') {
                $query->where('shop_owner_id', $shopId);
            } else {
                $query->where('counter_shop', $fCounter)->where('shop_owner_id', $shopId);
            }
        });

        if ($fromDate) {
            $query->whereDate('date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('date', '<=', $toDate);
        }

        // Additional filters
        $query->when($quality !== 'all', function ($query) use ($quality) {
            $query->where('quality', $quality);
        });

        $query->when($catId !== 'all', function ($query) use ($catId) {
            $query->where('category_id', $catId);
        });

        return $query;
    }

}
