<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class facebookmessage extends Model
{
    //
    protected $table='fb_messenger_click_log';
    protected $fillable=['user_fb_id','shop_id','user_id','item_id'];

}