@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Products List')

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
            <x-alert> </x-alert>

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
                                            <h2>Items Lists By Shops</h2>
                                            <h2>ALL Items Count : <span id="totalcount"></span></h2>
                                            <h2>ALL Items Count By date : <span id="totalcountd"></span></h2>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end my-3 align-items-center">
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>From Date</legend>
                                                <input type="text" id='search_fromdate_shop'
                                                value="{{ date('Y-m-d') }}" class="shopdatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>To Date</legend>
                                                <input type="text" id='search_todate_shop'
                                                value="{{ date('Y-m-d') }}" class="shopdatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="pr-md-4">
                                            <input type='button' id="shop_search_button" value="Search"
                                                class="form-control bg-info">
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <table id="superAdminTable" class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Name</th>
                                                <th>Shop Logo</th>
                                                <th>Shop Banner</th>
                                                <th>Type</th>
                                                <th>Product Counts</th>
                                                <th>Main Phone</th>
                                                <th>Created At</th>
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
                "url": "{{ route('backside.super_admin.items.getItemsAjax') }}",
                'data': function(data) {
                    // Read values
                    var from_date = $('#search_fromdate_shop').val() ? $('#search_fromdate_shop').val() +
                        " 00:00:00" : null;
                    var to_date = $('#search_todate_shop').val() ? $('#search_todate_shop').val() +
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
                    data: 'shop_name'
                },
                {
                    data: 'shop_logo',
                    render: function(data, type) {
                        console.log(data);
                        var image = `<img src="{{ url('/images/logo/' . ':img') }}"
                          class="rounded-circle" width="50"
                          height="45" alt="Logo" />`;
                        image = image.replace(':img', data);
                        return image;
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'shop_banner',
                    render: function(data, type) {
                        var image = `<img src="{{ url('/images/banner/' . ':img') }}"
                          alt="cover" class="rounded-circle" width="50"
                          height="45"/>`;
                        image = image.replace(':img', data);
                        return image;
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'premium',
                    render: function(data, type) {
                        if (data == 'yes') {
                            return "Premium"
                        } else {
                            return "Normal"
                        }
                    }
                },
                {
                    data: 'items',
                    name: 'items_count',
                    searchable: false
                },
                {
                    data: 'main_phone'
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
            order: [
                    [7, 'desc']
                ],
        });

        $(document).ready(function() {
            var gettotal = () => {
                $.post(
                    "{{ url('backside/super_admin/items/total_create_count') }}", {
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
