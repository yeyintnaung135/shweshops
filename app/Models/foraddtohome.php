<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class foraddtohome extends Model
{
    //
    protected $table='for_add_to_home';
    protected $fillable=['user_id','added','show_atc'];
}
