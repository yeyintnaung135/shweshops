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
            <!-- {{-- <x-header>-->
            <!--@foreach ($shopowner as $shopowner)-->
            <!--{{$shopowner->shop_name}}-->
            <!--        @endforeach-->

            <!--</x-header> --}}-->
            <!-- end zh header shopname -->

            <!--{{-- <x-title>-->
            <!-- Users list-->
            <!--</x-title> --}}-->
            <!-- Main content -->
            <section class="content pt-3 sn-background-light-blue">
                <div class="sn-tab-panel">
                    <ul>
                        <a class="active-panel" href="{{ route('backside.shop_owner.so_activity.u_product') }}">
                            <li>Product Activity</li>
                        </a>
                        <a href="{{ route('backside.shop_owner.so_activity.u_role') }}">
                            <li>Role Activity</li>
                        </a>
                    </ul>
                </div>

                <!--{{-- panel 2 --}}-->
                <div id="item-panel-2" class="container-fluid ">
                    <div class="row">
                        <div class="col-12">
                            <div class="sn-table-list-wrapper">
                                <!-- /.card-header -->
                                <div class="card shadow-none border-0 rounded-5 pb-2">
                                    <!--{{-- <div class="m2"> --}}-->
                                    <div class="card-header border-0">
                                        <h2>Panel Product Activity
                                            @include('backend.shopowner.toottips')
                                        </h2>
                                        <p>Check your store’s panel product activity</p>
                                    </div>
                                    <div class="d-flex justify-content-end my-3 align-items-center">
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>From Date</legend>
                                                <input type="text" id='search_fromdate_user'
                                                    class="userdatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>To Date</legend>
                                                <input type="text" id='search_todate_user'
                                                    class="userdatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="pr-md-4">
                                            <input type='button' id="user_search_button" value="Search"
                                                class="btn bg-info">
                                        </div>
                                    </div>
                                    <!--{{-- <div class="table-responsive"> --}}-->
                                    <table id="usersActivityTable" class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Product code</th>
                                                <th>Item name</th>
                                                <th>User name</th>
                                                <th>Action</th>
                                                <th>Check Edit</th>
                                                <th>Role</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!--{{-- panel 3 --}}-->
                <!-- /.container-fluid -->
            </section>
            @include('backend.shopowner.manager.editdetail')
            @include('backend.shopowner.manager.itemeditdetail')
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!--{{-- @include('layouts.backend.footer') --}}-->

        <!-- Control Sidebar -->
        <!--{{-- <aside class="control-sidebar control-sidebar-dark"> --}}-->
        <!-- Control sidebar content goes here -->
        <!--{{-- </aside> --}}-->
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
        var usersActivityTable = $('#usersActivityTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'url': "{{ route('backside.shop_owner.users.getusers_activity_Log') }}",
                'data': function(data) {
                    // Read values
                    var from_date = $('#search_fromdate_user').val() ? $('#search_fromdate_user').val() +
                        " 00:00:00" : null;
                    var to_date = $('#search_todate_user').val() ? $('#search_todate_user').val() +
                        " 23:59:59" : null;

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
                    data: 'item_name'
                },
                {
                    data: 'user_name'
                },
                {
                    data: 'action'
                },
                {
                    data: 'check',
                    render: function(data, type, row) {
                        if (row.action == 'Edit') {
                            var detail =
                                `<button class="btn btn-primary" data-toggle="modal" data-target="#item_myModal" onclick="checkItemDetail(:id, :action)"><span class="fa fa-eye"></span></button>`;
                            detail = detail.replace(':id', data);
                            detail = detail.replace(':action', "'" + row.action + "'");
                        } else {
                            detail = null;
                        }
                        return detail;
                    },
                    orderable: false
                },
                {
                    data: 'role'
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
                [7, 'desc']
            ],
        });

        $(document).ready(function() {
            $(".userdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#user_search_button').click(function() {
                if ($('#search_fromdate_user').val() != null && $('#search_todate_user').val() != null) {
                    usersActivityTable.draw();
                }
            });

            $(".roledatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#role_search_button').click(function() {
                if ($('#search_fromdate_role').val() != null && $('#search_todate_role').val() != null) {
                    backroleActivityTable.draw();
                }
            });
        });
    </script>
@endpush
