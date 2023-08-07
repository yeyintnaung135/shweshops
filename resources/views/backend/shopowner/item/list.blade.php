@extends('layouts.backend.datatable')
@section('content')
    @push('css')
        <style>
            .priceInput{
                height: 30px;
                border:0px !important;
            }
            .priceInput-invalid{
                border: 3px solid red !important;
            }

            .priceInput:focus{
                /* border: 1px solid blueviolet !important; */
                background-color: #efefef;

            }
            #itemsTable thead>tr>td:nth-child(6){
                width: 250px;
            }

            .price{
                text-align: left !important;
            }


        </style>
    @endpush

    <div class="wrapper">
    @include('backend.shopowner.loading')
    @include('layouts.backend.navbar')


    <!-- Main Sidebar Container -->
    @include('layouts.backend.sidebar')
    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper sn-background-light-blue">
            <!-- Content Header (Page header) -->
            @if(Session::has('message'))
                <x-alert>

                </x-alert>
        @endif
        <!-- zhheader shopname -->
        {{-- <x-header>
        @foreach($shopowner as $shopowner )
                @endforeach
                {{$shopowner->shop_name}}
        </x-header> --}}
        <!-- end zh header shopname -->
        {{-- <x-title>
            Items list
        </x-title> --}}
        <!-- Main content -->
            <section class="content pt-3">
                {{-- <div class="sn-tab-panel">
                    <ul>
                        <li id="item-tab-1" class="active-panel" onclick="itemTabSwitchOne()">Item List</li>
                        <li id="item-tab-2" onclick="itemTabSwitchTwo()">Item Activity</li>
                        <li id="item-tab-3" onclick="itemTabSwitchThree()">Multiple Price Activity</li>
                        <li id="item-tab-4" onclick="itemTabSwitchFour()">Multiple Discount Activity</li>
                        <li id="item-tab-5" onclick="itemTabSwitchFive()">Multiple Percent Activity</li>
                    </ul>
                </div> --}}
                <div id="item-panel-1" class="container-fluid">
                    <div class="row">
                        <div class="col-12">


                            <div class="sn-table-list-wrapper">
                                <div class="border-bottom-0 mt-4 mr-2">
                                    <a href="{{url('backside/shop_owner/items/create')}}"
                                       class="btn btn-primary float-right"><span class="fa fa-plus-circle"></span>&nbsp;&nbsp;Add
                                        New Item
                                    </a>
                                    <br><br>
                                </div>
                                <!-- /.card-header -->
                                <div class="card shadow-none border-0 rounded-5 pb-2">
                                    <div class="card-header">
                                        @error('percent')
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>{{ $message }}</strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @enderror
                                        <div class="">
                                            <h2>Today's Update Products @include('backend.shopowner.toottips')
                                            </h2>
                                            <p>Check your store's daily updates</p>
                                        </div>
                                        <div class="ml-auto mt-2 d-flex ">
                                            <button class="btn btn-success multi-btn" id="multi-btn">Change Price
                                            </button>
                                            <button class="btn btn-warning setDiscount ml-2" id="set-discount">Set Discount
                                            </button>
                                            <button class="btn btn-danger multiple_stock  ml-2" id="multipleStock">Stock</button>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end my-3 align-items-center">
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>From Date</legend>
                                                <input type="text" id='search_fromdate_item' class="itemdatepicker form-control" placeholder='Choose date' autocomplete="off"/>
                                            </fieldset>
                                        </div>
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>To Date</legend>
                                                <input type="text" id='search_todate_item' class="itemdatepicker form-control" placeholder='Choose date' autocomplete="off"/>
                                            </fieldset>
                                        </div>
                                        <div class="pr-md-4">
                                            <input type='button' id="item_search_button" value="Search" class="btn bg-info"  >
                                        </div>
                                    </div>

                                    <table id="itemsTable" class="table table-borderless">
                                        <thead>
                                        <tr>
                                            <td>Select</td>

                                            <td>Name</td>
                                            <td>Discount</td>
                                            <td>Image</td>
                                            <td>Product Code</td>
                                            <td class="price">Price</td>
                                            <td>Action</td>
                                            <td>Date</td>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <td>Select</td>

                                            <td>Name</td>
                                            <td>Discount</td>
                                            <td>Image</td>
                                            <td>Product Code</td>
                                            <td>Price</td>
                                            <td>Action</td>
                                            <td>Date</td>
                                        </tr>
                                        </tfoot>
                                    </table>

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>

                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>

    <!-- Modal Start  -->
    <div id="multipleModal" class="modal fade" role="dialog">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Multiple Update</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body  sop-font">
                    @csrf
                    <div class="hidden-input"></div>
                    <div class="form-group">
                        <label class="control-label ">Price : </label>
                        <input type="text" name="price"  id="changepricebox" class="form-control"/>
                        <span id="error_price" class="text-danger d-none">error</span>

                    </div>
                    <div class="form-row mb-4">
                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input " type="radio" name="oper" value='plus' id="plus"
                                       checked> ပေါင်း
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input " type="radio" name="oper" value='minus' id="minus">
                                နှုတ်
                            </div>
                        </div>

                        <div class="col-8 radio-error"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">အလျော့တွက် % : </label>
                        <input type="number" name="အလျော့တွက်" id="first_name" value="" class="form-control "/>
                        <span id="error_အလျော့တွက်" class="text-danger d-none">error</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label">လက်ခ % : </label>
                        <input type="text" name="လက်ခ" id="first_name" class="form-control"/>
                        <span id="error_လက်ခ" class="text-danger d-none">error</span>

                    </div>
                    <div class="form-group">
                        <label class="control-label">အထည်မပျက်ပြန်သွင်း % : </label>
                        <input type="text" name="အထည်မပျက်ပြန်သွင်း" id="first_name" class="form-control"/>
                        <span id="error_အထည်မပျက်ပြန်သွင်း" class="text-danger d-none">error</span>

                    </div>
                    <div class="form-group">
                        <label class="control-label">အထည်ပျက်စီးချို့ယွင်း % : </label>
                        <input type="text" name="အထည်ပျက်စီးချို့ယွင်း" id="first_name" class="form-control"/>
                        <span id="error_အထည်ပျက်စီးချို့ယွင်း" class="text-danger d-none">error</span>

                    </div>
                    <div class="form-group ">
                        <label class="control-label">တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲ % : </label>
                        <input type="text" name="တန်ဖိုးမြင့်" id="first_name" class="form-control"/>
                        <span id="error_တန်ဖိုးမြင့်" class="text-danger d-none sop-font">error</span>

                    </div>
                    <br/>
                    <div class="form-group">
                        <button class="btn btn-warning update"> Update</button>
                        <br/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="multipleStockModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Multiple Stock</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body sop-font">
                    <form action="{{route('backside.shop_owner.multiple.stock.items')}}" method="post">
                        @csrf
                        <input type="hidden" name="multipleStockId" value="" class="multipleStock">
                        <div class="form-group">
                            <label class="control-label">Stock</label>
                            <select class="form-control" id="multipleStockSelect" name="stock">
                                <option value="Out Of Stock">Out Of Stock</option>
                                <option value="In Stock">In Stock</option>
                            </select>
                        </div>
                        <div class="form-group multipleStockCount">
                            <label class="control-label">Counts</label>
                            <input type="number" class="form-control multipleStockCountVal" name="count">
                            <span class="font-weight-bolder text-danger multipleCountValidate">In stock count required*</span>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-warning" onclick="multipleStockBtn(this)">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="discountModal" class="modal sop-font fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Multiple Set Discount</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    {{--            <form action="{{ route('backside.shop_owner.items.multiple.discount')}}" method="post">--}}
                    @csrf
                    <div class="hidden-input"></div>
                    <div class="form-group">
                        <label class="control-label ">Percent : </label>
                        <input type="text" name="percent" id="tochangeper" class="form-control"/>
                        <span id="error_percent" class="text-danger d-none">error</span>

                    </div>
                    <br/>
                    <div class="form-group">
                        <button class="btn btn-warning discount_check"> Discount</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div id="updatedsuccess" class="modal sop-font fade" data-controls-modal="updatedsuccess" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Please check your change price</h4>
                    <button type="button" class="success-close cross-close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span><br/>
                    </button>
                </div>
                <div class="modal-body">

                    <p id="success-text"></p>
                    <br>
                    <div class="content">

                    </div>
                    <button class="btn btn-info success-close ">Cancel</button>
                    <button class=" done-button btn btn-primary confirm float-right ">Confirm</button>
                </div>

            </div>
        </div>
    </div>

    <div id="discountcheck" class="modal sop-font fade " data-controls-modal="discountcheck" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Please check your change price</h4>
                    <button type="button" class="success-close cross-close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span><br/>
                    </button>
                </div>
                <div class="modal-body">

                    <p id="success-text"></p>
                    <br>
                    <div class="content">

                    </div>
                    <button class="btn btn-info success-close ">Cancel</button>
                    <button class=" done-button btn btn-primary confirm_disc  float-right ">Confirm</button>

                </div>

            </div>
        </div>
    </div>

    <!-- Modal end  -->
