<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;

class PosAssignPlatinumPrice extends Model
{
    //
    protected $fillable = ['date', 'shop_owner_id', 'gradeA', 'gradeB', 'gradeC', 'gradeD'];
    protected $table = 'pos_assign_platinum_prices';
}
