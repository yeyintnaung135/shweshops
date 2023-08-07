<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $table = "points";
    protected $fillable = [ 'count','status'];
    
    public function user_points()
    {
        return $this->belongsTo('App\UserPoint');
    }
}
