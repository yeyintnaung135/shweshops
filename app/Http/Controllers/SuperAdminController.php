<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:super_admin');
    }
    public function index(){
        return view('backend.super_admin.dashboard');
    }
}
