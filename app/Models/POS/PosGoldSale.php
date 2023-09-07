<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class PosGoldSale extends Model
{
    //

    protected $fillable = ['date', 'shop_owner_id', 'purchase_id', 'staff_id', 'counter_shop', 'remark', 'customer_name', 'phone', 'address', 'price', 'total_price', 'selling_price', 'decrease_price', 'amount', 'return_price', 'left_price', 'credit', 'prepaid'];
    protected $table = 'pos_gold_sales';
    protected $with = ['purchase'];

    public function purchase()
    {
        return $this->belongsTo(PosPurchase::class);
    }

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
