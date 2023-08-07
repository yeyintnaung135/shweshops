<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guestoruserid extends Model
{
    //
    protected $table='guestoruserid';
    protected $fillable=['guest_id','user_id','ip','user_agent'];
}
