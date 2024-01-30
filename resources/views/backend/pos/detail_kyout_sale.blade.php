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
                    <div class="row mt-2">
                        <div class="col-4">
                            ​<i class="fa fa-chevron-left text-color" aria-hidden="true" onclick="back()"></i>
                        </div>
                        <div class="col-4 text-center">
                            <h4 class="text-color">စိန်​​ကျောက်ထည်အမည်</h4>
                        </div>
                        <div class="offset-2">
                            <h6 class="text-color ml-5">​<i class="fa fa-calendar-check-o mr-1"
                                    aria-hidden="true"></i>{{ $purchase->date }}</h6>
                        </div>
                    </div>
                    <?php
                    $product = explode('/', $purchase->purchase->product_weight);
                    $diamond = explode('/', $purchase->purchase->diamond_gram_kyat_pe_yway);
                    $decrease = explode('/', $purchase->purchase->decrease_pe_yway);
                    $profit = explode('/', $purchase->purchase->profit);
                    $service = explode('/', $purchase->purchase->service_fee);
                    ?>
                    <div class="row mt-3">
                        <div class="col-11">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="text-color">စိန်​​ကျောက်ထည်အ​ကြောင်းများ</h6>
                                    <div class="row mt-3">
                                        <div class="col-7">
                                            <div class="row">
                                                <div class="col-12">
                                                    <table>
                                                        <tr>
                                                            <td style="border: none;">စျေးနှုန်း</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $purchase->price }} ကျပ်</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">စိန်​​ကျောက်ဖိုး</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $purchase->purchase->diamond_selling_price }}
                                                                    ကျပ်</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">ရောင်းဈေး</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $purchase->amount }} ကျပ်</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">ကျသင့်​ငွေ</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $purchase->purchase->purchase_price }}
                                                                    ကျပ်</span>
                                                            </td>


                                                        </tr>

                                                        @if ($purchase->return_price)
                                                            <tr>
                                                                <td style="border: none;">လဲမည့် တန်ဖိုး</td>
                                                                <td>-</td>
                                                                <td><span class="text-color ">
                                                                        {{ $purchase->return_price }} ကျပ်</span>
                                                                </td>


                                                            </tr>
                                                        @endif
                                                        @if ($purchase->left_price)
                                                            <tr>
                                                                <td style="border: none;">ကျန်​ငွေ</td>
                                                                <td>-</td>
                                                                <td><span class="text-color ">
                                                                        {{ $purchase->left_price }}
                                                                        ကျပ်</span>
                                                                </td>


                                                            </tr>
                                                        @endif
                                                        <tr>
                                                            <td style="border: none;">အမြတ်</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $profit[0] }}
                                                                    ကျပ်</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">လက်ခ</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $service[0] }}
                                                                    ကျပ်</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">​ရွှေစင်ချိန်</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $product[1] ? $product[1] . 'ကျပ်' : '' }}
                                                                    {{ $product[2] ? $product[2] . 'ပဲ' : '' }}
                                                                    {{ $product[3] ? $product[3] . 'ရွေး' : '' }}</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">စိန်​​ကျောက်ချိန်</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $diamond[1] ? $diamond[1] . 'ကျပ်' : '' }}
                                                                    {{ $diamond[2] ? $diamond[2] . 'ပဲ' : '' }}
                                                                    {{ $diamond[3] ? $diamond[3] . 'ရွေး' : '' }}</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">အလျော့တွက်</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $decrease[0] ? $decrease[0] . 'ပဲ' : '' }}
                                                                    {{ $decrease[1] ? $decrease[1] . 'ရွေး' : '' }}</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">ဝယ်သူအမည်</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $purchase->customer_name }}</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">ဖုန်းနံပါတ်</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $purchase->phone }}</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">​နေရပ်လိပ်စာ</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $purchase->address }}</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">Code Number</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $purchase->purchase->code_number }}</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">ရွှေထည်အမည်</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $purchase->purchase->purchase_price }}
                                                                    ကျပ်</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">စုစု​ပေါင်းအ​ရေ​အတွက်</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    1</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">ပန်းထိမ်ဆိုင်</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $purchase->purchase->supplier->name }}</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">ရွှေအရည်အသွေး</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $purchase->purchase->quality->name }}</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">ရွှေအမျိုးအစား</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $purchase->purchase->gold_type }}</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">Product အမျိုးအစား</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $purchase->purchase->category->name }}</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">ဝယ်ယူသည့်​စျေးနှုန်း</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $purchase->purchase->purchase_price }}
                                                                    ကျပ်</span>
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td style="border: none;">စစ်​ဆေးမည့် ဝန်ထမ်း</td>
                                                            <td>-</td>
                                                            <td><span class="text-color ">
                                                                    {{ $purchase->staff_id }}</span>
                                                            </td>


                                                        </tr>
                                                        @if ($purchase->remark)
                                                            <tr>
                                                                <td style="border: none;">မှတ်ချက်</td>
                                                                <td>-</td>
                                                                <td><span class="text-color ">
                                                                        {{ $purchase->remark }}</span>
                                                                </td>


                                                            </tr>
                                                        @endif



                                                    </table>
                                                </div>



                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <img src="{{ asset('images/pos/kyoutpurchase_photo/' . $purchase->purchase->photo) }}"
                                                alt="">
                                            <div class="mt-5">
                                                <input type="hidden" id="text"
                                                    value="{{ $purchase->purchase->barcode }}" />
                                                <input type="hidden" id="scan_text"
                                                    value="{{ $purchase->purchase->barcode_text }}" />
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
                            <a href="{{ route('backside.shop_owner.pos.edit_kyoutsale', $purchase->id) }}"
                                class="ml-2 mt-4 btn btn-sm btn-warning text-white"><i class="fa fa-pencil"></i></a><br>
                            <a class="ml-2 mt-4 btn btn-sm btn-danger" onclick="Delete({{ $purchase->id }})"
                                title="Delete">
                                <span class="fa fa-trash"></span>
                            </a>
                            <form id="delete_form_{{ $purchase->id }}"
                                action="{{ route('backside.shop_owner.pos.delete_kyoutsale', $purchase->id) }}"
                                method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
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
        $(document).ready(function() {

            var barcode_text = $('#scan_text').val();
            var text = $('#text').val();
            $("#showVal").text(barcode_text);
            $("#bcTarget").barcode(text, "code39");

        });

        function addBarcodeText(val) {
            $('#scan_text').val(val);
        }

        function fill_capital(val) {
            $('#capital').val(val);
        }

        function check_barcode() {
            if ($('#print_barcode').is(':checked')) {
                var code = $('#code_number').val();
                var gram = $('#product_weight').val();

                var barcode_text = $('#barcode_text').val();
                if (code == '' || gram == '') {
                    swal({
                        title: "Warning!",
                        text: "You need to fill code number or product's gram!",
                        icon: "warning",
                    });
                } else {
                    $('#text').val(code + '-' + gram);
                    $('#scan_text').val(barcode_text);
                    $('#print_barcode').val(1);
                    $('#barcode_convert').show();
                    $('#text_barcode').show();

                }
            } else {
                $('#barcode_convert').hide();
                $('#text_barcode').hide();
            }

        }

        function Delete(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-danger ml-2',
                    cancelButton: 'btn btn-info'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Check if "Confirm" button was clicked
                    $('#delete_form_' + id).submit();
                }
            });
        }

        function back() {
            history.go(-1);
        }
    </script>
@endpush
@push('css')
    <style>
        table,
        tr,
        td {
            border: none;

        }

        table {
            width: 90% !important;
        }

        body {
            background: #F0F7FA;
            font-family: 'Myanmar3', Sans-Serif !important;
        }

        .btn-color {
            background: #780116;
            color: white;
            padding: 5px 25px;
        }

        .btn-color:hover {
            color: white;
        }

        .text-color {
            color: #780116;
        }

        .badge-color {
            background: #780116;
            color: white;
            font-size: 13px;
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

        .form-check-label {
            font-size: 20px;
        }

        .card-color {
            background-color: #D4AF37;
        }

        .card-color1 {
            background-color: #780116;
        }
    </style>
@endpush
