<?php

namespace App\Helpers;

use App\Models\SuperadminLogActivity as SuperadminLogActivityModel;
use Illuminate\Support\Facades\Auth;

class SuperadminLogActivity
{

    // ads
    public static function SuperadminAdsDeleteLog($subject)
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
        SuperadminLogActivityModel::create($log);
    }

    public static function SuperadminAdsCreateLog($subject)
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
        SuperadminLogActivityModel::create($log);
    }

    public static function SuperadminAdsEditLog($subject)
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

        SuperadminLogActivityModel::create($log);
    }
    // end of ads

    // shop
    public static function SuperadminShopCreateLog($subject)
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
        SuperadminLogActivityModel::create($log);
    }

    public static function SuperadminShopEditLog($subject)
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
        SuperadminLogActivityModel::create($log);
    }

    public static function SuperadminShopDeleteLog($subject)
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
        SuperadminLogActivityModel::create($log);
    }
    // end of shop

    // admin
    public static function SuperadminAdminCreateLog($subject)
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
        SuperadminLogActivityModel::create($log);
    }

    public static function SuperadminAdminEditLog($subject)
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
        SuperadminLogActivityModel::create($log);
    }

    // end of admin

    public static function logActivityLists()
    {
        return LogActivityModel::latest()->get();
    }

}
