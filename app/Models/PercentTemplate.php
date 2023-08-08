<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PercentTemplate extends Model
{
    use SoftDeletes;
    protected $table = 'percent_template';
    protected $fillable = ['shop_id', 'name', 'undamage_product', 'damage_product', 'valuable_product', 'deleted_at'];
}
