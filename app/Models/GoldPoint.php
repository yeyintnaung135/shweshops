<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoldPoint extends Model
{
    protected $table = "gold_points";
    protected $fillable = ['counts', 'status'];
}
