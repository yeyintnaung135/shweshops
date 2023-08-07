@extends('layouts.frontend.frontend') @section('content') @include('layouts.frontend.allpart.for_mobile')

<div id="page" class="site container-fluid my-0 py-0">


    {{--MENU--}} @include('layouts.frontend.allpart.menu') {{-- end Menu--}}
    <!-- .site-content-contain -->
    <div class="site-content-contain">


        <!-- .site-content-contain -->
        <div class="site-content-contain">


            <div class="page-container container show_breadcrumb_">
                <div class="remove_wrapp">
                    @include('layouts.frontend.allpart.loading_wrapper')
                </div>

                <div class="row">
                    <div id="main-content" class="show_dev col-sm-9 col-xs-12 d-none">

                        <br><br>
                        <form name="myform">



                            <div class="row">

                                <!-- Weight -->

                                <!-- Gram -->
                                <div class="gram form-group col-4">
                                    <!-- <label>Gram</label> -->
                                    <input type="number" name="gram" id="gram">
                                </div>

                                <!-- Kyattar -->
                                <div class="testkyattar form-group col-4">
                                    <!-- <label>Testkyattar</label> -->
                                    <input type="number" name="testkyattar" id="testkyattar">
                                </div>

                                <!-- Pae -->
                                <div class="pae form-group col-4">
                                    <!-- <label>Pae</label> -->
                                    <input type="number" name="pae" id="pae">
                                </div>

                                <!-- Yway -->
                                <div class="yway form-group col-4">
                                    <!-- <label>Yway</label> -->
                                    <input type="number" name="yway" id="yway">
                                </div>

                                <!-- Selection Option -->
                                <div class="col-2 selection">
                                    <!-- <label>Weight</label> -->
                                    <select id="selectoption">
                                        <option value = "gram"> Gram </option>
                                        <option value = "kyattar"> Kyattar </option>
                                        <option value = "pae"> Pae </option>
                                        <option value = "yway"> Yway </option>
                                    </select>
                                </div>

                                <!-- Button -->
                                <div class="col-2">
                                <!-- <label>Calculate</label> -->
                                    <button type="button" class="grambtn btn-primary">Calculate</button>
                                    <button type="button" class="kyattarbtn btn-primary">Calculate</button>
                                    <button type="button" class="paebtn btn-primary">Calculate</button>
                                    <button type="button" class="ywaybtn btn-primary">Calculate</button>
                                </div>

                                <!-- Total Value -->

                                <!-- Gram value -->
                                <div class="totalvalue form-group col-4">
                                    <!-- <label>Gram value</label> -->
                                    <input type="number" name="total" id="total">
                                </div>

                                <!-- Kyattar value -->
                                <div class="kyattartotal form-group col-4">
                                    <!-- <label>Kyattar Value</label> -->
                                    <input type="number" name="kyattartotal" id="Kyattartotal">
                                </div>

                                <!-- Pae value -->
                                <div class="paetotal form-group col-4">
                                    <!-- <label>Pae Value</label> -->
                                    <input type="number" name="paetotal" id="paetotal">
                                 </div>

                                 <!-- yway value -->

                                 <div class="ywaytotal form-group col-4">
                                    <!-- <label>Yway Value</label> -->
                                    <input type="number" name="ywaytotal" id="ywaytotal">
                                 </div>

                            </div>

                            <!-- world gold price -->
                            <div class="row">
                                <div class="worldgoldprice form-group col-6">
                                    <label>World Gold Price</label>
                                    <input type="number" name="wgoldprice" id="wgoldprice">
                                </div>
                            </div><br><br>
                    </form>

                </div>
            </div>
        </div>


        @include('layouts.frontend.allpart.footer')
    </div>


    <div class="ftc-close-popup"></div>

    @include('layouts.frontend.allpart.mobile_footer')

    <div id="to-top" class="scroll-button">
      <a class="" onclick="scrollToTop()" title="Back to Top">Back to Top</a>
    </div>


</div>
</div>

