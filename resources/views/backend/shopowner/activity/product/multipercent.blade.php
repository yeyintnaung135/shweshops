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
                        <a href="{{ route('backside.shop_owner.so_activity.p_multidiscount') }}">
                            <li>Multiple Discount Activities</li>
                        </a>
                        <a class="active-panel" href="{{ route('backside.shop_owner.so_activity.p_multipercent') }}">
                            <li>Multiple Percent Activities</li>
                        </a>
                    </ul>
                </div>

                <div id="item-panel-5" class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="sn-table-list-wrapper">
                                <!-- /.card-header -->
                                <div class="card shadow-none border-0 rounded-5 pb-2">

                                    <div class="card-header border-0">
                                        <h2>Panel Multiple Percent Activity @include('backend.shopowner.toottips')</h2>
                                        <p>Check your store’s panel multiple Percent activity</p>
                                    </div>
                                    <div class="d-flex justify-content-end my-3 align-items-center">
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>From Date</legend>
                                                <input type="text" id='search_fromdate_mulperact'
                                                    class="mulperactdatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>To Date</legend>
                                                <input type="text" id='search_todate_mulperact'
                                                    class="mulperactdatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="pr-md-4">
                                            <input type='button' id="mulperact_search_button" value="Search"
                                                class="btn bg-info">
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="multipleDamageActivityTable" class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Product Code</th>
                                                    <th>Product Name</th>
                                                    <th>User Name</th>
                                                    <th>User Role</th>
                                                    <th>Name</th>
                                                    <th>အလျော့တွက်</th>
                                                    <th>လက်ခ</th>
                                                    <th>အထည်မပျက် ပြန်သွင်း</th>
                                                    <th>အထည်ပျက်စီး ချို့ယွင်း</th>
                                                    <th>တန်ဖိုးမြင့်အထည်နှင့် အထည်မပျက်ပြန်လဲ</th>
                                                    <th>အလျော့တွက်(new)</th>
                                                    <th>လက်ခ(new)</th>
                                                    <th>undamaged_product(new)</th>
                                                    <th>အထည်ပျက်စီး ချို့ယွင်း(new)</th>
                                                    <th>တန်ဖိုးမြင့်အထည်နှင့် အထည်မပျက်ပြန်လဲ(new)</th>
                                                    <th>Created Date</th>
                                                </tr>
                                            </thead>
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
            // Multiple Damage Activity Table
            var multipleDamageActivityTable = $('#multipleDamageActivityTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ route('backside.shop_owner.items.getmultiple_damage_activity_log') }}",
                    'data': function(data) {
                        // Read values
                        var from_date = $('#search_fromdate_mulperact').val() ? $(
                            '#search_fromdate_mulperact').val() + " 00:00:00" : null;
                        var to_date = $('#search_todate_mulperact').val() ? $(
                            '#search_todate_mulperact').val() + " 23:59:59" : null;

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
                        data: 'name'
                    },
                    {
                        data: 'decrease'
                    },
                    {
                        data: 'fee'
                    },
                    {
                        data: 'undamage'
                    },
                    {
                        data: 'damage'
                    },
                    {
                        data: 'expensive_thing'
                    },
                    {
                        data: 'new_decrease'
                    },
                    {
                        data: 'new_fee'
                    },
                    {
                        data: 'new_undamage'
                    },
                    {
                        data: 'new_damage'
                    },
                    {
                        data: 'new_expensive_thing'
                    },
                    {
                        data: 'created_at'
                    }

                ],
                dom: 'lBfrtip',
                "responsive": true,
                "autoWidth": false,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                order: [
                    [16, 'desc']
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
