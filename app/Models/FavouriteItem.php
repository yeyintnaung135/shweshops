<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavouriteItem extends Model
{
    //
    protected $table = 'favourite';
    protected $fillable = ['user_id', 'fav_id','type'];

}
