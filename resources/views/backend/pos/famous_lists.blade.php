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
                            <li class=" nav-item">
                                <a href="#navpills-6" class="nav-link" data-toggle="tab" aria-expanded="false" onClick="changeTab(6)">
                                    ​အ​ခေါက်​ရွှေ
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-7" class="nav-link" data-toggle="tab" aria-expanded="false" onClick="changeTab(7)">
                                    ​၁၅ ပဲရည်
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-8" class="nav-link" data-toggle="tab" aria-expanded="false" onClick="changeTab(8)">
                                    ​၁၄ ပဲ ၂ ပြား
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-9" class="nav-link" data-toggle="tab" aria-expanded="false" onClick="changeTab(9)">
                                    ​​၁၄ ပဲရည်
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-10" class="nav-link" data-toggle="tab" aria-expanded="false" onClick="changeTab(10)">
                                    ၁၃ ပဲရည်
                                </a>
                            </li>
                            <li class=" nav-item">
                                <a href="#navpills-11" class="nav-link" data-toggle="tab" aria-expanded="false" onClick="changeTab(11)">
                                    ၁၂ ပဲရည်
                                </a>
                            </li>
                            <input type="hidden" value="1" id="type">
                            @foreach ($categories as $cate)
                            <li class=" nav-item">
                                <a href="#navpill-{{$cate->id}}" class="nav-link" data-toggle="tab" aria-expanded="false" onClick="changeTab(12{{$cate->id}})">
                                    {{$cate->mm_name}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="tab-content br-n pn">
                            <div id="navpills-1" class="tab-pane active">
                                <div class=" table-responsive text-black mt-3">
                                    <table class="table table-striped example23" id="purchaseTable">
                                        <thead>
                                            <th style="max-width: 40px;">နံပါတ်</th>
                                            <th>အမျိုးအမည်</th>
                                            <th>အ​ရောင်း</th>
                                            <th>လက်ကျန်</th>
                                            {{-- <th></th> --}}
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
            "url": "{{ route('backside.shop_owner.pos.get_famous_sale_lists') }}",
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
            data: 'name',
            name: 'name'
        },
        {
            data: 'qty',
            name: 'qty'
        },
        {
            data: 'stock_qty',
            name: 'stock_qty'
        },
        ],
    
        dom: 'lBfrtip',
        "responsive": true,
        "autoWidth": false,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        order: [
            [2, 'desc']
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
            alert(val);
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

