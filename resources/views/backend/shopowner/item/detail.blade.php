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
            @if (Session::has('message'))
                <x-alert></x-alert>
            @endif

            <!-- zhheader shopname -->
            <x-header>
                @foreach ($shopowner as $shopowner)
                @endforeach
                {{ $shopowner->shop_name }}
            </x-header>
            <!-- end zh header shopname -->

            <x-title>
                ID: {{ $item->product_code }}
            </x-title>
            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card card-solid">
                    <div class="card-body">
                        <div id=""
                            class="row product type-product post-553 status-publish first instock product_cat-accessories product_cat-bracelet product_cat-brand product_cat-earrings product_cat-fragrances product_cat-gift-for-men has-post-thumbnail shipping-taxable purchasable product-type-simple ">
                            @if ($item->check_discount != 'no')
                                <?php
                                $get_dis = \App\Models\discount::where('id', $item->check_discount)->first();
                                ?>
                                {{-- <h3 class="product_title entry-title yk-jello-horizontal sn-discount-badge">
                                    {{$get_dis->percent}}% <span class="sn-off-text">OFF</span></h3> --}}
                            @endif


                            <div class="details-img col-12 col-md-6 col-xl-4">

                                <div id="mainCarousel" class="carousel w-10/12 max-w-5xl mx-auto">
                                    @if(dofile_exists('/items/mid/'.$item->default_photo))

                                    @if ($item->default_photo != '')
                                        <div class="carousel__slide "
                                            data-src="{{ filedopath('/items/' . $item->default_photo) }}"
                                            data-fancybox="group">
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
                                    @endif

                                    @if ($item->photo_one != '' && $item->photo_one != $item->default_photo)
                                        <div class="carousel__slide "
                                            data-src="{{ filedopath('/items/mid' . $item->photo_one) }}"
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
                                        <div class="carousel__slide "
                                            data-src="{{ filedopath('/items/' . $item->photo_two) }}" data-fancybox="group">
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
                                        <div class="carousel__slide "
                                            data-src="{{ filedopath('/items/' . $item->photo_three) }}"
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
                                        <div class="carousel__slide "
                                            data-src="{{ filedopath('/items/' . $item->photo_four) }}" data-fancybox="group">
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
                                        <div class="carousel__slide "
                                            data-src="{{ filedopath('/items/' . $item->photo_five) }}" data-fancybox="group">
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
                                        <div class="carousel__slide "
                                            data-src="{{ filedopath('/items/' . $item->photo_six) }}" data-fancybox="group">
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
                                        <div class="carousel__slide "
                                            data-src="{{ filedopath('/items/' . $item->photo_seven) }}"
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
                                            data-src="{{ filedopath('/items/' . $item->photo_eight) }}"
                                            data-fancybox="group">
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
                                            data-src="{{ filedopath('/items/' . $item->photo_nine) }}"
                                            data-fancybox="group">
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
                                        <div class="carousel__slide "
                                            data-src="{{ filedopath('/items/' . $item->photo_ten) }}"
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
                                    @if(dofile_exists('/items/'.$item->default_photo))

                                    @if ($item->default_photo != '')
                                        @if (dofile_exists('/images/items/thumbs/' . $item->default_photo))
                                            <div class="carousel__slide">
                                                <img class=""
                                                    src="{{ filedopath('/items/thumbs/' . $item->default_photo) }}" />
                                            </div>
                                        @else
                                            <div class="carousel__slide">
                                                <img class=""
                                                    src="{{ filedopath('/items/' . $item->default_photo) }}" />
                                            </div>
                                        @endif
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
                                                <img class=""
                                                    src="{{ filedopath('/items/' . $item->photo_three) }}" />
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
                                                <img class=""
                                                    src="{{ filedopath('/items/' . $item->photo_four) }}" />
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
                                                <img class=""
                                                    src="{{ filedopath('/items/' . $item->photo_five) }}" />
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
                                                <img class=""
                                                    src="{{ filedopath('/items/' . $item->photo_seven) }}" />
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
                                                <img class=""
                                                    src="{{ filedopath('/items/' . $item->photo_eight) }}" />
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
                                                <img class=""
                                                    src="{{ filedopath('/items/' . $item->photo_nine) }}" />
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

                            <div class="summary entry-summary col-12 col-md-6  col-xl-7" style="padding-right: 0;">
                                <div class="row">
                                    <div class="col-8">
                                        <p class="price">
                                            @if ($item->check_discount != '0')
                                                @if ($item->price != 0)
                                                    <span class="woocommerce-Price-amount amount sn-origin-amount"><bdi
                                                            style="text-decoration: line-through !important;">Ks
                                                            {{ number_format($item->price) }}</bdi>
                                                    </span>
                                                @else
                                                    <span class="woocommerce-Price-amount amount sn-origin-amount"><bdi
                                                            style="text-decoration: line-through !important;">Ks
                                                            {{ number_format($item->min_price) }}-{{ number_format($item->max_price) }}</bdi>
                                                    </span>
                                                @endif
                                                @if ($get_dis->discount_price != 0)
                                                    <span
                                                        class="woocommerce-Price-amount amount yk-amount sn-discount-amount"><bdi
                                                            style="font-size:22px !important;"><span
                                                                class="woocommerce-Price-currencySymbol"></span>Ks
                                                            {{ number_format($get_dis->discount_price) }}</bdi>
                                                    </span>
                                                @else
                                                    <span class="woocommerce-Price-amount amount yk-amount"><bdi
                                                            style="font-size:22px !important;"><span
                                                                class="woocommerce-Price-currencySymbol"></span>Ks
                                                            {{ number_format($get_dis->discount_min) }}-{{ number_format($get_dis->discount_max) }}
                                                        </bdi>
                                                    </span>
                                                @endif
                                            @else
                                                @if ($item->price != 0)
                                                    <span class="woocommerce-Price-amount amount yk-amount"><bdi
                                                            style="font-size:22px !important;"><span
                                                                class="woocommerce-Price-currencySymbol"></span>Ks
                                                            {{ number_format($item->price) }} </bdi>
                                                    </span>
                                                @else
                                                    <span class="woocommerce-Price-amount amount yk-amount"><bdi
                                                            style="font-size:22px !important;"><span
                                                                class="woocommerce-Price-currencySymbol"></span>Ks
                                                            {{ number_format($item->min_price) }}-{{ number_format($item->max_price) }}</bdi>
                                                    </span>
                                                @endif
                                            @endif
                                        </p>
                                        <h1 class="product_title entry-title sn-product-title">{{ $item->name }}<span
                                                class="zh-pc" style="color:grey;"> ({{ $item->product_code }})</span>
                                        </h1>
                                    </div>
                                    <div class="col-12">
                                        <!-- zh view count -->
                                        <div class="d-flex">
                                            <div>
                                                <i class=" fa fa-user"
                                                    style="
                                            margin-bottom: 20px;
                                            margin-top: 12px;
                                            margin-left: 11px;
                                            color: grey;
                                            text-color: grey;
                                        "></i><span
                                                    style="
                                                    margin-left: 5px;
                                                    color: grey;
                                                ">{{ $item->yk_view }}</span>
                                                <span
                                                    style="
                                                    color: grey;
                                                ">ကြည့်ရူသူ</span>
                                            </div>
                                            <div id="vf-count">
                                            </div>
                                        </div>

                                        @if ($item->stock == 'In Stock')
                                            <p class="availability stock in-stock sn-product-instock">
                                                <span>In Stock {{ $item->stock_count }}</span>
                                            </p>
                                        @else
                                            <p class="availability stock in-stock sn-product-outstock"
                                                style="color:red !important;">
                                                <span>Out Of Stock</span>
                                            </p>
                                        @endif
                                    </div>
                                </div>


                                {{--                                @if (strlen($item->description) < 220) --}}
                                {{--                                    <readmore-detail longdesc="{{$item->description}}" noti="0" --}}
                                {{--                                                     shortdesc="{{\Illuminate\Support\Str::limit($item->description, 220, '...')}}"></readmore-detail> --}}
                                {{--                                @else --}}
                                {{--                                    <readmore-detail class="sn-product-des" longdesc="{{$item->description}}" noti="1" --}}
                                {{--                                                     shortdesc="{{\Illuminate\Support\Str::limit($item->description, 220, '...')}}"></readmore-detail> --}}

                                {{--                                @endif --}}

                                <div class="sn-product-detail">
                                    <div class="row">
                                        <div class="col-10 sn-accordion">
                                            <div class="sn-accordion-item">
                                                <input type="checkbox" class="sn-accordion-checkbox" checked>
                                                <i class="sn-accordion-arrow"></i>

                                                <h1 class="product_title entry-title sn-accordion-title"
                                                    style="text-transform: none!important;">Product အချက်အလက်များ</h1>
                                                <div class="sku-wrapper product_meta sn-accordion-content">
                                                    <div class="zh-row row">
                                                        <div class="col-6">
                                                            <span class="sn-detail-title font-red sop-font">ရတနာ
                                                                အမျိုးအစား</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="sku sop-font"
                                                                itemprop="sku">{{ $item->MainCategoryName }}</span>
                                                        </div>
                                                    </div>
                                                    @if (!empty($item->size))
                                                        <div class="zh-row row">
                                                            <div class="col-6">
                                                                <span class="sn-detail-title font-red sop-font">Size</span>
                                                            </div>
                                                            <div class="col-6">
                                                                <span class="sku sop-font"
                                                                    itemprop="sku">{{ $item->size }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="zh-row row">
                                                        <div class="col-6">
                                                            <span class="sn-detail-title font-red sop-font">Category</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="sku sop-font"
                                                                itemprop="sku">{{ $item->YkbeautyCat }}</span>
                                                        </div>
                                                    </div>
                                                    @if ($item->weight_unit != '0')
                                                        <div class="zh-row row">
                                                            <div class="col-6">
                                                                <span class="font-red sn-detail-title "
                                                                    style="">အလေးချိန်</span>
                                                            </div>
                                                            <div class="col-6">
                                                                <?php
                                                                $weight = json_decode($item->weight, true);
                                                                ?>
                                                                @foreach ($weight as $w)
                                                                    <span class="sku"
                                                                        itemprop="sku">{{ $w['value'] }}
                                                                        {{ $w['name'] }}</span>
                                                                    ,
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="zh-row row">
                                                        <div class="col-6">
                                                            <span class="sn-detail-title font-red">အရည်အသွေး</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="sku"
                                                                itemprop="sku">{{ $item->gold_quality }}</span>
                                                        </div>
                                                    </div>
                                                    @if ($item->gems_data != 'empty')
                                                        <?php
                                                        $gems = json_decode($item->gems_data, true);
                                                        ?>
                                                        @if (!empty($gems))
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <span
                                                                        class="sn-detail-title font-red">ပါဝင်ကျောက်</span>
                                                                </div>
                                                            </div>
                                                            <div class="zh-row row ">
                                                                @foreach ($gems as $g)
                                                                    <div class="col-6  pt-3">
                                                                        <span class="sku font-yellow"
                                                                            itemprop="sku">{{ $g['name'] }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-6  pt-3">
                                                                        <span class="sku" itemprop="sku">
                                                                            {{ 'အရေအတွက်- ' . $g['count'] . 'လုံး' }}
                                                                            @if ($g['carat'] != 0 || $g['yati'] != 0 || $g['pwint'] != 0)
                                                                                <br />
                                                                            @endif
                                                                            @if ($g['carat'] != 0)
                                                                                {{ 'ကာရက်- ' . $g['carat'] }}
                                                                            @endif
                                                                            @if ($g['yati'] != 0 || $g['pwint'] != 0)
                                                                                <br />
                                                                            @endif
                                                                            @if ($g['yati'] != 0)
                                                                                {{ 'ရတီ- ' . $g['yati'] }}
                                                                            @endif
                                                                            @if ($g['pwint'] != 0)
                                                                                <br />
                                                                            @endif
                                                                            {{-- @if ($g['pwint'] != 0) {{'ပွင့်- '.$g['pwint']}} @endif
                                                                            @if ($g['pwint'] != 0)<br/>@endif --}}
                                                                            @if ($g['pwint'] != 0)
                                                                                {{ 'ဘီ- ' . $g['pwint'] }}
                                                                            @endif
                                                                        </span>
                                                                        <br>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    @endif
                                                    <div class="zh-row row">
                                                        <div class="col-6">
                                                            <span class="sn-detail-title font-red">အရောင်</span>
                                                        </div>
                                                        <div class="col-6">
                                                            <span class="sku"
                                                                itemprop="sku">{{ $item->gold_colour }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="zh-row row">
                                                        <div class="col-6">
                                                            <span class="sn-detail-title font-red">Gender</span>
                                                        </div>
                                                        <div class="col-6 d-flex align-items-center">
                                                            @switch($item->gender)
                                                                @case('Kid')
                                                                    <i class="fa fa-child px-1" style="font-size:22px;"></i>
                                                                    <span class="sku" itemprop="sku">ကလေးဝတ်</span>
                                                                @break

                                                                @case('Couple')
                                                                    <img src="{{ asset('images/icons/couple.png') }}"
                                                                        class="px-1" alt=""
                                                                        style="height:22px; color:#d80007;">
                                                                    <span class="sku" itemprop="sku">စုံတွဲဝတ်</span>
                                                                @break

                                                                @case('Women')
                                                                    <i class="fa fa-venus px-1" aria-hidden="true"
                                                                        style="font-size:22px; color:#F7BEC0;"></i>
                                                                    <span class="sku" itemprop="sku">အမျိုးသမီးဝတ်</span>
                                                                @break

                                                                @case('Men')
                                                                    <i class="fa fa-mars px-1" aria-hidden="true"
                                                                        style="font-size:22px; color:#2E8BC0;"></i>
                                                                    <span class="sku" itemprop="sku">အမျိုးသားဝတ်</span>
                                                                @break

                                                                @case('UniSex')
                                                                    <i class="fa-solid fa-genderless px-1" aria-hidden="true"
                                                                        style="font-size:22px; color:#000000;"></i>
                                                                    <span class="sku" itemprop="sku">အားလုံးဝတ်</span>
                                                                @break

                                                                @default
                                                                    <span></span>
                                                            @endswitch


                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-10 sn-accordion">
                                            <div class="sn-accordion-item">
                                                <input type="checkbox" class="sn-accordion-checkbox" checked>
                                                <i class="sn-accordion-arrow"></i>
                                                <h1 class="product_title entry-title sn-accordion-title">ဆိုင်
                                                    အချက်အလက်များ</h1>
                                                <div class="sku-wrapper product_meta sn-accordion-content" style="">
                                                    <div class="zh-row row ">
                                                        <div class="col-8 ">
                                                            <span class="sn-detail-title font-red">ဆိုင်အမည်</span>
                                                        </div>
                                                        <div class="col-4 ">
                                                            <a class="sn-shop-link"
                                                                href="{{ url('/shops/' . $item->shop_name->id) }}">
                                                                {{ $item->shop_name->shop_name }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="zh-row row">
                                                        <div class="col-8 ">
                                                            <span class="sn-detail-title font-red">အလျော့တွက်</span>
                                                        </div>
                                                        <div class="col-4 ">
                                                            <span class="sku"
                                                                itemprop="sku">{{ $item->handmade }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="zh-row row">
                                                        <div class="col-8 ">
                                                            <span class="sn-detail-title font-red">လက်ခ</span>
                                                        </div>

                                                        <div class="col-4 ">
                                                            <span class="sku" itemprop="sku">
                                                                @if (empty($item->charge))
                                                                    @else{{ $item->charge }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="zh-row row">
                                                        <div class="col-8 ">
                                                            <span
                                                                class="sn-detail-title font-red">အထည်မပျက်ပြန်သွင်း</span>
                                                        </div>
                                                        <div class="col-4 ">
                                                            <span class="sku"
                                                                itemprop="sku">{{ $item->undamaged_product }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="zh-row row">
                                                        <div class="col-8 ">
                                                            <span
                                                                class="sn-detail-title font-red">အထည်ပျက်စီး ချို့ယွင်း</span>
                                                        </div>
                                                        <div class="col-4 ">
                                                            <span class="sku"
                                                                itemprop="sku">{{ $item->damaged_product }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="zh-row row">
                                                        <div class="col-8 ">
                                                            <span class="sn-detail-title font-red">တန်ဖိုးမြင့်အထည်နှင့်
                                                                အထည်မပျက်ပြန်လဲ</span>
                                                        </div>
                                                        <div class="col-4 ">
                                                            <span class="sku"
                                                                itemprop="sku">{{ $item->valuable_product }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="" style="margin: 0 10px; font-weight:400">

                                    @if (count($item->tags) != 0)
                                        <i class="fa-solid fa-tag fa-flip-horizontal"></i> ပစ္စည်းအမျိုးအစား :

                                        @foreach ($item->tags as $itg)
                                            <a href="{{ url('tags/' . $itg->name) }}"
                                                style="color:#780116 !important; text-decoration: underline!important;">{{ $itg->name }}</a>
                                            @if ($loop->remaining != 0)
                                                ,
                                            @endif
                                        @endforeach
                                    @endif
                                </div>

                            </div>
                        </div>


                        <div class="row justify-content-between mt-4 px-2 px-lg-3">
                            <div class="">
                                {{-- @isRole('shopowner') --}}
                                    <a class="btn btn-md btn-danger" onclick="Delete()"><span
                                            class="fa fa-trash"></span>&nbsp;&nbsp;Delete</a>
                                    <form id="delete_form"
                                        action="{{ route('backside.shop_owner.items.destroy', ['item' => $item->id]) }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <input type="hidden" name="id" value="{{ $item->id }}" />
                                    </form>
                                {{-- @endisRole --}}
                            </div>
                            <div class="row">
                                @if ($item->check_discount == '0')
                                    <a href="{{ url('backside/shop_owner/item/discount/' . $item->id) }}"
                                        class="btn btn-md btn-info"><i class="fa-solid fa-percent"></i>&nbsp;&nbsp;Set
                                        Discount</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                @else
                                    <a href="javascript:void(0);" class="btn btn-md btn-info"
                                        onclick="unsetDiscount()"><i class="fa-solid fa-percent"></i>&nbsp;&nbsp;Unset
                                        Discount</a>&nbsp;
                                    <form id="unset" action="{{ url('backside/shop_owner/item/discount_remove') }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <input type="hidden" name="id" value="{{ $item->check_discount }}" />
                                        <input type="hidden" name="item_id" value="{{ $item->id }}" />
                                    </form>
                                @endif

                                <a href="{{ route('backside.shop_owner.items.edit', ['item' => $item->id]) }}"
                                    class="btn btn-md btn-success" style="background-color:#4E73F8"><span
                                        class="fa fa-edit"></span>&nbsp;&nbsp;Edit</a>
                            </div>
                        </div>

                    </div>

                    <!-- /.card-body -->
                </div>

                <!-- /.card -->

            </section>
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

@push('css')
    <style>
        .sn-shop-title {
            margin: 20px auto 15px;
            text-align: center;
        }

        .sn-shop-title h2 {
            margin-top: 5px;
            font-size: 1.25rem;
            color: #747474;
        }

        .sn-site-content {
            margin-top: 20px;

            font-family: 'Myanmar3', Sans-Serif !important;
            /* font-family: 'Roboto', sans-serif; */

        }

        .sn-product-image {
            border-radius: 6px;
            width: 600px !important;
            vertical-align: inherit !important;
        }

        .sn-product-thumb {
            border-radius: 7px;
        }

        #sync2 .owl-stage {
            width: auto !important;
        }

        #sync2 .owl-item {
            width: auto !important;
            margin-right: 15px !important;
            margin-bottom: 15px !important;
        }

        .sn-discount-badge {
            background: #ff0000e0;
            display: inline-block;
            padding: 7px 10px 4px !important;
            margin-bottom: 10px !important;
            margin-left: 10px !important;
            font-size: 16px !important;
            font-weight: 900;
            color: #fff;
            border-radius: 50px;
        }

        .sn-off-text {
            font-size: 13px;
        }

        .sn-origin-amount {
            color: #6c6c6c !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            line-height: 28px !important;
            float: left !important;
            margin-left: 10px !important;
        }

        .sn-discount-amount bdi {
            letter-spacing: 1px !important;
        }

        .sn-product-title {
            margin: 0 0 5px 10px !important;
        }

        .sn-product-instock {
            margin: 3px auto 35px 10px !important;
        }

        .sn-product-instock span {
            background-color: #b8ffb8;
            color: #007000;
            padding: 3px 10px;
            border-radius: 50px;
            text-transform: none !important;
        }

        .sn-product-outstock {
            margin: 3px auto 35px 10px !important;
        }

        .sn-product-outstock span {
            background-color: #ffd9c3;
            color: #ff5f01;
            padding: 3px 10px;
            border-radius: 50px;
            text-transform: none !important;
        }

        .sn-product-des {
            margin-left: 10px;
            position: relative !important;
            line-height: 1.8;
        }

        .sn-product-des button {
            background: none !important;
            padding: 0 !important;
            color: #646464 !important;
            border-bottom: 1.5px dotted;
            border-radius: 0;
        }

        .sn-product-des .fa-arrow-up,
        .sn-product-des .fa-arrow-down {
            position: unset !important;
            margin-left: 7px;
        }

        .sn-product-des .fa-arrow-up::before {
            transform: translateX(2px) rotate(45deg);
        }

        .sn-product-des .fa-arrow-up::after {
            transform: translateX(-2px) rotate(-45deg);
        }

        .sn-product-des .fa-arrow-down::before {
            transform: translateX(-2px) rotate(45deg);
        }

        .sn-product-des .fa-arrow-down::after {
            transform: translateX(2px) rotate(-45deg);
        }

        .sn-product-des .fa-arrow-up::before,
        .sn-product-des .fa-arrow-up::after,
        .sn-product-des .fa-arrow-down::before,
        .sn-product-des .fa-arrow-down::after {
            content: "" !important;
            position: absolute !important;
            bottom: 10px;
            background-color: #646464;
            width: 2px;
            height: 8px;
            transition: transform 0.25s ease-in-out;
        }

        #sync2 .item {
            width: 75px !important;
        }

        .sn-product-detail {
            margin-top: 30px;
            margin-left: 10px;
            line-height: 2rem;
            /* zh-modify */
            /*font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;*/
        }

        .sn-product-detail h1 {
            margin: 15px auto 10px;
        }

        .sn-similar-seeall {
            position: absolute;
            top: 10%;
            margin: 0 40px;
            text-align: center;
        }

        .sn-similar-seeall a {
            padding: 10px;
        }

        .sn-similar-seeall i {
            padding: 15px;
            border: 1px solid #dbdbdb;
            background: white;
            border-radius: 50%;
            font-size: 25px;
            box-shadow: 0px 0px 5px 1px #e5e5e5;
            color: #a3a3a3;
        }

        .sn-similar-seeall .see-all-text {
            margin: 12px 0 0;
        }


        .sn-accordion {
            width: 100% !important;
        }

        .sn-accordion-checkbox {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            opacity: 0;
        }

        .sn-accordion-arrow {
            position: absolute;
            right: 0;
            margin-top: 10px;
            margin-right: 6%;
            z-index: 0;
        }

        .sn-accordion-arrow::before,
        .sn-accordion-arrow::after {
            content: "";
            position: absolute;
            background-color: #313131;
            width: 2px;
            height: 8px;
            transition: transform 0.25s ease-in-out;
        }

        .sn-accordion-arrow::before {
            transform: translateX(-2px) rotate(45deg);
        }

        .sn-accordion-arrow::after {
            transform: translateX(2px) rotate(-45deg);
        }

        .sn-accordion-checkbox:checked~.sn-accordion-arrow::before {
            transform: translateX(2px) rotate(45deg);
        }

        .sn-accordion-checkbox:checked~.sn-accordion-arrow::after {
            transform: translateX(-2px) rotate(-45deg);
        }

        .sn-accordion-title {
            margin-top: 30 !important;
            margin-bottom: 0 !important;
        }

        .sn-accordion-item {
            position: relative;
        }

        .sn-accordion-content {
            position: relative;

            margin: 25px 0 0;
            opacity: 1;
            overflow: hidden;
            transition: all 0.35s ease-in-out;
            line-height: 1.6;
            z-index: 2;
        }

        .sn-accordion-checkbox:checked~.sn-accordion-content {
            max-height: 0;
            opacity: 0;
        }

        .sn-shop-link {
            border-bottom: 1px dotted;
            color: #ee6412 !important;
        }

        .sn-wrapper {
            margin: 0 !important;
        }

        .sn-wrapper h3 {
            font-size: 16px;
            font-weight: 900;
            margin: 13px 0 10px !important;
        }

        .sn-wrapper .sn-detail-title {
            font-size: 16px !important;
            /* zh-modify */
            font-weight: bold !important;
            color: #000;
            margin-right: 7px;
        }

        /* zh animation */
        .sn-wrapper span {
            opacity: 0%;
            animation-name: span;
            animation-duration: 1s;
            animation-fill-mode: forwards;
        }

        @keyframes span {
            from {
                opacity: 0%;
            }

            to {
                opacity: 100%;
            }
        }

        .yk-product-image {
            width: 100% !important;
            height: 300px !important;
            vertical-align: inherit !important;
            object-fit: cover;
        }

        .sop-ribbon-pd span {
            width: 136px;
            height: 30px;
            top: 13px;
            right: -46px;
            position: absolute;
            display: block;
            background: #FF0000;
            color: #333;
            font-family: arial;
            font-size: 14px;
            color: white;
            text-align: center;
            line-height: 30px;
            transform: rotate(45deg);
            -webkit-transform: rotate(52deg);
        }

        .sop-ribbon-pd {
            height: 110px;
            display: block;
            position: absolute;
            z-index: 111;
            top: 0;
            right: 0;
        }

        .sn-buynow-button {
            /* zh-modify */
            background: #fff !important;
            border-radius: 5px !important;
            border-color: #780116 !important;
            width: 100% !important;
            margin: 20px auto 0;
            color: #000 !important;
            font-size: 18px !important;
            padding: 7px 0 !important;
            font-weight: 500 !important;
        }

        .sn-buynow-button:HOVER {
            background: #f3f3f3b9 !important;
        }

        .zh-addtocart-button {
            background: #780116 !important;
            border-radius: 5px !important;
            border-color: #780116 !important;
            width: 100% !important;
            margin: 20px auto 0;
            color: rgba(247, 181, 56, 1) !important;
            font-size: 18px !important;
            padding: 7px 0 !important;
            font-weight: 500 !important;
        }

        .font-red {
            color: #ac0221 !important;
            font-weight: 700 !important;
            font-size: 17px;
        }

        .entry-summary p.stock.in-stock {
            display: block !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function Delete() {
            $(function() {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-danger ml-2',
                        cancelButton: 'btn btn-info'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete_form').submit();
                    }
                })
            });
        };

        function unsetDiscount() {
            $(function() {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-danger ml-2',
                        cancelButton: 'btn btn-info'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Unset Discount it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('unset').submit();
                    }
                })
            });
        }
    </script>
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
@endpush
