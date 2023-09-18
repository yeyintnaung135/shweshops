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
                    <h4 class="text-color">ပလက်တီနမ် အ​ရောင်းစာရင်းများ</h4>
                    <a class="btn btn-m btn-color ml-3" href="{{route('backside.shop_owner.pos.sale_ptm_purchase')}}">
                    <i class="fa fa-plus mr-2"></i>Create</a>
                    {{-- <div class="dropdown ml-5">
                        <a class="btn btn-m btn-color dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-filter"></i></a>
                        <ul class="dropdown-menu px-1">
                        <li><label><input type="checkbox" id="female" > မိန်းမဝတ်</label></li>
                        <li><label><input type="checkbox" id="male"> ​​ယောကျားဝတ်</label></li>
                        <li><label><input type="checkbox" id="unisex"> unisex</label></li>
                        <li><label><input type="checkbox" id="child"> က​လေးဝတ်</label></li>
                        <li><hr class="dropdown-divider"/></li>
                        <li><a href="#" class="btn btn-color btn-sm" style="margin-left: 50px;" onclick="goldtypefilter(1)">Save</a></li>
                        </ul>
                    </div> --}}
                </div>
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
                <h6 class="mt-3 text-color mb-1">ဆိုင်ခွဲဖြင့်ကြည့်ရှုရန်
                    {{-- <input type="checkbox" class="mt-1 ml-2" name='chkflag' id="chkflag" onclick="stockcheck(1)"> --}}
                    <select name="f_counter"  id="f_counter">
                        <option value="">ဆိုင်ခွဲများ</option>
                        <option value="all_shop" selected>အားလုံး</option>
                        @foreach ($counters as $counter)
                            <option value="{{ $counter->shop_name }}">{{ $counter->shop_name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="print_counter" value="All">
                </h6>
            </div>
            <div class="col-5">
                <div class="row">
                    <div class="col-8">
                        {{-- <h6 class="text-color mt-4">​ပန်းထိမ်ဆိုင်ဖြင့်ကြည့်ရှုရန်</h6> --}}
                        <h6 class="text-color mt-4">​​ပလက်တီနမ်​အမျိုးအစားဖြင့်ကြည့်ရှုရန်</h6>
                        <h6 class="text-color mt-4">ပစ္စည်း​အမျိုးအစားဖြင့်ကြည့်ရှုရန်</h6>
                    </div>
                    <div class="col-1">
                        {{-- <input type="checkbox" class="sup mt-4" onclick="advanceFilter()"> --}}
                        <input type="checkbox" class="qual mt-4" onclick="advanceFilter()">
                        <input type="checkbox" class="cat mt-4" onclick="advanceFilter()">
                    </div>
                    <div class="col-3" >
                        {{-- <select name="" id="sup" class="mt-2 form-control" onchange="filtergoldadvance(this.value,1)">
                            <option value="">​ပန်းထိမ်ဆိုင်များ</option>
                            @foreach ($sups as $sup)
                            <option value="{{$sup->id}}">{{$sup->name}}</option>
                            @endforeach
                        </select> --}}
                        <input type="hidden" id="print_gtype" value="All">
                        <select name="" id="qual" class="mt-2 form-control">
                            <option selected disabled value="">ရှာရန်</option>
                            <option value="Grade A">Grade A</option>
                            <option value="Grade B">Grade B</option>
                            <option value="Grade C">Grade C</option>
                            <option value="Grade D">Grade D</option>
                        </select>
                        <input type="hidden" id="print_cat" value="All">
                        <select name="" id="cat" class="mt-2 form-control">
                            <option selected disabled value="">ရှာရန်</option>
                            @foreach ($cats as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->mm_name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="supid">
                        <input type="hidden" id="qualid">
                        <input type="hidden" id="catid">
                    </div>
                </div>
            </div>
        </div>
                <div class="card mt-2">
                    <?php $tot_g = 0;$tot_sale=0;
                    foreach ($purchases as $pg) {
                        $product = explode ("/",$pg->purchase->product_gram);
                        $tot_sale += $pg->amount;
                        $tot_g += $product [0];
                    }
                    ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 card row" style="max-height: 70px;">
                                <h6 class="col-8 text-color mt-2" >စုစု​ပေါင်းအ​ရေအတွက်</h6>
                                <h6 class="col-4 text-color mt-2" id="tot_qty">{{count($purchases)}}</h6>
                            </div>
                            <div class="col-3 card row" style="max-height: 70px;">
                                <h6 class="col-8 text-color mt-2" >စုစု​ပေါင်းအ​လေးချိန် (g)</h6>
                                <h6 class="col-4 text-color mt-2"><span id="tot_g">{{$tot_g}}</span>  g</h6>
                            </div>
                            
                            <div class="col-6 card row" style="max-height: 70px;">
                                <h6 class="col-5 text-color mt-2" >ရောင်းရ​ငွေစုစု​ပေါင်း</h6>
                                <h6 class="col-7 text-color mt-2" id="tot_sale">{{$tot_sale}} ကျပ်</h6>
                            </div>
                        </div>
                        <div class=" table-responsive text-black">
                        <table class="table table-striped" id="saleTable">
                            <thead>
                                <th>နံပါတ်</th>
                                <th>​ပလက်တီနမ်အမည်</th>
                                <th>ကုဒ်နံပါတ်</th>
                                <th>စုစု​ပေါင်းအ​ရေ​အတွက်</th>
                                <th>ရောင်းစျေး</th>
                                <th>Product အ​လေးချိန်<br>(in gram)</th>
                                <th>Date</th>
                                <th></th>
                            </thead>
                          
                        </table>
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

        $('#fromDate, #toDate').datepicker({
            "dateFormat": "yy-mm-dd",
            changeYear: true
        });

       var platinumPurchaseTable = $('#saleTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            "url": "{{ route('backside.shop_owner.pos.get_ptm_sale_list') }}",
            "data": function(d) {
                d.fromDate = $('#fromDate').val();
                d.toDate = $('#toDate').val();
                d.f_counter = $('#f_counter').val();
                d.qual = $('#qual').val();
                d.cat = $('#cat').val();
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
            data: 'code_number',
            name: 'code_number'
        },
        {
            data: 'product_gram',
            name: 'product_gram'
        },
        {
            data: 'stock_qty',
            name: 'stock_qty'
        },
        {
            data: 'amount',
            name: 'amount'
        },
        {
            data: 'date',
            name: 'date'
        },
        {
            data: 'actions',
            name: 'actions',
            render: function(data, type, full, meta) {
                var actions = '';
                    actions += `
                    <a class="btn btn-sm" onclick="Delete('${full.id}')"
                    title="Delete">
                    <span class="fa fa-trash text-danger"></span>
                    </a>
                    <form id="delete_form_${full.id}" action="${full.actions.delete_url}" method="POST"
                    style="display: none;">
                    @csrf
                    @method('DELETE')
                    </form>`;
                actions +=
                    `<a href="${full.actions.edit_url}" class="ml-2 text-warning"><i class="fa fa-edit"></i></a>`;
                actions +=
                    `<a href="${full.actions.detail_url}" class="ml-2 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a>`;

                return actions;
            },
        },
    ],
    drawCallback: function(settings) {
        var api = this.api();
        var purchasesData = api.rows().data(); // Access the data in the current view

        // Reset the totals to 0 before recalculating
        var tot_g = 0;var count = 0;var tot_sale = 0;

        // Calculate totals based on the data in the current view
        for (var i = 0; i < purchasesData.length; i++) {
            var pg = purchasesData[i];
            tot_sale += pg.amount;
            tot_g += parseFloat(pg.product_gram);
        }

        // Update the HTML elements with the recalculated totals
        $('#tot_qty').text(purchasesData.length);
        $('#tot_g').text(tot_g);
        $('#tot_sale').text(tot_sale);
    },
    dom: 'lBfrtip',
    "responsive": true,
    "autoWidth": false,
    buttons: [
        'copy', 'csv', 'excel', 'pdf',
        {
            extend: 'print',
            customize: function(win) {
                    var tot_qty = $('#tot_qty').text();
                    var tot_g = $('#tot_g').text();
                    var tot_sale = $('#tot_sale').text();
                    var date = $('#print_date').val();
                    var counter = $('#print_counter').val();
                    var gtype = $('#print_gtype').val();
                    var cat = $('#print_cat').val();
                    var existingData = $(win.document.body).html();
                    var extraText1 = `<div class="row">
                        <div class="col-3 card" style="max-height: 70px;"><h6 class="text-color mt-2" >စုစု​ပေါင်းအ​ရေအတွက် &nbsp;&nbsp;&nbsp;<span>${tot_qty}</span></h6></div>
                        <div class="col-3 card" style="max-height: 70px;"><h6 class="text-color mt-2" >စုစု​ပေါင်းအ​လေးချိန် &nbsp;&nbsp;&nbsp;<span>${tot_g}</span>  g<br>(Gram)</h6></div>
                        
                        <div class="col-5 card row" style="max-height: 70px;">
                            <h6 class="col-5 text-color mt-2" >ရောင်းရ​ငွေစုစု​ပေါင်း</h6>
                            <h6 class="col-7 text-color mt-2" id="tot_sale">${tot_sale}</h6>
                        </div>
                    </div>`;
                    var extraText2 = `
                        <h6 class='text-color'>​ကောင်တာ : ${counter}</h6>
                        <h6 class='text-color'>​​ရွှေရည် : ${gtype}</h6>
                        <h6 class='text-color'>​အမျိုးအစား : ${cat}</h6>
                        <h6 class='text-color'>​Date : ${date}</h6>
                    `;
                    $(win.document.body).html(extraText1+existingData+extraText2);
                }
            }
        ],
       
    });

    //Date Filter
    $('#searchButton').click(function() {
        platinumPurchaseTable.draw();
    });

    $('#f_counter').change(function() {
        platinumPurchaseTable.draw();
    });

    $('#qual').change(function() {
        platinumPurchaseTable.draw();
    });

    $('#cat').change(function() {
        platinumPurchaseTable.draw();
    });

    });

    function Delete(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-danger ml-2',
                    cancelButton: 'btn btn-info'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Check if "Confirm" button was clicked
                    $('#delete_form_'+id).submit();
                }
            });
        }
        
        

        function advanceFilter(){
                if($('.sup').is(':checked',true)){
                    $('#sup').show();
                }else{
                    $('#sup').hide();
                    $('#supid').val('');
                }
                if($('.qual').is(':checked',true)){
                    $('#qual').show();
                }else{
                    $('#qual').hide();
                    $('#qualid').val('');
                }
                if($('.cat').is(':checked',true)){
                    $('#cat').show();
                }else{
                    $('#cat').hide();
                    $('#catid').val('');
                }
            }
      
         $(document).ready(function() {
            $('#sup').hide();
                $('#qual').hide();
                $('#cat').hide();
            function alignModal(){
        var modalDialog = $(this).find(".modal-dialog");

        // Applying the top margin on modal to align it vertically center
            modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
        }
        // Align modal when it is displayed
        $(".modal").on("shown.bs.modal", alignModal);

        // Align modal when user resize the window
        $(window).on("resize", function(){
            $(".modal:visible").each(alignModal);
        });

    });


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

    </style>
@endpush

