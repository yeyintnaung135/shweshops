<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    //
    public $table = 'support';
    public $fillable = ['title', 'video', 'cat_id', 'for_what'];
}
