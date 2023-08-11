<?php

namespace App\Http\Controllers\ShopOwner;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:shop_owner');
    }
}


