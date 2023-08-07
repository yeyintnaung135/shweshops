<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forfirebase extends Model
{
    //
    public $fillable=['token','androidtoken','userid','shopid'];
    protected $table='firebase';
}
