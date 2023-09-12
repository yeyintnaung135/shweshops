<?php

namespace App\Models\POS;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class PosReturnList extends Model
{
    //
    protected $fillable = [
        'date', 'shop_owner_id', 'quality_id', 'category_id', 'diamonds', 'counts', 'carrats', 'yaties', 'bes',
        'product_gram_kyat_pe_yway', 'gold_price', 'product_type', 'photo',
        'gold_fee', 'remark', 'customer_name', 'phone', 'address', 'add_flag',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function quality()
    {
        return $this->belongsTo(PosQuality::class);
    }
}
