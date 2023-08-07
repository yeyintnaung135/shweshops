<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Passwordresetforshop extends Model
{
    //
    protected $fillable=['id','emailorphone','code','expire_at','try_counts','status'];
    public $table='password_resets_for_shop';
    public $timestamps=false;

}
