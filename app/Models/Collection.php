<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = ['name', 'shop_id'];
    protected $table = 'collection';

    public function items()
    {
        return $this->hasMany(Item::class, 'collection_id');
    }

}
