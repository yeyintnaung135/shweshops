@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Directory List')

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
                                            <h2>Shop Directory Lists</h2>
                                        </div>
                                        <a href=" {{ url('backside/super_admin/directory/create') }} "
                                            class="btn btn-primary">Add New Shop Directory</a>
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
                                                <th>Name</th>
                                                <!-- <th>Myanamr Name</th> -->
                                                <th>Shop Logo</th>
                                                <!-- <th>Description</th> -->
                                                <!-- <th>undamaged_product</th>
                                                        <th>valuable_product</th>
                                                        <th>damaged_product</th> -->
                                                <!-- <th>Messanger Link</th>
                                                        <th>Page Link</th> -->
                                                <th>Main Phone</th>
                                                <th>Action</th>
                                                <th>created at</th>
                                                <!--<th>Action</th> -->
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
                "url": "{{ url('backside/super_admin/directory/alldirect') }}",
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
                // {data: 'shop_name_myan'},
                {
                    data: 'shop_logo',
                    render: function(data, type) {
                        if (data) {
                            var image = `<img src="{{ url('/images/directory/' . ':img') }}"
                          class="rounded-circle" width="50"
                          height="45" alt="Logo" />`;
                            image = image.replace(':img', data);
                            return image;
                        } else {
                            return data;
                        }
                    }
                },

                // {data: 'description'},
                // {data: 'undamaged_product'},
                // {data: 'valuable_product'},
                // {data: 'damaged_product'},
                // {data: 'messenger_link'},
                // {data: 'page_link'},

                {
                    data: 'main_phone'
                },
                {
                    data: 'id',
                    render: function(data, type) {
                        var edit = `<a href="{{ url('backside/super_admin/directory/edit/' . ':id') }}" role="button" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Shop Edit">
                        <i class="fa fa-edit"></i>
                      </a>`;
                        edit = edit.replace(':id', data);
                        var detail = `
                      <a href="{{ url('backside/super_admin/directory/detail/' . ':id') }}" role="button" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Shop Detail">
                        <i class="fa fa-eye"></i>
                      </a>`;
                        var detail = detail.replace(':id', data);
                        var del = `<form action="{{ url('backside/super_admin/directory/delete') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value=":id">
                        <button type="button" onclick="deleteShop(this)" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Move To Trash">
                        <i class="fa fa-trash"></i>
                        </button>

                      </form>
`;
                        var del = del.replace(':id', data);

                        return ` <div class="d-flex justify-content-around w-75">
                     ${detail + edit + del}
                </div>`;

                    }
                },
                {
                    data: 'created_at'
                }

            ],

            responsive: true,
            lengthChange: true,
            autoWidth: false,
            paging: true,
            dom: 'Blfrtip',
            buttons: ["copy", "csv", "excel", "pdf", "print"],
            columnDefs: [{
                    responsivePriority: 1,
                    targets: 1
                },
                {
                    responsivePriority: 2,
                    targets: 2
                },
                {
                    responsivePriority: 3,
                    targets: 3
                },
                {
                    responsivePriority: 4,
                    targets: 4
                }

            ],
            language: {
                "search": '<i class="fa fa-search"></i>',
                "searchPlaceholder": 'Search',
                paginate: {
                    next: '<i class="fa fa-angle-right"></i>', // or '→'
                    previous: '<i class="fa fa-angle-left"></i>' // or '←'
                }
            },

            "order": [
                [5, "desc"]
            ],
        });

        $(document).ready(function() {
            $(".shopdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#shop_search_button').click(function() {
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
