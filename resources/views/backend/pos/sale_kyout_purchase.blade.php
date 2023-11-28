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
                         <form action="{{route('backside.shop_owner.pos.store_sale_kyout')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-7">
                                    <h4 class="text-color mt-2">​<i class="fa fa-chevron-left" aria-hidden="true" onclick="back()"></i> &nbsp;&nbsp;​​ကျောက်ထည်အ​ရောင်းစာရင်းသွင်းခြင်း</h4>
                                    <div class="col-4 mt-2">
                                        <label for="date" class="col-form-label">​နေ့စွဲ</label>
                                        <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>"><br><br>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="row mt-3">
                                        <div class="card col-5 py-2 card-color">
                                            <span class="text-white" style="font-size:19px;">​ယ​​နေ့ဆိုင်​ပေါက်​စျေး</span><br>
                                            <span class="text-white" style="font-size:19px;">{{$shop_price}} mmk</span>
                                        </div>
                                        <div class="card offset-1 col-5 py-2 card-color1">
                                            <span class="text-white" style="font-size:19px;">​ယ​နေ့အပြင်​ပေါက်​စျေး</span><br>
                                            <span class="text-white" style="font-size:19px;">{{$out_price}} mmk</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                           <div class="row">
                            <div class="col-6">
                                <span class="text-color" style="font-size:19px;">​ရောင်းချမည့် ​စိန်​ကျောက်ထည်</span>
                            </div>
                            <div class="col-6">
                                <span class="text-color" style="font-size:19px;">Customer Information</span>
                            </div>
                          </div>
                         <div class="row mt-5">
                            <div class="col-5">
                                <div class="row">
                                    <div class="col-6 form-group">
                                        <label for="name">​ရွှေထည်အမည်</label>
                                        <select name="purchase_id" id="" onchange="fillValues(this.value)"  class="form-control select2" required>
                                            <option value="">ရွှေထည်အမည်များ</option>
                                            @foreach ($purchases as $purchase)
                                            @if ($purchase->stock_qty > 0)
                                            <option value="{{$purchase->id}}">{{$purchase->code_number}}-{{$purchase->name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="code_number">ကုဒ်နံပါတ်</label>
                                        <input type="text" name="code_number" class="form-control" id="code_number" required>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="quality">​ရွှေအရည်အသွေး</label>
                                        <input type="text" name="quality" id="quality" class="form-control" required>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="gold_type">ရွှေအမျိုးအစား</label>
                                        <input type="text" name="gold_type" class="form-control" id="gold_type" required>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="category">Product အမျိုးအစား</label>
                                        <input type="text" name="category" id="category" class="form-control" required>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="staff_id">စစ်​ဆေးမည့် ဝန်ထမ်း</label>
                                        <select name="staff_id" id="staff_id" class="form-control" required>
                                            <option value="">ဝန်ထမ်းများ</option>
                                            @foreach ($staffs as $staff)
                                            <option value="{{$staff->name}}">{{$staff->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="counter">ဆိုင်ခွဲ</label>
                                        <select name="counter" id="counter" class="form-control">
                                            <option id="fill_shop"></option>
                                            <!--@foreach ($counters as $counter)-->
                                            <!--<option value="{{$counter->shop_name}}">{{$counter->shop_name}}</option>-->
                                            <!--@endforeach-->

                                        </select>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="color">အ​ရောင်</label>
                                        <input type="text" name="color" class="form-control" id="color">
                                    </div>
                                    <div class="col-12">
                                        <div>
                                            <label for="product_weight">​ရွှေစင်ချိန်</label>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 form-group">
                                                <input type="number" step="0.01" name="product_weight" placeholder="Gram" id="product_weight" class="form-control" required>

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
                                    <div class="col-12">
                                        <div>
                                            <label for="profit_weight">စိန်​ကျောက်ချိန်</label>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 form-group">
                                                <input type="number" step="0.01" name="diamond_gram" placeholder="Gram" id="diamond_gram" class="form-control" required>

                                            </div>
                                            <div class="col-3 form-group">
                                                <input type="number" step="0.01" name="diamond_kyat"  id="diamond_kyat" class="form-control"  placeholder="ကျပ်">

                                            </div>
                                            <div class="col-3 form-group">
                                                <input type="number" step="0.01" name="diamond_pe" id="diamond_pe" class="form-control"  placeholder="ပဲ">
                                            </div>
                                            <div class="col-3 form-group">
                                                <input type="number" step="0.01" name="diamond_yway" id="diamond_yway" class="form-control"  placeholder="ရွေး">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                            <div class="row">
                                                <div class="col-12 form-group">
                                                    <label for="include_diamonds">ပါဝင်သည့်စိန်​ကျောက်များ</label>
                                                    {{-- <select class="js-example-basic-single form-control" name="include_diamonds[]" multiple="multiple" id="include_diamonds" onchange="add_diamond(this.value)">
                                                        <option>စိန်​ကျောက်များ</option>
                                                    </select> --}}
                                                </div>
                                            </div>
                                            <div class="row" >
                                                <div class="col-12" id="add_diamond">
                                                   
                                                </div>
                                            </div>

                                    </div>
                                    <div class="col-12">
                                        <div>
                                            <label for="decrease_weight">အလျော့တွက်</label>
                                        </div>
                                        <div class="row">
                                            {{-- <div class="col-3 form-group">
                                                <input type="number" step="0.01" name="decrease_price"  id="decrease_amount" class="form-control"  placeholder="">
                                            </div>
                                            <div class="col-3 form-group">
                                                <select name="currency" id="currency">
                                                    <option value="MMK">MMK</option>
                                                    <option value="%">%</option>
                                                </select>
                                            </div> --}}
                                            <div class="col-6 form-group">
                                                <input type="number" step="0.01" name="decrease_pe" id="decrease_pe" class="form-control"  placeholder="ပဲ">

                                            </div>
                                            <div class="col-6 form-group">
                                                <input type="number" step="0.01" name="decrease_yway" id="decrease_yway" class="form-control"  placeholder="ရွေး">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div>
                                            <label for="product_weight">လက်ခ</label>
                                        </div>
                                        <div class="row">
                                            <div class="col-8 form-group">
                                                <input type="number" step="0.01" name="service_fee"  id="service_amount" class="form-control"  placeholder="">
                                            </div>
                                            <div class="col-4 form-group">
                                                <select name="currency2" id="currency2">
                                                    <option value="MMK">MMK</option>
                                                    {{-- <option value="%">%</option> --}}
                                                </select>
                                            </div>
                                            {{-- <div class="col-3 form-group">
                                                <input type="number" step="0.01" name="service_pe" id="service_pe" class="form-control"  placeholder="ပဲ">

                                            </div>
                                            <div class="col-3 form-group">
                                                <input type="number" step="0.01" name="service_yway" id="service_yway" class="form-control"  placeholder="ရွေး">
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="remark" class="text-color">မှတ်ချက်ထည့်သွင်းရန်</label>
                                        <textarea name="remark" id="" cols="30" rows="5"></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="offset-1 col-5">
                                <div class="row">
                                    <div class="col-6 form-group">
                                        <label for="name">​ဝယ်သူအမည်</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="phone">ဖုန်းနံပါတ်</label>
                                        <input type="text" name="phone" class="form-control" id="phone" required>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label for="addresss">​နေရပ်လိပ်စာ</label>
                                        <textarea  id="" cols="30" rows="4" class="form-control" name="address"></textarea>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <span class="text-color" style="font-size:19px;">စုစု​ပေါင်းကျမည့်​ငွေ</span>
                                        <input type="hidden" name="" id="gold_price">
                                    </div>
                                    <div class="col-6 form-group" style="margin-top:25px;">
                                        <label for="price">​စျေးနှုန်း</label>
                                        <input type="text" name="price" id="gold_fee" class="form-control" required>
                                    </div>
                                    <div class="col-6 form-group" style="margin-top:25px;">
                                        <label for="diamond_fee">​စိန်​ကျောက်ဘိုး</label>
                                        <input type="text" name="diamond_fee" id="diamond_fee" class="form-control" required>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="amount">စုစု​ပေါင်းကျ​ငွေ</label>
                                        <input type="text" name="amount" class="form-control" id="amount" required>
                                    </div>
                                    {{-- <div class="col-6 form-group" style="margin-top:25px;">
                                        <label for="selling_price">​ရောင်း​စျေး</label>
                                        <input type="text" name="selling_price" class="form-control" required>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="de_price">​​လျှော့ငွေ</label>
                                        <input type="text" name="de_price" class="form-control" id="de_price" required>
                                    </div> --}}
                                    <div class="col-6 form-group">
                                        <label for="prepaid">​စရန်ငွေ</label>
                                        <input type="number" name="prepaid" class="form-control" value="0" onchange="creditAmount(this.value)">
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="credit">​​ကျန်ငွေ</label>
                                        <input type="number" name="credit" class="form-control" id="credit" value="0">
                                    </div>
                                    {{-- <div class="col-6">

                                    </div> --}}

                                    {{-- <div class="col-6 form-group">
                                        <label for="credit">​​ကျန်ငွေ</label>
                                        <input type="number" name="credit" class="form-control" id="credit" placeholder="0">
                                    </div> --}}
                                    {{-- <div class="col-12 mt-3" >
                                        <label for="return_sale">အလဲလှယ်​ရောင်း</label>
                                        <input type="checkbox" name="return_sale" id='return_sale' class="ml-4"  onclick="check_return()">
                                    </div>
                                    <div class="col-6 form-group" id="ptype">
                                        <label for="category_id">Product အမျိုးအစား</label>
                                        <select name="return_category_id" class="form-control" id="category_id">
                                            <option value="">အမျိုးအစားများ</option>
                                            @foreach ($categories as $cat)
                                            <option value="{{$cat->id}}">{{$cat->mm_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 form-group" id="gqual">
                                        <label for="quality">ရွှေအရည်အသွေး</label>
                                        <select name="return_quality" class="form-control" onchange="calculate_quality(this.value)">
                                            <option value="">ရွှေအရည်အသွေးများ</option>
                                            @foreach ($quality as $q)
                                            <option value="{{$q->id}}">{{$q->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12" id="pweight">
                                        <div>
                                            <label for="product_weight">Product အလေးချိန်</label>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 form-group">
                                                <input type="number" step="0.01" name="return_gram" placeholder="Gram" id="return_gram" class="form-control">

                                            </div>
                                            <div class="col-3 form-group">
                                                <input type="number" step="0.01" name="return_kyat"  id="return_kyat" class="form-control"  placeholder="ကျပ်">

                                            </div>
                                            <div class="col-3 form-group">
                                                <input type="number" step="0.01" name="return_pe" id="return_pe" class="form-control"  placeholder="ပဲ">
                                            </div>
                                            <div class="col-3 form-group">
                                                <input type="number" step="0.01" name="return_yway" id="return_yway" class="form-control"  placeholder="ရွေး">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12" id="hbut">
                                        <div class="row" style="margin-top:27px;">
                                            <a  class="btn btn-m btn-color text-center col-12"  onclick="calculate()">ပစ္စည်းတန်ဖိုးတွက်ရန်</a>
                                        </div>
                                    </div>
                                    <div class=" col-6 form-group mt-4" id="return_fee">
                                        <label for="return_fee">လဲမည့်ပစ္စည်းတန်ဖိုး&nbsp;<span id="old_fee" class="text-color"></span></label>
                                        <input type="text" name="return_fee" id="return" class="form-control" onfocus="setOldfee()" onchange="setLeft(this.value)">
                                    </div>
                                    <div class="col-6 form-group mt-4" id="left_fee">
                                        <label for="left_fee">ကျန်​ငွေ</label>
                                        <input type="text" name="left_fee" id="left" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <span id="change_text" class="text-color"></span>
                                    </div> --}}
                                </div>
                            </div>
                         </div>
                         <div class="row mt-4 offset-8">
                            <button type="submit" class="btn btn-m btn-color text-center"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i>Save</button>
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

     function creditAmount(val){
            var amount = $('#amount').val();
            var credit = amount - val;
            $('#credit').val(credit);
        }
        $(document).ready(function(){
            $('#return_fee').hide();
            $('#left_fee').hide();
            $('#ptype').hide();
            $('#gqual').hide();
            $('#pweight').hide();
            $('#hbut').hide();
        });

        function check_return(){
            if($('#return_sale').is(':checked')){
                $('#return_fee').show();
                $('#left_fee').show();
                $('#ptype').show();
            $('#gqual').show();
            $('#pweight').show();
            $('#hbut').show();
            }else{
                $('#return_fee').hide();
                $('#left_fee').hide();
                $('#ptype').hide();
            $('#gqual').hide();
            $('#pweight').hide();
            $('#hbut').hide();
            }

        }
       function fillValues(val){
            $.ajax({

                type:'POST',

                url:'{{route("backside.shop_owner.pos.getSaleKValues")}}',

                data:{
                "_token":"{{csrf_token()}}",
                "purchase_id":val,
                },

                success:function(data){
                    $('#code_number').val(data.purchase.code_number);
                    $('#quality').val(data.purchase.quality.name);
                    $('#gold_type').val(data.purchase.gold_type);
                    $('#category').val(data.purchase.category.mm_name);
                    $('#product_weight').val(data.product[0]);
                    $('#product_kyat').val(data.product[1]);
                    $('#product_pe').val(data.product[2]);
                    $('#product_yway').val(data.product[3]);
                    $('#diamond_gram').val(data.diamond[0]);
                    $('#diamond_kyat').val(data.diamond[1]);
                    $('#diamond_pe').val(data.diamond[2]);
                    $('#diamond_yway').val(data.diamond[3]);
                    $('#decrease_amount').val(data.decrease_price[0]);
                    $('#currency').val(data.decrease_price[1]);
                    $('#decrease_pe').val(data.decrease[0]);
                    $('#decrease_yway').val(data.decrease[1]);
                    $('#service_amount').val(data.service_fee[0]);
                    $('#currency2').val(data.service_fee[1]);
                    $('#service_pe').val(data.service[0]);
                    $('#service_yway').val(data.service[1]);
                    $('#diamond_fee').val(data.purchase.diamond_selling_price);
                    $('#color').val(data.purchase.color);
                     $('#amount').val(data.purchase.selling_price);
                     $('#fill_shop').val(data.purchase.counter_shop);
                    $('#fill_shop').text(data.purchase.counter_shop);
                    var diamonds = data.purchase.diamonds.split(',');
                    var carrats = data.purchase.carrats.split(',');
                    var counts = data.purchase.counts.split(',');
                    var yaties = data.purchase.yaties.split(',');
                    var bes = data.purchase.bes.split(',');
                     var dprice = data.purchase.diamond_price.split(',');
                    var html = '';
                    // alert(counts[0]);
                    
            for(var i=0;i<diamonds.length-1;i++){
             html += `
                <div class="row form-group mt-2">
                    <div class="col-12">
                        <h6 for="" name="diamond_name[]"><i class="fa fa-diamond" aria-hidden="true"></i> &nbsp;${diamonds[i]}</h6>
                    </div>
                    <div class="row  border border-1 mt-2 p-2">
                    <div class="col-3">
                        <label for="">Count</label>
                        <input type="text"  class="form-control" value="${counts[i]}">
                    </div>`;
                if(carrats[i] != 0){
                    html += `
                    <div class="col-3">
                        <label for="">Weight</label>
                        <input type="text" class="form-control" value="${carrats[i]}">
                    </div>
                    `;
                }
                else if(yaties[i] != 0){
                    html += `
                    <div class="col-3">
                        <label for="">Weight</label>
                        <input type="text" class="form-control" value="${yaties[i]}">
                    </div>
                    `;
                }
                else{
                    html += `
                    <div class="col-3">
                        <label for="">Weight</label>
                        <input type="text" class="form-control" value="${bes[i]}">
                    </div>
                    `;
                }
                
                    html += `
                    <div class="col-3 mt-2">
                        <label for=""> </label>
                        <select name="kyb" class="form-control text-primary">
                    `;
                    
                if(carrats[i] != 0 ){
                    html += `<option value="1">ကာရက်</option>`;
                }
                else if(yaties[i] != 0){
                    html += `<option value="2">ရတီ</option>`;
                }
                else{
                    html += `<option value="3">ဘီ</option>`;
                }
               
                    html += `
                    </select>
                    </div>
                    
                    <div class="col-3">
                        <label for="">Price</label>
                        <input type="text" class="form-control" name="dprice[]" value="${dprice[i]}">
                    </div>
                    <h6 class="text-primary mt-2">Total Amount - 
                    `;
                       
                if(carrats[i] != 0){
                    var tot = carrats[i]*dprice[i];
                    html += `<span>${tot}</span>`;
                }
                else if(yaties[i] != 0){
                    var tot = yaties[i]*dprice[i];
                    html += `<span>${tot}</span>`;
                }
                else{
                    var tot = bes[i]*dprice[i];
                    html += `<span>${tot}</span>`;
                }
                
                html += `
                </h6>
                    </div>
                </div>
                `;
           
        }
  
        $('#add_diamond').html(html);
                    calculate_quality_price(data.purchase.quality_id);
                }
                })
        }
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
                    calculate_price();
                }
            })
        }

        function calculate_price(){
            var yway = parseFloat($('#product_yway').val());
            var pe = parseFloat($('#product_pe').val());
            var kyat = parseFloat($('#product_kyat').val());
            var gold_price = parseInt($('#gold_price').val());
            var dyway = parseFloat($('#diamond_yway').val());
            var dpe = parseFloat($('#diamond_pe').val());
            var dkyat = parseFloat($('#diamond_kyat').val());
            var decrease_pe = parseFloat($('#decrease_pe').val());
            var decrease_yway = parseFloat($('#decrease_yway').val());
            if(decrease_pe){ decrease_pe = decrease_pe;}else{ decrease_pe = 0;}
            if(decrease_yway){ decrease_yway = decrease_yway;}else{ decrease_yway = 0;}
            if(yway){ yway = yway;}else{ yway = 0;}
            if(pe){ pe = pe;}else{ pe = 0;}
            if(kyat){ kyat = kyat;}else{ kyat = 0;}
            if(dyway){ dyway = dyway;}else{ dyway = 0;}
            if(dpe){ dpe = dpe;}else{ dpe = 0;}
            if(dkyat){ dkyat = dkyat;}else{ dkyat = 0;}
            var decrease = (((decrease_yway/8)+decrease_pe)/16)* gold_price;
            var gold = ((((yway/8)+pe)/16)+kyat)*gold_price + decrease;
            var diamond = ((((dyway/8)+dpe)/16)+dkyat)*gold_price;
            var gold_fee =  parseInt(gold-diamond);
            var capital = parseInt(gold);
            $('#gold_fee').val(gold_fee);
            // $('#selling_price').val(gold_fee);
        }

        function back(){
        history.go(-1);
      }
      function setOldfee(){
            var oldfee = $('#return').val();
            $('#old_fee').html(`(${oldfee})`);
        }
        function setLeft(val){
            var amount = $('#amount').val();
           $('#left').val(amount-val);
            if($('#left').val()<0){
                $('#change_text').html(`* Customer အားပြန်အမ်းရမည့်​ငွေ = ( ${$('#left').val()*(-1)} MMK )`)
            }else{
                $('#change_text').html(``);
            }

        }
        function calculate_quality(val){
            $.ajax({

                type:'POST',

                url:'{{route("backside.shop_owner.pos.quality_gold_price")}}',

                data:{
                "_token":"{{csrf_token()}}",
                "quality_id":val,
                },

                success:function(data){
                    $('#gold_price').val(data);
                    // alert(data);
                }
            })
        }
        function calculate(){
            var yway = parseFloat($('#return_yway').val());
            var pe = parseFloat($('#return_pe').val());
            var kyat = parseFloat($('#return_kyat').val());
            var gold_price = parseInt($('#gold_price').val());
            var amount = parseInt($('#amount').val());

            if(yway){ yway = yway;}else{ yway = 0;}
            if(pe){ pe = pe;}else{ pe = 0;}
            if(kyat){ kyat = kyat;}else{ kyat = 0;}

            var fee =  ((((yway/8)+pe)/16)+kyat)*gold_price;
            var gold_fee = parseInt(fee);
            $('#return').val(gold_fee);
            $('#left').val(amount-gold_fee);
            if($('#left').val()<0){
                $('#change_text').html(`* Customer အားပြန်အမ်းရမည့်​ငွေ = ( ${$('#left').val()*(-1)} MMK )`)
            }else{
                $('#change_text').html(``);
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
        .btn-outline-color{
        border: 1px solid #780116;
        color:#780116;
        padding: 5px 25px;
        margin-left: 10px;
        }
        .btn-color:hover{
            color: white;
        }
        .btn-outline-color:hover{
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
            background-color: #D4AF37;
        }
        .card-color1{
            background-color: #780116;
        }

    </style>
@endpush

