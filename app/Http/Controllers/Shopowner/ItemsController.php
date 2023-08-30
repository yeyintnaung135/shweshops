<?php

namespace App\Http\Controllers\ShopOwner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trait\FacebookTrait;
use App\Http\Controllers\Trait\Logs\MultipleDamageLogsTrait;
use App\Http\Controllers\Trait\Logs\MultiplePriceLogsTrait;
use App\Http\Controllers\Trait\Logs\ShopsLogActivityTrait;
use App\Http\Controllers\Trait\MultipleItem;
use App\Http\Controllers\Trait\UserRole;
use App\Http\Controllers\Trait\YKImage;
use App\Http\Requests\ShopOwner\ItemCreateRequest;
use App\Http\Requests\ShopOwner\ItemEditRequest;
use App\Http\Requests\ShopOwner\ItemsRecapUpdateRequest;
use App\Http\Requests\ShopOwner\MultiplePriceUpdateRequest;
use App\Models\Collection;
use App\Models\Discount;
use App\Models\Gems;
use App\Models\Item;
use App\Models\ItemLogActivity;
use App\Models\MainCategory;
use App\Models\MultipleDamageLogs;
use App\Models\MultipleDiscountLogs;
use App\Models\MultiplePriceLogs;
use App\Models\PercentTemplate;
use App\Models\Shops;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Validator;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ItemsController extends Controller
{
    use YKImage, UserRole, FacebookTrait, ShopsLogActivityTrait,
    MultipleItem, MultipleDamageLogsTrait, MultiplePriceLogsTrait;

    public $err_data = [];

    public function __construct()
    {
        $this->middleware('auth:shop_owners_and_staffs');
    }

    public function index(): View
    {
        return view('backend.shopowner.item.list');
    }

    public function item_activity_index(): View
    {
        return view('backend.shopowner.activity.product.item');
    }

    public function multiprice_activity_index(): View
    {
        return view('backend.shopowner.activity.product.multiprice');
    }

    public function multidiscount_activity_index(): View
    {
        return view('backend.shopowner.activity.product.multidis');
    }

    public function multipercent_activity_index(): View
    {
        return view('backend.shopowner.activity.product.multipercent');
    }

    public function get_item_activity_log(Request $request): JsonResponse
    {
        $shop_id = $this->get_shopid();
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        $query = ItemLogActivity::select('id', 'user_name', 'item_code', 'name', 'user_id', 'created_at')
            ->where('shop_id', $shop_id)
            ->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::of($query)
            ->editColumn('created_at', fn($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->toJson();
    }

    public function get_multiple_price_activity_log(Request $request): JsonResponse
    {

        $shop_id = $this->get_shopid();
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        $query = MultiplePriceLogs::select(
            'id', 'product_code', 'name', 'user_id', 'user_name',
            'user_role', 'old_price', 'new_price', 'min_price',
            'max_price', 'new_min_price', 'new_max_price', 'created_at')
            ->where('shop_id', $shop_id)
            ->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::of($query)
            ->editColumn('created_at', fn($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->toJson();

        return DataTables::of($query)
            ->addColumn('created_at_formatted', fn($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->toJson();
    }

    public function get_multiple_discount_activity_log(Request $request): JsonResponse
    {
        $shop_id = $this->get_shopid();
        $searchByFromdate = $request->input('searchByFromdate', '0-0-0 00:00:00');
        $searchByTodate = $request->input('searchByTodate', now());

        $query = MultipleDiscountLogs::select(
            'id', 'product_code', 'name', 'user_name',
            'user_role', 'old_price', 'old_min_price', 'old_max_price',
            'percent', 'old_discount_price', 'new_discount_price',
            'old_discount_min', 'old_discount_max', 'new_discount_min',
            'new_discount_max', 'created_at')
            ->where('shop_id', $shop_id)
            ->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::of($query)
            ->editColumn('created_at', fn($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->toJson();
    }

    public function get_multiple_damage_activity_log(Request $request): JsonResponse
    {
        $shop_id = $this->get_shopid();
        $searchByFromdate = $request->input('searchByFromdate', '0-0-0 00:00:00');
        $searchByTodate = $request->input('searchByTodate', now());

        $query = MultipleDamageLogs::select(
            'id', 'product_code', 'name', 'user_name',
            'user_role', 'name', 'decrease', 'fee', 'undamage',
            'damage', 'expensive_thing', 'new_decrease', 'new_fee',
            'new_undamage', 'new_damage', 'new_expensive_thing', 'created_at')
            ->where('shop_id', $shop_id)
            ->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::of($query)
            ->editColumn('created_at', fn($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->toJson();
    }
    //show create form
    //Process Ajax request
    public function get_items(Request $request): JsonResponse
    {
        $shop_id = $this->get_shopid();
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        $items = Item::select(
            'id', 'product_code', 'default_photo', 'name', 'shop_id',
            'price', 'min_price', 'max_price', 'created_at')
            ->where('shop_id', $shop_id)
            ->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn($query) => $query->whereDate('created_at', '<=', $searchByTodate));

        return DataTables::of($items)
            ->addColumn('checkbox', fn($item) => $item->id)
            ->addColumn('check_discount', fn($item) => $item->YkGetDiscount)
            ->addColumn('price_formatted', fn($item) => $item->formatted_price)
            ->addColumn('action', fn($item) => $item->id)
            ->editColumn('created_at', fn($item) => $item->created_at->format('F d, Y ( h:i A )'))
            ->toJson();
    }

    public function export_excel(): View
    {
        return view('backend.shopowner.item.exportexcel');
    }

    public function post_export_excel(Request $request): JsonResponse
    {
        $shop_id = $this->get_shopid();
        $searchByFromdate = $request->input('searchByFromdate', '0-0-0 00:00:00');
        $searchByTodate = $request->input('searchByTodate', now());

        $query = Item::query()
            ->orderByDesc('created_at')
            ->where('shop_id', $shop_id)
            ->whereBetween('created_at', [$searchByFromdate, $searchByTodate])
            ->select(
                'id', 'product_code', 'default_photo', 'name',
                'description', 'price', 'min_price', 'max_price', 'created_at'
            );

        return DataTables::of($query)
            ->addColumn('check_discount', fn($record) => $record->YkGetDiscount)
            ->addColumn('price_formatted', function ($record) {
                return ($record->price != 0) ? $record->price : $record->min_price . '-' . $record->max_price;
            })
            ->addColumn('action', fn($record) => $record->id)
            ->addColumn('created_at_formatted', fn($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->toJson();
    }

    public function get_product_code_by_typing(Request $request)
    {
        $result = Item::orderBy('product_code', 'asc')
            ->where('shop_id', $request->shop_id)
            ->where('product_code', 'like', $request->chatdatabytyping . '%')
            ->select('*')
            ->take(5)
            ->get();
        echo json_encode($result);
    }

    //show create form
    public function create(): View
    {
        //tz
        $shop_id = $this->get_shopid();
        $collection = Collection::where('shop_id', $shop_id)->get();
        $somedatafromshop = Shops::where('id', $shop_id)->first();
        $percenttemplate = PercentTemplate::where('shop_id', $shop_id)->get();
        $main_cat = MainCategory::get();
        $cat_list = DB::table('categories')->leftjoin('items', 'categories.name', '=', 'items.category_id')->select('categories.*')->groupBy('categories.name')->orderByRaw("CASE
                        WHEN count(items.category_id) = 0 THEN categories.id END ASC,
            case when count(items.category_id) != 0 then count(categories.name) end DESC")->get();

        return view('backend.shopowner.item.create', ['main_cat' => $main_cat, 'cat_list' => $cat_list, 'shopowner' => $this->current_shop_data(), 'collection' => $collection, 'product_details' => [], 'somedatafromshop' => $somedatafromshop, 'percenttemplate' => $percenttemplate]);
    }

    //start storing data
    public function store(ItemcreateRequest $request): JsonResponse
    {
        // $this->ShopsaddToLog($id);
        $input = $request->except('_token');
        if ($input['price'] > 9999999999 or $input['min_price'] > 9999999999 or $input['max_price'] > 9999999999 or ($input['min_price'] > $input['max_price'])) {
            return response()->json(['msg' => 'error', 'error_msg' => 'Wrong Price']);
        }

        $jdmidimage = json_decode($input['formidphotos'], true);
        $jdthumbimage = json_decode($input['forthumbphotos'], true);
        $statictimestamp = Carbon::now()->timestamp;

        foreach ($request->file('file') as $key => $value) {
            $file = $request->file('file')[$key];

            $imageName[$key] = strtolower($statictimestamp . '_' . $key . '.' . $file->getClientOriginalExtension());
            if ($input['default_photo'] == $file->getClientOriginalName()) {
                $input['default_photo'] = $imageName[$key];
            }
            $get_path = $this->save_image($file, $imageName[$key], 'items/');
        }
        foreach ($jdmidimage as $key => $value) {
            $this->base64_to_image($value['data'], 'items/mid/' . $imageName[$key]);
        }
        foreach ($jdthumbimage as $key => $value) {
            $this->base64_to_image($value['data'], 'items/thumbs/' . $imageName[$key]);
        }
        if (!empty($imageName[0])) {
            $input['photo_one'] = $imageName[0];
        } else {
            $input['photo_one'] = '';
        }
        if (!empty($imageName[1])) {
            $input['photo_two'] = $imageName[1];
        } else {
            $input['photo_two'] = '';
        }
        if (!empty($imageName[2])) {
            $input['photo_three'] = $imageName[2];
        } else {
            $input['photo_three'] = '';
        }
        if (!empty($imageName[3])) {
            $input['photo_four'] = $imageName[3];
        } else {
            $input['photo_four'] = '';
        }
        if (!empty($imageName[4])) {
            $input['photo_five'] = $imageName[4];
        } else {
            $input['photo_five'] = '';
        }
        if (!empty($imageName[5])) {
            $input['photo_six'] = $imageName[5];
        } else {
            $input['photo_six'] = '';
        }
        if (!empty($imageName[6])) {
            $input['photo_seven'] = $imageName[6];
        } else {
            $input['photo_seven'] = '';
        }
        if (!empty($imageName[7])) {
            $input['photo_eight'] = $imageName[7];
        } else {
            $input['photo_eight'] = '';
        }
        if (!empty($imageName[8])) {
            $input['photo_nine'] = $imageName[8];
        } else {
            $input['photo_nine'] = '';
        }
        if (!empty($imageName[9])) {
            $input['photo_ten'] = $imageName[9];
        } else {
            $input['photo_ten'] = '';
        }

        //set id for manager
        $input['shop_id'] = $this->get_shopid();
        $input['user_id'] = $this->get_currentauthdata()->id;
        $input['review'] = 'default';
        $input['sizing_guide'] = 'default';

        $input['default_photo'] = strtolower($input['default_photo']);
        $input['view_count'] = 0;
        if ($input['diamond'] == 'No') {
            $input['carat'] = 0;
            $input['yati'] = 0;
            $input['pwint'] = 0;
            $input['d_gram'] = 0;
        }

        $input['weight_unit'] = 0;

        $itemupload = Item::create($input);
        $this->ShopsCreateLog($itemupload, $this->get_shopid());
        if ($itemupload) {
            Gems::create(['gems' => $input['gems'], 'item_id' => $itemupload->id]);
            $itemupload->tag($request->tags);
        }
        // if ($input['price'] != 0) {
        //     $toshowprice = $input['price'];
        // } else {
        //     $toshowprice = $input['min_price'] . '-' . $input['max_price'];
        // }
        // $data = $input['name'] . ' (' . $toshowprice . ')' . $input['description'];
        // $getfbdata = facebooktable::where('shop_id', $input['shop_id'])->first();
        // if (!empty($getfbdata)) {
        //     $this->posttofbpage($input['shop_id'], $data, $itemupload->check_photo);
        // }

        Session::flash('message', 'Your item was successfully uploaded');

        return response()->json(['msg' => 'success', 'id' => $itemupload->id]);
    }
    //edit function
    public function edit_ajax(Request $request)
    {
        //        if (!$this->itisowneritem($request->id)) {
        //            return $this->unauthorize();
        //        }
        return response()->json($request);
        $old_tags = DB::table('tagging_tagged')->where('taggable_id', $request->id)->get();
        $item_tag = Item::where('id', $request->id)->first();
        $item_tagarray = explode(',', $item_tag->tags);
        $collection = collect($item_tagarray);
        $output = $collection->implode(',');
        $current_item = Item::where('id', $request->id)->first();
        $old_gem = Gems::where('item_id', $request->id)->first();

        $all_image_fields = ['photo_one', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_six', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten'];
        $input = $request->except('_token', 'id', 'gems', 'tags', 'file', 'formidphotos', 'forthumbphotos', 'discount', 'unsetdiscount');

        if ($input['price'] > 9999999999 or $input['min_price'] > 9999999999 or $input['max_price'] > 9999999999 or ($input['min_price'] > $input['max_price'])) {
            return response()->json(['msg' => 'error', 'error_msg' => 'Wrong Price']);
        }
        $forphotos = $request->except('_token', 'id', 'gems', 'tags', 'file');
        $imageName = [];
        if ($input['diamond'] == 'No') {
            $input['carat'] = 0;
            $input['yati'] = 0;
            $input['pwint'] = 0;
            $input['d_gram'] = 0;
        }
        $input['weight_unit'] = 0;
        $input['sizing_guide'] = 'default';

        $jdmidimage = json_decode($forphotos['formidphotos'], true);
        $jdthumbimage = json_decode($forphotos['forthumbphotos'], true);
        $statictimestamp = Carbon::now()->timestamp;

        foreach ($request->file('file') as $key => $value) {
            $file = $request->file('file')[$key];

            $imageName[$key] = strtolower($statictimestamp . '_' . $key . '.' . $file->getClientOriginalExtension());
            if ($input['default_photo'] == $file->getClientOriginalName()) {
                $input['default_photo'] = $imageName[$key];
            }
            $get_path = $this->save_image($file, $imageName[$key], 'items/');

            //for thumbnail

            //$this->setthumbs($get_path, $imageName[$key]);
            //for thumbnail

        }
        foreach ($jdmidimage as $key => $value) {
            $this->base64_to_image($value['data'], 'items/mid/' . $imageName[$key]);
        }
        foreach ($jdthumbimage as $key => $value) {
            $this->base64_to_image($value['data'], 'items/thumbs/' . $imageName[$key]);
        }
        foreach ($imageName as &$imn) {
            foreach ($all_image_fields as $af) {
                if (empty($input[$af])) {

                    if ($current_item[$af] == '') {

                        $input[$af] = $imn;

                        break;
                    } else {
                        continue;
                    }
                } else {
                    continue;
                }
            }
        }
        $change = Item::where('id', $request->id);
        $input['review'] = 'default';

        // return dd($change);
        if ($change->update($input)) {

            $shop_id = $this->get_shopid();

            $this->ShopsEditLog($request, $shop_id);
            Item::find($request->id)->retag($request->all()['tags']);

            $checkgcount = Gems::where('item_id', $request->id)->count();
            if ($checkgcount == 0) {
                Gems::create(['gems' => $request->all()['gems'], 'item_id' => $request->id]);
            } else {
                Gems::where('item_id', $request->id)->update(['gems' => $request->all()['gems']]);
            }

            $tmpdis = json_decode($request->all()['discount'], true);
            if ($tmpdis['show'] == 'yes' and $request->all()['unsetdiscount'] == 'false') {
                discount::where('item_id', $request->id)->update(['discount_price' => $tmpdis['newprice'], 'discount_min' => $tmpdis['newmin'], 'discount_max' => $tmpdis['newmax']]);
            } else if ($tmpdis['show'] == 'yes' and $request->all()['unsetdiscount'] == 'true') {
                discount::where('item_id', $request->id)->delete();
            } else {
            }

            //            $dis = discount::where('item_id', $request->id)->get();
            //            foreach ($dis as $d) {
            //                $percent = $input['price'] - ($input['price'] * $d->percent / 100);
            //                discount::where('item_id', $request->id)->update(['discount_price' => $percent]);
            //            }

        }
        // else {
        //     return dd($input);

        // }
        // $new_gem = Gems::where('item_id', $request->id)->first();
        // $changes = $change->getChanges();
        // $new_tags = $request->tags;
        // $items_edit_detail_logs = new ItemsEditDetailLogs();
        // $new_gem = Gems::where('item_id', $request->id)->first();
        // $new_tags = $request->tags;
        // $item_newtag = Item::where('id', $request->id)->first();
        // $item_newtagarray = explode(',', $item_newtag->tags);
        // $newcollection = collect($item_newtagarray);
        // $newoutput = $newcollection->implode(',');

        // $changes = $change->getChanges();

        // $items_edit_detail_logs = new ItemsEditDetailLogs();
        // // return dd($item_tag['tags']);

        // $items_edit_detail_logs->tags = $output;

        // if ($output == $newoutput) {
        //     $items_edit_detail_logs->new_tags = "-----";
        // } else {
        //     $items_edit_detail_logs->new_tags = $new_tags;
        // }
        // $items_edit_detail_logs->gems = $old_gem->gems;

        // if ($old_gem == $new_gem) {
        //     $items_edit_detail_logs->new_gems = "-----";
        // } else {
        //     $items_edit_detail_logs->new_gems = $new_gem->gems;
        // }

        // $items_edit_detail_logs->photo_one = $current_item->photo_one;
        // if ($current_item->photo_one == $change->photo_one) {
        //     $items_edit_detail_logs->new_photo_one = "-----";
        // } else {
        //     $items_edit_detail_logs->new_photo_one = "images changes";
        // }
        // $items_edit_detail_logs->photo_two = $current_item->photo_two;
        // if ($current_item->photo_two == $change->photo_two) {
        //     $items_edit_detail_logs->new_photo_two = "-----";
        // } else {
        //     $items_edit_detail_logs->new_photo_two = "images changes";
        // }
        // $items_edit_detail_logs->photo_three = $current_item->photo_three;
        // if ($current_item->photo_three == $change->photo_three) {
        //     $items_edit_detail_logs->new_photo_three = "-----";
        // } else {
        //     $items_edit_detail_logs->new_photo_three = "images changes";
        // }
        // $items_edit_detail_logs->photo_four = $current_item->photo_four;
        // if ($current_item->photo_four == $change->photo_four) {
        //     $items_edit_detail_logs->new_photo_four = "-----";
        // } else {
        //     $items_edit_detail_logs->new_photo_four = "images changes";
        // }
        // $items_edit_detail_logs->photo_five = $current_item->photo_five;
        // if ($current_item->photo_five == $change->photo_five) {
        //     $items_edit_detail_logs->new_photo_five = "-----";
        // } else {
        //     $items_edit_detail_logs->new_photo_five = "images changes";
        // }
        // $items_edit_detail_logs->photo_six = $current_item->photo_six;
        // if ($current_item->photo_six == $change->photo_six) {
        //     $items_edit_detail_logs->new_photo_six = "-----";
        // } else {
        //     $items_edit_detail_logs->new_photo_six = "images changes";
        // }
        // $items_edit_detail_logs->photo_seven = $current_item->photo_seven;
        // if ($current_item->photo_seven == $change->photo_seven) {
        //     $items_edit_detail_logs->new_photo_seven = "-----";
        // } else {
        //     $items_edit_detail_logs->new_photo_seven = "images changes";
        // }
        // $items_edit_detail_logs->photo_eight = $current_item->photo_eight;
        // if ($current_item->photo_eight == $change->photo_eight) {
        //     $items_edit_detail_logs->new_photo_eight = "-----";
        // } else {
        //     $items_edit_detail_logs->new_photo_eight = "images changes";
        // }
        // $items_edit_detail_logs->photo_nine = $current_item->photo_nine;
        // if ($current_item->photo_nine == $change->photo_nine) {
        //     $items_edit_detail_logs->new_photo_nine = "-----";
        // } else {
        //     $items_edit_detail_logs->new_photo_nine = "images changes";
        // }
        // $items_edit_detail_logs->photo_ten = $current_item->photo_ten;
        // if ($current_item->photo_ten == $change->photo_ten) {
        //     $items_edit_detail_logs->new_photo_ten = "-----";
        // } else {
        //     $items_edit_detail_logs->new_photo_ten = "images changes";
        // }
        // $items_edit_detail_logs->default_photo = $current_item->default_photo;
        // if ($current_item->default_photo == $change->default_photo) {
        //     $items_edit_detail_logs->new_default_photo = "-----";
        // } else {
        //     $items_edit_detail_logs->new_default_photo = "images changes";
        // }

        // $items_edit_detail_logs->name = $current_item->name;
        // if ($current_item->name == $change->name) {
        //     $items_edit_detail_logs->new_name = "-----";
        // } else {
        //     $items_edit_detail_logs->new_name = $changes['name'];
        // }

        // $items_edit_detail_logs->price = $current_item->price;
        // if ($current_item->price == $change->price) {
        //     $items_edit_detail_logs->new_price = "-----";
        // } else {
        //     $items_edit_detail_logs->new_price = $changes['price'];
        // }
        // $items_edit_detail_logs->description = $current_item->description;
        // if ($current_item->description == $change->description) {
        //     $items_edit_detail_logs->new_description = "-----";
        // } else {
        //     $items_edit_detail_logs->new_description = $changes['description'];
        // }
        // $items_edit_detail_logs->product_code = $current_item->product_code;
        // if ($current_item->product_code == $change->product_code) {
        //     $items_edit_detail_logs->new_product_code = "-----";
        // } else {
        //     $items_edit_detail_logs->new_product_code = $changes['product_code'];
        // }
        // $items_edit_detail_logs->gold_quality = $current_item->gold_quality;
        // if ($current_item->gold_quality == $change->gold_quality) {
        //     $items_edit_detail_logs->new_gold_quality = "-----";
        // } else {
        //     $items_edit_detail_logs->new_gold_quality = $changes['gold_quality'];
        // }
        // $items_edit_detail_logs->gold_colour = $current_item->gold_colour;
        // if ($current_item->gold_colour == $change->gold_colour) {
        //     $items_edit_detail_logs->new_gold_colour = "-----";
        // } else {
        //     $items_edit_detail_logs->new_gold_colour = $changes['gold_colour'];
        // }
        // //   $items_edit_detail_logs->sizing_guide = $old['sizing_guide'];
        // //   if($changes == []){
        // //         $items_edit_detail_logs->new_sizing_guide = "-----";
        // //   }else{
        // //       $items_edit_detail_logs->new_sizing_guide = $changes['sizing_guide'];
        // //   }
        // $items_edit_detail_logs->undamage = $current_item->undamaged_product;
        // if ($current_item->undamaged_product == $change->undamaged_product) {
        //     $items_edit_detail_logs->new_undamage = "-----";
        // } else {
        //     $items_edit_detail_logs->new_undamage = $changes['undamaged_product'];
        // }
        // $items_edit_detail_logs->expensive_thing = $current_item->valuable_product;
        // if ($current_item->valuable_product == $change->valuable_product) {
        //     $items_edit_detail_logs->new_expensive_thing = "-----";
        // } else {
        //     $items_edit_detail_logs->new_expensive_thing = $changes['valuable_product'];
        // }
        // $items_edit_detail_logs->damage = $current_item->damaged_product;
        // if ($current_item->damaged_product == $change->damaged_product) {
        //     $items_edit_detail_logs->new_damage = "-----";
        // } else {
        //     $items_edit_detail_logs->new_damage = $changes['damaged_product'];
        // }
        // $items_edit_detail_logs->weight = $current_item->weight;
        // if ($current_item->weight == $change->weight) {
        //     $items_edit_detail_logs->new_weight = "-----";
        // } else {
        //     $items_edit_detail_logs->new_weight = $changes['weight'];
        // }
        // //   $items_edit_detail_logs->weight_unit = $old['weight_unit'];
        // //   if($changes == []){
        // //         $items_edit_detail_logs->new_weight_unit = "-----";
        // //   }else{
        // //       $items_edit_detail_logs->new_weight_unit = $changes['weight_unit'];
        // //   }

        // $items_edit_detail_logs->min_price = $current_item->min_price;
        // if ($current_item->min_price == $change->min_price) {
        //     $items_edit_detail_logs->new_min_price = "-----";
        // } else {
        //     $items_edit_detail_logs->new_min_price = $changes['min_price'];
        // }
        // $items_edit_detail_logs->max_price = $current_item->max_price;
        // if ($current_item->max_price == $change->max_price) {
        //     $items_edit_detail_logs->new_max_price = "-----";
        // } else {
        //     $items_edit_detail_logs->new_max_price = $changes['max_price'];
        // }
        // $items_edit_detail_logs->review = $current_item->review;
        // if ($current_item->review == $change->review) {
        //     $items_edit_detail_logs->new_review = "-----";
        // } else {
        //     $items_edit_detail_logs->new_review = $changes['review'];
        // }
        // $items_edit_detail_logs->stock = $current_item->stock;
        // if ($current_item->stock == $change->stock) {
        //     $items_edit_detail_logs->new_stock = "-----";
        // } else {
        //     $items_edit_detail_logs->new_stock = $changes['stock'];
        // }
        // $items_edit_detail_logs->stock_count = $current_item->stock_count;
        // if ($current_item->stock_count == $change->stock_count) {
        //     $items_edit_detail_logs->new_stock_count = "-----";
        // } else {
        //     $items_edit_detail_logs->new_stock_count = $changes['stock_count'];
        // }
        // $items_edit_detail_logs->diamond = $current_item->diamond;
        // if ($current_item->diamond == $change->diamond) {
        //     $items_edit_detail_logs->new_diamond = "-----";
        // } else {
        //     $items_edit_detail_logs->new_diamond = $changes['diamond'];
        // }
        // $items_edit_detail_logs->carat = $current_item->carat;
        // if ($current_item->carat == $change->carat) {
        //     $items_edit_detail_logs->new_carat = "-----";
        // } else {
        //     $items_edit_detail_logs->new_carat = $changes['carat'];
        // }
        // $items_edit_detail_logs->yati = $current_item->yati;
        // if ($current_item->yati == $change->yati) {
        //     $items_edit_detail_logs->new_yati = "-----";
        // } else {
        //     $items_edit_detail_logs->new_yati = $changes['yati'];
        // }
        // $items_edit_detail_logs->gender = $current_item['gender'];
        // if ($current_item->gender == $change->gender) {
        //     $items_edit_detail_logs->new_gender = "-----";
        // } else {
        //     $items_edit_detail_logs->new_gender = $changes['gender'];
        // }
        // $items_edit_detail_logs->handmade = $current_item->handmade;
        // if ($current_item->handmade == $change->handmade) {
        //     $items_edit_detail_logs->new_handmade = "-----";
        // } else {
        //     $items_edit_detail_logs->new_handmade = $changes['handmade'];
        // }
        // $items_edit_detail_logs->pwint = $current_item->pwint;
        // if ($current_item->pwint == $change->pwint) {
        //     $items_edit_detail_logs->new_pwint = "-----";
        // } else {
        //     $items_edit_detail_logs->new_pwint = $changes['pwint'];
        // }
        // $items_edit_detail_logs->d_gram = $current_item->d_gram;
        // if ($current_item->d_gram == $change->d_gram) {
        //     $items_edit_detail_logs->new_d_gram = "-----";
        // } else {
        //     $items_edit_detail_logs->new_d_gram = $changes['d_gram'];
        // }
        // $items_edit_detail_logs->category_id = $current_item->category_id;
        // if ($current_item->category_id == $change->category_id) {
        //     $items_edit_detail_logs->new_category_id = "-----";
        // } else {
        //     $items_edit_detail_logs->new_category_id = $changes['category_id'];
        // }
        // $items_edit_detail_logs->view_count = $current_item->view_count;
        // if ($current_item->view_count == $change->view_count) {
        //     $items_edit_detail_logs->new_view_count = "-----";
        // } else {
        //     $items_edit_detail_logs->new_view_count = $changes['view_count'];
        // }
        // $items_edit_detail_logs->charge = $current_item->charge;
        // if ($current_item->charge == $change->charge) {
        //     $items_edit_detail_logs->new_charge = "-----";
        // } else {
        //     $items_edit_detail_logs->new_charge = $changes['charge'];
        // }
        // $items_edit_detail_logs->collection_id = $current_item->collection_id;
        // if ($current_item->collection_id == $change->collection_id) {
        //     $items_edit_detail_logs->new_collection_id = "-----";
        // } else {
        //     $items_edit_detail_logs->new_collection_id = $changes['collection_id'];
        // }
        // $items_edit_detail_logs->user_id = $current_item->user_id;
        // $items_edit_detail_logs->shop_id = $current_item->shop_id;
        // $items_edit_detail_logs->shopownereditlogs_id = $shopownerlogid->id;
        // $items_edit_detail_logs->save();

        Session::flash('message', 'Your item was successfully updated');
        return response()->json(['msg' => 'success', 'id' => $request->id]);
    }
    //show edit form
    public function edit($id): View
    {

        $shop_id = $this->get_shopid();
        $collection = Collection::where('shop_id', $shop_id)->get();

        $item = Item::where('shop_id', $shop_id)->where('id', $id)->with('tagged')->first();

        if ($item->weight_unit != '0') {
            $item->weight = 'temp';
        }

        $cat_list = DB::table('categories')->leftjoin('items', 'categories.name', '=', 'items.category_id')->select('categories.*')->groupBy('categories.name')->orderByRaw("CASE
                                WHEN count(items.category_id) = 0 THEN categories.id END ASC,
                    case when count(items.category_id) != 0 then count(categories.name) end DESC")->get();
        $main_cat = MainCategory::get();

        return view('backend.shopowner.item.edit', ['cat_list' => $cat_list, 'main_cat' => $main_cat, 'shopowner' => $this->current_shop_data(), 'item' => $item, 'collection' => $collection]);
    }
    public function items_photos_delete($id): string
    {
        $all_image_fields = ['photo_one', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_six', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten'];
        $item = Item::onlyTrashed()->findOrFail($id);

        foreach ($all_image_fields as $image_field) {
            if (dofile_exists('/items/' . $item->$image_field)) {

                if (env('USE_DO') == 'true') {
                    Storage::disk('digitalocean')->delete('/prod/items/' . $item->$image_field);
                    if (Storage::disk('digitalocean')->exists('/prod/items/thumbs/' . $item->$image_field)) {
                        Storage::disk('digitalocean')->delete('/prod/items/thumbs/' . $item->$image_field);
                    }
                    if (Storage::disk('digitalocean')->exists('/prod/items/mid/' . $item->$image_field)) {
                        Storage::disk('digitalocean')->delete('/prod/items/mid/' . $item->$image_field);
                    }
                } else {
                    Storage::disk('public_image')->delete('/items/' . $item->$image_field);
                    if (Storage::disk('public_image')->exists('/items/thumbs/' . $item->$image_field)) {
                        Storage::disk('public_image')->delete('/items/thumbs/' . $item->$image_field);
                    }
                    if (Storage::disk('public_image')->exists('/items/mid/' . $item->$image_field)) {
                        Storage::disk('public_image')->delete('/items/mid/' . $item->$image_field);
                    }
                }
            }
        }
        return 'done';
    }
    public function remove_image(Request $request): JsonResponse
    {
        $itemquery = Item::where('id', $request->id)->where('shop_id', $this->get_shopid());
        if (empty($itemquery->count())) {
            return response()->json(['success' => false]);
        }
        $checkimagehasintable = $itemquery->where($request->column_name, $request->name)->first();
        if (!empty($checkimagehasintable) && !empty($request->column_name)) {

            if (dofile_exists('/items/' . $request->name)) {
                if (env('USE_DO') == 'true') {
                    Storage::disk('digitalocean')->delete('/prod/items/' . $request->name);
                    if (Storage::disk('digitalocean')->exists('/prod/items/thumbs/' . $request->name)) {
                        Storage::disk('digitalocean')->delete('/prod/items/thumbs/' . $request->name);
                    }
                    if (Storage::disk('digitalocean')->exists('/prod/items/mid/' . $request->name)) {
                        Storage::disk('digitalocean')->delete('/prod/items/mid/' . $request->name);
                    }
                } else {
                    Storage::disk('public_image')->delete('/items/' . $request->name);
                    if (Storage::disk('public_image')->exists('/items/thumbs/' . $request->name)) {
                        Storage::disk('public_image')->delete('/items/thumbs/' . $request->name);
                    }
                    if (Storage::disk('public_image')->exists('/items/mid/' . $request->name)) {
                        Storage::disk('public_image')->delete('/items/mid/' . $request->name);
                    }
                }

                $itemquery->update(array($request->column_name => ''));
                return response()->json('success');
            } else {

                Item::where('id', $request->id)->update(array($request->column_name => ''));

                return response()->json($request);
            }
        } else {
            return response()->json(['success' => false]);
        }
    }

    //edit but custom upload not from dropzone
    public function custom_edit(ItemEditRequest $request): JsonResponse
    {
        // if (!$this->itisowneritem($request->id)) {
        //      return $this->unauthorize();
        //  }
        $all_image_fields = ['photo_one', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_six', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten'];

        $input = $request->except('_token', 'id', 'gems', 'tags', 'file', 'formidphotos', 'forthumbphotos', 'discount', 'unsetdiscount');
        if ($input['price'] > 9999999999 or $input['min_price'] > 9999999999 or $input['max_price'] > 9999999999 or ($input['min_price'] > $input['max_price'])) {
            return response()->json(['msg' => 'error', 'error_msg' => 'Wrong Price']);
        }

        if ($input['diamond'] == 'No') {
            $input['carat'] = 0;
            $input['yati'] = 0;
            $input['pwint'] = 0;
            $input['d_gram'] = 0;
        }
        $input['weight_unit'] = 0;
        $input['sizing_guide'] = 'default';

        $change = Item::where('id', $request->id)->first();
        $old = $change->getOriginal();
        $old_gem = Gems::where('item_id', $request->id)->first();
        $input['review'] = 'default';

        if ($change->update($input)) {

            $shop_id = $this->get_shopid();

            // $shopownerlogid = \ShopownerLogActivity::ShopownerEditLog($request, $shop_id);
            $old_tags = DB::table('tagging_tagged')->where('taggable_id', $request->id)->get();
            $item_tag = Item::where('id', $request->id)->first();
            $item_tagarray = explode(',', $item_tag->tags);
            $collection = collect($item_tagarray);
            $output = $collection->implode(',');

            // $item_tagarray = implode(',',$item_tag->tags);

            Item::find($request->id)->retag($request->all()['tags']);

            $checkgcount = Gems::where('item_id', $request->id)->count();
            if ($checkgcount == 0) {
                $n_gems = Gems::create(['gems' => $request->all()['gems'], 'item_id' => $request->id]);
            } else {
                $n_gems = Gems::where('item_id', $request->id);
                $n_gems->update(['gems' => $request->all()['gems']]);
            }
            $tmpdis = json_decode($request->all()['discount'], true);
            if ($tmpdis['show'] == 'yes' and $request->all()['unsetdiscount'] == 'false') {
                discount::where('item_id', $request->id)->update(['discount_price' => $tmpdis['newprice'], 'discount_min' => $tmpdis['newmin'], 'discount_max' => $tmpdis['newmax']]);
            } else if ($tmpdis['show'] == 'yes' and $request->all()['unsetdiscount'] == 'true') {
                discount::where('item_id', $request->id)->delete();
            } else {
            }
        }

        // $new_gem = Gems::where('item_id', $request->id)->first();
        // $new_tags = $request->tags;
        // $item_newtag = Item::where('id', $request->id)->first();
        // $item_newtagarray = explode(',', $item_newtag->tags);
        // $newcollection = collect($item_newtagarray);
        // $newoutput = $newcollection->implode(',');

        // $changes = $change->getChanges();

        // $items_edit_detail_logs = new ItemsEditDetailLogs();
        // // return dd($item_tag['tags']);

        // $items_edit_detail_logs->tags = $output;

        // if ($output == $newoutput) {
        //     $items_edit_detail_logs->new_tags = "-----";
        // } else {
        //     $items_edit_detail_logs->new_tags = $new_tags;
        // }

        // $items_edit_detail_logs->gems = $old_gem->gems;

        // if ($old_gem == $new_gem) {
        //     $items_edit_detail_logs->new_gems = "-----";
        // } else {
        //     $items_edit_detail_logs->new_gems = $new_gem->gems;
        // }

        // $items_edit_detail_logs->name = $old['name'];
        // if ($old['name'] == $change->name) {
        //     $items_edit_detail_logs->new_name = "-----";
        // } else {
        //     $items_edit_detail_logs->new_name = $changes['name'];
        // }
        // $items_edit_detail_logs->price = $old['price'];
        // if ($old['price'] == $change->price) {
        //     $items_edit_detail_logs->new_price = "-----";
        // } else {
        //     $items_edit_detail_logs->new_price = $changes['price'];
        // }
        // $items_edit_detail_logs->description = $old['description'];
        // if ($old['description'] == $change->description) {
        //     $items_edit_detail_logs->new_description = "-----";
        // } else {
        //     $items_edit_detail_logs->new_description = $changes['description'];
        // }
        // $items_edit_detail_logs->product_code = $old['product_code'];
        // if ($old['product_code'] == $change->product_code) {
        //     $items_edit_detail_logs->new_product_code = "-----";
        // } else {
        //     $items_edit_detail_logs->new_product_code = $changes['product_code'];
        // }
        // $items_edit_detail_logs->gold_quality = $old['gold_quality'];
        // if ($old['gold_quality'] == $change->gold_quality) {
        //     $items_edit_detail_logs->new_gold_quality = "-----";
        // } else {
        //     $items_edit_detail_logs->new_gold_quality = $changes['gold_quality'];
        // }
        // $items_edit_detail_logs->gold_colour = $old['gold_colour'];
        // if ($old['gold_colour'] == $change->gold_colour) {
        //     $items_edit_detail_logs->new_gold_colour = "-----";
        // } else {
        //     $items_edit_detail_logs->new_gold_colour = $changes['gold_colour'];
        // }
        // //   $items_edit_detail_logs->sizing_guide = $old['sizing_guide'];
        // //   if($changes == []){
        // //         $items_edit_detail_logs->new_sizing_guide = "-----";
        // //   }else{
        // //       $items_edit_detail_logs->new_sizing_guide = $changes['sizing_guide'];
        // //   }
        // $items_edit_detail_logs->undamage = $old['undamaged_product'];
        // if ($old['undamaged_product'] == $change->undamaged_product) {
        //     $items_edit_detail_logs->new_undamage = "-----";
        // } else {
        //     $items_edit_detail_logs->new_undamage = $changes['undamaged_product'];
        // }
        // $items_edit_detail_logs->expensive_thing = $old['valuable_product'];
        // if ($old['valuable_product'] == $change->valuable_product) {
        //     $items_edit_detail_logs->new_expensive_thing = "-----";
        // } else {
        //     $items_edit_detail_logs->new_expensive_thing = $changes['valuable_product'];
        // }
        // $items_edit_detail_logs->damage = $old['damaged_product'];
        // if ($old['damaged_product'] == $change->damaged_product) {
        //     $items_edit_detail_logs->new_damage = "-----";
        // } else {
        //     $items_edit_detail_logs->new_damage = $changes['damaged_product'];
        // }
        // $items_edit_detail_logs->weight = $old['weight'];
        // if ($old['weight'] == $change->weight) {
        //     $items_edit_detail_logs->new_weight = "-----";
        // } else {
        //     $items_edit_detail_logs->new_weight = $changes['weight'];
        // }
        // //   $items_edit_detail_logs->weight_unit = $old['weight_unit'];
        // //   if($changes == []){
        // //         $items_edit_detail_logs->new_weight_unit = "-----";
        // //   }else{
        // //       $items_edit_detail_logs->new_weight_unit = $changes['weight_unit'];
        // //   }

        // $items_edit_detail_logs->min_price = $old['min_price'];
        // if ($old['min_price'] == $change->min_price) {
        //     $items_edit_detail_logs->new_min_price = "-----";
        // } else {
        //     $items_edit_detail_logs->new_min_price = $changes['min_price'];
        // }
        // $items_edit_detail_logs->max_price = $old['max_price'];
        // if ($old['max_price'] == $change->max_price) {
        //     $items_edit_detail_logs->new_max_price = "-----";
        // } else {
        //     $items_edit_detail_logs->new_max_price = $changes['max_price'];
        // }
        // $items_edit_detail_logs->review = $old['review'];
        // if ($old['review'] == $change->review) {
        //     $items_edit_detail_logs->new_review = "-----";
        // } else {
        //     $items_edit_detail_logs->new_review = $changes['review'];
        // }
        // $items_edit_detail_logs->stock = $old['stock'];
        // if ($old['stock'] == $change->stock) {
        //     $items_edit_detail_logs->new_stock = "-----";
        // } else {
        //     $items_edit_detail_logs->new_stock = $changes['stock'];
        // }
        // $items_edit_detail_logs->stock_count = $old['stock_count'];
        // if ($old['stock_count'] == $change->stock_count) {
        //     $items_edit_detail_logs->new_stock_count = "-----";
        // } else {
        //     $items_edit_detail_logs->new_stock_count = $changes['stock_count'];
        // }
        // $items_edit_detail_logs->diamond = $old['diamond'];
        // if ($old['diamond'] == $change->diamond) {
        //     $items_edit_detail_logs->new_diamond = "-----";
        // } else {
        //     $items_edit_detail_logs->new_diamond = $changes['diamond'];
        // }
        // $items_edit_detail_logs->carat = $old['carat'];
        // if ($old['carat'] == $change->carat) {
        //     $items_edit_detail_logs->new_carat = "-----";
        // } else {
        //     $items_edit_detail_logs->new_carat = $changes['carat'];
        // }
        // $items_edit_detail_logs->yati = $old['yati'];
        // if ($old['yati'] == $change->yati) {
        //     $items_edit_detail_logs->new_yati = "-----";
        // } else {
        //     $items_edit_detail_logs->new_yati = $changes['yati'];
        // }
        // $items_edit_detail_logs->gender = $old['gender'];
        // if ($old['gender'] == $change->gender) {
        //     $items_edit_detail_logs->new_gender = "-----";
        // } else {
        //     $items_edit_detail_logs->new_gender = $changes['gender'];
        // }
        // $items_edit_detail_logs->handmade = $old['handmade'];
        // if ($old['handmade'] == $change->handmade) {
        //     $items_edit_detail_logs->new_handmade = "-----";
        // } else {
        //     $items_edit_detail_logs->new_handmade = $changes['handmade'];
        // }
        // $items_edit_detail_logs->pwint = $old['pwint'];
        // if ($old['pwint'] == $change->pwint) {
        //     $items_edit_detail_logs->new_pwint = "-----";
        // } else {
        //     $items_edit_detail_logs->new_pwint = $changes['pwint'];
        // }
        // $items_edit_detail_logs->d_gram = $old['d_gram'];
        // if ($old['d_gram'] == $change->d_gram) {
        //     $items_edit_detail_logs->new_d_gram = "-----";
        // } else {
        //     $items_edit_detail_logs->new_d_gram = $changes['d_gram'];
        // }
        // $items_edit_detail_logs->category_id = $old['category_id'];
        // if ($old['category_id'] == $change->category_id) {
        //     $items_edit_detail_logs->new_category_id = "-----";
        // } else {
        //     $items_edit_detail_logs->new_category_id = $changes['category_id'];
        // }
        // $items_edit_detail_logs->view_count = $old['view_count'];
        // if ($old['view_count'] == $change->view_count) {
        //     $items_edit_detail_logs->new_view_count = "-----";
        // } else {
        //     $items_edit_detail_logs->new_view_count = $changes['view_count'];
        // }
        // $items_edit_detail_logs->charge = $old['charge'];
        // if ($old['charge'] == $change->charge) {
        //     $items_edit_detail_logs->new_charge = "-----";
        // } else {
        //     $items_edit_detail_logs->new_charge = $changes['charge'];
        // }
        // $items_edit_detail_logs->collection_id = $old['collection_id'];
        // if ($old['collection_id'] == $change->collection_id) {
        //     $items_edit_detail_logs->new_collection_id = "-----";
        // } else {
        //     $items_edit_detail_logs->new_collection_id = $changes['collection_id'];
        // }
        // $items_edit_detail_logs->user_id = $old['user_id'];
        // $items_edit_detail_logs->shop_id = $old['shop_id'];
        // $items_edit_detail_logs->shopownereditlogs_id = $shopownerlogid->id;
        // $items_edit_detail_logs->save();

        Session::flash('message', 'Your item was successfully updated');
        return response()->json(['msg' => 'success', 'id' => $request->id]);
    }

    public function multiple_update_minus(MultiplePriceUpdateRequest $request): JsonResponse
    {
        $plus_price = $request->price;

        foreach ($request->id as $id) {
            $item = Item::findOrfail($id);
            $shop_id = $this->get_shopid();

            $this->MultipleMinusPriceLogs($item, $plus_price, $shop_id);
            $this->minus($item, $request);
        }
        $items = Item::whereIn('id', $request->id)->get();
        Session::flash('message', 'Your items were successfully edited');

        return response()->json(
            [
                'data' => $this->err_data,
                'items' => $items,
            ]
        );
    }

    public function multiple_update_recap(ItemsRecapUpdateRequest $request): JsonResponse
    {
        $old_percent = $request;
        foreach ($request->id as $id) {
            $item = Item::findOrfail($id);
            $shop_id = $this->get_shopid();

            // return dd($item);
            $this->MultipleDamageLogs($item, $old_percent, $shop_id);
            // $item->user_id = $user_id;
            $this->get_multiple_recap($item, $old_percent);
        }

        $items = Item::whereIn('id', $request->id)->get();

        Session::flash('message', 'Your items were successfully edited');

        return response()->json(
            [
                'items' => $items,
            ]
        );
    }

    public function multiple_update_plus(MultiplePriceUpdateRequest $request): JsonResponse
    {

        $plus_price = $request->price;
        foreach ($request->id as $id) {
            $item = Item::findOrfail($id);
            $shop_id = $this->get_shopid();

            $this->MultiplePlusPriceLogs($item, $plus_price, $shop_id);
            $this->plus($item, $request);
        }
        $items = Item::whereIn('id', $request->id)->get();

        Session::flash('message', 'Your items were successfully edited');
        return response()->json(
            [
                'success' => true,
                'data' => $request->data,
                'items' => $items,
            ],

        );
    }

    public function multiple_stock(Request $request): RedirectResponse
    {

        if ($request->stock === "In Stock") {

            $request->validate([
                "count" => "required|integer|min:0|max:1000",
            ]);
        }

        $change_request_array = explode(",", $request->multipleStockId);

        foreach ($change_request_array as $id) {

            $items = Item::find($id);
            $items->stock = $request->stock;
            if ($request->count) {
                $items->stock_count = $request->count;
            }
            $items->update();
        }
        //  Session::flash('message', 'Your Discount Item was successfully unset');

        return redirect()->back();
    }

    public function validatorformultiupdate($data): Validator
    {
        $message = [
            'price.min' => 'Price သည် 1 ထပ် မငယ်ရ', 'price.numeric' => 'Price သည် number ဖြစ်ရမည်', 'အလျော့တွက်.min' => 'အလျော့တွက်သည် 0 ထပ် မငယ်ရ',
            'အလျော့တွက်.numeric' => 'အလျော့တွက်သည် number ဖြစ်ရမည်',

            'လက်ခ.min' => 'လက်ခသည် 0 ထပ် မငယ်ရ',
            'လက်ခ.numeric' => 'လက်ခသည် number ဖြစ်ရမည်',

            'undamaged_product.min' => 'အထည်မပျက်ပြန်သွင်းသည် 0 ထပ် မငယ်ရ',
            'undamaged_product.numeric' => 'အထည်မပျက်ပြန်သွင်းသည် number ဖြစ်ရမည်',

            'damaged_product.min' => 'အထည်ပျက်စီးချို့ယွင်းသည် 0 ထပ် မငယ်ရ',
            'damaged_product.numeric' => 'အထည်ပျက်စီးချို့ယွင်းသည် number ဖြစ်ရမည်',

            'valuable_product.min' => 'တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲသည် 0 ထပ် မငယ်ရ',
            'valuable_product.numeric' => 'တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲသည် number ဖြစ်ရမည်',
        ];

        return Validator::make($data, [
            'price' => ['numeric', 'min:1'],
            'အလျော့တွက်' => ['numeric', 'min:0', 'max:90'],
            'လက်ခ' => ['numeric', 'min:0', 'max:90'],
            'undamaged_product' => ['numeric', 'min:0', 'max:90'],
            'damaged_product' => ['numeric', 'min:0', 'max:90'],
            'valuable_product' => ['numeric', 'min:0', 'max:90'],
        ], $message);
    }

    public function check_price_after_update_click(Request $request): JsonResponse
    {

        $validator = $this->validatorformultiupdate($request->all());
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'data' => $validator->errors()]);
        }

        $willupdatepricelist = [];
        if ($request->price != '') {

            foreach ($request->id as $key => $value) {
                $item = Item::where('id', $value)->first();
                $disitem = 'no';
                $disprice = 0;
                $dismin = 0;
                $dismax = 0;
                $plus_price = 0;
                $minPrice = 0;
                $maxPrice = 0;
                $fromdisprice = '----';

                if ($request->oper == 'plus') {
                    $plus_price = $item->price + $request->price;
                    $minPrice = $item->min_price + $request->price;
                    $maxPrice = $item->max_price + $request->price;
                } else {
                    $plus_price = $item->price - $request->price;
                    $minPrice = $item->min_price - $request->price;
                    $maxPrice = $item->max_price - $request->price;
                }
                if ($item->ykget_discount !== 0) {
                    $disitem = 'yes';
                    if ($item->ykget_discount->base == 'price') {
                        if ($item->ykget_discount->discount_price != 0) {
                            $fromdisprice = $item->ykget_discount->discount_price;

                            $disprice = $plus_price - $item->ykget_discount->dec_price;
                            $dismin = 0;
                            $dismax = 0;
                        } else {
                            $fromdisprice = $item->ykget_discount->discount_min . '--' . $item->ykget_discount->discount_max;

                            $disprice = 0;
                            $dismin = $minPrice - $item->ykget_discount->dec_price;
                            $dismax = $maxPrice - $item->ykget_discount->dec_price;
                        }
                    } else {
                        if ($item->ykget_discount->discount_price != 0) {
                            $fromdisprice = $item->ykget_discount->discount_price;
                            $disprice = round($plus_price - (($plus_price * $item->ykget_discount->percent) / 100));
                            $dismin = 0;
                            $dismax = 0;
                        } else {
                            $fromdisprice = $item->ykget_discount->discount_min . '--' . $item->ykget_discount->discount_max;

                            $disprice = 0;
                            $dismin = round($minPrice - (($minPrice * $item->ykget_discount->percent) / 100));
                            $dismax = round($maxPrice - (($maxPrice * $item->ykget_discount->percent) / 100));
                        }
                    }
                }

                if ($item->price != 0) {
                    $willupdatepricelist[$key] = ['fromdisprice' => $fromdisprice, 'disitem' => $disitem, 'disprice' => $disprice, 'dismin' => $dismin, 'dismax' => $dismax, 'id' => $item->id, 'name' => $item->name, 'product_code' => $item->product_code, 'orgprice' => $item->price, 'orgmin' => 0, 'orgmax' => 0, 'price' => $plus_price, 'min' => 0, 'max' => 0];
                } else {
                    $willupdatepricelist[$key] = ['fromdisprice' => $fromdisprice, 'disitem' => $disitem, 'disprice' => $disprice, 'dismin' => $dismin, 'dismax' => $dismax, 'id' => $item->id, 'name' => $item->name, 'product_code' => $item->product_code, 'price' => 0, 'min' => $minPrice, 'max' => $maxPrice, 'orgprice' => 0, 'orgmin' => $item->min_price, 'orgmax' => $item->max_price];
                }
            }
            return response()->json(['status' => 'success', 'data' => $willupdatepricelist]);
        } else {
            return response()->json(['status' => 'onlypercent']);
        }
    }

    //for detail of specified item
    public function show($id): View
    {
        $slides = Item::select('photo_one', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_six', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten')->get();
        $photo = Item::where('id', $id)->get(['photo_one', 'photo_two', 'photo_three', 'photo_four', 'photo_five', 'photo_six', 'photo_seven', 'photo_eight', 'photo_nine', 'photo_ten']);
        $photos = $photo;
        $item_id = Item::findOrFail($id)->shop_id;

        $item = Item::where('id', $id)->first();

        return view('backend.shopowner.item.detail', ['shopowner' => $this->current_shop_data(), 'item' => $item, 'photos' => $photos, 'slides' => $slides]);
    }

    //for delete function of specified item
    public function destroy($id): RedirectResponse
    {
        dd($id);
        $shop_id = $this->get_shopid();
        $item = Item::where('id', $id)->where('shop_id', $shop_id)->delete();
        $this->ShopsDeleteLog($item, $shop_id);
        // $shopowner_log = Item::where('id', $id)->get();

        // $item_log = ItemLogActivity::where('item_id', $id);

        if (discount::where('item_id', $id)->count() > 0) {
            discount::where('item_id', $id)->delete();
        }
        // if (Auth::guard('shop_role')->check()) {
        //     $this->role('shop_role');
        //     if (TzGate::allows($item_id == $this->role_shop_id)) {
        //         $item->delete();
        //         $item_log->delete();
        //     }
        //     $shop_id = $this->role_shop_id;
        // } else {
        //     $this->role('shop_owner');

        //     if (TzGate::allows($item_id == $this->role)) {
        //         $item->delete();
        //         $item_log->delete();
        //     }
        //     $shop_id = "yahoo";
        // }
        // $shopownerlogid = $this->ShopsDeleteLog($shopowner_log, $shop_id);

        return redirect(url('backside/shop_owner/items'))->with(['status' => 'success', 'message' => 'Your Item was successfully Deleted']);
    }

    public function trash(): View
    {
        return view('backend.shopowner.item.trash');
    }

    public function get_items_trash(Request $request): JsonResponse
    {
        $shop_id = $this->get_shopid();

        $records = Item::select('id', 'product_code', 'default_photo', 'price', 'deleted_at')
            ->where('shop_id', $shop_id)->onlyTrashed();

        return DataTables::of($records)
            ->addColumn('price_formatted', function ($record) {
                return ($record->price != 0) ? $record->price : $record->short_price;
            })
            ->addColumn('action', fn($record) => $record->id)
            ->addColumn('deleted_at', function ($record) {
                return $record->deleted_at ? $record->deleted_at->format('F d, Y ( h:i A )') : '';
            })
            ->toJson();
    }

    public function restore($id): RedirectResponse
    {

        Item::onlyTrashed()->where('id', $id)->where('shop_id', $this->get_shopid())->restore();
        discount::onlyTrashed()->where('item_id', $id)->where('shop_id', $this->get_shopid())->restore();
        Session::flash('message', 'Your item was successfully restored');

        return redirect('backside/shop_owner/items_trash');
    }

    public function force_delete($id): RedirectResponse
    {

        discount::onlyTrashed()->where('item_id', $id)->where('shop_id', $this->get_shopid())->forceDelete();
        $this->items_photos_delete($id);
        $forceDeletedItem = Item::onlyTrashed()->where('id', $id)->where('shop_id', $this->get_shopid())->first();
        $forceDeletedItem->forceDelete();
        $this->ShopsForceDeleteLog($forceDeletedItem, $this->get_shopid());

        Session::flash('message', 'Your item was successfully hard deleted ');

        return redirect()->back();
    }

    public function from_detail_edit(Request $request)
    {
        $input = $request->except('_token', '_method', 'id');
        $id = $request->input('id');
        if (($request->input('price')) != null) {
            $this->validate($request, [
                'product_code' => 'required|gt:0',
                'stock_count' => 'required|numeric|gt:0',
                'price' => 'required|numeric',
            ]);
        } elseif (($request->input('max_price')) != null) {
            $this->validate($request, [
                'product_code' => 'required|gt:0',
                'stock_count' => 'required|numeric|gt:0',
                'min_price' => 'required|numeric',
                'max_price' => 'required|numeric',
            ]);
        }
        $item = DB::table('items')->where('id', $id);
        $query = $item->update($input);
        Session::flash('message', 'Your item was successfully updated');
        return redirect()->back();
    }

    public function only_price_update(Request $request): JsonResponse
    {

        $request->validate([
            'price' => 'required',
        ]);

        $price = explode("-", $request->price);

        $item = Item::find($request->id);
        if (count($price) > 1) {
            if ($price[0] < $price[1]) {
                $item->price = 0;
                $item->min_price = $price[0];
                $item->max_price = $price[1];
                $item->update();
            } else {
                return redirect()->back()->withErrors('wrong_price', 'In Valid Price');
            }
        } else {
            $item->price = $request->price;
            $item->update();
        }

        return response()->json([
            'success' => true,
            'data' => $price,
        ]);
    }
}
