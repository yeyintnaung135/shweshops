<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersSelection extends Model
{
    //
    protected $fillable = ['user_id', 'selection_id'];
    public $table = 'cart';
}
