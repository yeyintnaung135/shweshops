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
                <x-alert></x-alert>
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
                <!-- <div class="sn-tab-panel">
                      <ul>
                        <li id="item-tab-1" class="active-panel" onclick="itemTabSwitchOne()">Shop View List</li>
                      </ul>
                    </div> -->

                <!--{{-- panel 1 --}}-->
                <div id="item-panel-1" class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="sn-table-list-wrapper">
                                <div class="border-bottom-0 mt-4 mr-2">

                                </div>
                                <!-- /.card-header -->
                                <div class="card shadow-none border-0 rounded-5 pb-2">
                                    <!--{{-- <div class="m2"> --}}-->
                                    <div class="card-header border-0">
                                        <h2>Panel Unique Product View List</h2>
                                        <p>Check your unique product view</p>
                                    </div>
                                    <!--{{-- <div class="table-responsive"> --}}-->
                                    <table id="uniqueitemsActivityTable" class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Product Code</th>
                                                <th>Product Name</th>
                                                <th>User Id</th>
                                                <th>User Name</th>
                                                <th>Created Date</th>
                                            </tr>
                                        </thead>

                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Product Code</th>
                                                <th>Product Name</th>
                                                <th>User Id</th>
                                                <th>User Name</th>
                                                <th>Created Date</th>
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

@push('scripts')
    <script>
        $('#uniqueitemsActivityTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('backside.shop_owner.items.uniquegetitems_activity_log') }}",

                columns: [{
                        data: 'id',
                    },
                    {
                        data: 'item_code'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'user_id'
                    },
                    {
                        data: 'user_name'
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
            });
    </script>
@endpush
