<?php

namespace App\Http\Controllers\users;

use App\User;
use App\Point;
use App\UserPoint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:web','web']);
    }
    public function index(){
    $user_id = Auth::guard('web')->id();
    $user = User::findOrFail($user_id);
        return view('backend.user.information',compact('user'));
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $user_name = Point::where('id',10)->first();
        $birth_day = Point::where('id',8)->first();
        $address = Point::where('id',9)->first();
        $photo = Point::where('id',6)->first();
        $user_point_name = UserPoint::where('user_id',$id)
        ->where('point_id',10)
        ->get();
        $user_point_birth = UserPoint::where('user_id',$id)
        ->where('point_id',8)
        ->get();
        $user_point_address = UserPoint::where('user_id',$id)
        ->where('point_id',9)
        ->get();
        $user_point_profile= UserPoint::where('user_id',$id)
        ->where('point_id',6)
        ->get();
        return view('backend.user.profile_edit',[
            'user' => $user,
            'user_name' => $user_name,
            'point_name' => $user_point_name,
            'birth' => $birth_day,
            'point_birth' => $user_point_birth,
            'address' => $address,
            'point_address'=> $user_point_address,
            'photo' => $photo,
            'point_profile' => $user_point_profile,
            
        ]);
    }
    
    public function update(Request $request,$id)
    {
        
        $user = User::findOrFail($id);
        $username_point_id = UserPoint::where('point_id',10)->count();
        $phone_point_id = UserPoint::where('point_id',7)->count();
        $profile_point_id = UserPoint::where('point_id',6)->count();
        $birthdate_point_id = UserPoint::where('point_id',8)->count();
        $address_point_id = UserPoint::where('point_id',9)->count();
        if($user->username != $request->username && $username_point_id === 0){
            $user_point = new UserPoint();
            $user_point->user_id = Auth::guard('web')->id();
            $user_point->point_id = 10;
            $user_point->save();
        }
        if($user->phone != $request->phone && $phone_point_id === 0){
            $user_point = new UserPoint();
            $user_point->user_id = Auth::guard('web')->id();
            $user_point->point_id = 7;
            $user_point->save();
        }
        if($user->birthday != $request->birth && $birthdate_point_id === 0){
            $user_point = new UserPoint();
            $user_point->user_id = Auth::guard('web')->id();
            $user_point->point_id = 8;
            $user_point->save();
        }
        if($user->address != $request->address && $address_point_id === 0){
            $user_point = new UserPoint();
            $user_point->user_id = Auth::guard('web')->id();
            $user_point->point_id = 9;
            $user_point->save();
        }
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->birthday = $request->birth;
        $user->address = $request->address;
        if($request->birth){
            $user->send_baydin = "0";
        }
        
        if($request->file('photo')){
            if($profile_point_id === 0 ){
                 
              $user_point = new UserPoint();
              $user_point->user_id = Auth::guard('web')->id();
              $user_point->point_id = 6;
              $user_point->save();
            }
            $img = $request->photo;
            $imageNameone = time().'userprofile'.'.'.$img->getClientOriginalExtension();
             if (File::exists(public_path($user->photo))) {
                 File::delete(public_path($user->photo));
               
             }
             $img->move(public_path('images/user-profile/profile_photo/'),$imageNameone);
              $user->photo = 'images/user-profile/profile_photo/'.$imageNameone;
             
            
        }
        
        $user->save();
        return redirect('user/profile')->with('success','Profile updated successfully');
    }

    public function birthday_update(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->birthday = $request->birth;
        if($request->birth){
            $user->send_baydin = "0";
        }
        $result = $user->update();
        return redirect('/baydin')->with('success','Profile updated successfully');
    }
    
    public function whislist_point(Request $request)
    {
        $product_id = UserPoint::where('user_id',Auth::guard('web')->id())
        ->where('product_id',$request->p_id)
         ->where('point_id',2)
        ->get();
        if(count($product_id) == 0){
            $user_point = new UserPoint();
            $user_point->user_id = Auth::guard('web')->id();
            $user_point->point_id = 2;
            $user_point->product_id = $request->p_id;
            $user_point->save();
        }
     
        return response()->json([
            'data'=> $request->p_id,
        ]);
    }
    
    public function buy_now_point(Request $request)
    {
        $product_id = UserPoint::where('user_id',Auth::guard('web')->id())
        ->where('product_id',$request->m_id)
        ->where('point_id',3)
        ->get();
        if(count($product_id) == 0){
            $user_point = new UserPoint();
            $user_point->user_id = Auth::guard('web')->id();
            $user_point->point_id = 3;
            $user_point->product_id = $request->m_id;
            $user_point->save();
        }
     
        return response()->json([
            'data'=> $request->m_id,
        ]);
    }
    
    public function add_to_cart_point(Request $request)
    {
        $product_id = UserPoint::where('user_id',Auth::guard('web')->id())
        ->where('product_id',$request->add_id)
        ->where('point_id',5)
        ->get();
        if(count($product_id) == 0){
            $user_point = new UserPoint();
            $user_point->user_id = Auth::guard('web')->id();
            $user_point->point_id = 5;
            $user_point->product_id = $request->add_id;
            $user_point->save();
        }
     
        return response()->json([
            'data'=> $request->add_id,
        ]);
    }
    
    public function logout()
    {
        if(Auth::guard('web')->check()){
             Auth::guard('web')->logout();
        }
        
        return redirect('/');
    }
}


