<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoldPrice extends Model
{
    //
    protected $fillable=['sell_price','buy_price'];
    public $table='gold_price';
}
