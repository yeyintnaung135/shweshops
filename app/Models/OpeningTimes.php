<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpeningTimes extends Model
{
    protected $fillable = ['opening_time', 'shop_id'];
    protected $table = 'shops_opening_hours';
}
