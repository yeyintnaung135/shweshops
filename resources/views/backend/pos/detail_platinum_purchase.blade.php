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
                            <h4 class="text-color">​ပလက်တီနမ်အမည်</h4>
                        </div>
                        <div class="offset-2">
                            <h6 class="text-color ml-5">​<i class="fa fa-calendar-check-o mr-1"
                                    aria-hidden="true"></i>{{ $purchase->date }}</h6>
                        </div>
                    </div>
                    <?php
                    $profit = explode('/', $purchase->profit);
                    ?>
                    <div class="row mt-3">
                        <div class="col-11">
                            <div class="card">
                                <div class="card-body">
                                    {{-- <h6 class="text-color">ရွှေထည်အ​ကြောင်းများ</h6> --}}
                                    <div class="row mt-3">
                                        <div class="col-7">
                                            <div class="row">
                                                    <div class="col-12">
                                                        <table cellspacing="0" cellpadding="0" style="border: none;">
                                                            <tr>
                                                                <td style="border: none;">ရောင်းဈေး</td>
                                                                <td>-</td>
                                                                <td><span class="text-color ">{{ $purchase->selling_price }}
                                                                        ကျပ်</span>
                                                                </td>


                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;">အရင်း​</td>
                                                                <td>-</td>
                                                                <td><span class="text-color ">{{ $purchase->capital }}
                                                                        ကျပ်</span>
                                                                </td>


                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;">အမြတ်</td>
                                                                <td>-</td>
                                                                <td><span class="text-color ">{{ $profit[0] }}
                                                                        {{ $profit[1] }} ကျပ်</span>
                                                                </td>


                                                            </tr>

                                                            <tr>
                                                                <td style="border: none;">Product အလေးချိန်</td>
                                                                <td>-</td>
                                                                <td><span class="text-color ">
                                                                        {{ $purchase->product_weight }} gram
                                                                    </span>
                                                                </td>


                                                            </tr>

                                                            <tr>
                                                                <td style="border: none;">Code Number</td>
                                                                <td>-</td>
                                                                <td><span class="text-color ">
                                                                        {{ $purchase->code_number }}
                                                                    </span>
                                                                </td>


                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;">​ပလက်တီနမ်အမည်</td>
                                                                <td>-</td>
                                                                <td><span class="text-color ">
                                                                        {{ $purchase->name }}</span>
                                                                </td>


                                                            </tr>

                                                            <tr>
                                                                <td style="border: none;">​ပလက်တီနမ်အရည်အသွေး</td>
                                                                <td>-</td>
                                                                <td><span class="text-color ">
                                                                        {{ $purchase->quality }}</span>
                                                                </td>


                                                            </tr>

                                                            <tr>
                                                                <td style="border: none;">​ပလက်တီနမ်အမျိုးအစား</td>
                                                                <td>-</td>
                                                                <td><span class="text-color ">
                                                                        {{ $purchase->platinum_type }}</span> </span>
                                                                </td>


                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;">Product အမျိုးအစား</td>
                                                                <td>-</td>
                                                                <td><span class="text-color ">
                                                                        {{ $purchase->category->name }}</span> </span>
                                                                </td>


                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;">ဝယ်ယူသည့်​စျေးနှုန်း</td>
                                                                <td>-</td>
                                                                <td><span class="text-color ">
                                                                        {{ $purchase->purchase_price }}</span> </span>
                                                                </td>


                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;">စစ်​ဆေးမည့် ဝန်ထမ်း</td>
                                                                <td>-</td>
                                                                <td><span class="text-color ">
                                                                        {{ $purchase->staff_id }}</span> </span>
                                                                </td>


                                                            </tr>
                                                            @if ($purchase->remark)
                                                                <tr>
                                                                    <td style="border: none;">မှတ်ချက်</td>
                                                                    <td>-</td>
                                                                    <td><span class="text-color ">
                                                                            {{ $purchase->remark }}</span> </span>
                                                                    </td>


                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td style="border: none;">ပစ္စည်းအမျိုးအစား</td>
                                                                <td>-</td>
                                                                <td><?php $ischeck = $purchase->type; ?>
                                                                    @if ($ischeck == 'option1')
                                                                        <span class="badge badge-color">​​မိန်းမဝတ်</span>
                                                                    @endif
                                                                    @if ($ischeck == 'option2')
                                                                        <span class="badge badge-color">​ယောကျားဝတ်</span>
                                                                    @endif
                                                                    @if ($ischeck == 'option3')
                                                                        <span class="badge badge-color">unisex</span>
                                                                    @endif
                                                                    @if ($ischeck == 'option4')
                                                                        <span class="badge badge-color">​က​လေးဝတ်</span>
                                                                    @endif </span>
                                                                </td>


                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;">အ​ရောင်</td>

                                                                <td>-</td>
                                                                <td><span class="text-color ">
                                                                        {{ $purchase->color }}</span> </span>
                                                                </td>


                                                            </tr>

                                                        </table>

                                                    </div>




                                            </div>
                                        </div>
                                        <div class="col-5">
                                            @if (dofile_exists('main/images/pos/platinumpurchase_photo/' . $purchase->photo))
                                                <img src="{{ url('/pos/platinumpurchase_photo/' . $purchase->photo) }}" />
                                            @else
                                                <img
                                                    src="{{ filedopath('/pos/platinumpurchase_photo/' . $purchase->photo) }}" />
                                            @endif
                                            <!-- <img src="{{ asset('images/pos/platinumpurchase_photo/' . $purchase->photo) }}" alt=""> -->
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
                                <h6 class="text-color">ရွှေထည်​စျေးနှုန်းတွက်ချက်ခြင်း</h6>
                                <div class="row mt-3">
                                    <div class="col-7">

                                        <div class="row">
                                            <div class="col-4">




                                            </div>
                                            <div class="col-1">
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
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
                            <a href="{{ route('backside.shop_owner.pos.edit_ptm_purchase', $purchase->id) }}"
                                class="ml-2 mt-4 btn btn-sm btn-warning text-white"><i class="fa fa-pencil"></i></a><br>
                            @if ($purchase->sell_flag == 0)
                                <a class="btn btn-sm btn-danger text-white mt-3 ml-2"
                                    onclick="Delete('{{ route('backside.shop_owner.pos.delete_ptm_purchase', ['purchase' => $purchase]) }}')">
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

        .badge-color {
            background: #780116;
            color: white;
            font-size: 13px;
            padding: 6px 6px;
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
