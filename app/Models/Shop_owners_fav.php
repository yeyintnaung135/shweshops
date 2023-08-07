<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop_owners_fav extends Model
{
    //
    protected $fillable=['user_id','fav_id'];
    public $table='shop_owners_fav';
}