<script type="application/javascript">
    $(document).ready(function() {
        $(".worldgoldprice").hide();
        $(".kyattar").hide();

        // kyattar
        $(".testkyattar").hide();
        $(".kyattartotal").hide();
        $(".kyattarbtn").hide();

        // pae
        $(".pae").hide();
        $(".paetotal").hide();
        $(".paebtn").hide();

        // yway
        $(".yway").hide();
        $(".ywaytotal").hide();
        $(".ywaybtn").hide();

        $.ajax({
            url: 'https://www.goldapi.io/api/XAU/USD',
            headers: {
                "x-access-token": "goldapi-1lxojrtkysvyykt-io"
            },
            type: "get",
            dataType: "json",
            success: function(data) {

                var wgoldprice = data.open_price;
                console.log(data.open_price);
                document.myform.wgoldprice.value = wgoldprice.toFixed(0);

            },
            error: function(err) {
                console.log(err);
            }
        })

        // Gram

        $(".grambtn").click(function() {



            $.ajax({
                url: 'https://freecurrencyapi.net/api/v2/latest?apikey=e6381610-7d30-11ec-b6cd-71d0d40a2d6f',
                type: "get",
                dataType: "json",
                success: function(data) {

                    var wgoldprice = $("#wgoldprice").val();
                    console.log(wgoldprice);

                    var currencymmk = data.data.MMK;
                    console.log(currencymmk);

                    var gram = $("#gram").val();
                    console.log(gram);

                    var kyattar = gram / 16.606;
                    console.log(kyattar);

                    var pae = (kyattar - Math.floor(kyattar)) * 16;
                    console.log(pae);

                    var yway = (pae - Math.floor(pae)) * 8;
                    console.log(yway);

                    var dollargold = wgoldprice * currencymmk;
                    console.log(dollargold);

                    var myanmargoldprice = dollargold / 1.875;
                    console.log(myanmargoldprice);

                    // var KS=$.html("<p>KS</p>");
                    // console.log(KS);

                    var total = kyattar * myanmargoldprice;
                    console.log(total);

                    // document.myform.kyattar.value = kyattar.toFixed(0);
                    // document.myform.pae.value = Math.round(pae);
                    // document.myform.yway.value = Math.round(yway);
                    document.myform.total.value = total.toFixed(0);

                },
                error: function(err) {
                    console.log(err);
                }
            })




        })

        // Kyattar Click
        $(".kyattarbtn").click(function() {

            $.ajax({
                url: 'https://www.goldapi.io/api/XAU/USD',
                headers: {
                    "x-access-token": "goldapi-1lxojrtkysvyykt-io"
                },
                type: "get",
                dataType: "json",
                success: function(data) {

                    var wgoldprice = data.open_price;
                    console.log(data.open_price);
                    document.myform.wgoldprice.value = wgoldprice.toFixed(0);

                },
                error: function(err) {
                    console.log(err);
                }
            })

            $.ajax({
                url: 'https://freecurrencyapi.net/api/v2/latest?apikey=e6381610-7d30-11ec-b6cd-71d0d40a2d6f',
                type: "get",
                dataType: "json",
                success: function(data) {

                    var wgoldprice = $("#wgoldprice").val();
                    console.log(wgoldprice);

                    var currencymmk = data.data.MMK;
                    console.log(currencymmk);

                    var kyattar = $("#gram").val();
                    console.log(kyattar);

                    var dollargold = wgoldprice * currencymmk;
                    console.log(dollargold);

                    var myanmargoldprice = dollargold / 1.875;
                    console.log(myanmargoldprice);

                    var kyattartotal = kyattar * myanmargoldprice;
                    console.log(total);

                    document.myform.kyattartotal.value = kyattartotal.toFixed(0);

                },
                error: function(err) {
                    console.log(err);
                }
            })
            })

            // pae
            $(".paebtn").click(function() {

                $.ajax({
                        url: 'https://freecurrencyapi.net/api/v2/latest?apikey=e6381610-7d30-11ec-b6cd-71d0d40a2d6f',
                        type: "get",
                        dataType: "json",
                        success: function(data) {

                            var wgoldprice = $("#wgoldprice").val();
                            console.log(wgoldprice);

                            var currencymmk = data.data.MMK;
                            console.log(currencymmk);

                            var pae = $("#gram").val();
                            console.log(pae);

                            var kyattar = pae / 16;
                            console.log(kyattar);

                            var dollargold = wgoldprice * currencymmk;
                            console.log(dollargold);

                            var myanmargoldprice = dollargold / 1.875;
                            console.log(myanmargoldprice);

                            var paetotal = kyattar * myanmargoldprice;
                            console.log(paetotal);

                            document.myform.paetotal.value = paetotal.toFixed(0);

                        },
                        error: function(err) {
                            console.log(err);
                        }

                })
                })

                // yway
                $(".ywaybtn").click(function() {

                    $.ajax({
                            url: 'https://freecurrencyapi.net/api/v2/latest?apikey=e6381610-7d30-11ec-b6cd-71d0d40a2d6f',
                            type: "get",
                            dataType: "json",
                            success: function(data) {

                                var wgoldprice = $("#wgoldprice").val();
                                console.log(wgoldprice);

                                var currencymmk = data.data.MMK;
                                console.log(currencymmk);

                                var yway = $("#gram").val();
                                console.log(yway);

                                var pae = yway / 8;
                                console.log(pae);

                                var kyattar = pae / 16;
                                console.log(kyattar);

                                var dollargold = wgoldprice * currencymmk;
                                console.log(dollargold);

                                var myanmargoldprice = dollargold / 1.875;
                                console.log(myanmargoldprice);

                                var ywaytotal = kyattar * myanmargoldprice;
                                console.log(ywaytotal);

                                document.myform.ywaytotal.value = ywaytotal.toFixed(0);
                            },
                                error: function(err) {
                                    console.log(err);
                                }

                        })
                    })


        // select option
        $("#selectoption").change(function() {
            if (this.value == 'gram') {
                // alert("gram");
                $(".gram").show();
                $(".totalvalue").show();
                $(".kyattartotal").hide();
                $(".testkyattar").hide();
                $(".pae").hide();
                $(".paetotal").hide();
                $(".yway").hide();
                $(".ywaytotal").hide();
                $(".yway").hide();
                $(".ywaytotal").hide();
                $(".grambtn").show();
                $(".kyattarbtn").hide();
                $(".paebtn").hide();
                $(".ywaybtn").hide();

            }  else if (this.value == 'kyattar') {
                // alert("kyat");
                // $(".gram").hide();
                $(".totalvalue").hide();
                $(".kyattartotal").show();
                $(".testkyattar").hide();
                $(".pae").hide();
                $(".paetotal").hide();
                $(".yway").hide();
                $(".ywaytotal").hide();
                $(".grambtn").hide();
                $(".kyattarbtn").show();
                $(".paebtn").hide();
                $(".ywaybtn").hide();
                     // Kyattar


            } else if (this.value == 'pae'){
                $(".gram").show();
                $(".totalvalue").hide();
                $(".kyattartotal").hide();
                $(".testkyattar").hide();
                $(".pae").hide();
                $(".paetotal").show();
                $(".yway").hide();
                $(".ywaytotal").hide();
                $(".grambtn").hide();
                $(".kyattarbtn").hide();
                $(".paebtn").show();
                $(".ywaybtn").hide();

            // Pae


                // alert("pae");
            }else if (this.value == 'yway'){
                $(".gram").show();
                $(".totalvalue").hide();
                $(".kyattartotal").hide();
                $(".testkyattar").hide();
                $(".pae").hide();
                $(".paetotal").hide();
                $(".yway").hide();
                $(".ywaytotal").show();
                $(".grambtn").hide();
                $(".kyattarbtn").hide();
                $(".paebtn").hide();
                $(".ywaybtn").show();

                        // Yway



                // alert("yway");
            }

        })

    })

</script>

@endsection

@push('css')
    <style>
        .remove_wrapp{
            height: 822px !important;
            position:relative !important;
        }

    </style>
@endpush
