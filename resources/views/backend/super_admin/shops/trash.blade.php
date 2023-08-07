@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Shop Trash')

@section('content')
    @include('backend.super_admin.loading')
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
                <x-title>All Shops</x-title>
            </section> --}}

            <!-- Main content -->
            <section class="content pt-3">

                <div id="item-panel-1" class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <div class="sn-table-list-wrapper">
                                <div class="card shadow-none border-0 rounded-5 pb-2 mt-5">
                                    <div class="card-header">
                                        <div class="">
                                            <h2>Trash Shop Lists</h2>
                                            <p>Check your Shops</p>
                                        </div>
                                        <div class="d-flex">

                                            <form action="{{ route('shops.multiple_delete') }}" method="post">
                                                @csrf

                                                <input type="hidden" name="deleted_shops" value=""
                                                    class="deleteShopValue">
                                                <button type="button" class="btn btn-danger multiple_delete_btn ml-2"
                                                    onclick="multipleDelete(this)"><i class="fa fa-trash"> Multiple
                                                        Delete</i></button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="shopTrashTable" class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th>Select</th>
                                                    <th>Id</th>
                                                    <th>Owner</th>
                                                    <th>Shop Name</th>
                                                    <th>Shop Name (Myanmar)</th>
                                                    <th>Email</th>
                                                    <th>Date</th>
                                                    <th>Handle</th>
                                                    <th>created at</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

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

        .multiple_delete_btn {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $("#loader").hide();
        let deleShopData = new Array();

        function shopForceDelete(e) {
            if (window.confirm("Are you sure to delete?")) {
                $(e.form).submit();
                $("#loader").show();
            }
        }

        function multipleDelete(e) {
            if (window.confirm("Are you sure to delete?")) {
                $(e.form).submit();
                $("#loader").show();
            }
        }

        function checkBox(e) {
            if ($(e).is(':checked')) {
                deleShopData.push(e.value);
                $(".deleteShopValue").val(deleShopData);
                $('.multiple_delete_btn').show();
                localData = localStorage.setItem("localData", JSON.stringify(deleShopData));

            } else {
                const index = deleShopData.indexOf(e.value);
                if (index > -1) {
                    deleShopData.splice(index, 1);
                }
                if (deleShopData.length === 0) {
                    $('.multiple_delete_btn').hide();
                }
                localData = localStorage.removeItem("localData", JSON.stringify(deleShopData));
            }

        }

        $('#shopTrashTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('shops.get_all_trash_shop') }}",

            columns: [{
                    data: 'checkbox',
                    render: function(data, type) {
                        let localRetri = JSON.parse(window.localStorage.getItem("localData")) || [];
                        return (localRetri.length == 0) ?
                            `<input type="checkbox" value="${data}" id="checkBox" onclick="checkBox(this)">` :
                            (localRetri.find(element => element == data) == data) ?
                            `<input type="checkbox" value="${data}" id="checkBox" onclick="checkBox(this)" checked>` :
                            `<input type="checkbox" value="${data}" id="checkBox" onclick="checkBox(this)">`

                    }
                },
                {
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'shop_name'
                },
                {
                    data: 'shop_name_myan'
                },
                {
                    data: 'email'
                },
                {
                    data: 'expired',
                    render: function(data, type, row) {
                        console.log(row.expired)
                        if (data == "expired") {
                            var result = `<span class="badge badge-danger">Expired</span>`;
                        } else {
                            var result =
                                ` <span class="badge badge-warning">သက်တမ်းကုန်ဆုံးရန် ${row.expired} ရက်သာလိုပါတော့သည်။</span>`;
                        }

                        return result;

                    }


                },
                {
                    data: 'id',
                    render: function(data, type) {
                        var result =
                            `
                <form action="{{ route('shops.restore', ':id') }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-success mr-2"><i class="fas fa-trash-restore"></i> Restore from trash</button>
                </form>
                `;
                        var result = result.replace(':id', data);

                        var del = `<form action="{{ route('shops.force_delete', ':id') }}" method="post" >
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger" onclick="shopForceDelete(this)"><i class="fa fa-trash"> Delete from trash</i></button>
                        </form>
            `;
                        var del = del.replace(':id', data);
                        return `
                <div class="d-flex">
                ${result + del}
                </div>
            `;

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
                },
                {
                    'targets': [6],
                    'orderable': false,
                },
                {
                    'targets': [0],
                    'orderable': false,
                },
                {
                    'targets': [8],
                    'visible': false,
                    'searchable': false,
                }
            ],
            language: {
                "search": '<i class="fa-solid fa-search"></i>',
                "searchPlaceholder": 'Search Shop Name',
                paginate: {
                    next: '<i class="fa fa-angle-right"></i>', // or '→'
                    previous: '<i class="fa fa-angle-left"></i>' // or '←'
                }
            },

            "order": [
                [7, "desc"]
            ],
        });
    </script>
@endpush
