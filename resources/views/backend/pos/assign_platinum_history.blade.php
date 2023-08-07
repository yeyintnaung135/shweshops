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

                        @if (!empty($assign_gold_price))
                        <div class="row">
                            <div class="col-9">
                                <span class="text-color" style="font-size:19px;">ပလက်တီနမ်​စျေးနှုန်းများ</span>
                            </div>
                            <div class="col-3">
                                <span class="text-color" style="font-size:19px;"><i class="fa fa-calendar-check-o mr-1" aria-hidden="true"></i><?php echo date("l, F j, Y");?></span>
                            </div>
                          </div>
                          <div class="row mt-5">
                            <div class="card col-2  p-2 card-color">
                                <span class="text-white" style="font-size:19px;">Grade A</span><br>
                                <span class="text-white" style="font-size:19px;">{{$assign_gold_price->gradeA}} MMK</span>
                            </div>
                            <div class="card offset-1 col-2  p-2 card-color1">
                                <span class="text-white" style="font-size:19px;">Grade B</span><br>
                                <span class="text-white" style="font-size:19px;">{{$assign_gold_price->gradeB}} MMK</span>
                            </div>
                            <div class="card offset-1 col-2  p-2 card-color">
                                <span class="text-white" style="font-size:19px;">Grade C</span><br>
                                <span class="text-white" style="font-size:19px;">{{$assign_gold_price->gradeC}} MMK</span>
                            </div>
                            <div class="card offset-1 col-2  p-2 card-color1">
                                <span class="text-white" style="font-size:19px;">Grade D</span><br>
                                <span class="text-white" style="font-size:19px;">{{$assign_gold_price->gradeD}} MMK</span>
                            </div>
                        </div>
                        <a href="{{route('backside.shop_owner.pos.assign_platinum_price')}}" class="btn btn-m btn-color float-right mt-3">Update</a>
                        @else
                        <div class="row">
                            <div class="col-9">
                                <span class="text-color" style="font-size:19px;">ပလက်တီနမ်​စျေးနှုန်းများ</span>
                            </div>
                            <div class="col-3">
                                <span class="text-color" style="font-size:19px;"><i class="fa fa-calendar-check-o mr-1" aria-hidden="true"></i><?php echo date("l, F j, Y");?></span>
                            </div>
                          </div>
                          <div class="row mt-5">
                            <div class="card col-2  p-2 card-color">
                                <span class="text-white" style="font-size:19px;">Grade A</span><br>
                                <span class="text-white" style="font-size:19px;">0 MMK</span>
                            </div>
                            <div class="card offset-1 col-2  p-2 card-color1">
                                <span class="text-white" style="font-size:19px;">Grade B</span><br>
                                <span class="text-white" style="font-size:19px;">0 MMK</span>
                            </div>
                            <div class="card offset-1 col-2  p-2 card-color">
                                <span class="text-white" style="font-size:19px;">Grade C</span><br>
                                <span class="text-white" style="font-size:19px;">0 MMK</span>
                            </div>
                            <div class="card offset-1 col-2  p-2 card-color1">
                                <span class="text-white" style="font-size:19px;">Grade D</span><br>
                                <span class="text-white" style="font-size:19px;">0 MMK</span>
                            </div>
                        </div>
                        <a href="{{route('backside.shop_owner.pos.assign_platinum_price')}}" class="btn btn-m btn-color float-right mt-3">Create</a>
                        @endif
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


    </script>
@endpush
@push('css')
    <style>
        body {
            background: #F0F7FA;
            font-family: 'Myanmar3', Sans-Serif !important;
        }
        .btn-color{
        background: #780116;
        color:white;
        padding: 5px 25px;
        }
        .btn-color:hover{
            color: white;
        }
        .text-color{
        color: #780116;
        }
        .file-upload-input {
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        outline: none;
        opacity: 0;
        cursor: pointer;
        }

        .image-upload-wrap {
        margin-top: 20px;
        border: 4px dashed #780116;
        position: relative;
        }

        .drag-text {
        text-align: center;
        }

        .form-check-label{
            font-size: 20px;
        }

        .card-color{
            background-color: gray;
        }
        .card-color1{
            background-color: gray;
        }

    </style>
@endpush

