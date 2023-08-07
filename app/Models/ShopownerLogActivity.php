<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopownerLogActivity extends Model
{
    
     use SoftDeletes;
     protected $fillable = [
      'shop_id','shop_name','product_code','item_id','item_name','category','user_name','action','role','deleted_at'
    ];
}
