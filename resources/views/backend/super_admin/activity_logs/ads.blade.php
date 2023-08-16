@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Ads Activity')

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
            <x-title>All Customer</x-title>
        </section> --}}

            <!-- Main content -->
            <section class="content pt-3">
                {{-- <div class="sn-tab-panel">
                    <ul>
                    <a href="{{route('activity.customer')}}"><li>User Activities</li></a>
                    <a href="{{route('activity.ads')}}" class="active-panel"><li>Ads Activities</li></a>
                    <a href="{{route('activity.shop')}}"><li>Shop Activities</li></a>
                    <a href="{{route('activity.admin')}}"><li>Admin Activities</li></a>
                    </ul>
                </div> --}}

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">


                            <div class="sn-table-list-wrapper">

                                <!-- /.card-header -->
                                <div class="card shadow-none border-0 rounded-5 pb-2 mt-5">
                                    <div class="card-header">
                                        <div class="">
                                            <h2>Ads Activity Lists</h2>
                                            <p>Check your Ads Activity</p>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end my-3 align-items-center">
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>From Date</legend>
                                                <input type="text" id='search_fromdate_adsact'
                                                    class="adsactdatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>To Date</legend>
                                                <input type="text" id='search_todate_adsact'
                                                    class="adsactdatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="pr-md-4">
                                            <input type='button' id="adsact_search_button" value="Search"
                                                class="btn bg-info">
                                        </div>
                                    </div>

                                    <table id="superAdminTable" class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <td>id</td>
                                                <td>Name</td>
                                                <td>Type</td>
                                                <td>Type Name</td>
                                                <td>Status</td>
                                                <td>Role</td>
                                                <td>Date</td>
                                            </tr>
                                        </thead>

                                        <tfoot>
                                            <tr>
                                                <td>id</td>
                                                <td>Name</td>
                                                <td>Type</td>
                                                <td>Type Name</td>
                                                <td>Status</td>
                                                <td>Role</td>
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
        $(document).ready(function() {
            var adsActivityTable = $('#superAdminTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    'url': "{{ route('ads.getAdsActivity') }}",
                    'data': function(data) {
                        // Read values
                        var from_date = $('#search_fromdate_adsact').val() ? $(
                            '#search_fromdate_adsact').val() + " 00:00:00" : null;
                        var to_date = $('#search_todate_adsact').val() ? $('#search_todate_adsact')
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
                        data: 'created_at_formatted'
                    }

                ],
                dom: 'lBfrtip',
                "responsive": true,
                "autoWidth": false,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });

            $(".adsactdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#adsact_search_button').click(function() {
                if ($('#search_fromdate_adsact').val() != null && $('#search_todate_adsact').val() !=
                    null) {
                    adsActivityTable.draw();
                }
            });
        });
    </script>
@endpush

