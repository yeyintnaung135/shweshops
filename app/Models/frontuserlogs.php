<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrontUserLogs extends Model
{
    //
    protected $table = 'front_user_logs';
    protected $fillable = ['userorguestid', 'visited_link', 'product_id', 'shop_id', 'status', 'ads_id'];
}
