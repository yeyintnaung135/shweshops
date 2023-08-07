<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdcutdetailsForItems extends Model
{
    //
    protected $fillable=['id','product_details_id','unit','item_id'];
    public $table='product_details_for_items';
}
