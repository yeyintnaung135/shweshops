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
                {{-- <div class="sn-tab-panel">
                  <ul>
                    <li id="item-tab-1" class="active-panel" onclick="itemTabSwitchOne()">User List</li>
                    <li id="item-tab-2" onclick="itemTabSwitchTwo()">Product Activity</li>
                    <li id="item-tab-3"  onclick="itemTabSwitchThree()">Role Activity</li>
                  </ul>
                </div> --}}
                <!--{{-- panel 1 --}}-->
                <div id="item-panel-1" class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="sn-table-list-wrapper">
                                <div class="border-bottom-0 mt-4 mr-2">
                                    <a href="{{ url('backside/shop_owner/users/create') }}"
                                        class="btn btn-primary float-right"><span
                                            class="fa fa-plus-circle"></span>&nbsp;&nbsp;Add New User
                                    </a>
                                    <br><br>
                                </div>
                                <div class="card shadow-none border-0 rounded-5 pb-2">
                                    <div class="card-header border-0">
                                        <h2>Panel Users List @include('backend.shopowner.toottips')
                                        </h2>
                                        <p>Check your store’s panel users list</p>
                                    </div>

                                    <table id="datatable" class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Phone-no</th>
                                                <th>Role</th>
                                                <th>Action</th>
                                                <!--{{-- <th>Created Date</th> --}}-->
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($managers as $manager)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $manager->name }}</td>
                                                    <td>{{ $manager->phone }}</td>
                                                    <td>{{ $manager->role->name }}</td>
                                                    <td><a class="btn btn-sm btn-success"
                                                            href="{{ route('backside.shop_owner.managers.detail', $manager->id) }}"><span
                                                                class="fa fa-info-circle"></span></a>
                                                        <a class="btn btn-sm btn-primary"
                                                            href="{{ route('backside.shop_owner.managers.edit', $manager->id) }}"><span
                                                                class="fa fa-edit"></span></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Phone-no</th>
                                                <th>Role</th>
                                                <th>Action</th>
                                                <!--{{-- <th>Created Date</th> --}}-->
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php /*
                <!--{{-- panel 2 --}}-->
                <div id="item-panel-2" class="container-fluid sn-panel-hide">
                      <div class="row">
                        <div class="col-12">


                            <div class="sn-table-list-wrapper">
                                <div class="border-bottom-0 mt-4 mr-2">
                                <a href="{{url('backside/shop_owner/users/create')}}" class="btn btn-primary float-right"><span class="fa fa-plus-circle"></span>&nbsp;&nbsp;Add New User
                                    </a>
                                    <br><br>
                                </div>
                                <!-- /.card-header -->
                                <div class="card shadow-none border-0 rounded-5 pb-2">
                                  <!--{{-- <div class="m2"> --}}-->
                                   <div class="card-header border-0">
                                    <h2>Panel Product Activity</h2>
                                    <p>Check your store’s panel product activity</p>
                                   </div>
                                   <div class="d-flex justify-content-end my-3">
                                    <div class="form-group mr-md-2">
                                      <fieldset>
                                        <legend>From Date</legend>
                                        <input type="text" id='search_fromdate_user' class="userdatepicker form-control" placeholder='Choose date' autocomplete="off"/>
                                      </fieldset>
                                    </div>
                                    <div class="form-group mr-md-2">
                                      <fieldset>
                                        <legend>To Date</legend>
                                        <input type="text" id='search_todate_user' class="userdatepicker form-control" placeholder='Choose date' autocomplete="off"/>
                                      </fieldset>
                                    </div>
                                    <div class="pr-md-4">
                                      <input type='button' id="user_search_button" value="Search" class="form-control bg-info" style="margin-top: 25px;">
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
                                          <th>Check</th>
                                          <th>Role</th>
                                          <th>Date</th>
                                        </tr>
                                        </thead>

                                        <tfoot>
                                        <tr>

                                          <th>ID</th>
                                          <th>Product code</th>
                                          <th>Item name</th>
                                          <th>User name</th>
                                          <th>Action</th>
                                          <th>Check</th>
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
                    <!-- /.row -->
                </div>
                <!--{{-- panel 3 --}}-->
                <div id="item-panel-3" class="container-fluid sn-panel-hide">
                      <div class="row">
                        <div class="col-12">


                            <div class="sn-table-list-wrapper">
                                <div class="border-bottom-0 mt-4 mr-2">
                                <a href="{{url('backside/shop_owner/users/create')}}" class="btn btn-primary float-right"><span class="fa fa-plus-circle"></span>&nbsp;&nbsp;Add New User
                                    </a>
                                    <br><br>
                                </div>
                                <!-- /.card-header -->
                                <div class="card shadow-none border-0 rounded-5 pb-2">
                                  <!--{{-- <div class="m2"> --}}-->
                                   <div class="card-header border-0">
                                    <h2>Panel Role Activity</h2>
                                    <p>Check your store’s panel role activity</p>
                                   </div>
                                   <div class="d-flex justify-content-end my-3">
                                    <div class="form-group mr-md-2">
                                      <fieldset>
                                        <legend>From Date</legend>
                                        <input type="text" id='search_fromdate_role' class="roledatepicker form-control" placeholder='Choose date' autocomplete="off"/>
                                      </fieldset>
                                    </div>
                                    <div class="form-group mr-md-2">
                                      <fieldset>
                                        <legend>To Date</legend>
                                        <input type="text" id='search_todate_role' class="roledatepicker form-control" placeholder='Choose date' autocomplete="off"/>
                                      </fieldset>
                                    </div>
                                    <div class="pr-md-4">
                                      <input type='button' id="role_search_button" value="Search" class="form-control bg-info" style="margin-top: 25px;">
                                    </div>
                                  </div>
                                    <!--{{-- <div class="table-responsive"> --}}-->

                                      <table id="backroleActivityTable" class="table table-borderless">
                                          <thead>
                                          <tr>
                                            <th>ID</th>
                                            <th>User Name</th>
                                            <th>User Role</th>
                                            <th>Action</th>
                                            <th>Check</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Date</th>
                                          </tr>
                                          </thead>

                                          <tfoot>
                                          <tr>

                                            <th>ID</th>
                                            <th>User Name</th>
                                            <th>User Role</th>
                                            <th>Action</th>
                                            <th>Check</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Date</th>
                                          </tr>
                                          </tfoot>
                                      </table>
                                    <!--{{-- </div> --}}-->
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                      </div>
                    <!-- /.row -->
                </div>
                */
                ?>
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
        $("#datatable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            'columnDefs': [{
                    responsivePriority: 1,
                    targets: 2
                },
                {
                    responsivePriority: 2,
                    targets: 1
                },
                {
                    responsivePriority: 3,
                    targets: 3
                },
                {
                    "targets": [4],
                    'orderable': false,
                }
            ],
            language: {
                "search": '<i class="fa-solid fa-search sn-search-icon"></i>',
                "searchPlaceholder": 'Search by name or role or phone',
                paginate: {
                    next: '<i class="fa fa-angle-right"></i>', // or '→'
                    previous: '<i class="fa fa-angle-left"></i>' // or '←'
                }
            },
            "order": [0, 'desc']
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

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

        function get(obj) {
            return document.getElementById(obj);
        }

        function itemTab_Panel(tab_active, tab2, tab3, panel_remove, panel2, panel3) {
            get(tab_active).classList.add("active-panel");
            get(tab2).classList.remove("active-panel");
            get(tab3).classList.remove("active-panel");

            get(panel_remove).classList.remove("sn-panel-hide");
            get(panel2).classList.add("sn-panel-hide");
            get(panel3).classList.add("sn-panel-hide");
        }

        function itemTabSwitchOne() {
            itemTab_Panel("item-tab-1", "item-tab-2", "item-tab-3", "item-panel-1", "item-panel-2", "item-panel-3");
        }

        function itemTabSwitchTwo() {
            itemTab_Panel("item-tab-2", "item-tab-1", "item-tab-3", "item-panel-2", "item-panel-1", "item-panel-3");
        }

        function itemTabSwitchThree() {
            itemTab_Panel("item-tab-3", "item-tab-1", "item-tab-2", "item-panel-3", "item-panel-1", "item-panel-2");
        }
    </script>
@endpush
