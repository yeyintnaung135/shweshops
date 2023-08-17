@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Ads List')

@php
    use Illuminate\Support\Carbon;
@endphp

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
                <x-title>All Ads</x-title>
            </section>

            <!-- Main content -->
            <section class="content">
                <div id="item-panel-1" class="container-fluid">
                    <div class="row">
                        <div class="col-12">


                            <div class="sn-table-list-wrapper pb-2 mt-5">
                                <!-- /.card-header -->
                                <div class="card shadow-none border-0 rounded-5 p-2">
                                    <div class="card-header">
                                        <a href=" {{ route('backside.super_admin.ads.create') }} "
                                            class="btn btn-primary float-right">Add New Ad</a>

                                    </div>
                                    <div class="d-flex justify-content-end my-3 align-items-center">
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>From Date</legend>
                                                <input type="text" id='search_fromdate_ads'
                                                    class="adsdatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>To Date</legend>
                                                <input type="text" id='search_todate_ads'
                                                    class="adsdatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="pr-md-4">
                                            <input type='button' id="ads_search_button" value="Search" class="btn bg-info">
                                        </div>
                                    </div>
                                    <table id="superAdminTable" class="table table-borderless">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Image</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Expired</th>
                                                <th>Action</th>
                                                <th>Created Date</th>
                                            </tr>
                                        </thead>
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
        .deleted {
            text-decoration: line-through;
            color: #777;
        }

        .filter {
            filter: grayscale(100%);
        }

        .cover {
            width: 150px;
            height: 100px;
        }
    </style>
@endpush

@push('scripts')
    @if (session()->has('adsupdated'))
        <script>
            alert('Ads was successfully updated')
        </script>
    @endif
    @if (session()->has('adscreated'))
        <script>
            alert('Ads was successfully created')
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $(".adsdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#ads_search_button').click(function() {
                if ($('#search_fromdate_ads').val() != null && $('#search_todate_ads').val() != null) {
                    adsTable.draw();
                }
            });

            $(".adsactdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#adsact_search_button').click(function() {
                if ($('#search_fromdate_adsact').val() != null && $('#search_todate_adsact').val() !=
                    null) {
                    adsActivityTable.draw();
                }
            });
        });

        var deleted = document.querySelectorAll('#deleted_at');
        deleted.forEach((e) => {
            $(e.parentElement).addClass('deleted-at');
        })
        // function get(obj) {
        //   return document.getElementById(obj);
        // }
        // function itemTab_Panel (tab_active, tab2, panel_remove, panel2) {
        //   get(tab_active).classList.add("active-panel");
        //   get(tab2).classList.remove("active-panel");

        //   get(panel_remove).classList.remove("sn-panel-hide");
        //   get(panel2).classList.add("sn-panel-hide");
        // }
        // function adsTabSwitchOne() {
        //   itemTab_Panel("item-tab-1", "item-tab-2", "item-panel-1", "item-panel-2");
        // }
        // function adsTabSwitchTwo() {
        //   itemTab_Panel("item-tab-2", "item-tab-1", "item-panel-2", "item-panel-1");
        // }

        var adsTable = $('#superAdminTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'url': "{{ route('backside.super_admin.ads.getAllAds') }}",
                'data': function(data) {
                    // Read values
                    var from_date = $('#search_fromdate_ads').val() ? $('#search_fromdate_ads').val() +
                        " 00:00:00" : null;
                    var to_date = $('#search_todate_ads').val() ? $('#search_todate_ads').val() + " 23:59:59" :
                        null;

                    // Append to data
                    data.searchByFromdate = from_date;
                    data.searchByTodate = to_date;
                }
            },

            columns: [{
                    data: 'name',
                    render: function(data, type, row) {
                        var result = row.deleted_at ? `<span class="deleted">${data}</span>` : data;
                        return result;
                    }
                },
                {
                    data: 'image',
                    render: function(data, type, row) {
                        console.log(row)
                        if (row.video !== null) {
                            var result = row.deleted_at ?
                                `<img src="{{ asset('images/banner/video/${row.video}') }}" class="filter cover" alt="cover" >` :
                                `<img src="{{ asset('images/banner/video/${row.video}') }}" alt="cover" class="cover" >`;

                        } else {
                            var result = row.deleted_at ?
                                `<img src="{{ asset('images/banner/${data}') }}" class="filter cover" alt="cover" >` :
                                `<img src="{{ asset('images/banner/${data}') }}" alt="cover" class="cover" >`;
                        }

                        return result;
                    }
                },
                {
                    data: 'start_formatted',
                    render: function(data, type, row) {
                        var result = row.deleted_at ? `<span class="deleted">${data}</span>` : data;
                        return result;
                    }
                },
                {
                    data: 'end_formatted',
                    render: function(data, type, row) {
                        var result = row.deleted_at ? `<span class="deleted">${data}</span>` : data;
                        return result;
                    }
                },
                {
                    data: 'deleted_at_formatted',
                    render: function(data, type, row) {
                        var result = data ? data : "-";
                        return result;
                    }
                },
                {
                    data: 'action',
                    render: function(data, type, row) {
                        if (row.video === null) {
                            var detail = `<a href="{{ route('backside.super_admin.ads.show', ':id') }}" class="btn btn-sm btn-warning mr-2">
                         <i class="far fa-eye"></i>
                        </a>`;
                            var edit = `<a href="{{ route('backside.super_admin.ads.edit', ':id') }}" class="btn btn-sm btn-success mr-2">
                        <i class="far fa-edit"></i>
                      </a>`;
                            detail = detail.replace(':id', data);
                            edit = edit.replace(':id', data);
                            var del = ` <form action="{{ route('backside.super_admin.ads.destroy', ':id') }}" method="post">
                      @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                <i class="fa fa-trash"></i>
                            </button>
                          </form>`;


                            del = del.replace(':id', data);
                            return `
            <div class="d-flex justify-content-center">
            ${detail}  ${edit}  ${del}
            </div>
          `;
                        } else {
                            var del = ` <form action="{{ route('backside.super_admin.ads.destroy', ':id') }}" method="post">
                      @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                <i class="fa fa-trash"></i>
                            </button>
                          </form>`;


                            del = del.replace(':id', data);
                            return `
                        <div class="d-flex justify-content-center">
                        ${del}
                        </div>
                      `;

                        }


                    }
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
