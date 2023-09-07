<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class PosDiamond extends Model
{
    use SoftDeletes;
    //
    protected $fillable = ['date', 'shop_owner_id', 'code_number', 'diamond_name', 'remark', 'carrat_price', 'yati_price', 'deleted_at'];
    protected $table = 'pos_diamonds';
}
