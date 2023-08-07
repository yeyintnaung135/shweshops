@extends('backend.super_admin.layout')
@section('title', 'MOE Admin Team | Daily Shop')

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
            <section class="content-header">
                <x-title>Daily Shop Count</x-title>
                <div
                    style="
                        display: flex;
                        margin-left: 23px;
                    ">
                    <h1>Product : {{ count($itemlog) }}</h1>
                    <form action="{{ route('shopdailycount.clear') }}" method="POST"
                        style="
                            margin-left: 48px;
                        ">
                        @method('DELETE')
                        @csrf
                        <input type="submit" class="btn btn-danger" value="Delete" />
                    </form>
                </div>

            </section>

            <!-- Main content -->
            <section class="content">
                <div class="daily row"
                    style="
                        margin-right: 0px;
                        margin-left: 80px;
                    ">
                    <div class="col-6  count">
                        @foreach ($itemdate as $dateName => $bulk)
                            <div class="card" style="width: 10rem;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $dateName }}</h5><br>

                                    @foreach ($bulk as $userId => $date)
                                        <p class="card-text"> {{ $userId }} - {{ $date->count() }} </p>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-6 total">
                        @foreach ($itemtotal as $dateName => $bulk)
                            <div class="card" style="width: 10rem;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $dateName }}</h5><br>
                                    <p class="card-text"> Total:{{ count($bulk) }} </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


            </section>
            <!-- /.content -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    {{-- <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0-rc
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">MOE</a>.</strong> All rights
            reserved.
        </footer> --}}

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
@endsection

@push('scripts')
    <script></script>
@endpush
