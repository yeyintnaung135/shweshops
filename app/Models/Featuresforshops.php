<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Featuresforshops extends Model
{
    //
    protected $table='features_for_shop';
    protected $fillable=['shop_id','feature'];

}
