<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopOwnersFav extends Model
{
    //
    protected $fillable = ['user_id', 'fav_id'];
    public $table = 'shop_owners_fav';
}
