@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Directory Detail')

@section('content')
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.backend.navbar')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('layouts.backend.sidebar')

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
                                            <h2><i class="fas fa-user"></i> Order Detail </h2>
                                            <a href="{{ url('backside/super_admin/directory/all') }}"> <i
                                                    class="fas fa-list"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body p-lg-5">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Photo</label>
                                            <div><img src="{{ filedopath($order->items->check_photo) }}"
                                                    style="width: 222px;"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">User Name</label>
                                            <div>{{ $order->user_name }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">User Phone</label>
                                            <div>{{ $order->user_phone }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Address</label>
                                            <div>{{ $order->address }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Note</label>
                                            <div>{{ $order->note }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Item Name</label>
                                            <div>{!! $order->items->name !!}</div>

                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Item Code</label>
                                            <div>{!! $order->items->product_code !!}</div>


                                        </div>
                                        <div class="form-group">

                                            <label for="exampleInputEmail1">Shop Name</label>
                                            <div>{!! $order->items->shop_name->shop_name !!}</div>

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
