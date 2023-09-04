<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\Customer\PointUpdateRequest;
use App\Models\GoldPoint;
use App\Models\ItemLogActivity;
use App\Models\Point;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function index(): View
    {
        $itemlogs = ItemLogActivity::whereBetween('created_at', [Carbon::now()->submonth(), Carbon::now()]);
        return view('backend.super_admin.customer.list', ['itemlogs' => $itemlogs]);
    }

    public function activity_index(): View
    {

        return view('backend.super_admin.activity_logs.customer');
    }

    public function get_customers(Request $request): JsonResponse
    {
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        $recordsQuery = User::select(
            'id',
            'username',
            'phone',
            'gender',
            'birthday',
            'active',
            'created_at')
            ->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn($query) => $query->whereDate('created_at', '<=', $searchByTodate));
        return DataTables::of($recordsQuery)
            ->editColumn('created_at', fn($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->make(true);
    }

    //WARNING Code has not been used
    public function get_customer_activity(Request $request): JsonResponse
    {
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        $recordsQuery = ItemLogActivity::select('id', 'user_name', 'item_code', 'user_id', 'created_at')
            ->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::of($recordsQuery)
            ->editColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->created_at));
            })
            ->make(true);
    }

    public function point(): View
    {
        $register_points = Point::where('status', 'Register')->first();
        $whislist_points = Point::where('status', 'Whislist')->first();
        $add_to_cart_points = Point::where('status', 'AddToCart')->first();
        $buynow_points = Point::where('status', 'Buynow')->first();
        $daily_points = Point::where('status', 'Daily Login')->first();
        $profile_edit = Point::where('status', 'Profile Edit')->first();
        $phone_number = Point::where('status', 'Phone Number Edit')->first();
        $birthdate = Point::where('status', 'Birth Date Edit')->first();
        $address = Point::where('status', 'Address Edit')->first();
        $username = Point::where('status', 'User Name Edit')->first();

        return view('backend.super_admin.point', [
            "register" => $register_points,
            "whislist" => $whislist_points,
            'addtocart' => $add_to_cart_points,
            "buynow" => $buynow_points,
            "daily" => $daily_points,
            "profile" => $profile_edit,
            "phone" => $phone_number,
            "birthdate" => $birthdate,
            "address" => $address,
            "username" => $username,
        ]);
    }
    public function point_update(PointUpdateRequest $request): RedirectResponse
    {
        Point::where('status', $request->register)->update([
            'count' => $request->count1,
        ]);
        Point::where('status', $request->daily)->update([
            'count' => $request->count2,
        ]);
        Point::where('status', $request->whislist)->update([
            'count' => $request->count3,
        ]);
        Point::where('status', $request->buynow)->update([
            'count' => $request->count4,
        ]);
        Point::where('status', $request->addtocart)->update([
            'count' => $request->count5,
        ]);
        Point::where('status', $request->profile)->update([
            'count' => $request->count10,
        ]);
        Point::where('status', $request->username)->update([
            'count' => $request->count9,
        ]);
        Point::where('status', $request->phone)->update([
            'count' => $request->count6,
        ]);
        Point::where('status', $request->birthdate)->update([
            'count' => $request->count7,
        ]);
        Point::where('status', $request->address)->update([
            'count' => $request->count8,
        ]);

        return redirect()->back();
    }

    /** Gold Point */

    public function gold_point(): View
    {
        return view('backend.super_admin.point_system.gold_points_create');
    }

    public function gold_point_store(Request $request): RedirectResponse
    {
        $request->validate([
            'status' => 'required|numeric|unique:gold_points,status',
            'counts' => 'required|numeric',
        ]);
        $gold_points = new GoldPoint();
        $gold_points->status = $request->status;
        $gold_points->counts = $request->counts;

        return redirect()->back();
    }

    public function gold_point_edit($id): View
    {
        $gold_point = GoldPoint::findOrFail($id);
        $gold_points = GoldPoint::latest()->paginate(5);
        return view('backend.super_admin.point_system.gold_points_edit', compact('gold_point', 'gold_points'));
    }

    public function gold_point_update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'status' => 'required|numeric|unique:gold_points,status,' . $id, // Rule::unique('gold_points', 'status')->ignore($this->status),
            'counts' => 'required|numeric',
        ]);

        $gold_point = GoldPoint::findOrFail($id);
        $gold_point->status = $request->status;
        $gold_point->counts = $gold_point->counts;
        $gold_point->save();
        return redirect()->route('gold_point');
    }
}
