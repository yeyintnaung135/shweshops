<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{
    //
    protected $fillable=['top_text','phone','email','mid_text','address','map','active','image'];
    public $table='contactus';
}
