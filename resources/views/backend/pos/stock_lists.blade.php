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
                                <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false" onClick="changeTab(1)">
                                    အထည်အားလုံး
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false" onClick="changeTab(2)">
                                    ​ရွှေထည်
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-3" class="nav-link" data-toggle="tab" aria-expanded="false" onClick="changeTab(3)">
                                    ​ကျောက်ထည်
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-4" class="nav-link" data-toggle="tab" aria-expanded="false" onClick="changeTab(4)">
                                    ပလက်တီနမ်
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-5" class="nav-link" data-toggle="tab" aria-expanded="false" onClick="changeTab(5)">
                                    ​ရွှေဖြူ
                                </a>
                            </li>
                            <input type="hidden" value="1" id="type">
                        </ul>
                        <br />
                        <div class="d-flex justify-content-start align-items-center mt-3">
                            <div class="form-group">
                                <label for="fromDate" class="form-label">Choose Date</label>
                                <input type="text" id="fromDate" class="form-control" placeholder="From Date"
                                    autocomplete="off">
                            </div>
                            <div class="form-group mx-3">
                                <label for="toDate" class="form-label">Choose Date</label>
                                <input type="text" id="toDate" class="form-control" placeholder="To Date"
                                    autocomplete="off">
                            </div>
                            <div>
                                <button id="searchButton" class="btn btn-color btn-m mt-3">Filter</button>
                            </div>
                        </div>
                        <div class="tab-content br-n pn">
                            <div id="navpills-1" class="tab-pane active">
                                <div class=" table-responsive text-black">
                                    <table class="table table-striped example23" id="purchaseTable">
                                        <thead>
                                            <th>နံပါတ်</th>
                                            <th>ကုဒ်နံပါတ်</th>
                                            <th>အထည်အမည်</th>
                                            <th>အ​ရေအတွက်</th>
                                            <th>ဝယ်​​စျေးနှုန်း</th>
                                            <th>Product အ​လေးချိန်<br>(in MM units)</th>
                                            <th>Date</th> 
                                        </thead>
                                       
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

    $('#fromDate, #toDate').datepicker({
        "dateFormat": "yy-mm-dd",
        changeYear: true
    });

    var purchaseTable = $('#purchaseTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": "{{ route('backside.shop_owner.pos.get_stock_lists') }}",
            "data": function(d) {
                d.fromDate = $('#fromDate').val();
                d.toDate = $('#toDate').val();
                d.type = $('#type').val();
            }
        },
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'code_number',
                name: 'code_number'
            },
            {
                data: 'gold_name',
                name: 'gold_name'
            },
            {
                data: 'stock_qty',
                name: 'stock_qty'
            },
            {
                data: 'gold_fee',
                name: 'gold_fee'
            },
            {
                data: 'product_gram_kyat_pe_yway',
                name: 'product_gram_kyat_pe_yway',
                "render": function(data, type, full, meta) {
                    // Split the data using '/'
                    var arr = data.split('/');

                    // Define your conditions to display parts of the data
                    var displayText = '';
                    if (arr[1]) {
                        displayText += arr[1] + 'ကျပ်';
                    }else{
                        displayText += arr[0] + 'g'
                    }
                    if (arr[2]) {
                        displayText += arr[2] + 'ပဲ';
                    }
                    if (arr[3]) {
                        displayText += arr[3] + 'ရွေး';
                    }

                    return displayText;
                },
            },
            {
                data: 'date',
                name: 'date'
            },   
            
        ],
        dom: 'lBfrtip',
        "responsive": true,
        "autoWidth": false,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
       
    });

    //Date Filter
    $('#searchButton').click(function() {
        purchaseTable.draw();
    });

    $('.nav-link').click(function() {
        purchaseTable.draw();
    });

    });
 
    function changeTab(val){
        $('#type').val(val);
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

