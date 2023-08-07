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
                            <h4 class="text-color">​ရွှေထည် အ​ရောင်းစာရင်းများ</h4>
                            <a class="btn btn-m btn-color ml-3" href="{{route('backside.shop_owner.pos.slae_purchase')}}">
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
                                <a href="#" class="btn btn-color btn-m" onclick="goldtypefilter(2)">Search</a>
                            </label>
                        </div>
                        <h6 class="mt-3 text-color mb-1">ဆိုင်ခွဲဖြင့်ကြည့်ရှုရန်
                            {{-- <input type="checkbox" class="mt-1 ml-2" name='chkflag' id="chkflag" onclick="stockcheck(1)"> --}}
                            <select name=""  id="f_counter" onchange="stockcheck(1,this.value)">
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
                            <div class="col-6">
                                <h6 class="text-color mt-4">​ပန်းထိမ်ဆိုင်ဖြင့်ကြည့်ရှုရန်</h6>
                                <h6 class="text-color mt-4">​ရွှေ​အမျိုးအစားဖြင့်ကြည့်ရှုရန်</h6>
                                <h6 class="text-color mt-4">ပစ္စည်း​အမျိုးအစားဖြင့်ကြည့်ရှုရန်</h6>
                            </div>
                            <div class="col-1">
                                <input type="checkbox" class="sup mt-4" onclick="advanceFilter()">
                                <input type="checkbox" class="qual mt-4" onclick="advanceFilter()">
                                <input type="checkbox" class="ptype mt-4" onclick="advanceFilter()">
                            </div>
                            <div class="col-4" >
                                <select name="" id="sup" class="mt-2 form-control" onchange="filtergoldadvance(this.value,1)">
                                    <option value="">​ပန်းထိမ်ဆိုင်များ</option>
                                    @foreach ($sups as $sup)
                                    <option value="{{$sup->id}}">{{$sup->name}}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" id="print_gtype" value="All">
                                <select name="" id="qual" class="mt-2 form-control" onchange="filtergoldadvance(this.value,2)">
                                    <option value="">ရွှေ​အမျိုးအစားများ</option>
                                    @foreach ($quals as $qual)
                                    <option value="{{$qual->id}}">{{$qual->name}}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" id="print_ptype" value="All">
                                <select name="" id="ptype" class="mt-2 form-control" onchange="filtergoldadvance(this.value,3)">
                                    <option value="">ပစ္စည်း​အမျိုးအစားများ</option>
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
                    <?php $tot_g = 0;$tot_y=0;$tot_p=0;$tot_k=0;$tot_dy=0;$tot_dp=0;$tot_dk=0;$tot_sale=0;
                    foreach ($purchases as $pg) {
                        $product = explode ("/",$pg->purchase->product_gram_kyat_pe_yway);
                        $decrease = explode ("/",$pg->purchase->decrease_pe_yway);
                        $tot_sale += $pg->amount;
                        $tot_g += $product [0];
                        $tot_y += $product [3] ? $product [3] : 0;
                        $tot_p += $product [2] ? $product [2] : 0;
                        $tot_k += $product [1] ? $product [1] : 0;
                        $tot_dy += $decrease [1] ? $decrease [1] : 0;
                        $tot_dp += $decrease [0] ? $decrease [0] : 0;
                        if($tot_y>=8){
                        $tot_p += 1; $tot_y = $tot_y-8;
                        }
                        if($tot_p>=16){
                            $tot_k += 1; $tot_p = $tot_p-16;
                        }
                        if($tot_dy>=8){
                        $tot_dp += 1; $tot_dy = $tot_dy-8;
                        }
                        if($tot_dp>=16){
                            $tot_dk += 1; $tot_dp = $tot_dp-16;
                        }
                    }
                    ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 card row" style="max-height: 70px;">
                                <h6 class="col-8 text-color mt-2" >စုစု​ပေါင်းအ​ရေအတွက်</h6>
                                <h6 class="col-4 text-color mt-2" id="tot_qty">{{count($purchases)}}</h6>
                            </div>
                            <div class="col-3 card row" style="max-height: 70px;">
                                <h6 class="col-8 text-color mt-2" >စုစု​ပေါင်းအ​လေးချိန် (g)</h6>
                                <h6 class="col-4 text-color mt-2"><span id="tot_g">{{$tot_g}}</span>  g</h6>
                            </div>
                            <div class="col-3 card row" style="max-height: 70px;">
                                <h6 class="col-7 text-color mt-2" >စုစု​ပေါင်းအ​လေးချိန် (ကျပ်၊ ပဲ၊ ​ရွေး)</h6>
                                <h6 class="col-5 text-color mt-2" id="tot_kpy">{{$tot_k}}ကျပ် {{$tot_p}}ပဲ  {{$tot_y}}​ရွေး</h6>
                            </div>
                            <div class="col-3 card row" style="max-height: 70px;">
                                <h6 class="col-8 text-color mt-2">စုစု​ပေါင်းအ​လျော့တွက် (ကျပ်၊ ပဲ၊ ​ရွေး)</h6>
                                <h6 class="col-4 text-color mt-2" id="tot_dkpy">{{$tot_dk}}ကျပ် {{$tot_dp}}ပဲ  {{$tot_dy}}​ရွေး</h6>
                            </div>
                            <div class="col-5 card row" style="max-height: 70px;">
                                <h6 class="col-5 text-color mt-2" >ရောင်းရ​ငွေစုစု​ပေါင်း</h6>
                                <h6 class="col-7 text-color mt-2" id="tot_sale">{{$tot_sale}} ကျပ်</h6>
                            </div>
                        </div>
                        <div class=" table-responsive text-black">
                        <table class="table table-striped" id="example23">
                            <thead>
                                <th>နံပါတ်</th>
                                <th>​ရွှေထည်အမည်</th>
                                <th>ကုဒ်နံပါတ်</th>
                                <th>စုစု​ပေါင်းအ​ရေ​အတွက်</th>
                                <th>ရောင်းစျေး</th>
                                <th>Product အ​လေးချိန်<br>(in MM units)</th>
                                <th>Date</th>
                                <th></th>
                            </thead>
                            <tbody class="text-center" id="filter">
                                <?php $i = 1;?>
                                @foreach ($purchases as $purchase)
                                <?php  $arr = explode ("/",$purchase->purchase->product_gram_kyat_pe_yway); ?>
                                <tr>
                                 <td>{{$i++}}</td>
                                 <td>{{$purchase->purchase->gold_name}}</td>
                                 <td>{{$purchase->purchase->code_number}}</td>
                                 <td>1</td>
                                 <td>{{$purchase->amount}}</td>
                                 <td>
                                    {{$arr[1] !=0 ? $arr[1].'ကျပ်' : ''}}
                                    {{$arr[2] !=0 ? $arr[2].'ပဲ' : ''}}
                                    {{$arr[3] !=0 ? $arr[3].'ရွေး' : ''}}
                                 </td>
                                 <td> ​
                                    {{$purchase->date}}
                                 </td>
                                 <td>
                                     <a href="#myModal{{$purchase->id}}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a> 
                                    <a href="{{route('backside.shop_owner.pos.edit_goldsale',$purchase->id)}}" class="ml-2 text-warning"><i class="fa fa-edit" ></i></a>
                                    <a href="{{route('backside.shop_owner.pos.detail_goldsale',$purchase->id)}}" class="ml-2 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    {{-- <a href="" class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <a href="{{route('backside.shop_owner.pos.edit_purchase',$purchase->id)}}" class="btn btn-sm btn-warning"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger" onclick="suredelete({{$purchase->id}})"><i class="fa fa-trash" aria-hidden="true"></i></a> --}}
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
         function goldtypefilter(val){
            var dataTable = $('#example23').DataTable();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();

            $.ajax({

            type:'POST',

            url: '{{route("backside.shop_owner.pos.goldsale_type_filter")}}',

            data:{
            "_token":"{{csrf_token()}}",
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
                var tot_g = 0;var tot_y=0;var tot_p=0;var tot_k=0;var tot_dy=0;var tot_dp=0;var tot_dk=0;var tot_sale=0;var count=0;
                $.each(data.data, function(i, v) {
                    count++;var html1 = '';var html2 = `<div class="d-flex">`;
                    var url1 = '{{ route('backside.shop_owner.pos.edit_goldsale', ':purchase_id') }}';
                    url1 = url1.replace(':purchase_id', v.id);
                    var url2 = '{{ route('backside.shop_owner.pos.detail_goldsale', ':purchase_id') }}';
                    url2 = url2.replace(':purchase_id', v.id);
                    var arr = v.purchase.product_gram_kyat_pe_yway.split('/');
                    var decrease = v.purchase.decrease_pe_yway.split('/');
                        tot_sale += v.amount;
                        tot_g += parseInt(arr [0]);
                        tot_y += arr [3] ? parseInt(arr [3]) : 0;
                        tot_p += arr [2] ? parseInt(arr [2]) : 0;
                        tot_k += arr [1] ? parseInt(arr [1]) : 0;
                        tot_dy += decrease [1] ? parseInt(decrease [1]) : 0;
                        tot_dp += decrease [0] ? parseInt(decrease [0]) : 0;
                        if(tot_y>=8){
                        tot_p += 1; tot_y = tot_y-8;
                        }
                        if(tot_p>=16){
                            tot_k += 1; tot_p = tot_p-16;
                        }
                        if(tot_dy>=8){
                        tot_dp += 1; tot_dy = tot_dy-8;
                        }
                        if(tot_dp>=16){
                            tot_dk += 1; tot_dp = tot_dp-16;
                        }
                        if(arr[1] != 0){
                            html1 += arr[1]+'ကျပ်';
                        }
                        if(arr[2] != 0){
                            html1 += arr[2]+'ပဲ';
                        }
                        if(arr[3] != 0){
                            html1 += arr[3]+'ရွေး';
                        }
                        if(v.sell_flag == 0){
                            html2 += `<a href="#myModal${v.id}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a>`;
                        }
                            
                        html2 += `<a href="${url1}" class="ml-4 text-warning"><i class="fa fa-edit" ></i></a>
                                  <a href="${url2}" class="ml-4 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a></div>`;
                    
                    dataTable.row.add([++i,v.purchase.gold_name,v.purchase.code_number,1,v.amount,html1,v.date,html2]).draw();
                })

                $('#tot_qty').html(count);
                $('#tot_g').html(tot_g);
                $('#tot_sale').html(tot_sale);
                $('#tot_kpy').html(`${tot_k}ကျပ် ${tot_p}ပဲ  ${tot_y}​ရွေး`);
                $('#tot_dkpy').html(`${tot_dk}ကျပ် ${tot_dp}ပဲ  ${tot_dy}​ရွေး`);
            }
        })

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

            url: '{{route("backside.shop_owner.pos.goldsale_advance_filter")}}',

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
                var tot_g = 0;var tot_y=0;var tot_p=0;var tot_k=0;var tot_dy=0;var tot_dp=0;var tot_dk=0;var tot_sale=0;var count=0;
                $.each(data.data, function(i, v) {
                    count++;var html1 = '';var html2 = `<div class="d-flex">`;
                    var url1 = '{{ route('backside.shop_owner.pos.edit_goldsale', ':purchase_id') }}';
                    url1 = url1.replace(':purchase_id', v.id);
                    var url2 = '{{ route('backside.shop_owner.pos.detail_goldsale', ':purchase_id') }}';
                    url2 = url2.replace(':purchase_id', v.id);
                    var arr = v.purchase.product_gram_kyat_pe_yway.split('/');
                    var decrease = v.purchase.decrease_pe_yway.split('/');
                        tot_sale += v.amount;
                        tot_g += parseInt(arr [0]);
                        tot_y += arr [3] ? parseInt(arr [3]) : 0;
                        tot_p += arr [2] ? parseInt(arr [2]) : 0;
                        tot_k += arr [1] ? parseInt(arr [1]) : 0;
                        tot_dy += decrease [1] ? parseInt(decrease [1]) : 0;
                        tot_dp += decrease [0] ? parseInt(decrease [0]) : 0;
                        if(tot_y>=8){
                        tot_p += 1; tot_y = tot_y-8;
                        }
                        if(tot_p>=16){
                            tot_k += 1; tot_p = tot_p-16;
                        }
                        if(tot_dy>=8){
                        tot_dp += 1; tot_dy = tot_dy-8;
                        }
                        if(tot_dp>=16){
                            tot_dk += 1; tot_dp = tot_dp-16;
                        }
                        if(arr[1] != 0){
                            html1 += arr[1]+'ကျပ်';
                        }
                        if(arr[2] != 0){
                            html1 += arr[2]+'ပဲ';
                        }
                        if(arr[3] != 0){
                            html1 += arr[3]+'ရွေး';
                        }
                        if(v.sell_flag == 0){
                            html2 += `<a href="#myModal${v.id}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a>`;
                        }
                            
                        html2 += `<a href="${url1}" class="ml-4 text-warning"><i class="fa fa-edit" ></i></a>
                                  <a href="${url2}" class="ml-4 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a></div>`;
                    
                    dataTable.row.add([++i,v.purchase.gold_name,v.purchase.code_number,1,v.amount,html1,v.date,html2]).draw();
                })

                $('#tot_qty').html(count);
                $('#tot_g').html(tot_g);
                $('#tot_sale').html(tot_sale);
                $('#tot_kpy').html(`${tot_k}ကျပ် ${tot_p}ပဲ  ${tot_y}​ရွေး`);
                $('#tot_dkpy').html(`${tot_dk}ကျပ် ${tot_dp}ပဲ  ${tot_dy}​ရွေး`);
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
                        var tot_kpy = $('#tot_kpy').text();
                        var tot_dkpy = $('#tot_dkpy').text();
                        var tot_sale = $('#tot_sale').text();
                        var date = $('#print_date').val();
                        var counter = $('#print_counter').val();
                        var gtype = $('#print_gtype').val();
                        var ptype = $('#print_ptype').val();
                        var existingData = $(win.document.body).html();
                        var extraText1 = `<div class="row">
                            <div class="col-3 card" style="max-height: 70px;"><h6 class="text-color mt-2" >စုစု​ပေါင်းအ​ရေအတွက် &nbsp;&nbsp;&nbsp;<span>${tot_qty}</span></h6></div>
                            <div class="col-3 card" style="max-height: 70px;"><h6 class="text-color mt-2" >စုစု​ပေါင်းအ​လေးချိန် &nbsp;&nbsp;&nbsp;<span>${tot_g}</span>  g<br>(Gram)</h6></div>
                            <div class="col-3 card row" style="max-height: 70px;">
                                <h6 class="col-7 text-color mt-2" >စုစု​ပေါင်းအ​လေးချိန် (ကျပ်၊ ပဲ၊ ​ရွေး)</h6>
                                <h6 class="col-5 text-color mt-2">${tot_kpy}</h6>
                            </div>
                            <div class="col-3 card row" style="max-height: 70px;">
                                <h6 class="col-8 text-color mt-2">စုစု​ပေါင်းအ​လျော့တွက် (ကျပ်၊ ပဲ၊ ​ရွေး)</h6>
                                <h6 class="col-4 text-color mt-2">${tot_dkpy}</h6>
                            </div>
                            <div class="col-5 card row" style="max-height: 70px;">
                                <h6 class="col-5 text-color mt-2" >ရောင်းရ​ငွေစုစု​ပေါင်း</h6>
                                <h6 class="col-7 text-color mt-2" id="tot_sale">${tot_sale}</h6>
                            </div>
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
                            location.reload();
                            // console.log('success');
                        }
                    })


        }

        function stockcheck(val,text){
            var dataTable = $('#example23').DataTable();
            $.ajax({

            type:'POST',

            url: '{{route("backside.shop_owner.pos.sold_filter")}}',

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
                var tot_g = 0;var tot_y=0;var tot_p=0;var tot_k=0;var tot_dy=0;var tot_dp=0;var tot_dk=0;var tot_sale=0;var count=0;
                $.each(data.data, function(i, v) {
                    count++;var html1 = '';var html2 = `<div class="d-flex">`;
                    var url1 = '{{ route('backside.shop_owner.pos.edit_goldsale', ':purchase_id') }}';
                    url1 = url1.replace(':purchase_id', v.id);
                    var url2 = '{{ route('backside.shop_owner.pos.detail_goldsale', ':purchase_id') }}';
                    url2 = url2.replace(':purchase_id', v.id);
                    var arr = v.purchase.product_gram_kyat_pe_yway.split('/');
                    var decrease = v.purchase.decrease_pe_yway.split('/');
                        tot_sale += v.amount;
                        tot_g += parseInt(arr [0]);
                        tot_y += arr [3] ? parseInt(arr [3]) : 0;
                        tot_p += arr [2] ? parseInt(arr [2]) : 0;
                        tot_k += arr [1] ? parseInt(arr [1]) : 0;
                        tot_dy += decrease [1] ? parseInt(decrease [1]) : 0;
                        tot_dp += decrease [0] ? parseInt(decrease [0]) : 0;
                        if(tot_y>=8){
                        tot_p += 1; tot_y = tot_y-8;
                        }
                        if(tot_p>=16){
                            tot_k += 1; tot_p = tot_p-16;
                        }
                        if(tot_dy>=8){
                        tot_dp += 1; tot_dy = tot_dy-8;
                        }
                        if(tot_dp>=16){
                            tot_dk += 1; tot_dp = tot_dp-16;
                        }
                        if(arr[1] != 0){
                            html1 += arr[1]+'ကျပ်';
                        }
                        if(arr[2] != 0){
                            html1 += arr[2]+'ပဲ';
                        }
                        if(arr[3] != 0){
                            html1 += arr[3]+'ရွေး';
                        }
                        if(v.sell_flag == 0){
                            html2 += `<a href="#myModal${v.id}" class="text-danger" data-toggle="modal"><i class="fa fa-trash"></i></a>`;
                        }
                            
                        html2 += `<a href="${url1}" class="ml-4 text-warning"><i class="fa fa-edit" ></i></a>
                                  <a href="${url2}" class="ml-4 text-success"><i class="fa fa-eye" aria-hidden="true"></i></a></div>`;
                    
                    dataTable.row.add([++i,v.purchase.gold_name,v.purchase.code_number,1,v.amount,html1,v.date,html2]).draw();
                })

                $('#tot_qty').html(count);
                $('#tot_g').html(tot_g);
                $('#tot_sale').html(tot_sale);
                $('#tot_kpy').html(`${tot_k}ကျပ် ${tot_p}ပဲ  ${tot_y}​ရွေး`);
                $('#tot_dkpy').html(`${tot_dk}ကျပ် ${tot_dp}ပဲ  ${tot_dy}​ရွေး`);
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

