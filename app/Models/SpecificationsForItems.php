<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecificationsForItems extends Model
{
    //
    protected $fillable = ['id', 'specification_id', 'unit', 'item_id'];
    public $table = 'specifications_for_items';
}
