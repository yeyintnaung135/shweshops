<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosPlatinumPurchase extends Model
{
    //
    protected $fillable = [
        'date', 'shop_owner_id', 'supplier_id', 'quality', 'staff_id', 'platinum_name', 'platinum_type',
        'purchase_price', 'category_id', 'code_number', 'counter_shop', 'qty',
        'product_gram', 'profit', 'platinum_price', 'stock_qty',
        'capital', 'selling_price', 'color', 'sell_flag',
        'remark', 'photo', 'barcode_text', 'type', 'barcode',
    ];
    protected $table = 'pos_platinum_purchases';
    protected $with = ['category'];

    public function supplier()
    {
        return $this->belongsTo(PosSupplier::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function staff()
    {
        return $this->belongsTo(PosStaff::class);
    }
}
