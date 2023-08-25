@extends('layouts.backend.datatable')

@section('content')
    <div class="wrapper">
        @include('layouts.backend.navbar')

        <!-- Main Sidebar Container -->
        @include('layouts.backend.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @if (Session::has('message'))
                <x-alert></x-alert>
            @endif

            <!-- Main content -->
            <section class="content pt-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="sn-table-list-wrapper">
                                <div class="border-bottom-0 mt-4 mr-2">

                                    <a href="{{ url('backside/shop_owner/items/create') }}"
                                        class="btn btn-primary float-right"><span
                                            class="fa fa-plus-circle"></span>&nbsp;&nbsp;Add New Item
                                    </a>
                                    <br><br>
                                </div>
                                <!-- /.card-header -->
                                <div class="card shadow-none border-0 rounded-5 pb-2">
                                    <div class="card-header">
                                        <h2>Today’s Update Products</h2>
                                        <p>Check your store’s daily updates</p>
                                    </div>
                                    <table id="itemsTrashTable" class="table table-borderless">
                                        <thead>
                                            <tr>

                                                <th>ID</th>
                                                <th>Product Code</th>
                                                <th>IMAGE</th>
                                                <th>Price</th>
                                                <th>Action</th>
                                                <th>Deleted Date</th>
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
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
@endsection

@push('scripts')
    <script>
        $('#itemsTrashTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('backside/shop_owner/get_items_trash')}}",

            columns: [{
                    data: 'id'
                },
                {
                    data: 'product_code'
                },

                {
                    data: 'default_photo',
                    render: function(data, type) {
                        const image = `<img src= "{{ filedopath('/items/' . '${data}') }}"/>`;
                        return image;
                    }
                },
                {
                    data: 'price_formatted'
                },
                {
                    data: 'action',
                    render: function(data, type) {
                        var restore =
                            `<a style="margin-right: 5px;" class="btn btn-sm btn-success" href="{{ route('backside.shop_owner.items.restore', [':id']) }}">Restore</a>`;
                        restore = restore.replace(':id', data);
                        var delete_forever = `
<<<<<<< HEAD
=======
                            @if (Auth::guard('shop_owners_and_staffs')->check())
>>>>>>> 8d51a8b6a4185854d3a8036d7aff2b6eb385e31e
                            <form id="forceDeleteForm" method="post" action="{{ route('backside.shop_owner.items.forcedelete', [':id']) }}">
                             @csrf
                             @method('DELETE')
                             <button type="button" class="btn btn-sm btn-danger" onclick="Delete()"  >Delete from Trash</button>

                            </form>
                            `;
                        delete_forever = delete_forever.replace(':id', data);
                        return `
                             <div class="d-flex w-100 justify-content-end">
                             ${restore}  ${delete_forever}
                             </div>
                            `;

                    }
                },
                {
                    data: 'deleted_at'
                }

            ],
            dom: 'lBfrtip',
            "responsive": true,
            "autoWidth": false,
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
        });


        function Delete() {
            $(function() {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-danger ml-2',
                        cancelButton: 'btn btn-info'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('forceDeleteForm').submit();
                    }
                })
            });
        };
    </script>
@endpush
