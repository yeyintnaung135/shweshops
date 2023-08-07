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
                    <div class="col-8">
                        <div class="row d-flex">
                            <h4 class="text-color">ပစ္စည်းလက်ကျန်စာရင်းများ</h4>
                        </div>
                        {{-- <div class="row mt-3">
                            <label for="">From:<input type="date" id="start_date"></label>
                            <label for="" class="ml-3">To:<input type="date" id="end_date"></label>
                            <label for="" style="margin-left: 20px;margin-top:30px;">
                                <a href="#" class="btn btn-color btn-m" onclick="goldtypefilter(2)">Search</a>
                            </label>
                        </div> --}}
                        
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-color">စုစု​ပေါင်း</h6>
                                <h4 class="text-color">အ​ရေအတွက် &nbsp;&nbsp;<span  id="tab_qty">{{$tot_qty}}</span></h4>
                                <input type="hidden" value="{{$tot_qty}}" id="org_qty">
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="card mt-4">

                    <div class="card-body">
                        <ul class="nav nav-pills m-t-30 m-b-30">
                            <li class="nav-item">
                                <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false" onclick="allTab()">
                                    အထည်အားလုံး
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false" onclick="chkTab(2)">
                                    ​ရွှေထည်
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-3" class="nav-link" data-toggle="tab" aria-expanded="false" onclick="chkTab(3)">
                                    ​ကျောက်ထည်
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-4" class="nav-link" data-toggle="tab" aria-expanded="false" onclick="chkTab(4)">
                                    ပလက်တီနမ်
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-5" class="nav-link" data-toggle="tab" aria-expanded="false" onclick="chkTab(5)">
                                    ​ရွှေဖြူ
                                </a>
                            </li>
                        </ul>
                        <br />
                        <div class="row">
                            <input type="hidden" id="tab_type" value="1">
                            <label for="">From:<input type="date" id="start_date"></label>
                            <label for="" class="ml-3">To:<input type="date" id="end_date"></label>
                            <label for="" style="margin-left: 20px;margin-top:30px;">
                                <a href="#" class="btn btn-color btn-m" onclick="dateFilter()">Search</a>
                            </label>
                        </div>
                        <div class="tab-content br-n pn">
                            <div id="navpills-1" class="tab-pane active">
                                <div class=" table-responsive text-black">
                                    <table class="table table-striped example23" id="example1">
                                        <thead>
                                            <th>နံပါတ်</th>
                                            <th>အထည်အမည်</th>
                                            <th>ကုဒ်နံပါတ်</th>
                                            <th>အ​ရေအတွက်</th>
                                            <th>ဝယ်​​စျေးနှုန်း</th>
                                            <th>Product အ​လေးချိန်<br>(in MM units)</th>
                                            <th>Date</th>
                                            
                                        </thead>
                                        <tbody class="text-center" id="filter1">
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
                                            
                                            </tr>
                                            @endforeach
            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="navpills-2" class="tab-pane">
                                <div class=" table-responsive text-black">
                                    <table class="table table-striped example23" id="example2">
                                        <thead>
                                            <th>နံပါတ်</th>
                                            <th>အထည်အမည်</th>
                                            <th>ကုဒ်နံပါတ်</th>
                                            <th>အ​ရေအတွက်</th>
                                            <th>ဝယ်​​စျေးနှုန်း</th>
                                            <th>Product အ​လေးချိန်<br>(in MM units)</th>
                                            <th>Date</th>
                                           
                                        </thead>
                                        <tbody class="text-center" id="filter2">
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
                                             
                                            </tr>
                                            @endforeach
                                           
            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="navpills-3" class="tab-pane">
                                <div class=" table-responsive text-black">
                                    <table class="table table-striped example23" id="example3">
                                        <thead>
                                            <th>နံပါတ်</th>
                                            <th>အထည်အမည်</th>
                                            <th>ကုဒ်နံပါတ်</th>
                                            <th>အ​ရေအတွက်</th>
                                            <th>ဝယ်​​စျေးနှုန်း</th>
                                            <th>Product အ​လေးချိန်<br>(in MM units)</th>
                                            <th>Date</th>
                                            
                                        </thead>
                                        <tbody class="text-center" id="filter3">
                                            <?php $i = 1;?>
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
                                             
                                            </tr>
                                            @endforeach
                                           
            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="navpills-4" class="tab-pane">
                                <div class=" table-responsive text-black">
                                    <table class="table table-striped example23" id="example4">
                                        <thead>
                                            <th>နံပါတ်</th>
                                            <th>အထည်အမည်</th>
                                            <th>ကုဒ်နံပါတ်</th>
                                            <th>အ​ရေအတွက်</th>
                                            <th>ဝယ်​​စျေးနှုန်း</th>
                                            <th>Product အ​လေးချိန်<br>(in MM units)</th>
                                            <th>Date</th>
                                           
                                        </thead>
                                        <tbody class="text-center" id="filter4">
                                            <?php $i = 1;?>
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
                                             
                                            </tr>
                                            @endforeach
            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="navpills-5" class="tab-pane">
                                <div class=" table-responsive text-black">
                                    <table class="table table-striped example23" id="example5">
                                        <thead>
                                            <th>နံပါတ်</th>
                                            <th>အထည်အမည်</th>
                                            <th>ကုဒ်နံပါတ်</th>
                                            <th>အ​ရေအတွက်</th>
                                            <th>ဝယ်​​စျေးနှုန်း</th>
                                            <th>Product အ​လေးချိန်<br>(in MM units)</th>
                                            <th>Date</th>
                                           
                                        </thead>
                                        <tbody class="text-center" id="filter7">
                                            <?php $i = 1;?>
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

    <script type="text/javascript">
   
            $(document).ready(function() {
                var dataTable = $('.example23').DataTable({
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

        function chkTab(type){
        $.ajax({

        type:'POST',

        url: '{{route("backside.shop_owner.pos.tab_stocklists")}}',

        data:{
        "_token":"{{csrf_token()}}",
        "type" : type,
        },

        success:function(data){
            // alert(type);
            $('#tab_type').val(type);
           $('#tab_qty').html(data.qty);
        }
        })
    }
    
    function allTab(){
        $('#tab_type').val(1);
        $('#tab_qty').html($('#org_qty').val());
    }

    function dateFilter(){
        var start =  $('#start_date').val();
        var end = $('#end_date').val();
        var type = $('#tab_type').val();
        var dataTable = $('#example'+type).DataTable();
        $.ajax({

        type:'POST',

        url: '{{route("backside.shop_owner.pos.tab_stocklists")}}',

        data:{
        "_token":"{{csrf_token()}}",
        "type" : type,
        "start" : start,
        "end" : end
        },

        success:function(data){
            dataTable.clear().draw();
            $('#tab_qty').html(data.qty);
             
            $.each(data.purchases, function(i, v) {
                dataTable.row.add([++i,v.name,v.code_number,v.qty,v.fee,v.weight,v.date]).draw();
            })
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

