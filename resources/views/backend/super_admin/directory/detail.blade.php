@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Directory Detail')

@section('content')
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
                                            <h2><i class="fas fa-user"></i> Shop Directory detail </h2>
                                            <a href="{{ url('backside/super_admin/directory/all') }}"> <i
                                                    class="fas fa-list"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body p-lg-5">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Logo</label>
                                            <div><img src="{{ filedopath('/directory/mid/' . $ttdata->shop_logo) }}"
                                                    style="width: 222px;"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Shop Name</label>
                                            <div>{{ $ttdata->shop_name }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Shop Name Myanmar</label>
                                            <div>{{ $ttdata->shop_name_myan }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Main Phone</label>
                                            <div>{!! $ttdata->main_phone !!}</div>

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Other Phones</label>
                                            @foreach (json_decode($ttdata->additional_phones, true) as $adphone)
                                                <div>{{ $adphone }}</div>
                                            @endforeach

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Facebook Link</label>
                                            <div><a href="{{ $ttdata->facebook_link }}">{{ $ttdata->facebook_link }}</a>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Website Link</label>
                                            <div><a href="{{ $ttdata->website_link }}">{{ $ttdata->website_link }}</a></div>

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
        function fdelete() {
            let check = confirm('Are you sure you want to delete this item?');
            if (check) {
                document.getElementById('formdel').submit();
            }
        }
    </script>
@endpush
