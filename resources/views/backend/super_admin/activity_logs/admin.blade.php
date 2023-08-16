@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Admin Activity')

@section('content')
    <div class="wrapper">
        <!-- Navbar -->
        @include('backend.super_admin.navbar')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('backend.super_admin.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <x-alert></x-alert>

            <!-- Content Header (Page header) -->
            {{-- <section class="content-header">
                <x-title>All Admin</x-title>
            </section> --}}

            <!-- Main content -->
            <section class="content pt-3">
                {{-- <div class="sn-tab-panel">
                  <ul>
                    <a href="{{route('activity.customer')}}"><li>User Activities</li></a>
                    <a href="{{route('activity.ads')}}"><li>Ads Activities</li></a>
                    <a href="{{route('activity.shop')}}"><li>Shop Activities</li></a>
                    <a href="{{route('activity.admin')}}" class="active-panel"><li>Admin Activities</li></a>
                  </ul>
              </div> --}}

                <div id="item-panel-2" class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="sn-table-list-wrapper">

                                <!-- /.card-header -->
                                <div class="card shadow-none border-0 rounded-5 pb-2 mt-5">
                                    <div class="card-header">
                                        <div class="">
                                            <h2>Admins Activity Lists</h2>
                                            <p>Check your Admins Activity</p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end my-3 align-items-center">
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>From Date</legend>
                                                <input type="text" id='search_fromdate_adminsact'
                                                    class="admindatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>To Date</legend>
                                                <input type="text" id='search_todate_adminsact'
                                                    class="admindatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="pr-md-4">
                                            <input type='button' id="adminsact_search_button" value="Search"
                                                class="btn bg-info">
                                        </div>
                                    </div>
                                    <table id="superAdminTable" class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Type Name</th>
                                                <th>Status</th>
                                                <th>Role</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>

                                        <tfoot>
                                            <tr>
                                                <th>id</th>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Type Name</th>
                                                <th>Status</th>
                                                <th>Role</th>
                                                <th>Date</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content -->
        {{-- </div> --}}
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
        .title {
            cursor: pointer;
        }
        .edit-section {
            display: none;
            cursor: pointer;
        }
        .sn-tab-panel ul li {
            width: 100% !important;
            background: transparent !important;
            padding: 6px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        var superAdminActivityTable = $('#superAdminTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'url': "{{ route('super_admin_role.getAdminActivity') }}",
                'data': function(data) {
                    // Read values
                    var from_date = $('#search_fromdate_adminsact').val() ? $('#search_fromdate_adminsact')
                        .val() + " 00:00:00" : null;
                    var to_date = $('#search_todate_adminsact').val() ? $('#search_todate_adminsact').val() +
                        " 23:59:59" : null;

                    // Append to data
                    data.searchByFromdate = from_date;
                    data.searchByTodate = to_date;

                }
            },

            // ajax: "{{ route('super_admin_role.getAdminActivity') }}",

            columns: [{
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'type'
                },
                {
                    data: 'type_name'
                },
                {
                    data: 'status'
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
            })

        $(document).ready(function() {
            $(".admindatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#adminsact_search_button').click(function() {
                if ($('#search_fromdate_adminsact').val() != null && $('#search_todate_adminsact').val() !=
                    null) {
                    superAdminActivityTable.draw();
                }
            });
        });
    </script>
@endpush
