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
                                        <h2>Panel Unique Ads View List</h2>
                                        <p>Check your Unique Ads View Click</p>
                                    </div>
                                    <!--{{-- <div class="table-responsive"> --}}-->
                                    <table id="uniqueadsTable" class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>User ID</th>
                                                <th>User Name</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>

                                        <tfoot>
                                            <tr>

                                                <th>ID</th>
                                                <th>User ID</th>
                                                <th>User Name</th>
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
        function get(obj) {
            return document.getElementById(obj);
        }
        // function itemTab_Panel (tab_active, tab2, tab3, panel_remove, panel2, panel3) {
        //   get(tab_active).classList.add("active-panel");
        //   get(tab2).classList.remove("active-panel");
        //   get(tab3).classList.remove("active-panel");

        //   get(panel_remove).classList.remove("sn-panel-hide");
        //   get(panel2).classList.add("sn-panel-hide");
        //   get(panel3).classList.add("sn-panel-hide");
        // }
        // function itemTabSwitchOne() {
        //   itemTab_Panel("item-tab-1", "item-tab-2", "item-tab-3", "item-panel-1", "item-panel-2", "item-panel-3");
        // }
        // function itemTabSwitchTwo() {
        //   itemTab_Panel("item-tab-2", "item-tab-1", "item-tab-3", "item-panel-2", "item-panel-1", "item-panel-3");
        // }
        // function itemTabSwitchThree() {
        //   itemTab_Panel("item-tab-3", "item-tab-1", "item-tab-2", "item-panel-3", "item-panel-1", "item-panel-2");
        // }
    </script>
@endpush
