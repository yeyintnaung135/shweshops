<?php

namespace App\Http\Controllers\super_admin;

use App\Sign;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class SignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(['auth:super_admin','admin']);
    }

    public function index()
    {
        //
        $signs = Sign::all();
        return view('backend.super_admin.sign.list',compact('signs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.super_admin.sign.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'title' => 'required',
            'description' => 'required',
            'photo' => 'required',
            'sign_logo' => 'required',
            'credit' => 'required'
        ]);
        if($validator->fails()){
            return redirect('baydins/create')->withErrors($validator)->withInput();
        }
        // return dd($request);
        if($request->hasfile('photo'))
        {
          // dd("okok");
          $photo = $request->photo;
          $name = uniqid().'_baydin'.'.'.$photo->getClientOriginalName();
          $photo->move(public_path() . '/images/baydin/', $name);
          $photo = $name;
          
        }

        if($request->hasfile('sign_logo'))
        {
          // dd("okok");
          $sign_logo = $request->sign_logo;
          $name = uniqid().'_sign_logo'.'.'.$sign_logo->getClientOriginalName();
          $sign_logo->move(public_path() . '/images/baydin/sign', $name);
          $sign_logo = $name;
          
        }
       
        Sign::create([
            'name' => $request->name,
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $photo,
            'sign_logo' => $sign_logo,
            'credit' => $request->credit
        ]);
        return redirect()->route('baydins.index')->with('success','Your Sign is successfully Created');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $sign = Sign::findOrFail($id);
        return view('backend.super_admin.sign.detail',compact('sign'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $sign = Sign::findOrFail($id);
        return view('backend.super_admin.sign.edit',compact('sign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatevalidator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required','string'],
            'credit' => ['required','string', 'max:255'],
            'title' => ['required','string', 'max:255'],
            // 'photo' => ['required', 'string', 'max:50'],
        ]);
    }

    public function update(Request $request, $id)
    {
        //
        $valid=$this->updatevalidator($request->except('_token'));
        if( $valid->fails())
        {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $update_sign = Sign::findOrFail($id);
        // dd($request->all());

        // dd($photo);

        $update_sign->name = $request->name;
        $update_sign->description = $request->description;
        $update_sign->title = $request->title;
        $update_sign->credit = $request->credit;

        if ($request->file('photo')) {

            if (File::exists(public_path($update_sign->photo))) {
                File::delete(public_path($update_sign->photo));
            }

            $photo = time() . '1.' . $request->file('photo')->getClientOriginalExtension();
            $get_path = $request->file('photo')->move(public_path('/images/baydin/'), $photo);
             $update_sign->photo = $photo;

        }
        if ($request->file('sign_logo')) {

            if (File::exists(public_path($update_sign->sign_logo))) {
                File::delete(public_path($update_sign->sign_logo));
            }

            $sign_logo = time() . '1.' . $request->file('sign_logo')->getClientOriginalExtension();
            $get_path = $request->file('sign_logo')->move(public_path('/images/baydin/sign'), $sign_logo);
             $update_sign->sign_logo = $sign_logo;

        }
       $result = $update_sign->update();
        return redirect()->route('baydins.index')->with('success','Your Baydin is successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_sign = Sign::findOrFail($id);
        $delete_sign->delete();
        return redirect()->route('baydins.index')->with('delete_baydin','Your Baydin is successfully Updated');
        //
    }

    public function delete_sign(Request $request)
    {
        $delete_sign = Sign::find($request->sign_id);
        $delete_sign->delete();
        return response()->json("success");
        //
    }
}
