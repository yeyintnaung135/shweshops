<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Messages;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class SuperAdminMessage extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function show_all_expire(): View
    {
        return view('backend.super_admin.message.expire');
    }

    public function delete_by_one(Request $request): RedirectResponse
    {
        Messages::destroy($request->id);
        return redirect()->back();
    }

    //TODO Unfinished method, should be implemented later
    public function get_expire(Request $request): JsonResponse
    {
        $messages = Messages::with(['user:id,name', 'shop:id,shop_name'])
            ->select('id', 'message', 'created_at');

        return DataTables::of($messages)
            ->addColumn('checkbox', function ($record) {
                return $record->id;
            })
            ->addColumn('user_name', function ($record) {
                return $record->user ? $record->user->name : '-';
            })
            ->addColumn('shop_name', function ($record) {
                return $record->shop ? $record->shop->shop_name : '-';
            })
            ->addColumn('message', function ($record) {
                if (Str::contains($record->message, 'image')) {
                    return $record->message;
                } else {
                    return Str::limit($record->message, 50);
                }
            })
            ->addColumn('expired_in', function ($record) {
                $cd = Carbon::parse($record->message_created_at);
                $expiredMonth = Carbon::now()->subMinute();
                return $cd->diffForHumans($expiredMonth);
            })
            ->addColumn('action', function ($record) {
                return $record->id;
            })
            ->editColumn('created_at', fn($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->toJson();
    }
}
