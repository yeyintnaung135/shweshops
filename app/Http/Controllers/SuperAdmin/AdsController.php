<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Support\Facades\Storage;

use App\Facade\Repair;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\YKImage;
use App\Http\Controllers\Trait\Logs\SuperAdminLogActivityTrait;
use App\Http\Requests\SuperAdmin\Ads\StoreAdsImageRequest;
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
use Illuminate\Support\Str;

class AdsController extends Controller
{
    use YKImage;
    use SuperAdminLogActivityTrait;

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
    public function get_ads_activity(Request $request): JsonResponse
    {
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        $recordsQuery = SuperAdminLogActivity::select('id', 'name', 'type', 'type_name', 'status', 'created_at', 'role')
            ->where('type', 'ads')
            ->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::of($recordsQuery)
            ->editColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->created_at));
            })
            ->toJson();

    }

    public function get_all_ads(Request $request): JsonResponse
    {
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        $recordsQuery = Ads::select('id', 'name', 'image', 'start', 'end', 'created_at', 'deleted_at', 'video')
            ->withTrashed()
            ->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::of($recordsQuery)
            ->editColumn('start', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->start));
            })
            ->editColumn('end', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->end));
            })
            ->editColumn('deleted_at', function ($record) {
                return $record->deleted_at ? '<span class="text-danger">' . $record->deleted_at->diffForHumans() . '</span>' : '';
            })
            ->editColumn('created_at', function ($record) {
                return date('F d, Y ( h:i A )', strtotime($record->created_at));
            })
            ->addColumn('action', fn ($record) => $record->id)
            ->rawColumns(['deleted_at'])
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


    public function store_video(StoreAdsImageRequest $request): mixed
    {


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
        $statictimestamp = Carbon::now()->timestamp;
        $file = $request->file('photo');

        $imageName = strtolower($statictimestamp . '_' . Str::random(4) . '.' . $file->getClientOriginalExtension());
        $this->save_image($file, $imageName, 'ads/');

        $mobilefile = $request->file('image_for_mobile');
        $mobileimageName = strtolower($statictimestamp . '_' . Str::random(4) . '.' . $mobilefile->getClientOriginalExtension());
        $this->save_image($file, $mobileimageName, 'ads/thumbs/');

        $ads->image = $imageName;
        $ads->image_for_mobile = $mobileimageName;

        $ads->start = $start;
        $ads->links = $request->links;
        $ads->end = $end;
        $ads->save();

        $this->SuperAdminAdsCreateLog($ads);

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
        $statictimestamp = Carbon::now()->timestamp;
        if (!empty($shop_name)) {
            $ads->name = $shop_name->shop_name;
        } else {
            $ads->name = 'No Shop';
        }
        $ads->shop_id = $request->shop_id;
        if ($request->start) {
            $ads->start = Carbon::createFromFormat('d-m-Y h:i A', $request->start)->format('Y-m-d H:i:s A');
        }
        if ($request->end) {
            $ads->end = Carbon::createFromFormat('d-m-Y h:i A', $request->end)->format('Y-m-d H:i:s A');
        }
        if ($request->file('photo')) {
            if (env('USE_DO') == 'true') {
                Storage::disk('digitalocean')->delete('/prod/ads/' . $ads->image);
            } else {
                Storage::disk('public_image')->delete('/ads/' . $ads->image);
            }


            $file = $request->file('photo');


            $imageName = strtolower($statictimestamp . '_' . Str::random(4) . '.' . $file->getClientOriginalExtension());

            $this->save_image($file, $imageName, 'ads/');

            $ads->image =  $imageName;
        }
        if ($request->file('image_for_mobile')) {
            if (env('USE_DO') == 'true') {
                Storage::disk('digitalocean')->delete('/prod/ads/thumbs/' . $ads->image_for_mobile);
            } else {
                Storage::disk('public_image')->delete('/ads/thumbs/' . $ads->image_for_mobile);
            }
            $mobilefile = $request->file('image_for_mobile');
            $mobileimageName = strtolower($statictimestamp . '_' . Str::random(4) . '.' . $mobilefile->getClientOriginalExtension());
            $this->save_image($mobilefile, $mobileimageName, 'ads/thumbs/');

            $ads->image_for_mobile = $mobileimageName;
        }
        $ads->links = $request->links;

        $ads->save();
        $this->SuperAdminAdsEditLog($ads);

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
        $this->SuperAdminAdsDeleteLog($ad);
        $this->delete_image('ads/' . $ad->image,'ads/' . $ad->image_for_mobile);
     
        if ($ad->deleted_at) {
            Ads::onlyTrashed()->findOrFail($id)->forceDelete();
        } else {
            $ad->delete();
        }
        Session::flash('message', 'Your ads was successfully deleted');

        return redirect()->route('backside.super_admin.ads.index');
    }
}
