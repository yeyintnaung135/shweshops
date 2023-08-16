<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Messages;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class SuperAdminMessage extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin', 'admin']);
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

    public function get_expire(Request $request): mixed
    {
        if ($request->ajax()) {
            $query = Messages::leftJoin('users', 'users.id', '=', 'message_user_id')
                ->leftJoin('shop_owners', 'shop_owners.id', '=', 'message_shop_id')
                ->where('messages.created_at', '<', Carbon::now()->subMinute())
                ->select([
                    'messages.id as mid',
                    'users.username as user_name',
                    'shop_owners.shop_name as shop_name',
                    'messages.message',
                    DB::raw("CASE WHEN CHAR_LENGTH(messages.message) > 50 THEN CONCAT(LEFT(messages.message, 50), '...') ELSE messages.message END as truncated_message"),
                    DB::raw("CONCAT('message_created_at') as message_created_at"),
                ])->orderBy('messages.created_at', 'desc');

            return DataTables::of($query)
                ->addColumn('checkbox', function ($record) {
                    return $record->mid;
                })
                ->addColumn('action', function ($record) {
                    return $record->mid;
                })
                ->editColumn('expired_in', function ($record) {
                    $cd = Carbon::parse($record->message_created_at);
                    $expiredMonth = Carbon::now()->subMinute();
                    $diff = $cd->diffForHumans($expiredMonth);
                    return $diff;
                })
                ->editColumn('message_created_at', function ($record) {
                    return date('F d, Y ( h:i A )', strtotime($record->message_created_at));
                })
                ->make(true);
        }
    }
}
