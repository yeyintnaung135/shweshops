@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Messenger Log Detail')
@section('content')
    <div class="wrapper">
        @include('backend.super_admin.loading')

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
            <x-title>All Shops</x-title>
        </section> --}}

            <!-- Main content -->
            <section class="content pt-3">
                {{-- <div class="sn-tab-panel">
                      <ul>
                      <li id="item-tab-1" class="active-panel" onclick="shopTabSwitchOne()">Shop List</li>
                      <li id="item-tab-2" onclick="shopTabSwitchTwo()">Shop Activity</li>
                      </ul>
                  </div> --}}
                <div id="item-panel-1" class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="sn-table-list-wrapper">
                                <div class="card shadow-none border-0 rounded-5 pb-2 mt-5">
                                    <div class="card-header">
                                        <div class="">
                                            <h2>Shop connected with facebook Lists</h2>
                                            <h2>All Count : <span id="totalcount"></span></h2>
                                            <h2> Count By Date : <span id="totalcountd"></span></h2>

                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end my-3 align-items-center">
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>From Date</legend>
                                                <input type="text" id='search_fromdate_shop'
                                                    class="shopdatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>To Date</legend>
                                                <input type="text" id='search_todate_shop'
                                                    class="shopdatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="pr-md-4">
                                            <input type='button' id="shop_search_button" value="Search"
                                                class="btn bg-info">
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <table id="superAdminTable" class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>User Name</th>
                                                <th>User Phone</th>

                                                <th>Item Code</th>
                                                <th>Item Name</th>
                                                <th>Item Photo</th>
                                                <th>Created Date</th>

                                            </tr>
                                        </thead>
                                    </table>
                                    <!-- /.card-body -->
                                </div>
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
    </style>
@endpush

@push('scripts')
    <script>
        var shopsTable = $('#superAdminTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ url('backside/super_admin/fbdata/messenger/log/get_detail') }}",
                'data': function(data) {
                    // Read values
                    var from_date = $('#search_fromdate_shop').val() ? $('#search_fromdate_shop').val() +
                        " 00:00:00" : null;
                    var to_date = $('#search_todate_shop').val() ? $('#search_todate_shop').val() +
                        " 23:59:59" : null;
                    var shopid = "{{ $shop_id }}";
                    // Append to data
                    data.fromDate = from_date;
                    data.toDate = to_date;
                    data.shop_id = shopid;
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
                    data: 'item_name'
                },
                {
                    data: 'item_code'
                },
                {
                    data: 'item_photo',
                    render: function(data, type) {
                        const image =
                            `<img style="width:150px;height:150px;" src= "{{ url('${data}') }}"/>`;
                        return image;
                    }
                },

                {
                    data: 'created_at'
                },


            ],
            dom: 'lBfrtip',
                "responsive": true,
                "autoWidth": false,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
        });

        $(document).ready(function() {
            var gettotal = () => {
                $.post(
                    "{{ url('backside/super_admin/fbdata/messenger/getmsglogcount') }}", {
                        from: $('#search_fromdate_shop').val() + " 00:00:00",
                        to: $('#search_todate_shop').val() + " 23:59:59",
                        _token: "{{ csrf_token() }}"
                    },
                    function(data, status) {
                        $('#totalcount').text(data.all);
                        $('#totalcountd').text(data.alld);

                    }
                );
            };
            gettotal();
            $(".shopdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#shop_search_button').click(function() {
                gettotal();

                if ($('#search_fromdate_shop').val() != null && $('#search_todate_shop').val() != null) {
                    shopsTable.draw();
                }
            });

            $(".shopactdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#shopact_search_button').click(function() {
                if ($('#search_fromdate_shopact').val() != null && $('#search_todate_shopact').val() !=
                    null) {
                    shopActivityTable.draw();
                }
            });
        });
        $("#loader").hide();
        $(function() {

            $("#post").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"],
                // 'columnDefs': [
                //     { responsivePriority: 1, targets: 0 },
                //     { responsivePriority: 2, targets: 4 },
                //     { responsivePriority: 3, targets: 2 },
                //     { responsivePriority: 4, targets: 1},
                // ],
                "order": [0, 'desc']
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            $(".title").click(function(e) {
                $(e.target).children().toggle(500);
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

        function shopTabSwitchOne() {
            itemTab_Panel("item-tab-1", "item-tab-2", "item-panel-1", "item-panel-2");
        }

        function shopTabSwitchTwo() {
            itemTab_Panel("item-tab-2", "item-tab-1", "item-panel-2", "item-panel-1");
        }

        function deleteShop(e) {
            if (window.confirm("Are you sure to delete?")) {
                $(e.form).submit();
                $("#loader").show();
            }
        }
    </script>
@endpush

