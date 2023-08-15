@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Ads Views')

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
                <x-title>Ads View</x-title>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="sn-table-list-wrapper">
                            <div class="card shadow-none border-0 rounded-5 pb-2 mt-5">
                                <div class="card-header">
                                    <div class="">
                                        <h2>Ads List</h2>
                                        <p>Check your Ads List</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end my-3 align-items-center">
                                    <div class="form-group mr-md-2">
                                        <fieldset>
                                            <legend>From Date</legend>
                                            <input type='text' id='search_fromdate_ads'
                                                class="adsdatepicker form-control" placeholder='Choose date'
                                                autocomplete="off">
                                        </fieldset>
                                    </div>
                                    <div class="form-group mr-md-2">
                                        <fieldset>
                                            <legend>To Date</legend>
                                            <input type='text' id='search_todate_ads' class="adsdatepicker form-control"
                                                placeholder='Choose date' autocomplete="off">
                                        </fieldset>
                                    </div>
                                    <div class="pr-md-4">
                                        <input type='button' id="ads_search_button" value="Search" class="btn bg-info">
                                    </div>
                                </div>

                                <table id="adsCountTable" class="table table-borderless">
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
            var adsCountTable = $('#adsCountTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ route('adscount.getAllAdsCount') }}",
                    'data': function(data) {
                        // Read values
                        var from_date = $('#search_fromdate_ads').val() ? $('#search_fromdate_ads')
                            .val() + " 00:00:00" : null;
                        var to_date = $('#search_todate_ads').val() ? $('#search_todate_ads').val() +
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
            })

            $(".adsdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#ads_search_button').click(function() {
                if ($('#search_fromdate_ads').val() != null && $('#search_todate_ads').val() != null) {
                    adsCountTable.draw();
                }
            });
        });
    </script>
@endpush
