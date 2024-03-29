@extends('layouts.backend.backend')
@section('content')
    <div class="wrapper">
        <!-- Navbar -->
    @include('layouts.backend.pos_nav')
    <!-- /.navbar -->

        <!-- Main Sidebar Container -->
    @include('layouts.backend.pos_sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        
        @section('content')
            <div class="wrapper">
                <!-- Navbar -->
            @include('layouts.backend.pos_nav')
            <!-- /.navbar -->
        
                <!-- Main Sidebar Container -->
            @include('layouts.backend.pos_sidebar')

    
        
    

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <div class="card-body">
                    <form method="POST" action="{{ route('backside.shop_owner.pos.update.password') }}">
                        @csrf 
   
                         @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                         @endforeach 
  
              
  
                            <div class="form-group row">
                            <!-- <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label> -->
  
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                         <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-default"><i class="fas fa-lock"></i></span>
                                        </div>
                                         <input id="new_password" type="password" class="form-control" name="new_password" placeholder="New Password" autocomplete="current-password">
                                </div>
                            </div>
                        </div>
  
                        <div class="form-group row">
                            <!-- <label for="password" class="col-md-4 col-form-label text-md-right">New Confirm Password</label> -->
    
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                         <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-default"><i class="fas fa-lock"></i></span>
                                        </div>
                                    <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" placeholder="New Confirm Password" autocomplete="current-password">
                                </div>
                            </div>
                        </div>
  
   
                        <div class="text-center">
                                <button type="submit" class="back btn">
                                    Update Password
                                </button>
                        </div>
                    </form>
                </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        @include('layouts.backend.footer')


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    @endsection @push('scripts')
    <script>
        $(document).ready(function() {
            $('.product-image-thumb').on('click', function() {
                var $image_element = $(this).find('img')
                $('.product-image').fadeOut('slow', function() {
                    $('.product-image').prop('src', $image_element.attr('src')).fadeIn();

                })

                $('.product-image-thumb.active').removeClass('active')
                $(this).addClass('active')
            })
        })
    </script>
    @endpush
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        @include('layouts.backend.footer')


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    @endsection 
