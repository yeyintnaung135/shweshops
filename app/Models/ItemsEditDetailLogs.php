<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemsEditDetailLogs extends Model
{
    //
    protected $fillable = [
        'photo_one', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_six', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten',
        'default_photo', 'name', 'price', 'description', 'product_code', 'gold_quality', 'gold_colour', 'sizing_guide', 'undamage', 'expensive_thing',
        'damage', 'weight', 'weight_unit', 'min_price', 'max_price', 'review', 'stock', 'stock_count', 'gems', 'diamond', 'carat',
        'yati', 'gender', 'handmade', 'pwint', 'd_gram', 'category_id', 'view_count', 'charge',
        'new_photo_one', 'new_photo_two', 'new_photo_three', 'new_photo_four', 'new_photo_five', 'new_photo_six', 'new_photo_seven', 'new_photo_eight', 'new_photo_nine', 'new_photo_ten',
        'new_default_photo', 'new_name', 'new_price', 'new_description', 'new_product_code', 'new_gold_quality', 'new_gold_colour', 'new_sizing_guide', 'new_undamage', 'new_expensive_thing',
        'new_damage', 'new_weight', 'new_weight_unit', 'new_min_price', 'new_max_price', 'new_review', 'new_stock', 'new_stock_count', 'new_gems', 'new_diamond', 'new_carat',
        'new_yati', 'new_gender', 'new_handmade', 'new_pwint', 'new_d_gram', 'new_category_id', 'new_view_count', 'new_charge', 'shopownereditlogs_id',

    ];
}
