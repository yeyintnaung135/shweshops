<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users_fav extends Model
{
    //
    protected $fillable=['user_id','fav_id'];
    public $table='users_fav';
}
