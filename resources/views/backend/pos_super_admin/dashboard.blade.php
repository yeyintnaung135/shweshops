@extends('layouts.backend.super_admin.datatable')
@section('title','MOE Admin Team | Dashboard')
@section('content')
    <style>

    </style>
    <div class="wrapper">
        <!-- Navbar -->
    @include('backend.pos_super_admin.navbar')
    <!-- /.navbar -->
        <!-- Main Sidebar Container -->
    @include('backend.pos_super_admin.sidebar')

    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <x-alert></x-alert>

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <x-title>

                    Dashboard
                </x-title>

            </section>
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    @php
                                        use App\Featuresforshops;
                                        $all_shops_count = Featuresforshops::all()->count();
                                    @endphp
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="logo" >
                                                <img src="{{url('logo/Gold.png')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="col-8" >
                                            <h4 class="font-weight-bold mt-2">{{$all_shops_count}}</h4>
                                            <h6 class="text-color mt-1">​ရွှေဆိုင်စုစု​ပေါင်း</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                  
                   
                </div>
            </section>
           
        </div>
        <!-- /.content -->
    </div>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
@endsection
@push('scripts')
    <script>

    </script>
@endpush
@push('css')
    <style>
        .sn-card {
          box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
          width: 30%;
          margin: 10px;
          word-wrap: break-word;
          background-clip: border-box;
          border: 0 solid rgba(0,0,0,.125);
          border-radius: 0.25rem;
        }
        @media only screen and (max-width: 600px) {
          .sn-card {
            margin: 5px;
            width: 45%;
          }
        }


    </style>
@endpush