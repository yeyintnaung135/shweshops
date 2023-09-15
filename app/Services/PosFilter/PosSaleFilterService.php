<?php

namespace App\Services\PosFilter;

use App\Http\Controllers\Trait\UserRole;
use App\Models\POS\PosGoldSale;
use App\Models\POS\PosKyoutSale;
use App\Models\POS\PosPlatinumSale;
use App\Models\POS\PosWhiteGoldSale;

//NOTE PosPurchaseFilterService is responsible for filtering sale lists' datatables

class PosSaleFilterService
{
    use UserRole;

    public function filterGoldSales($request)
    {
        $shopId = $this->get_shopid();
        $fCounter = $request->input('f_counter');
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $supId = $request->input('sup');
        $qualId = $request->input('qual');
        $catId = $request->input('cat');

        $query = PosGoldSale::join('pos_purchases', 'pos_gold_sales.purchase_id', '=', 'pos_purchases.id')
            ->select('pos_gold_sales.id', 'pos_gold_sales.amount', 'pos_gold_sales.date', 'pos_purchases.gold_name',
                'pos_purchases.code_number', 'pos_purchases.product_gram_kyat_pe_yway', 'pos_purchases.decrease_pe_yway');

        $query->when($fCounter !== null, function ($query) use ($shopId, $fCounter) {
            if ($fCounter === 'all_shop') {
                $query->where('pos_purchases.shop_owner_id', $shopId);
            } else {
                $query->where('pos_purchases.counter_shop', $fCounter)->where('pos_purchases.shop_owner_id', $shopId);
            }
        });

        if ($fromDate) {
            $query->whereDate('pos_gold_sales.created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('pos_gold_sales.created_at', '<=', $toDate);
        }

        // Additional filters
        if ($supId) {
            $query->where('pos_purchases.supplier_id', $supId);
        }

        if ($qualId) {
            $query->where('pos_purchases.quality_id', $qualId);
        }

        if ($catId) {
            $query->where('pos_purchases.category_id', $catId);
        }

        return $query;
    }

    public function filterKyoutSales($request)
    {
        $shopId = $this->get_shopid();
        $fCounter = $request->input('f_counter');
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $supId = $request->input('sup');
        $qualId = $request->input('qual');
        $catId = $request->input('cat');

        $query = PosKyoutSale::join('pos_kyout_purchases', 'pos_kyout_sales.purchase_id', '=', 'pos_kyout_purchases.id')
            ->select('pos_kyout_sales.id', 'pos_kyout_sales.amount', 'pos_kyout_sales.date', 'pos_kyout_purchases.gold_name',
                'pos_kyout_purchases.code_number', 'pos_kyout_purchases.gold_gram_kyat_pe_yway', 'pos_kyout_purchases.decrease_pe_yway');

        $query->when($fCounter !== null, function ($query) use ($shopId, $fCounter) {
            if ($fCounter === 'all_shop') {
                $query->where('pos_kyout_purchases.shop_owner_id', $shopId);
            } else {
                $query->where('pos_kyout_purchases.counter_shop', $fCounter)->where('pos_kyout_purchases.shop_owner_id', $shopId);
            }
        });

        if ($fromDate) {
            $query->whereDate('pos_kyout_sales.created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('pos_kyout_sales.created_at', '<=', $toDate);
        }

        // Additional filters
        if ($supId) {
            $query->where('pos_kyout_purchases.supplier_id', $supId);
        }

        if ($qualId) {
            $query->where('pos_kyout_purchases.quality_id', $qualId);
        }

        if ($catId) {
            $query->where('pos_kyout_purchases.category_id', $catId);
        }

        return $query;
    }

    public function filterPlatinumSales($request)
    {
        $shopId = $this->get_shopid();
        $fCounter = $request->input('f_counter');
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $quality = $request->input('qual');
        $catId = $request->input('cat');

        $query = PosPlatinumSale::join('pos_platinum_purchases', 'pos_platinum_sales.purchase_id', '=', 'pos_platinum_purchases.id')
            ->select('pos_platinum_sales.id', 'pos_platinum_sales.amount', 'pos_platinum_sales.date', 'pos_platinum_purchases.platinum_name', 'pos_platinum_purchases.code_number', 'pos_platinum_purchases.product_gram');

        $query->when($fCounter !== null, function ($query) use ($shopId, $fCounter) {
            if ($fCounter === 'all_shop') {
                $query->where('pos_platinum_purchases.shop_owner_id', $shopId);
            } else {
                $query->where('pos_platinum_purchases.counter_shop', $fCounter)->where('pos_platinum_purchases.shop_owner_id', $shopId);
            }
        });

        if ($fromDate) {
            $query->whereDate('pos_platinum_sales.created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('pos_platinum_sales.created_at', '<=', $toDate);
        }

        // Additional filters

        if ($quality) {
            $query->where('pos_platinum_purchases.quality', $quality);
        }

        if ($catId) {
            $query->where('pos_platinum_purchases.category_id', $catId);
        }

        return $query;
    }

    public function filterWhiteGoldSales($request)
    {
        $shopId = $this->get_shopid();
        $fCounter = $request->input('f_counter');
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $quality = $request->input('qual');
        $catId = $request->input('cat');

        $query = PosWhiteGoldSale::join('pos_white_gold_purchases', 'pos_white_gold_sales.purchase_id', '=', 'pos_white_gold_purchases.id')
            ->select('pos_white_gold_sales.id', 'pos_white_gold_sales.amount', 'pos_white_gold_sales.date', 'pos_white_gold_purchases.whitegold_name', 'pos_white_gold_purchases.code_number', 'pos_white_gold_purchases.product_gram');

        $query->when($fCounter !== null, function ($query) use ($shopId, $fCounter) {
            if ($fCounter === 'all_shop') {
                $query->where('pos_white_gold_purchases.shop_owner_id', $shopId);
            } else {
                $query->where('pos_white_gold_purchases.counter_shop', $fCounter)->where('pos_white_gold_purchases.shop_owner_id', $shopId);
            }
        });

        if ($fromDate) {
            $query->whereDate('pos_white_gold_sales.created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('pos_white_gold_sales.created_at', '<=', $toDate);
        }

        // Additional filters

        if ($quality) {
            $query->where('pos_white_gold_purchases.quality', $quality);
        }

        if ($catId) {
            $query->where('pos_white_gold_purchases.category_id', $catId);
        }

        return $query;
    }

}
