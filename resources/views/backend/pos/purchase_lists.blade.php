@extends('layouts.backend.datatable')
@section('content')
    <div class="wrapper">
        <!-- Navbar -->
    @include('layouts.backend.pos_nav')
    <!-- /.navbar -->

        <!-- Main Sidebar Container -->
    @include('layouts.backend.pos_sidebar')

    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper sn-background-light-blue">
            @if(Session::has('message'))

                <x-alert>

                </x-alert>
        @endif
        <!-- Content Header (Page header) -->
        <section class="content-header sn-content-header">
            <div class="container-fluid">
                @foreach($shopowner as $shopowner )
                @endforeach


            </div><!-- /.container-fluid -->
        </section>

        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-7">
                        <div class="row d-flex">
                            <h4 class="text-color">အဝယ်စာရင်းများ</h4>
                        </div>
                        {{-- <div class="row mt-3">
                            <label for="">From:<input type="date" id="start_date"></label>
                            <label for="" class="ml-3">To:<input type="date" id="end_date"></label>
                            <label for="" style="margin-left: 20px;margin-top:30px;">
                                <a href="#" class="btn btn-color btn-m" onclick="goldtypefilter(2)">Search</a>
                            </label>
                        </div> --}}
                        
                    </div>
                    
                </div>

                <div class="card mt-4">

                    <div class="card-body">
                        <ul class="nav nav-pills m-t-30 m-b-30">
                            <li class="nav-item">
                                <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">
                                    အထည်အားလုံး
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">
                                    ​ရွှေထည်
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-3" class="nav-link" data-toggle="tab" aria-expanded="false">
                                    ​ကျောက်ထည်
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-4" class="nav-link" data-toggle="tab" aria-expanded="false">
                                    ပလက်တီနမ်
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-5" class="nav-link" data-toggle="tab" aria-expanded="false">
                                    ​ရွှေဖြူ
                                </a>
                            </li>
                        </ul>
                        <br />
                        <div class="tab-content br-n pn">
                            <div id="navpills-1" class="tab-pane active">
                                <div class=" table-responsive text-black">
                                    <table class="table table-striped" id="example23">
                                        <thead>
                                            <th>နံပါတ်</th>
                                            <th>အထည်အမည်</th>
                                            <th>ကုဒ်နံပါတ်</th>
                                            <th>အ​ရေအတွက်</th>
                                            <th>ဝယ်​​စျေးနှုန်း</th>
                                            <th>Product အ​လေးချိန်<br>(in MM units)</th>
                                            <th>Date</th>
                                            <th></th>
                                        </thead>
                                        <tbody class="text-center" id="filter">
                                            <?php $i = 1;?>
                                            @foreach ($purchases as $purchase)
                                            <?php  $arr = explode ("/",$purchase->product_gram_kyat_pe_yway); ?>
                                            <tr>
                                             <td>{{$i++}}</td>
                                             <td>{{$purchase->gold_name}}</td>
                                             <td>{{$purchase->code_number}}</td>
                                             <td>{{$purchase->stock_qty}}</td>
                                             <td>{{$purchase->gold_fee}}</td>
                                             <td>
                                                {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}
                                             </td>
                                             <td> ​
                                                {{$purchase->date}}
                                             </td>
                                             <td>
                                                 @if($purchase->sell_flag == 0)
                                                <a href="#myModal5{{$purchase->id}}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a>
                                                @endif
                                                <a href="{{route('backside.shop_owner.pos.edit_purchase',$purchase->id)}}" class="ml-2 text-warning"><i class="fa fa-edit" ></i></a>
                                                <a href="{{route('backside.shop_owner.pos.detail_purchase',$purchase->id)}}" class="ml-2 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                             </td>
            
                                             <div id="myModal5{{$purchase->id}}" class="modal">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete List</h5>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-center">Are you Sure to Delete this List?</p>
                                                        </div>
                                                        <div class="modal-footer text-center">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCLE</button>
                                                            <button type="button" class="btn btn-color" onclick="suredelete({{$purchase->id}},1)">DELETE</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </tr>
                                            @endforeach
                                            @foreach ($kyoutpurchases as $purchase)
                                            <?php  $arr = explode ("/",$purchase->gold_gram_kyat_pe_yway); ?>
                                            <tr>
                                             <td>{{$i++}}</td>
                                             <td>{{$purchase->gold_name}}</td>
                                             <td>{{$purchase->code_number}}</td>
                                             <td>{{$purchase->stock_qty}}</td>
                                             <td>{{$purchase->capital}}</td>
                                             <td>
                                                {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}
                                             </td>
                                             
                                             <td> ​
                                                {{$purchase->date}}
                                             </td>
                                             <td>
                                                @if($purchase->sell_flag == 0)
                                                <a href="#myModal6{{$purchase->id}}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a>
                                                @endif
                                                <a href="{{route('backside.shop_owner.pos.edit_kyout_purchase',$purchase->id)}}" class="ml-2 text-warning"><i class="fa fa-edit" ></i></a>
                                                <a href="{{route('backside.shop_owner.pos.detail_kyout_purchase',$purchase->id)}}" class="ml-2 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                             </td>
            
                                             <div id="myModal6{{$purchase->id}}" class="modal">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete List</h5>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-center">Are you Sure to Delete this List?</p>
                                                        </div>
                                                        <div class="modal-footer text-center">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCLE</button>
                                                            <button type="button" class="btn btn-color" onclick="suredelete({{$purchase->id}},2)">DELETE</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </tr>
                                            @endforeach
                                            @foreach ($platinumpurchases as $purchase)
                                            <tr>
                                             <td>{{$i++}}</td>
                                             <td>{{$purchase->platinum_name}}</td>
                                             <td>{{$purchase->code_number}}</td>
                                             <td>{{$purchase->stock_qty}}</td>
                                             <td>{{$purchase->capital}}</td>
                                             <td>{{$purchase->product_gram}} g</td>
                                             <td> ​
                                                {{$purchase->date}}
                                             </td>
                                             <td>
                                               @if($purchase->sell_flag == 0)
                                                <a href="#myModal7{{$purchase->id}}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a>
                                                @endif
                                                <a href="{{route('backside.shop_owner.pos.edit_ptm_purchase',$purchase->id)}}" class="ml-2 text-warning"><i class="fa fa-edit" ></i></a>
                                                <a href="{{route('backside.shop_owner.pos.detail_ptm_purchase',$purchase->id)}}" class="ml-2 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                             </td>
            
                                             <div id="myModal7{{$purchase->id}}" class="modal">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete List</h5>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-center">Are you Sure to Delete this List?</p>
                                                        </div>
                                                        <div class="modal-footer text-center">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCLE</button>
                                                            <button type="button" class="btn btn-color" onclick="suredelete({{$purchase->id}},3)">DELETE</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </tr>
                                            @endforeach
                                            @foreach ($whitegoldpurchases as $purchase)
                                            <tr>
                                             <td>{{$i++}}</td>
                                             <td>{{$purchase->whitegold_name}}</td>
                                             <td>{{$purchase->code_number}}</td>
                                             <td>{{$purchase->stock_qty}}</td>
                                             <td>{{$purchase->capital}}</td>
                                             <td>{{$purchase->product_gram}} g</td>
                                             <td> ​
                                                {{$purchase->date}}
                                             </td>
                                             <td>
                                                @if($purchase->sell_flag == 0)
                                                <a href="#myModal8{{$purchase->id}}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a>
                                                @endif
                                                <a href="{{route('backside.shop_owner.pos.edit_wg_purchase',$purchase->id)}}" class="ml-2 text-warning"><i class="fa fa-edit" ></i></a>
                                                <a href="{{route('backside.shop_owner.pos.detail_wg_purchase',$purchase->id)}}" class="ml-2 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                             </td>
            
                                             <div id="myModal8{{$purchase->id}}" class="modal">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete List</h5>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-center">Are you Sure to Delete this List?</p>
                                                        </div>
                                                        <div class="modal-footer text-center">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCLE</button>
                                                            <button type="button" class="btn btn-color" onclick="suredelete({{$purchase->id}},4)">DELETE</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </tr>
                                            @endforeach
            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="navpills-2" class="tab-pane">
                                <div class=" table-responsive text-black">
                                    <table class="table table-striped" id="example2">
                                        <thead>
                                            <th>နံပါတ်</th>
                                            <th>​ရွှေထည်အမည်</th>
                                            <th>ပန်းထိမ်ဆိုင်</th>
                                            <th>ကုဒ်နံပါတ်</th>
                                            <th>အ​ရေအတွက်</th>
                                            <th>Product အ​လေးချိန်<br>(in MM units)</th>
                                            <th>ပစ္စည်းတန်ဖိုး</th>
                                            <th>Date</th>
                                            <th></th>
                                        </thead>
                                        <tbody class="text-center" id="filter">
                                            <?php $i = 1;?>
                                            @foreach ($purchases as $purchase)
                                            <?php  $arr = explode ("/",$purchase->product_gram_kyat_pe_yway); ?>
                                            <tr>
                                             <td>{{$i++}}</td>
                                             <td>{{$purchase->gold_name}}</td>
                                             @if ($purchase->supplier_id)
                                             <td>{{$purchase->supplier->name}}</td>
                                             @else
                                             <td>-</td>
                                             @endif
            
                                             <td>{{$purchase->code_number}}</td>
                                             <td>{{$purchase->stock_qty}}</td>
                                             <td>
                                                {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}
                                             </td>
                                             <td>{{$purchase->gold_fee}}</td>
                                             <td> ​
                                                {{$purchase->date}}
                                             </td>
                                             <td>
                                                 @if($purchase->sell_flag == 0)
                                                <a href="#myModal1{{$purchase->id}}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a>
                                                @endif
                                                <a href="{{route('backside.shop_owner.pos.edit_purchase',$purchase->id)}}" class="ml-2 text-warning"><i class="fa fa-edit" ></i></a>
                                                <a href="{{route('backside.shop_owner.pos.detail_purchase',$purchase->id)}}" class="ml-2 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                             </td>
            
                                             <div id="myModal1{{$purchase->id}}" class="modal">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete List</h5>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-center">Are you Sure to Delete this List?</p>
                                                        </div>
                                                        <div class="modal-footer text-center">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCLE</button>
                                                            <button type="button" class="btn btn-color" onclick="suredelete({{$purchase->id}},1)">DELETE</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </tr>
                                            @endforeach
                                           
            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="navpills-3" class="tab-pane">
                                <div class=" table-responsive text-black">
                                    <table class="table table-striped" id="example3">
                                        <thead>
                                            <th>နံပါတ်</th>
                                            <th>​​ကျောက်ထည်အမည်</th>
                                            <th>ကုဒ်နံပါတ်</th>
                                            <th>အ​ရေအတွက်</th>
                                            <th>ပန်းထိမ်ဆိုင်</th>
                                            <th>စိန်​ကျောက်ချိန်<br>(in MM units)</th>
                                            <th>​ရွှေအရည်အ​သွေး</th>
                                            <th>ပစ္စည်းတန်ဖိုး</th>
                                            <th>Date</th>
                                            <th></th>
                                        </thead>
                                        <tbody class="text-center" id="filter">
                                            <?php $i = 1;?>
                                            @foreach ($kyoutpurchases as $purchase)
                                            <?php  $arr = explode ("/",$purchase->gold_gram_kyat_pe_yway); ?>
                                            <tr>
                                             <td>{{$i++}}</td>
                                             <td>{{$purchase->gold_name}}</td>
                                             <td>{{$purchase->code_number}}</td>
                                             <td>{{$purchase->stock_qty}}</td>
                                             <td>{{$purchase->supplier->name}}</td>
                                             <td>
                                                {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}
                                             </td>
                                             <td>{{$purchase->quality->name}}</td>
                                             <td>{{$purchase->capital}}</td>
                                             <td> ​
                                                {{$purchase->date}}
                                             </td>
                                             <td>
                                                @if($purchase->sell_flag == 0)
                                                <a href="#myModal2{{$purchase->id}}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a>
                                                @endif
                                                <a href="{{route('backside.shop_owner.pos.edit_kyout_purchase',$purchase->id)}}" class="ml-2 text-warning"><i class="fa fa-edit" ></i></a>
                                                <a href="{{route('backside.shop_owner.pos.detail_kyout_purchase',$purchase->id)}}" class="ml-2 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                             </td>
            
                                             <div id="myModal2{{$purchase->id}}" class="modal">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete List</h5>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-center">Are you Sure to Delete this List?</p>
                                                        </div>
                                                        <div class="modal-footer text-center">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCLE</button>
                                                            <button type="button" class="btn btn-color" onclick="suredelete({{$purchase->id}},2)">DELETE</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </tr>
                                            @endforeach
                                           
            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="navpills-4" class="tab-pane">
                                <div class=" table-responsive text-black">
                                    <table class="table table-striped" id="example4">
                                        <thead>
                                            <th>နံပါတ်</th>
                                            <th>​ပလက်တီနမ်အမည်</th>
                                            <th>ပလက်တီနမ်အရည်အ​သွေး</th>
                                            <th>ပလက်တီနမ်အမျိုးအစား</th>
                                            <th>ကုဒ်နံပါတ်</th>
                                            <th>အ​ရေအတွက်</th>
                                            <th>Product အ​လေးချိန်<br>(in gram)</th>
                                            <th>ပစ္စည်းတန်ဖိုး</th>
                                            <th>Date</th>
                                            <th></th>
                                        </thead>
                                        <tbody class="text-center" id="filter">
                                            <?php $i = 1;?>
                                            @foreach ($platinumpurchases as $purchase)
                                            <tr>
                                             <td>{{$i++}}</td>
                                             <td>{{$purchase->platinum_name}}</td>
                                             <td>{{$purchase->quality}}</td>
                                             <td>{{$purchase->platinum_type}}</td>
                                             <td>{{$purchase->code_number}}</td>
                                             <td>{{$purchase->stock_qty}}</td>
                                             <td>{{$purchase->product_gram}}</td>
                                             <td>{{$purchase->capital}}</td>
                                             <td> ​
                                                {{$purchase->date}}
                                             </td>
                                             <td>
                                               @if($purchase->sell_flag == 0)
                                                <a href="#myModal3{{$purchase->id}}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a>
                                                @endif
                                                <a href="{{route('backside.shop_owner.pos.edit_ptm_purchase',$purchase->id)}}" class="ml-2 text-warning"><i class="fa fa-edit" ></i></a>
                                                <a href="{{route('backside.shop_owner.pos.detail_ptm_purchase',$purchase->id)}}" class="ml-2 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                             </td>
            
                                             <div id="myModal3{{$purchase->id}}" class="modal">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete List</h5>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-center">Are you Sure to Delete this List?</p>
                                                        </div>
                                                        <div class="modal-footer text-center">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCLE</button>
                                                            <button type="button" class="btn btn-color" onclick="suredelete({{$purchase->id}},3)">DELETE</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </tr>
                                            @endforeach
            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="navpills-5" class="tab-pane">
                                <div class=" table-responsive text-black">
                                    <table class="table table-striped" id="example5">
                                        <thead>
                                            <th>နံပါတ်</th>
                                            <th>​ရွှေဖြူအမည်</th>
                                            <th>​ရွှေဖြူအရည်အ​သွေး</th>
                                            <th>​ရွှေဖြူအမျိုးအစား</th>
                                            <th>ကုဒ်နံပါတ်</th>
                                            <th>အ​ရေအတွက်</th>
                                            <th>Product အ​လေးချိန်<br>(in gram)</th>
                                            <th>ပစ္စည်းတန်ဖိုး</th>
                                            <th>Date</th>
                                            <th></th>
                                        </thead>
                                        <tbody class="text-center" id="filter">
                                            <?php $i = 1;?>
                                            @foreach ($whitegoldpurchases as $purchase)
                                            <tr>
                                             <td>{{$i++}}</td>
                                             <td>{{$purchase->whitegold_name}}</td>
                                             <td>{{$purchase->quality}}</td>
                                             <td>{{$purchase->whitegold_type}}</td>
                                             <td>{{$purchase->code_number}}</td>
                                             <td>{{$purchase->stock_qty}}</td>
                                             <td>{{$purchase->product_gram}}</td>
                                              <td>{{$purchase->capital}}</td>
                                             <td> ​
                                                {{$purchase->date}}
                                             </td>
                                             <td>
                                                @if($purchase->sell_flag == 0)
                                                <a href="#myModal4{{$purchase->id}}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a>
                                                @endif
                                                <a href="{{route('backside.shop_owner.pos.edit_wg_purchase',$purchase->id)}}" class="ml-2 text-warning"><i class="fa fa-edit" ></i></a>
                                                <a href="{{route('backside.shop_owner.pos.detail_wg_purchase',$purchase->id)}}" class="ml-2 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                             </td>
            
                                             <div id="myModal4{{$purchase->id}}" class="modal">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete List</h5>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-center">Are you Sure to Delete this List?</p>
                                                        </div>
                                                        <div class="modal-footer text-center">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCLE</button>
                                                            <button type="button" class="btn btn-color" onclick="suredelete({{$purchase->id}},4)">DELETE</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </tr>
                                            @endforeach
            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>    
                        
                    </div>
                </div>
            </div>
        </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    {{-- @include('layouts.backend.footer') --}}


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>

