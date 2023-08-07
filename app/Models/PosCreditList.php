<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosCreditList extends Model
{
    //
    protected $fillable = ['customer_name','shop_owner_id','phone','address','purchase_code','purchase_date','pay_date','credit'];
}
