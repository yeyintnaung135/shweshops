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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">


                            <div class="sn-table-list-wrapper">

                                <!-- /.card-header -->
                                <div class="card shadow-none border-0 rounded-5 pb-2 mt-5">
                                    <div class="card-header">
                                        <div class="">
                                            <h2>Orders Lists</h2>
                                            <p>Check your Orders</p>
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
                                                <td>ID</td>
                                                <td>Name</td>
                                                <td>Phone</td>
                                                <td>Product Name</td>
                                                <td>Product Code</td>
                                                <td>Shop Name</td>
                                                <td> Date</td>
                                                <td>Action</td>

                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <td>ID</td>
                                                <td>Name</td>
                                                <td>Phone</td>
                                                <td>Product Name</td>
                                                <td>Product Code</td>
                                                <td>Shop Name</td>
                                                <td> Date</td>
                                                <td>Action</td>
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
                'url': "{{ url('/backside/super_admin/get_orders') }}",
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
                    data: 'user_name'
                },
                {
                    data: 'user_phone'
                },
                {
                    data: 'product_name'
                },
                {
                    data: 'product_code'
                },
                {
                    data: 'shop_name'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'action',
                    render: function(data) {
                        var detail = `
                      <a href="{{ url('backside/super_admin/orders/detail/:id') }}" role="button" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Shop Detail">
                        <i class="fa fa-eye"></i>
                      </a>
                    `;
                    var detail = detail.replace(':id', data);

                        return   detail;

                    
                }
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
            $(".customerdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#customer_search_button').click(function() {
                if ($('#search_fromdate_customer').val() != null && $('#search_todate_customer')
                    .val() !=
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
