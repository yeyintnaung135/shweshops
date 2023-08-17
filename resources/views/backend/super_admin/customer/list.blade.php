@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Customers Lists')

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
            {{-- <section class="content-header">
                <x-title>All Customer</x-title>
            </section> --}}

            <!-- Main content -->
            <section class="content pt-3">
                {{-- <div class="sn-tab-panel">
                  <ul>
                  <li id="item-tab-1" class="active-panel" onclick="customerTabSwitchOne()">Customer List</li>
                  <li id="item-tab-2" onclick="customerTabSwitchTwo()">Customer Activity</li>
                  </ul>
              </div> --}}
                <div id="item-panel-1" class="container-fluid">
                    <div class="row">
                        <div class="col-12">


                            <div class="sn-table-list-wrapper">

                                <!-- /.card-header -->
                                <div class="card shadow-none border-0 rounded-5 pb-2 mt-5">
                                    <div class="card-header">
                                        <div class="">
                                            <h2>Customers Lists</h2>
                                            <p>Check your Customers</p>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end my-3 align-items-center">
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>From Date</legend>
                                                <input type="text" id='search_fromdate_customer'
                                                    class="customerdatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>To Date</legend>
                                                <input type="text" id='search_todate_customer'
                                                    class="customerdatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="pr-md-4">
                                            <input type='button' id="customer_search_button" value="Search"
                                                class="btn bg-info">
                                        </div>
                                    </div>

                                    <table id="superAdminTable" class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <td>id</td>
                                                <td>Name</td>
                                                <td>Phone</td>
                                                <td>Gender</td>
                                                <td>Birthday</td>
                                                <td>Active</td>
                                                <td>Join Date</td>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <td>id</td>
                                                <td>Name</td>
                                                <td>Phone</td>
                                                <td>Gender</td>
                                                <td>Birthday</td>
                                                <td>Active</td>
                                                <td>Join Date</td>
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
                <?php /*
              <div id="item-panel-2" class="container-fluid sn-panel-hide">
                <div class="row">
                    <div class="col-12">


                        <div class="sn-table-list-wrapper">

                            <!-- /.card-header -->
                            <div class="card shadow-none border-0 rounded-5 pb-2 mt-5">
                                <div class="card-header">
                                  <div class="">
                                    <h2>Customers Activity</h2>
                                    <p>Check your Customers</p>
                                  </div>
                                </div>

                                <div class="d-flex justify-content-end my-3">
                                  <div class="form-group mr-md-2">
                                    <fieldset>
                                      <legend>From Date</legend>
                                      <input type="text" id='search_fromdate_cusAct' class="cusActdatepicker form-control" placeholder='Choose date' autocomplete="off"/>
                                    </fieldset>
                                  </div>
                                  <div class="form-group mr-md-2">
                                    <fieldset>
                                      <legend>To Date</legend>
                                      <input type="text" id='search_todate_cusAct' class="cusActdatepicker form-control" placeholder='Choose date' autocomplete="off"/>
                                    </fieldset>
                                  </div>
                                  <div class="pr-md-4">
                                    <input type='button' id="cusAct_search_button" value="Search" class="form-control bg-info" style="margin-top: 25px;">
                                  </div>
                                </div>

                                <table id="customersActivityTable" class="table table-borderless">
                                  <thead>
                                    <tr>
                                      <th>id</th>
                                      <th>Product Code</th>
                                      <th>Product Name</th>
                                      <th>User Id</th>
                                      <th>User Name</th>
                                      <th>Date</th>
                                    </tr>
                                  </thead>

                                  <tfoot>
                                    <tr>
                                       <th>id</th>
                                      <th>Product Code</th>
                                      <th>Product Name</th>
                                      <th>User Id</th>
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
            */
                ?>
                <!-- /.container-fluid -->
            </section>
            <!---- Card Body end --->
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
    </style>
@endpush

@push('scripts')
    <script>
        var customersTable = $('#superAdminTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'url': "{{ route('backside.super_admin.customers.getCustomers') }}",
                'data': function(data) {
                    // Read values
                    var from_date = $('#search_fromdate_customer').val() ? $('#search_fromdate_customer')
                        .val() + " 00:00:00" : null;
                    var to_date = $('#search_todate_customer').val() ? $('#search_todate_customer').val() +
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
                    data: 'username'
                },
                {
                    data: 'phone'
                },
                {
                    data: 'gender'
                },
                {
                    data: 'birthday'
                },
                {
                    data: 'active'
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

        $(document).ready(function() {
            $(".customerdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#customer_search_button').click(function() {
                if ($('#search_fromdate_customer').val() != null && $('#search_todate_customer').val() !=
                    null) {
                    customersTable.draw();
                }
            });
        });
        $(document).ready(function() {
            $(".cusActdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#cusAct_search_button').click(function() {
                if ($('#search_fromdate_cusAct').val() != null && $('#search_todate_cusAct').val() !=
                    null) {
                    customersActivityTable.draw();
                }
            });
        });

        function get(obj) {
            return document.getElementById(obj);
        }

        function itemTab_Panel(tab_active, tab2, panel_remove, panel2) {
            get(tab_active).classList.add("active-panel");
            get(tab2).classList.remove("active-panel");

            get(panel_remove).classList.remove("sn-panel-hide");
            get(panel2).classList.add("sn-panel-hide");
        }

        function customerTabSwitchOne() {
            itemTab_Panel("item-tab-1", "item-tab-2", "item-panel-1", "item-panel-2");
        }

        function customerTabSwitchTwo() {
            itemTab_Panel("item-tab-2", "item-tab-1", "item-panel-2", "item-panel-1");
        }
    </script>
@endpush