@endsection
@push('scripts')
    <script>

        $("#loader").hide();
        function priceUpdate(e) {
            e = e || window.event;
            return(e.keyCode || e.which);
        }

        window.onload = function(){
            document.onkeypress = function(e){
                var key = priceUpdate(e);
                if(key === 13){
                    var input = e.srcElement.value;
                    let regex = /^([_\-\.0-9]+){2,7}$/;
                    let number = regex.test(input);
                    if(input == '' || input == 0 || number === false ){
                        $(e.srcElement).addClass('priceInput-invalid')
                        return false;
                    }else{
                        $.ajax({
                            method: "POST",
                            url: " {{ route('backside.shop_owner.price_only_update')}}",
                            cache: false,
                            dataType: "json",
                            data: {
                                _token: '{{csrf_token()}}',
                                price: e.srcElement.value,
                                id: e.target.nextElementSibling.value,

                            },
                            beforeSend: function() {
                                $("#loader").show();
                            },

                            error: function (err) {
                                console.log(err)
                                $(e.originalTarget).addClass('priceInput-invalid');
                                $("#loader").hide();
                            },
                            success: function (response) {
                                console.log(response['data'])
                                $(e.originalTarget).removeClass('priceInput-invalid');
                                $(e.srcElement).removeClass('priceInput-invalid')
                                $("#loader").hide();
                            },
                        });
                    }

                }


            };
        };

        $(document).ready(function() {
            var itemsTable = $('#itemsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ route('backside.shop_owner.items.getItems') }}",
                    'data': function (data) {
                        // Read values
                        var from_date = $('#search_fromdate_item').val() ? $('#search_fromdate_item').val() + " 00:00:00" : null;
                        var to_date = $('#search_todate_item').val() ? $('#search_todate_item').val() + " 23:59:59" : null;

                        // Append to data
                        data.searchByFromdate = from_date;
                        data.searchByTodate = to_date;
                    }
                },
                columns: [
                    {
                        data: 'checkbox',
                        render: function (data, type) {
                            let localRetri = JSON.parse(window.localStorage.getItem("localData")) || [];
                            return (localRetri.length == 0) ? `<input type="checkbox" value="${data}" onclick='checkbox(this)' id="1_${data}">`
                                : (localRetri.find(element => element == data) == data)
                                    ? `<input type="checkbox" value="${data}" onclick='checkbox(this)' id="1_${data}" checked>`
                                    : `<input type="checkbox" value="${data}" onclick='checkbox(this)' id="1_${data}">`
                        }
                    },
                    {data: 'name',},

                    {
                        data: 'check_discount',

                        render: function (data, type) {
                            const discount = (data == 0) ? `----` : `<span class="badge bg-success">${data.percent}%</span>`;
                            return discount;
                        }
                    },
                    {

                        data: 'image',
                        render: function (data, type) {
                            const image = `<img src= "{{ filedopath ('/items/'.'${data}')}}"/>`;
                            return image;
                        }
                    },
                    {data: 'product_code'},
                    {
                        data: 'price',
                        render: function (data,type,row) {

                            let getErrData = JSON.parse(window.localStorage.getItem("errData")) || [];
                            return (getErrData.length == 0) ? `
                                <div class="tz-error-${data[1]}">
                                    <input type="text" name="price" value="${data[0]}" onkeypress="priceUpdate(this)" class="priceInput">
                                    <input type="hidden" name="id" value="${row.id}" class="shop_id">
                                </div>`
                                : (getErrData.find(element => element == data[1]) == data[1])
                                    ? `<div class="tz-error-${data[1]} text-danger">
                                         <input type="text" name="price" value="${data[0]}" onkeypress="priceUpdate(this)" class="priceInput">
                                         <input type="hidden" name="id" value="${row.id}" class="shop_id">
                                       </div><span class="text-danger">*မှားနေပါတယ်</span>`
                                    : `<div class="tz-error-${data[1]}">
                                         <input type="text" name="price" value="${data[0]}" onkeypress="priceUpdate(this)" class="priceInput">
                                         <input type="hidden" name="id" value="${row.id}" class="shop_id">
                                     </div>`
                        }
                    },
                    {
                        data: 'action',
                        render: function (data, type) {
                            var info = `<a style="margin-right: 5px;" class="btn btn-sm btn-success" href="{{ route ('backside.shop_owner.items.show',['item'=>':id'])}}"><span class="fa fa-info-circle"></span></a>`;
                            info = info.replace(':id', data);
                            var edit = `<a class="btn btn-sm btn-primary" href="{{ route ('backside.shop_owner.items.edit',['item'=>':id'])}}"><span class="fa fa-edit"></span></a>`;
                            edit = edit.replace(':id', data);
                            return info + edit;

                        }
                    },
                    {data: 'created_at'}

                ],

                responsive: true,
                lengthChange: true,
                autoWidth: false,
                paging: true,
                dom: 'Blfrtip',
                buttons: ["copy", "csv",  {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [  1, 4, 5 ]
                    }
                }, "pdf", "print"],
                columnDefs: [
                    {responsivePriority: 1, targets: 0},
                    {responsivePriority: 2, targets: 2},
                    {responsivePriority: 3, targets: 3},
                    {responsivePriority: 4, targets: 4},
                    {
                        'targets': [0, 2, 5],
                        'orderable': false,
                    },
                    {
                        'orderable': false,
                        'className': 'select-checkbox',
                        'targets': 2
                    },
                    {

                        'targets': [7],
                        'visible': false,
                        'searchable': false,
                    },
                    {

'targets': [3],
'orderable': false,
},
{

'targets': [6],
'orderable': false,
}
                ],
                language: {
                    "search": '<i class="fa-solid fa-search"></i>',
                    "searchPlaceholder": 'Search...',
                    paginate: {
                        next: '<i class="fa fa-angle-right"></i>', // or '→'
                        previous: '<i class="fa fa-angle-left"></i>' // or '←'
                    }
                },


                "order": [[7, "desc"]],

            });



            $( ".itemdatepicker" ).datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#item_search_button').click(function(){
                if($('#search_fromdate_item').val() != null && $('#search_todate_item').val() != null) {
                    itemsTable.draw();
                }
            });

            $( ".itemactdatepicker" ).datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#itemact_search_button').click(function(){
                if($('#search_fromdate_itemact').val() != null && $('#search_todate_itemact').val() != null) {
                    itemsActivityTable.draw();
                }
            });

            $( ".mulpriceactdatepicker" ).datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#mulpriceact_search_button').click(function(){
                if($('#search_fromdate_mulpriceact').val() != null && $('#search_todate_mulpriceact').val() != null) {
                    multiplePriceLogsActivityTable.draw();
                }
            });

            $( ".muldisactdatepicker" ).datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#muldisact_search_button').click(function(){
                if($('#search_fromdate_muldisact').val() != null && $('#search_todate_muldisact').val() != null) {
                    multipleDiscountActivityTable.draw();
                }
            });

            $( ".mulperactdatepicker" ).datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#mulperact_search_button').click(function(){
                if($('#search_fromdate_mulperact').val() != null && $('#search_todate_mulperact').val() != null) {
                    multipleDamageActivityTable.draw();
                }
            });
        });

        $('.multi-btn').hide();

        $('.setDiscount').hide();

        $('.multiple_stock').hide();
        var STOPCLICK = false;
        var STOPCLICK_DISCOUNT = false;
        var oper = 'plus';
        var temptodis = {};
        $("input[name=oper]").on('change', function () {
            oper = $(this).val();
        });
        var unsetdiscountitemlist = [];
        //we cannot use some jquery code in this fn beacause it conflict with bootstrap model
        //okay pr :p
        $(document).on('change', '.ff', function (e) {
            if (!e.target.checked) {
                temptodis[e.target.value] = $('#' + e.target.value).text();
                ;
                console.log(temptodis);
                $('#' + e.target.value).html('------');

                unsetdiscountitemlist.push(e.target.value)

            } else {
                $('#' + e.target.value).html(temptodis[e.target.value]);

                const index = unsetdiscountitemlist.indexOf(e.target.value);
                if (index > -1) {
                    unsetdiscountitemlist.splice(index, 1);
                }
            }
            console.log(unsetdiscountitemlist);
        });
        //we cannot use some jquery code in this fn beacause it conflict with bs model

        let inputs = $(':input');
        let errData = new Array();
        let currentError = new Array();
        localData = localStorage.setItem("localData", JSON.stringify(data));

        function checkbox(e) {

            if ($(e).is(':checked')) {

                data.push(e.value);

                $('.multi-btn').show();

                $('.setDiscount').show();

                $('.multiple_stock').show();
                $(".multipleStock").val(data);
                localData = localStorage.setItem("localData", JSON.stringify(data));

            } else {
                const index = data.indexOf(e.value);
                if (index > -1) {
                    data.splice(index, 1);
                    $(".multipleStock").val(data);
                }
                // console.log(y);
                if (data.length === 0) {
                    $('.multi-btn').hide();
                    $('.setDiscount').hide();
                    $('.multiple_stock').hide();
                }

                localData = localStorage.removeItem("localData", JSON.stringify(data));
            }
        }
        function location_href() {
            return window.location.href = "{{route('backside.shop_owner.items.index')}}";
        }
        function radio_error_check() {
            $('.radio-error').append(`
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>အပေါင်း(သို့မဟုတ်)အနှုတ်</strong>  ရွေးပေးပါ
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
             </div>
        `);
        }

        $('.success-close').click(function () {
            location_href();
        })

        $('.multi-btn').on('click', function (e) {

            e.preventDefault();
            $('#multipleModal').modal('show');
            console.log(data)
            data.map(function (el, index) {

                $('.hidden-input').append(`
                <input type="hidden" name="id[]" value="${el}" id="get_id-${el}" class="form-control"/>
            `);

                // var items_id = $(`#get_id-${el}`).val();
                // if(!item_id.includes(items_id)){
                //     item_id.push(items_id);
                //
                // }
            });
            item_id = data;
        });

        $('#multipleStock').click(function () {
            $(".multipleStockCount").hide();
            $(".multipleCountValidate").hide();

            $("#multipleStockSelect").on('change', ()=>{

                if( $("#multipleStockSelect").val() === "In Stock"){
                    $(".multipleStockCount").fadeIn();

                }else{
                    $(".multipleStockCount").fadeOut();
                }
            })

            $('#multipleStockModal').modal('show');
        });

        function multipleStockBtn(e){
            var countVal = $(".multipleStockCountVal").val();
            if($("#multipleStockSelect").val() === "Out Of Stock"){
                $(e.form).submit();
            }else if(countVal.length > 0){
                $(e.form).submit();
            }else{
                $(".multipleCountValidate").show();
            }
        }

        $('.setDiscount').click(function () {
            $('#discountModal').modal('show');
            data.map(function (el, index) {
                $('.hidden-input').find($('input[type=hidden]')).remove();
                $('.hidden-input').append(`
                <input type="hidden" name="id[]" value="${el}" id="get_id-${el}" class="form-control"/>
            `);
            });
            item_id = data;

        });

        $('.update').on('click', function (e) {
            if (STOPCLICK) return;
            STOPCLICK = true;
            e.preventDefault();
            checkpriceafterupdateclick();

        });

        $('.discount_check').on('click', function (e) {
            if (STOPCLICK_DISCOUNT) return;
            STOPCLICK_DISCOUNT = true;

            e.preventDefault();
            checkpriceafterdiscountclick();


        });

        //this is for show before update model
        function updatedSuccess(items, text, type) {
            var content;
            if (type == "price") {
                content = `<table id="price_table" class="table borderless table-responsive">
                    <thead><th>Product Code</th><th>Name</th><th>Old Price</th><th>New Price</th><th>Unset Discount?</th><th>Old Discount Price</th><th>New Discount Price</th></thead>
                    <tbody></tbody>
                  </table>`;
            } else if (type == "recap") {

                conone = '';
                contwo = '';
                conthree = '';
                confour = '';
                confive = '';
                if ($("input[name=အလျော့တွက်]").val() !== '') {
                    let val = $("input[name=အလျော့တွက်]").val();
                    conone = `<p>အလျော့တွက် : ${val} %</p>`;
                }
                if ($("input[name=အထည်မပျက်ပြန်သွင်း]").val() !== '') {
                    let val = $("input[name=အထည်မပျက်ပြန်သွင်း]").val();
                    confive = `<p>အထည်မပျက်ပြန်သွင်း : ${val} %</p>`;
                }
                if ($("input[name=လက်ခ]").val() !== '') {
                    let val = $("input[name=လက်ခ]").val();
                    contwo = `<p>လက်ခ : ${val} %</p>`;
                }
                if ($("input[name=အထည်ပျက်စီးချို့ယွင်း]").val() !== '') {
                    let val = $("input[name=အထည်ပျက်စီးချို့ယွင်း]").val();
                    conthree = `<p>အထည်ပျက်စီးချို့ယွင်း : ${val} %</p>`;
                }
                if ($("input[name=တန်ဖိုးမြင့်]").val() !== '') {
                    let val = $("input[name=တန်ဖိုးမြင့်]").val();
                    confour = `<p>တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲ : ${val} %</p>`;
                }

                content = conone + contwo + conthree + confive + confour;
            }
            $('#updatedsuccess .content').append(content);
            $('#multipleModal').hide();
            $('#updatedsuccess').modal('show');
            $('#success-text').html(text);
            var result;
            if (type == "price") {
                items.forEach(item => {
                    var fromprice = item.orgprice != 0 ? item.orgprice : item.orgmin + "-" + item.orgmax;
                    var toprice = item.price != 0 ? item.price : item.min + "-" + item.max;
                    var discount = item.disitem;
                    var unsetdiscount = '----';
                    var fromdisprice = item.fromdisprice;
                    var unsetdiscount = `----`;

                    if (discount == 'yes') {
                        unsetdiscount = `<input type="checkbox" class='ff' data-toggle="toogle" checked data-size="mini" value='${item.id}' data-offstyle="danger" data-width="100">`;

                        var todisprice = item.disprice != 0 ? item.disprice : item.dismin + '--' + item.dismax;
                    } else {


                        var todisprice = '-----';
                    }


                    result += `<tr> <td>${item.product_code}</td> <td>${item.name}</td> <td>${fromprice}</td><td>${toprice}</td><td >${unsetdiscount}</td><td>${fromdisprice}</td><td id="${item.id}">${todisprice}</td></tr>`


                });
                $("#updatedsuccess #price_table tbody").append(result);
                $(".ff").bootstrapToggle({
                    on: 'Discount',
                    off: 'Unset'
                });


            } else if (type == "recap") {
                items.forEach(item => {
                    result += `<tr><td>${item.product_code}</td> <td>${item.name}</td></tr>`
                });

                $("#updatedsuccess #recap_table tbody").append(result);
            }
        }
        //this is for show before update model
        function showdismodelbeforediscount(items) {

            $('#discountModal').modal('hide');
            var content = `<table id="dis_price_table" class="table borderless table-responsive">
                    <thead><th>Product Code</th><th>Name</th><th>Old Price</th><th>Old Discount Price</th><th>New Discount Price</th></thead>
                    <tbody></tbody>
                  </table>`;

            $('#discountcheck .content').append(content);
            let result;

            items.forEach(item => {
                var fromprice = item.orgprice != 0 ? item.orgprice : item.orgmin + "-" + item.orgmax;
                var fromdisprice = item.fromdisprice;
                var todisprice = item.disprice;


                result += `<tr> <td>${item.product_code}</td> <td>${item.name}</td> <td>${fromprice}</td><td>${fromdisprice}</td><td id="${item.id}">${todisprice}</td></tr>`


            });
            $("#discountcheck #dis_price_table tbody").append(result);
            $('#discountcheck').modal('show');

        }

        $('.confirm_disc').one('click', function (e) {
            $.ajax({
                method: "POST",
                url: " {{ route('backside.shop_owner.items.multiple.discount')}}",
                cache: false,
                dataType: "json",
                data: {
                    _token: '{{csrf_token()}}',
                    percent: jQuery('#tochangeper').val(),
                    id: item_id,


                },
                error: function (err) {


                },
                success: function (response) {
                    // console.log(response['data'])
                    if (response['status'] == 'success') {
                        window.location.assign(location_href());
                    }


                },
            });

        });


        function checkpriceafterdiscountclick() {


            $.ajax({
                method: "POST",
                url: "{{ route('backside.shop_owner.multiple_items.checkpriceafterdiscountclick') }}",
                cache: false,
                dataType: "json",
                data: {
                    _token: '{{csrf_token()}}',
                    percent: jQuery('#tochangeper').val(),
                    id: item_id,


                },
                error: function (err) {
                },
                success: function (response) {
                    // console.log(response['data'])
                    if (response['status'] == 'success') {
                        showdismodelbeforediscount(response['data'])

                    } else {
                        if (response['data'].percent != undefined) {
                            $("input[name=percent]").addClass('is-invalid');
                            $("#error_percent").removeClass('d-none');
                            $("#error_percent").addClass('d-block');
                            $("#error_percent").html(response['data'].percent);
                        }

                        setTimeout(function(){
                            STOPCLICK_DISCOUNT=false;
                        }, 1000)
                    }

                },
            });
        }

        function checkpriceafterupdateclick() {

            let temppercent = {'အလျော့တွက်': $("input[name=အလျော့တွက်]").val()};

            $.ajax({
                method: "POST",
                url: "{{ route('backside.shop_owner.multiple_items.checkpriceafterupdateclick') }}",
                cache: false,
                dataType: "json",
                data: {
                    _token: '{{csrf_token()}}',
                    price: jQuery('#changepricebox').val(),
                    id: item_id,
                    oper: oper,
                    အလျော့တွက်: $("input[name=အလျော့တွက်]").val(),
                    လက်ခ: $("input[name=လက်ခ]").val(),
                    အထည်မပျက်ပြန်သွင်း: $("input[name=အထည်မပျက်ပြန်သွင်း]").val(),
                    အထည်ပျက်စီးချို့ယွင်း: $("input[name=အထည်ပျက်စီးချို့ယွင်း]").val(),
                    တန်ဖိုးမြင့်: $("input[name=တန်ဖိုးမြင့်]").val()

                },
                error: function (err) {
                    STOPCLICK = false;


                },
                success: function (response) {
                    console.log(response);
                    if (response['status'] == 'success') {
                        updatedSuccess(response['data'], 'test msg', 'price');
                        // for percent template
                        if ($("input[name=အလျော့တွက်]").val() !== '' || $("input[name=လက်ခ]").val() !== '' || $("input[name=အထည်မပျက်ပြန်သွင်း]").val() !== '' || $("input[name=အထည်ပျက်စီးချို့ယွင်း]").val() !== '' || $("input[name=တန်ဖိုးမြင့်]").val() !== '') {
                            updatedSuccess('recap', 'test msg', 'recap')

                        }
                    } else if (response['status'] == 'onlypercent') {
                        if ($("input[name=အလျော့တွက်]").val() !== '' || $("input[name=လက်ခ]").val() !== '' || $("input[name=အထည်မပျက်ပြန်သွင်း]").val() !== '' || $("input[name=အထည်ပျက်စီးချို့ယွင်း]").val() !== '' || $("input[name=တန်ဖိုးမြင့်]").val() !== '') {
                            updatedSuccess('recap', 'test msg', 'recap')

                        }
                    } else {
                        if (response['data'].အလျော့တွက် != undefined) {
                            $("input[name=အလျော့တွက်]").addClass('is-invalid');
                            $("#error_အလျော့တွက်").removeClass('d-none');
                            $("#error_အလျော့တွက်").addClass('d-block');
                            $("#error_အလျော့တွက်").html(response['data'].အလျော့တွက်[0]);
                        }
                        if (response['data'].လက်ခ != undefined) {
                            $("input[name=လက်ခ]").addClass('is-invalid');
                            $("#error_လက်ခ").removeClass('d-none');
                            $("#error_လက်ခ").addClass('d-block');
                            $("#error_လက်ခ").html(response['data'].လက်ခ[0]);
                        }
                        if (response['data'].အထည်မပျက်ပြန်သွင်း != undefined) {
                            $("input[name=အထည်မပျက်ပြန်သွင်း]").addClass('is-invalid');
                            $("#error_အထည်မပျက်ပြန်သွင်း").removeClass('d-none');
                            $("#error_အထည်မပျက်ပြန်သွင်း").addClass('d-block');
                            $("#error_အထည်မပျက်ပြန်သွင်း").html(response['data'].အထည်မပျက်ပြန်သွင်း[0]);
                        }
                        if (response['data'].အထည်ပျက်စီးချို့ယွင်း != undefined) {
                            $("input[name=အထည်ပျက်စီးချို့ယွင်း]").addClass('is-invalid');
                            $("#error_အထည်ပျက်စီးချို့ယွင်း").removeClass('d-none');
                            $("#error_အထည်ပျက်စီးချို့ယွင်း").addClass('d-block');
                            $("#error_အထည်ပျက်စီးချို့ယွင်း").html(response['data'].အထည်ပျက်စီးချို့ယွင်း[0]);
                        }
                        if (response['data'].တန်ဖိုးမြင့် != undefined) {
                            $("input[name=တန်ဖိုးမြင့်]").addClass('is-invalid');
                            $("#error_တန်ဖိုးမြင့်").removeClass('d-none');
                            $("#error_တန်ဖိုးမြင့်").addClass('d-block');
                            $("#error_တန်ဖိုးမြင့်").html(response['data'].တန်ဖိုးမြင့်[0]);
                        }
                        if (response['data'].price != undefined) {
                            $("input[name=price]").addClass('is-invalid');
                            $("#error_price").removeClass('d-none');
                            $("#error_price").addClass('d-block');
                            $("#error_price").html(response['data'].price[0]);
                        }

                    }
                    setTimeout(function(){
                        STOPCLICK=false;
                    }, 1000)

                },
            });
        }


        $('.confirm').one('click', function (e) {

            let price = $("#changepricebox").val();
            e.preventDefault();
            if (price !== '' || $("input[name=အလျော့တွက်]").val() !== '' || $("input[name=လက်ခ]").val() !== '' || $("input[name=အထည်မပျက်ပြန်သွင်း]").val() !== '' || $("input[name=အထည်ပျက်စီးချို့ယွင်း]").val() !== '' || $("input[name=တန်ဖိုးမြင့်]").val() !== '') {
                if ($("input[name=အလျော့တွက်]").val() !== '' || $("input[name=လက်ခ]").val() !== '' || $("input[name=အထည်မပျက်ပြန်သွင်း]").val() !== '' || $("input[name=အထည်ပျက်စီးချို့ယွင်း]").val() !== '' || $("input[name=တန်ဖိုးမြင့်]").val() !== '') {
                    if (price !== '') {
                        if (oper == 'plus') {
                            plus();

                        } else if (oper == 'minus') {
                            minus();

                        } else {

                            radio_error_check();
                        }
                    }
                    recap_update();
                } else {
                    if (oper == 'plus') {
                        plus();
                    } else if (oper == 'minus') {
                        minus();

                    } else {
                        radio_error_check();
                    }
                }
            } else {
                $('label').addClass('active');
                inputs.addClass('is-invalid');
            }
            $('.update').attr('disabled', true);
        });

        function get(obj) {
            return document.getElementById(obj);
        }

        function itemTab_Panel(tab_active, tab2, tab3, tab4, tab5, panel_remove, panel2, panel3, panel4, panel5) {
            get(tab_active).classList.add("active-panel");
            get(tab2).classList.remove("active-panel");
            get(tab3).classList.remove("active-panel");
            get(tab4).classList.remove("active-panel");
            get(tab5).classList.remove("active-panel");

            get(panel_remove).classList.remove("sn-panel-hide");
            get(panel2).classList.add("sn-panel-hide");
            get(panel3).classList.add("sn-panel-hide");
            get(panel4).classList.add("sn-panel-hide");
            get(panel5).classList.add("sn-panel-hide");
        }

        function itemTabSwitchOne() {
            itemTab_Panel("item-tab-1","item-tab-2","item-tab-3","item-tab-4", "item-tab-5","item-panel-1","item-panel-2","item-panel-3", "item-panel-4", "item-panel-5");
        }

        function itemTabSwitchTwo() {
            itemTab_Panel("item-tab-2","item-tab-1","item-tab-3","item-tab-4", "item-tab-5","item-panel-2","item-panel-1","item-panel-3", "item-panel-4", "item-panel-5");
        }

        function itemTabSwitchThree() {
            itemTab_Panel("item-tab-3","item-tab-1","item-tab-2","item-tab-4", "item-tab-5","item-panel-3","item-panel-1","item-panel-2", "item-panel-4", "item-panel-5");
        }

        function itemTabSwitchFour() {
            itemTab_Panel("item-tab-4","item-tab-1","item-tab-2","item-tab-3", "item-tab-5","item-panel-4","item-panel-1","item-panel-2", "item-panel-3", "item-panel-5");
        }

        function itemTabSwitchFive() {
            itemTab_Panel("item-tab-5","item-tab-1","item-tab-2","item-tab-3", "item-tab-4","item-panel-5","item-panel-1","item-panel-2", "item-panel-3", "item-panel-4");
        }

        function plus() {
            $.ajax({
                method: "POST",
                url: "{{ route('backside.shop_owner.multiple_items.update_plus') }}",
                cache: false,
                dataType: "json",
                data: {
                    _token: '{{csrf_token()}}',
                    price: jQuery('#changepricebox').val(),
                    id: item_id,
                    unsetdiscountitems: unsetdiscountitemlist
                    // console.log(price);

                },

                error: function (err) {
                    $.each(err.responseJSON.errors, function (i, error) {
                        currentError.push(error);
                        var el = $(document).find('[name="' + i + '"]');
                        el.after($('<span class="invalid-feedback">' + error[0] + '</span>'));
                        el.addClass('is-invalid');
                    });

                },
                success: function (response) {
                    location.assign(window.location.href)


                },
            });
        }

        function minus() {
            $.ajax({
                method: "POST",
                url: "{{ route('backside.shop_owner.multiple_items.update_minus') }}",
                cache: false,
                dataType: "json",
                data: {
                    _token: '{{csrf_token()}}',

                    price: jQuery('#changepricebox').val(),
                    id: item_id,
                    unsetdiscountitems: unsetdiscountitemlist

                },
                error: function (err) {

                    $.each(err.responseJSON.errors, function (i, error) {

                        currentError.push(error);
                        var el = $(document).find('[name="' + i + '"]');
                        el.after($('<span class="invalid-feedback">' + error[0] + '</span>'));
                        el.addClass('is-invalid');
                    });
                },
                success: function (response) {
                    location.assign(window.location.href)


                },
            });
        }

        function recap_update() {
            $.ajax({
                method: "POST",
                url: "{{ route('backside.shop_owner.multiple_items.update_recap') }}",
                cache: false,
                dataType: "json",
                data: {
                    _token: '{{csrf_token()}}',
                    id: item_id,
                    အလျော့တွက်: jQuery("input[name=အလျော့တွက်]").val(),
                    လက်ခ: jQuery("input[name=လက်ခ]").val(),
                    အထည်မပျက်ပြန်သွင်း: jQuery("input[name=အထည်မပျက်ပြန်သွင်း]").val(),
                    အထည်ပျက်စီးချို့ယွင်း: jQuery("input[name=အထည်ပျက်စီးချို့ယွင်း]").val(),
                    တန်ဖိုးမြင့်: jQuery("input[name=တန်ဖိုးမြင့်]").val(),

                },
                error: function (err) {
                    $.each(err.responseJSON.errors, function (i, error) {
                        currentError.push(error);
                        var el = $(document).find('[name="' + i + '"]');
                        el.after($('<span class="invalid-feedback">' + error[0] + '</span>'));
                        el.addClass('is-invalid');
                    });

                },


                success: function (response) {
                    if (currentError.length <= 0) {
                        $('.update').attr('disabled', 'disabled');
                        var text = `ရွေးချယ်ထားသော ပစ္စည်းများအား ပြင်ဆင်ပြီးပါပြီ`;
                        location.assign(window.location.href)
                        // location_href();


                    } else {
                        alert('Error');
                    }
                    // location_href();

                },

            });
        }

        if (window.performance) {
            localStorage.removeItem('errData');
            if ($('.plus').is(':checked')) {
                document.getElementById("radioButtonPlus").checked = false;
            } else if ($('.minus').is(':checked')) {
                document.getElementById("radioButtonMinus").checked = false;

            }
        }

    </script>
@endpush



