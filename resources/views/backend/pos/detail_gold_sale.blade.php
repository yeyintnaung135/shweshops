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
                <div class="row mt-2">
                    <div class="col-4">
                        ​<i class="fa fa-chevron-left text-color" aria-hidden="true" onclick="back()"></i>
                    </div>
                    <div class="col-4 text-center">
                        <h4 class="text-color">​ရွှေထည်အမည်</h4>
                    </div>
                    <div class="offset-2">
                        <h6 class="text-color ml-5">​<i class="fa fa-calendar-check-o mr-1" aria-hidden="true"></i>{{$purchase->date}}</h6>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-11">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="text-color">ရွှေထည်အ​ကြောင်းများ</h6>
                                <div class="row mt-3">
                                    <div class="col-7">
                                        <div class="row">
                                            <div class="col-4">​
                                              <h6 class="">စျေးနှုန်း</h6>
                                              <h6 class="mt-4">ရောင်းဈေး</h6>
                                              <h6 class="mt-4">ကျသင့်​ငွေ</h6>
                                              @if ($purchase->return_price)
                                              <h6 class="mt-4">လဲမည့် တန်ဖိုး</h6>
                                              @endif
                                              @if ($purchase->left_price)
                                              <h6 class="mt-4">ကျန်​ငွေ</h6>
                                              @endif
                                              <h6 class="mt-4">အမြတ်</h6>
                                              <h6 class="mt-4">လက်ခ</h6>
                                              <h6 class="mt-4">Product အလေးချိန်</h6>
                                              <h6 class="mt-4">အလျော့တွက်</h6>
                                              <h6 class="mt-4">ဝယ်သူအမည်</h6>
                                              <h6 class="mt-4">ဖုန်းနံပါတ်</h6>
                                              <h6 class="mt-4">​နေရပ်လိပ်စာ</h6>

                                              <h6 class="mt-4">Code Number</h6>
                                              <h6 class="mt-4">ရွှေထည်အမည်</h6>
                                              <h6 class="mt-4">စုစု​ပေါင်းအ​ရေ​အတွက်</h6>
                                              <h6 class="mt-4">ပန်းထိမ်ဆိုင်</h6>
                                              <h6 class="mt-4">ရွှေအရည်အသွေး</h6>
                                              <h6 class="mt-4">ရွှေအမျိုးအစား</h6>
                                              <h6 class="mt-4">Product အမျိုးအစား</h6>
                                              <h6 class="mt-4">ဝယ်ယူသည့်​စျေးနှုန်း</h6>
                                              <h6 class="mt-4">စစ်​ဆေးမည့် ဝန်ထမ်း</h6>
                                              @if ($purchase->remark)
                                              <h6 class="mt-4">မှတ်ချက်</h6>
                                              @endif

                                            </div>
                                            <div class="col-1">
                                                <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              @if ($purchase->return_price)
                                              <h6 class="mt-4">-</h6>
                                              @endif
                                              @if ($purchase->left_price)
                                              <h6 class="mt-4">-</h6>
                                              @endif
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              @if ($purchase->remark)
                                              <h6 class="mt-4">-</h6>
                                              @endif


                                            </div>
                                            <?php
                                            $product = explode('/',$purchase->purchase->product_gram_kyat_pe_yway);
                                            $decrease = explode('/',$purchase->purchase->decrease_pe_yway);
                                            $profit = explode('/',$purchase->purchase->profit);
                                            $service = explode('/',$purchase->purchase->service_fee);
                                            ?>
                                            <div class="col-7">
                                            <h6 class="text-color mt-4">{{$purchase->price}} ကျပ်</h6>
                                              <h6 class="text-color mt-4">{{$purchase->amount}} ကျပ်</h6>
                                              <h6 class="text-color mt-4">{{$purchase->amount}} ကျပ်</h6>
                                              @if ($purchase->return_price)
                                              <h6 class="text-color mt-4">{{$purchase->return_price}} ကျပ်</h6>
                                              @endif
                                              @if ($purchase->return_price)
                                              <h6 class="text-color mt-4">{{$purchase->left_price}} ကျပ်</h6>
                                              @endif
                                              <h6 class="text-color mt-4">{{$profit[0]}}</h6>
                                              <h6 class="text-color mt-4">{{$service[0]}}</h6>
                                              <h6 class="text-color mt-4">{{$product[1] ? $product[1].'ကျပ်' : ''}} {{$product[2] ? $product[2].'ပဲ' : ''}} {{$product[3] ? $product[3].'ရွေး' : ''}}</h6>
                                              <h6 class="text-color mt-4">{{$decrease[0] ? $decrease[0].'ပဲ' : ''}} {{$decrease[1] ? $decrease[1].'ရွေး' : ''}}</h6>
                                              <h6 class="text-color mt-4">{{$purchase->customer_name}}</h6>
                                              <h6 class="text-color mt-4">{{$purchase->phone}}</h6>
                                              <h6 class="text-color mt-4">{{$purchase->address}}</h6>

                                              <h6 class="text-color mt-4">{{$purchase->purchase->code_number}}</h6>
                                              <h6 class="text-color mt-4">{{$purchase->purchase->gold_name}}</h6>
                                              <h6 class="text-color mt-4">1</h6>
                                              <h6 class="text-color mt-4">{{$purchase->purchase->supplier->name}}</h6>
                                              <h6 class="text-color mt-4">{{$purchase->purchase->quality->name}}</h6>
                                              <h6 class="text-color mt-4">{{$purchase->purchase->gold_type}}</h6>
                                              <h6 class="text-color mt-4">{{$purchase->purchase->category->name}}</h6>
                                              <h6 class="text-color mt-4">{{$purchase->purchase->purchase_price}} ကျပ်</h6>
                                              <h6 class="text-color mt-4">{{$purchase->staff_id}}</h6>
                                              @if ($purchase->remark)
                                              <h6 class="text-color mt-4">{{$purchase->remark}}</h6>
                                              @endif

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <img src="{{asset('main/images/pos/goldpurchase_photo/'.$purchase->purchase->photo)}}" alt="">
                                        <div class="mt-5">
                                            <input type="hidden" id="text" value="{{$purchase->purchase->barcode}}"/>
                                            <input type="hidden" id="scan_text" value="{{$purchase->purchase->barcode_text}}"/>
                                            <div>
                                                <div id="showVal"></div>
                                                <div id="bcTarget"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">

                                </div>
                            </div>
                        </div>
                        <br>
                        {{-- <div class="card">
                            <div class="card-body">
                                <div class="row mt-3">
                                    <div class="col-7">

                                        <div class="row">
                                            <div class="col-4">




                                            </div>
                                            <div class="col-1">

                                            </div>
                                            <div class="col-7">

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div> --}}

                    </div>
                    <div class="col-1">
                        <a href="{{route('backside.shop_owner.pos.edit_goldsale',$purchase->id)}}" class="ml-2 mt-4 btn btn-sm btn-warning text-white"><i class="fa fa-pencil" ></i></a><br>
                        <a href="#myModal{{$purchase->id}}" class="btn btn-sm btn-danger text-white mt-3 ml-2" data-toggle="modal"><i class="fa fa-trash"></i></a>
                        <div id="myModal{{$purchase->id}}" class="modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete List</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-center">Are you Sure to Delete this List?</p>
                                    </div>
                                    <div class="modal-footer text-center">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCLE</button>
                                        <button type="button" class="btn btn-color" onclick="suredelete({{$purchase->id}})">DELETE</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        $(document).ready(function(){

            var barcode_text = $('#scan_text').val();
            var text = $('#text').val();
            $("#showVal").text(barcode_text);
            $("#bcTarget").barcode(text, "code39");

        });

        function  addBarcodeText(val){
            $('#scan_text').val(val);
        }

        function fill_capital(val){
            $('#capital').val(val);
        }

        function check_barcode(){
            if($('#print_barcode').is(':checked')){
                var code = $('#code_number').val();
                var gram = $('#product_gram').val();

                var barcode_text = $('#barcode_text').val();
                if(code == '' || gram == ''){
                    swal({
                            title: "Warning!",
                            text : "You need to fill code number or product's gram!",
                            icon : "warning",
                        });
                }else{
                    $('#text').val(code+'-'+gram);
                    $('#scan_text').val(barcode_text);
                    $('#print_barcode').val(1);
                    $('#barcode_convert').show();
                    $('#text_barcode').show();

                }
            }else{
                $('#barcode_convert').hide();
                $('#text_barcode').hide();
            }

        }

        function suredelete(id){
            // alert(id);
                $.ajax({

                    type:'POST',

                    url: '{{route("backside.shop_owner.pos.delete_goldsale")}}',

                    data:{
                    "_token":"{{csrf_token()}}",
                    "pid" : id,
                    },

                    success:function(data){
                        // window.open('https://test.shweshops.com/backside/shop_owner/gold_sale_list');
                        window.location.href = "{{ route('backside.shop_owner.pos.gold_sale_list')}}";
                       
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
        .badge-color{
        background: #780116;
        color:white;
        font-size:13px;
        padding: 6px 6px;
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
            background-color: #D4AF37;
        }
        .card-color1{
            background-color: #780116;
        }

    </style>
@endpush

