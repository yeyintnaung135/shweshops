@extends('layouts.backend.datatable')

@section('content')
    <div class="wrapper">

        @include('layouts.backend.navbar')

        <!-- Main Sidebar Container -->
        @include('layouts.backend.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper sn-background-light-blue">
            <!-- Content Header (Page header) -->
            @if (Session::has('message'))
                <x-alert>

                </x-alert>
            @endif
            <!-- zhheader shopname -->
            {{-- <x-header>
        @foreach ($shopowner as $shopowner)
                @endforeach
                {{$shopowner->shop_name}}
        </x-header> --}}
            <!-- end zh header shopname -->
            {{-- <x-title>
            Items list
        </x-title> --}}
            <!-- Main content -->
            <section class="content pt-3">
                <div class="sn-tab-panel">
                    <ul>
                        <a href="{{ route('backside.shop_owner.so_activity.p_product') }}">
                            <li>Item Activities</li>
                        </a>
                        <a href="{{ route('backside.shop_owner.so_activity.p_multiprice') }}">
                            <li>Multiple Price Activities</li>
                        </a>
                        <a class="active-panel" href="{{ route('backside.shop_owner.so_activity.p_multidiscount') }}">
                            <li>Multiple Discount Activities</li>
                        </a>
                        <a href="{{ route('backside.shop_owner.so_activity.p_multipercent') }}">
                            <li>Multiple Percent Activities</li>
                        </a>
                    </ul>
                </div>

                <div id="item-panel-4" class=" container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="sn-table-list-wrapper">

                                <!-- /.card-header -->
                                <div class="card shadow-none border-0 rounded-5 pb-2">
                                    <div class="card-header border-0">
                                        <h2>Panel Multiple Discount Activity @include('backend.shopowner.toottips')</h2>
                                        <p>Check your store’s panel multiple discount activity</p>
                                    </div>
                                    <div class="d-flex justify-content-end my-3 align-items-center">
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>From Date</legend>
                                                <input type="text" id='search_fromdate_muldisact'
                                                    class="muldisactdatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>To Date</legend>
                                                <input type="text" id='search_todate_muldisact'
                                                    class="muldisactdatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="pr-md-4">
                                            <input type='button' id="muldisact_search_button" value="Search"
                                                class="btn bg-info">
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="multipleDiscountActivityTable" class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Product Code</th>
                                                    <th>Product Name</th>
                                                    <th>User Name</th>
                                                    <th>User Role</th>
                                                    <th>Old Price</th>
                                                    <th>Old Min Price</th>
                                                    <th>Old Max Price</th>
                                                    <th>Percent</th>
                                                    <th>Old Discount Price</th>
                                                    <th>New Discount Price</th>
                                                    <th>Old Discount Min</th>
                                                    <th>Old Discount Max</th>
                                                    <th>New Discount Min</th>
                                                    <th>New Discount Max</th>
                                                    <th>Created Date</th>
                                                </tr>
                                            </thead>

                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Product Code</th>
                                                    <th>Product Name</th>
                                                    <th>User Name</th>
                                                    <th>User Role</th>
                                                    <th>Old Price</th>
                                                    <th>Old Min Price</th>
                                                    <th>Old Max Price</th>
                                                    <th>Percent</th>
                                                    <th>Old Discount Price</th>
                                                    <th>New Discount Price</th>
                                                    <th>Old Discount Min</th>
                                                    <th>Old Discount Max</th>
                                                    <th>New Discount Min</th>
                                                    <th>New Discount Max</th>
                                                    <th>Created Date</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>

                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
@endsection

@push('css')
    <style>
        .sn-tab-panel ul li {
            width: 100% !important;
            background: transparent !important;
            padding: 6px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Multiple Discount Activity Table
            var multipleDiscountActivityTable = $('#multipleDiscountActivityTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ route('backside.shop_owner.items.getmultiple_discount_activity_log') }}",
                    'data': function(data) {
                        // Read values
                        var from_date = $('#search_fromdate_muldisact').val() ? $(
                            '#search_fromdate_muldisact').val() + " 00:00:00" : null;
                        var to_date = $('#search_todate_muldisact').val() ? $(
                            '#search_todate_muldisact').val() + " 23:59:59" : null;

                        // Append to data
                        data.searchByFromdate = from_date;
                        data.searchByTodate = to_date;
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'product_code'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'user_name'
                    },
                    {
                        data: 'user_role'
                    },
                    {
                        data: 'old_price'
                    },
                    {
                        data: 'old_min_price'
                    },
                    {
                        data: 'old_max_price'
                    },
                    {
                        data: 'percent'
                    },
                    {
                        data: 'old_discount_price'
                    },
                    {
                        data: 'new_discount_price'
                    },
                    {
                        data: 'old_discount_min'
                    },
                    {
                        data: 'old_discount_max'
                    },
                    {
                        data: 'new_discount_min'
                    },
                    {
                        data: 'new_discount_max'
                    },
                    {
                        data: 'created_at'
                    }

                ],

                responsive: true,
                lengthChange: true,
                // searching: false,
                autoWidth: false,
                paging: true,
                dom: 'Blfrtip',
                buttons: ["copy", "csv", "excel", "pdf", "print"],
                columnDefs: [{
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 2,
                        targets: 2
                    },
                    {
                        responsivePriority: 3,
                        targets: 3
                    },
                    {
                        responsivePriority: 4,
                        targets: 4
                    },
                ],
                language: {
                    "search": '<i class="fa-solid fa-search"></i>',
                    "searchPlaceholder": 'Search...',
                    paginate: {
                        next: '<i class="fa fa-angle-right"></i>', // or '→'
                        previous: '<i class="fa fa-angle-left"></i>' // or '←'
                    }
                },


                "order": [
                    [9, "desc"]
                ],

            });

            $(".itemdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#item_search_button').click(function() {
                if ($('#search_fromdate_item').val() != null && $('#search_todate_item').val() != null) {
                    itemsTable.draw();
                }
            });

            $(".itemactdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#itemact_search_button').click(function() {
                if ($('#search_fromdate_itemact').val() != null && $('#search_todate_itemact').val() !=
                    null) {
                    itemsActivityTable.draw();
                }
            });

            $(".mulpriceactdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#mulpriceact_search_button').click(function() {
                if ($('#search_fromdate_mulpriceact').val() != null && $('#search_todate_mulpriceact')
                .val() != null) {
                    multiplePriceLogsActivityTable.draw();
                }
            });

            $(".muldisactdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#muldisact_search_button').click(function() {
                if ($('#search_fromdate_muldisact').val() != null && $('#search_todate_muldisact').val() !=
                    null) {
                    multipleDiscountActivityTable.draw();
                }
            });

            $(".mulperactdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#mulperact_search_button').click(function() {
                if ($('#search_fromdate_mulperact').val() != null && $('#search_todate_mulperact').val() !=
                    null) {
                    multipleDamageActivityTable.draw();
                }
            });
        });
        var STOPCLICK = false;
        var STOPCLICK_DISCOUNT = false;
        var oper = 'plus';
        var temptodis = {};
        $("input[name=oper]").on('change', function() {
            oper = $(this).val();
        });
        var unsetdiscountitemlist = [];
        //we cannot use some jquery code in this fn beacause it conflict with bootstrap model
        //okay pr :p
        $(document).on('change', '.ff', function(e) {
            if (!e.target.checked) {
                temptodis[e.target.value] = $('#' + e.target.value).text();;
                console.log(temptodis);
                $('#' + e.target.value).html('------');

                unsetdiscountitemlist.push(e.target.value)

            } else {
                $('#' + e.target.value).html(temptodis[e.target.value]);

                const index = unsetdiscountitemlist.indexOf(e.target.value);
                if (index > -1) {
                    unsetdiscountitemlist.splice(index, 1);
                }
            }
            console.log(unsetdiscountitemlist);
        });
        //we cannot use some jquery code in this fn beacause it conflict with bs model
    </script>
@endpush
