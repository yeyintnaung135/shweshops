@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Daily Product')

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
            <section class="content-header">
                <x-title>Create Products Counts</x-title>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="sn-table-list-wrapper">
                            <div class="card shadow-none border-0 rounded-5 pb-2 mt-5">
                                <div class="card-header">
                                    @error('percent')
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>{{ $message }}</strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @enderror
                                    <div class="">
                                        <h2>Create Products Count by date : <span id="totalcount"></span></h2>
                                        <p>Check your store’s daily updates</p>
                                    </div>

                                </div>
                                <div class="row no-gutters">
                                    <div class="col-12 col-md-4">
                                        <div class="d-flex justify-content-start mt-md-5 ">
                                            <button class="btn btn-success multi-btn" id="clear_sel">Clear Selected
                                            </button>

                                            <button class="btn btn-danger multiple_stock  ml-2" id="clearall">
                                                Clear All
                                            </button>
                                            <form action="{{ url('backside/super_admin/daily_shop_create_delselected') }}"
                                                id="todelshopidsform" method="post">
                                                @csrf
                                                <input type="hidden" name="delshopids" value="" id="delshopids"
                                                    class="multipleStock">
                                                <input type="hidden" name="fromdate" value="" id="fromdate"
                                                    class="multipleStock">
                                                <input type="hidden" name="todate" value="" id="todate"
                                                    class="multipleStock">

                                            </form>
                                            <form action="{{ url('backside/super_admin/daily_shop_create_delall') }}"
                                                id="clearallform" method="post">
                                                @csrf
                                                <input type="hidden" name="cafromdate" value="" id="cafromdate"
                                                    class="multipleStock">
                                                <input type="hidden" name="catodate" value="" id="catodate"
                                                    class="multipleStock">

                                            </form>


                                        </div>

                                    </div>

                                    <div class="col-12 col-md-8">
                                        <div class="d-flex justify-content-end my-3 align-items-center">

                                            <div class="form-group mr-md-2">
                                                <fieldset>
                                                    <legend>From Date</legend>
                                                    <input type='text' id='search_fromdate_addtocart'
                                                        class="addtocartdatepicker form-control" value="{{ date('Y-m-d') }}"
                                                        placeholder='Choose date' autocomplete="off">
                                                </fieldset>
                                            </div>
                                            <div class="form-group mr-md-2">
                                                <fieldset>
                                                    <legend>To Date</legend>
                                                    <input type='text' id='search_todate_addtocart'
                                                        class="addtocartdatepicker form-control" value="{{ date('Y-m-d') }}"
                                                        placeholder='Choose date' autocomplete="off">
                                                </fieldset>
                                            </div>
                                            <div class="pr-md-4">
                                                <input type='button' id="addtocart_search_button" value="Search"
                                                    class="btn bg-info">
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <table id="dailyshopcreate" class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <td></td>
                                            <td>id</td>
                                            <td>Shop Name</td>
                                            <td>Products Create count</td>

                                            <td>Created At</td>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <td></td>

                                            <td>id</td>
                                            <td>Shop Name</td>
                                            <td>Products Create count</td>

                                            <td>Created At</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    {{-- <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.2.0-rc
        </div>
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">MOE</a>.</strong> All rights
        reserved.
    </footer> --}}

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var gettotal = () => {
                $.post(
                    "{{ url('backside/super_admin/total_create_count') }}", {
                        from: $('#search_fromdate_addtocart').val() + " 00:00:00",
                        to: $('#search_todate_addtocart').val() + " 23:59:59",
                        _token: "{{ csrf_token() }}"
                    },
                    function(data, status) {
                        $('#totalcount').text(data);
                    }
                );
            };
            gettotal();

            var dailyshopcreate = $('#dailyshopcreate').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('backside/super_admin/getalldailyshopcreatecounts') }}",
                    'data': function(data) {
                        // Read values
                        var from_date = $('#search_fromdate_addtocart').val() ? $(
                            '#search_fromdate_addtocart').val() + " 00:00:00" : null;
                        var to_date = $('#search_todate_addtocart').val() ? $(
                            '#search_todate_addtocart').val() + " 23:59:59" : null;

                        // Append to data
                        data.searchByFromdate = from_date;
                        data.searchByTodate = to_date;
                    }
                },


                columns: [{
                        data: 'checkbox',
                        render: function(data, type) {

                            let hasvalue = tmpshopidsarry.find(e => {
                                return e == data;
                            });

                            if (hasvalue == data) {
                                return `<input type="checkbox" value="${data}" onclick="checkbox(this)" id="${data}" checked>`;

                            } else {
                                return `<input type="checkbox" value="${data}" onclick="checkbox(this)" id="${data}" >`;

                            }
                        }
                    },
                    {
                        data: 'id'
                    },
                    {
                        data: 'shop_name'
                    },
                    {
                        data: 'product_count'
                    },
                    {
                        data: 'created_at'
                    },
                    // {data: 'deleted_at'},


                ],

                responsive: true,
                lengthChange: true,
                autoWidth: false,
                paging: true,

                columnDefs: [{

                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 2,
                        targets: 1
                    },
                    {
                        orderable: false,
                        responsivePriority: 3,
                        targets: 2
                    },
                    {
                        responsivePriority: 4,
                        targets: 3
                    },
                    {
                        responsivePriority: 5,
                        targets: 4
                    },
                ],

                language: {
                    "search": '<i class="fa-solid fa-search sn-search-icon" style="left: 12px;"></i>',
                    "searchPlaceholder": 'Search...',
                    paginate: {
                        next: '<i class="fa fa-angle-right"></i>', // or '→'
                        previous: '<i class="fa fa-angle-left"></i>' // or '←'
                    }
                },


                "order": [
                    [4, "desc"]
                ],

            });

            $(".addtocartdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#addtocart_search_button').click(function() {
                gettotal();

                if ($('#search_fromdate_addtocart').val() != null && $('#search_todate_addtocart').val() !=
                    null) {
                    dailyshopcreate.draw();
                }
            });
        });

        var tmpshopidsarry = [];
        $('#clear_sel').hide();
        var checkbox = (e) => {
            if ($(e).is(':checked')) {
                tmpshopidsarry.push(e.value);
            } else {
                let index = tmpshopidsarry.indexOf(e.value);
                if (index > -1) {
                    tmpshopidsarry.splice(index, 1);
                }

            }
            if (tmpshopidsarry.length > 0) {
                $('#clear_sel').show();

            } else {
                $('#clear_sel').hide();

            }
            $('#delshopids').val(tmpshopidsarry);

            console.log(tmpshopidsarry)

        }
        $('#clear_sel').on('click', () => {
            $('#fromdate').val($('#search_fromdate_addtocart').val() + " 00:00:00");
            $('#todate').val($('#search_todate_addtocart').val() + " 23:59:59");
            let c = confirm('Are u sure want to del selected records? ');
            if (c) {
                $('#todelshopidsform').submit();
            }
        })
        $('#clearall').on('click', () => {
            $('#cafromdate').val($('#search_fromdate_addtocart').val() + " 00:00:00");
            $('#catodate').val($('#search_todate_addtocart').val() + " 23:59:59");
            let c = confirm('Are u sure want to del all records between selected date? ');
            if (c) {
                $('#clearallform').submit();
            }
        })
    </script>
@endpush
