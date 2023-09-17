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
                            @if ($type == 1)
                            <h4 class="text-color">​အ​ရောင်းစာရင်းများ</h4>
                            @elseif ($type == 2)
                            <h4 class="text-color">​​ရောင်းအားအ​​ကောင်းဆုံးပစ္စည်းများ</h4>
                            @else
                            <h4 class="text-color">​ဝင်​ငွေစာရင်းများ</h4>
                            @endif
                            
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
                                @if ($type == 3)
                                <h6 class="text-color">စုစု​ပေါင်း</h6>
                                <h4 class="text-color">အမြတ်ငွေ &nbsp;&nbsp;<span  id="tab_inc">{{$arr}}</span></h4>
                                <input type="hidden" value="{{$arr}}" id="org_inc">
                                @else
                                <h6 class="text-color">စုစု​ပေါင်း</h6>
                                <h4 class="text-color" >ငွေပမာဏ &nbsp;&nbsp;<span id="tab_amt">{{$arr}}</span></h4>
                                <input type="hidden" value="{{$arr}}" id="org_amt">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-color">စုစု​ပေါင်း</h6>
                                <h4 class="text-color" >အ​ရေအတွက် &nbsp;&nbsp;<span id="tab_qty">{{$tot_qty}}</span></h4>
                                <input type="hidden" value="{{$tot_qty}}" id="org_qty">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <ul class="nav nav-pills m-t-30 m-b-30">
                            <li class="nav-item">
                                <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false" onclick="allTab1()">
                                    အထည်အားလုံး
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false" onclick="chkTab1(2)">
                                    ​ရွှေထည်
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-3" class="nav-link" data-toggle="tab" aria-expanded="false" onclick="chkTab1(3)">
                                    ​ကျောက်ထည်
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-4" class="nav-link" data-toggle="tab" aria-expanded="false" onclick="chkTab1(4)">
                                    ပလက်တီနမ်
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-5" class="nav-link" data-toggle="tab" aria-expanded="false" onclick="chkTab1(5)">
                                    ​ရွှေဖြူ
                                </a>
                            </li>
                        </ul>
                        <br>
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
                                <div class=" table-responsive text-black mt-3">
                                    <table class="table table-striped example23" id="example1">
                                        <thead>
                                            <th>နံပါတ်</th>
                                            <th>အထည်အမည်</th>
                                            <th>ကုဒ်နံပါတ်</th>
                                            <th>အ​ရေအတွက်</th>
                                            <th>အမြတ်</th>
                                            <th>Product အ​လေးချိန်<br>(in MM units)</th>
                                            {{-- <th>Date</th> --}}
                                            
                                        </thead>
                                        <tbody class="text-center" id="filter1">
                                            <?php $i = 1;?>
                                            @foreach ($qty as $q)
                                            @foreach ($purchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 1)
                                            <?php  $arr = explode ("/",$purchase->purchase->product_gram_kyat_pe_yway); ?>
                                            <tr>
                                             <td>{{$i++}}</td>
                                             <td>{{$purchase->purchase->gold_name}}</td>
                                             <td>{{$purchase->purchase->code_number}}</td>
                                             <td>{{$q->qty}}</td>
                                             <td>{{explode('/',$purchase->purchase->profit)[0]}}</td>
                                             
                                             <td>
                                                {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}
                                             </td>
                                             {{-- <td> ​
                                                {{$purchase->date}}
                                             </td> --}}
                                             
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach
                                            
                                            @foreach ($qty as $q)
                                            @foreach ($kyoutpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 2)
                                            <?php  $arr = explode ("/",$purchase->purchase->gold_gram_kyat_pe_yway); ?>
                                            <tr>
                                             <td>{{$i++}}</td>
                                             <td>{{$purchase->purchase->gold_name}}</td>
                                             <td>{{$purchase->purchase->code_number}}</td>
                                             <td>{{$q->qty}}</td>
                                            
                                             <td>{{explode('/',$purchase->purchase->profit)[0]}}</td>
                                             <td>
                                                {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}
                                             </td>
                                             {{-- <td> ​
                                                {{$purchase->date}}
                                             </td> --}}
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach

                                            @foreach ($qty as $q)
                                            @foreach ($platinumpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 3)
                                            <tr>
                                             <td>{{$i++}}</td>
                                             <td>{{$purchase->purchase->platinum_name}}</td>
                                             <td>{{$purchase->purchase->code_number}}</td>
                                             <td>{{$q->qty}}</td>
                                            
                                             <td>{{explode('/',$purchase->purchase->profit)[0]}}</td>
                                            
                                             <td>{{$purchase->purchase->product_gram}} g</td>
            
                                             {{-- <td> ​
                                                {{$purchase->date}}
                                             </td> --}}
                                            </tr>
                                            @endif
                                            @endforeach
                                            @endforeach

                                            @foreach ($qty as $q)
                                            @foreach ($whitegoldpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 4)
                                            <tr>
                                             <td>{{$i++}}</td>
                                             <td>{{$purchase->purchase->whitegold_name}}</td>
                                             <td>{{$purchase->purchase->code_number}}</td>
                                             <td>{{$q->qty}}</td>
                                             
                                             <td>{{explode('/',$purchase->purchase->profit)[0]}}</td>
                        
                                             <td>{{$purchase->purchase->product_gram}} g</td>
            
                                             {{-- <td> ​
                                                {{$purchase->date}}
                                             </td> --}}
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
                                    <table class="table table-striped example23" id="example2">
                                        <thead>
                                            <th>နံပါတ်</th>
                                            <th>​ရွှေထည်အမည်</th>
                                            <th>ကုဒ်နံပါတ်</th>
                                            <th>စုစု​ပေါင်းအ​ရေ​အတွက်</th>
                                           
                                            <th>အမြတ်</th>
                                           
                                            <th>Product အ​လေးချိန်<br>(in MM units)</th>
                                            {{-- <th>Date</th> --}}
                                            
                                        </thead>
                                        <tbody class="text-center" id="filter2">
                                            <?php $i = 1;?>
                                            @foreach ($qty as $q)
                                            @foreach ($purchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 1)
                                            <?php  $arr = explode ("/",$purchase->purchase->product_gram_kyat_pe_yway); ?>
                                            <tr>
                                             <td>{{$i++}}</td>
                                             <td>{{$purchase->purchase->gold_name}}</td>
                                             <td>{{$purchase->purchase->code_number}}</td>
                                             <td>{{$q->qty}}</td>
                                             
                                             <td>{{explode('/',$purchase->purchase->profit)[0]}}</td>
                                           
                                             <td>
                                                {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}
                                             </td>
                                             {{-- <td> ​
                                                {{$purchase->date}}
                                             </td> --}}
                                             
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
                                    <table class="table table-striped example23" id="example3">
                                        <thead>
                                            <th>နံပါတ်</th>
                                            <th>​​ကျောက်ထည်အမည်</th>
                                            <th>ကုဒ်နံပါတ်</th>
                                            <th>စုစု​ပေါင်းအ​ရေ​အတွက်</th>
                                            
                                            <th>အမြတ်</th>
                                            
                                            <th>Product အ​လေးချိန်<br>(in MM units)</th>
                                            {{-- <th>Date</th> --}}
                                            
                                        </thead>
                                        <tbody class="text-center" id="filter3">
                                            <?php $i = 1;?>
                                            @foreach ($qty as $q)
                                            @foreach ($kyoutpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 2)
                                            <?php  $arr = explode ("/",$purchase->purchase->gold_gram_kyat_pe_yway); ?>
                                            <tr>
                                             <td>{{$i++}}</td>
                                             <td>{{$purchase->purchase->gold_name}}</td>
                                             <td>{{$purchase->purchase->code_number}}</td>
                                             <td>{{$q->qty}}</td>
                                              
                                             <td>{{explode('/',$purchase->purchase->profit)[0]}}</td>
                                
                                             <td>
                                                {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                                {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                                {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}
                                             </td>
                                             {{-- <td> ​
                                                {{$purchase->date}}
                                             </td> --}}
                                             
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
                                    <table class="table table-striped example23" id="example4">
                                        <thead>
                                            <th>နံပါတ်</th>
                                            <th>​ပလက်တီနမ်အမည်</th>
                                            <th>ကုဒ်နံပါတ်</th>
                                            <th>စုစု​ပေါင်းအ​ရေ​အတွက်</th>
                                          
                                            <th>အမြတ်</th>
                                           
                                            <th>Product အ​လေးချိန်<br>(in gram)</th>
                                            {{-- <th>Date</th> --}}
                                            
                                        </thead>
                                        <tbody class="text-center" id="filter4">
                                            <?php $i = 1;?>
                                            @foreach ($qty as $q)
                                            @foreach ($platinumpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 3)
                                            <tr>
                                             <td>{{$i++}}</td>
                                             <td>{{$purchase->purchase->platinum_name}}</td>
                                             <td>{{$purchase->purchase->code_number}}</td>
                                             <td>{{$q->qty}}</td>
                                            
                                             <td>{{explode('/',$purchase->purchase->profit)[0]}}</td>
                                            
                                             <td>{{$purchase->purchase->product_gram}} g</td>
            
                                             {{-- <td> ​
                                                {{$purchase->date}}
                                             </td> --}}
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
                                    <table class="table table-striped example23" id="example5">
                                        <thead>
                                            <th>နံပါတ်</th>
                                            <th>ရွှေဖြူအမည်</th>
                                            <th>ကုဒ်နံပါတ်</th>
                                            <th>စုစု​ပေါင်းအ​ရေ​အတွက်</th>
                                           
                                            <th>အမြတ်</th>
                                           
                                            <th>Product အ​လေးချိန်<br>(in gram)</th>
                                            {{-- <th>Date</th> --}}
                                            
                                        </thead>
                                        <tbody class="text-center" id="filter5">
                                            <?php $i = 1;?>
                                            @foreach ($qty as $q)
                                            @foreach ($whitegoldpurchases as $purchase)
                                            @if ($q->sale_id == $purchase->id && $q->type == 4)
                                            <tr>
                                             <td>{{$i++}}</td>
                                             <td>{{$purchase->purchase->whitegold_name}}</td>
                                             <td>{{$purchase->purchase->code_number}}</td>
                                             <td>{{$q->qty}}</td>
                                             
                                             <td>{{explode('/',$purchase->purchase->profit)[0]}}</td>
                                             
                                             <td>{{$purchase->purchase->product_gram}} g</td>
            
                                             {{-- <td> ​
                                                {{$purchase->date}}
                                             </td> --}}
                                            
                                            </tr>
                                            @endif
                                            @endforeach
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
                    url = route("backside.shop_owner.pos.delete_goldsale",id);
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

    function allTab1(){
        $('#tab_type').val(1);
        $('#tab_inc').html($('#org_inc').val());
        $('#tab_qty').html($('#org_qty').val());
    }

    function chkTab1(type){
        $.ajax({

        type:'POST',

        url: '{{route("backside.shop_owner.pos.tab_incomelists")}}',

        data:{
        "_token":"{{csrf_token()}}",
        "type" : type,
        },

        success:function(data){
            $('#tab_type').val(type);
           $('#tab_inc').html(data.total);
           $('#tab_qty').html(data.qty);
        }
        })
    }

    function dateFilter(){
        var start =  $('#start_date').val();
        var end = $('#end_date').val();
        var type = $('#tab_type').val();
        var dataTable = $('#example'+type).DataTable();
        $.ajax({

        type:'POST',

        url: '{{route("backside.shop_owner.pos.tab_incomelists")}}',

        data:{
        "_token":"{{csrf_token()}}",
        "type" : type,
        "start" : start,
        "end" : end
        },

        success:function(data){
            dataTable.clear().draw();
            $('#tab_inc').html(data.total);
            $('#tab_qty').html(data.qty);
            // alert(type);
            var html1='';
            $.each(data.purchases, function(i, v) {
                dataTable.row.add([++i,v.name,v.code_number,v.qty,v.fee,v.weight]).draw();
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

