<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    //
    protected $table = 'state';
    protected $fillable = ['id', 'name', 'myan_name'];
}
