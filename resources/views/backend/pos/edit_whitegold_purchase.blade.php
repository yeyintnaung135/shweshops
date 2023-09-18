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
                        {{-- <span class="offset-5  mt-2 font-weight-bold" style="font-size:19px;">Create Purchase Form (ရွှေ)</span> --}}
                         <form action="{{route('backside.shop_owner.pos.update_wg_purchase',$purchase->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-7">
                                    <h4 class="text-color mt-2">​<i class="fa fa-chevron-left" aria-hidden="true" onclick="back()"></i> &nbsp;&nbsp;ရွှေဖြူစာရင်းပြင်ဆင်ခြင်း</h4>
                                    <div class="col-4 mt-2">
                                        <label for="date" class="col-form-label">Choose Date</label>
                                        <input type="date" name="date" value="{{$purchase->date}}"><br><br>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="row mt-3">
                                        <div class="card col-5 py-2 card-color">
                                            <span class="text-white" style="font-size:19px;">Grade A</span><br>
                                            <span class="text-white" style="font-size:19px;">{{$gradeA}} mmk</span>
                                        </div>
                                        <div class="card offset-1 col-5 py-2 card-color1">
                                            <span class="text-white" style="font-size:19px;">Grade B</span><br>
                                            <span class="text-white" style="font-size:19px;">{{$gradeB}} mmk</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                           <div class="row">
                            <div class="col-7">
                                <span class="text-color" style="font-size:19px;">​ရွှေဖြူအထည်အ​ကြောင်းများ</span>
                            </div>
                            <div class="col-5">
                                <span class="text-color" style="font-size:19px;">​ရွှေဖြူ​စျေးနှုန်းတွက်ချက်ခြင်း</span>
                            </div>
                          </div>
                         <div class="row mt-5">
                            <div class="col-3 form-group">
                                <label for="wg_name">​ရွှေဖြူအမည်</label>
                                <input type="text" name="wg_name" class="form-control" value="{{$purchase->whitegold_name}}" required>
                            </div>
                            <div class="col-3 form-group">
                                <label for="quality">​ရွှေဖြူအရည်အ​သွေး</label>
                                <select name="quality" class="form-control" onchange="calculate_quality_price(this.value)" required>
                                    <option value="{{$purchase->quality}}">{{$purchase->quality}}</option>
                                    <option value="Grade A">Grade A</option>
                                    <option value="Grade B">Grade B</option>
                                    <option value="Grade C">Grade C</option>
                                    <option value="Grade D">Grade D</option>
                                </select>
                            </div>
                            <div class="offset-1 col-5">
                                <div class="row mt-1">
                                    <div class="col-6 form-group">
                                        <label for="purchase_price">ဝယ်ယူသည့်​စျေးနှုန်း</label>
                                        <input type="text" name="purchase_price" class="form-control" value="{{$purchase->purchase_price}}"  required>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="product_weight">Product အလေးချိန်</label>
                                        <input type="number" step="0.01" name="product_gram" placeholder="Gram" id="product_gram" class="form-control" value="{{$purchase->product_gram}}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3 form-group">
                                <label for="wg_type">​ရွှေဖြူအမျိုးအစား</label>
                                <input type="text" name="wg_type" class="form-control" value="{{$purchase->whitegold_type}}">
                            </div>
                            <div class="col-3 form-group">
                                <label for="category_id">Product အမျိုးအစား</label>
                                <select name="category_id" class="form-control" id="category_id" required>
                                    <option value="{{$purchase->category_id}}">{{$purchase->category->name}}</option>
                                    @foreach ($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->mm_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="offset-1 col-5">
                                <div class="row">
                                    <div class="col-3 form-group">
                                         <label for="profit_weight">အမြတ်</label>
                                        <input type="number" step="0.01" name="profit"  id="profit_amount" class="form-control"  placeholder="" value="<?php echo explode('/',$purchase->profit)[0]; ?>">
                                    </div>
                                    <div class="col-3 form-group" style="margin-top:30px;">
                                        <select name="currency1" id="currency">
                                            <option value="<?php echo explode('/',$purchase->profit)[1]; ?>"><?php echo explode('/',$purchase->profit)[1]; ?></option>
                                            <option value="MMK">MMK</option>
                                            <option value="%">%</option>
                                        </select>
                                    </div>
                                    <div class="offset-1 col-3">
                                        <label for="stock_qty">အ​ရေအတွက်</label>
                                        <input type="text" name="stock_qty" class="form-control" value="{{$purchase->stock_qty}}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-3" hidden>
                                <input type="text" name='wg_price' id='wg_price' value="{{$purchase->whitegold_price}}">
                            </div>

                            <div class="col-2 form-group">
                                <label for="code_number">ကုဒ်နံပါတ်</label>
                                <input type="text" name="code_number" class="form-control @error('code_number') is-invalid @enderror" id="code_number" value="{{$purchase->code_number}}" required>

                                @error('code_number')
                                    <span class="invalid-feedback alert alert-danger" role="alert"  height="100">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="col-1" style="margin-top: 37px;">
                                <button type="button" class="btn btn-sm btn-warning py-1 text-white" onclick="autofillcode()">Generate</button>
                            </div>
                            <div class="col-3 form-group">
                                <label for="color">အ​ရောင်</label>
                                <input type="text" name="color" class="form-control" value="{{$purchase->color}}">
                            </div>

                            <div class="offset-1 col-5">
                                <div class="row" style="margin-top:35px;">
                                    <a href="#" class="btn btn-m btn-color text-center col-12"  onclick="calculate_price()">​Generate</a>
                                </div>
                            </div>
                            <div class="col-3 form-group">
                                <label for="staff_id">စစ်​ဆေးမည့် ဝန်ထမ်း</label>
                                <select name="staff_id" id="staff_id" class="form-control">
                                    <option value="{{$purchase->staff_id}}">{{$purchase->staff_id}}</option>
                                    @foreach ($staffs as $staff)
                                    <option value="{{$staff->name}}">{{$staff->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3 form-group">
                                <label for="counter">ဆိုင်ခွဲ</label>
                                <select name="counter" id="counter" class="form-control" required>
                                    <option value="{{$purchase->counter_shop}}">{{$purchase->counter_shop}}</option>
                                    @foreach ($counters as $counter)
                                    <option value="{{$counter->shop_name}}">{{$counter->shop_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">

                            </div>
                            <div class="image-upload-wrap col-6 py-3">
                                <input class="file-upload-input" type='file' id="image"  accept="image/*" name="photo"/>
                                <div class="drag-text">
                                  <h6 class="mt-3"><img src="{{asset('/pos/whitegoldpurchase_photo/'.$purchase->photo)}}"  style="max-height: 100px;" id="preview-image-before-upload">ပုံ​ရွေးရန်</h6>
                                </div>
                            </div>
                            <div class="offset-1 col-5">
                                <div class="row mt-3">
                                    <div class="col-6 form-group">
                                        <label for="capital">​​အရင်း</label>
                                        <input type="number" name="capital" class="form-control" id="capital" value="{{$purchase->capital}}">
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="selling_price">ရောင်းဈေး</label>
                                        <input type="number" name="selling_price" class="form-control" id="selling_price" value="{{$purchase->selling_price}}" required>
                                    </div>
                                </div>
                            </div>

                            <?php $ischeck = $purchase->type;?>
                                <div class="col-6 mt-5">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="inlineCheckbox" name='inlineCheckbox' value="option1" @if ($ischeck == 'option1')
                                        checked
                                        @endif />
                                        <label class="form-check-label" for="inlineCheckbox">​​မိန်းမဝတ်</label>
                                      </div>

                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="inlineCheckbox" name='inlineCheckbox' value="option2" @if ($ischeck == 'option2')
                                        checked
                                        @endif/>
                                        <label class="form-check-label" for="inlineCheckbox">​ယောကျားဝတ်</label>
                                      </div>

                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="inlineCheckbox" name='inlineCheckbox' value="option3" @if ($ischeck == 'option3')
                                        checked
                                        @endif/>
                                        <label class="form-check-label" for="inlineCheckbox">unisex</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="inlineCheckbox" name='inlineCheckbox' value="option4" @if ($ischeck == 'option4')
                                        checked
                                        @endif/>
                                        <label class="form-check-label" for="inlineCheckbox">က​လေးဝတ်</label>
                                      </div>
                                </div>
                            @if ($shopowner->pos_only == 'no')
                            <!-- ShweShop Item -->
                            <div class="col-12 mt-3" >
                                <label for="shwe_item">Shwe Shop Item တွင်​ပြောင်းမည်</label>
                                <input type="checkbox" name="shwe_item" id='shwe_item' class="ml-4" value="0" onclick="check_shwe_item()">
                            </div>
                            <!-- End -->
                            @endif
                            <div class="col-12 mt-2">
                                <hr/>
                            </div>
                            <div class="col-6 mt-2">
                                <span class="text-color" style="font-size:19px;">​Code ဖတ်ရန်</span><br>
                                <div class="col-12 mt-3" >
                                    <label for="print_barcode">Print Barcode</label>
                                    <input type="checkbox" name="print_barcode" id='print_barcode' class="ml-4" value="0" onclick="check_barcode()">
                                </div>
                                <div class="col-12 form-group" id="text_barcode">
                                    <label for="barcode_text">Barcode Text</label>
                                    <input type="text" name="barcode_text" id="barcode_text" class="form-control" onchange="addBarcodeText(this.value)" value="{{$purchase->barcode_text}}">
                                </div>


                                <div class="col-12" id="barcode_convert">
                                    <input type="text" id="text" />
                                    <input type="hidden" id="scan_text"/>
                                    <input type="button" id="button" name="click" value="Convert Barcode" />
                                    <div id="print">
                                        <div id="showVal"></div>
                                        <div id="bcTarget"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 form-group mt-2">
                                <label for="remark" class="text-color">မှတ်ချက်ထည့်သွင်းရန်</label>
                                <textarea name="remark" id="" cols="30" rows="7">{{$purchase->remark}}</textarea>
                            </div>

                            <div class="row mt-4 offset-5">
                                <button type="submit" class="btn btn-m btn-color text-center"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>Save</button>
                            </div>
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

    <script>
        $(document).ready(function(){
            $('#barcode_convert').hide();
            $('#text_barcode').hide();
            $("#button").click(function(){
            var barcode_text = $('#scan_text').val();
            var text = $('#text').val();
            $("#showVal").text(barcode_text);
            $("#bcTarget").barcode(text, "code39");
            });
            $("#button").click();

            $("#print").click(function() {
            let html = document.getElementById('print').innerHTML;
            $('#mobileprint').html(html);

            var printContent = $('#mobileprint')[0];
            var WinPrint = window.open('', '', 'width=900,height=650');
            WinPrint.document.write('<html><head><title>Print Voucher</title>');
            WinPrint.document.write('<link rel="stylesheet" type="text/css" href="css/style.css">');
            WinPrint.document.write('<link rel="stylesheet" type="text/css" media="print" href="css/print.css">');
            WinPrint.document.write('</head><body >');
            WinPrint.document.write(printContent.innerHTML);
            WinPrint.document.write('</body></html>');

            WinPrint.focus();
            WinPrint.print();
            WinPrint.document.close();
            WinPrint.close();
            });
            $('#image').change(function(){

            let reader = new FileReader();

            reader.onload = (e) => {

              $('#preview-image-before-upload').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);

           });

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
        function autofillcode(){
            var category_id = $('#category_id').val();
            $.ajax({

                type:'POST',

                url:'{{route("backside.shop_owner.pos.codegenerate")}}',

                data:{
                "_token":"{{csrf_token()}}",
                "category_id":category_id,
                "type": 'gold',
                },

                success:function(data){
                    if(data.code == 0){
                        swal({
                            title: "Warning!",
                            text : "You need to choose product type!",
                            icon : "warning",
                        });
                    }else{
                        $('#code_number').val(data.code);
                    }

                }
                })
        }
        function calculate_quality_price(val){
            $.ajax({

                type:'POST',

                url:'{{route("backside.shop_owner.pos.quality_wg_price")}}',

                data:{
                "_token":"{{csrf_token()}}",
                "quality":val,
                },

                success:function(data){
                    $('#wg_price').val(data);
                }
            })
        }

        function calculate_price(){
            var gram = parseFloat($('#product_gram').val());
            var wg_price = parseInt($('#wg_price').val());
            if(gram){ gram = gram;}else{ gram = 0;}

            var cap = gram * wg_price;
            var capital = parseInt(cap);
            $('#capital').val(capital);

        }

        function back(){
        history.go(-1);
      }

      function check_shwe_item(){
            if($('#shwe_item').is(':checked')){
                $('#shwe_item').val(1);
            }else{
                $('#shwe_item').val(0);
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

