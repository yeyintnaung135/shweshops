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
                         <form action="{{route('backside.shop_owner.pos.update_staff',$staff->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                           <h4 class="text-color mt-2">​<i class="fa fa-chevron-left" aria-hidden="true" onclick="back()"></i> &nbsp;&nbsp;Staff စာရင်းပြင်ဆင်ခြင်း</h4>
                           <div class="col-5">
                            <label for="date" class="col-form-label">Choose Date</label>
                            <input type="date" name="date" value="{{$staff->date}}"><br><br>
                            <span class="text-color" style="font-size:19px;">Staff အချက်အလက်များ</span>
                          </div>
                            <div class="row mt-4">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="name" class="col-form-label">Staff အမည်</label>
                                                <input type="text" class="form-control" name="name" value="{{$staff->name}}">
                                            </div>

                                            <div class="form-group col-6">
                                                <label for="code_number" class="col-form-label">ကုဒ်နံပါတ်</label>
                                                <input type="text" class="form-control" name="code_number" value="{{$staff->code_number}}">
                                            </div>
                                            {{-- <div class="form-group col-6">
                                                <label for="phone" class="col-form-label">ဖုန်းနံပါတ်</label>
                                                <input type="number" class="form-control" name="phone" value="{{$staff->phone}}">
                                            </div> --}}
                                            <div class="col-md-6">
                                                <div class="form-group ">
                                                    <fieldset>
                                                      <legend>Phone-no </legend>
                                                      <input type="text" class="form-control sop-form-control @error('phone') is-invalid @enderror" name="phone"
                                                           placeholder="Enter Phone-no" autocomplete="off" value="{{$staff->phone}}" required/>
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
                                            
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <fieldset>
                                                      <legend>Role</legend>
                                                      <select
                                                          class="selectpicker form-control sop-form-control select2"
                                                          name="role_id"
                                                          style="width: 100%"
                                                      >   
                                                      
                                                      @foreach($role as $role)
                                                      <option value="{{$role -> id}}" {{$staff->role_id == $role->id ? 'selected' : ''}}>
                                                        {{$role -> name}}
                                                     </option>
                                                      @endforeach
                    
                                                      </select> 
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="address" class="col-form-label">လိပ်စာ</label>
                                                <textarea class="form-control" name="address">{{$staff->address}}</textarea>
                                            </div>
                                            {{-- <div class="form-group col-12">
                                                <label for="counter_shop" class="col-form-label">Counter Shop</label>
                                                <select name="counter_shop" id="counter" class="form-control" required>
                                                <option value="{{$staff->counter_shop}}">{{$staff->counter_shop}}</option>
                                                @foreach ($counters as $counter)
                                                <option value="{{$counter->shop_name}}">{{$counter->shop_name}}</option>
                                                @endforeach
                                            </div> --}}
                                           
                                        </div>
                                        
                                    </div>
                                    
                            </div>
                            
                            
                            <div class="row mt-5 offset-10">
                                <button type="submit" class="btn btn-sm btn-color text-center"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>Update</button>
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

    <script type="text/javascript">

      function back(){
        history.go(-1);
      }

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

