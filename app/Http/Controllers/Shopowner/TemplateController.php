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
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];

        $shop_id = $this->get_shopid();

        $totalRecords = PercentTemplate::select('count(*) as allcount')
            ->where('shop_id', $shop_id)
            ->where('name', 'like', '%' . $searchValue . '%')
            ->count();
        $totalRecordswithFilter = $totalRecords;

        $records = PercentTemplate::orderBy($columnName, $columnSortOrder)
            ->where('shop_id', $shop_id)->orderBy('created_at', 'desc')
            ->where('name', 'like', '%' . $searchValue . '%')
            ->select('percent_template.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $data_arr[] = array(
                "id" => $record->id,
                "name" => $record->name,
                "undamaged_product" => $record->undamaged_product,
                "damaged_product" => $record->damaged_product,
                "valuable_product" => $record->valuable_product,
                "action" => $record->id,
                "created_at" => $record->created_at,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        echo json_encode($response);
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
