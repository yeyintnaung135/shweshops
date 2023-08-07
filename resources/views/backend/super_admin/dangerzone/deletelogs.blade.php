@extends('layouts.backend.super_admin.datatable')
@section('title', 'MOE Admin Team | Delete Logs')

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
                <x-title>Delete Logs


                </x-title>
                <div class="row g-0">
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-center mt-md-4 ml-3">
                        <h4>&nbsp;ALL Logs Count : <span id="totalcount">{{$alllogscount}}</span></h4>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                   
                    <div class="d-flex justify-content-end my-3 align-items-center">
                      
                        <div class="form-group mr-md-2">
                            &nbsp;
                        </div>
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
                            <input type='button' id="addtocart_search_button" value="Delete" class="btn bg-danger "
                                data-toggle="modal" data-target="#exampleModalCenter">
                        </div>
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
                                        {{ count($viewer) }}</p>
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
                                        {{ count($adsview) }}</p>
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
                                        {{ count($shop) }}</p>
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
                                        {{ count($shopview) }}</p>
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
                                        {{ count($buynow) }}</p>
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
                                        {{ count($addtocart) }}</p>
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
                                        {{ count($whishlist) }}</p>
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
                                        {{ count($uqviewer) }}</p>
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
                                        {{ count($uqadsview) }}</p>
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
                                        {{ count($uqshopview) }}</p>
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
                                        {{ count($register) }}</p>
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
                                        {{ count($uqbuynow) }}</p>
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
                                <a href="{{ route('visitorcount.all') }}" style="color: #ffffff;">
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
                                <a href="{{ route('adscount.all') }}" style="color: #ffffff;">
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
                                <a href="{{ route('shopviewercount.all') }}" style="color: #ffffff;">
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
                                <a href="{{ route('buynowcount.all') }}" style="color: #ffffff;">
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
                                        {{ count($addtocart) }}</p>
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
                                        {{ count($whishlist) }}</p>
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




        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Danger</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure want to delete logs?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="confirmtodelete">Yes Do It</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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


            $(".dp").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });
            $('#confirmtodelete').click(function() {
                $('#exampleModalCenter').modal('hide');


                if ($('#search_fromdate_addtocart').val() != '' && $('#search_todate_addtocart').val() !=
                    '') {
                    $.post("{{ url('backside/super_admin/deletelogs') }}", {
                            from: $('#search_fromdate_addtocart').val() + " 00:00:00",
                            to: $('#search_todate_addtocart').val() + " 23:59:59",
                            currenttotal: $('#totalcount').html(),

                            _token: "{{ csrf_token() }}"
                        },
                        function(data, status) {

                            if (data.success) {
                                $('#search_fromdate_addtocart').val('');
                                $('#search_todate_addtocart').val('');
                                if (window.confirm(data.deleted_count + ' Logs were Successfully Deleted')){
                                    location.assign(location.href)
                                }else{
                                    location.assign(location.href)

                                }
                            }
                        });
                }
            });
        });
    </script>
@endpush
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
