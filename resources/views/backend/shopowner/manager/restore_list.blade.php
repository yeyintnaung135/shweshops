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
                <x-alert>

                </x-alert>
            @endif

            <!-- zhheader shopname -->
            {{-- <x-header>
            @foreach ($shopowner as $shopowner)
                    @endforeach
                    {{$shopowner->shop_name}}
            </x-header> --}}
            <!-- end zh header shopname -->

            {{-- <x-title>
           Restore User list
            </x-title> --}}
            <!-- Main content -->
            <section class="content pt-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">


                            <div class="sn-table-list-wrapper">
                                <div class="card-header border-0">
                                    @if (request()->has('view_deleted'))
                                        <a href="{{ route('backside.shop_owner.managers.restore_list') }}"
                                            class="btn btn-success">Restore All</a>
                                    @endif
                                </div>
                                <!-- /.card-header -->
                                <div class="card shadow-none border-0 rounded-5 pb-2">
                                    <div class="card-header border-0">
                                        <h2>Deleted Users List</h2>
                                        <p>Check your deleted users list</p>
                                    </div>
                                    <table id="trashTable" class="table table-borderless mb-2">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Phone-no</th>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Action</th>
                                                {{-- <th>Deleted Date</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $i=1; @endphp
                                            @foreach ($trashList as $trash)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $trash->phone }}</td>
                                                    <td>{{ $trash->name }}</td>
                                                    <td>{{ $trash->role->name }}</td>

                                                    <td>
                                                        <a href="{{ route('backside.shop_owner.managers.restore', $trash->id) }}"
                                                            class="btn btn-success">Restore</a>
                                                    </td>

                                                </tr>
                                            @endforeach

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Phone-no</th>
                                                <th>Role</th>
                                                <th>Action</th>
                                                {{-- <th>Deleted Date</th> --}}
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
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        {{-- @include('layouts.backend.footer') --}}

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
@endsection
@push('scripts')
    <script>
        $("#trashTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            'columnDefs': [{
                    responsivePriority: 1,
                    targets: 2
                },
                {
                    responsivePriority: 2,
                    targets: 1
                },
                {
                    responsivePriority: 3,
                    targets: 3
                },
                {
                    "targets": [4],
                    'orderable': false,
                }
            ],
            language: {
                "search": '<i class="fa-solid fa-search sn-search-icon"></i>',
                "searchPlaceholder": 'Search by name or role or phone',
                paginate: {
                    next: '<i class="fa fa-angle-right"></i>', // or '→'
                    previous: '<i class="fa fa-angle-left"></i>' // or '←'
                }
            },
            "order": [0, 'desc']
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

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
                    confirmButtonText: 'Yes, Do it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete_form').submit();
                    }
                })
            });
        }
    </script>
@endpush
