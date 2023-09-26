<?php

namespace App\Http\Controllers\Trait;

use App\Models\Item;
use App\Models\Role;
use App\Models\ShopOwnersAndStaffs;
use App\Models\Shops;
use Illuminate\Support\Facades\Auth;

trait UserRole
{

    private $role, $role_shop_id, $role_user, $user_lists;

    private function get_shopowners_role($user_role)
    {
        return Auth::guard('shop_owners_and_staffs')->user()->role->name;
    }

    public function current_shop_data()
    {

        return Shops::where('id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
    }

    private function role_check_trash($x)
    {
        if ($x == 1) {
            $this->role_user = ShopOwnersAndStaffs::onlyTrashed()->where('shop_id', $this->role_shop_id)->whereIn('role_id', [2, 3])->get();
        } elseif ($x == 2) {
            $this->role_user = ShopOwnersAndStaffs::onlyTrashed()->where('shop_id', $this->role_shop_id)->where(['role_id' => 3])->get();
        }
    }

    public function itisowneritem($itemid)
    {
        $tmpdata = 0;
        if ($this->isowner()) {
            $tmpdata = Item::where('shop_id', $this->get_shopid)->first()->count();
        } else {
            $tmpdata = Item::where('user_id', $this->get_shopid)->first()->count();
        }
        if ($tmpdata != 0) {
            return true;
        } else {
            return false;
        }
    }
    public function is_admin()
    {
        if (Auth::guard('shop_owners_and_staffs')->user()->role->id == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function is_manager()
    {
        if (Auth::guard('shop_owners_and_staffs')->user()->role->id == 2) {
            return true;
        } else {
            return false;
        }
    }

    public function is_owner()
    {
        if (Auth::guard('shop_owners_and_staffs')->user()->role->id == 4) {
            return true;
        } else {
            return false;
        }
    }
    public function is_staff()
    {
        if (Auth::guard('shop_owners_and_staffs')->user()->role->id == 3) {
            return true;
        } else {
            return false;
        }
    }
    public function unauthorize()
    {
        return abort(401);
    }
    public function getuserlistbyrolelevel()
    {
        if ($this->is_manager()) {
            return ShopOwnersAndStaffs::where('shop_id', $this->get_shopid())->whereIn('role_id', [3])->orderBy('created_at', 'desc')->get();
        }
        if ($this->is_admin()) {
            return ShopOwnersAndStaffs::where('shop_id', $this->get_shopid())->whereIn('role_id', [2, 3])->orderBy('created_at', 'desc')->get();
        }
        if ($this->is_owner()) {
            return ShopOwnersAndStaffs::where('shop_id', $this->get_shopid())->get();
        }
        if ($this->is_staff()) {

            return ShopOwnersAndStaffs::where('shop_id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        }
    }

    public function get_user_list_by_role_level_select()
    {
        if ($this->is_manager()) {
            return ShopOwnersAndStaffs::where('shop_id', $this->get_shopid())->whereIn('role_id', [3])->orderBy('created_at', 'desc');
        }
        if ($this->is_admin()) {
            return ShopOwnersAndStaffs::where('shop_id', $this->get_shopid())->whereIn('role_id', [2, 3])->orderBy('created_at', 'desc');
        }
        if ($this->is_owner()) {
            return ShopOwnersAndStaffs::where('shop_id', $this->get_shopid());
        }
        if ($this->is_staff()) {

            return ShopOwnersAndStaffs::where('shop_id', $this->get_shopid())->orderBy('created_at', 'desc');
        }
    }

    public function get_user_list_by_role_level_count()
    {
        if ($this->is_manager()) {
            return ShopOwnersAndStaffs::where('shop_id', $this->get_shopid())->whereIn('role_id', [3])->orderBy('created_at', 'desc')->count();
        }
        if ($this->is_admin()) {
            return ShopOwnersAndStaffs::where('shop_id', $this->get_shopid())->whereIn('role_id', [2, 3])->orderBy('created_at', 'desc')->count();
        }
        if ($this->is_owner()) {
            return ShopOwnersAndStaffs::where('shop_id', $this->get_shopid())->count();
        }
        if ($this->is_staff()) {

            return ShopOwnersAndStaffs::where('shop_id', $this->get_shopid())->orderBy('created_at', 'desc')->count();
        }
    }

    public function get_role_list()
    {
        if ($this->is_manager()) {
            return Role::whereIn('id', [3])->get();
        }
        if ($this->is_admin()) {
            return Role::whereIn('id', [2, 3])->get();
        }
        if ($this->is_owner()) {
            return Role::whereIn('id', [1, 2, 3])->get();
        }
        if ($this->is_staff()) {

            return ShopOwnersAndStaffs::where('shop_id', $this->get_shopid())->orderBy('created_at', 'desc')->get();
        }
    }

    public function trash_list_by_role()
    {
        if ($this->is_owner()) {
            return ShopOwnersAndStaffs::where('shop_id', $this->get_shopid())->select('id', 'name', 'phone', 'created_at', 'shop_id', 'role_id')->onlyTrashed();
        }
        if ($this->is_admin()) {
            return ShopOwnersAndStaffs::where('shop_id', $this->get_shopid())->select('id', 'name', 'phone', 'created_at', 'shop_id', 'role_id')->onlyTrashed()->whereIn('role_id', [2, 3])->orderBy('created_at', 'desc');
        }
        if ($this->is_manager()) {
            return ShopOwnersAndStaffs::where('shop_id', $this->get_shopid())->select('id', 'name', 'phone', 'created_at', 'shop_id', 'role_id')->onlyTrashed()->where('role_id', 3)->orderBy('created_at', 'desc');
        }
    }

    public function get_currentauthdata()
    {
        return Auth::guard('shop_owners_and_staffs')->user();
    }
    public function get_shopid()
    {
        $shop_id = $this->get_currentauthdata()->shop_id;

        return $shop_id;
    }
}
