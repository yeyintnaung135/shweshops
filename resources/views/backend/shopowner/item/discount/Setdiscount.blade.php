@extends('layouts.backend.backend')

@section('content')
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.backend.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.backend.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h3 class="card-title">Set Discount</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Shops</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- left column -->

                    <!-- general form elements -->
                    <div class="row" style="background:white;padding:22px;">


                        <div class="col-12 col-sm-6">
                            <h3 class="d-inline-block d-sm-none">{{ $item->name }}</h3>
                            <div id="mainCarousel" class="carousel w-10/12 max-w-5xl mx-auto">
                                @if ($item->default_photo != '')
                                    <div class="carousel__slide "
                                        data-src="{{ filedopath('/items/' . $item->default_photo) }}" data-fancybox="group">
                                        @if ($item->check_discount != '0')
                                            <div class="sop-ribbon-pd ">
                                                <span>-{{ $get_dis->percent }}%</span>
                                            </div>
                                        @endif

                                        @if (dofile_exists('/items/mid/' . $item->default_photo))
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/mid/' . $item->default_photo) }}" />
                                        @else
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/' . $item->default_photo) }}" />
                                        @endif
                                        <div class="yk-photozoom-text">Click Photo to zoom</div>

                                    </div>
                                @endif

                                @if ($item->photo_one != '' && $item->photo_one != $item->default_photo)
                                    <div class="carousel__slide " data-src="{{ filedopath('/items/mid' . $item->photo_one) }}"
                                        data-fancybox="group">
                                        @if ($item->check_discount != '0')
                                            <div class="sop-ribbon-pd ">
                                                <span>-{{ $get_dis->percent }}%</span>
                                            </div>
                                        @endif
                                        @if (dofile_exists('/items/mid/' . $item->photo_one))
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/mid/' . $item->photo_one) }}" />
                                        @else
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/' . $item->photo_one) }}" />
                                        @endif
                                        <div class="yk-photozoom-text">Click Photo to zoom</div>

                                    </div>
                                @endif

                                @if ($item->photo_two != '' && $item->photo_two != $item->default_photo)
                                    <div class="carousel__slide " data-src="{{ filedopath('/items/' . $item->photo_two) }}"
                                        data-fancybox="group">
                                        @if ($item->check_discount != '0')
                                            <div class="sop-ribbon-pd ">
                                                <span>-{{ $get_dis->percent }}%</span>
                                            </div>
                                        @endif

                                        @if (dofile_exists('/items/mid/' . $item->photo_two))
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/mid/' . $item->photo_two) }}" />
                                        @else
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/' . $item->photo_two) }}" />
                                        @endif
                                        <div class="yk-photozoom-text">Click Photo to zoom</div>

                                    </div>
                                @endif
                                @if ($item->photo_three != '' && $item->photo_three != $item->default_photo)
                                    <div class="carousel__slide " data-src="{{ filedopath('/items/' . $item->photo_three) }}"
                                        data-fancybox="group">
                                        @if ($item->check_discount != '0')
                                            <div class="sop-ribbon-pd ">
                                                <span>-{{ $get_dis->percent }}%</span>
                                            </div>
                                        @endif
                                        @if (dofile_exists('/items/mid/' . $item->photo_three))
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/mid/' . $item->photo_three) }}" />
                                        @else
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/' . $item->photo_three) }}" />
                                        @endif
                                        <div class="yk-photozoom-text">Click Photo to zoom</div>

                                    </div>
                                @endif
                                @if ($item->photo_four != '' && $item->photo_four != $item->default_photo)
                                    <div class="carousel__slide " data-src="{{ filedopath('/items/' . $item->photo_four) }}"
                                        data-fancybox="group">
                                        @if ($item->check_discount != '0')
                                            <div class="sop-ribbon-pd ">
                                                <span>-{{ $get_dis->percent }}%</span>
                                            </div>
                                        @endif
                                        @if (file_exists(filedopath('/items/mid/' . $item->photo_four)))
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/mid/' . $item->photo_four) }}" />
                                        @else
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/' . $item->photo_four) }}" />
                                        @endif
                                        <div class="yk-photozoom-text">Click Photo to zoom</div>

                                    </div>
                                @endif
                                @if ($item->photo_five != '' && $item->photo_five != $item->default_photo)
                                    <div class="carousel__slide " data-src="{{ filedopath('/items/' . $item->photo_five) }}"
                                        data-fancybox="group">
                                        @if ($item->check_discount != '0')
                                            <div class="sop-ribbon-pd ">
                                                <span>-{{ $get_dis->percent }}%</span>
                                            </div>
                                        @endif
                                        @if (file_exists(filedopath('/items/mid/' . $item->photo_five)))
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/mid/' . $item->photo_five) }}" />
                                        @else
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/' . $item->photo_five) }}" />
                                        @endif
                                        <div class="yk-photozoom-text">Click Photo to zoom</div>

                                    </div>
                                @endif
                                @if ($item->photo_six != '' && $item->photo_six != $item->default_photo)
                                    <div class="carousel__slide " data-src="{{ filedopath('/items/' . $item->photo_six) }}"
                                        data-fancybox="group">
                                        @if ($item->check_discount != '0')
                                            <div class="sop-ribbon-pd ">
                                                <span>-{{ $get_dis->percent }}%</span>
                                            </div>
                                        @endif
                                        @if (file_exists(filedopath('/items/mid/' . $item->photo_six)))
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/mid/' . $item->photo_six) }}" />
                                        @else
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/' . $item->photo_six) }}" />
                                        @endif
                                        <div class="yk-photozoom-text">Click Photo to zoom</div>

                                    </div>
                                @endif
                                @if ($item->photo_seven != '' && $item->photo_seven != $item->default_photo)
                                    <div class="carousel__slide " data-src="{{ filedopath('/items/' . $item->photo_seven) }}"
                                        data-fancybox="group">
                                        @if ($item->check_discount != '0')
                                            <div class="sop-ribbon-pd ">
                                                <span>-{{ $get_dis->percent }}%</span>
                                            </div>
                                        @endif
                                        @if (file_exists(filedopath('/items/mid/' . $item->photo_seven)))
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/mid/' . $item->photo_seven) }}" />
                                        @else
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/' . $item->photo_seven) }}" />
                                        @endif
                                        <div class="yk-photozoom-text">Click Photo to zoom</div>

                                    </div>
                                @endif
                                @if ($item->photo_eight != '' && $item->photo_eight != $item->default_photo)
                                    <div class="carousel__slide"
                                        data-src="{{ filedopath('/items/' . $item->photo_eight) }}" data-fancybox="group">
                                        @if ($item->check_discount != '0')
                                            <div class="sop-ribbon-pd ">
                                                <span>-{{ $get_dis->percent }}%</span>
                                            </div>
                                        @endif
                                        @if (file_exists(filedopath('/items/mid/' . $item->photo_eight)))
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/mid/' . $item->photo_eight) }}" />
                                        @else
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/' . $item->photo_eight) }}" />
                                        @endif
                                        <div class="yk-photozoom-text">Click Photo to zoom</div>

                                    </div>
                                @endif
                                @if ($item->photo_nine != '' && $item->photo_nine != $item->default_photo)
                                    <div class="carousel__slide "
                                        data-src="{{ filedopath('/items/' . $item->photo_nine) }}" data-fancybox="group">
                                        @if ($item->check_discount != '0')
                                            <div class="sop-ribbon-pd ">
                                                <span>-{{ $get_dis->percent }}%</span>
                                            </div>
                                        @endif
                                        @if (file_exists(filedopath('/items/mid/' . $item->photo_nine)))
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/mid/' . $item->photo_nine) }}" />
                                        @else
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/' . $item->photo_nine) }}" />
                                        @endif
                                        <div class="yk-photozoom-text">Click Photo to zoom</div>

                                    </div>
                                @endif
                                @if ($item->photo_ten != '' && $item->photo_ten != $item->default_photo)
                                    <div class="carousel__slide " data-src="{{ filedopath('/items/' . $item->photo_ten) }}"
                                        data-fancybox="group">
                                        @if ($item->check_discount != '0')
                                            <div class="sop-ribbon-pd ">
                                                <span>-{{ $get_dis->percent }}%</span>
                                            </div>
                                        @endif
                                        @if (file_exists(filedopath('/items/mid/' . $item->photo_ten)))
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/mid/' . $item->photo_ten) }}" />
                                        @else
                                            <img class="yk-product-image" id="zoom_07"
                                                src="{{ filedopath('/items/' . $item->photo_ten) }}" />
                                        @endif
                                        <div class="yk-photozoom-text">Click Photo to zoom</div>

                                    </div>
                                @endif


                            </div>


                            <div id="thumbCarousel" class="carousel max-w-xl mx-auto">
                                @if ($item->default_photo != '')
                                    @if (dofile_exists('/images/items/thumbs/' . $item->default_photo))
                                        <div class="carousel__slide">
                                            <img class=""
                                                src="{{ filedopath('/items/thumbs/' . $item->default_photo) }}" />
                                        </div>
                                    @else
                                        <div class="carousel__slide">
                                            <img class="" src="{{ filedopath('/items/' . $item->default_photo) }}" />

                                        </div>
                                    @endif
                                @endif
                                @if ($item->photo_one != '' && $item->photo_one != $item->default_photo)
                                    @if (dofile_exists('/items/thumbs/' . $item->photo_one))
                                        <div class="carousel__slide">
                                            <img class=""
                                                src="{{ filedopath('/items/thumbs/' . $item->photo_one) }}" />
                                        </div>
                                    @else
                                        <div class="carousel__slide">
                                            <img class="" src="{{ filedopath('/items/' . $item->photo_one) }}" />

                                        </div>
                                    @endif
                                @endif
                                @if ($item->photo_two != '' && $item->photo_two != $item->default_photo)
                                    @if (dofile_exists('/items/thumbs/' . $item->photo_two))
                                        <div class="carousel__slide">
                                            <img class=""
                                                src="{{ filedopath('/items/thumbs/' . $item->photo_two) }}" />
                                        </div>
                                    @else
                                        <div class="carousel__slide">
                                            <img class="" src="{{ filedopath('/items/' . $item->photo_two) }}" />

                                        </div>
                                    @endif
                                @endif
                                @if ($item->photo_three != '' && $item->photo_three != $item->default_photo)
                                    @if (dofile_exists('/items/thumbs/' . $item->photo_three))
                                        <div class="carousel__slide">
                                            <img class=""
                                                src="{{ filedopath('/items/thumbs/' . $item->photo_three) }}" />
                                        </div>
                                    @else
                                        <div class="carousel__slide">
                                            <img class="" src="{{ filedopath('/items/' . $item->photo_three) }}" />

                                        </div>
                                    @endif
                                @endif
                                @if ($item->photo_four != '' && $item->photo_four != $item->default_photo)
                                    @if (dofile_exists('/items/thumbs/' . $item->photo_four))
                                        <div class="carousel__slide">
                                            <img class=""
                                                src="{{ filedopath('/items/thumbs/' . $item->photo_four) }}" />
                                        </div>
                                    @else
                                        <div class="carousel__slide">
                                            <img class="" src="{{ filedopath('/items/' . $item->photo_four) }}" />

                                        </div>
                                    @endif
                                @endif
                                @if ($item->photo_five != '' && $item->photo_five != $item->default_photo)
                                    @if (dofile_exists('/items/thumbs/' . $item->photo_five))
                                        <div class="carousel__slide">
                                            <img class=""
                                                src="{{ filedopath('/items/thumbs/' . $item->photo_five) }}" />
                                        </div>
                                    @else
                                        <div class="carousel__slide">
                                            <img class="" src="{{ filedopath('/items/' . $item->photo_five) }}" />

                                        </div>
                                    @endif
                                @endif
                                @if ($item->photo_six != '' && $item->photo_six != $item->default_photo)
                                    @if (dofile_exists('/items/thumbs/' . $item->photo_six))
                                        <div class="carousel__slide">
                                            <img class=""
                                                src="{{ filedopath('/items/thumbs/' . $item->photo_six) }}" />
                                        </div>
                                    @else
                                        <div class="carousel__slide">
                                            <img class="" src="{{ filedopath('/items/' . $item->photo_six) }}" />

                                        </div>
                                    @endif
                                @endif
                                @if ($item->photo_seven != '' && $item->photo_seven != $item->default_photo)
                                    @if (dofile_exists('/items/thumbs/' . $item->photo_seven))
                                        <div class="carousel__slide">
                                            <img class=""
                                                src="{{ filedopath('/items/thumbs/' . $item->photo_seven) }}" />
                                        </div>
                                    @else
                                        <div class="carousel__slide">
                                            <img class="" src="{{ filedopath('/items/' . $item->photo_seven) }}" />

                                        </div>
                                    @endif
                                @endif
                                @if ($item->photo_eight != '' && $item->photo_eight != $item->default_photo)
                                    @if (dofile_exists('/items/thumbs/' . $item->photo_eight))
                                        <div class="carousel__slide">
                                            <img class=""
                                                src="{{ filedopath('/items/thumbs/' . $item->photo_eight) }}" />
                                        </div>
                                    @else
                                        <div class="carousel__slide">
                                            <img class="" src="{{ filedopath('/items/' . $item->photo_eight) }}" />

                                        </div>
                                    @endif
                                @endif
                                @if ($item->photo_nine != '' && $item->photo_nine != $item->default_photo)
                                    @if (dofile_exists('/items/thumbs/' . $item->photo_nine))
                                        <div class="carousel__slide">
                                            <img class=""
                                                src="{{ filedopath('/items/thumbs/' . $item->photo_nine) }}" />
                                        </div>
                                    @else
                                        <div class="carousel__slide">
                                            <img class="" src="{{ filedopath('/items/' . $item->photo_nine) }}" />

                                        </div>
                                    @endif
                                @endif
                                @if ($item->photo_ten != '' && $item->photo_ten != $item->default_photo)
                                    @if (dofile_exists('/items/thumbs/' . $item->photo_ten))
                                        <div class="carousel__slide">
                                            <img class=""
                                                src="{{ filedopath('/items/thumbs/' . $item->photo_ten) }}" />
                                        </div>
                                    @else
                                        <div class="carousel__slide">
                                            <img class="" src="{{ filedopath('/items/' . $item->photo_ten) }}" />

                                        </div>
                                    @endif
                                @endif

                            </div>
                        </div>


                        <div class="col-12 col-sm-6">
                            <div class="card-body">
                                <h3 class="my-3 mt-sm-0">{{ $item->name }}</h3>
                                <table class="table table-hover">
                                    <tbody>

                                        <tr>
                                            <td>Product Code</td>
                                            <td>{{ $item->product_code }}</td>
                                        </tr>
                                        @if ($item->price != 0)
                                            <tr>
                                                <td>
                                                    Old Price
                                                </td>
                                                <td id="old_exact_price">{{ $item->price }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>
                                                    Old Min Price
                                                </td>
                                                <td id="old_min_price">{{ $item->min_price }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Old Max Price
                                                </td>
                                                <td id="old_max_price">{{ $item->max_price }}</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                                <br>
                                <form method="post" action="{{ url('/backside/shop_owner/item/discount/' . $item->id) }}">
                                    @csrf {{-- cross site request forgery --}}
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="col-md-12">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="sop-font">ဘယ်ပေါ်မူတည်ပြီး Discount
                                                                လျော့မလည်း </label>

                                                            <select name="base"
                                                                class="price-select form-control form-select"
                                                                id="discountbase">
                                                                <option value="price" selected>Price ဖြစ်</option>
                                                                <option value="percent">Percent ဖြစ်</option>
                                                            </select>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-12 percent">

                                            <div class="col-md-12">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12 ">
                                                            <label>လျော့မည့် % </label>

                                                            <input type="number" class="form-control" value=""
                                                                min="1" name="percent"
                                                                placeholder="Enter Discount Percent" required
                                                                step="0.1">
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-12 price">

                                            <div class="col-md-12">

                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12 ">
                                                            <label>လျော့မည့် price</label>

                                                            <input type="number" id="pricetominus" class="form-control"
                                                                name="price" placeholder="Enter Discount Price" required
                                                                step="0.1">
                                                            <span id="showpricelogic"></span>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>

                                        </div>
                                        <br>
                                        <div class="col-12 ">

                                            <div class="col-md-12">

                                                <div class="form-group">
                                                    @if ($item->price == 0)
                                                        <label> သင့် product စျေးနှုန်းသည်<span id="percentforshow"></span>
                                                        </label>
                                                        <div class="row">
                                                            <div class="col-6 range">


                                                                <input type="number" class="form-control disable-form"
                                                                    name="discount_min" min="0"
                                                                    placeholder="Min price" required readonly>

                                                            </div>
                                                            <div class="col-6 range">

                                                                <input type="number" class="form-control disable-form"
                                                                    name="discount_max" min="0"
                                                                    placeholder="MAX price" required readonly>

                                                            </div>
                                                        </div>
                                                        <span id="showpricelogicminmax"></span>
                                                    @else
                                                        <div class="row">
                                                            <div class="col-12 exact no-gutters sop-font">
                                                                <label>သင့် product စျေးနှုန်းသည် <span
                                                                        id="percentforshow"></span> </label>

                                                                <input type="number" class="form-control" min="0"
                                                                    name="discount_price"
                                                                    placeholder="Enter Discount Price" required readonly>
                                                                <span id="showpricelogicexc"></span>

                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <input type="hidden" name="percentbyprice" value=""
                                                    class="form-control">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-md-8">&nbsp;</div>

                                        <input type="hidden" name="item_id" value="{{ $item->id }}" />
                                        <div class="col-6 col-md-4 float-right">
                                            <button id="snbtn" class="btn btn-primary sn-submit" type="submit"><span
                                                    class="fa fa-paper-plane"></span>&nbsp;&nbsp;Submit form
                                            </button>
                                        </div>
                                        <div>
                                            <a class="sn-cancel-form" href="{{ url()->previous() }}">
                                                <span>Cancel</span>
                                            </a>
                                        </div>

                                    </div>
                                </form>

                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.card -->

                <!-- general form elements -->

                <!--/.col (left) -->
                <!-- right column -->

                <!--/.col (right) -->

                <!-- /.row -->
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
@endsection

@push('scripts')
    <script src="{{ url('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.product-image-thumb').on('click', function() {
                var $image_element = $(this).find('img')
                $('.product-image').fadeOut('slow', function() {
                    $('.product-image').prop('src', $image_element.attr('src')).fadeIn();

                })

                $('.product-image-thumb.active').removeClass('active')
                $(this).addClass('active')
            })
        })
    </script>
    <script>
        $(function() {

        });
    </script>
    <script>
        $(document).ready(function() {
            // bsCustomFileInput.init();
            $('.price').show();
            $('.percent').hide();
            var cachepricepercentexact;
            var cachepricepercentmin;
            var cachepricepercentmax;
            var cachepercentforshow;
            var cachepriceexact;
            var cachepricemin;
            var cachepricemax;
            $("input[name*='discount_price']").val($('#old_exact_price').text());
            $("input[name*='discount_min']").val($('#old_min_price').text());
            $("input[name*='discount_max']").val($('#old_max_price').text());
            $("#pricetominus").val('');
            $("input[name*='percent']").val('');


            $("input[name*='percent']").removeAttr('required');
            $("#pricetominus").attr('required');

            $('#discountbase').change(() => {
                let priceselect = $('#discountbase').val();
                console.log(priceselect);
                if (priceselect == 'price') {
                    $('.price').show();
                    $('.percent').hide();
                    $("input[name*='percent']").removeAttr('required');
                    $("#pricetominus").attr('required');

                    if ($('#old_exact_price').text()) {
                        if (cachepriceexact) {

                            setfromcacheexact(cachepriceexact);
                            $('#percentforshow').html("(" + cachepercentforshow + "% OFF)");
                            $("input[name*='percentbyprice']").val(cachepercentforshow);
                            $('#percentforshow').show();
                            errorclear();


                        } else if (cachepriceexact == 0) {
                            console.log('ffff')
                            $("input[name*='discount_price']").val(0);
                            $('#showpricelogicexc').show();
                            cachepriceexact = 0;
                            $('#percentforshow').hide();

                            $('#showpricelogicexc').html('<span style="color:red;">Wrong Price</span>');
                            errorshow();
                        } else {
                            $('#pricetominus').val('');

                            $('#showpricelogic').hide();
                            $('#showpricelogic').html();

                            resetmainprice();
                            errorclear();



                        }
                    } else {
                        if (cachepricemin) {
                            setfromcacheminmax(cachepricemin, cachepricemax);
                            $('#percentforshow').html("(" + cachepercentforshow + "% OFF)");
                            $("input[name*='percentbyprice']").val(cachepercentforshow);

                            $('#percentforshow').show();
                            errorclear();


                        } else if (cachepricemin == 0) {

                            $("input[name*='discount_min']").val(0);
                            $("input[name*='discount_max']").val(0);
                            $('#showpricelogicminmax').show();
                            cachepricemin = 0;
                            cachepricemax = 0;
                            $('#percentforshow').hide();

                            $('#showpricelogicminmax').html('<span style="color:red;">Wrong Price</span>');
                            errorshow();

                        } else {
                            $('#pricetominus').val('');
                            $('#percentforshow').show();

                            $('#showpricelogic').hide();
                            $('#showpricelogic').html();

                            resetmainprice();
                            errorclear();

                        }
                    }

                } else {
                    $('.price').hide();
                    $('.percent').show();

                    $("input[name*='percent']").attr('required');
                    $("#pricetominus").removeAttr('required');

                    $('.percent').attr('required', true);
                    $('#percentforshow').val('');
                    $("input[name*='percentbyprice']").val('');

                    $('#percentforshow').hide();
                    if ($('#old_exact_price').text()) {


                        if (cachepricepercentexact) {
                            setfromcacheexact(cachepricepercentexact);
                            errorclear();
                        } else if (cachepricepercentexact == 0) {
                            console.log('here')
                            $("input[name*='discount_price']").val(0);
                            $('#showpricelogicexc').show();
                            $('#showpricelogicexc').html('<span style="color:red;">Wrong Price</span>');
                            cachepricepercentexact = 0;

                            errorshow();


                        } else {

                            resetmainprice();
                            errorclear();



                        }
                    } else {


                        if (cachepricepercentmin) {
                            setfromcacheminmax(cachepricepercentmin, cachepricepercentmax);
                            errorclear();

                        } else if (cachepricepercentmin == 0) {
                            $("input[name*='discount_min']").val(0);
                            $("input[name*='discount_max']").val(0);
                            $('#showpricelogicminmax').show();
                            cachepricepercentmin = 0;
                            cachepricepercentmax = 0;
                            $('#showpricelogicminmax').html('<span style="color:red;">Wrong Price</span>');
                            errorshow();
                        } else {

                            resetmainprice();
                            errorclear();



                        }
                    }





                }
            });

            function resetmainprice() {
                $("input[name*='discount_price']").val($('#old_exact_price').text());
                $("input[name*='discount_min']").val($('#old_min_price').text());

                $("input[name*='discount_max']").val($('#old_max_price').text());
                showpricemyanmarforexactmain($('#old_exact_price').text());
                showpricemyanmarforminmax($('#old_min_price').text(), $('#old_max_price').text());

            }
            $('#pricetominus').keyup(() => {
                var temp = pricelogicsn($('#pricetominus').val());
                cachepriceminus = $('#pricetominus').val();

                $('#showpricelogic').show();
                $('#showpricelogic').html(temp + ' လျော့မည်');
                if ($('#old_exact_price').text()) {
                    //decrease price process
                    whendiscountpriceactiveforoldexact();
                    //decrease price process
                }
                if ($('#old_min_price').text()) {
                    //decrease price process
                    whendiscountpriceactiveforminmax();
                    //decrease price process
                }
                console.log(temp)
            })

            function setfromcacheexact(value) {
                $("input[name*='discount_price']").val(value);

                showpricemyanmarforexactmain(value);
            }

            function setfromcacheminmax(min, max) {
                $("input[name*='discount_min']").val(min);
                $("input[name*='discount_max']").val(max);

                showpricemyanmarforminmax(min, max);
            }

            function whendiscountpriceactiveforoldexact() {
                var old_exact_price = $('#old_exact_price').text();
                let tempexec = $('#old_exact_price').text() - $('#pricetominus').val();
                if (tempexec < 0) {
                    cachepriceexact = 0;

                    $("input[name*='discount_price']").val(0);
                    $('#showpricelogicexc').show();
                    $('#showpricelogicexc').html('<span style="color:red;">Wrong Price</span>');
                    $('#percentforshow').hide();

                    errorshow();


                } else {
                    cachepriceexact = tempexec;
                    $("input[name*='discount_price']").val(tempexec);

                    console.log(percentforshow)
                    showpercentbyminusprice(tempexec)

                    showpricemyanmarforexactmain(tempexec)
                    errorclear();


                }

            }

            function showpercentbyminusprice(value) {
                $('#percentforshow').show();

                if ($('#old_exact_price').text()) {
                    var old_exact_price = $('#old_exact_price').text();
                    let percentforshow = (value / old_exact_price) * 100;
                    let percentforshowstring = Math.round(100 - percentforshow) + ' % OFF'
                    cachepercentforshow = Math.round(100 - percentforshow);
                    $('#percentforshow').html("(" + percentforshowstring + ")");
                    $("input[name*='percentbyprice']").val(cachepercentforshow);

                } else {
                    var old_min_price = $('#old_min_price').text();
                    let percentforshow = (value / old_min_price) * 100;
                    let percentforshowstring = Math.round(100 - percentforshow) + ' % OFF'
                    cachepercentforshow = Math.round(100 - percentforshow);
                    $('#percentforshow').html("(" + percentforshowstring + ")");
                    $("input[name*='percentbyprice']").val(cachepercentforshow);

                }

            }

            function errorshow() {

                $('#snbtn').addClass('disabled');
                $('#snbtn').attr('disabled', true);

            }

            function errorclear() {

                $('#snbtn').removeClass('sn-submit');
                $('#snbtn').removeClass('disabled');
                $('#snbtn').attr('disabled', false);


            }

            function whendiscountpriceactiveforminmax() {
                var old_min_price = $('#old_min_price').text();
                var old_max_price = $('#old_max_price').text();
                let tempmin = $('#old_min_price').text() - $('#pricetominus').val();
                let tempmax = $('#old_max_price').text() - $('#pricetominus').val();
                if (tempmin < 0 || tempmax < 0) {

                    $("input[name*='discount_min']").val(0);
                    $("input[name*='discount_max']").val(0);
                    $('#showpricelogicminmax').show();
                    cachepricemin = 0;
                    cachepricemax = 0;
                    $('#showpricelogicminmax').html('<span style="color:red;">Wrong Price</span>');
                    $('#percentforshow').hide();

                    errorshow();



                } else {
                    $("input[name*='discount_min']").val(tempmin);
                    $("input[name*='discount_max']").val(tempmax);
                    showpercentbyminusprice(tempmin)
                    $('#percentforshow').show();

                    cachepricemin = tempmin;
                    cachepricemax = tempmax;
                    showpricemyanmarforminmax(tempmin, tempmax)
                    errorclear();


                }

            }


            function showpricemyanmarforexactmain(value) {
                if (value < 0) {
                    $('#showpricelogicexc').show();

                    $('#showpricelogicexc').html('<span style="color:red;">error</span>');

                } else {
                    let tempexecmyanmar = pricelogicsn(value)
                    $('#showpricelogicexc').show();
                    $('#showpricelogicexc').html(tempexecmyanmar + 'ဖြစ်သွားမည်');
                }



            }

            function showpricemyanmarforminmax(min, max) {
                console.log(min)
                if (min < 0) {

                    $('#showpricelogicminmax').show();

                    $('#showpricelogicminmax').html('<span style="color:red;">error</span>');

                } else {
                    let tempminmyanmar = pricelogicsn(min)
                    if (tempminmyanmar == '') {
                        tempminmyanmar = 0
                    }

                    let tempmaxmyanmar = pricelogicsn(max)
                    if (tempmaxmyanmar == '') {
                        tempminmyanmar = 0
                    }
                    $('#showpricelogicminmax').show();
                    $('#showpricelogicminmax').html(tempminmyanmar + '-' + tempmaxmyanmar + 'ဖြစ်သွားမည်');
                }



            }

            var percent = $("input[name*='percent']");

            if ($('#old_exact_price').text()) {


                var exact_price = $("input[name*='discount_price']");
                var old_exact_price = $('#old_exact_price').text();

                percent.on('keyup', function() {
                    var calculated_price = (percent.val() == '' || percent.val() == '0') ? '' :
                        old_exact_price - (old_exact_price * percent.val() / 100);
                    if (calculated_price < 0) {
                        exact_price.val(0);
                        cachepricepercentexact = 0;
                        $('#showpricelogicexc').html('<span style="color:red;">Wrong Price</span>');
                        errorshow();

                    } else {
                        exact_price.val(Math.round(calculated_price));
                        cachepricepercentexact = Math.round(calculated_price);
                        showpricemyanmarforexactmain(Math.round(calculated_price))
                        errorclear();


                    }



                    console.log(calculated_price);
                })

                exact_price.on('keyup', function() {
                    var calculated_percent = (exact_price.val() == '') ? '' : (old_exact_price - exact_price
                        .val()) * 100 / old_exact_price;
                    // percent.val(calculated_percent);
                    percent.val(Math.round(calculated_percent * 10) / 10);
                })

                $('.sn-submit').on('click', function(e) {
                    // if (exact_price.val() == old_exact_price) {
                    //     e.preventDefault();
                    //     $('.sn-cancel-form')[0].click();
                    // }
                })

            } else {

                var min_price = $("input[name*='discount_min']");
                var max_price = $("input[name*='discount_max']");
                var old_min_price = $('#old_min_price').text();
                var old_max_price = $('#old_max_price').text();

                percent.on('keyup', function() {
                    var calculated_min_price = (percent.val() == '' || percent.val() == '0') ? '' :
                        old_min_price - (old_min_price * percent.val() / 100);
                    var calculated_max_price = (percent.val() == '' || percent.val() == '0') ? '' :
                        old_max_price - (old_max_price * percent.val() / 100);
                    if (calculated_min_price < 0) {
                        min_price.val(0);
                        max_price.val(0);
                        cachepricepercentmin = 0;
                        cachepricepercentexact = 0
                        $('#showpricelogicminmax').html('<span style="color:red;">Wrong Price</span>');
                        errorshow();

                    } else {
                        min_price.val(Math.round(calculated_min_price));
                        max_price.val(Math.round(calculated_max_price));
                        cachepricepercentmin = Math.round(calculated_min_price);
                        cachepricepercentmax = Math.round(calculated_max_price);
                        errorclear();

                        showpricemyanmarforminmax(Math.round(calculated_min_price), Math.round(
                            calculated_max_price))
                    }



                })
                $('.sn-submit').on('click', function(e) {
                    // if (percent.val() == '0') {
                    //     e.preventDefault();
                    //     $('.sn-cancel-form')[0].click();
                    // }
                })
            }
        })
    </script>
@endpush
