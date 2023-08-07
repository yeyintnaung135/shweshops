<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    protected $table = "news";

    protected $fillable = ['shop_id', 'title', 'slug', 'description', 'image', 'deleted_at'];
}
