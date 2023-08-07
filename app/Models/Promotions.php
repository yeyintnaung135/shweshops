<?php

namespace App\Models;

use App\Shopowner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotions extends Model
{
    use SoftDeletes;

    protected $table = "promotions";
    protected $fillable = ['title','slug','description','photo','shop_id','deleted_at'];

    public function getShop()
    {
        return $this->belongsTo(Shopowner::class,'shop_id');
    }

}
