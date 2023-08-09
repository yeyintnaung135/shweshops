<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//NOTE this is for android and ios web apps files

class AppFile extends Model
{
    protected $fillable = ['file', 'user_type', 'operating_system'];
}
