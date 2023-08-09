<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopBanner extends Model
{
    use SoftDeletes;
    protected $table = 'shops_banner';
    protected $guarded = [];
}
