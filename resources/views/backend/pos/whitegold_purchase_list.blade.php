@extends('layouts.backend.datatable')
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
                <div class="row">
                    <div class="col-7">
                <div class="row d-flex">
                    <h4 class="text-color">​ရွှေဖြူ အဝယ်စာရင်းများ</h4>
                    <a class="btn btn-m btn-color ml-3" href="{{route('backside.shop_owner.pos.create_wg_purchase')}}">
                    <i class="fa fa-plus mr-2"></i>Create</a>
                    {{-- <div class="dropdown ml-5">
                        <a class="btn btn-m btn-color dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-filter"></i></a>
                        <ul class="dropdown-menu px-1">
                        <li><label><input type="checkbox" id="female" > မိန်းမဝတ်</label></li>
                        <li><label><input type="checkbox" id="male"> ​​ယောကျားဝတ်</label></li>
                        <li><label><input type="checkbox" id="unisex"> unisex</label></li>
                        <li><label><input type="checkbox" id="child"> က​လေးဝတ်</label></li>
                        <li><hr class="dropdown-divider"/></li>
                        <li><a href="#" class="btn btn-color btn-sm" style="margin-left: 50px;" onclick="goldtypefilter(1)">Save</a></li>
                        </ul>
                    </div> --}}
                </div>
                <div class="row mt-3">
                    <input type="hidden" id="print_date" value="All">
                    <label for="">From:<input type="date" id="start_date"></label>
                    <label for="" class="ml-3">To:<input type="date" id="end_date"></label>
                    <label for="" style="margin-left: 20px;margin-top:30px;">
                        <a href="#" class="btn btn-color btn-m" onclick="wgtypefilter(2)">Search</a>
                    </label>
                </div>
                <h6 class="mt-3 text-color mb-1">ဆိုင်လက်ကျန်ကြည့်ရှုရန်
                    {{-- <input type="checkbox" class="mt-1 ml-2" name='chkflag' id="chkflag" onclick="stockcheck(4)"> --}}
                    <select name="" id="f_counter" onchange="stockcheck(4,this.value)">
                        <option value="">ဆိုင်ခွဲများ</option>
                        @foreach ($counters as $counter)
                        <option value="{{$counter->shop_name}}">{{$counter->shop_name}}</option>
                        @endforeach
                        <option value="အားလုံး">အားလုံး</option>
                    </select>
                    <input type="hidden" id="print_counter" value="All">
                </h6>
            </div>
            <div class="col-5">
                <div class="row">
                    <div class="col-7">
                        {{-- <h6 class="text-color mt-4">​ပန်းထိမ်ဆိုင်ဖြင့်ကြည့်ရှုရန်</h6> --}}
                        <h6 class="text-color mt-4">​​ရွှေဖြူ​အမျိုးအစားဖြင့်ကြည့်ရှုရန်</h6>
                        <h6 class="text-color mt-4">ပစ္စည်း​အမျိုးအစားဖြင့်ကြည့်ရှုရန်</h6>
                    </div>
                    <div class="col-1">
                        {{-- <input type="checkbox" class="sup mt-4" onclick="advanceFilter()"> --}}
                        <input type="checkbox" class="qual mt-4" onclick="advanceFilter()">
                        <input type="checkbox" class="ptype mt-4" onclick="advanceFilter()">
                    </div>
                    <div class="col-4" >
                        {{-- <select name="" id="sup" class="mt-2 form-control" onchange="filtergoldadvance(this.value,1)">
                            <option value="">​ပန်းထိမ်ဆိုင်များ</option>
                            @foreach ($sups as $sup)
                            <option value="{{$sup->id}}">{{$sup->name}}</option>
                            @endforeach
                        </select> --}}
                        <input type="hidden" id="print_gtype" value="All">
                        <select name="" id="qual" class="mt-2 form-control" onchange="filtergoldadvance(this.value,2)">
                            <option value="">​ရှာရန်</option>
                            <option value="Grade A">Grade A</option>
                            <option value="Grade B">Grade B</option>
                            <option value="Grade C">Grade C</option>
                            <option value="Grade D">Grade D</option>
                        </select>
                        <input type="hidden" id="print_ptype" value="All">
                        <select name="" id="ptype" class="mt-2 form-control" onchange="filtergoldadvance(this.value,3)">
                            <option value="">ရှာရန်</option>
                            @foreach ($cats as $cat)
                            <option value="{{$cat->id}}">{{$cat->mm_name}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="supid">
                        <input type="hidden" id="qualid">
                        <input type="hidden" id="catid">
                    </div>
                </div>
            </div>
        </div>
                <div class="card mt-2">
                    <?php $tot_g = 0;
                    foreach ($purchases as $pg) {
                        $tot_g += $pg->product_gram;
                    }
                    ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="offset-6 col-3 card" style="max-height: 70px;"><h6 class="text-color mt-2" >စုစု​ပေါင်းအ​ရေအတွက် &nbsp;&nbsp;&nbsp;<span id="tot_qty">{{count($purchases)}}</span></h6></div>
                            <div class="col-3 card" style="max-height: 70px;"><h6 class="text-color mt-2" >စုစု​ပေါင်းအ​လေးချိန် &nbsp;&nbsp;&nbsp;<span id="tot_g">{{$tot_g}}</span>  g<br>(Gram)</h6></div>
                        </div>
                        <div class=" table-responsive text-black">
                        <table class="table table-striped" id="example23">
                            <thead>
                                <th>နံပါတ်</th>
                                <th>​ရွှေဖြူအမည်</th>
                                <th>​ရွှေဖြူအရည်အ​သွေး</th>
                                <th>​ရွှေဖြူအမျိုးအစား</th>
                                <th>ကုဒ်နံပါတ်</th>
                                <th>Product အ​လေးချိန်<br>(in gram)</th>
                                <th>အ​ရေအတွက်</th>
                                <th>ပစ္စည်းတန်ဖိုး</th>
                                <th>Date</th>
                                <th></th>
                            </thead>
                            <tbody class="text-center" id="filter">
                                <?php $i = 1;?>
                                @foreach ($purchases as $purchase)
                                <tr>
                                 <td>{{$i++}}</td>
                                 <td>{{$purchase->whitegold_name}}</td>
                                 <td>{{$purchase->quality}}</td>
                                 <td>{{$purchase->whitegold_type}}</td>
                                 <td>{{$purchase->code_number}}</td>
                                 <td>{{$purchase->product_gram}}</td>
                                 <td>{{$purchase->stock_qty}}</td>
                                  <td>{{$purchase->capital}}</td>
                                 <td> ​
                                    {{$purchase->date}}
                                 </td>
                                 <td>
                                    @if($purchase->sell_flag == 0)
                                    <a href="#myModal{{$purchase->id}}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a>
                                    @endif
                                    <a href="{{route('backside.shop_owner.pos.edit_wg_purchase',$purchase->id)}}" class="ml-2 text-warning"><i class="fa fa-edit" ></i></a>
                                    <a href="{{route('backside.shop_owner.pos.detail_wg_purchase',$purchase->id)}}" class="ml-2 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                 </td>

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

                                </tr>
                                @endforeach

                            </tbody>
                        </table>
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
         function stockcheck(val,text){
            var dataTable = $('#example23').DataTable();
            $.ajax({

            type:'POST',

            url: '{{route("backside.shop_owner.pos.sell_flag_filter")}}',

            data:{
            "_token":"{{csrf_token()}}",
            'val' : val,
            'text' : text,
            },

            success:function(data){
                $('#print_counter').val(text);
                $('#print_date').val('All');
                $('#print_gtype').val('All');
                $('#print_ptype').val('All');
                $('#start_date').val('');
                $('#end_date').val('');
                dataTable.clear().draw();
                var tot_g = 0;var count = 0;
                $.each(data.data, function(i, v) {
                    count++;var html2 = `<div class="d-flex">`;
                    var url1 = '{{ route('backside.shop_owner.pos.edit_wg_purchase', ':purchase_id') }}';
                    url1 = url1.replace(':purchase_id', v.id);
                    var url2 = '{{ route('backside.shop_owner.pos.detail_wg_purchase', ':purchase_id') }}';
                    url2 = url2.replace(':purchase_id', v.id);
                    tot_g += parseInt(v.product_gram);
                    if(v.sell_flag == 0){
                            html2 += `<a href="#myModal${v.id}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a>`;
                        }
                            
                        html2 += `<a href="${url1}" class="ml-4 text-warning"><i class="fa fa-edit" ></i></a>
                                  <a href="${url2}" class="ml-4 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a></div>`;
                    
                    dataTable.row.add([++i,v.whitegold_name,v.quality,v.whitegold_type,v.code_number,v.product_gram,v.stock_qty,v.capital,v.date,html2]).draw();
                })
               
                $('#tot_qty').html(count);
                $('#tot_g').html(tot_g);
            }
            })
        }
         function wgtypefilter(val){
            var dataTable = $('#example23').DataTable();
            var html = '';
            if($("#female").is(":checked") == true){
                html += 'option1'
            }
            if($("#male").is(":checked") == true){
                html += '/option2'
            }
            if($("#unisex").is(":checked") == true){
                html += '/option3'
            }
            if($("#child").is(":checked") == true){
                html += '/option4'
            }
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();

            $.ajax({

            type:'POST',

            url: '{{route("backside.shop_owner.pos.wg_type_filter")}}',

            data:{
            "_token":"{{csrf_token()}}",
            "text" : html,
            "start_date" : start_date,
            "end_date" : end_date,
            "type" : val,
            },

            success:function(data){
                $('#print_date').val(start_date+' to '+end_date);
                $('#print_counter').val('All');
                $('#print_gtype').val('All');
                $('#print_ptype').val('All');
                $('#f_counter').val('');
                dataTable.clear().draw();
                var tot_g = 0;var count = 0;
                $.each(data.data, function(i, v) {
                    count++;var html2 = `<div class="d-flex">`;
                    var url1 = '{{ route('backside.shop_owner.pos.edit_wg_purchase', ':purchase_id') }}';
                    url1 = url1.replace(':purchase_id', v.id);
                    var url2 = '{{ route('backside.shop_owner.pos.detail_wg_purchase', ':purchase_id') }}';
                    url2 = url2.replace(':purchase_id', v.id);
                    tot_g += parseInt(v.product_gram);
                    if(v.sell_flag == 0){
                            html2 += `<a href="#myModal${v.id}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a>`;
                        }
                            
                        html2 += `<a href="${url1}" class="ml-4 text-warning"><i class="fa fa-edit" ></i></a>
                                  <a href="${url2}" class="ml-4 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a></div>`;
                    
                    dataTable.row.add([++i,v.whitegold_name,v.quality,v.whitegold_type,v.code_number,v.product_gram,v.stock_qty,v.capital,v.date,html2]).draw();
                })
               
                $('#tot_qty').html(count);
                $('#tot_g').html(tot_g);
            }
        })

        }

        function advanceFilter(){
                if($('.sup').is(':checked',true)){
                    $('#sup').show();
                }else{
                    $('#sup').hide();
                    $('#supid').val('');
                }
                if($('.qual').is(':checked',true)){
                    $('#qual').show();
                }else{
                    $('#qual').hide();
                    $('#qualid').val('');
                }
                if($('.ptype').is(':checked',true)){
                    $('#ptype').show();
                }else{
                    $('#ptype').hide();
                    $('#catid').val('');
                }
            }
        function filtergoldadvance(val,type){
            $('#start_date').val('');
            $('#end_date').val('');
            $('#f_counter').val('');
            var dataTable = $('#example23').DataTable();
            if(type == 1){
                $('#supid').val(val);
            }
            if(type == 2){
                $('#qualid').val(val);
                $('#print_gtype').val($("#qual option:selected").text());
                $('#print_date').val('All');
                $('#print_counter').val('All');
            }
            if(type == 3){
                $('#catid').val(val);
                $('#print_ptype').val($("#ptype option:selected").text());
                $('#print_date').val('All');
                $('#print_counter').val('All');
            }
            var supid = $('#supid').val();
            var qualid = $('#qualid').val();
            var catid = $('#catid').val();
            $.ajax({

            type:'POST',

            url: '{{route("backside.shop_owner.pos.whitegold_advance_filter")}}',

            data:{
            "_token":"{{csrf_token()}}",
            'text' : val,
            'supid' : supid,
            'qualid' : qualid,
            'catid' : catid,
            "type" : type,
            },

            success:function(data){
                dataTable.clear().draw();
                var tot_g = 0;var count = 0;
                $.each(data.data, function(i, v) {
                    count++;var html2 = `<div class="d-flex">`;
                    var url1 = '{{ route('backside.shop_owner.pos.edit_wg_purchase', ':purchase_id') }}';
                    url1 = url1.replace(':purchase_id', v.id);
                    var url2 = '{{ route('backside.shop_owner.pos.detail_wg_purchase', ':purchase_id') }}';
                    url2 = url2.replace(':purchase_id', v.id);
                    tot_g += parseInt(v.product_gram);
                    if(v.sell_flag == 0){
                            html2 += `<a href="#myModal${v.id}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a>`;
                        }
                            
                        html2 += `<a href="${url1}" class="ml-4 text-warning"><i class="fa fa-edit" ></i></a>
                                  <a href="${url2}" class="ml-4 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a></div>`;
                    
                    dataTable.row.add([++i,v.whitegold_name,v.quality,v.whitegold_type,v.code_number,v.product_gram,v.stock_qty,v.capital,v.date,html2]).draw();
                })
               
                $('#tot_qty').html(count);
                $('#tot_g').html(tot_g);
            }
            })
    }
         $(document).ready(function() {
            $('#sup').hide();
                $('#qual').hide();
                $('#ptype').hide();
            function alignModal(){
        var modalDialog = $(this).find(".modal-dialog");

        // Applying the top margin on modal to align it vertically center
            modalDialog.css("margin-top", Math.max(0, ($(window).height() - modalDialog.height()) / 2));
        }
        // Align modal when it is displayed
        $(".modal").on("shown.bs.modal", alignModal);

        // Align modal when user resize the window
        $(window).on("resize", function(){
            $(".modal:visible").each(alignModal);
        });

            $('#example23').DataTable({

                dom: 'Blfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf',
                        {
                    extend: 'print',
                    customize: function(win) {
                        var tot_qty = $('#tot_qty').text();
                        var tot_g = $('#tot_g').text();
                        var date = $('#print_date').val();
                        var counter = $('#print_counter').val();
                        var gtype = $('#print_gtype').val();
                        var ptype = $('#print_ptype').val();
                        var existingData = $(win.document.body).html();
                        var extraText1 = `<div class="row">
                            <div class="col-3 card" style="max-height: 70px;"><h6 class="text-color mt-2" >စုစု​ပေါင်းအ​ရေအတွက် &nbsp;&nbsp;&nbsp;<span>${tot_qty}</span></h6></div>
                            <div class="col-3 card" style="max-height: 70px;"><h6 class="text-color mt-2" >စုစု​ပေါင်းအ​လေးချိန် &nbsp;&nbsp;&nbsp;<span>${tot_g}</span>  g<br>(Gram)</h6></div>
                        </div>`;
                        var extraText2 = `
                            <h6 class='text-color'>​ကောင်တာ : ${counter}</h6>
                            <h6 class='text-color'>​​ရွှေရည် : ${gtype}</h6>
                            <h6 class='text-color'>​အမျိုးအစား : ${ptype}</h6>
                            <h6 class='text-color'>​Date : ${date}</h6>
                        `;
                        $(win.document.body).html(extraText1+existingData+extraText2);
                    }
                    }
                    ],
                    processing: true,
                    "ordering": true,
                    "info": true,
                    "paging": true,

            });
        });

        function suredelete(id){
            // alert(id);
                $.ajax({

                    type:'POST',

                    url: '{{route("backside.shop_owner.pos.delete_wg_purchase")}}',

                    data:{
                    "_token":"{{csrf_token()}}",
                    "pid" : id,
                    },

                    success:function(data){
                        location.reload();
                        // console.log('success');
                    }
                })


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
        background-color: #780116;
        color: white;
        }
        .btn-color:hover{
                color: white;
            }
        .text-color{
            color: #780116;
        }
    </style>
@endpush

