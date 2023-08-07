<?php
   
namespace App\Http\Controllers;
   
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Shopowner;
use App\Http\Controllers\Controller;

class UpdatePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:shop_owner');
    }
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('updatePassword');
    } 
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        // return dd($request);
        $request->validate([
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        Shopowner::where('id', Auth::guard('shop_owner')->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        return redirect()->route('backside.shop_owner.detail');
    }
}