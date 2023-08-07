<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sitesettings extends Model
{
    //
    public $table='sitesettings';
    public $fillable=['name','action'];
    public $timestamps = false;
}
