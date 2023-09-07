<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteItems extends Model
{
    //
    protected $table = 'favorite';
    protected $fillable = ['user_id', 'fav_id','type'];

}
