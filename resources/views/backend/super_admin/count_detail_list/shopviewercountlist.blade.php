@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Shop Viewes')

@section('content')
    <div class="wrapper">
        <!-- Navbar -->
        @include('backend.super_admin.navbar')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('backend.super_admin.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <x-alert> </x-alert>

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <x-title>Shop Viewer</x-title>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="sn-table-list-wrapper">
                            <div class="card shadow-none border-0 rounded-5 pb-2 mt-5">
                                <div class="card-header">
                                    <div class="">
                                        <h2>Shop Viewer List</h2>
                                        <p>Check your Shop Viewers List</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end my-3 align-items-center">
                                    <div class="form-group mr-md-2">
                                        <fieldset>
                                            <legend>From Date</legend>
                                            <input type='text' id='search_fromdate_shopviewer'
                                                class="shopviewerdatepicker form-control" placeholder='Choose date'
                                                autocomplete="off">
                                        </fieldset>
                                    </div>
                                    <div class="form-group mr-md-2">
                                        <fieldset>
                                            <legend>To Date</legend>
                                            <input type='text' id='search_todate_shopviewer'
                                                class="shopviewerdatepicker form-control" placeholder='Choose date'
                                                autocomplete="off">
                                        </fieldset>
                                    </div>
                                    <div class="pr-md-4">
                                        <input type='button' id="shopviewer_search_button" value="Search"
                                            class="btn bg-info">
                                    </div>
                                </div>

                                <table id="shopVisitorTable" class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <td>Id</td>
                                            <td>Shop</td>
                                            <td>Shop Name</td>
                                            <td>User Id</td>
                                            <td>User Name</td>
                                            <td>Created At</td>
                                            {{-- <td>Deleted At</td> --}}
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <td>Id</td>
                                            <td>Shop</td>
                                            <td>Shop Name</td>
                                            <td>User Id</td>
                                            <td>User Name</td>
                                            <td>Created At</td>
                                            {{-- <td>Deleted At</td> --}}
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    {{-- <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0-rc
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">MOE</a>.</strong> All rights
            reserved.
        </footer> --}}

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
@endsection

@push('scripts')
    <script>
        var shopVisitorTable = $('#shopVisitorTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ route('shopviewercount.getAllShopviewerCount') }}",
                'data': function(data) {
                    // Read values
                    var from_date = $('#search_fromdate_shopviewer').val() ? $('#search_fromdate_shopviewer')
                        .val() + " 00:00:00" : null;
                    var to_date = $('#search_todate_shopviewer').val() ? $('#search_todate_shopviewer').val() +
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
                    data: 'shop'
                },
                {
                    data: 'shop_name'
                },
                {
                    data: 'user_id'
                },
                {
                    data: 'user_name'
                },
                {
                    data: 'created_at_formatted'
                },
            ],
            dom: 'lBfrtip',
            "responsive": true,
            "autoWidth": false,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
        })

        $(document).ready(function() {
            $(".shopviewerdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#shopviewer_search_button').click(function() {
                if ($('#search_fromdate_shopviewer').val() != null && $('#search_todate_shopviewer')
                    .val() != null) {
                    shopVisitorTable.draw();
                }
            });
        });
    </script>
@endpush
