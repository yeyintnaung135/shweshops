<?php

namespace App\Http\Controllers\ShopOwner;

use App\Models\Item;
use App\Facade\TzGate;
use App\Models\Percent_template;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Trait\UserRole;
use App\Http\Requests\ItemsRecapRequest;
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
            $templates = Percent_template::where('shop_id', $this->role_shop_id)->orderBy('created_at', 'desc')->get();
        } else {
            $this->role('shop_owner');
            $templates = Percent_template::where('shop_id', $this->role)->orderBy('created_at', 'desc')->get();
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


        $totalRecords = Percent_template::select('count(*) as allcount')
                        ->where('shop_id', $shop_id)
                        ->where('name', 'like', '%' . $searchValue . '%')
                        ->count();
        $totalRecordswithFilter = $totalRecords;

          $records = Percent_template::orderBy($columnName, $columnSortOrder)
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
                "undamage_product" => $record->undamage_product,
                "damage_product" => $record->damage_product,
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
        return view('backend.shopowner.template.template_create', [ 'shopowner' => $this->shop_owner]);
    }

    public function edit($id)
    {
        $template_id = Percent_template::findOrFail($id)->shop_id;
        if (isset(Auth::guard('shop_role')->user()->id)) {
            $this->role('shop_role');
            if (TzGate::allows($this->role_shop_id == $template_id)) {
                $tempalte = Percent_template::where('id', $id)->first();
            }
        } else {


            $this->role('shop_owner');



            $user_id = $this->role;
            if (TzGate::allows($user_id == $template_id)) {
                $tempalte = Percent_template::where('id', $id)->first();


            }
        }


        return view('backend.shopowner.template.edit', [ 'shopowner' => $this->shop_owner, 'template' => $tempalte]);
    }
    public function store(ItemsRecapRequest $request)
    {
       if(Auth::guard('shop_role')->check()){
         $this->role('shop_role');
         $shop_id = $this->role_shop_id;
       }else{
        $this->role('shop_owner');
         $shop_id = $this->role;
       }
       Percent_template::create([
            'shop_id' => $shop_id,
            'name' => $request->input('name'),
            'undamage_product' => $request->input('undamage'),
            'damage_product' => $request->input('damage'),
            'valuable_product' => $request->input('valuable'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        return response()->json(
            [
                'success'=> true,
                'message'=> "Template Create Successfully",
            ],
        );
    }

    public function update(ItemsRecapRequest $request, $id)
    {
        if(Auth::guard('shop_role')->check()){
            $this->role('shop_role');
            $shop_id = $this->role_shop_id;
          }else{
           $this->role('shop_owner');
            $shop_id = $this->role;
          }
            $template =  Percent_template::find($id);
            $template->shop_id = $shop_id;
            $template->name = $request->name;
            $template->undamage_product = $request->အထည်မပျက်ပြန်သွင်း;
            $template->damage_product = $request->အထည်ပျက်စီးချို့ယွင်း;
            $template->valuable_product = $request->တန်ဖိုးမြင့်;
            $template->created_at = Carbon::now();
            $template->updated_at = Carbon::now();
            $template->save();
            return response()->json(
                [
                    'success'=> true,
                    'message'=> "Template Update Successfully",
                ],
            );
    }

    public function destroy($id)
    {
        $item_id = Percent_template::findOrFail($id)->shop_id;
        $template = Percent_template::find($id);
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
