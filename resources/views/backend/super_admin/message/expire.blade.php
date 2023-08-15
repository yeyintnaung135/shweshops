@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Expired Messages')

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
                                            <h2>Expire Message Lists</h2>
                                            <p>Check your Shops</p>
                                        </div>
                                        <div class="d-flex">

                                            <form action="{{ url('backside/super_admin/messages/deletemultiple') }}"
                                                method="post">
                                                @csrf

                                                <input type="hidden" name="id" value="" class="deleteShopValue">
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
                                                    <th>User Name</th>
                                                    <th>Shop Name</th>
                                                    <th>Message</th>
                                                    <th>Expired at</th>
                                                    <th>created at</th>
                                                    <th>Action</th>
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
        var deletemessage = new Array();

        function multipleDelete(e) {
            if (window.confirm("Are you sure to delete?")) {
                $(e.form).submit();
                $("#loader").show();
            }
        }

        function checkBox(e) {
            if ($(e).is(':checked')) {
                deletemessage.push(e.value);
                $(".deleteShopValue").val(deletemessage);
                $('.multiple_delete_btn').show();
                localData = localStorage.setItem("localData", JSON.stringify(deletemessage));


            } else {
                const index = deletemessage.indexOf(e.value);
                if (index > -1) {
                    deletemessage.splice(index, 1);
                }
                if (deletemessage.length === 0) {
                    $('.multiple_delete_btn').hide();
                }
                localData = localStorage.removeItem("localData", JSON.stringify(deletemessage));

            }

        }


        function shopForceDelete(e) {
            if (window.confirm("Are you sure to delete?")) {
                $(e.form).submit();
                $("#loader").show();
            }
        }

        $('#shopTrashTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('backside/super_admin/messages/getexpire') }}",

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
                    data: 'mid'
                },
                {
                    data: 'user_name'
                },
                {
                    data: 'shop_name'
                },
                {
                    data: 'message',
                    render: function(data, type, row) {
                        if (data.includes('image')) {
                            return `<img src="${"http://" + window.location.hostname+'/'+data}" class="photo_deleted" style="width: 80px;" alt="cover">`;
                        } else {
                            return data;

                        }
                    }
                },
                {
                    data: 'expired_in',
                    render: function(data, type, row) {
                        var result = `<span class="badge badge-danger">Expired At ${row.expired_in}</span>`;
                        return result;
                    }
                },

                {
                    data: 'message_created_at'
                },

                {
                    data: 'action',
                    render: function(data, type) {

                        var del = `<form action="{{ route('backside.super_admin.delete', ':id') }}" method="post" >
                        @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-danger" onclick="shopForceDelete(this)"><i class="fa fa-trash"> Delete</i></button>
                    </form>`;
                        var del = del.replace(':id', data);
                        return `
                <div class="d-flex">
                ${del}
                </div>`;
                    }
                }
            ],
            dom: 'lBfrtip',
                "responsive": true,
                "autoWidth": false,
        });
    </script>
@endpush
