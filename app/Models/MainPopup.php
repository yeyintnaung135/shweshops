<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainPopup extends Model
{
    protected $fillable = ['ad_title', 'video_name', 'video_path', 'shop_id'];
    protected $table = 'popups_for_premium_shops';
}
