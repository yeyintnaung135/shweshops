<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagerSelection extends Model
{
    //
    protected $fillable = ['user_id', 'selection_id'];
    public $table = 'manager_selection';
}
