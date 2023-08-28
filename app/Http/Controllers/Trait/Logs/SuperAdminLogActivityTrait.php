<?php

namespace App\Http\Controllers\Trait\Logs;

use App\Models\LogActivity;
use App\Models\SuperAdminLogActivity;
use Illuminate\Support\Facades\Auth;

trait SuperAdminLogActivityTrait
{
    // ads
    public static function SuperAdminAdsCreateLog($subject)
    {

        $log = [];
        $log['name'] = Auth::guard('super_admin')->user()->name;
        $log['type'] = 'ads';
        $log['type_name'] = $subject->name;
        $log['type_id'] = $subject->id;
        $log['status'] = 'create';
        if (Auth::guard('super_admin')->user()->role == 0 or Auth::guard('super_admin')->user()->role == 4) {
            $log['role'] = "SuperAdmin";

        } else {
            $log['role'] = "Sub-Admin";
        }
        $log['role_id'] = Auth::guard('super_admin')->user()->id;
        SuperAdminLogActivity::create($log);
    }

    public static function SuperAdminAdsDeleteLog($subject)
    {

        $log = [];
        $log['name'] = Auth::guard('super_admin')->user()->name;
        $log['type'] = 'ads';
        $log['type_name'] = $subject->name;
        $log['type_id'] = $subject;
        $log['status'] = 'delete';
        if (Auth::guard('super_admin')->user()->role == 0 or Auth::guard('super_admin')->user()->role == 4) {
            $log['role'] = "SuperAdmin";

        } else {
            $log['role'] = "Sub-Admin";
        }
        $log['role_id'] = Auth::guard('super_admin')->user()->id;
        SuperAdminLogActivity::create($log);
    }

    public static function SuperAdminAdsEditLog($subject)
    {

        $log = [];
        $log['name'] = Auth::guard('super_admin')->user()->name;
        $log['type'] = 'ads';
        $log['type_name'] = $subject->name;
        $log['type_id'] = $subject->id;
        $log['status'] = 'edit';
        if (Auth::guard('super_admin')->user()->role == 0) {
            $log['role'] = "SuperAdmin";

        } else {
            $log['role'] = "Sub-Admin";
        }
        $log['role_id'] = Auth::guard('super_admin')->user()->id;

        SuperAdminLogActivity::create($log);
    }
    // end of ads

    // shop
    public static function SuperAdminShopCreateLog($subject)
    {

        $log = [];
        $log['name'] = Auth::guard('super_admin')->user()->name;
        $log['type'] = 'shop';
        $log['type_name'] = $subject->name;
        $log['type_id'] = $subject->id;
        $log['status'] = 'create';
        if (Auth::guard('super_admin')->user()->role == 0 or Auth::guard('super_admin')->user()->role == 4) {
            $log['role'] = "SuperAdmin";

        } else {
            $log['role'] = "Sub-Admin";
        }
        $log['role_id'] = Auth::guard('super_admin')->user()->id;
        SuperAdminLogActivity::create($log);
    }

    public static function SuperAdminShopEditLog($subject)
    {

        $log = [];
        $log['name'] = Auth::guard('super_admin')->user()->name;
        $log['type'] = 'shop';
        $log['type_name'] = $subject['name'];
        $log['type_id'] = "0";
        $log['status'] = 'edit';
        if (Auth::guard('super_admin')->user()->role == 0 or Auth::guard('super_admin')->user()->role == 4) {
            $log['role'] = "SuperAdmin";

        } else {
            $log['role'] = "Sub-Admin";
        }
        $log['role_id'] = Auth::guard('super_admin')->user()->id;
        SuperAdminLogActivity::create($log);
    }

    public static function SuperAdminShopDeleteLog($subject)
    {

        $log = [];
        $log['name'] = Auth::guard('super_admin')->user()->name;
        $log['type'] = 'shop';
        $log['type_name'] = $subject['name'];
        $log['type_id'] = $subject['id'];
        $log['status'] = 'delete';
        if (Auth::guard('super_admin')->user()->role == 0 or Auth::guard('super_admin')->user()->role == 4) {
            $log['role'] = "SuperAdmin";

        } else {
            $log['role'] = "Sub-Admin";
        }
        $log['role_id'] = Auth::guard('super_admin')->user()->id;
        SuperAdminLogActivity::create($log);
    }
    // end of shop

    // admin
    public static function SuperAdminAdminCreateLog($subject)
    {

        $log = [];
        $log['name'] = Auth::guard('super_admin')->user()->name;
        $log['type'] = 'sub-admin';
        $log['type_id'] = $subject['name'];
        $log['type_name'] = $subject['name'];
        $log['status'] = 'create';
        if (Auth::guard('super_admin')->user()->role == 0 or Auth::guard('super_admin')->user()->role == 4) {
            $log['role'] = "SuperAdmin";

        } else {
            $log['role'] = "Sub-Admin";
        }
        $log['role_id'] = Auth::guard('super_admin')->user()->id;
        SuperAdminLogActivity::create($log);
    }

    public static function SuperAdminAdminEditLog($subject)
    {
        $log = [];
        $log['name'] = Auth::guard('super_admin')->user()->name;
        $log['type'] = 'admin';
        $log['type_name'] = $subject['name'];
        $log['status'] = 'edit';
        if (Auth::guard('super_admin')->user()->role == 0 or Auth::guard('super_admin')->user()->role == 4) {
            $log['role'] = "SuperAdmin";

        } else {
            $log['role'] = "Sub-Admin";
        }
        $log['role_id'] = Auth::guard('super_admin')->user()->id;
        SuperAdminLogActivity::create($log);
    }

    // end of admin

    public static function logActivityLists()
    {
        return LogActivity::latest()->get();
    }

}
