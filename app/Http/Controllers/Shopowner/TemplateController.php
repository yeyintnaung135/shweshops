<?php

namespace App\Http\Controllers\ShopOwner;

use App\Facade\TzGate;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\UserRole;
use App\Http\Requests\ItemsRecapRequest;
use App\Http\Requests\ShopOwner\PercentTemplateCreateRequest;
use App\Models\PercentTemplate;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Js;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class TemplateController extends Controller
{
    use UserRole;

    public function __construct()
    {
        $this->middleware('auth:shop_owners_and_staffs');
    }
    public function index(): View
    {

        $templates = PercentTemplate::where('shop_id', $this->get_shopid())->orderBy('created_at', 'desc')->get();

        return view('backend.shopowner.template.list', ['templates' => $templates, 'shopowner' => $this->current_shop_data()]);
    }

    public function get_template(Request $request)
    {
        $shop_id = $this->get_shopid();

    $query = PercentTemplate::query()->where('shop_id', $shop_id);

    return DataTables::of($query)
        ->filter(function ($query) use ($request) {
            if ($request->has('search.value') && !empty($request->input('search.value'))) {
                $query->where('name', 'like', '%' . $request->input('search.value') . '%');
            }
        })
        ->addColumn('action', function ($record) {
            // Customize your action column here
            return $record->id;
        })
        ->addColumn('created_at', function ($record) {
            return $record->created_at->format('Y-m-d H:i:s');
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function create(): View
    {

        return view('backend.shopowner.template.template_create', ['shopowner' => $this->current_shop_data()]);
    }

    public function edit($id): View
    {
        $tempalte = PercentTemplate::where('shop_id', $this->get_shopid())->where('id', $id)->first();


        return view('backend.shopowner.template.edit', ['shopowner' => $this->current_shop_data(), 'template' => $tempalte]);
    }
    public function store(PercentTemplateCreateRequest $request): JsonResponse
    {
        $shop_id = $this->get_shopid();

        PercentTemplate::create([
            'shop_id' => $shop_id,
            'name' => $request->input('name'),
            'undamaged_product' => $request->input('undamage'),
            'damaged_product' => $request->input('damage'),
            'valuable_product' => $request->input('valuable'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        return response()->json(
            [
                'success' => true,
                'message' => "Template Create Successfully",
            ],
        );
    }

    public function update(PercentTemplateCreateRequest $request, $id): JsonResponse
    {

        $template = PercentTemplate::where('id', $id)->where('shop_id', $this->get_shopid())->first();
        $template->shop_id = $this->get_shopid();
        $template->name = $request->input('name');
        $template->undamaged_product = $request->input('undamaged_product');
        $template->damaged_product = $request->input('damaged_product');
        $template->valuable_product = $request->input('valuable_product');
        $template->created_at = Carbon::now();
        $template->updated_at = Carbon::now();
        $template->save();
        return response()->json(
            [
                'success' => true,
                'message' => "Template Update Successfully",
            ],
        );
    }

    public function destroy($id): RedirectResponse
    {
        $template = PercentTemplate::where('id', $id)->where('shop_id', $this->get_shopid())->first();

        $template->delete();

        return redirect()->route('backside.shop_owner.items.template.list');
    }
}
