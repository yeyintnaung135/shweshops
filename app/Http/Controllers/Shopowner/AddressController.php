<?php

namespace App\Http\Controllers\Shopowner;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:shop_owner');
    }
}


