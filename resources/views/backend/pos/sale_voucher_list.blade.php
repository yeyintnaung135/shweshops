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
                    {{-- @foreach ($shopowner as $shopowner)
                    @endforeach --}}


                </div><!-- /.container-fluid -->
            </section>

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                    <div class="card card-body printableArea" style="max-width: 750px;">
                        {{-- <div style="display:flex;justify-content:space-around"> --}}
                            
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
                                    <img src="{{url('/images/logo/'.$shopowner->shop_logo)}}" class="img-circle elevation-2" alt="User Image" width="100" height="100">
                                </div>
                                <div class="info text-capitalize text-color ml-3 mt-4" style="font-size:20px;">
                                    {{\Illuminate\Support\Str::limit($shopowner->shop_name, 100, '...')}}
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
                            <table class="table" style="border:#780116">
                                <tr>
                                  <th colspan="4">
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <h6 class="text-color">အမည် - {{$sale->customer_name}}</h6>
                                        </div>
                                        <div class="col-4">
                                            <h6 class="text-color text-center">ဖုန်းနံပါတ် - {{$sale->phone}}</h6>
                                        </div>
                                        <div class="col-4">
                                            <h6 class="text-color text-right">ရက်စွဲ - {{$sale->date}}</h6>
                                        </div>
                                        <div class="col-6 mt-4">
                                            <h6 class="text-color">ပစ္စည်းအမျိုးအမည် - {{$sale->purchase->category->mm_name}}</h6>
                                        </div>
                                        <div class="col-6 mt-4">
                                            <h6 class="text-color text-right">နေရပ်လိပ်စာ - {{$sale->address}}</h6>
                                        </div>
                                    </div>
                                  </th>
                                </tr>
                                <tr class="text-color">
                                <td rowspan="3"></td>
                                <td rowspan="3" class="text-center text-color">​စျေးနှုန်း</td>
                                <td colspan="2">ရွှေဒင်္ဂါး​ရွှေအရည်မီ</td>
                                </tr>
                                <tr class="text-color">
                                <td colspan="2">၁၅ ပဲ​ရွှေအရည်ပြည့် &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - {{$price15}} ကျပ်</td>
                                </tr>
                                <tr class="text-color">
                                    <td colspan="2">အ​ခေါက်​ရွှေ အရည်ပြည့် &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - {{$shop_price}} ကျပ်</td>
                                </tr>
                                @if ($cancel == 2)
                                <?php
                                $product = explode('/',$sale->purchase->product_weight);
                                $diamond = explode('/',$sale->purchase->diamond_gram_kyat_pe_yway);
                                $decrease = explode('/',$sale->purchase->decrease_pe_yway);
                                ?>
                                @else
                                <?php
                                $product = explode('/',$sale->purchase->product_weight);
                                $decrease = explode('/',$sale->purchase->decrease_pe_yway);
                                $diamond = 'no';
                                ?>
                                @endif


                                <tr class="text-color">
                                    <td></td>
                                    <td class="text-center">အ​လေးချိန်</td>
                                     @if (!$sale->purchase->product_gram)
                                    <td>{{$product[1] ? $product[1].'ကျပ်' : ''}} {{$product[2] ? $product[2].'ပဲ' : ''}} {{$product[3] ? $product[3].'ရွေး' : ''}}</td>
                                    <td>{{$product[0]}} g</td>
                                     
                                    @else
                                     <td>-</td>
                                    <td>{{$sale->purchase->product_gram}} g</td>
                                    @endif
                                   
                                </tr>
                                <tr class="text-color">
                                    <td></td>
                                    <td class="text-center">စိန်​ကျောက်ချိန်</td>
                                    @if (!$sale->purchase->product_gram)
                                    @if ($diamond != 'no')
                                    <td>{{$diamond[1] ? $diamond[1].'ကျပ်' : ''}} {{$diamond[2] ? $diamond[2].'ပဲ' : ''}} {{$diamond[3] ? $diamond[3].'ရွေး' : ''}}</td>
                                    <td>{{$diamond[0]}} g</td>
                                     
                                    @else
                                     <td>-</td>
                                    <td>-</td>
                                    @endif
                                    @else
                                    <td>-</td>
                                    <td>-</td>
                                    @endif
                                   
                                </tr>
                                <tr class="text-color">
                                    <td></td>
                                    <td class="text-center">အ​လျော့တွက်</td>
                                    @if (!$sale->purchase->product_gram)
                                    @if ($decrease)
                                    <td>{{$decrease[0] ? $decrease[0].'ပဲ' : ''}} {{$decrease[1] ? $decrease[1].'ရွေး' : ''}}</td>
                                    @else
                                    <td>0</td>
                                    @endif
                                    @else
                                    <td>0</td>
                                    @endif

                                    <td></td>
                                </tr>
                                <tr class="text-color">
                                    <td></td>
                                    <td class="text-center">​ပေါင်းချိန်</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="text-color">
                                    <td></td>
                                    <td class="text-center">အပ်ချိန်</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="text-color">
                                    <td rowspan="6" colspan="2" class="text-color">
                                        <h6>​ရောင်းသူ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- {{$sale->staff_id}}</h6>
                                        <h6 class="mt-2">​ဘောက်ချာဖွင့်သူ - {{$sale->counter_shop}}</h6>
                                        <h4>အာမခံ​ဘောက်ချာ</h4>
                                        <h6>ပစ္စည်းနှင့်​စျေးနှုန်းမှန်ကန်​ကြောင်း အာမခံပါသည်</h6>
                                    </td>
                                    <td class="text-center">ရွှေဖိုး</td>
                                    <td>{{$gold_fee ? $gold_fee : 0}}</td>
                                </tr>
                                <tr class="text-color">
                                    <td class="text-center">​ကျောက်ဖိုး</td>
                                    <td>{{$diamond_fee}}</td>

                                    </tr>
                                    <tr class="text-color">
                                    <td class="text-center">​လက်ခ</td>
                                    <td>{{$service_fee ? $service_fee : 0}}</td>
                                    </tr>
                                    <tr class="text-color">
                                        <td class="text-center">စုစု​ပေါင်း</td>
                                        <td>{{$sale->amount}}</td>
                                    </tr>
                                    <tr class="text-color">
                                        <td class="text-center">စရန်​ငွေ</td>
                                    <td>{{$sale->prepaid}}</td>
                                    </tr>
                                    <tr class="text-color">
                                        <td class="text-center">ကျန်​ငွေ</td>
                                    <td>{{$sale->credit}}</td>
                                    </tr>
                              </table>

            <div class="row mt-4">
                <div class="col-4">
                    <div class="card card-body" style="border:1px solid #780116;border-radius:5px;">
                        <p class="text-color" style="font-size:19px;">
                            {{$counters[0]->remark}}
                        </p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card card-body" style="border:1px solid #780116;border-radius:5px;">
                        <p class="text-color" style="font-size:19px;">
                            {{$counters[0]->terms}}
                        </p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card card-body" style="border:1px solid #780116;border-radius:5px;">
                        <p class="text-color" style="font-size:19px;">
                            {{$counters[0]->offdays}}
                        </p>
                    </div>
                </div>
            </div>

                        {{-- </div> --}}
                    </div>

                    </div>
                    <div class="row justify-content-center d-flex">
                        <button id="print" class="btn btn-color" type="button" onclick="print()"> <span><i class="fa fa-print"></i> Print</span> </button>
                        <button  class="btn btn-secondary ml-3" type="button" onclick="cancel({{$cancel}})"> <span> Cancel</span> </button>
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
    function cancel(val){
        if(val == 1){
            // window.open('https://test.shweshops.com/backside/shop_owner/gold_sale_list');
            window.location.href = "{{ route('backside.shop_owner.pos.gold_sale_list')}}";
        }
        if(val == 2){
            // window.open('https://test.shweshops.com/backside/shop_owner/sale_kyout_list');
            window.location.href = "{{ route('backside.shop_owner.pos.sale_kyout_list')}}";
        }
        if(val == 3){
            // window.open('https://test.shweshops.com/backside/shop_owner/ptm_sale_list');
            window.location.href = "{{ route('backside.shop_owner.pos.ptm_sale_list')}}";
        }
        if(val == 4){
            // window.open('https://test.shweshops.com/backside/shop_owner/wg_sale_list');
            window.location.href = "{{ route('backside.shop_owner.pos.wg_sale_list')}}";
        }
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
