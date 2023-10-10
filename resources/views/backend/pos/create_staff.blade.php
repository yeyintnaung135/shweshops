@extends('layouts.backend.posbackend')
@section('content')
    <div class="wrapper">
        <!-- Navbar -->
    @include('layouts.backend.pos_nav')
    <!-- /.navbar -->

        <!-- Main Sidebar Container -->
    @include('layouts.backend.pos_sidebar')

    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper sn-background-light-blue">
            @if(Session::has('message'))

                <x-alert>

                </x-alert>
        @endif
        <!-- Content Header (Page header) -->
        <section class="content-header sn-content-header">
            <div class="container-fluid">
                @foreach($shopowner as $shopowner )
                @endforeach


            </div><!-- /.container-fluid -->
        </section>

        <section class="content-header">
            <div class="container-fluid">

                <div class="card">
                    <div class="card-body">
                         <form action="{{route('backside.shop_owner.pos.store_staff')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                           <h4 class="text-color mt-2">​<i class="fa fa-chevron-left" aria-hidden="true" onclick="back()"></i> &nbsp;&nbsp;Staff စာရင်းသွင်းခြင်း</h4>
                           <div class="col-5">
                            <label for="date" class="col-form-label">Choose Date</label>
                            <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>"><br><br>
                            <span class="text-color" style="font-size:19px;">Staff အချက်အလက်များ</span>
                          </div>
                            <div class="row mt-4">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="name" class="col-form-label">Staff အမည်</label>
                                                <input type="text" class="form-control" name="name">
                                            </div>

                                            <div class="form-group col-6">
                                                <label for="code_number" class="col-form-label">ကုဒ်နံပါတ်  <span class="text-danger" id="code_chk">(*ကုဒ်နံပါတ် မတူရပါ။*)</span></label>
                                                <input type="text" name="code_number" class="form-control" onchange="changecode(this.value)" required>

                              
                                                <!--<input type="text" class="form-control" name="code_number">-->
                                            </div>
                                            {{-- <div class="form-group col-6">
                                                <label for="phone" class="col-form-label">ဖုန်းနံပါတ်</label>
                                                <input type="number" class="form-control" name="phone">
                                            </div> --}}
                                            <div class="form-group col-6">
                                                <label for="counter_shop" class="col-form-label">Counter Shop</label>
                                                <select name="counter_shop" id="counter" class="form-control" required>
                                                <option>ဆိုင်ခွဲများ</option>
                                                @foreach ($counters as $counter)
                                                <option value="{{$counter->shop_name}}">{{$counter->shop_name}}</option>
                                                @endforeach
            
                                            </select>
                                                <!--<input type="text" class="form-control" name="counter_shop">-->
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group ">
                                                    <fieldset>
                                                      <legend>Phone-no </legend>
                                                      <input type="text" class="form-control sop-form-control @error('phone') is-invalid @enderror" name="phone"
                                                           placeholder="Enter Phone-no" autocomplete="off" required/>
                                                           @error('phone')
                                                            <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                    </fieldset>
                                                </div>
                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
        
                                            </div>
                                            <div class="col-md-12">
                                            <div class="fs form-group row">
                                            <div class="col-md-12">
                                                <label for="exampleInputEmail1">Password <span
                                                            style="color: red;">*</span></label>

                                                <div class="input-group mb-3">

                                                    <input id="password" type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" placeholder="Enter Password"
                                                        autocomplete="password" minlength="6" maxlength="20" required>
                                                </div>
                                               
                                                @error('password')
                                                <x-error>
                                                    {{$message}}
                                                </x-error>
                                                @enderror
                                            </div>
                                            <div class="col-md-12"><button type="button" class="sn_generate_password btn btn-secondary d-block">Generate Password</button></div>
                                            </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <fieldset>
                                                      <legend>Role</legend>
                                                      <select
                                                          class="selectpicker form-control sop-form-control select2"
                                                          name="role_id"
                                                          style="width: 100%"
                                                      >  
                                                      @if(Session::has('staff_role'))
                                                      @if(Session::get('staff_role') == 1) 
                                                      <option value="2">manager</option>
                                                      <option value="3">staff</option>
                                                      @endif
                                                      @if(Session::get('staff_role') == 2) 
                                                      <option value="3">staff</option>
                                                      @endif
                                                      @if(Session::get('staff_role') == 4) 
                                                      <option value="4">owner</option>
                                                        <option value="1">admin</option>
                                                        <option value="2">manager</option>
                                                        <option value="3">staff</option>
                                                      @endif
                                                      @else
                                                        <option value="4">owner</option>
                                                        <option value="1">admin</option>
                                                        <option value="2">manager</option>
                                                        <option value="3">staff</option>
                                                      @endif
                                                     
        
                                                      </select> 
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <div class="form-group col-12">
                                                <label for="address" class="col-form-label">လိပ်စာ</label>
                                                <textarea class="form-control" name="address"></textarea>
                                            </div>

                                        </div>
                                    </div>

                            </div>
                            <div class="row mt-5 offset-10">
                                <button type="submit" class="btn btn-sm btn-color text-center"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>Save</button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    {{-- @include('layouts.backend.footer') --}}


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>

@endsection
@push('scripts')
   <script type='text/javascript'> 
      
      $(document).ready(function() {

        $('.sn_generate_password').click(function () {
        var chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$%&^*ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        var passwordLength = 6;
        var generated_password = "";
        for (var i = 1; i <= passwordLength; i++) {
            var randomNumber = Math.floor(Math.random() * chars.length);
            generated_password += chars.substring(randomNumber, randomNumber +1);
        }
        document.getElementById("password").type = 'text';

        document.getElementById("password").value = generated_password;
        })
      });
       
   </script>
@endpush
@push('css')
    <style>
        body {
            background: #F0F7FA;
            font-family: 'Myanmar3', Sans-Serif !important;
        }
        .text-color{
        color: #780116;
    }
    .btn-color{
        background: #780116;
        color:white;
        padding: 5px 25px;
    }
    .btn-color:hover{
            color: white;
        }
        .zh-eye-picon:hover button i{
        color: black;
        
    }
    .zh-eye-picon:focus button i{
        color: black;
        
    }
    .zh-eye-picon:hover button i{
        transform: scale(1)
    }
    .zh-eye-picon button i{
        display:flex;
        color:#808080;
        transform: scale(0.9);
    }
    .zh-eye-picon {
        z-index: 9999 !important;
        position: absolute !important;
        right:0;
        top:0;
        margin-top:-3px;
    }

    </style>
@endpush

