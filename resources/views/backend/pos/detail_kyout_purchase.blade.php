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
                            <h4 class="text-color">​စိန်​ကျောက်ထည်အမည်</h4>
                        </div>
                        <div class="offset-2">
                            <h6 class="text-color ml-5">​<i class="fa fa-calendar-check-o mr-1"
                                    aria-hidden="true"></i>{{ $purchase->date }}</h6>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-11">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mt-3">
                                        <div class="col-7">
                                            <div class="row">
                                                <div class="col-5">
                                                    <h6 class="mt-4">ရွှေဘိုး</h6>
                                                    <h6 class="mt-4">အရင်း​</h6>
                                                    <h6 class="mt-4">ရောင်းဈေး</h6>
                                                    <h6 class="mt-4">စိန်​ကျောက်ဖိုးအ​ရောင်း</h6>
                                                    <h6 class="mt-4">အမြတ်</h6>
                                                    <h6 class="mt-4">လက်ခ</h6>
                                                    <h6 class="mt-4">အလျော့တွက်</h6>
                                                    <h6 class="mt-4">ပစ္စည်းအလေးချိန်</h6>
                                                    <h6 class="mt-4">စိန်​ကျောက်ချိန်</h6>
                                                    <h6 class="mt-4">Code Number</h6>
                                                    <h6 class="mt-4">ရွှေထည်အမည်</h6>
                                                    <h6 class="mt-4">ပန်းထိမ်ဆိုင်</h6>
                                                    <h6 class="mt-4">ရွှေအရည်အသွေး</h6>
                                                    <h6 class="mt-4">ရွှေအမျိုးအစား</h6>
                                                    <h6 class="mt-4">Product အမျိုးအစား</h6>
                                                    <h6 class="mt-4">ဝယ်ယူသည့်​စျေးနှုန်း</h6>
                                                    <h6 class="mt-4">စစ်​ဆေးမည့် ဝန်ထမ်း</h6>
                                                    <h6 class="mt-4">စိန်​ကျောက်အမည်</h6>
                                                    @if ($purchase->remark)
                                                        <h6 class="mt-4">မှတ်ချက်</h6>
                                                    @endif
                                                    <h6 class="mt-4">ပစ္စည်းအမျိုးအစား</h6>
                                                    <h6 class="mt-4">အ​ရောင်</h6>
                                                </div>
                                                <div class="col-1">
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
                                                    <h6 class="mt-4">-</h6>
                                                    <h6 class="mt-4">-</h6>
                                                    @if ($purchase->remark)
                                                        <h6 class="mt-4">-</h6>
                                                    @endif
                                                    <h6 class="mt-4">-</h6>
                                                    <h6 class="mt-4">-</h6>
                                                </div>
                                                <?php
                                                $product = explode('/', $purchase->gold_gram_kyat_pe_yway);
                                                $diamond = explode('/', $purchase->diamond_gram_kyat_pe_yway);
                                                $decrease = explode('/', $purchase->decrease_pe_yway);
                                                $profit = explode('/', $purchase->profit);
                                                $service = explode('/', $purchase->service_fee);
                                                ?>
                                                <div class="col-6">
                                                    <h6 class="text-color mt-4">{{ $purchase->gold_fee }} ကျပ်</h6>
                                                    <h6 class="text-color mt-4">{{ $purchase->capital }} ကျပ်</h6>
                                                    <h6 class="text-color mt-4">{{ $purchase->selling_price }} ကျပ်</h6>
                                                    <h6 class="text-color mt-4">{{ $purchase->diamond_selling_price }} ကျပ်
                                                    </h6>
                                                    <h6 class="text-color mt-4">{{ $profit[0] }}</h6>
                                                    <h6 class="text-color mt-4">{{ $service[0] }}</h6>
                                                    <h6 class="text-color mt-4">{{ $decrease[0] ? $decrease[0] . 'ပဲ' : '' }}
                                                        {{ $decrease[1] ? $decrease[1] . 'ရွေး' : '' }}</h6>
                                                    <h6 class="text-color mt-4">{{ $product[1] ? $product[1] . 'ကျပ်' : '' }}
                                                        {{ $product[2] ? $product[2] . 'ပဲ' : '' }}
                                                        {{ $product[3] ? $product[3] . 'ရွေး' : '' }}</h6>
                                                    <h6 class="text-color mt-4">{{ $diamond[1] ? $diamond[1] . 'ကျပ်' : '' }}
                                                        {{ $diamond[2] ? $diamond[2] . 'ပဲ' : '' }}
                                                        {{ $diamond[3] ? $diamond[3] . 'ရွေး' : '' }}</h6>
                                                    <h6 class="text-color mt-4">{{ $purchase->code_number }}</h6>
                                                    <h6 class="text-color mt-4">{{ $purchase->gold_name }}</h6>
                                                    <h6 class="text-color mt-4">{{ $purchase->supplier->name }}</h6>
                                                    <h6 class="text-color mt-4">{{ $purchase->quality->name }}</h6>
                                                    <h6 class="text-color mt-4">{{ $purchase->gold_type }}</h6>
                                                    <h6 class="text-color mt-4">{{ $purchase->category->name }}</h6>
                                                    <h6 class="text-color mt-4">{{ $purchase->purchase_price }} ကျပ်</h6>
                                                    <h6 class="text-color mt-4">{{ $purchase->staff_id }}</h6>
                                                    <h6 class="text-color mt-4">{{ $purchase->diamonds }}</h6>
                                                    @if ($purchase->remark)
                                                        <h6 class="text-color mt-4">{{ $purchase->remark }}</h6>
                                                    @endif
                                                    <h6 class="text-color mt-4">
                                                        <?php $ischeck = $purchase->type; ?>
                                                        @if ($ischeck == 'option1')
                                                            <span class="badge badge-color ml-2">​​မိန်းမဝတ်</span>
                                                        @endif
                                                        @if ($ischeck == 'option2')
                                                            <span class="badge badge-color ml-2">​ယောကျားဝတ်</span>
                                                        @endif
                                                        @if ($ischeck == 'option3')
                                                            <span class="badge badge-color ml-2">unisex</span>
                                                        @endif
                                                        @if ($ischeck == 'option4')
                                                            <span class="badge badge-color ml-2">​က​လေးဝတ်</span>
                                                        @endif
                                                    </h6>
                                                    <h6 class="text-color mt-4">{{ $purchase->color }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            @if (dofile_exists('main/images/pos/kyoutpurchase_photo/' . $purchase->photo))
                                                <img src="{{ url('/pos/kyoutpurchase_photo/' . $purchase->photo) }}" />
                                            @else
                                                <img
                                                    src="{{ filedopath('/pos/kyoutpurchase_photo/' . $purchase->photo) }}" />
                                            @endif

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
                                <h6 class="text-color">ရွှေထည်​နှင့်​ကျောက်ထည်စျေးနှုန်းတွက်ချက်ခြင်း</h6>
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
                            <a href="{{ route('backside.shop_owner.pos.edit_kyout_purchase', $purchase->id) }}"
                                class="ml-2 mt-4 btn btn-sm btn-warning text-white"><i class="fa fa-pencil"></i></a><br>
                            @if ($purchase->sell_flag == 0)
                                <a class="btn btn-sm btn-danger text-white mt-3 ml-2"
                                    onclick="Delete('{{ route('backside.shop_owner.pos.delete_kyout_purchase', ['purchase' => $purchase]) }}')">
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

        .badge-color {
            background: #780116;
            color: white;
            font-size: 13px;
            padding: 6px 6px;
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
            background-color: #D4AF37;
        }

        .card-color1 {
            background-color: #780116;
        }
    </style>
@endpush
