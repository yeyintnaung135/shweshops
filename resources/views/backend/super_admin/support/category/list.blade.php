@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Categories')

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
            <x-title>All Admin</x-title>
        </section> --}}

            <!-- Main content -->
            <section class="content pt-3">
                {{-- <div class="sn-tab-panel">
                    <ul>
                    <li id="item-tab-1" class="active-panel" onclick="superAdminTabSwitchOne()">Admin List</li>
                    <li id="item-tab-2" onclick="superAdminTabSwitchTwo()">Admin Activity</li>
                    </ul>
                </div> --}}
                <div id="item-panel-1" class="container-fluid">
                    <div class="row">
                        <div class="col-12">


                            <div class="sn-table-list-wrapper">

                                <!-- /.card-header -->
                                <div class="card shadow-none card-outline card-primary rounded-5  mt-5">
                                    <div class="card-header">
                                        <div class=" d-flex justify-content-between align-items-center">
                                            <h2><i class="nav-icon fas fa-toolbox"></i> Support Categories Lists </h2>
                                            <a href="{{ url('backside/super_admin/support/cat/create') }}" role="button"
                                                class="btn btn-primary"> Create Support Category </a>
                                        </div>
                                    </div>

                                    <div class="card-body p-lg-3">

                                        <table id="example2" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>Title</th>
                                                    <th>Created At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cats as $c)
                                                    <tr>
                                                        <td>{{ $c->id }}</td>
                                                        <td>{{ $c->title }}</td>

                                                        <td>{{ date('F d, Y ( h:i A )', strtotime($c->created_at)) }}</td>
                                                        <td>
                                                            @if ($c->id != '1')
                                                                <div class="d-flex justify-content-around w-75">


                                                                    <a href="{{ url('backside/super_admin/support/cat/edit/' . $c->id) }}"
                                                                        role="button" class="btn btn-sm btn-info"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Shop Edit">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    <form
                                                                        action="{{ url('backside/super_admin/support/cat/delete') }}"
                                                                        method="post">
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $c->id }}">
                                                                        <button type="button" onclick="Delete(this)"
                                                                            class="btn btn-sm btn-danger"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title="Move To Trash">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>

                                                                    </form>

                                                                </div>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach


                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>id</th>
                                                    <th>Title</th>
                                                    <th>Created At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content -->
        {{-- </div> --}}
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0-rc
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">MOE</a>.</strong> All rights
            reserved.
        </footer>

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
        $("#loader").hide();
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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
        });

        //Datatable





        function Delete(e) {
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
                        $(e.form).submit();
                    }
                })
            });
        }
    </script>
@endpush
