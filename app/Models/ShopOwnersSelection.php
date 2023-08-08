<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopOwnersSelection extends Model
{
    //
    protected $fillable = ['user_id', 'selection_id'];
    public $table = 'shop_owners_selection';
}
