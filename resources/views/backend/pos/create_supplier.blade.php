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
                         <form action="{{route('backside.shop_owner.pos.store_supplier')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                           <h4 class="text-color mt-2">​<i class="fa fa-chevron-left" aria-hidden="true" onclick="back()"></i> &nbsp;&nbsp;ပန်းထိမ်ကုန်သည်စာရင်းသွင်းခြင်း</h4>
                           <div class="col-3">
                            <label for="date" class="col-form-label">Choose Date</label>
                            <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>"><br><br>
                            <span class="text-color" style="font-size:19px;">ပန်းထိမ်ဆိုင်အချက်အလက်များ</span>
                          </div>
                            <div class="row mt-4">
                                <div class="form-group col-4">
                                    <label for="shop_name" class="col-form-label">ဆိုင်အမည်</label>
                                    <input type="text" class="form-control" name="shop_name">
                                </div>
                                <div class="form-group col-4">
                                    <label for="shop_type" class="col-form-label">ဆိုင်အမျိုးအစား</label>
                                    <select class="form-control" name="shop_type">
                                        <option value="ပန်းထိမ်ဆိုင်">ပန်းထိမ်ဆိုင်</option>
                                        <option value="လက်ကားဆိုင်">လက်ကားဆိုင်</option>
                                        <option value="ကိုယ်ပိုင်ပန်းထိမ်ဆိုင်">ကိုယ်ပိုင်ပန်းထိမ်ဆိုင်</option>
                                    </select>
                                </div>
                                <div class="col-4">

                                </div>
                                <div class="form-group col-4">
                                    <label for="code_number" class="col-form-label">ကုဒ်နံပါတ်</label>
                                    <input type="text" class="form-control" name="code_number">
                                </div>
                                <div class="form-group col-4">
                                    <label for="name" class="col-form-label">ပန်းထိမ်ဆရာအမည်</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="col-4">

                                </div>
                                <div class="form-group col-4">
                                    <label for="phone" class="col-form-label">ဖုန်းနံပါတ်</label>
                                    <input type="number" class="form-control" name="phone">
                                </div>
                                <div class="form-group col-4 ">
                                    <label for="other_phone" class="col-form-label">တခြားဖုန်းနံပါတ်</label>
                                    <input type="number" class="form-control" name="other_phone">
                                </div>
                                <div class="col-4">

                                </div>
                                <div class="form-group col-4">
                                    <label for="state" class="col-form-label">တိုင်း​ဒေသကြီး</label>
                                    <select class="form-control" name="state" onchange="changeState(this.value )">
                                        @foreach ($state as $st)
                                        <option value="{{$st->id}}">{{$st->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label for="township" class="col-form-label">မြို့နယ်</label>
                                    <select class="form-control" name="township" id="township">
                                        @foreach ($township as $ts)
                                        <option value="{{$ts->id}}">{{$ts->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-8">
                                <label for="address" class="col-form-label">​နေရပ်လိပ်စာအပြည့်အစုံ</label>
                                <textarea class="form-control" name="address"></textarea>
                                </div>
                                <div class="form-group col-8">
                                    <label for="remark" class="col-form-label">မှတ်ချက်</label>
                                    <textarea class="form-control" name="remark"></textarea>
                                </div>
                                <div class="col-8 mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name='inlineCheckbox1' value="option1" />
                                        <label class="form-check-label" for="inlineCheckbox1">​ရွှေထည်</label>
                                    </div>

                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name='inlineCheckbox2' value="option2" />
                                        <label class="form-check-label" for="inlineCheckbox2">​ကျောက်မျက်ရတနာ</label>
                                      </div>

                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name='inlineCheckbox3' value="option3"/>
                                        <label class="form-check-label" for="inlineCheckbox3">စိန်ထည်</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox4" name='inlineCheckbox4' value="option4" />
                                        <label class="form-check-label" for="inlineCheckbox4">ပလက်တီနမ်</label>
                                      </div>
                                </div>

                                <div class="col-6">

                                </div>
                                <div class="row mt-5 offset-4">
                                    <button type="submit" class="btn btn-sm btn-color text-center"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>Save</button>
                                </div>
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
      function changeState(id){
        $.ajax({

        type:'POST',

        url: '{{route("backside.shop_owner.pos.change_state")}}',

        data:{
        "_token":"{{csrf_token()}}",
        "sid" : id,
        },

        success:function(data){
            var html = '';
            $.each(data, function(i, v) {
                html+=`
                <option value="${v.id}">${v.name}</option>
                `;
            })
            $('#township').html(html);
        }
        })
      }

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

