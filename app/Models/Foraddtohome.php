<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForAddToHome extends Model
{
    //
    protected $table = 'for_add_to_home';
    protected $fillable = ['user_id', 'added', 'show_atc'];
}
