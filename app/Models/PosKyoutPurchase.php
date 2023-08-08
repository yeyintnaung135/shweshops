<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosKyoutPurchase extends Model
{
    //
    protected $fillable = [
        'date', 'shop_owner_id', 'gold_name', 'supplier_id', 'quality_id', 'gold_type', 'staff_id', 'counter_shop',
        'purchase_price', 'category_id', 'code_number', 'diamonds', 'counts', 'carrats', 'yaties', 'bes', 'photo', 'color',
        'type', 'gold_gram_kyat_pe_yway', 'diamond_gram_kyat_pe_yway', 'decrease_pe_yway', 'qty',
        'profit_pe_yway', 'service_pe_yway', 'gold_price', 'decrease_price', 'profit', 'service_fee',
        'gold_fee', 'selling_price', 'diamond_selling_price', 'capital', 'stock_qty',
        'remark', 'barcode_text', 'barcode', 'sell_flag',
    ];
    protected $table = 'pos_kyout_purchases';
    protected $with = ['supplier', 'category', 'quality', 'diamond'];

    public function supplier()
    {
        return $this->belongsTo(PosSupplier::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function quality()
    {
        return $this->belongsTo(PosQuality::class);
    }

    public function staff()
    {
        return $this->belongsTo(PosStaff::class);
    }

    public function diamond()
    {
        return $this->belongsTo(PosDiamond::class);
    }
}
