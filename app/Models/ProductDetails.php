<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetails extends Model
{
    //
    protected $fillable = ['id', 'name'];
    public $table = 'product_details';

}
