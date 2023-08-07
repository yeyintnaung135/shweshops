<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosPlatinumSale extends Model
{
    //
    protected $fillable = ['date','shop_owner_id','purchase_id','staff_id','counter_shop','remark','customer_name','phone','address','price','total_price','selling_price','decrease_price','amount','return_price','left_price','prepaid','credit'];
    protected $table='pos_platinum_sales';
    protected $with = ['purchase'];
  

    public function purchase()
    {
        return $this->belongsTo(PosPlatinumPurchase::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function staff(){
        return $this->belongsTo(PosStaff::class);
    }
}
