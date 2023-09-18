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
            @if (Session::has('message'))
                <x-alert>

                </x-alert>
            @endif
            <!-- Content Header (Page header) -->
            <section class="content-header sn-content-header">
                <div class="container-fluid">
                </div><!-- /.container-fluid -->
            </section>

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-7">
                            <div class="row d-flex">
                                <h4 class="text-color">ပလက်တီနမ် အဝယ်စာရင်းများ</h4>
                                <a class="btn btn-m btn-color ml-3"
                                    href="{{ route('backside.shop_owner.pos.create_ptm_purchase') }}">
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
                            <h6 class="mt-3 text-color mb-1">ဆိုင်လက်ကျန်ကြည့်ရှုရန်
                                {{-- <input type="checkbox" class="mt-1 ml-2" name='chkflag' id="chkflag" onclick="stockcheck(3)"> --}}
                                <select name="f_counter" id="f_counter">
                                    <option disabled>ဆိုင်ခွဲများ</option>
                                    <option value="all_shops" selected>အားလုံး</option>
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
                                <div class="col-3">
                                    {{-- <select name="" id="sup" class="mt-2 form-control" onchange="filtergoldadvance(this.value,1)">
                            <option value="">​ပန်းထိမ်ဆိုင်များ</option>
                            @foreach ($sups as $sup)
                            <option value="{{$sup->id}}">{{$sup->name}}</option>
                            @endforeach
                        </select> --}}
                                    <select name="" id="qual" class="mt-2 form-control">
                                        <option selected value="all">အားလုံး</option>
                                        <option value="Grade A">Grade A</option>
                                        <option value="Grade B">Grade B</option>
                                        <option value="Grade C">Grade C</option>
                                        <option value="Grade D">Grade D</option>
                                    </select>
                                    <select name="" id="cat" class="mt-2 form-control">
                                        <option selected value="all">အားလုံး</option>
                                        @foreach ($cats as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->mm_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3 card" style="max-height: 70px;">
                                    <h6 class="text-color mt-2">စုစု​ပေါင်းအ​ရေအတွက် &nbsp;&nbsp;&nbsp;<span
                                            id="tot_qty">0</span></h6>
                                </div>
                                <div class="col-3 card" style="max-height: 70px;">
                                    <h6 class="text-color mt-2">စုစု​ပေါင်းအ​လေးချိန် &nbsp;&nbsp;&nbsp;<span
                                            id="tot_g">0</span> g<br>(Gram)</h6>
                                </div>
                            </div>
                            <div class=" table-responsive text-black">
                                <table class="table table-striped" id="platinumPurchaseTable">
                                    <thead>
                                        <th>နံပါတ်</th>
                                        <th>​ပလက်တီနမ်အမည်</th>
                                        <th>ပလက်တီနမ်အရည်အ​သွေး</th>
                                        <th>ပလက်တီနမ်အမျိုးအစား</th>
                                        <th>ကုဒ်နံပါတ်</th>
                                        <th>Product အ​လေးချိန်<br>(in gram)</th>
                                        <th>အ​ရေအတွက်</th>
                                        <th>ပစ္စည်းတန်ဖိုး</th>
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

            var tot_g = 0;

            var platinumPurchaseTable = $('#platinumPurchaseTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ route('backside.shop_owner.pos.get_ptm_purchase_list') }}",
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
                        data: 'quality',
                        name: 'quality'
                    },
                    {
                        data: 'platinum_type',
                        name: 'platinum_type',
                        render: function(data, type, row) {
                            return data ? data : '-';
                        },
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
                        data: 'capital',
                        name: 'capital'
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
                            if (full.sell_flag == 0) {
                                actions += `
            <a class="btn btn-sm btn-danger" onclick="Delete('${full.actions.delete_url}')"
            title="Delete">
            <span class="fa fa-trash"></span>
        </a>
        <form id="delete_form_${full.id}" action="${full.actions.delete_url}" method="POST"
            style="display: none;">
            @csrf
            @method('DELETE')
        </form>`;
                            }
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
                    tot_g = 0;

                    // Calculate totals based on the data in the current view
                    for (var i = 0; i < purchasesData.length; i++) {
                        var pg = purchasesData[i];

                        tot_g += parseFloat(pg.product_gram);
                    }

                    // Update the HTML elements with the recalculated totals
                    $('#tot_qty').text(purchasesData.length);
                    $('#tot_g').text(tot_g);
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
                            var date = $('#fromDate').val() + ' - ' + $('#toDate').val();
                            var counter = $('#f_counter option:selected').text();
                            var gtype = $('#qual option:selected').text();
                            var cat = $('#cat option:selected').text();
                            var existingData = $(win.document.body).html();
                            var extraText1 = `<div class="row">
                <div class="col-3 card" style="max-height: 70px;"><h6 class="text-color mt-2" >စုစု​ပေါင်းအ​ရေအတွက် &nbsp;&nbsp;&nbsp;<span>${tot_qty}</span></h6></div>
                <div class="col-3 card" style="max-height: 70px;"><h6 class="text-color mt-2" >စုစု​ပေါင်းအ​လေးချိန် &nbsp;&nbsp;&nbsp;<span>${tot_g}</span>  g<br>(Gram)</h6></div>
            </div>`;
                            var extraText2 = `
                <h6 class='text-color'>​ကောင်တာ : ${counter}</h6>
                <h6 class='text-color'>​​ရွှေရည် : ${gtype}</h6>
                <h6 class='text-color'>​အမျိုးအစား : ${cat}</h6>
                <h6 class='text-color'>​Date : ${date}</h6>
            `;
                            $(win.document.body).html(extraText1 + existingData + extraText2);
                        }
                    }
                ],
                order: [
                    [8, 'desc']
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

        function Delete(deleteUrl) {
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
                    const deleteForm = document.createElement('form');
                    deleteForm.action = deleteUrl;
                    deleteForm.method = 'POST';
                    deleteForm.style.display = 'none';
                    deleteForm.innerHTML = `
                    @csrf
                    @method('DELETE')`;
                    document.body.appendChild(deleteForm);
                    deleteForm.submit();
                }
            });
        }

        function advanceFilter() {

            if ($('.sup').is(':checked', true)) {
                $('#sup').show();
            } else {
                $('#sup').hide();
                $('#supid').val('');
            }
            if ($('.qual').is(':checked', true)) {
                $('#qual').show();
            } else {
                $('#qual').hide();
                $('#qualid').val('');
            }
            if ($('.cat').is(':checked', true)) {
                $('#cat').show();
            } else {
                $('#cat').hide();
                $('#catid').val('');
            }
        }


        $(document).ready(function() {
            $('#sup').hide();
            $('#qual').hide();
            $('#cat').hide();

            function alignModal() {
                var modalDialog = $(this).find(".modal-dialog");

                // Applying the top margin on modal to align it vertically center
                modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
            }
            // Align modal when it is displayed
            $(".modal").on("shown.bs.modal", alignModal);

            // Align modal when user resize the window
            $(window).on("resize", function() {
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

        .btn-color {
            background-color: #780116;
            color: white;
        }

        .btn-color:hover {
            color: white;
        }

        .text-color {
            color: #780116;
        }
    </style>
@endpush
