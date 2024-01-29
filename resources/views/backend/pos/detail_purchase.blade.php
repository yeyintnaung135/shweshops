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
                            <h4 class="text-color">​ရွှေထည်အမည်</h4>
                        </div>
                        <div class="offset-2">
                            <h6 class="text-color ml-5">​<i class="fa fa-calendar-check-o mr-1"
                                    aria-hidden="true"></i>{{ $purchase->date }}</h6>
                        </div>
                    </div>
                    <?php
                    $product = explode('/', $purchase->product_weight);
                    $decrease = explode('/', $purchase->decrease_pe_yway);
                    $profit = explode('/', $purchase->profit);
                    $service = explode('/', $purchase->service_fee);
                    ?>
                    <div class="row mt-3">
                        <div class="col-11">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="text-color">ရွှေထည်အ​ကြောင်းများ</h6>
                                    <div class="row mt-3">
                                        <div class="col-7">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="mt-4">ရောင်းဈေး - {{ $purchase->selling_price }} ကျပ် </h6>
                                                    <h6 class="mt-4">ရွှေဘိုး - {{ $purchase->gold_fee }} ကျပ်</h6>
                                                    <h6 class="mt-4">အမြတ် - {{ $profit[0] }}</h6>
                                                    <h6 class="mt-4">လက်ခ - {{ $service[0] }}</h6>
                                                    <h6 class="mt-4">Product အလေးချိန် -
                                                        {{ $product[1] ? $product[1] . 'ကျပ်' : '' }}
                                                        {{ $product[2] ? $product[2] . 'ပဲ' : '' }}
                                                        {{ $product[3] ? $product[3] . 'ရွေး' : '' }}</h6>
                                                    <h6 class="mt-4">အလျော့တွက် -
                                                        {{ $decrease[0] ? $decrease[0] . 'ပဲ' : '' }}
                                                        {{ $decrease[1] ? $decrease[1] . 'ရွေး' : '' }}</h6>
                                                    <h6 class="mt-4">Code Number - {{ $purchase->code_number }}</h6>
                                                    <h6 class="mt-4">ရွှေထည်အမည် - {{ $purchase->name }}</h6>
                                                    <h6 class="mt-4">ပန်းထိမ်ဆိုင် @if (!empty($purchase->supplier->name))
                                                            - {{ $purchase->supplier->name }}
                                                        @else
                                                            Deleted </h6>
                                                    <h6 class="mt-4">ရွှေအရည်အသွေး - {{ $purchase->quality->name }}</h6>
                                                    <h6 class="mt-4">ရွှေအမျိုးအစား - {{ $purchase->gold_type }}</h6>
                                                    <h6 class="mt-4">Product အမျိုးအစား - {{ $purchase->category->name }}
                                                    </h6>
                                                    <h6 class="mt-4">ဝယ်ယူသည့်​စျေးနှုန်း -
                                                        {{ $purchase->purchase_price }} ကျပ်</h6>
                                                    <h6 class="mt-4">စစ်​ဆေးမည့် ဝန်ထမ်း - {{ $purchase->staff_id }}</h6>
                                                    @if ($purchase->remark)
                                                        <h6 class="mt-4">မှတ်ချက် - {{ $purchase->remark }}</h6>
                                                    @endif
                                                    <?php $ischeck=$purchase->type;?>
                                                    <h6 class="mt-4">ပစ္စည်းအမျိုးအစား -
                                                        @if ($ischeck == 'option1')
                                                            ​​မိန်းမဝတ်
                                                        @endif
                                                        @if ($ischeck == 'option2')
                                                            ​ယောကျားဝတ်
                                                        @endif
                                                        @if ($ischeck == 'option3')
                                                            unisex
                                                        @endif
                                                        @if ($ischeck == 'option4')
                                                            ​က​လေးဝတ်
                                                        @endif
                                                    </h6>
                                                    <h6 class="mt-4">အ​ရောင် - {{ $purchase->color }}</h6>
                                                </div>
                                               
                                                <div class="col-7 mt-4">
                                           

                                                    <h6 class="text-color mt-4"></h6>
                                                    @endif
                                                    <h6 class="text-color mt-4"></h6>
                                                    <h6 class="text-color mt-4"></h6>
                                                    <h6 class="text-color mt-4"></h6>
                                                    <h6 class="text-color mt-4"></h6>
                                                    <h6 class="text-color mt-4"></h6>
                                            
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            @if (dofile_exists('main/images/pos/goldpurchase_photo/' . $purchase->photo))
                                                <img src="{{ url('/pos/goldpurchase_photo/' . $purchase->photo) }}" />
                                            @else
                                                <img
                                                    src="{{ filedopath('/pos/goldpurchase_photo/' . $purchase->photo) }}" />
                                            @endif
                                            <!-- <img src="{{ asset('images/pos/goldpurchase_photo/' . $purchase->photo) }}" alt=""> -->
                                            <div class="mt-5">
                                                <input type="hidden" id="text" value="{{ $purchase->barcode }}" />
                                                <input type="hidden" id="scan_text"
                                                    value="{{ $purchase->barcode_text }}" />
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
                            <a href="{{ route('backside.shop_owner.pos.edit_purchase', $purchase->id) }}"
                                class="ml-2 mt-4 btn btn-sm btn-warning text-white"><i class="fa fa-pencil"></i></a><br>
                            @if ($purchase->sell_flag == 0)
                                <a class="btn btn-sm btn-danger text-white mt-3 ml-2"
                                    onclick="Delete('{{ route('backside.shop_owner.pos.delete_purchase', ['purchase' => $purchase]) }}')">
                                    <i class="fa fa-trash"></i>
                                </a>
                                <form id="delete_form_{{ $purchase->id }}" method="POST" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
                            @endif
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

        function Delete(deleteUrl) {
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
                    const deleteForm = document.createElement('form');
                    deleteForm.action = deleteUrl;
                    deleteForm.method = 'POST';
                    deleteForm.style.display = 'none';
                    deleteForm.innerHTML = `
                    @csrf
                    @method('DELETE')`;
                    document.body.appendChild(deleteForm);
                    deleteForm.submit();
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
