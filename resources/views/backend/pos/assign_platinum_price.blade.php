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
                    @if (!empty($assign_gold_price))
                    <div class="card-body">

                        <form action="{{route('backside.shop_owner.pos.update_assign_platinum_price',$assign_gold_price->id)}}" method="POST">
                           @csrf
                           <a href="{{route('backside.shop_owner.pos.assign_platinum_list')}}"><h4 class="text-color mt-2">​<i class="fa fa-chevron-left" aria-hidden="true"></i> &nbsp;&nbsp;ပလက်တီနမ်​စျေးသတ်မှတ်ခြင်း</h4></a>
                           <div class="col-3">
                            <label for="date" class="col-form-label">Choose Date</label>
                            <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                          </div>
                          <div class="row mt-5">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="gradeA" class="col-form-label">Grade A</label>
                                        <input type="number" name="gradeA" value="{{$assign_gold_price->gradeA}}">
                                    </div>
                                    <div class="col-6">
                                        <label for="gradeB" class="col-form-label">Grade B</label>
                                        <input type="number" name="gradeB" value="{{$assign_gold_price->gradeB}}">
                                    </div>
                                    <div class="col-6 mt-2">
                                        <label for="gradeC" class="col-form-label">Grade C</label>
                                        <input type="number" name="gradeC" value="{{$assign_gold_price->gradeC}}">
                                    </div>
                                    <div class="col-6 mt-2">
                                        <label for="gradeD" class="col-form-label">Grade D</label>
                                        <input type="number" name="gradeD" value="{{$assign_gold_price->gradeD}}">
                                    </div>
                                </div>
                            </div>
                          </div>
                               <div class="row mt-5 offset-10">
                                   <button type="submit" class="btn btn-sm btn-color text-center px-5"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>Update</button>
                               </div>

                       </form>

                   </div>
                   @else
                   <div class="card-body">
                    <form action="{{route('backside.shop_owner.pos.store_assign_platinum_price')}}" method="POST">
                       @csrf
                       <a href="{{route('backside.shop_owner.pos.assign_platinum_list')}}"><h4 class="text-color mt-2">​<i class="fa fa-chevron-left" aria-hidden="true"></i> &nbsp;&nbsp;ပလက်တီနမ်​စျေးသတ်မှတ်ခြင်း</h4></a>
                           <div class="col-3">
                            <label for="date" class="col-form-label">Choose Date</label>
                            <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                          </div>
                          <div class="row mt-5">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="gradeA" class="col-form-label">Grade A</label>
                                        <input type="number" name="gradeA" value="">
                                    </div>
                                    <div class="col-6">
                                        <label for="gradeB" class="col-form-label">Grade B</label>
                                        <input type="number" name="gradeB" value="">
                                    </div>
                                    <div class="col-6 mt-2">
                                        <label for="gradeC" class="col-form-label">Grade C</label>
                                        <input type="number" name="gradeC" value="">
                                    </div>
                                    <div class="col-6 mt-2">
                                        <label for="gradeD" class="col-form-label">Grade D</label>
                                        <input type="number" name="gradeD" value="">
                                    </div>
                                </div>
                            </div>
                          </div>
                          <div class="row mt-5 offset-10">
                            <button type="submit" class="btn btn-sm btn-color text-center px-5"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>Save</button>
                        </div>

                   </form>
               </div>
                    @endif

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
@push('css')
<style>
    .btn-color{
        background: #780116;
        color:white;
    }
    .btn-color:hover{
        color: white;
    }
    .text-color{
        color: #780116;
    }
</style>
@endpush
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


    </style>
@endpush

