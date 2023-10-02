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

                    <div class="card">
                        <div class="card-body">
                            {{-- <span class="offset-5  mt-2 font-weight-bold" style="font-size:19px;">Create Purchase Form (ရွှေ)</span> --}}
                            <form action="{{ route('backside.shop_owner.pos.store_return') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-7">
                                        <h4 class="text-color mt-2">​<i class="fa fa-chevron-left" aria-hidden="true"
                                                onclick="back()"></i> &nbsp;&nbsp;​​အထည်​ဟောင်းဝယ်ယူမှု စာရင်းသွင်းခြင်း</h4>
                                        <div class="col-4 mt-2">
                                            <label for="date" class="col-form-label">​နေ့စွဲ</label>
                                            <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>"><br><br>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <span class="text-color" style="font-size:19px;">Customer Information</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-color" style="font-size:19px;">ဝယ်ယူမည့်ပစ္စည်း</span>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-5">
                                        <div class="row">
                                            <div class="col-6 form-group">
                                                <label for="name">ရောင်းသူအမည်</label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                            <div class="col-6 form-group">
                                                <label for="phone">ဖုန်းနံပါတ်</label>
                                                <input type="text" name="phone" class="form-control" id="phone"
                                                    required>
                                            </div>
                                            <div class="col-12 form-group">
                                                <label for="addresss">​နေရပ်လိပ်စာ</label>
                                                <textarea id="" cols="30" rows="4" class="form-control" name="address"></textarea>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="remark">မှတ်ချက်ထည့်သွင်းရန်</label>
                                                <textarea name="remark" id="" cols="30" rows="5"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="offset-1 col-5">
                                        <div class="row">
                                            <div class="col-6 form-group">
                                                <label for="category_id">Product အမျိုးအစား</label>
                                                <select name="category_id" class="form-control" id="category_id" required>
                                                    <option value="">အမျိုးအစားများ</option>
                                                    @foreach ($categories as $cat)
                                                    <option value="{{$cat->id}}">{{$cat->mm_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6 form-group">
                                                <label for="quality">ရွှေအရည်အသွေး</label>
                                                <select name="quality" class="form-control" onchange="calculate_quality_price(this.value)" required>
                                                    <option value="">ရွှေအရည်အသွေးများ</option>
                                                    @foreach ($quality as $q)
                                                    <option value="{{$q->id}}">{{$q->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <div>
                                                    <label for="product_weight">Product အလေးချိန်</label>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3 form-group">
                                                        <input type="number" step="0.01" name="product_gram" placeholder="Gram" id="product_weight" class="form-control" required>

                                                    </div>
                                                    <div class="col-3 form-group">
                                                        <input type="number" step="0.01" name="product_kyat"  id="product_kyat" class="form-control"  placeholder="ကျပ်">

                                                    </div>
                                                    <div class="col-3 form-group">
                                                        <input type="number" step="0.01" name="product_pe" id="product_pe" class="form-control"  placeholder="ပဲ">
                                                    </div>
                                                    <div class="col-3 form-group">
                                                        <input type="number" step="0.01" name="product_yway" id="product_yway" class="form-control"  placeholder="ရွေး">
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="col-3" >
                                                <input type="text" name='gold_price' id='gold_price'>
                                            </div> --}}
                                            {{-- <div class="col-12">
                                                <div class="row" style="margin-top:30px;">
                                                    <a href="#" class="btn btn-m btn-color text-center col-12"  onclick="calculate_price()">​စျေးနှုန်းတွက်ရန်</a>
                                                </div>
                                            </div> --}}
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 form-group">
                                                        {{-- <span class="text-color" style="font-size:19px;">စိန်​ကျောက်ထည်အ​ကြောင်းများ</span><br><br> --}}
                                                        <label for="include_diamonds">ပါဝင်သည့်စိန်​ကျောက်များ</label>
                                                        <select class="js-example-basic-single form-control" name="include_diamonds[]" multiple="multiple" id="include_diamonds" onchange="add_diamond(this.value)">
                                                            <option>စိန်​ကျောက်များ</option>
                                                            @foreach ($diamonds as $diamond)
                                                            <option value="{{$diamond->diamond_name}}">{{$diamond->code_number}}-{{$diamond->diamond_name}}</option>
                                                            @endforeach
                                                            <option value="Test"> test</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row" >
                                                    <div class="col-12" id="add_diamond">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 form-group mt-4">
                                                <label for="product_type">​ပစ္စည်းအမျိုးအစား</label>
                                                <select name="product_type" id="" class="form-control">
                                                    <option value="">​ပစ္စည်းအမျိုးအစားများ</option>
                                                    <option value="စိန်">စိန်</option>
                                                    <option value="ရွှေ">ရွှေ</option>
                                                    <option value="ပလက်တီနမ်">ပလက်တီနမ်</option>
                                                    <option value="ရွှေဖြူ">ရွှေဖြူ</option>
                                                    <option value="18k">18k</option>
                                                </select>
                                            </div>
                                            <div class="col-6 form-group mt-4">
                                                <label for="gold_fee">​စျေးနှုန်း &nbsp;<span id="old_fee" class="text-color"></span></label>
                                                <input type="number" name="gold_fee" class="form-control" id="gold_fee">
                                            </div>
                                            <div class="col-12 form-group mt-4">
                                                <label for="vou_photo">​Voucher Upload</label>
                                                <div class="image-upload-wrap py-3">
                                                    <input class="file-upload-input" type='file' id="image"  accept="image/*" name="photo"/>
                                                    <div class="drag-text">
                                                      <h6 class="mt-1"><img src=""  style="max-height: 100px;" id="preview-image-before-upload">ပုံ​ရွေးရန်</h6>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4 offset-10">
                                    <button type="submit" class="btn btn-m btn-color text-center"><i
                                            class="fa fa-floppy-o mr-2" aria-hidden="true"></i>Save</button>
                                    {{-- <button  class="btn btn-m btn-outline-color text-center"><i class="fa fa-print mr-2" aria-hidden="true"></i>​ဘောင်ချာထုတ်ရန်</button> --}}
                                </div>
                            </form>
                            <div id="mobileprint" class="d-none">

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
<script type="text/javascript">
    $('.select2').select2();
    $('.js-example-basic-single').select2();
    $(document).ready(function(){
            $('#image').change(function(){

            let reader = new FileReader();

            reader.onload = (e) => {

              $('#preview-image-before-upload').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);

           });

        });
        function calculate_quality_price(val){
            $.ajax({

                type:'POST',

                url:'{{route("backside.shop_owner.pos.quality_gold_price")}}',

                data:{
                "_token":"{{csrf_token()}}",
                "quality_id":val,
                },

                success:function(data){
                    $('#gold_price').val(data);
                }
            })
        }

        function calculate_price(){
            var yway = parseFloat($('#product_yway').val());
            var pe = parseFloat($('#product_pe').val());
            var kyat = parseFloat($('#product_kyat').val());
            var gold_price = parseInt($('#gold_price').val());
            if(yway){ yway = yway;}else{ yway = 0;}
            if(pe){ pe = pe;}else{ pe = 0;}
            if(kyat){ kyat = kyat;}else{ kyat = 0;}

            var fee =  ((((yway/8)+pe)/16)+kyat)*gold_price;
            var gold_fee = parseInt(fee);
            $('#gold_fee').val(gold_fee);
        }

        function back() {
            history.go(-1);
        }

        function setOldfee() {
            var oldfee = $('#gold_fee').val();
            $('#old_fee').html(`(${oldfee})`);
        }
        function add_diamond(val){
        var count = $('#include_diamonds').val();
        var html = '';
        if(count){
        $.each(count, function(i, v) {
            html += `
            <div class="row form-group mt-2">
                <div class="col-12">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="diamond_name[]" value="${v}">
                </div>
                <div class="col-6">
                    <label for="" class="text-danger">Count*</label>
                    <input type="text" class="form-control" name="counts[]" value="0">
                </div>
                <div class="col-6">
                    <label for="">ကာရက်</label>
                    <input type="text" class="form-control" name="carrats[]" value="0">
                </div>
                <div class="col-6">
                    <label for="">ရတီ</label>
                    <input type="text" class="form-control" name="yaties[]" value="0">
                </div>
                <div class="col-6">
                    <label for="">ဘီ</label>
                    <input type="text" class="form-control" name="bes[]" value="0">
                </div>
            </div>
            `;
        })
    }
        $('#add_diamond').html(html);
        // alert($('#count').val());
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
