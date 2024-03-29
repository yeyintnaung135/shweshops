@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Dashboard')

@section('content')
    <div class="wrapper">
        <!-- Navbar -->
        @include('backend.super_admin.navbar')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('backend.super_admin.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <x-alert></x-alert>

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <x-title>Dashboard


                </x-title>

                <div class="col-12 col-md-12">
                    <div class="d-flex justify-content-end my-3 align-items-center">

                        <div class="form-group mr-md-2">
                            <fieldset>
                                <legend>From Date</legend>
                                <input type='text' id='search_fromdate_addtocart' class="dp form-control"
                                    placeholder='Choose date' autocomplete="off">
                            </fieldset>
                        </div>
                        <div class="form-group mr-md-2">
                            <fieldset>
                                <legend>To Date</legend>
                                <input type='text' id='search_todate_addtocart' class="dp form-control"
                                    placeholder='Choose date' autocomplete="off">
                            </fieldset>
                        </div>
                        <div class="pr-md-4">
                            <input type='button' id="addtocart_search_button" value="Search" class="btn bg-info ">
                        </div>
                    </div>

                </div>

            </section>

            <!-- Main content -->
            <section class="content">
                <div class="ml-2 ml-lg-4">
                    <h4 style="">User Counts Based on day
                        <span class="yk-info fa fa-info-circle">
                            <div class="yk-tootips">
                                ရက်ပိုင်းအတွင်းShweShopsကိုအသုံးပြုထားသည့် Users အရေအတွက်
                            </div>
                        </span>
                    </h4>
                    <br>

                </div>
                <div class="ml-2 ml-lg-4">
                    <div class="d-flex flex-wrap align-items-stretch justify-content-start">
                        <div class="sn-card" style="background-color: #4E73F8;color: white;">

                            <div class="card-body">
                                <a href="" style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                    font-size: 1.3rem;
                                ">
                                        Website Viewer</h5>
                                    <p class="card-text" id="viewer"
                                        style="
                                    font-size: 2.1rem;
                                ">
                                        {{ $viewer }}</p>
                                </a>
                            </div>
                        </div>
                        <div class="sn-card" style="background-color: #f84e4e;color: white;">
                            <div class="card-body">
                                <a href="" style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                    font-size: 1.3rem;
                                ">
                                        Ads View</h5>
                                    <p class="card-text" id="adsview"
                                        style="
                                    font-size: 2.1rem;
                                ">
                                        {{ $adsview }}</p>
                                </a>
                            </div>
                        </div>
                        <div class="sn-card" style="background-color:#6ddb09;color: white;">
                            <div class="card-body">
                                <a href="" style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                    font-size: 1.3rem;
                                ">
                                        Shops</h5>
                                    <p class="card-text" id='shop'
                                        style="
                                    font-size: 2.1rem;
                                ">
                                        {{ $shop }}</p>
                                </a>
                            </div>
                        </div>
                        <div class="sn-card" style="background-color: #e64ef8;color: white;">
                            <div class="card-body">
                                <a href="" style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                    font-size: 1.3rem;
                                ">
                                        Shops Viewer</h5>
                                    <p class="card-text" id='shopview'
                                        style="
                                    font-size: 2.1rem;
                                ">
                                        {{ $shopview }}</p>
                                </a>
                            </div>
                        </div>
                        <div class="sn-card" style="background-color: #4E73F8;color: white;">
                            <div class="card-body">
                                <a href="" style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                    font-size: 1.3rem;
                                ">
                                        Buy Now</h5>
                                    <p class="card-text" id='buynow'
                                        style="
                                    font-size: 2.1rem;
                                ">
                                        {{ $buynow }}</p>
                                </a>
                            </div>
                        </div>
                        <div class="sn-card" style="background-color: #f84e4e;color: white;">
                            <div class="card-body">
                                <a href="" style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                    font-size: 1.3rem;
                                ">
                                        Add To Cart</h5>
                                    <p class="card-text" id='addtocart'
                                        style="
                                    font-size: 2.1rem;
                                ">
                                        {{ $addtocart }}</p>
                                </a>
                            </div>
                        </div>
                        <div class="sn-card" style="background-color:#6ddb09;color: white;">
                            <div class="card-body">
                                <a href="" style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                    font-size: 1.3rem;
                                ">
                                        Whishlist</h5>
                                    <p class="card-text" id='whishlist'
                                        style="
                                    font-size: 2.1rem;
                                ">
                                        {{ $whishlist }}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
            <hr>
            <!-- Main content -->
            <section class="content">
                <div class="ml-2 ml-lg-4">
                    <h4 style="">All Unique users counts of all time <span class="yk-info fa fa-info-circle">
                            <div class="yk-tootips">
                                ShweShops ကိုအသုံးပြုထားသည့် မတူညီသော Users အရေအတွက်
                            </div>
                        </span></h4>
                    <br>
                </div>
                <div class="ml-2 ml-lg-4">
                    <div class="d-flex flex-wrap align-items-stretch">
                        <div class="sn-card" style="background-color: #4E73F8;color: white;">

                            <div class="card-body">
                                <a href="" style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                      font-size: 1.3rem;
                                  ">
                                        Website Viewer</h5>
                                    <p class="card-text" id='uqviewer'
                                        style="
                                      font-size: 2.1rem;
                                  ">
                                        {{ $uqviewer }}</p>
                                </a>
                            </div>
                        </div>
                        <div class="sn-card" style="background-color: #f84e4e;color: white;">
                            <div class="card-body">
                                <a href="" style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                      font-size: 1.3rem;
                                  ">
                                        Ads View</h5>
                                    <p class="card-text" id='uqadsview'
                                        style="
                                      font-size: 2.1rem;
                                  ">
                                        {{ $uqadsview }}</p>
                                </a>
                            </div>
                        </div>
                        <div class="sn-card" style="background-color: #e64ef8;color: white;">
                            <div class="card-body">
                                <a href="" style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                      font-size: 1.3rem;
                                  ">
                                        Shops Viewer</h5>
                                    <p class="card-text" id='uqshopview'
                                        style="
                                      font-size: 2.1rem;
                                  ">
                                        {{ $uqshopview }}</p>
                                </a>
                            </div>
                        </div>
                        <div class="sn-card" style="background-color: #6ddb09;color: white;">
                            <div class="card-body">
                                <a href="" style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                      font-size: 1.3rem;
                                  ">
                                        All Register Users</h5>
                                    <p class="card-text" id='registercount'
                                        style="font-size: 2.1rem;
                                  ">
                                        {{ $register }}</p>
                                </a>
                            </div>
                        </div>
                        <div class="sn-card" style="background-color: #4E73F8;color: white;">
                            <div class="card-body">
                                <a href="" style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                      font-size: 1.3rem;
                                  ">
                                        Buy Now</h5>
                                    <p class="card-text" id='uqbuynow'
                                        style="
                                      font-size: 2.1rem;
                                  ">
                                        {{ $uqbuynow }}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
            <hr>
            <!-- Main content -->
            <section class="content">
                <div class="ml-2 ml-lg-4">
                    <h4 style="">All users counts of all time <span class="yk-info fa fa-info-circle">
                            <div class="yk-tootips">

                                ShweShops ကိုအသုံးပြုထားသည့် Users များ ၏ အကြိမ်အရေအတွက်နှင့်အသေးစိတ်မှတ်တမ်း</div>
                        </span></h4>
                    <br>
                </div>
                <div class="ml-2 ml-lg-4">
                    <div class="d-flex flex-wrap align-items-stretch">
                        <div class="sn-card" style="background-color: #4E73F8;color: white;">

                            <div class="card-body">
                                <a href="{{ route('backside.super_admin.visitorcount.all') }}" style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                      font-size: 1.3rem;
                                  ">
                                        Website Viewer</h5>
                                    <p class="card-text" id='allviewers'
                                        style="
                                      font-size: 2.1rem;
                                  ">
                                        {{ $allviewers }}</p>
                                </a>
                            </div>
                        </div>
                        <div class="sn-card" style="background-color: #f84e4e;color: white;">
                            <div class="card-body">
                                <a href="{{ route('backside.super_admin.adscount.all') }}" style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                      font-size: 1.3rem;
                                  ">
                                        Ads View</h5>
                                    <p class="card-text" id='alladsviewers'
                                        style="
                                      font-size: 2.1rem;
                                  ">
                                        {{ $alladsviewers }}</p>
                                </a>
                            </div>
                        </div>
                        <div class="sn-card" style="background-color: #e64ef8;color: white;">
                            <div class="card-body">
                                <a href="{{ route('backside.super_admin.shopviewercount.all') }}" style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                      font-size: 1.3rem;
                                  ">
                                        Shops Viewer</h5>
                                    <p class="card-text" id='allshopviewers'
                                        style="
                                      font-size: 2.1rem;
                                  ">
                                        {{ $allshopviewers }}</p>
                                </a>
                            </div>
                        </div>
                        <div class="sn-card" style="background-color: #4E73F8;color: white;">
                            <div class="card-body">
                                <a href="{{ route('backside.super_admin.buynowcount.all') }}" style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                      font-size: 1.3rem;
                                  ">
                                        Buy Now</h5>
                                    <p class="card-text" id='allbuynow'
                                        style="
                                      font-size: 2.1rem;
                                  ">
                                        {{ $allbuynow }}</p>
                                </a>
                            </div>
                        </div>
                        <div class="sn-card" style="background-color: #f84e4e;color: white;">
                            <div class="card-body">
                                <a href="{{ url('backside/super_admin/addtocartcount/all') }}" style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                      font-size: 1.3rem;
                                  ">
                                        Add To Cart</h5>
                                    <p class="card-text" id='alladdtocart'
                                        style="
                                      font-size: 2.1rem;
                                  ">
                                        {{ $addtocart }}</p>
                                </a>
                            </div>
                        </div>
                        <div class="sn-card" style="background-color:#6ddb09;color: white;">
                            <div class="card-body">
                                <a href="{{ url('backside/super_admin/wishlistcount/all') }}" style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                      font-size: 1.3rem;
                                  ">
                                        Whishlist</h5>
                                    <p class="card-text" id='allwhishlist'
                                        style="
                                      font-size: 2.1rem;
                                  ">
                                        {{ $whishlist }}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
            <hr>
            <!-- Main content -->
            <section class="content">
                <div class="ml-2 ml-lg-4">
                    <h4 style="">New Users <span class="yk-info fa fa-info-circle">
                            <div class="yk-tootips">
                                ShweShops ကိုအသုံးပြုထားသည့် Users အသစ်အရေအတွက်</div>
                        </span></h4>
                    <br>
                </div>
                <div class="ml-2 ml-lg-4">
                    <div class="d-flex flex-wrap align-items-stretch">
                        <div class="sn-card" style="background-color: #4E73F8;color: white;">

                            <div class="card-body">
                                <a style="color: #ffffff;">
                                    <h5 class="card-title"
                                        style="
                                      font-size: 1.3rem;
                                  ">
                                        New Users</h5>
                                    <p class="card-text" id='newusers'
                                        style="
                                      font-size: 2.1rem;
                                  ">
                                        {{ $newusers }}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- /.content -->
    </div>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
@endsection

@push('css')
    <style>
        .sn-card {
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            width: 30%;
            margin: 10px;
            word-wrap: break-word;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: 0.25rem;
        }

        @media only screen and (max-width: 600px) {
            .sn-card {
                margin: 5px;
                width: 45%;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {


            $(".dp").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });
            $('#addtocart_search_button').click(function() {
                if ($('#search_fromdate_addtocart').val() != '' && $('#search_todate_addtocart').val() !=
                    '') {
                    $.post("{{ url('backside/super_admin/all_counts') }}", {
                            from: $('#search_fromdate_addtocart').val() + " 00:00:00",
                            to: $('#search_todate_addtocart').val() + " 23:59:59",
                            _token: "{{ csrf_token() }}"
                        },
                        function(data, status) {
                            $('#newusers').html(data.newusers);
                            $('#addtocart').html(data.addtocart);
                            $('#alladdtocart').html(data.addtocart);
                            $('#adsview').html(data.adsview);
                            $('#alladsviewers').html(data.alladsviewers);
                            $('#allbuynow').html(data.allbuynow);
                            $('#allshopviewers').html(data.allshopviewers);
                            $('#allviewers').html(data.allviewers);
                            $('#buynow').html(data.buynow);
                            $('#shop').html(data.shop);
                            $('#shopview').html(data.shopview);
                            $('#uqadsview').html(data.uqadsview);
                            $('#registercount').html(data.register);
                            $('#uqbuynow').html(data.uqbuynow);
                            $('#uqshopview').html(data.uqshopview);
                            $('#uqviewer').html(data.uqviewer);
                            $('#viewer').html(data.viewer);
                            $('#whishlist').html(data.whishlist);
                            $('#allwhishlist').html(data.whishlist);
                        });
                }
            });
        });
    </script>
@endpush
