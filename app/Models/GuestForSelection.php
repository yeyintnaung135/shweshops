<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestForSelection extends Model
{
    //
    protected $fillable = ['guest_id', 'selection_id', 'fav_id'];
    public $table = 'guest_for_selection';
}
