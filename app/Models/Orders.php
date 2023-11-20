<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = ['user_id', 'product_id', 'user_name','note', 'user_phone', 'address', 'status'];

    public function items(){
       return $this->belongsTo(Item::class,'product_id');
    }
    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
}

