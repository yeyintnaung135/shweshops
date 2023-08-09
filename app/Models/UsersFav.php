<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersFav extends Model
{
    //
    protected $fillable = ['user_id', 'fav_id'];
    public $table = 'users_fav';
}
