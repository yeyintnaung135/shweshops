<?php

namespace App\Models\POS;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class PosPurchase extends Model
{
    //

    protected $fillable = [
        'date', 'shop_owner_id', 'supplier_id', 'quality_id', 'staff_id', 'gold_name',
        'purchase_price', 'category_id', 'code_number', 'color', 'counter_shop',
        'product_gram_kyat_pe_yway', 'service_pe_yway', 'gold_price', 'qty',
        'decrease_pe_yway', 'profit_pe_yway', 'decrease_price', 'stock_qty',
        'gold_fee', 'profit', 'service_fee', 'selling_price', 'sell_flag',
        'gold_type', 'remark', 'photo', 'barcode_text', 'type', 'barcode',
    ];
    protected $table = 'pos_purchases';
    protected $with = ['supplier', 'category', 'quality'];

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
}
