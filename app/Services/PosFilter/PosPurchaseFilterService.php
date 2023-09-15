<?php

namespace App\Services\PosFilter;

use App\Http\Controllers\Trait\UserRole;
use App\Models\POS\PosKyoutPurchase;
use App\Models\POS\PosPlatinumPurchase;
use App\Models\POS\PosPurchase;
use App\Models\POS\PosWhiteGoldPurchase;

//NOTE PosPurchaseFilterService is responsible for filtering purchase lists' datatables

class PosPurchaseFilterService
{
    use UserRole;

    public function filter_purchases($request)
    {
        $shopId = $this->get_shopid();
        $fCounter = $request->input('f_counter');
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $supId = $request->input('sup');
        $qualId = $request->input('qual');
        $catId = $request->input('cat');

        $query = PosPurchase::select(
            'id', 'gold_name', 'supplier_id', 'code_number', 'sell_flag',
            'product_gram_kyat_pe_yway', 'decrease_pe_yway', 'stock_qty', 'gold_fee', 'date'
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
        $query->when($supId !== 'all', function ($query) use ($supId) {
            $query->where('supplier_id', $supId);
        });

        $query->when($qualId !== 'all', function ($query) use ($qualId) {
            $query->where('quality_id', $qualId);
        });

        $query->when($catId !== 'all', function ($query) use ($catId) {
            $query->where('category_id', $catId);
        });

        return $query;
    }

    public function filter_kyout_purchases($request)
    {
        $shopId = $this->get_shopid();
        $fCounter = $request->input('f_counter');
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $supId = $request->input('sup');
        $diamond = $request->input('dia');
        $catId = $request->input('cat');

        $query = PosKyoutPurchase::select(
            'id', 'gold_name', 'supplier_id', 'quality_id', 'code_number', 'sell_flag',
            'gold_gram_kyat_pe_yway', 'decrease_pe_yway', 'stock_qty', 'capital', 'date', 'diamonds'
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
        $query->when($supId !== 'all', function ($query) use ($supId) {
            $query->where('supplier_id', $supId);
        });

        $query->when($diamond !== 'all', function ($query) use ($diamond) {
            $query->where('diamonds', $diamond);
        });

        $query->when($catId !== 'all', function ($query) use ($catId) {
            $query->where('category_id', $catId);
        });

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
        $query->when($quality !== 'all', function ($query) use ($quality) {
            $query->where('quality', $quality);
        });

        $query->when($catId !== 'all', function ($query) use ($catId) {
            $query->where('category_id', $catId);
        });

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
