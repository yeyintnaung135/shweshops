<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tooltips;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class TooltipsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }

    public function create_form(): View
    {
        return view('backend.super_admin.tooltips.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'endpoint' => ['required', 'string', 'max:222'],
            'info' => ['required', 'string', 'max:22222'],
        ]);
        Tooltips::create($request->except('_token'));
        Session::flash('message', 'Your Tooltips was successfully Created');

        return redirect('backside/super_admin/tooltips/list');
    }

    public function detail($id): View
    {
        $ttdata = Tooltips::where('id', $id)->first();
        return view('backend.super_admin.tooltips.detail', ['ttdata' => $ttdata]);
    }

    public function delete($id): RedirectResponse
    {
        Tooltips::findOrFail($id)->delete();

        Session::flash('message', 'Your Tooltips was successfully deleted');

        return redirect('backside/super_admin/tooltips/list');
    }

    function list(): View {
        $alltt = Tooltips::all();
        return view('backend.super_admin.tooltips.list', ['alltt' => $alltt]);
    }

    public function all(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = Tooltips::query();

            $searchValue = $request->input('search.value');

            $data->where('endpoint', 'like', '%' . $searchValue . '%')
                ->orWhere('info', 'like', '%' . $searchValue . '%');

            $totalRecords = $data->count();
            $totalRecordswithFilter = $totalRecords;

            $orderColumnIndex = $request->input('order.0.column');
            $orderDirection = $request->input('order.0.dir');

            $orderColumn = $orderColumnIndex == 1 ? 'endpoint' : $request->input('columns.' . $orderColumnIndex . '.data');

            $data->orderBy($orderColumn, $orderDirection)
                ->orderBy('created_at', 'desc')
                ->skip($request->input('start'))
                ->take($request->input('length'));

            return DataTables::of($data)
                ->addColumn('action', function ($record) {
                    return '<a href="#">Edit</a>'; // Add your action link here
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function edit($id): View
    {
        $tooltip = Tooltips::findOrFail($id);
        return view('backend.super_admin.tooltips.edit', compact('tooltip'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'endpoint' => ['string', 'required', 'max:222'],
            'info' => ['string', 'required', 'max:22222'],
        ]);
        $tooltip = Tooltips::findOrFail($id);

        $tooltip->endpoint = $request->endpoint;
        $tooltip->info = $request->info;
        $tooltip->update();
        Session::flash('message', 'Update Successfully');
        return redirect('backside/super_admin/tooltips/list');
    }
}
