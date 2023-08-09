<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagerFav extends Model
{
    //
    protected $fillable = ['user_id', 'fav_id'];
    public $table = 'manager_fav';
}
