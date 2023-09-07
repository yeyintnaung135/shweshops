<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class PosWhiteGoldPurchase extends Model
{
    //
    protected $fillable = [
        'date', 'shop_owner_id', 'supplier_id', 'quality', 'staff_id', 'whitegold_name', 'whitegold_type',
        'purchase_price', 'category_id', 'code_number', 'counter_shop', 'qty',
        'product_gram', 'profit', 'whitegold_price', 'stock_qty',
        'capital', 'selling_price', 'color', 'sell_flag',
        'remark', 'photo', 'barcode_text', 'type', 'barcode',
    ];
    protected $table = 'pos_white_gold_purchases';
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
