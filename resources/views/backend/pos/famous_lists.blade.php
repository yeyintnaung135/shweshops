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
                    <div class="col-4">
                        <div class="row d-flex">
                            <h4 class="text-color">​​ရောင်းအားအ​​ကောင်းဆုံးပစ္စည်းများ</h4>              
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
                                    အားလုံး
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
                            <li class=" nav-item">
                                <a href="#navpills-6" class="nav-link" data-toggle="tab" aria-expanded="false">
                                    ​အ​ခေါက်​ရွှေ
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-7" class="nav-link" data-toggle="tab" aria-expanded="false">
                                    ​၁၅ ပဲရည်
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-8" class="nav-link" data-toggle="tab" aria-expanded="false">
                                    ​၁၄ ပဲ ၂ ပြား
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-9" class="nav-link" data-toggle="tab" aria-expanded="false">
                                    ​​၁၄ ပဲရည်
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-10" class="nav-link" data-toggle="tab" aria-expanded="false">
                                    ၁၃ ပဲရည်
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-11" class="nav-link" data-toggle="tab" aria-expanded="false">
                                    ၁၂ ပဲရည်
                                </a>
                            </li>
                            @foreach ($categories as $cate)
                            <li class=" nav-item">
                                <a href="#navpill-{{$cate->id}}" class="nav-link" data-toggle="tab" aria-expanded="false">
                                    {{$cate->mm_name}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="tab-content br-n pn">
                            <div id="navpills-1" class="tab-pane active">
                                <div class=" table-responsive text-black mt-3">
                                                                       <table class="table table-striped example23">
                                        <thead>
                                            <th style="max-width: 40px;">နံပါတ်</th>
                                            <th>အမျိုးအမည်</th>
                                            <th>အ​ရောင်း</th>
                                            <th>လက်ကျန်</th>
                                            {{-- <th></th> --}}
                                        </thead>
                                        <tbody class="text-center" id="filter">
                                            <?php $i = 1;?>
                                            @foreach ($qty as $q)
                                            @foreach ($purchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 1)
                                            <?php  $arr = explode ("/",$purchase->purchase->product_gram_kyat_pe_yway); ?>
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                             <td>{{$i++}}</td>
                                             <td>
                                                {{$purchase->purchase->gold_name}}-{{$purchase->purchase->code_number}} -
                                                {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}-{{$purchase->purchase->category->mm_name}}
                                            </td>
                                             <td>{{$q->qty}}</td>
                                             <td>{{$purchase->purchase->stock_qty}}</td>  
                                             {{-- <td>
                                                 <a href="#myModal5{{$purchase->id}}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a> 
                                                <a href="{{route('backside.shop_owner.pos.edit_goldsale',$purchase->id)}}" class="ml-2 text-warning"><i class="fa fa-edit" ></i></a>
                                                <a href="{{route('backside.shop_owner.pos.detail_goldsale',$purchase->id)}}" class="ml-2 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                             </td> --}}
            
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
                                            @endif
                                            @endforeach
                                            @endforeach
                                            
                                            @foreach ($qty as $q)
                                            @foreach ($kyoutpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 2)
                                            <?php  $arr = explode ("/",$purchase->purchase->gold_gram_kyat_pe_yway); ?>
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                             <td>{{$i++}}</td>
                                             <td>
                                                {{$purchase->purchase->gold_name}}-{{$purchase->purchase->code_number}}-
                                                {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}-{{$purchase->purchase->category->mm_name}}
                                            </td>
                                             <td>{{$q->qty}}</td>
                                             
                                             <td>{{$purchase->purchase->stock_qty}}</td>   
                                             
                                             {{-- <td>
                                                <a href="#myModal6{{$purchase->id}}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a>
                                                <a href="{{route('backside.shop_owner.pos.edit_kyoutsale',$purchase->id)}}" class="ml-2 text-warning"><i class="fa fa-edit" ></i></a>
                                                <a href="{{route('backside.shop_owner.pos.detail_kyoutsale',$purchase->id)}}" class="ml-2 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                             </td> --}}
            
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
                                            @endif
                                            @endforeach
                                            @endforeach

                                            @foreach ($qty as $q)
                                            @foreach ($platinumpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 3)
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                             <td>{{$i++}}</td>
                                             <td>
                                                {{$purchase->purchase->platinum_name}}-{{$purchase->purchase->code_number}}
                                                {{$purchase->purchase->product_gram}} g-{{$purchase->purchase->category->mm_name}}
                                            </td>
                                             <td>{{$q->qty}}</td>
                                             
                                             <td>{{$purchase->purchase->stock_qty}}</td>  
                                           
                                             {{-- <td>
                                                 <a href="#myModal7{{$purchase->id}}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a> 
                                                <a href="{{route('backside.shop_owner.pos.edit_ptmsale',$purchase->id)}}" class="ml-2 text-warning"><i class="fa fa-edit" ></i></a>
                                                <a href="{{route('backside.shop_owner.pos.detail_ptmsale',$purchase->id)}}" class="ml-2 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                             </td> --}}
            
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
                                            @endif
                                            @endforeach
                                            @endforeach

                                            @foreach ($qty as $q)
                                            @foreach ($whitegoldpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 4)
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                             <td>{{$i++}}</td>
                                             <td>
                                                {{$purchase->purchase->whitegold_name}}-{{$purchase->purchase->code_number}}
                                                {{$purchase->purchase->product_gram}} g-{{$purchase->purchase->category->mm_name}}
                                            </td>
            
                                             <td>{{$q->qty}}</td>
                                             
                                             <td>{{$purchase->purchase->stock_qty}}</td>  
                                            
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="navpills-2" class="tab-pane">
                                <div class=" table-responsive text-black mt-3">
                                    <table class="table table-striped example23">
                                        <thead>
                                            <th style="max-width: 40px;">နံပါတ်</th>
                                            <th>အမျိုးအမည်</th>
                                            <th>အ​ရောင်း</th>
                                            <th>လက်ကျန်</th>
                                            {{-- <th></th> --}}
                                        </thead>
                                        <tbody class="text-center" id="filter">
                                            <?php $i = 1;?>
                                            @foreach ($qty as $q)
                                            @foreach ($purchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 1)
                                            <?php  $arr = explode ("/",$purchase->purchase->product_gram_kyat_pe_yway); ?>
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                                <td>{{$i++}}</td>
                                                <td>
                                                   {{$purchase->purchase->gold_name}}-{{$purchase->purchase->code_number}} -
                                                   {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                   {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                   {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}-{{$purchase->purchase->category->mm_name}}
                                               </td>
                                                <td>{{$q->qty}}</td>
                                                <td>{{$purchase->purchase->stock_qty}}</td>  
                                             
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
                                           
            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="navpills-3" class="tab-pane">
                                <div class=" table-responsive text-black mt-3">
                                    <table class="table table-striped example23">
                                        <thead>
                                            <th style="max-width: 40px;">နံပါတ်</th>
                                            <th>အမျိုးအမည်</th>
                                            <th>အ​ရောင်း</th>
                                            <th>လက်ကျန်</th>
                                            {{-- <th></th> --}}
                                        </thead>
                                        <tbody class="text-center" id="filter">
                                            <?php $i = 1;?>
                                            @foreach ($qty as $q)
                                            @foreach ($kyoutpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 2)
                                            <?php  $arr = explode ("/",$purchase->purchase->gold_gram_kyat_pe_yway); ?>
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                                <td>{{$i++}}</td>
                                                <td>
                                                   {{$purchase->purchase->gold_name}}-{{$purchase->purchase->code_number}}-
                                                   {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                   {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                   {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}-{{$purchase->purchase->category->mm_name}}
                                               </td>
                                                <td>{{$q->qty}}</td>
                                                
                                                <td>{{$purchase->purchase->stock_qty}}</td>
                                            
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
            
                                        </tbody>
                                    </table>
                                    </div>
                            </div>
                            <div id="navpills-4" class="tab-pane">
                                <div class=" table-responsive text-black mt-3">
                                    <table class="table table-striped example23">
                                        <thead>
                                            <th style="max-width: 40px;">နံပါတ်</th>
                                            <th>အမျိုးအမည်</th>
                                            <th>အ​ရောင်း</th>
                                            <th>လက်ကျန်</th>
                                            {{-- <th></th> --}}
                                        </thead>
                                        <tbody class="text-center" id="filter">
                                            <?php $i = 1;?>
                                            @foreach ($qty as $q)
                                            @foreach ($platinumpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 3)
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                                <td>{{$i++}}</td>
                                                <td>
                                                   {{$purchase->purchase->platinum_name}}-{{$purchase->purchase->code_number}}
                                                   {{$purchase->purchase->product_gram}} g-{{$purchase->purchase->category->mm_name}}
                                               </td>
                                                <td>{{$q->qty}}</td>
                                                
                                                <td>{{$purchase->purchase->stock_qty}}</td> 
                                             
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
            
                                        </tbody>
                                    </table>
                                    </div>
                            </div>
                            <div id="navpills-5" class="tab-pane">
                                <div class=" table-responsive text-black mt-3">
                                    <table class="table table-striped example23">
                                        <thead>
                                            <th style="max-width: 40px;">နံပါတ်</th>
                                            <th>အမျိုးအမည်</th>
                                            <th>အ​ရောင်း</th>
                                            <th>လက်ကျန်</th>
                                            {{-- <th></th> --}}
                                        </thead>
                                        <tbody class="text-center" id="filter">
                                            <?php $i = 1;?>
                                            @foreach ($qty as $q)
                                            @foreach ($whitegoldpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 4)
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                                <td>{{$i++}}</td>
                                                <td>
                                                   {{$purchase->purchase->whitegold_name}}-{{$purchase->purchase->code_number}}
                                                   {{$purchase->purchase->product_gram}} g-{{$purchase->purchase->category->mm_name}}
                                               </td>
                                                <td>{{$q->qty}}</td>
                                                
                                                <td>{{$purchase->purchase->stock_qty}}</td> 
                                            
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
            
                                        </tbody>
                                    </table>
                                    </div>
                            </div>
                            <div id="navpills-6" class="tab-pane">
                                <div class=" table-responsive text-black mt-3">
                                    <table class="table table-striped example23">
                                        <thead>
                                            <th style="max-width: 40px;">နံပါတ်</th>
                                            <th>အမျိုးအမည်</th>
                                            <th>အ​ရောင်း</th>
                                            <th>လက်ကျန်</th>
                                        </thead>
                                        <tbody class="text-center" id="filter">
                                            <?php $i = 1;?>
                                            @foreach ($qty as $q)
                                            @foreach ($purchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 1 && $purchase->purchase->quality_id == 1)
                                            <?php  $arr = explode ("/",$purchase->purchase->product_gram_kyat_pe_yway); ?>
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                                <td>{{$i++}}</td>
                                                <td>
                                                   {{$purchase->purchase->gold_name}}-{{$purchase->purchase->code_number}} -
                                                   {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                   {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                   {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}-{{$purchase->purchase->category->mm_name}}
                                               </td>
                                                <td>{{$q->qty}}</td>
                                                <td>{{$purchase->purchase->stock_qty}}</td>  
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
                                            
                                            @foreach ($qty as $q)
                                            @foreach ($kyoutpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 2 && $purchase->purchase->quality_id == 1)
                                            <?php  $arr = explode ("/",$purchase->purchase->gold_gram_kyat_pe_yway); ?>
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                                <td>{{$i++}}</td>
                                                <td>
                                                   {{$purchase->purchase->gold_name}}-{{$purchase->purchase->code_number}}-
                                                   {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                   {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                   {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}-{{$purchase->purchase->category->mm_name}}
                                               </td>
                                                <td>{{$q->qty}}</td>
                                                
                                                <td>{{$purchase->purchase->stock_qty}}</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="navpills-7" class="tab-pane">
                                <div class=" table-responsive text-black mt-3">
                                    <table class="table table-striped example23">
                                        <thead>
                                             <th style="max-width: 40px;">နံပါတ်</th>
                                            <th>အမျိုးအမည်</th>
                                            <th>အ​ရောင်း</th>
                                            <th>လက်ကျန်</th>
                                        </thead>
                                        <tbody class="text-center" id="filter">
                                            <?php $i = 1;?>
                                            @foreach ($qty as $q)
                                            @foreach ($purchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 1 && ($purchase->purchase->quality_id == 2 || $purchase->purchase->quality_id == 3))
                                            <?php  $arr = explode ("/",$purchase->purchase->product_gram_kyat_pe_yway); ?>
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                                <td>{{$i++}}</td>
                                                <td>
                                                   {{$purchase->purchase->gold_name}}-{{$purchase->purchase->code_number}} -
                                                   {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                   {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                   {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}-{{$purchase->purchase->category->mm_name}}
                                               </td>
                                                <td>{{$q->qty}}</td>
                                                <td>{{$purchase->purchase->stock_qty}}</td>  
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
                                            
                                            @foreach ($qty as $q)
                                            @foreach ($kyoutpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 2 && ($purchase->purchase->quality_id == 2 || $purchase->purchase->quality_id == 3))
                                            <?php  $arr = explode ("/",$purchase->purchase->gold_gram_kyat_pe_yway); ?>
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                                <td>{{$i++}}</td>
                                                <td>
                                                   {{$purchase->purchase->gold_name}}-{{$purchase->purchase->code_number}}-
                                                   {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                   {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                   {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}-{{$purchase->purchase->category->mm_name}}
                                               </td>
                                                <td>{{$q->qty}}</td>
                                                
                                                <td>{{$purchase->purchase->stock_qty}}</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="navpills-8" class="tab-pane">
                                <div class=" table-responsive text-black mt-3">
                                         <table class="table table-striped example23">
                                        <thead>
                                             <th style="max-width: 40px;">နံပါတ်</th>
                                            <th>အမျိုးအမည်</th>
                                            <th>အ​ရောင်း</th>
                                            <th>လက်ကျန်</th>
                                        </thead>
                                        <tbody class="text-center" id="filter">
                                            <?php $i = 1;?>
                                            @foreach ($qty as $q)
                                            @foreach ($purchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 1 && ($purchase->purchase->quality_id == 6 || $purchase->purchase->quality_id == 7))
                                            <?php  $arr = explode ("/",$purchase->purchase->product_gram_kyat_pe_yway); ?>
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                                <td>{{$i++}}</td>
                                                <td>
                                                   {{$purchase->purchase->gold_name}}-{{$purchase->purchase->code_number}} -
                                                   {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                   {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                   {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}-{{$purchase->purchase->category->mm_name}}
                                               </td>
                                                <td>{{$q->qty}}</td>
                                                <td>{{$purchase->purchase->stock_qty}}</td>  
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
                                            
                                            @foreach ($qty as $q)
                                            @foreach ($kyoutpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 2 && ($purchase->purchase->quality_id == 6 || $purchase->purchase->quality_id == 7))
                                            <?php  $arr = explode ("/",$purchase->purchase->gold_gram_kyat_pe_yway); ?>
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                                <td>{{$i++}}</td>
                                                <td>
                                                   {{$purchase->purchase->gold_name}}-{{$purchase->purchase->code_number}}-
                                                   {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                   {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                   {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}-{{$purchase->purchase->category->mm_name}}
                                               </td>
                                                <td>{{$q->qty}}</td>
                                                
                                                <td>{{$purchase->purchase->stock_qty}}</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="navpills-9" class="tab-pane">
                                <div class=" table-responsive text-black mt-3">
                                        <table class="table table-striped example23">
                                        <thead>
                                             <th style="max-width: 40px;">နံပါတ်</th>
                                            <th>အမျိုးအမည်</th>
                                            <th>အ​ရောင်း</th>
                                            <th>လက်ကျန်</th>
                                        </thead>
                                        <tbody class="text-center" id="filter">
                                            <?php $i = 1;?>
                                            @foreach ($qty as $q)
                                            @foreach ($purchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 1 && ($purchase->purchase->quality_id == 4 || $purchase->purchase->quality_id == 5))
                                            <?php  $arr = explode ("/",$purchase->purchase->product_gram_kyat_pe_yway); ?>
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                                <td>{{$i++}}</td>
                                                <td>
                                                   {{$purchase->purchase->gold_name}}-{{$purchase->purchase->code_number}} -
                                                   {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                   {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                   {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}-{{$purchase->purchase->category->mm_name}}
                                               </td>
                                                <td>{{$q->qty}}</td>
                                                <td>{{$purchase->purchase->stock_qty}}</td>  
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
                                            
                                            @foreach ($qty as $q)
                                            @foreach ($kyoutpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 2 && ($purchase->purchase->quality_id == 4 || $purchase->purchase->quality_id == 5))
                                            <?php  $arr = explode ("/",$purchase->purchase->gold_gram_kyat_pe_yway); ?>
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                                <td>{{$i++}}</td>
                                                <td>
                                                   {{$purchase->purchase->gold_name}}-{{$purchase->purchase->code_number}}-
                                                   {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                   {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                   {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}-{{$purchase->purchase->category->mm_name}}
                                               </td>
                                                <td>{{$q->qty}}</td>
                                                
                                                <td>{{$purchase->purchase->stock_qty}}</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="navpills-10" class="tab-pane">
                                <div class=" table-responsive text-black mt-3">
                                        <table class="table table-striped example23">
                                        <thead>
                                             <th style="max-width: 40px;">နံပါတ်</th>
                                            <th>အမျိုးအမည်</th>
                                            <th>အ​ရောင်း</th>
                                            <th>လက်ကျန်</th>
                                        </thead>
                                        <tbody class="text-center" id="filter">
                                            <?php $i = 1;?>
                                            @foreach ($qty as $q)
                                            @foreach ($purchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 1 && ($purchase->purchase->quality_id == 8 || $purchase->purchase->quality_id == 9))
                                            <?php  $arr = explode ("/",$purchase->purchase->product_gram_kyat_pe_yway); ?>
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                                <td>{{$i++}}</td>
                                                <td>
                                                   {{$purchase->purchase->gold_name}}-{{$purchase->purchase->code_number}} -
                                                   {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                   {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                   {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}-{{$purchase->purchase->category->mm_name}}
                                               </td>
                                                <td>{{$q->qty}}</td>
                                                <td>{{$purchase->purchase->stock_qty}}</td>  
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
                                            
                                            @foreach ($qty as $q)
                                            @foreach ($kyoutpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 2 && ($purchase->purchase->quality_id == 8 || $purchase->purchase->quality_id == 9))
                                            <?php  $arr = explode ("/",$purchase->purchase->gold_gram_kyat_pe_yway); ?>
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                                <td>{{$i++}}</td>
                                                <td>
                                                   {{$purchase->purchase->gold_name}}-{{$purchase->purchase->code_number}}-
                                                   {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                   {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                   {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}-{{$purchase->purchase->category->mm_name}}
                                               </td>
                                                <td>{{$q->qty}}</td>
                                                
                                                <td>{{$purchase->purchase->stock_qty}}</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="navpills-11" class="tab-pane">
                                <div class=" table-responsive text-black mt-3">
                                                                       <table class="table table-striped example23">
                                        <thead>
                                             <th style="max-width: 40px;">နံပါတ်</th>
                                            <th>အမျိုးအမည်</th>
                                            <th>အ​ရောင်း</th>
                                            <th>လက်ကျန်</th>
                                        </thead>
                                        <tbody class="text-center" id="filter">
                                            <?php $i = 1;?>
                                            @foreach ($qty as $q)
                                            @foreach ($purchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 1 && ($purchase->purchase->quality_id == 10 || $purchase->purchase->quality_id == 11))
                                            <?php  $arr = explode ("/",$purchase->purchase->product_gram_kyat_pe_yway); ?>
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                                <td>{{$i++}}</td>
                                                <td>
                                                   {{$purchase->purchase->gold_name}}-{{$purchase->purchase->code_number}} -
                                                   {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                   {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                   {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}-{{$purchase->purchase->category->mm_name}}
                                               </td>
                                                <td>{{$q->qty}}</td>
                                                <td>{{$purchase->purchase->stock_qty}}</td>  
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
                                            
                                            @foreach ($qty as $q)
                                            @foreach ($kyoutpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 2 && ($purchase->purchase->quality_id == 10 || $purchase->purchase->quality_id == 11))
                                            <?php  $arr = explode ("/",$purchase->purchase->gold_gram_kyat_pe_yway); ?>
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                                <td>{{$i++}}</td>
                                                <td>
                                                   {{$purchase->purchase->gold_name}}-{{$purchase->purchase->code_number}}-
                                                   {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                   {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                   {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}-{{$purchase->purchase->category->mm_name}}
                                               </td>
                                                <td>{{$q->qty}}</td>
                                                
                                                <td>{{$purchase->purchase->stock_qty}}</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @foreach ($categories as $cate)
                            <div id="navpill-{{$cate->id}}" class="tab-pane">
                                <div class=" table-responsive text-black mt-3">
                                                                       <table class="table table-striped example23">
                                        <thead>
                                            <th style="max-width: 40px;">နံပါတ်</th>
                                            <th>အမျိုးအမည်</th>
                                            <th>အ​ရောင်း</th>
                                            <th>လက်ကျန်</th>
                                            {{-- <th></th> --}}
                                        </thead>
                                        <tbody class="text-center" id="filter">
                                            <?php $i = 1;?>
                                            @foreach ($qty as $q)
                                            @foreach ($purchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 1 && $purchase->purchase->category_id == $cate->id)
                                            <?php  $arr = explode ("/",$purchase->purchase->product_gram_kyat_pe_yway); ?>
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                             <td>{{$i++}}</td>
                                             <td>
                                                {{$purchase->purchase->gold_name}}-{{$purchase->purchase->code_number}} -
                                                {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}-{{$purchase->purchase->category->mm_name}}
                                            </td>
                                             <td>{{$q->qty}}</td>
                                             <td>{{$purchase->purchase->stock_qty}}</td>  
                                            
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
                                            
                                            @foreach ($qty as $q)
                                            @foreach ($kyoutpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 2 && $purchase->purchase->category_id == $cate->id)
                                            <?php  $arr = explode ("/",$purchase->purchase->gold_gram_kyat_pe_yway); ?>
                                            <tr  class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                             <td>{{$i++}}</td>
                                             <td>
                                                {{$purchase->purchase->gold_name}}-{{$purchase->purchase->code_number}}-
                                                {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}-{{$purchase->purchase->category->mm_name}}
                                            </td>
                                             <td>{{$q->qty}}</td>
                                             
                                             <td>{{$purchase->purchase->stock_qty}}</td>   
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach

                                            @foreach ($qty as $q)
                                            @foreach ($platinumpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 3 && $purchase->purchase->category_id == $cate->id)
                                            <tr class="@if ($purchase->purchase->stock_qty < 1) @if ($purchase->purchase->stock_qty < 1) bg-red @endif @endif">
                                             <td>{{$i++}}</td>
                                             <td>
                                                {{$purchase->purchase->platinum_name}}-{{$purchase->purchase->code_number}}
                                                {{$purchase->purchase->product_gram}} g-{{$purchase->purchase->category->mm_name}}
                                            </td>
                                             <td>{{$q->qty}}</td>
                                             
                                             <td>{{$purchase->purchase->stock_qty}}</td>  
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach

                                            @foreach ($qty as $q)
                                            @foreach ($whitegoldpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 4 && $purchase->purchase->category_id == $cate->id)
                                            <tr class="@if ($purchase->purchase->stock_qty < 1) bg-red @endif">
                                             <td>{{$i++}}</td>
                                             <td>
                                                {{$purchase->purchase->whitegold_name}}-{{$purchase->purchase->code_number}}
                                                {{$purchase->purchase->product_gram}} g-{{$purchase->purchase->category->mm_name}}
                                            </td>
            
                                             <td>{{$q->qty}}</td>
                                             
                                             <td>{{$purchase->purchase->stock_qty}}</td>  
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endforeach
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
            
                $('.example23').DataTable({
                    dom: 'Blfrtip',
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
                    url = route('backside.shop_owner.pos.delete_goldsale',id);
                }
                if(type == 2){
                    url = route("backside.shop_owner.pos.delete_kyoutsale",id);
                }
                if(type == 3){
                    url = route("backside.shop_owner.pos.delete_ptm_sale",id);
                }
                if(type == 4){
                    url = route("backside.shop_owner.pos.delete_wg_sale",id);
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

    function chkTab(type){
        $.ajax({

        type:'POST',

        url: '{{route("backside.shop_owner.pos.tab_salelists")}}',

        data:{
        "_token":"{{csrf_token()}}",
        "type" : type,
        },

        success:function(data){
           $('#tab_amt').html(data.total);
           $('#tab_qty').html(data.qty);
        }
        })
    }
    
    function allTab(){
        $('#tab_amt').html($('#org_amt').val());
        $('#tab_qty').html($('#org_qty').val());
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

