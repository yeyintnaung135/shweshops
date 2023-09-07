<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PosStaff extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['date', 'shop_id', 'name', 'code_number', 'counter_shop', 'phone', 'address', 'role_id', 'password', 'deleted_at'];
    protected $table = 'pos_staffs';
    protected $appends = ['favIds', 'selectionIds', 'notification'];

    public function getRoleAttribute()
    {
        $role_name = Role::where('id', $this->role_id)->first();
        return $role_name;
    }

    public function getShopownerAttribute()
    {
        $shopowner_name = Shopowner::where('id', $this->shopowner_id)->first();
        return $shopowner_name;
    }
    public function getFavIdsAttribute()
    {
        $fav_ids = Manager_fav::where('user_id', $this->id)->get();
        return $fav_ids;
    }
    public function getSelectionIdsAttribute()
    {
        $selection_ids = Manager_selection::where('user_id', $this->id)->get();
        return $selection_ids;
    }
    public function getNotificationAttribute()
    {
        $noti = Usernoti::where('receiver_user_id', $this->id)->where('user_type', 'manager')->where('read_by_receiver', 0)->get();
        return $noti;
    }
}
