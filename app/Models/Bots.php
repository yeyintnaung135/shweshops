<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bots extends Model
{
    //
    protected $fillable = ['ip', 'user_agent', 'checklink'];
}
