@extends('layouts.backend.datatable')

@section('content')
    <div class="wrapper">
        @include('layouts.backend.navbar')

        <!-- Main Sidebar Container -->
        @include('layouts.backend.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper sn-background-light-blue">
            <!-- Content Header (Page header) -->
            @if (Session::has('message'))
                <x-alert></x-alert>
            @endif
            <!-- zhheader shopname -->
            {{-- <x-header>
        @foreach ($shopowner as $shopowner)
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
                                    <a href="{{ url('backside/shop_owner/items/create') }}"
                                        class="btn btn-primary float-right"><span
                                            class="fa fa-plus-circle"></span>&nbsp;&nbsp;Add
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
                                            <h2>Today’s Update Products @include('backend.shopowner.toottips')
                                            </h2>
                                            <p>Check your store’s daily updates</p>
                                        </div>
                                        <div class="ml-auto mt-2 d-flex ">
                                            <button class="btn btn-success multi-btn" id="multi-btn">Change Price
                                            </button>
                                            <button class="btn btn-warning setDiscount ml-2" id="set-discount">Set
                                                Discount
                                            </button>
                                            <button class="btn btn-danger multiple_stock  ml-2" id="multipleStock">
                                                Stock
                                            </button>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end my-3 align-items-center">
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>From Date</legend>
                                                <input type="text" id='search_fromdate_item'
                                                    class="itemdatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="form-group mr-md-2">
                                            <fieldset>
                                                <legend>To Date</legend>
                                                <input type="text" id='search_todate_item'
                                                    class="itemdatepicker form-control" placeholder='Choose date'
                                                    autocomplete="off" />
                                            </fieldset>
                                        </div>
                                        <div class="pr-md-4">
                                            <input type='button' id="item_search_button" value="Search"
                                                class="btn bg-info">
                                        </div>
                                    </div>

                                    <table id="itemsTable" class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <td>ID</td>
                                                <td>Discount</td>
                                                <td>Image</td>
                                                <td>Product Code</td>
                                                <td>Price</td>
                                                <td>Action</td>
                                                <td>Date</td>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <td>ID</td>
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
                        <input type="text" name="price" id="first_name" class="form-control" />
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
                                <input class="form-check-input " type="radio" name="oper" value='minus'
                                    id="minus">
                                နှုတ်
                            </div>
                        </div>

                        <div class="col-8 radio-error"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">အလျော့တွက် % : </label>
                        <input type="number" name="အလျော့တွက်" id="first_name" value="" class="form-control " />
                        <span id="error_အလျော့တွက်" class="text-danger d-none">error</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label">လက်ခ % : </label>
                        <input type="text" name="လက်ခ" id="first_name" class="form-control" />
                        <span id="error_လက်ခ" class="text-danger d-none">error</span>

                    </div>
                    <div class="form-group">
                        <label class="control-label">အထည်မပျက်ပြန်သွင်း % : </label>
                        <input type="text" name="undamaged_product" id="first_name" class="form-control" />
                        <span id="error_undamaged_product" class="text-danger d-none">error</span>

                    </div>
                    <div class="form-group">
                        <label class="control-label">အထည်ပျက်စီး ချို့ယွင်း % : </label>
                        <input type="text" name="damaged_product" id="first_name" class="form-control" />
                        <span id="error_အထည်ပျက်စီးချို့ယွင်း" class="text-danger d-none">error</span>

                    </div>
                    <div class="form-group ">
                        <label class="control-label">တန်ဖိုးမြင့် အထည်နှင့်အထည်မပျက်ပြန်လဲ % : </label>
                        <input type="text" name="valuable_product" id="first_name" class="form-control" />
                        <span id="error_valuable_product" class="text-danger d-none sop-font">error</span>

                    </div>
                    <br />
                    <div class="form-group">
                        <button class="btn btn-warning update"> Update</button>
                        <br />
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
                    <form action="{{ route('backside.shop_owner.multiple.stock.items') }}" method="post">
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
                            <span class="font-weight-bolder text-danger multipleCountValidate">In stock count
                                required*</span>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-warning" onclick="multipleStockBtn(this)">Update
                            </button>
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
                    {{--            <form action="{{ route('backside.shop_owner.items.multiple.discount')}}" method="post"> --}}
                    @csrf
                    <div class="hidden-input"></div>
                    <div class="form-group">
                        <label class="control-label ">Percent : </label>
                        <input type="text" name="percent" class="form-control" />
                        <span id="error_percent" class="text-danger d-none">error</span>

                    </div>
                    <br />
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
                        <span aria-hidden="true">&times;</span><br />
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
                        <span aria-hidden="true">&times;</span><br />
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
        $(document).ready(function() {
            var itemsTable = $('#itemsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('backside/shop_owner/items/postexportexcel') }}",
                    'data': function(data) {
                        // Read values
                        var from_date = $('#search_fromdate_item').val() ? $('#search_fromdate_item')
                            .val() + " 00:00:00" : null;
                        var to_date = $('#search_todate_item').val() ? $('#search_todate_item').val() +
                            " 23:59:59" : null;

                        // Append to data
                        data.searchByFromdate = from_date;
                        data.searchByTodate = to_date;
                    }
                },

                columns: [

                    {
                        data: 'id',
                    },
                    {
                        data: 'check_discount',

                        render: function(data, type) {
                            const discount = (data == 0) ? `----` :
                                `<span class="badge bg-success">${data.percent}%</span>`;
                            return discount;
                        }
                    },
                    {

                        data: 'default_photo',
                        render: function(data, type) {
                            const image = `<img src= "{{ url('images/items/' . '${data}') }}"/>`;
                            return image;
                        }
                    },
                    {
                        data: 'product_code'
                    },
                    {
                        data: 'price_formatted',


                    },
                    {
                        data: 'action',
                        render: function(data, type) {
                            var info =
                                `<a style="margin-right: 5px;" class="btn btn-sm btn-success" href="{{ route('backside.shop_owner.items.show', ['item' => ':id']) }}"><span class="fa fa-info-circle"></span></a>`;
                            info = info.replace(':id', data);
                            var edit =
                                `<a class="btn btn-sm btn-primary" href="{{ route('backside.shop_owner.items.edit', ['item' => ':id']) }}"><span class="fa fa-edit"></span></a>`;
                            edit = edit.replace(':id', data);
                            return info + edit;

                        }
                    },
                    {
                        data: 'created_at_formatted'
                    }

                ],
                dom: 'lBfrtip',
                "responsive": true,
                "autoWidth": false,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });

            $(".itemdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#item_search_button').click(function() {
                if ($('#search_fromdate_item').val() != null && $('#search_todate_item').val() != null) {
                    itemsTable.draw();
                }
            });

            $(".itemactdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#itemact_search_button').click(function() {
                if ($('#search_fromdate_itemact').val() != null && $('#search_todate_itemact').val() !=
                    null) {
                    itemsActivityTable.draw();
                }
            });

            $(".mulpriceactdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#mulpriceact_search_button').click(function() {
                if ($('#search_fromdate_mulpriceact').val() != null && $('#search_todate_mulpriceact')
                    .val() != null) {
                    multiplePriceLogsActivityTable.draw();
                }
            });

            $(".muldisactdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#muldisact_search_button').click(function() {
                if ($('#search_fromdate_muldisact').val() != null && $('#search_todate_muldisact').val() !=
                    null) {
                    multipleDiscountActivityTable.draw();
                }
            });

            $(".mulperactdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#mulperact_search_button').click(function() {
                if ($('#search_fromdate_mulperact').val() != null && $('#search_todate_mulperact').val() !=
                    null) {
                    multipleDamageActivityTable.draw();
                }
            });
        });


        function location_href() {
            return window.location.href = "{{ route('backside.shop_owner.items.index') }}";
        }


        $('.success-close').click(function() {
            location_href();
        })


        function get(obj) {
            return document.getElementById(obj);
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
