<?php

namespace App\Services\PosFilter;

use App\Http\Controllers\Trait\UserRole;
use App\Models\POS\PosCounterShop;
use App\Models\POS\PosStaff;
use App\Models\POS\PosSupplier;

//NOTE PosShopFilterService is responsible for filtering shop and their staff lists' datatables

class PosShopFilterService
{
    use UserRole;

    public function filter_counter_shops($request)
    {
        $shopId = $this->get_shopid();
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $query = PosCounterShop::select('id', 'shop_name', 'counter_name', 'staff_no', 'address', 'date')
            ->where('shop_owner_id', $shopId);

        if ($fromDate) {
            $query->whereDate('date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('date', '<=', $toDate);
        }

        return $query;
    }

    public function filter_staffs($request)
    {
        $shopId = $this->get_shopid();
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        $query = PosStaff::select('id', 'code_number', 'name', 'phone', 'address', 'counter_shop', 'date')
            ->where('shop_id', $shopId);

        if ($fromDate) {
            $query->whereDate('date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('date', '<=', $toDate);
        }

        return $query;
    }

    public function filter_suppliers($request)
    {
        $shopId = $this->get_shopid();
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $text = $request->input('text');

        $query = PosSupplier::select('id', 'shop_name', 'shop_type', 'code_number', 'name', 'phone', 'other_phone', 'type', 'date')
            ->where('shop_owner_id', $shopId);

        if ($fromDate) {
            $query->whereDate('date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->whereDate('date', '<=', $toDate);
        }

        // Split the $text parameter into an array if it's not empty
        if ($text) {
            $types = explode('/', $text);
            // Apply the filter only if there are values in $types
            if (!empty($types)) {
                $query->orWhereIn('type', $types);
            }
        }

        return $query;
    }
}
