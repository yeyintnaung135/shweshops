<?php

namespace App\Services\PosFilter;

use App\Http\Controllers\Trait\UserRole;
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
}
