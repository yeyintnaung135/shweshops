<?php

namespace App\Services\PosFilter;

use App\Http\Controllers\Trait\UserRole;
use App\Models\POS\PosPurchase;

//NOTE PosPurchaseFilterService is responsible for handling filtering datatable objects

class PosPurchaseFilterService
{
    use UserRole;

    public function filterPurchases($request)
    {
        $shopId = $this->get_shopid();
        $fCounter = $request->input('f_counter');
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $supId = $request->input('sup');
        $qualId = $request->input('qual');
        $ptypeId = $request->input('ptype');

        $query = PosPurchase::select(
            'id', 'gold_name', 'supplier_id', 'code_number', 'sell_flag',
            'product_gram_kyat_pe_yway', 'stock_qty', 'gold_fee', 'date'
        );

        $query->when($fCounter !== null, function ($query) use ($shopId, $fCounter) {
            if ($fCounter === 'all_shop') {
                $query->where('shop_owner_id', $shopId);
            } else {
                $query->where('counter_shop', $fCounter)->where('shop_owner_id', $shopId);
            }
        });

        if ($fromDate) {
            $query->whereDate('created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('created_at', '<=', $toDate);
        }

        // Additional filters
        if ($supId) {
            $query->where('supplier_id', $supId);
        }

        if ($qualId) {
            $query->where('quality_id', $qualId);
        }

        if ($ptypeId) {
            $query->where('category_id', $ptypeId);
        }

        return $query;
    }

}
