<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Report For Shops</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;800&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('plugins/fontawesome-free/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ url('plugins/jquery-ui/jquery-ui.min.css') }}">
    <script src="{{ url('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ url('plugins/html2convas/html2convas.js') }}"></script>

</head>
<style>
    .ft-hg {
        height: 310px !important;
        margin-bottom: 22px !important;
    }

    .ft-text {
        text-align: left;
        font-size: 2.5rem;
        font-weight: 900;
        color: white;
        margin-top: 34px;
    }

    body {
        font-family: 'Nunito Sans', sans-serif;
    }

    .text-right {
        text-align: right;
    }

    .right-section {
        height: 350px;
    }

    .report-card {
        width: 80%;
    }

    .report-card .report-card-header {
        height: 430px;
        width: 100%;
    }

    .gradient {
        background: #DC2424;
        /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #DC2424, #4A569D);
        /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #DC2424, #4A569D);
        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    }

    .report-card .report-card-header .report-card-title {
        width: 100%;
        padding: 10px;
        display: flex;
        align-items: center;
    }

    .report-card .report-card-header .report-card-title img {
        width: 90px;
    }

    .report-card .report-card-header .report-card-title h2 {
        color: #fff;
        margin-left: 20px;
        font-weight: 700;

    }

    .report-card .report-card-header .report-card-month {
        display: flex;
        width: 100%;
        height: 200px;
    }

    .report-card .report-card-header .report-card-month h1 {
        text-transform: uppercase;
        color: #ffff;
        font-weight: 900;
    }

    .report-card .report-card-header .report-card-month .my-text {
        color: Gainsboro;
        font-size: 18px;
    }

    .report-card .report-card-body {
        position: relative;
        height: 1020px;
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .report-card .report-card-body .report-card-body-inner {
        background-color: WhiteSmoke;
        position: absolute;
        top: -70px;
        width: 95%;
        height: auto;
        border-radius: 12px;

    }

    .report-card .report-card-body .report-card-body-inner .report-card-body-inner-title {
        width: 100%;
        height: 70px;
        background-color: Gainsboro;
        border-radius: 12px 12px 0 0;
    }

    .report-card-body-inner-title h3 {
        font-weight: bolder;
        font-size: 20px;
        margin-top: 10px;
    }

    .report-card-body-inner .report-card-count-lists {
        display: flex;
        justify-content: space-between;
        padding: 20px;
    }

    @media screen and (max-width: 980px) {
        .for-mobile {
            /* display: none !important;
             */
            border: 1px solid red;
        }



        .ft-text {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 900;
            color: white;
            margin-top: 23px;
        }

        @media only screen and (max-width: 480px) {
            .ft-mobile {
                margin-top: 430px;

            }
        }
    }
</style>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-3">
                <div class="d-flex justify-content-end align-items-center">
                    <div class=" mr-3 p-1">
                        <fieldset>
                            <legend>From Date</legend>
                            <input type="text" id='search_fromdate_shop' class="shopdatepicker form-control"
                                placeholder='Choose date' value="" autocomplete="off" />
                        </fieldset>
                    </div>
                    <div class="ml-3 p-1">
                        <fieldset>
                            <legend>To Date</legend>
                            <input type="text" id='search_todate_shop' value=""
                                class="shopdatepicker form-control" placeholder='Choose date' autocomplete="off" />
                        </fieldset>
                    </div>
                    <div class="mt-3 text-light">
                        <input type='button' id="shop_search_button" value="Search" class="form-control bg-info"
                            style="margin-top: 27px;">
                    </div>
                </div>
                <div class="w-100  d-flex justify-content-center">
                    <button id="btn_convert" class="btn btn-warning">Download PNG <i
                            class="fas fa-download"></i></button>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 d-flex justify-content-center">
                <div class="report-card" id="myHtml">
                    <div class="report-card-header gradient p-4">
                        <div class="report-card-title mb-2">
                            <img src="{{ url('images/logo/' . $shopid->shop_logo) }}" alt="logo"
                                class="rounded-circle ">
                            <h2 class="mb-0"> {{ $shopid->shop_name }} Report </h2>
                        </div>
                        <div class="report-card-month">
                            <div class="col-7 d-flex align-items-center">
                                <div class="p-3">
                                    <h1 class="my-4 font-weight-bolder" id="changeMonth">{{ Date('F') }} Report</h1>
                                    <p class="my-text">
                                        <span class="fromMonth">{{ date('F') }}</span>
                                        <span class="fromDay">1st</span>
                                        <span>to</span>
                                        <span class="toMonth">{{ date('F') }}</span>
                                        <span class="toDay">{{ date('d') }}th</span>
                                        <span>,</span>
                                        <span>{{ date('Y') }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="w-100 d-flex justify-content-end p-0">
                                    <img src="{{ asset('images/logo/favicon.gif') }}" alt="" class="w-25 p-0">
                                </div>
                                <div class="w-100 text-right text-light">
                                    <span>Phone Number : +959 425472782</span><br>
                                    <span>E-mail : admin@shweshops.com</span><br>
                                    <span>Address : No.1168(6A), Pin Lon Road,</span><br>
                                    <span>35 Ward, North Dagon Township</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="report-card-body">
                        <div class="report-card-body-inner">
                            <div
                                class="report-card-body-inner-title d-flex justify-content-between align-items-center p-3">
                                <h3>Features</h3>
                                <h3>Counts</h3>
                            </div>
                            <h6 class="text-uppercase text-center font-weight-bolder mt-3">Shwe Shops</h6>
                            <div class="report-card-count-lists">
                                <span>အသုံးပြုသူစုစုပေါင်း</span><span id="totalUsers">{{ $total_user_count }}
                                    ဦး</span>
                            </div>
                            <div class="report-card-count-lists">
                                <span>Products အရေအတွက်စုစုပေါင်း</span><span
                                    id="totalProducts">{{ $total_products_count }} ခု</span>
                            </div>
                            <div class="report-card-count-lists">
                                <span>ဆိုင်စုစုပေါင်းအရေအတွက်</span><span id="totalUsers">{{ $shop_counts }}
                                    ဆိုင်</span>
                            </div>
                            <div class="report-card-count-lists">
                                <span>ကြော်ငြာများကြည့်ရူ့ထားသူအရေအတွက်</span><span
                                    id="adsCounts">{{ count($adsview) }} ဦး</span>
                            </div>
                            {{--                        <div class="report-card-count-lists"> --}}
                            {{--                                <span> --}}
                            {{--                                <!--    <span class="fromMonth">{{ date('F')}}</span>--> --}}
                            {{--                                    <!--    <span class="fromDay">1st</span>--> --}}
                            {{--                                    <!--    <span>to</span>--> --}}
                            {{--                                <!--    <span class="toMonth">{{ date('F') }}</span>--> --}}
                            {{--                                <!--    <span class="toDay">{{date('d')}}th</span>--> --}}
                            {{--                                    <!--    <span>,</span>--> --}}
                            {{--                                <!--    <span>{{ date('Y')}}</span>--> --}}
                            {{--                                    <!--    မှာ--> --}}
                            {{--                                    Shwe Shops ကိုအသုံးပြုသူအရေအတွက် --}}
                            {{--                                   </span> --}}
                            {{--                            <span id="totalNewUsers">{{ $new_users }} ယောက်</span> --}}
                            {{--                        </div> --}}
                            @if ($off_count != 0)
                                <hr>
                                <h6 class="text-uppercase text-center font-weight-bolder">{{ $shopid->shop_name }}</h6>
                            @endif
                            @if (count($products_count_setting) != 0)
                                <div class="report-card-count-lists">
                                    <span>Total Products အရေအတွက် (All Time)</span><span
                                        id="totalitems">{{ count($items) }} ခု</span>
                                </div>
                            @endif
                            @if (count($users_count_setting) != 0)
                                <div class="report-card-count-lists">
                                    <span> ဆိုင်အတွက်ထည့်ထားသော ဝန်ထမ်းအရေအတွက် (All Time)</span><span
                                        id="shopUserCounts"> {{ count($managers) }} ယောက်</span>
                                </div>
                            @endif
                            <h6 style="text-align: center;margin-top:22px;"><span class="for_date_shop"></span>
                            </h6>
                            <!-- Item counts -->
                            @if (count($products_count_setting) != 0)
                                <div class="report-card-count-lists">
                                    <span> Products အရေအတွက် </span><span id="shopItemCounts">{{ count($items) }}
                                        ခု</span>
                                </div>
                            @endif

                            <!-- User Counts  -->

                            <!-- User Inquiry Counts  -->
                            @if (count($inquiry_count_setting) != 0)
                                <div class="report-card-count-lists">
                                    <span> Chat Sytem မှတစ်ဆင့်စကားလာပြောထားသော customer အရေအတွက်</span><span
                                        id="inq"> {{ $inquiry }} ယောက်</span>
                                </div>
                            @endif

                            <!-- Item View Counts -->
                            @if (count($items_view_count_setting) != 0)
                                <div class="report-card-count-lists">
                                    <span> Products များကိုကြည့်ရှုထားသော customer အရေအတွက်</span><span
                                        id="shopProductViewCounts"> {{ count($productclick) }} ယောက်</span>
                                </div>
                            @endif

                            <!-- Shop View Counts -->
                            @if (count($shops_view_count_setting) != 0)
                                <div class="report-card-count-lists">
                                    <span><span class="for_date_shop"></span> ဆိုင်ကိုကြည့်ရှုထားသော customer အရေအတွက်
                                    </span><span id="shopViewCounts">{{ count($shopview) }} ယောက်</span>
                                </div>
                            @endif

                            <!-- Unique Product View -->
                            @if (count($unique_product_click_count_setting) != 0)
                                <div class="report-card-count-lists">
                                    <span> Products များကိုကြည့်ရှုထားသော customer အသစ်အရေအတွက်</span><span
                                        id="shopProductViewUniqueCounts">{{ count($unique_productclick) }}
                                        ယောက်</span>
                                </div>
                            @endif

                            <!-- Buy Now Click  -->
                            @if (count($buy_now_count_setting) != 0)
                                <div class="report-card-count-lists">
                                    <span> Products များကိုဝယ်ချင်သော customer အရေအတွက်</span><span
                                        id="buyNowCounts">{{ count($buynowclick) }} ယောက်</span>
                                </div>
                            @endif

                            @if (count($addtocartclick_count_setting) != 0)
                                <div class="report-card-count-lists">
                                    <span> Products များကိုသိမ်းထားသော customer အရေအတွက်</span><span
                                        id="addToCardCounts">{{ count($addtocartclick) }} ယောက်</span>
                                </div>
                            @endif

                            @if (count($whislistclick_count_setting) != 0)
                                <div class="report-card-count-lists">
                                    <span> Products များကိုကြိုက်နှစ်သက်သည့် customer အရေအတွက်</span><span
                                        id="whilistCounts">{{ count($whislistclick) }} ယောက်</span>
                                </div>
                            @endif



                            @if (count($discountview_count_setting) != 0)
                                <div class="report-card-count-lists">
                                    <span> Discount Products များကိုကြည့်ရှုထားသော customer အရေအတွက်</span><span
                                        id="discountCounts">{{ count($discountview) }} ယောက်</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="report-card-header gradient p-4 ft-hg ft-mobile">
                        <div class="report-card-title mb-4">
                            &nbsp;
                        </div>
                        <div class="row no-gutters ">
                            <div class="col-12 col-sm-5 d-flex justify-content-center justify-content-sm-end">
                                <img src="{{ asset('images/logo/favicon.gif') }}" style="width:122px;" />
                            </div>
                            <div class="col-12 col-sm-7 ft-text">
                                Thank You
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".shopdatepicker").datepicker({
                "dateFormat": "yy-mm-dd",
                changeYear: true
            });

            $('#shop_search_button').click(function() {
                const now = new Date();
                const month = ["January", "February", "March", "April", "May", "June", "July", "August",
                    "September", "October", "November", "December"
                ];
                const from = new Date($('#search_fromdate_shop').val());
                const to = new Date($('#search_todate_shop').val());
                let nowGetMonth = month[now.getMonth()];
                console.log(nowGetMonth)
                let fromGetMonth = month[from.getMonth()];
                let toGetMonth = month[to.getMonth()];
                let fromGetDay = from.getDate();
                let toGetDay = to.getDate();

                if (fromGetMonth != nowGetMonth && toGetMonth != nowGetMonth) {
                    $("#changeMonth").html(toGetMonth + ' Report');
                    $("#changeMonthPdf").html(toGetMonth + ' Report');
                } else {
                    $("#changeMonth").html(nowGetMonth + ' Report');
                    $("#changeMonthPdf").html(nowGetMonth + ' Report');
                }

                $(".fromMonth").html(fromGetMonth);
                $(".toMonth").html(toGetMonth);
                //For PDF
                $("#fromMonthPdf").html(fromGetMonth);
                $("#toMonthPdf").html(toGetMonth);


                switch (fromGetDay) {
                    case 1:
                        $(".fromDay").html(fromGetDay + 'st');
                        break;
                    case 2:
                        $(".fromDay").html(fromGetDay + 'nd');
                        break;
                    case 3:
                        $(".fromDay").html(fromGetDay + 'rd');
                        break;
                    default:
                        $(".fromDay").html(fromGetDay + 'th');
                }

                switch (toGetDay) {
                    case 1:
                        $(".toDay").html(toGetDay + 'st');
                        break;
                    case 2:
                        $(".toDay").html(toGetDay + 'nd');
                        break;
                    case 3:
                        $(".toDay").html(toGetDay + 'rd');
                        break;
                    default:
                        $(".toDay").html(toGetDay + 'th');
                }

                if ($('#search_fromdate_shop').val() != null && $('#search_todate_shop').val() != null) {
                    $.post(
                        "{{ url('backside/super_admin/date_filter') }}", {
                            id: `{{ $shopid->id }}`,
                            from: $('#search_fromdate_shop').val(),
                            to: $('#search_todate_shop').val(),
                            _token: "{{ csrf_token() }}"
                        },
                        function(data, status) {
                            console.log(data);

                            // $('#totalUsers').html(data.totalusers);
                            // $('#totalProducts').html(data.totalproducts);
                            // $('#totalNewUsers').html(data.newusers+'ဦး');
                            $('#shopItemCounts').html(data.itemscount + 'ခု');
                            $('#totalitems').html(data.totalitemsalltime + 'ခု');
                            $('#shopUserCounts').html(data.usercounts + 'ဦး:');
                            $('#shopProductViewCounts').html(data.productviews + 'ဦး');
                            $('#shopViewCounts').html(data.shopviewuser + 'ဦး');
                            $('#shopProductViewUniqueCounts').html(data.uniqueproductviews + 'ဦး');
                            $('#buyNowCounts').html(data.buynow + 'ဦး');
                            $('#addToCardCounts').html(data.addtocard + 'ဦး');
                            $('#whilistCounts').html(data.whislistcount + 'ဦး');
                            $('#adsCounts').html(data.ads);
                            $('#discountCounts').html(data.discount);
                            $('#inq').html(data.inquiry);
                            $('.for_date_shop').html('( ' + data.for_date_shop + ' )');

                        }
                    );
                }
            });

            $("#btn_convert").on('click', function() {
                html2canvas(document.getElementById("myHtml"), {
                    allowTaint: true,
                    useCORS: true
                }).then(function(canvas) {
                    var anchorTag = document.createElement("a");
                    document.body.appendChild(anchorTag);
                    // document.getElementById("previewImg").appendChild(canvas);
                    anchorTag.download =
                    `{{ $shopid->shop_name }} {{ date('F') }} Report.jpg`;
                    anchorTag.href = canvas.toDataURL();
                    anchorTag.target = '_blank';
                    anchorTag.click();
                });
            });

        });
    </script>

</body>

</html>
