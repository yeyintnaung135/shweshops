<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CountSetting extends Model
{
    use SoftDeletes;
    public $table='counts_setting';
    public $fillable=['name','setting','shop_id','deleted_at'];
    public $timestamps = false;

    public function shops()
    {
        return $this->belongsToMany(Shopowner::class,'counts_has_permission');
    }
}
