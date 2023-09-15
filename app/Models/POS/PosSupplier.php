<?php

namespace App\Models\POS;

use App\Models\State;
use App\Models\Township;
use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class PosSupplier extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['date', 'shop_owner_id', 'code_number', 'name', 'shop_name', 'shop_type', 'phone', 'other_phone', 'state_id', 'township_id', 'address', 'remark', 'type', 'count', 'deleted_at'];
    protected $table = 'pos_suppliers';

    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function township()
    {
        return $this->belongsTo(Township::class);
    }
}