@endsection
@push('scripts')
    <script>

            $(document).ready(function() {
                $('#example23').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    processing: true,
                    "ordering": true,
                    "info": true,
                    "paging": true,
                });
                $('#example2').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    processing: true,
                    "ordering": true,
                    "info": true,
                    "paging": true,
                });
                $('#example3').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    processing: true,
                    "ordering": true,
                    "info": true,
                    "paging": true,
                });
                $('#example4').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    processing: true,
                    "ordering": true,
                    "info": true,
                    "paging": true,
                });
                $('#example5').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    processing: true,
                    "ordering": true,
                    "info": true,
                    "paging": true,
                });
            });
 
            function suredelete(id,type){
                if(type == 1){
                    url = '{{route("backside.shop_owner.pos.delete_purchase")}}';
                }
                if(type == 2){
                    url = '{{route("backside.shop_owner.pos.delete_kyout_purchase")}}';
                }
                if(type == 3){
                    url = '{{route("backside.shop_owner.pos.delete_ptm_purchase")}}';
                }
                if(type == 4){
                    url = '{{route("backside.shop_owner.pos.delete_wg_purchase")}}';
                }
                // alert(id);
                    $.ajax({

                        type:'POST',

                        url: url,

                        data:{
                        "_token":"{{csrf_token()}}",
                        "pid" : id,
                        },

                        success:function(data){
                            location.reload();
                            // console.log('success');
                        }
                    })


            }



    </script>
@endpush
@push('css')
    <style>
        body {
            background: #F0F7FA;
            font-family: 'Myanmar3', Sans-Serif !important;
        }
        .btn-color{
        background-color: #780116;
        color: white;
    }
    .btn-color:hover{
            color: white;
        }
    .text-color{
        color: #780116;
    }
    .nav-pills .nav-item .nav-link.active {
        background-color: #780116;
    color: #FFF;
    }

    </style>
@endpush

