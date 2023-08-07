@extends('layouts.backend.super_admin.datatable')
@section('content')
    <style>
        .title {
            cursor: pointer;
        }

        .edit-section {
            display: none;
            cursor: pointer;
        }
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

          <!-- Main content -->
          <section class="content pt-3">
             
             <div class="container">
                 <div class="row">
                     <div class="col-12">


                         <div class="sn-table-list-wrapper">
                             
                             <!-- /.card-header -->
                             <div class="card shadow-none card-outline rounded-5 pb-2 mt-5">
                                 <div class="card-header">
                                   <div class="d-flex justify-content-between align-items-center">
                                     <h2><i class="fas fa-edit"></i> Edit Admin </h2>
                                    <a href="{{ route('pos_super_admin_role.list') }}"> <i class="fas fa-list text-color"></i></a>
                                   </div>
                                 </div>
                                <div class="card-body p-lg-5">
                                <form method="POST"  action="{{ route('pos_super_admin_role.update',$super_admin->id) }}">
                                   @csrf
                                   @method('PUT')
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Name</label>
                                            <input type="name" name="name" class="form-control @error('name') is-invalid @enderror" id="exampleInputName" value="{{ old('name',$super_admin->name )}}">
                                            @error('name')
                                            <span class="font-weight-bold text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span> @enderror
                                        </div>
                                            <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" value="{{ old('email',$super_admin->email )}}">
                                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                            @error('email')
                                                <span class="font-weight-bold text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                       
                                      
                                       <h4 class="mb-4 font-weight-bolder">Change Password</h4>
                                       <div class="form-group">
                                           <label for="exampleInputPassword1">Current Password</label>
                                           <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password"  autocomplete="current_password">
                                           @error('current_password')
                                           <small class="font-weight-bold text-danger">*{{ $message }}</small> 
                                           @enderror
                                       </div>
                                       <div class="form-group">
                                           <label for="exampleInputPassword1"> New Password</label>
                                           <input id="password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password"  autocomplete="new_password">
                                           @error('new_password')
                                           <small class="font-weight-bold text-danger">*{{ $message }}</small> 
                                           @enderror
                                       </div>
                                       <div class="form-group">
                                           <label for="exampleInputPassword1">{{ __('Confirm Password') }}</label>
                                           <input id="new_confirm_password" type="password" class="form-control @error('new_confirm_password') is-invalid @enderror" name="new_confirm_password"  autocomplete="new_confirm_password">
                                           @error('new_confirm_password')
                                           <small class="font-weight-bold text-danger">*{{ $message }}</small> 
                                           @enderror
                                       </div>
                                   
                                       <button type="submit" class="btn btn-color">
                                        {{ __('Update') }}
                                       </button>
                                       
                                  </div>
                                      
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
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io" class="text-color">MOE</a>.</strong> All rights
        reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
@endsection
@push("scripts")
    <script>

    </script>
@endpush
@push('css')
    <style>

        .btn-color{
        background-color: #780116;
        color: white;
    }
    .btn-color:hover{
            color: white;
        }
    .text-color{
        color: #780116;
    }

    </style>
@endpush
