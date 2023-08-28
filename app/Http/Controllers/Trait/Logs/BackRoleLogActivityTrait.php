<?php

namespace App\Http\Controllers\Trait\Logs;

use App\Models\BackRoleLogActivity;
use Illuminate\Support\Facades\Auth;

trait BackRoleLogActivityTrait
{

    public static function BackroleDeleteLog($subject, $shop_id)
    {
        $log = [];
        $log['shop_id'] = $shop_id;
        $log['user_name'] = Auth::guard('shop_owners_and_staffs')->user()->name;

        $userRole = Auth::guard('shop_owners_and_staffs')->user()->role_id;
        switch ($userRole) {
            case 1:
                $log['user_role'] = 'admin';
                break;
            case 2:
                $log['user_role'] = 'manager';
                break;
            case 3:
                $log['user_role'] = 'staff';
                break;
            case 4:
                $log['user_role'] = 'shopowner';
                break;
            default:
                $log['user_role'] = 'unknown';
                break;
        }

        $log['action'] = 'delete';
        $log['name'] = $subject->name;
        $role = $subject->role_id;

        $roles = [1 => 'admin', 2 => 'manager', 3 => 'staff'];
        $log['role'] = $roles[$role] ?? 'unknown';

        BackRoleLogActivity::create($log);
    }

    public static function BackroleCreateLog($subject, $shop_id)
    {
        // return dd($subject);
        $log = [];
        $log['shop_id'] = $shop_id;
        $log['user_name'] = Auth::guard('shop_owners_and_staffs')->user()->name;

        $userRole = Auth::guard('shop_owners_and_staffs')->user()->role_id;
        switch ($userRole) {
            case 1:
                $log['user_role'] = 'admin';
                break;
            case 2:
                $log['user_role'] = 'manager';
                break;
            case 3:
                $log['user_role'] = 'staff';
                break;
            case 4:
                $log['user_role'] = 'shopowner';
                break;
            default:
                $log['user_role'] = 'unknown';
                break;
        }

        $log['action'] = 'create';
        $log['name'] = $subject['name'];
        $role = $subject['role_id'];

        $roles = [1 => 'admin', 2 => 'manager', 3 => 'staff'];
        $log['role'] = $roles[$role] ?? 'unknown';

        BackRoleLogActivity::create($log);
    }

    public static function BackroleEditLog($subject, $shop_id)
    {
        $log = [];
        $log['shop_id'] = $shop_id;
        $log['user_name'] = Auth::guard('shop_owners_and_staffs')->user()->name;

        $userRole = Auth::guard('shop_owners_and_staffs')->user()->role_id;
        switch ($userRole) {
            case 1:
                $log['user_role'] = 'admin';
                break;
            case 2:
                $log['user_role'] = 'manager';
                break;
            case 3:
                $log['user_role'] = 'staff';
                break;
            case 4:
                $log['user_role'] = 'shopowner';
                break;
            default:
                $log['user_role'] = 'unknown';
                break;
        }

        $log['action'] = 'edit';
        $log['name'] = $subject['name'];
        $role = $subject['role_id'];

        $roles = [1 => 'admin', 2 => 'manager', 3 => 'staff'];
        $log['role'] = $roles[$role] ?? 'unknown';

        $backroleid = BackRoleLogActivity::create($log);
        return $backroleid;
    }

    public static function logActivityLists()
    {
        return BackRoleLogActivity::latest()->get();
    }

}
