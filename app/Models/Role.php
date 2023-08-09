<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = ['id', 'name'];
    protected $table = 'role';

    public function getShopownerAttribute()
    {
        $shopowner_name = Shopowner::where('id', $this->shopowner_id)->first();
        return $shopowner_name;
    }
}
