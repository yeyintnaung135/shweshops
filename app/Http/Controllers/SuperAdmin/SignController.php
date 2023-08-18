<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\Sign\StoreSignRequest;
use App\Http\Requests\SuperAdmin\Sign\UpdateSignRequest;
use App\Models\Sign;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class SignController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function index(): View
    {
        //
        $signs = Sign::all();
        return view('backend.super_admin.sign.list', compact('signs'));
    }

    public function create(): View
    {
        //
        return view('backend.super_admin.sign.create');
    }

    public function store(StoreSignRequest $request): RedirectResponse
    {
        if ($request->hasFile('photo')) {
            $photo = $request->photo;
            $name = uniqid() . '_baydin' . '.' . $photo->getClientOriginalName();
            $photo->move(public_path() . '/images/baydin/', $name);
            $photo = $name;
        }

        if ($request->hasFile('sign_logo')) {
            $sign_logo = $request->sign_logo;
            $name = uniqid() . '_sign_logo' . '.' . $sign_logo->getClientOriginalName();
            $sign_logo->move(public_path() . '/images/baydin/sign', $name);
            $sign_logo = $name;
        }

        Sign::create([
            'name' => $request->name,
            'title' => $request->title,
            'description' => $request->description,
            'photo' => $photo,
            'sign_logo' => $sign_logo,
            'credit' => $request->credit,
        ]);
        return redirect()->route('baydins.index')->with('success', 'Your Sign is successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        //
        $sign = Sign::findOrFail($id);
        return view('backend.super_admin.sign.detail', compact('sign'));
    }

    public function edit($id): View
    {
        $sign = Sign::findOrFail($id);
        return view('backend.super_admin.sign.edit', compact('sign'));
    }

    public function update(UpdateSignRequest $request, $id): RedirectResponse
    {
        $update_sign = Sign::findOrFail($id);
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
        return redirect()->route('baydins.index')->with('success', 'Your Baydin is successfully Updated');
    }

    public function destroy($id): RedirectResponse
    {
        $delete_sign = Sign::findOrFail($id);
        $delete_sign->delete();
        return redirect()->route('baydins.index')->with('delete_baydin', 'Your Baydin is successfully Updated');
        //
    }

    public function delete_sign(Request $request): RedirectResponse
    {
        $delete_sign = Sign::find($request->sign_id);
        $delete_sign->delete();
        return response()->json("success");
    }
}
