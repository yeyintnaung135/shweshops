<?php

namespace App\Http\Controllers\ShopOwner;

use App\Facade\TzGate;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\UserRole;
use App\Http\Requests\ItemsRecapRequest;
use App\Models\PercentTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class TemplateController extends Controller
{
    use UserRole;

    public function __construct()
    {
        $this->middleware('auth:shop_owner,shop_role');

    }
    public function index()
    {

        if (Auth::guard("shop_role")->check()) {
            $this->role('shop_role');
            $templates = PercentTemplate::where('shop_id', $this->role_shop_id)->orderBy('created_at', 'desc')->get();
        } else {
            $this->role('shop_owner');
            $templates = PercentTemplate::where('shop_id', $this->role)->orderBy('created_at', 'desc')->get();
        }
        return view('backend.shopowner.template.list', ['templates' => $templates, 'shopowner' => $this->shop_owner]);
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

        $shop_id = 1;

        if (Auth::guard('shop_owner')->check()) {
            $shop_id = Auth::guard('shop_owner')->user()->id;

        } else {
            $shop_id = Auth::guard('shop_role')->user()->shop_id;
        }

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

    public function create()
    {
        if (Auth::guard("shop_role")->check()) {
            $this->role('shop_role');

        } else {
            $this->role('shop_owner');

        }
        return view('backend.shopowner.template.template_create', ['shopowner' => $this->shop_owner]);
    }

    public function edit($id)
    {
        $template_id = PercentTemplate::findOrFail($id)->shop_id;
        if (isset(Auth::guard('shop_role')->user()->id)) {
            $this->role('shop_role');
            if (TzGate::allows($this->role_shop_id == $template_id)) {
                $tempalte = PercentTemplate::where('id', $id)->first();
            }
        } else {

            $this->role('shop_owner');

            $user_id = $this->role;
            if (TzGate::allows($user_id == $template_id)) {
                $tempalte = PercentTemplate::where('id', $id)->first();

            }
        }

        return view('backend.shopowner.template.edit', ['shopowner' => $this->shop_owner, 'template' => $tempalte]);
    }
    public function store(ItemsRecapRequest $request)
    {
        if (Auth::guard('shop_role')->check()) {
            $this->role('shop_role');
            $shop_id = $this->role_shop_id;
        } else {
            $this->role('shop_owner');
            $shop_id = $this->role;
        }
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

    public function update(ItemsRecapRequest $request, $id)
    {
        if (Auth::guard('shop_role')->check()) {
            $this->role('shop_role');
            $shop_id = $this->role_shop_id;
        } else {
            $this->role('shop_owner');
            $shop_id = $this->role;
        }
        $template = PercentTemplate::find($id);
        $template->shop_id = $shop_id;
        $template->name = $request->name;
        $template->undamaged_product = $request->undamaged_product;
        $template->damaged_product = $request->damaged_product;
        $template->valuable_product = $request->valuable_product;
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

    public function destroy($id)
    {
        $item_id = PercentTemplate::findOrFail($id)->shop_id;
        $template = PercentTemplate::find($id);
        if (Auth::guard('shop_role')->check()) {
            $this->role('shop_role');
            if (TzGate::allows($item_id == $this->role_shop_id)) {
                $template->delete();
            }
        } else {
            $this->role('shop_owner');

            if (TzGate::allows($item_id == $this->role)) {
                $template->delete();
            }
        }
        return redirect()->route('backside.shop_owner.items.template.list');
    }

}
