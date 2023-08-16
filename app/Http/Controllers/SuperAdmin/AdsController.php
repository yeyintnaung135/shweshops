<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Facade\Repair;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\Ads\StoreAdsImageRequest;
use App\Http\Requests\SuperAdmin\Ads\StoreAdsVideoFormRequest;
use App\Http\Requests\SuperAdmin\Ads\UpdateAdsImageRequest;
use App\Models\Ads;
use App\Models\Shops;
use App\Models\SuperAdminLogActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class AdsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function index(): View
    {
        $now = Carbon::now()->format('Y-m-d H:i:s A');
        Ads::where('end', '<=', $now)->delete();
        $ads = Ads::withTrashed()->get();
        // $ads_role = SuperAdminLogActivity::where('type',['ads'])->orderBy('created_at', 'desc')->get();
        return view('backend.super_admin.ad.all', ['ads' => $ads]);
    }
    public function activity_index(): View
    {
        $now = Carbon::now()->format('Y-m-d H:i:s A');
        Ads::where('end', '<=', $now)->delete();
        $ads = Ads::withTrashed()->get();
        $ads_role = SuperAdminLogActivity::where('type', 'ads')->orderBy('created_at', 'desc')->get();
        return view('backend.super_admin.activity_logs.ads', ['ads' => $ads, 'ads_role' => $ads_role]);
    }

    // datable for ads log activity
    public function get_ads_activity(Request $request): mixed
    {
        if ($request->ajax()) {
            $searchByFromdate = $request->input('searchByFromdate') ?? '0-0-0 00:00:00';
            $searchByTodate = $request->input('searchByTodate') ?? Carbon::now();

            $recordsQuery = SuperAdminLogActivity::where('type', 'ads')
                ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
                ->orderBy('created_at', 'desc');

            return DataTables::of($recordsQuery)
                ->addColumn('created_at_formatted', function ($record) {
                    return date('F d, Y ( h:i A )', strtotime($record->created_at));
                })
                ->editColumn('created_at', '{{ date("F d, Y ( h:i A )", strtotime($created_at)) }}')
                ->rawColumns(['created_at_formatted'])
                ->toJson();
        }
    }

    public function get_all_ads(Request $request): mixed
    {
        $searchByFromdate = $request->input('searchByFromdate') ?? '0-0-0 00:00:00';
        $searchByTodate = $request->input('searchByTodate') ?? Carbon::now();

        $recordsQuery = Ads::select('ads.*')
            ->withTrashed()
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->orderBy('created_at', 'desc');

        return DataTables::of($recordsQuery)
            ->addColumn('start', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->start));
            })
            ->addColumn('end', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->end));
            })
            ->addColumn('deleted_at', function ($record) {
                return $record->deleted_at ? '<span class="text-danger">' . $record->deleted_at->diffForHumans() . '</span>' : '';
            })
            ->addColumn('action', function ($record) {
                return '<a href="' . route('edit_route', $record->id) . '">Edit</a>';
                // Add more action links as needed
            })
            ->rawColumns(['deleted_at', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $shops = Shops::all();
        return view('backend.super_admin.ad.create', ['shops' => $shops]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdsImageRequest $request): JsonResponse
    {

        $folderPath = 'images/banner/';
        $mobileimgfolder = 'images/banner/thumbs/';
        $shop_name = Shops::where('id', $request->shop_id)->first();
        $start = Carbon::parse($request->start, 'UTC')->format('Y-m-d H:i:s A');
        $end = Carbon::parse($request->end, 'UTC')->format('Y-m-d H:i:s A');
        $ads = new Ads();
        if (!empty($shop_name)) {
            $ads->name = $shop_name->shop_name;

        } else {
            $ads->name = 'No Shop';
        }
        $ads->shop_id = $request->shop_id;
        $ads->image = Repair::fileStore($request->file('photo'), $folderPath);
        $ads->image_for_mobile = Repair::fileStore($request->file('image_for_mobile'), $mobileimgfolder);

        $ads->start = $start;
        $ads->links = $request->links;

        $ads->end = $end;
        $ads->save();

        \SuperAdminLogActivity::SuperAdminAdsCreateLog($ads);

        return response()->json([
            'success' => true,
            'message' => "Ads Created Successfully",
        ]);

    }

    public function store_video(StoreAdsVideoFormRequest $request): RedirectResponse
    {
        $folderPath = 'images/banner';
        $mobileimgfolder = 'images/banner/thumbs/';

        $shop_name = Shops::where('id', $request->shop_id)->first();

        $start = Carbon::parse($request->start, 'UTC')->format('Y-m-d H:i:s A');
        $end = Carbon::parse($request->end, 'UTC')->format('Y-m-d H:i:s A');
        $ads = new Ads();
        if (!empty($shop_name)) {
            $ads->name = $shop_name->shop_name;

        } else {
            $ads->name = 'No Shop';
        }
        $ads->shop_id = $request->shop_id;
        $ads->image = Repair::fileStore($request->file('video'), $folderPath);
        $ads->image_for_mobile = Repair::fileStore($request->file('image_for_mobile'), $mobileimgfolder);

        $ads->start = $start;
        $ads->links = $request->links;
        $ads->end = $end;
        $ads->save();

        \SuperAdminLogActivity::SuperAdminAdsCreateLog($ads);

        Session::flash('message', 'Your ads was successfully created');

        return redirect('/backside/super_admin/ads');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $ad = Ads::withTrashed()->findOrFail($id);
        $shop = Shops::where('shop_name', $ad->name)->first();

        if (empty($shop)) {
            $shop_name_myan = 'No Shop';
        } else {
            $shop_name_myan = $shop->shop_name_myan;
        }

        $end_date = $ad->end;
        $today = Carbon::now();

        if ($ad->deleted_at == null) {
            $day = $end_date->diffInDays($today);
            $hour = $end_date->diffInHours($today);
            $minutes = $end_date->diffInMinutes($today);
        } else {
            $day = null;
            $hour = null;
            $minutes = null;
        }

        return view('backend.super_admin.ad.detail', [
            'ad' => $ad,
            'shop_name_myan' => $shop_name_myan,
            'id' => $id,
            'day' => $day,
            'hour' => $hour,
            'minutes' => $minutes,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $ad = Ads::withTrashed()->findOrFail($id);
        $shops = Shops::all();
        return view('backend.super_admin.ad.edit', ['shops' => $shops, 'ad' => $ad]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdsImageRequest $request, $id): RedirectResponse
    {
//        return $request->shop_id;
        $shop_name = Shops::where('id', $request->shop_id)->first();
        $folderPath = 'images/banner/';
        $ads = Ads::withTrashed()->findOrfail($id);
        if (!empty($shop_name)) {
            $ads->name = $shop_name->shop_name;

        } else {
            $ads->name = 'No Shop';
        }$ads->shop_id = $request->shop_id;
        if ($request->start) {
            $ads->start = Carbon::createFromFormat('d-m-Y h:i A', $request->start)->format('Y-m-d H:i:s A');
        }
        if ($request->end) {
            $ads->end = Carbon::createFromFormat('d-m-Y h:i A', $request->end)->format('Y-m-d H:i:s A');
        }
        if ($request->image) {
            $ads->image = Repair::fileStore($request->file('image'), $folderPath);
        }
        if ($request->image_for_mobile) {
            $mobileimgfolder = 'images/banner/thumbs/';

            $ads->image_for_mobile = Repair::fileStore($request->file('image_for_mobile'), $mobileimgfolder);
        }
        $ads->links = $request->links;

        $ads->save();
        \SuperAdminLogActivity::SuperAdminAdsEditLog($ads);

        $ads = Ads::withTrashed()->findOrfail($id)->restore();
        Session::flash('message', 'Your ads was successfully updated');
        return redirect('/backside/super_admin/ads');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {

        $ad = Ads::withTrashed()->findOrFail($id);
        \SuperAdminLogActivity::SuperAdminAdsDeleteLog($ad);

        if (File::exists(public_path('images/banner/' . $ad->image))) {
            File::delete(public_path('/images/banner/' . $ad->name));
        }

        if ($ad->deleted_at) {
            Ads::onlyTrashed()->findOrFail($id)->forceDelete();
        } else {
            $ad->delete();
        }
        Session::flash('message', 'Your ads was successfully deleted');

        return redirect()->route('backside.super_admin.ads.index');
    }
}
