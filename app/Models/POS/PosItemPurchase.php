<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class PosItemPurchase extends Model
{
    //
    protected $fillable = ['item_id', 'purchase_id', 'type'];
}
