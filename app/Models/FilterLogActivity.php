<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilterLogActivity extends Model
{
    //
    protected $fillable = [
        'price', 'url', 'method', 'ip', 'agent', 'user_id',
    ];
}
