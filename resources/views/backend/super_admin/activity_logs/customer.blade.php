@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Viewers Activity')

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
            <x-title>Website Viewer</x-title>
            </section> --}}

            <!-- Main content -->
            <section class="content pt-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">


                            <div class="sn-table-list-wrapper">

                                <!-- /.card-header -->
                                <div class="card shadow-none border-0 rounded-5 pb-2 mt-5">
                                    <div class="card-header">
                                        <div class="">
                                            <h2>Website Visitor List</h2>
                                            <p>Check your Website Visitor</p>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="d-flex justify-content-end align-items-center">
                                            <div class="form-group mr-md-2">
                                                <fieldset>
                                                    <legend>From Date</legend>
                                                    <input type="text" id='search_fromdate_visitor'
                                                        class="visitordatepicker form-control" placeholder='Choose date'
                                                        autocomplete="off" />
                                                </fieldset>
                                            </div>
                                            <div class="form-group mr-md-2">
                                                <fieldset>
                                                    <legend>To Date</legend>
                                                    <input type="text" id='search_todate_visitor'
                                                        class="visitordatepicker form-control" placeholder='Choose date'
                                                        autocomplete="off" />
                                                </fieldset>
                                            </div>
                                            <div class="pr-md-4">
                                                <input type='button' id="visitor_search_button" value="Search"
                                                    class="btn bg-info">
                                            </div>
                                        </div>

                                        <table id="superAdminTable" class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <td>Id</td>
                                                    <td>User Name</td>
                                                    <td>Status</td>
                                                    <td>Product Code</td>
                                                    <td>User Id</td>
                                                    <td>Date</td>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <td>Id</td>
                                                    <td>User Name</td>
                                                    <td>Status</td>
                                                    <td>Product Code</td>
                                                    <td>User Id</td>
                                                    <td>Date</td>
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
                        <!-- /.row -->
                    </div>
                    <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
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
        $(document).ready(function() {
            var websiteVisitorTable = $('#superAdminTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ route('backside.super_admin.visitorcount.getAllVisitor') }}",
                    'data': function(data) {
                        // Read values
                        var from_date = $('#search_fromdate_visitor').val() ? $(
                            '#search_fromdate_visitor').val() + " 00:00:00" : null;
                        var to_date = $('#search_todate_visitor').val() ? $('#search_todate_visitor')
                            .val() + " 23:59:59" : null;

                        // Append to data
                        data.searchByFromdate = from_date;
                        data.searchByTodate = to_date;
                    }
                },

                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'user_name',
                        name: 'guest_or_user.user.username',
                    },
                    {
                        data: 'modified_status',
                        name: 'modified_status',
                    },
                    {
                        data: 'product_code',
                        name: 'item.product_code',
                    },
                    {
                        data: 'guest_or_user_id',
                        name: 'guest_or_user_id',

                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                    },
                ],
                dom: 'lBfrtip',
                "responsive": true,
                "autoWidth": false,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                order: [
                    [5, 'desc']
                ],
            });

            $(".visitordatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#visitor_search_button').click(function() {
                if ($('#search_fromdate_visitor').val() != null && $('#search_todate_visitor').val() !=
                    null) {
                    websiteVisitorTable.draw();
                }
            });
        });
    </script>
@endpush
