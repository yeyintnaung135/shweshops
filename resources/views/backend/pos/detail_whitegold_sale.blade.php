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
                <div class="row mt-2">
                    <div class="col-4">
                        ​<i class="fa fa-chevron-left text-color" aria-hidden="true" onclick="back()"></i>
                    </div>
                    <div class="col-4 text-center">
                        <h4 class="text-color">ရွှေဖြူအမည်</h4>
                    </div>
                    <div class="offset-2">
                        <h6 class="text-color ml-5">​<i class="fa fa-calendar-check-o mr-1" aria-hidden="true"></i>{{$purchase->purchase->date}}</h6>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-11">
                        <div class="card">
                            <div class="card-body">
                                {{-- <h6 class="text-color">ရွှေထည်အ​ကြောင်းများ</h6> --}}
                                <div class="row mt-3">
                                    <div class="col-7">
                                        <div class="row">
                                            <div class="col-4">
                                              <h6 class="mt-4">စျေးနှုန်း</h6>
                                              <h6 class="mt-4">ရောင်းဈေး</h6>
                                              <h6 class="mt-4">ကျသင့်​ငွေ</h6>

                                              <h6 class="mt-4">Product အလေးချိန်</h6>
                                              <h6 class="mt-4">ဝယ်သူအမည်</h6>
                                              <h6 class="mt-4">ဖုန်းနံပါတ်</h6>
                                              <h6 class="mt-4">​နေရပ်လိပ်စာ</h6>
                                              <h6 class="mt-4">စုစု​ပေါင်းအ​ရေ​အတွက်</h6>
                                              <h6 class="mt-4">Code Number</h6>
                                              <h6 class="mt-4">ရွှေဖြူအမည်</h6>
                                              <h6 class="mt-4">အရည်အသွေး</h6>
                                              <h6 class="mt-4">အမျိုးအစား</h6>
                                              <h6 class="mt-4">Product အမျိုးအစား</h6>
                                              <h6 class="mt-4">ဝယ်ယူသည့်​စျေးနှုန်း</h6>
                                              <h6 class="mt-4">စစ်​ဆေးမည့် ဝန်ထမ်း</h6>
                                              @if ($purchase->purchase->remark)
                                              <h6 class="mt-4">မှတ်ချက်</h6>
                                              @endif
                                              <h6 class="mt-4">ပစ္စည်းအမျိုးအစား</h6>
                                              <h6 class="mt-4">အ​ရောင်</h6>
                                            </div>
                                            <div class="col-1 ">
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
                                              @if ($purchase->purchase->remark)
                                              <h6 class="mt-4">-</h6>
                                              @endif
                                              <h6 class="mt-4">-</h6>
                                              <h6 class="mt-4">-</h6>
                                            </div>
                                            <?php
                                            $profit = explode('/',$purchase->purchase->profit);
                                            ?>
                                            <div class="col-7">
                                                <h6 class="text-color mt-4">{{$purchase->price}} ကျပ်</h6>
                                              <h6 class="text-color mt-4">{{$purchase->amount}} ကျပ်</h6>
                                              <h6 class="text-color mt-4">{{$purchase->amount}} ကျပ်</h6>

                                              <h6 class="text-color mt-4">{{$purchase->purchase->product_weight}} gram</h6>
                                              <h6 class="text-color mt-4">{{$purchase->customer_name}}</h6>
                                              <h6 class="text-color mt-4">{{$purchase->phone}}</h6>
                                              <h6 class="text-color mt-4">{{$purchase->address}}</h6>
                                              <h6 class="text-color mt-4">1</h6>
                                              <h6 class="text-color mt-4">{{$purchase->purchase->code_number}}</h6>

                                              <h6 class="text-color mt-4">{{$purchase->purchase->name}}</h6>
                                              <h6 class="text-color mt-4">{{$purchase->purchase->quality}}</h6>
                                              <h6 class="text-color mt-4">{{$purchase->purchase->whitegold_type}}</h6>
                                              <h6 class="text-color mt-4">{{$purchase->purchase->category->mm_name}}</h6>
                                              <h6 class="text-color mt-4">{{$purchase->purchase->purchase_price}} ကျပ်</h6>
                                              <h6 class="text-color mt-4">{{$purchase->purchase->staff_id}}</h6>
                                              @if ($purchase->purchase->remark)
                                              <h6 class="text-color mt-4">{{$purchase->purchase->remark}}</h6>
                                              @endif
                                              <h6 class="text-color mt-4">
                                                <?php $ischeck = $purchase->purchase->type;?>
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
                                              <h6 class="text-color mt-4">{{$purchase->purchase->color}}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <img src="{{asset('images/pos/whitegoldpurchase_photo/'.$purchase->purchase->photo)}}" alt="">
                                        <div class="mt-5">
                                            <input type="hidden" id="text" value="{{$purchase->purchase->barcode}}"/>
                                            <input type="hidden" id="scan_text" value="{{$purchase->purchase->barcode_text}}"/>
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

                    </div>
                    <div class="col-1">
                        <a href="{{route('backside.shop_owner.pos.edit_wg_purchase',$purchase->purchase->id)}}" class="ml-2 mt-4 btn btn-sm btn-warning text-white"><i class="fa fa-pencil" ></i></a><br>
                        <a class="ml-2 mt-4 btn btn-sm btn-danger" onclick="Delete({{$purchase->id}})"
                            title="Delete">
                            <span class="fa fa-trash"></span>
                            </a>
                        <form id="delete_form_{{$purchase->id}}" action="{{route('backside.shop_owner.pos.delete_wg_sale',$purchase->id)}}" method="POST"
                            style="display: none;">
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
        $(document).ready(function(){

            var barcode_text = $('#scan_text').val();
            var text = $('#text').val();
            $("#showVal").text(barcode_text);
            $("#bcTarget").barcode(text, "code39");

        });

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
                $('#delete_form_'+id).submit();
            }
        });
    }

        function back(){
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

        .badge-color{
        background: #780116;
        color:white;
        font-size:13px;
        padding: 6px 6px;
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

