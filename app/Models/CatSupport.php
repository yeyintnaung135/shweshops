<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatSupport extends Model
{
    //
    protected $table = 'categories_for_support';
    protected $fillable = ['title'];
}
