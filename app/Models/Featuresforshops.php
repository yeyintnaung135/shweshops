<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturesForShops extends Model
{
    //
    protected $table = 'features_for_shop';
    protected $fillable = ['shop_id', 'feature'];

}
