<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosItemPurchase extends Model
{
    //
    protected $fillable = ['item_id','purchase_id','type'];
}
