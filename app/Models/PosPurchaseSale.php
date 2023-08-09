<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosPurchaseSale extends Model
{
    //
    protected $fillable = ['purchase_id', 'shop_owner_id', 'sale_id', 'qty', 'type'];
}
