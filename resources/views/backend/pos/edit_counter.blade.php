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
                         <form action="{{route('backside.shop_owner.pos.update_counter',$counter->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                           <h4 class="text-color mt-2">​<i class="fa fa-chevron-left" aria-hidden="true" onclick="back()"></i> &nbsp;&nbsp;ဆိုင်ခွဲစာရင်းပြင်ဆင်ခြင်း</h4>
                           <div class="col-5">
                            <label for="date" class="col-form-label">Choose Date</label>
                            <input type="date" name="date" value="{{$counter->date}}"><br><br>
                            <span class="text-color" style="font-size:19px;">ဆိုင်ခွဲအချက်အလက်များ</span>
                          </div>
                            <div class="row mt-4">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="shop_name" class="col-form-label">ဆိုင်ခွဲအမည်</label>
                                                <input type="text" class="form-control" name="shop_name" value="{{$counter->shop_name}}">
                                            </div>

                                            <div class="form-group col-6">
                                                <label for="counter_name" class="col-form-label">​ကောင်တာအမည်</label>
                                                <input type="text" class="form-control" name="counter_name" value="{{$counter->counter_name}}">
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="staff_no" class="col-form-label">ဝန်ထမ်းစုစု​ပေါင်းအ​ရေ​အတွက်</label>
                                                <input type="number" class="form-control" name="staff_no" value="{{$counter->staff_no}}">
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="state" class="col-form-label">တိုင်း​ဒေသကြီး</label>
                                                <select class="form-control" name="state">
                                                    <option value="{{$counter->state_id}}">{{$counter->state->name}}</option>
                                                    @foreach ($state as $st)
                                                    <option value="{{$st->id}}">{{$st->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="phno" class="col-form-label">ဖုန်းနံပါတ်</label>
                                                <input type="number" class="form-control" name="phno" value="{{$counter->phno}}">
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="otherno" class="col-form-label">တခြားဖုန်းနံပါတ်</label>
                                                <input type="number" class="form-control" name="otherno" value="{{$counter->otherno}}">
                                            </div>
                                            <div class="form-group col-12">
                                                <label for="address" class="col-form-label">လိပ်စာ</label>
                                                <textarea class="form-control" name="address">{{$counter->address}}</textarea>
                                            </div>
                                            <div class="form-group col-12">
                                                <label for="terms" class="col-form-label">Terms & Conditions</label>
                                                <textarea class="form-control" name="terms">{{$counter->terms}}</textarea>
                                            </div>
                                            <div class="form-group col-12">
                                                <label for="offdays" class="col-form-label">ဆိုင်ပိတ်ရက်များ</label>
                                                <textarea class="form-control" name="offdays">{{$counter->offdays}}</textarea>
                                            </div>
                                            <div class="form-group col-12">
                                                <label for="remark" class="col-form-label">မှတ်ချက်</label>
                                                <textarea class="form-control" name="remark">{{$counter->remark}}</textarea>
                                            </div>
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

    <script>


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

    </style>
@endpush

