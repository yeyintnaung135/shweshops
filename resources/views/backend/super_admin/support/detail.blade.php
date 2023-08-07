@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Video Detail')

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
            <x-title>Create Admin</x-title>
        </section> --}}

            <!-- Main content -->
            <section class="content pt-3">

                <div class="container">
                    <div class="row">
                        <div class="col-12">


                            <div class="sn-table-list-wrapper">

                                <!-- /.card-header -->
                                <div class="card shadow-none card-outline card-primary rounded-5 pb-2 mt-5">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h2><i class="nav-icon fas fa-toolbox"></i> Detail </h2>
                                            <a href="{{ url('/backside/super_admin/support/list') }}"> <i
                                                    class="fas fa-list"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body p-lg-5">

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Title</label>
                                            <div>{{ $ttdata->title }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">For User Or Shop Owner</label>
                                            @if ($ttdata->for_what == 'for_user')
                                                <div>For User</div>
                                            @else
                                                <div>For Shop Owner</div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Category</label>
                                            <?php
                                            $ca = \App\Catsupport::where('id', $ttdata->cat_id)->first()->title;
                                            ?>
                                            <div>{{ $ca }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Video</label>
                                            <div>
                                                <iframe width="500" height="300" src="{{ $ttdata->video }}"
                                                    title="YouTube video player" frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen></iframe>
                                            </div>

                                        </div>
                                        <div class="d-flex">
                                            <form id='formdel'
                                                action="{{ url('/backside/super_admin/support/delete/' . $ttdata->id) }}"
                                                method="POST">
                                                @csrf

                                                <button type="button" class="btn btn-sm btn-danger" onclick="Delete(this)">
                                                    Trash <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                            <a href="{{ url('/backside/super_admin/support/list') }}"
                                                class="btn btn-outline-dark btn-sm ml-2">Back</a>
                                        </div>
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

                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content -->
    </div>
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
