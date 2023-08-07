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
            @if (Session::has('message'))
                <x-alert>

                </x-alert>
            @endif
            <!-- Content Header (Page header) -->
            <section class="content-header sn-content-header">
                <div class="container-fluid">
                    @foreach ($shopowner as $shopowner)
                    @endforeach


                </div><!-- /.container-fluid -->
            </section>

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                    <div class="card card-body printableArea" style="max-width: 750px;">
                        {{-- <div style="display:flex;justify-content:space-around"> --}}
                            @php
                            use App\Shopowner;
                            use App\Manager;

                            if(isset(Auth::guard('shop_owner')->user()->id)){
                                $current_shop=Shopowner::where('id',Auth::guard('shop_owner')->user()->id)->first();
                            }else{
                                $manager= Manager::where('id', Auth::guard('shop_role')->user()->id)->pluck('shop_id');
                                $current_shop=Shopowner::where('id',$manager)->first();

                            }

                            @endphp
                            <div class="row d-flex">
                                <div style="border:1px solid #780116;border-radius:10px;" width='130'>
                                    <h6 class="text-color px-3 py-1">SHWESHOP</h6>
                                </div>
                                <div style="border:1px solid #780116;border-radius:10px;margin-left:480px;" width='130'>
                                    <h6 class="text-color px-3 py-1">0012345</h6>
                                </div>
                            </div>
                            <div class="row d-flex mt-4">
                                <div class="image">
                                    <img src="{{url('/images/logo/'.$current_shop->shop_logo)}}" class="img-circle elevation-2" alt="User Image" width="100" height="100">
                                </div>
                                <div class="info text-capitalize text-color ml-3 mt-4" style="font-size:20px;">
                                    {{\Illuminate\Support\Str::limit($current_shop->shop_name, 100, '...')}}
                                </div>
                            </div>
                            <div class="row mt-3">
                                @foreach ($counters as $counter)
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-3">
                                            <h6 class="text-color"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;&nbsp;{{$counter->shop_name}}</h6>
                                        </div>
                                        <div class="col-5">
                                            <h6 class="text-color"> |&nbsp;&nbsp;<i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;&nbsp;{{$counter->address}}</h6>
                                        </div>
                                        <div class="col-4">
                                            <h6 class="text-color"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;&nbsp;{{$counter->phno}},{{$counter->otherno}}</h6>
                                        </div>
                                    </div>

                                </div>

                                @endforeach
                            </div>
                            <div class="mt-3" style="border:2px solid #780116">

                            </div>
                            <h6 class="text-color mt-3 text-center font-weight-bold">ပစ္စည်း​ဟောင်းပြန်အဝယ်​ဘောက်ချာ</h6>
                            <div class="mt-3 row">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-5">
                                            <h6 class="text-color">ရက်စွဲ</h6>
                                            <h6 class="text-color mt-3">အချိန်</h6>
                                            <h6 class="text-color mt-3">အမည်</h6>
                                            <h6 class="text-color mt-3">Code No</h6>
                                            <h6 class="text-color mt-3">အမျိုးအစား</h6>
                                            <h6 class="text-color mt-3">​စျေးနှုန်း</h6>
                                            <h6 class="text-color mt-3">​ရွှေချိန်</h6>
                                            <h6 class="text-color mt-3">သင့်​ငွေ</h6>
                                            @if ($return->remark)
                                            <h6 class="text-color mt-3">မှတ်ချက်</h6>
                                            @endif
                                        </div>
                                        <div class="col-1">
                                            <h6 class="text-color">-</h6>
                                            <h6 class="text-color mt-3">-</h6>
                                            <h6 class="text-color mt-3">-</h6>
                                            <h6 class="text-color mt-3">-</h6>
                                            <h6 class="text-color mt-3">-</h6>
                                            <h6 class="text-color mt-3">-</h6>
                                            <h6 class="text-color mt-3">-</h6>
                                            <h6 class="text-color mt-3">-</h6>
                                            @if ($return->remark)
                                            <h6 class="text-color mt-3">-</h6>
                                            @endif
                                        </div>
                                        <?php
                                            $product = explode('/',$return->product_gram_kyat_pe_yway);
                                            ?>
                                        <div class="col-6">
                                            <h6 class="text-color">{{$return->date}}</h6>
                                            <h6 class="text-color mt-3"><?php echo explode(' ',$return->created_at)[1] ?></h6>
                                            <h6 class="text-color mt-3">{{$return->customer_name}}</h6>
                                            <h6 class="text-color mt-3">{{$code}}</h6>
                                            <h6 class="text-color mt-3">{{$return->product_type}}</h6>
                                            <h6 class="text-color mt-3">{{$return->gold_fee}}</h6>
                                            <h6 class="text-color mt-3">{{$product[1] ? $product[1].'ကျပ်' : ''}} {{$product[2] ? $product[2].'ပဲ' : ''}} {{$product[3] ? $product[3].'ရွေး' : ''}}</h6>
                                            <h6 class="text-color mt-3">{{$return->gold_fee}}</h6>
                                            @if ($return->remark)
                                            <h6 class="text-color mt-3">{{$return->remark}}</h6>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>


                        {{-- </div> --}}
                    </div>

                    </div>
                    <div class="row justify-content-center d-flex">
                        <button id="print" class="btn btn-color" type="button" onclick="print()"> <span><i class="fa fa-print"></i> Print</span> </button>
                        <button  class="btn btn-secondary ml-3" type="button" onclick="cancel()"> <span> Cancel</span> </button>
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
<script src="{{asset('js/jquery.PrintArea.js')}}" type="text/JavaScript"></script>
<script type="text/javascript">

    function print(){
        var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = {
            mode: mode,
            popClose: close
        };
        $(".printableArea").printArea(options);
    }
    function cancel(){
        // window.open('https://test.shweshops.com/backside/shop_owner/return_list');
        window.location.href = "{{ route('backside.shop_owner.pos.return_list')}}";
    }
    </script>
@endpush
@push('css')
    <style>
        body {
            background: #F0F7FA;
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        .btn-color {
            background: #780116;
            color: white;
            padding: 5px 25px;
        }

        .btn-outline-color {
            border: 1px solid #780116;
            color: #780116;
            padding: 5px 25px;
            margin-left: 10px;
        }

        .btn-color:hover {
            color: white;
        }

        .btn-outline-color:hover {
            color: white;
        }

        .text-color {
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

        .form-check-label {
            font-size: 20px;
        }

        .card-color {
            background-color: gray;
        }

        .card-color1 {
            background-color: gray;
        }
    </style>
@endpush
