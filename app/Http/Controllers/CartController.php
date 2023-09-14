<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    //
    //
    public function __construct()
    {
        $this->middleware('auth')->except(['see_all', 'get_cart_items_data']);
    }


    public function see_all()
    {
        return view('front.Allcart');
    }
    public function get_cart_items_data_authuser(Request $request): JsonResponse
    {
        $useridandtypearry = $this->get_usertype_and_id();
        $type = $useridandtypearry['type'];
        $id = $useridandtypearry['id'];
        $getcartdata = Cart::select('cart_id')->where('user_id', $id)->where('type', $type)->get();

        if (!empty($getcartdata)) {
            $lettmpcart_ids = [];
            foreach ($getcartdata as $je) {
                array_push($lettmpcart_ids, $je->cart_id);
            }
            $get_item_data = Item::whereIn('id', $lettmpcart_ids)->get();
            return response()->json(['success' => true, 'data' => $get_item_data]);
        } else {
            return response()->json(['success' => true, 'data' => []]);
        }
    }

    public function get_cart_items_data(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'cart_ids' => ['required', 'array']
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors()]);
        }

        if ($request->cart_ids != "null" and !empty($request->cart_ids)) {
            $lettmpcart_ids = [];
            foreach ($request->cart_ids as $je) {
                array_push($lettmpcart_ids, $je['cart_id']);
            }
            $get_item_data = Item::whereIn('id', $lettmpcart_ids)->get();
            return response()->json(['success' => true, 'data' => $get_item_data]);
        } else {
            return response()->json(['success' => true, 'data' => []]);
        }
    }


    public function action_cart(Request $request)
    {
        $input = $request->except(['action']);
        $validator = Validator::make($request->all(), [
            'cart_id' => ['required', 'numeric'], 'action' => [Rule::in(['add', 'remove'])]
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors()]);
        }
        if ($request->action == 'add') {
            $this->store_cart_item_to_db($input);
        }
        if ($request->action == 'remove') {
            $this->remove_cart_item_to_db($input);
        }
        $useridandtypearry = $this->get_usertype_and_id();

        $getcartdata = Cart::select('cart_id')->where('user_id', $useridandtypearry['id'])->where('type', $useridandtypearry['type'])->get();

        return response()->json(['success' => true, 'data' => $getcartdata]);
    }



    public function upload_after_logined(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ids' => ['required', 'string', 'max:2000'],
            'rm_ids' => ['nullable','string', 'max:2000']

        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'data' => $validator->errors()]);
        }
        $useridandtypearry = $this->get_usertype_and_id();
        $type = $useridandtypearry['type'];
        $id = $useridandtypearry['id'];

        if ($request->ids != "null" and !empty($request->ids)) {
            $json_encoded = json_decode($request->ids, true);
            foreach ($json_encoded as $je) {


                $this->store_cart_item_to_db($je);
            }
        }
        if ($request->rm_ids != "null" and !empty($request->rm_ids)) {
            $json_encoded_rm = json_decode($request->rm_ids, true);
            foreach ($json_encoded_rm as $jerm) {


                $this->remove_cart_item_to_db($jerm);
            }
        }


        $getcartdata = Cart::select('cart_id')->where('user_id', $id)->where('type', $type)->get();


        return response()->json(['success' => true, 'data' => $getcartdata]);
    }
    public function remove_cart_item_to_db($data): string
    {


        $useridandtypearry = $this->get_usertype_and_id();
        $data['user_id'] = $useridandtypearry['id'];
        $data['type'] = $useridandtypearry['type'];


        $deletecart = Cart::where([['user_id', '=', $data['user_id']], ['type', '=', $data['type']], ['cart_id', '=', $data['cart_id']]])->delete();

        return 'done';
    }
    public function get_usertype_and_id(): array
    {
        if (Auth::guard('shop_owners_and_staffs')->check()) {
            $type = 'shop_owners';
            $id = Auth::guard('shop_owners_and_staffs')->user()->id;
        } else {
            $type = 'user';
            $id = Auth::guard('web')->user()->id;
        }
        return ['type' => $type, 'id' => $id];
    }
    public function store_cart_item_to_db($data): string
    {
        $useridandtypearry = $this->get_usertype_and_id();
        $data['user_id'] = $useridandtypearry['id'];
        $data['type'] = $useridandtypearry['type'];



        $updateorcreate = Cart::updateOrCreate($data);
        return 'done';
    }
    public function check(Request $request): JsonResponse
    {
        $data = $request->all();


        if (Auth::guard('shop_owners_and_staffs')->check()) {
            $data['type'] = 'shop_owners';
            $data['user_id'] = Auth::guard('shop_owners_and_staffs')->user()->id;
        } else {
            $data['type'] = 'user';
            $data['user_id'] = Auth::guard('web')->user()->id;
        }

        $check = Cart::where([['user_id', '=', $data['user_id']], ['type', '=', $data['type']], ['cart_id', '=', $data['cart_id']]])->first();
        if (!empty($check)) {
            return response()->json(['success' => true, 'data' => true]);
        } else {
            return response()->json(['success' => false, 'data' => false]);
        }
    }
}
