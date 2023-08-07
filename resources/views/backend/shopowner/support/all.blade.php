@extends('layouts.backend.backend')

@section('content')
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.backend.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.backend.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background:white;">


            <supportso-help :data="{{ $data }}" :cats="{{ $cats }}"></supportso-help>

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
        .yksupport {
            padding: 43px;
        }

        @media only screen and (max-width: 900px) {
            .yksupport {
                padding: 15px;
            }


        }
    </style>
@endpush
