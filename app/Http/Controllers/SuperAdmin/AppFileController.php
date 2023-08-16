<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AppFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AppFileController extends Controller
{
    public function index(): View
    {
        $appFiles = AppFile::all();

        return view('backend.super_admin.app-files.index', ['appFiles' => $appFiles]);
    }

    public function create(): View
    {
        return view('backend.super_admin.app-files.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // dd($request->file('file')->getMimeType());

        $validatedData = $request->validate([
            'file' => 'required|mimes:zip,apk,ipa|max:40960', // Limit to web app files up to 40 MB.
            'user_type' => 'required|in:Shop User,Regular User',
            'operating_system' => 'required|in:Android,iOS',
        ]);

        $file = $request->file('file');
        $originalFilename = $file->getClientOriginalName();

        $existingFile = AppFile::where('user_type', $validatedData['user_type'])
            ->where('operating_system', $validatedData['operating_system'])
            ->first();

        if ($existingFile) {
            // If a file with the same user_type and operating_system exists, delete it
            Storage::delete('app_files/' . $existingFile->file);
            $existingFile->delete();
        }

        // if (AppFile::where('file', $originalFilename)->exists()) {
        //     return redirect()->back()->withErrors(['file' => 'The file already exists in the database.']);
        // } //custom validation for uploaded file

        $file->storeAs('app_files', $originalFilename);

        $appFile = AppFile::create([
            'file' => $originalFilename,
            'user_type' => $validatedData['user_type'],
            'operating_system' => $validatedData['operating_system'],
        ]);

        Session::flash('message', 'App file uploaded successfully.');

        return redirect()->route('backside.super_admin.app-files.index');
    }

    public function destroy(AppFile $appFile): RedirectResponse
    {
        $filePath = "app_files/" . $appFile->file;
        Storage::delete($filePath);
        $appFile->delete();

        Session::flash('message', 'App file deleted successfully.');

        return redirect()->route('backside.super_admin.app-files.index');
    }

    //TODO: if you are from future and 'edit' and 'update' still not being used, you should delete them.

    // public function edit(AppFile $appFile)
    // {
    //     return view('backend.super_admin.app-files.edit', ['appFile' => $appFile]);
    // }

    // public function update(Request $request, AppFile $appFile)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:zip,apk,ipa|max:40960', // Limit to web app files up to 40 MB.
    //     ]);

    //     Storage::delete($appFile->file);
    //     $file = $request->file('file');
    //     $originalFilename = $file->getClientOriginalName();
    //     $file->storeAs('files', $originalFilename);
    //     $appFile->file = $originalFilename;
    //     $appFile->save();

    //     Session::flash('message', 'App file updated successfully.');

    //     return redirect()->route('backside.super_admin.app-files.index');
    // }
}
