@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Shop Chat')

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
            <!-- Main content -->
            <section class="content pt-3">
                <div id="item-panel-1" class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="sn-table-list-wrapper">
                                <div class="card shadow-none border-0 rounded-5 pb-2 mt-5">
                                    <div class="card-header">
                                        <div class="">
                                            <h2> Using Chat Lists </h2>
                                            <p>Check your Shops</p>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end my-3">
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
                                        <div class="pr-md-4 mt-4">
                                            <input type='button' id="shop_search_button" value="Search"
                                                class="btn bg-info">
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <table id="shopsUsingChatTable" class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Shop</th>
                                                <th class="text-center">Only Shopowner chat's count
                                                    <div class="badge badge-primary " data-toggle="tooltip"
                                                        data-placement="top" title="">
                                                        {{ count($shopowner_only_count) }}
                                                    </div>
                                                </th>
                                                <th class="text-center">User Inquiry count</th>
                                                <th>Detail</th>
                                                <th>Created Date</th>
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

        .sn-table-list-wrapper #shopsUsingChatTable_filter {
            position: relative;
        }

        .sn-table-list-wrapper #shopsUsingChatTable_filter i {
            position: absolute;
            top: 9px;
            left: 10px;
            color: #afafaf;
        }

        .sn-table-list-wrapper #shopsUsingChatTable_filter {
            width: 50%;
            clear: both;
            float: right;
            margin-right: 7px;
        }

        .badge-w {
            width: 50px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $("#loader").hide();

        var shopsUsingChatTable = $('#shopsUsingChatTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ route('backside.super_admin.shopowner_using_chat_all') }}",
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
                    data: 'name'
                },
                {
                    data: 'owner_chat_count',
                    render: function(data, type, row, meta) {
                        if (data === 0) {
                            var count = `
                      <div class="w-100 d-flex justify-content-center">
                         <div class="badge badge-danger badge-w" data-toggle="tooltip" data-placement="top" title="">
                          0
                         </div>
                      </div>
                  `;
                        } else {
                            var count = `
              <div class="w-100 d-flex justify-content-center">
               <a href="#" role="button" class="badge badge-info badge-w" data-toggle="tooltip" data-placement="top" title="view detail">
                ${data}
              </a>
              </div>
              `;
                            $(".shopChatcount").append(`
                  <span>${data.length}</span>
              `);

                            var count = count.replace(':id', row.action);
                        }

                        return count;
                    }
                },
                {
                    data: 'user_chat_count',
                    render: function(data, type, row) {
                        var count = `
                      <div class="w-100 d-flex justify-content-center">
                         <div class="badge badge-primary badge-w" data-toggle="tooltip" data-placement="top" title="">
                           ${row.user_chat_count}
                         </div>
                      </div>
                  `;



                        return count;
                    }
                },
                {
                    data: 'action',
                    render: function(data, type) {
                        var detail = `
                      <a href="{{ route('backside.super_admin.shopowner_using_chat_detail', ':action') }}" role="button" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Detail">
                        <i class="fa fa-eye"></i>
                      </a>
          `;
                        var detail = detail.replace(':action', data);

                        return detail;
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
                    'targets': [1, 2, 3],
                    'orderable': false,
                },
                {
                    'targets': [5],
                    'visible': false,
                    'searchable': false,
                }
            ],
            language: {
                "search": '<i class="fa-solid fa-search"></i>',
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
                    shopsUsingChatTable.draw();
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
    </script>
@endpush
