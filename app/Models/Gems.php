<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gems extends Model
{
    //
    protected $fillable=['gems','item_id'];
    protected $table='for_gems_and_diamonds';
    public $timestamps=false;
}
