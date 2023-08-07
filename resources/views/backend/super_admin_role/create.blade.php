@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Admin Create')

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
                                            <h2><i class="fas fa-user"></i> Create Admin </h2>
                                            <a href="{{ route('super_admin_role.list') }}"> <i class="fas fa-list"></i></a>
                                        </div>
                                    </div>
                                    <div class="card-body p-lg-5">
                                        <form method="POST" action="{{ route('super_admin_role.create') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Name</label>
                                                <input type="name" value="{{ old('name') }}" name="name"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    id="exampleInputName" aria-describedby="nameHelp"
                                                    placeholder="Enter name">
                                                @error('name')
                                                    <span class="font-weight-bold text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" value="{{ old('email') }}" name="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="exampleInputEmail1" placeholder="Enter email">
                                                <small id="emailHelp" class="form-text text-muted">We'll never share your
                                                    email with anyone else.</small>
                                                @error('email')
                                                    <span class="font-weight-bold text-danger" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Password</label>
                                                <input id="password" value="{{ old('password') }}" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" autocomplete="new-password">
                                                @error('password')
                                                    <small class="font-weight-bold text-danger">*{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">{{ __('Confirm Password') }}</label>
                                                <input id="password" value="{{ old('password') }}" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password_confirmation" autocomplete="new-password">
                                                @error('password')
                                                    <small class="font-weight-bold text-danger">*{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Create') }}
                                            </button>
                                        </form>
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
                <div id="item-panel-2">
                    <p class="mt-5 text-center pt-5">Coming Soon ...</p>
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
    <script></script>
@endpush
