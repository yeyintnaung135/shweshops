<?php

namespace App\Policies;

use App\Models\ShopOwnersAndStaffs;
use App\Http\Controllers\Trait\UserRole;
use Illuminate\Auth\Access\Response;


class ShopOwnersAndStaffsPolicy
{
    use UserRole;


    public function create(ShopOwnersAndStaffs $ShopOwnersAndStaffs, $requestrole_to_create = 'empty'): Response
    {
        $tmppermission = false;
        if ($this->is_owner()) {
            $tmppermission = in_array($requestrole_to_create, [1, 3]);
        }
        if ($this->is_admin()) {
            $tmppermission = in_array($requestrole_to_create, [2, 3]);
        }
        if ($this->is_manager()) {
            $tmppermission = in_array($requestrole_to_create, [3]);
        }
        if (!$this->is_staff() && $tmppermission) {
            return Response::allow();
        } else {
            return Response::deny();
        }
    }
}
