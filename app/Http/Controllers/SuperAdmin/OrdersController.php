<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\Shops;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:super_admin']);
    }
    public function index(){
        return view('backend.super_admin.orders.index');

    }
    public function get_orders(Request $request)
    {

        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');
        if(empty($searchByFromdate)){
            $searchByFromdate=Carbon::now()->toDateString()." 00:00:00";
        }
        if(empty($searchByTodate)){
            $searchByTodate=Carbon::now()->toDateString()." 23:59:59";
        }

        $recordsQuery = Orders::with('items')->when($searchByFromdate, fn($query) => $query->whereDate('created_at', '>=', $searchByFromdate))
            ->when($searchByTodate, fn($query) => $query->whereDate('created_at', '<=', $searchByTodate))->get();
        return DataTables::of($recordsQuery)
            ->editColumn('created_at', fn($record) => $record->created_at->format('F d, Y ( h:i A )'))
            ->editColumn('product_name', fn($record) => $record->items->name)
            ->editColumn('action', fn($record) => $record->id)

            ->editColumn('product_code', fn($record) => $record->items->product_code)
            ->editColumn('shop_name', function($record){
            return Shops::select()->where('id',$record->items->shop_id)->first()->shop_name;
            })


            ->make(true);
    }
    public function detail($id){
        $order= Orders::with('items')->where('id',$id)->first();
        return view('backend.super_admin.orders.detail',['order'=>$order]);
    }
}
