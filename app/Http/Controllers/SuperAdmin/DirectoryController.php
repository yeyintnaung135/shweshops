<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\YKImage;
use App\Http\Requests\SuperAdmin\Directory\StoreDirectoryRequest;
use App\Http\Requests\SuperAdmin\Directory\UpdateDirectoryRequest;
use App\Models\ShopDirectory;
use App\Models\State;
use App\Models\Tooltips;
use App\Models\Township;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class DirectoryController extends Controller
{
    use YKImage;

    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function all_table(): View
    {
        return view('backend.super_admin.directory.list');
    }

    public function all_directory(Request $request): JsonResponse
    {
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        $totalRecordsQuery = ShopDirectory::select('id', 'shop_name', 'shop_logo', 'main_phone', 'created_at')
            ->where('shop_id', '0')
            ->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::of($totalRecordsQuery)
            ->editColumn('created_at', fn($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->addColumn('action', function ($record) {
                return $record->id;
            })
            ->make(true);
    }

    public function get_township(Request $request): JsonResponse
    {
        if (is_array($request->id)) {
            $townships = Township::select('id', 'name', 'myan_name')->whereIn('state_id', $request->id)->get();
        } else {
            $townships = Township::select('id', 'name', 'myan_name')->where('state_id', $request->id)->get();
        }
        return response()->json($townships);
    }

    public function check_shop_directory_name(Request $request): JsonResponse
    {
        if (ShopDirectory::where('shop_name', '=', $request->shopName)->exists()) {
            $isExit = true;
        } else {
            $isExit = false;
        }
        return response()->json([
            'isExit' => $isExit,
        ]);
    }

    public function create_form(): View
    {
        $states = State::get();
        return view('backend.super_admin.directory.create', ['states' => $states]);
    }

    public function store(StoreDirectoryRequest $request): RedirectResponse
    {
        // dd($request);
        $data = $request->validated();
        if ($request->hasFile('shop_logo')) {
            $shop_logo = $data['shop_logo'];

            //file upload
            $imageNameone = time() . 'logo' . '.' . $shop_logo->getClientOriginalExtension();

            $this->save_image_shop_logo($shop_logo, $imageNameone, 'directory/');

            $data['shop_logo'] = $imageNameone;

        }
        $add_ph = json_decode($request->additional_phones);
        $add_ph_array = [];

        if (json_decode($request->additional_phones) !== null) {
            foreach ($add_ph as $k => $v) {
                if (count($add_ph) != 0) {
                    $ph = json_decode(json_encode($v), true);
                    foreach ($ph as $k2 => $v2) {
                        array_push($add_ph_array, $v2);
                    }
                }
            }
        }
        // $state = json_decode($request->state);
        // $state_array = [];
        // if(json_decode($request->state)!== null){
        //   foreach($state as $k=>$v){
        //     if(count($state) != 0){
        //       $st = json_decode(json_encode($v), true);
        //       foreach ($st as $k2=>$v2) {
        //         array_push($state_array,$v2);
        //       }
        //     }
        //   }
        // }

        $data['additional_phones'] = json_encode($add_ph_array);
        ShopDirectory::create($data);
        Session::flash('message', 'Your Shop Directory was successfully Created');

        return redirect('backside/super_admin/directory/all');
    }
    public function detail($id): View
    {
        $ttdata = ShopDirectory::where('id', $id)->first();
        return view('backend.super_admin.directory.detail', ['ttdata' => $ttdata]);

    }
    public function edit_form($id): View
    {
        $states = State::get();
        $ttdata = ShopDirectory::where('id', $id)->first();
        return view('backend.super_admin.directory.edit', ['ttdata' => $ttdata, 'states' => $states]);

    }
    public function update(UpdateDirectoryRequest $request): RedirectResponse
    {
        $sd = ShopDirectory::where('id', $request->id)->first();
        $data = $request->validated();

        if ($request->file('shop_logo')) {

            if (File::exists(public_path('image/directory/' . $sd->shop_logo))) {
                File::delete(public_path('image/directory/' . $sd->shop_logo));
            }

            $shop_logo = time() . '1.' . $request->file('shop_logo')->getClientOriginalExtension();
            $this->save_image_shop_logo($request->file('shop_logo'), $shop_logo, 'directory/');

            $data['shop_logo'] = $shop_logo;

        }
        $add_ph = json_decode($request->additional_phones);
        $add_ph_array = [];

        if (json_decode($request->additional_phones) !== null) {
            foreach ($add_ph as $k => $v) {
                if (count($add_ph) != 0) {
                    $ph = json_decode(json_encode($v), true);
                    foreach ($ph as $k2 => $v2) {
                        array_push($add_ph_array, $v2);
                    }
                }
            }
        }
        $data['additional_phones'] = json_encode($add_ph_array);
        ShopDirectory::where('id', $request->id)->update($data);

        Session::flash('message', 'Your Shop Directory was successfully Edited');

        return redirect('backside/super_admin/directory/all');

    }
    public function delete(Request $request): RedirectResponse
    {
        $sd = ShopDirectory::where('id', $request->id)->first();

        if (File::exists(public_path('image/directory/' . $sd->shop_logo))) {
            File::delete(public_path('image/directory/' . $sd->shop_logo));
        }

        ShopDirectory::where('id', $request->id)->delete();
        Session::flash('message', 'Your Shop Directory was successfully deleted');

        return redirect('backside/super_admin/directory/all');

    }
    public function list(): View
    {
        $alltt = Tooltips::all();
        return view('backend.super_admin.tooltips.list', ['alltt' => $alltt]);
    }

    public function all(): mixed
    {
        $recordsQuery = Tooltips::select('*')->orderBy('created_at', 'desc');

        return DataTables::of($recordsQuery)
            ->addColumn('url', function ($record) {
                return $record->name;
            })
            ->addColumn('info', function ($record) {
                return $record->email;
            })
            ->addColumn('created_at', function ($record) {
                return $record->created_at;
            })
            ->addColumn('action', function ($record) {
                return $record->id;
            })
            ->make(true);
    }
}
