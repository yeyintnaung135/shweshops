<?php
namespace App\Models;

use Illuminate\Support\Facades\Auth;

class Gate
{
    public function allows($x = null, $y = null)
    {
        if ($x) {
            if (Auth::guard('shop_owner')->check()) {
                return true;
            } else {
                if (Auth::user()->role_id == 2) {
                    if (!empty($y)) {
                        if ($y == 3) {
                            return true;
                        } else {
                            return abort(401);
                        }
                    } else {
                        return true;
                    }

                } elseif (Auth::user()->role_id == 1) {
                    if (!empty($y)) {
                        if ($y != 1) {
                            return true;
                        } else {
                            return abort(401);
                        }
                    } else {
                        return true;
                    }
                } elseif (Auth::user()->role_id == 3) {

                    if (!empty($y)) {
                        return abort(401);
                    } else {
                        return true;
                    }

                } else {
                    return abort(401);
                }
            }

            return true;

        } else {
            return abort(401);
        }
    }

    public function super_admin_allows($x = null, $y = null)
    {
        $auth_id = Auth::guard('super_admin')->user()->id;
        if ($x == $auth_id) {
            return true;
        } else {
            return abort(401);
        }
    }
}
