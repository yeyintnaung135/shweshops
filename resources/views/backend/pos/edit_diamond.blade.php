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
                         <form action="{{route('backside.shop_owner.pos.update_diamond',$diamond->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                           <h4 class="text-color mt-2">​<i class="fa fa-chevron-left" aria-hidden="true" onclick="back()"></i> &nbsp;&nbsp;စိန်​ကျောက်ထည်အမည်ပြင်ဆင်ခြင်း</h4>
                           <div class="col-5">
                            <label for="date" class="col-form-label">Choose Date</label>
                            <input type="date" name="date" value="{{$diamond->date}}"><br><br>
                            <span class="text-color" style="font-size:19px;">စိန်​ကျောက်ထည်အချက်အလက်များ</span>
                          </div>
                            <div class="row mt-4">
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <label for="diamond_name" class="col-form-label">စိန်​ကျောက်အမည်</label>
                                                <input type="text" class="form-control" name="diamond_name" value="{{$diamond->diamond_name}}">
                                            </div>

                                            <div class="form-group col-6">
                                                <label for="code_number" class="col-form-label">ကုဒ်နံပါတ်</label>
                                                <input type="text" class="form-control" name="code_number" value="{{$diamond->code_number}}">
                                            </div>

                                            <div class="form-group col-6">
                                                <label for="carrat" class="col-form-label">ကာရက်ဈေးနှုန်း </label>
                                                <input type="text" class="form-control" name="carrat" value="{{$diamond->carrat_price}}">
                                            </div>

                                            <div class="form-group col-6">
                                                <label for="yati" class="col-form-label">ရတီဈေးနှုန်း</label>
                                                <input type="text" class="form-control" name="yati" value="{{$diamond->yati_price}}">
                                            </div>

                                            <div class="form-group col-12">
                                                <label for="remark" class="col-form-label">မှတ်ချက်</label>
                                                <textarea class="form-control" name="remark">{{$diamond->remark}}</textarea>
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

