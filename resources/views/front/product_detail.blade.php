@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu')

    <div id="page" class="site container-fluid my-0 py-0">
        {{-- MENU --}}

        {{-- end Menu --}}
        <!-- .site-content-contain -->


        <div class="site-content-contain sn-site-content">

        </div>

        <!-- .site-content-contain -->
        <div class="site-content-contain">

            <div class="mx-4 px-md-5 show_breadcrumb_">



                <div class="row">
                    <div id="main-content" class="show_dev col-sm-9 col-xs-12 d-none">

                        {{-- for photo slide and tilte --}}
                        <div id=""
                            class="row product type-product post-553 status-publish first instock product_cat-accessories product_cat-bracelet product_cat-brand product_cat-earrings product_cat-fragrances product_cat-gift-for-men has-post-thumbnail shipping-taxable purchasable product-type-simple ">
                            @if ($item->check_discount != 'no')
                                <?php
                                $get_dis = \App\Models\Discount::where('id', $item->check_discount)->first();
                                ?>
                                {{-- <h3 class="product_title entry-title yk-jello-horizontal sn-discount-badge">
                                    {{$get_dis->percent}}% <span class="sn-off-text">OFF</span></h3> --}}
                            @endif

                            <div class="details-img col-12 col-md-6 col-xl-4">

                                <div id="mainCarousel" class="carousel w-10/12 max-w-5xl mx-auto">
                                    @if (dofile_exists('/items/' . $item->default_photo))

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
                                            data-src="{{ filedopath('/items/' . $item->photo_one) }}"
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
                                            data-src="{{ filedopath('/items/' . $item->photo_four) }}"
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
                                        <div class="carousel__slide "
                                            data-src="{{ filedopath('/items/' . $item->photo_five) }}"
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
                                        <div class="carousel__slide "
                                            data-src="{{ filedopath('/items/' . $item->photo_six) }}"
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
                                    @if (dofile_exists('/items/' . $item->default_photo))
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
                                                <img class=""
                                                    src="{{ filedopath('/items/' . $item->photo_one) }}" />

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
                                                <img class=""
                                                    src="{{ filedopath('/items/' . $item->photo_two) }}" />

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
                                                <img class=""
                                                    src="{{ filedopath('/items/' . $item->photo_six) }}" />

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
                                                <img class=""
                                                    src="{{ filedopath('/items/' . $item->photo_ten) }}" />

                                            </div>
                                        @endif
                                    @endif

                                </div>

                            </div>


                            <div class="summary entry-summary col-12 col-md-6">
                                <div class="row">
                                    <div class="col-12">
                                        <!-- zh view count -->
                                        <div class="d-flex">
                                            <div class="marginleft">
                                                <span class="sop-font">Uploaded on</span>
                                                <span
                                                    class="grey">{{ Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8">


                                        <p class="price">

                                            @if ($item->check_discount != '0')
                                                @if ($item->price != 0)
                                                    <span class="woocommerce-Price-amount amount sn-origin-amount"><bdi
                                                            class="mprice">Ks {{ number_format($item->price) }}</bdi>
                                                    </span>
                                                @else
                                                    <span class="woocommerce-Price-amount amount sn-origin-amount"><bdi
                                                            class="mprice">Ks
                                                            {{ number_format($item->min_price) }}-{{ number_format($item->max_price) }}</bdi>
                                                    </span>
                                                @endif
                                                @if ($get_dis->discount_price != 0)
                                                    <span
                                                        class="woocommerce-Price-amount amount yk-amount sn-discount-amount"><bdi
                                                            class=""><span
                                                                class="woocommerce-Price-currencySymbol"></span>Ks
                                                            {{ number_format($get_dis->discount_price) }}</bdi>
                                                    </span>
                                                @else
                                                    <span class="woocommerce-Price-amount amount yk-amount"><bdi
                                                            class=""><span
                                                                class="woocommerce-Price-currencySymbol"></span>Ks
                                                            {{ number_format($get_dis->discount_min) }}-{{ number_format($get_dis->discount_max) }}
                                                        </bdi>
                                                    </span>
                                                @endif
                                            @else
                                                @if ($item->price != 0)
                                                    <span class="woocommerce-Price-amount amount yk-amount"><bdi
                                                            class=""><span
                                                                class="woocommerce-Price-currencySymbol"></span>Ks
                                                            {{ number_format($item->price) }} </bdi>
                                                    </span>
                                                @else
                                                    <span class="woocommerce-Price-amount amount yk-amount"><bdi><span
                                                                class="woocommerce-Price-currencySymbol"></span>Ks
                                                            {{ number_format($item->min_price) }}-{{ number_format($item->max_price) }}</bdi>
                                                    </span>
                                                @endif
                                            @endif
                                        </p>
                                        <h1 class="product_title entry-title sn-product-title sop-font">
                                            {{ $item->name }}
                                            <span class="zh-pc"> ({{ $item->product_code }})</span>
                                        </h1>

                                    </div>
                                    <div class="col-4 d-flex justify-content-end ">
                                        <div onclick="favclick('{{ $item->id }}','{{ Auth::check() }}')"
                                            id="fav"
                                            class="sop-product-d-p c-pointer d-flex flex-column justify-content-start align-items-center h-100">

                                            <div>
                                                <i id="ficon" class="zh-icon fa-regular fa-heart fa-2xl"></i>
                                            </div>
                                            <div class="pt-2">
                                                <p class="sop-font">ကြိုက်တယ်</p>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <!-- zh view count -->
                                        <div class="d-flex">
                                            <div>
                                                <i class="fa fa-user userstyle"></i><span
                                                    class="leftgrey">{{ $item->yk_view }}</span>
                                                <span class="sop-font">ကြည့်ရူသူ</span>
                                            </div>
                                            <div id="vf-count">

                                            </div>


                                        </div>

                                        @if ($item->stock == 'In Stock')
                                            <p class="availability stock in-stock sn-product-instock">
                                                <span>In Stock {{ $item->stock_count }}</span>
                                            </p>
                                        @else
                                            <p class="availability stock in-stock sn-product-outstock">
                                                <span>Out Of Stock</span>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                @if (strlen($item->description) < 220)
                                    <readmore-detail longdesc="{{ $item->description }}" noti="0" class="sop-font"
                                        shortdesc="{{ \Illuminate\Support\Str::limit($item->description, 220, '...') }}">
                                    </readmore-detail>
                                @else
                                    <readmore-detail class="sop-font" class="sn-product-des"
                                        longdesc="{{ $item->description }}" noti="1"
                                        shortdesc="{{ \Illuminate\Support\Str::limit($item->description, 220, '...') }}">
                                    </readmore-detail>
                                @endif
                                <div class="sn-product-detail">

                                    <div class="row">

                                        <div class="col-10 sn-accordion">
                                            <div class="sn-accordion-item">
                                                <input type="checkbox" class="sn-accordion-checkbox" checked>
                                                <i class="sn-accordion-arrow"></i>

                                                <h1 class="product_title entry-title sn-accordion-title sop-font">Product
                                                    အချက်အလက်များ</h1>
                                                <div class="sku-wrapper product_meta sn-accordion-content">
                                                    <div class="zh-row row">
                                                        <div class="col-4">
                                                            <span class="sn-detail-title font-red sop-font">ရတနာ
                                                                အမျိုးအစား</span>
                                                        </div>
                                                        <div class="col-8">
                                                            <span class="sku sop-font"
                                                                itemprop="sku">{{ $item->MainCategoryName }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="zh-row row">
                                                        <div class="col-4">
                                                            <span
                                                                class="font-red sn-detail-title sop-font">အလေးချိန်</span>


                                                        </div>
                                                        <div class="col-8">
                                                            <?php
                                                            $weight = json_decode($item->weight, true);
                                                            ?>
                                                            @foreach ($weight as $w)
                                                                <span class="sku" itemprop="sku">{{ $w['value'] }}
                                                                    {{ $w['name'] }}</span>
                                                                ,
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <div class="zh-row row">
                                                        <div class="col-4">
                                                            <span
                                                                class="sn-detail-title font-red sop-font">အရည်အသွေး</span>
                                                        </div>
                                                        <div class="col-8">
                                                            <span class="sku sop-font"
                                                                itemprop="sku">{{ $item->gold_quality }}</span>
                                                        </div>
                                                    </div>
                                                    @if (!empty($item->size))
                                                        <div class="zh-row row">
                                                            <div class="col-4">
                                                                <span class="sn-detail-title font-red sop-font">Size</span>
                                                            </div>
                                                            <div class="col-8">
                                                                <span class="sku sop-font"
                                                                    itemprop="sku">{{ $item->size }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="zh-row row">
                                                        <div class="col-4">
                                                            <span class="sn-detail-title font-red sop-font">Category</span>
                                                        </div>
                                                        <div class="col-8">
                                                            <span class="sku sop-font"
                                                                itemprop="sku">{{ $item->YkbeautyCat }}</span>
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
                                                                        class="sn-detail-title font-red sop-font">ပါဝင်ကျောက်</span>
                                                                </div>
                                                            </div>
                                                            <div class=" zh-row row ">
                                                                @foreach ($gems as $g)
                                                                    <div class="col-4  pt-3">
                                                                        <span class="sku font-yellow sop-font"
                                                                            itemprop="sku">{{ $g['name'] }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-8  pt-3">
                                                                        <span class="sku sop-font" itemprop="sku">
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
                                                                        </span><br>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif

                                                    @endif
                                                    <div class="zh-row row">
                                                        <div class="col-4">
                                                            <span class="sn-detail-title font-red sop-font">အရောင်</span>
                                                        </div>
                                                        <div class="col-8">
                                                            <span class="sku sop-font"
                                                                itemprop="sku">{{ $item->gold_colour }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="zh-row row">
                                                        <div class="col-4">
                                                            <span class="sn-detail-title font-red sop-font">
                                                                အမျိုးအစား</span>
                                                        </div>
                                                        <div class="col-8 d-flex align-items-center">
                                                            @switch($item->gender)
                                                                @case('Kid')
                                                                    <i class="fa fa-child px-1 kid"></i>
                                                                    <span class="sku sop-font" itemprop="sku">ကလေးဝတ်</span>
                                                                @break

                                                                @case('Couple')
                                                                    <img src="{{ asset('images/icons/couple.png') }}"
                                                                        class="px-1 couple" alt="">
                                                                    <span class="sku sop-font" itemprop="sku">စုံတွဲဝတ်</span>
                                                                @break

                                                                @case('Women')
                                                                    <i class="fa fa-venus px-1 women" aria-hidden="true"></i>
                                                                    <span class="sku sop-font" itemprop="sku">အမျိုးသမီးဝတ်</span>
                                                                @break

                                                                @case('Men')
                                                                    <i class="fa fa-mars px-1 men" aria-hidden="true"></i>
                                                                    <span class="sku sop-font" itemprop="sku">အမျိုးသားဝတ်</span>
                                                                @break

                                                                @case('UniSex')
                                                                    <i class="fa-solid fa-genderless px-1 unisex"
                                                                        aria-hidden="true"></i>
                                                                    <span class="sku sop-font" itemprop="sku">အားလုံးဝတ်</span>
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
                                                <h1 class="product_title entry-title sn-accordion-title sop-font">ဆိုင်
                                                    အချက်အလက်များ</h1>
                                                <div class="sku-wrapper product_meta sn-accordion-content">
                                                    <div class="zh-row row ">
                                                        <div class="col-4 ">
                                                            <span
                                                                class="sn-detail-title font-red sop-font">ဆိုင်အမည်</span>
                                                        </div>
                                                        <div class="col-8 ">
                                                            <a class="sn-shop-link sop-font"
                                                                href="{{ url('/' . $item->withoutspace_shopname) }}">
                                                                {{ $item->shop_name->shop_name }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @if (!empty($item->handmade))
                                                        <div class="zh-row row">

                                                            <div class="col-4 ">
                                                                <span
                                                                    class="sn-detail-title font-red sop-font">အလျော့တွက်</span>
                                                            </div>
                                                            <div class="col-8 ">
                                                                <span class="sku"
                                                                    itemprop="sku">{{ $item->handmade }} </span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if (!empty($item->charge))
                                                        <div class="zh-row row">
                                                            <div class="col-4 ">
                                                                <span class="sn-detail-title font-red sop-font">လက်ခ</span>
                                                            </div>
                                                            <div class="col-8 ">
                                                                <span class="sku" itemprop="sku">{{ $item->charge }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="zh-row row">
                                                        <div class="col-4 ">
                                                            <span class="sn-detail-title font-red sop-font">အထည်မပျက်
                                                                ပြန်သွင်း</span>
                                                        </div>
                                                        <div class="col-8 ">
                                                            <span class="sku sop-font"
                                                                itemprop="sku">{{ $item->undamaged_product }} </span>
                                                        </div>
                                                    </div>

                                                    <div class="zh-row row">
                                                        <div class="col-4 ">
                                                            <span class="sn-detail-title font-red sop-font">အထည်ပျက်စီး
                                                                ချို့ယွင်း</span>
                                                        </div>
                                                        <div class="col-8 ">
                                                            <span class="sku sop-font"
                                                                itemprop="sku">{{ $item->damaged_product }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="zh-row row">
                                                        <div class="col-4 ">
                                                            <span
                                                                class="sn-detail-title font-red sop-font">တန်ဖိုးမြင့်အထည်နှင့်
                                                                အထည်မပျက်ပြန်လဲ</span>
                                                        </div>
                                                        <div class="col-8 ">
                                                            <span class="sku sop-font"
                                                                itemprop="sku">{{ $item->valuable_product }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item_type">


                                    @if (count($item->tags) != 0)
                                        <i class="fa-solid fa-tag fa-flip-horizontal"></i> ပစ္စည်းအမျိုးအစား :

                                        @foreach ($item->tags as $itg)
                                            <a href="{{ url('tags/' . $itg->name) }}"
                                                class="item_tag_name">{{ $itg->name }}</a>
                                            @if ($loop->remaining != 0)
                                                ,
                                            @endif
                                        @endforeach
                                    @endif
                                </div>

                                <div class="row g-1 g-md-2 position-relative mt-3">

                                    @if ($is_chat_on == 'on')
                                        <div id="chatWithUs"
                                            class="col-2 mt-1 mt-md-2 chat-with-us d-flex flex-column align-items-center">
                                            <img src="{{ asset('images/icons/discuss-fill.png') }}" alt="Chat with Us"
                                                width="50px" class=>
                                            <p class="text-center" style="font-size:14px; color: #780116;">စုံစမ်းရန်</p>
                                        </div>

                                        <div id="chatWithUsContainer"
                                            class="position-absolute chat-with-us-container d-none w-md-50 w-100">
                                            <div>
                                                <h3 class="px-4 my-2 fbold" style="color: #780116">စုံစမ်းရန်</h3>
                                                <ul class="list-group">
                                                    <li class="list-group-item list-group-item-action border-0 px-4 my-2">
                                                        <a id="buynowbutton" class="d-flex align-items-center chat-width"
                                                          @click="buynowbuttonclick('{{ \Illuminate\Support\Facades\Auth::guard('web')->check() }}','{{ $item->shop->id }}',{{ $item }},'post','{{ \Illuminate\Support\Facades\Auth::guard('web')->check() == 1 ? \Illuminate\Support\Facades\Auth::guard('web')->user()->username : '' }}',{{ $item->shop }},'{{ \Carbon\Carbon::now() }}')">
                                                            <div class="btn shweshops-chat-btn d-flex align-items-center">
                                                                <div class="ss-chat-wrapper d-inline-block m-2"
                                                                    style="width: 40px; height: 40px;">
                                                                    <img src="{{ asset('test/img/logo-m.png') }}"
                                                                        alt="Chat with Us" style="width: 40px;"
                                                                        class="mt-2">
                                                                </div>
                                                                <div class="mx-3">Shweshops Chat</div>
                                                            </div>
                                                        </a> 
                                                    </li>
                                                    <li class="list-group-item list-group-item-action border-0 px-4">
                                                        @if ($is_fb_on == 'on')
                                                            <?php
                                                            $check_connect = \Illuminate\Support\Facades\DB::table('facebook')
                                                                ->where('shop_id', $item->shop->id)
                                                                ->first();
                                                            ?>
                                                          
                                                            @if (!empty($check_connect))
                                                                <a class="d-flex align-items-center chat-width"
                                                                    id="fbbutton"
                                                                    @click="messengerbuttonclick('{{ \Illuminate\Support\Facades\Auth::guard('web')->check() }}','{{ 'http://m.me/' . $check_connect->page_id . '?ref=' . $item->id }}','{{ $item->shop_name->id }}','{{ $item->id }}')"
                                                                    target="_blank">
                                                                    <div
                                                                        class="btn shweshops-chat-btn d-flex align-items-center">
                                                                        <div class="m-chat-wrapper d-inline-block m-2"
                                                                            style="width: 40px; height: 40px;">
                                                                            <img src="{{ asset('images/icons/messenger.png') }}"
                                                                                alt="Chat with Us" style="width: 34px;"
                                                                                class="ml-2">
                                                                        </div>
                                                                        <div class="mx-3">
                                                                            Page Messenger
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            @else
                                                                <a href="{{ $item->shop_name->page_link }}"
                                                                    class="d-flex align-items-center chat-width">
                                                                    <div
                                                                        class="btn shweshops-chat-btn d-flex align-items-center">
                                                                        <div class="m-chat-wrapper d-inline-block m-2"
                                                                            style="width: 40px; height: 40px;">
                                                                            <img src="{{ asset('images/icons/messenger.png') }}"
                                                                                alt="Chat with Us" style="width: 34px;"
                                                                                class="mt-2 ml-2">
                                                                        </div>
                                                                        <div class="mx-3">
                                                                            Page Messenger
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            @endif
                                                        @endif

                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="col-5 pe-2">

                                            <a id="buynowbutton"
                                                class="btn btn-primary zh-addtocart-button sop-font reg py-3"
                                                @click="buynowbuttonclick('{{ \Illuminate\Support\Facades\Auth::guard('web')->check() }}','{{ $item->shop->id }}',{{ $item }},'post','{{ \Illuminate\Support\Facades\Auth::guard('web')->check() == 1 ? \Illuminate\Support\Facades\Auth::guard('web')->user()->username : '' }}',{{ $item->shop }},'{{ \Carbon\Carbon::now() }}')"
                                                target="_blank"><span class="buy-font">ဝယ်မယ်</span></a>
                                        </div>
                                    <!-- maymyat -->
                                    <div class="col-5 pe-2">
                                        <!-- <a id="buynowbutton"
                                            class="btn btn-primary zh-addtocart-button sop-font reg py-3"
                                            data-toggle="modal" data-target="#myModal"
                                            ><span class="buy-font">test</span></a> -->
                                            <a href="{{ route('orderform') }}"
                                            class="btn btn-primary zh-addtocart-button sop-font reg py-3"
                                            ><span class="buy-font">test</span></a>
                                    </div>
                                    <!-- maymyat -->
                                    @endif


                                    @if (Session::get('clickbuynow'))
                                        <input id="buynowsession" type="hidden"
                                            value="{{ Session::get('clickbuynow') }}">
                                        @php
                                            Session::forget('clickbuynow');
                                        @endphp
                                    @endif
                                    {{ \Illuminate\Support\Facades\Session::get('clickmessenger') }}

                                    @if (Session::get('clickmessenger'))
                                        <input id="clickmessenger" type="hidden"
                                            value="{{ Session::get('clickmessenger') }}">
                                        @php
                                            Session::forget('clickmessenger');
                                        @endphp
                                    @endif

                                    @if (Session::get('clickpayment'))
                                        <input id="clickpayment" type="text"
                                            value="{{ Session::get('clickpayment') }}">
                                        @php
                                            Session::forget('clickpayment');
                                        @endphp
                                    @endif

                                    <div class="col-5 px-1">
                                        <div onclick="cartclick('{{ $item->id }}','{{ Auth::check() }}')"
                                            id="selection-div" class="btn btn-primary sn-buynow-button py-3">
                                            <i id="selection-icon" class="fa-solid d-none fa-check"></i>
                                            <span id="selection" class="sop-font buy-font">ရွေးထားမယ်</span>
                                        </div>

                                    </div>
                                </div>

                                <div class="row g-3 mt-3">

                                    {{-- <div class="col-6">

                                        <a class="btn btn-info" id="paymentbtn"
                                           @click="paymentbuttonclick('{{\Illuminate\Support\Facades\Auth::guard('web')->check()}}','{{url('payment/order/'.$item->id)}}')"
                                           target="_blank"
                                           style="">
                                            Check Out
                                        </a>

                                    </div> --}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pe-0 ps-2 px-md-4 mx-md-5">
        <div class="pe-0 ps-2 px-md-1">
            {{-- @if (!empty($sim_items)) --}}
            @if (count($sim_items) != 0)
                {{-- similar products --}}
                <div id="primary" class="site-content ">

                    {{--  product title --}}

                    <div
                        class="mt-3 mt-sm-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading mb-0">

                        <div class="elementor-widget-container">


                            <h3 class="elementor-heading-title elementor-size-default ps-2 sop-font">
                                <a class="sn-shop-link"
                                    href="{{ url('/' . $item->WithoutspaceShopname) }}">{{ $item->shop_name->shop_name }}</a>
                                မှဆင်တူ
                                <a class="sn-shop-link"
                                    href="{{ url($item->WithoutspaceShopname . '/similar_items/' . $item->category_id . '/' . $item->id . '/' . $item->shop_name->id) }}">{{ $item->ykbeauty_cat }}
                                    များ</a>
                            </h3>

                        </div>

                    </div>
                    {{--  products list --}}
                    <div class="col-12 main-content">
                        <div id="similar_slide" class="owl-carousel owl-theme w-100 ">
                            @foreach ($sim_items as $new_item)
                                @if ($new_item->ykget_discount == '0')
                                    <div class="ftc-product product yk-product">

                                        <div class="images sop-font sop-img">
                                            <span class=" fa fa-user yk-viewcount">
                                                {{ $new_item->yk_view }}
                                            </span>


                                            <a
                                                href="{{ url($new_item->WithoutspaceShopname . '/product_detail/' . $new_item->id) }}">
                                                <img class="sop-image-w-h" src="{{ filedopath($new_item->CheckPhoto) }}"
                                                    style="border-radius: 5px;" />
                                            </a>


                                        </div>
                                        <div class="item-description">
                                            <span class="price">
                                                <span class="woocommerce-Price-amount amount sop-amount">
                                                    <bdi>
                                                        {!! $new_item->mm_price !!}
                                                    </bdi>
                                                </span>
                                            </span>

                                            <h3 class="product_title product-name"><a
                                                    href="{{ url($new_item->WithoutspaceShopname . '/product_detail/' . $new_item->id) }}">{{ \Illuminate\Support\Str::limit($new_item->name, 8, '...') }}</a>
                                            </h3>
                                        </div>
                                    </div>
                                @else
                                    <div class="ftc-product product yk-product">

                                        <div class="images sop-font sop-img">

                                            <span class=" fa fa-user yk-viewcount">
                                                {{ $new_item->yk_view }}
                                            </span>

                                            <div class="sop-ribbon">
                                                <span>-{{ $new_item->ykget_discount->percent }}%</span>
                                            </div>

                                            <a
                                                href="{{ url($new_item->WithoutspaceShopname . '/product_detail/' . $new_item->id) }}">
                                                <img class="sop-image-w-h" src="{{ filedopath($new_item->CheckPhoto) }}"
                                                    style="border-radius: 5px;" />
                                            </a>


                                        </div>
                                        <div class="item-description">
                                            <span class="price">
                                                <span class="woocommerce-Price-amount amount sop-amount">
                                                    <bdi>
                                                        {!! $new_item->ykget_discount->mm_price !!}
                                                    </bdi>
                                                </span>
                                            </span>

                                            <h3 class="product_title product-name"><a
                                                    href="{{ url($new_item->WithoutspaceShopname . '/product_detail/' . $new_item->id) }}">{{ \Illuminate\Support\Str::limit($new_item->name, 8, '...') }}</a>
                                            </h3>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            @if (count($sim_items) >= 20)
                                <div class="sn-similar-seeall">
                                    <a
                                        href="{{ url($item->WithoutspaceShopname . '/similar_items/' . $item->category_id . '/' . $item->id . '/' . $item->shop_name->id) }}">
                                        <div>
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </div>
                                        <div class="see-all-text">See all</div>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
                {{-- similar products --}}
            @endif
            {{-- @if (!empty($sim_items_othershops)) --}}
            @if (count($sim_items_othershops) != 0)
                {{-- similar products for other shops --}}
                <div id="primary" class="site-content mt-3">


                    {{--  product title --}}

                    <div
                        class=" mt-3 mt-sm-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading mb-0">
                        <div class="elementor-widget-container">


                            <h3 class="elementor-heading-title elementor-size-default ps-2 sop-font">တခြားဆိုင်များမှ ဆင်တူ
                                <a class="sn-shop-link"
                                    href="{{ url('/other_shops/similar_items/' . $item->category_id . '/' . $item->id . '/' . $item->shop_name->id) }}">{{ $item->ykbeauty_cat }}
                                    များ</a>
                            </h3>

                        </div>

                    </div>
                    {{--  products list --}}


                    <div class="col-12 main-content">
                        <!-- zh-modify -->
                        <div id="pd-discount_slide" class="owl-carousel owl-theme w-100 ">
                            @foreach ($sim_items_othershops as $new_item)
                                @if ($new_item->ykget_discount == '0')
                                    <div class="ftc-product product yk-product">

                                        <div class="images sop-font sop-img">
                                            <div class="yk-hover-title sop-rounded-top text-capitalize text-left g-0"
                                                style="width:100% !important;">
                                                <img src="{{ url('images/logo/thumbs/' . $new_item->shop_name->shop_logo) }}"
                                                    class="yk-hover-logo float-left" />
                                                <span>
                                                    {{ \Illuminate\Support\Str::limit($new_item->shop_name->shop_name, 15, '...') }}
                                                </span>
                                            </div>

                                            <span class=" fa fa-user yk-viewcount">
                                                {{ $new_item->yk_view }}
                                            </span>


                                            <a
                                                href="{{ url($new_item->WithoutspaceShopname . '/product_detail/' . $new_item->id) }}">
                                                <img class="sop-image-w-h" src="{{ filedopath($new_item->CheckPhoto) }}"
                                                    style="border-radius: 5px;" />
                                            </a>


                                        </div>
                                        <div class="item-description">
                                            <span class="price">
                                                <span class="woocommerce-Price-amount amount sop-amount">
                                                    <bdi>
                                                        {!! $new_item->mm_price !!}
                                                    </bdi>
                                                </span>
                                            </span>

                                            <h3 class="product_title product-name"><a
                                                    href="{{ url($new_item->WithoutspaceShopname . '/product_detail/' . $new_item->id) }}">{{ \Illuminate\Support\Str::limit($new_item->name, 8, '...') }}</a>
                                            </h3>
                                        </div>
                                    </div>
                                @else
                                    <div class="ftc-product product yk-product">

                                        <div class="images sop-font sop-img">
                                            <div class="yk-hover-title sop-rounded-top text-capitalize text-left g-0"
                                                style="width:100% !important;">
                                                <img src="{{ url('images/logo/thumbs/' . $new_item->shop_name->shop_logo) }}"
                                                    class="yk-hover-logo float-left" />
                                                <span>
                                                    {{ \Illuminate\Support\Str::limit($new_item->shop_name->shop_name, 15, '...') }}
                                                </span>
                                            </div>

                                            <span class=" fa fa-user yk-viewcount">
                                                {{ $new_item->yk_view }}
                                            </span>
                                            <div class="sop-ribbon">
                                                <span>-{{ $new_item->ykget_discount->percent }}%</span>
                                            </div>

                                            <a
                                                href="{{ url($new_item->WithoutspaceShopname . '/product_detail/' . $new_item->id) }}">
                                                <img class="sop-image-w-h" src="{{ filedopath($new_item->CheckPhoto) }}"
                                                    style="border-radius: 5px;" />
                                            </a>


                                        </div>
                                        <div class="item-description">
                                            <span class="price">
                                                <span class="woocommerce-Price-amount amount sop-amount">
                                                    <bdi>
                                                        {!! $new_item->ykget_discount->mm_price !!}
                                                    </bdi>
                                                </span>
                                            </span>

                                            <h3 class="product_title product-name"><a
                                                    href="{{ url($new_item->WithoutspaceShopname . '/product_detail/' . $new_item->id) }}">{{ \Illuminate\Support\Str::limit($new_item->name, 8, '...') }}</a>
                                            </h3>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            @if (count($sim_items_othershops) >= 20)
                                <div class="sn-similar-seeall sop-font">
                                    <a
                                        href="{{ url('/other_shops/similar_items/' . $item->category_id . '/' . $item->id . '/' . $item->shop_name->id) }}">
                                        <div>
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </div>
                                        <div class="see-all-text">See all</div>
                                    </a>
                                </div>
                            @endif
                        </div>

                    </div>


                </div>

                {{-- similar products for other shops --}}
            @endif
        </div>

    </div>
    <div class="pt-5">
        @include('layouts.frontend.allpart.footer')
    </div>
    <div class="ftc-close-popup"></div>

    @include('layouts.frontend.allpart.mobile_footer')

    <div id="to-top" class="scroll-button">
        <a class="" onclick="scrollToTop()" title="Back to Top">Back to Top</a>
    </div>





@endsection


@push('custom-scripts')
    <script src="{{ url('test/js/fancybox.js') }}"></script>
    @include('JsScripts.Front.favourite')
    @include('JsScripts.Front.cart')

    <script>
        $(document).ready(function() {
            $('#similar_slide').owlCarousel({
                loop: false,
                margin: 2,
                responsiveClass: true,
                autoplay: false,
                dots: false,
                autoplayTimeout: 6000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 2,
                        stagePadding: 25,
                    },
                    600: {
                        items: 3,
                        stagePadding: 0,
                    },
                    900: {
                        items: 4,
                        stagePadding: 0,
                    },
                    1200: {
                        items: 5,
                        stagePadding: 0,
                    },
                    1400: {
                        items: 6,
                        stagePadding: 0,
                    }
                }
            });
            $('#pd-discount_slide').owlCarousel({
                loop: false,
                margin: 2,
                responsiveClass: true,
                autoplay: false,
                dots: false,
                autoplayTimeout: 6000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 2,
                        stagePadding: 25,
                    },
                    600: {
                        items: 3,
                        stagePadding: 0,
                    },
                    900: {
                        items: 4,
                        stagePadding: 0,
                    },
                    1200: {
                        items: 5,
                        stagePadding: 0,
                    },
                    1400: {
                        items: 6,
                        stagePadding: 0,
                    }
                }
            });

            if (document.getElementById('buynowsession') != null) {
                document.getElementById('buynowbutton').click();
            }
            if (document.getElementById('clickmessenger') != null) {

                if (document.getElementById('clickmessenger').value == 'click') {
                    document.getElementById('fbbutton').click();
                }
            }
        });
        var busy = false;
        // zh buynow log
        function buyNow(id) {
            if (`{{ Auth::guard('web')->check() }}`) {
                $.ajax({
                    method: "POST",
                    url: "{{ route('backside.user.buy_now.point') }}",
                    cache: false,
                    dataType: "json",
                    data: {
                        _token: '{{ csrf_token() }}',
                        m_id: id,
                    },

                    success: function(response) {
                        console.log(response['data'])

                    },
                });
            }
            $.ajax({
                method: "Get",
                url: "{{ route('buynow') }}",
                cache: false,
                dataType: "json",
                data: {
                    id: id,
                },
                success: function(data) {

                },
                error: function(err) {
                    console.log(err);
                }

            })
        }





        // Initialise Carousel
        const mainCarousel = new Carousel(document.querySelector("#mainCarousel"), {
            Dots: false,
        });

        // Thumbnails
        const thumbCarousel = new Carousel(document.querySelector("#thumbCarousel"), {
            Sync: {
                target: mainCarousel,
                friction: 0,
            },
            Dots: false,
            Navigation: false,
            center: true,
            slidesPerPage: 1,
            infinite: false,
        });

        // Customize Fancybox
        Fancybox.bind('[data-fancybox="gallery"]', {
            Carousel: {
                on: {
                    change: (that) => {
                        mainCarousel.slideTo(mainCarousel.findPageForSlide(that.page), {
                            friction: 0,
                        });
                    },
                },
            },
        });

        jQuery(function($) {

            // Chat With Us
            $('#chatWithUs').click(function() {
                $("#chatWithUsContainer").toggleClass('d-none');
            });

            $('#button_slide_collection').owlCarousel({
                loop: false,
                margin: 29,
                responsiveClass: true,
                autoplay: false,
                dots: false,
                autoplayTimeout: 6000,
                autoplayHoverPause: true,
                nav: false,

                responsive: {

                    0: {
                        items: 2,
                        stagePadding: 25,
                    },
                    600: {
                        items: 3,
                    },
                    900: {
                        items: 4,
                    },
                    1200: {
                        items: 5,
                    },
                    1400: {
                        items: 6,
                    }
                }
            });

        });
    </script>
@endpush
@push('css')
    <style>
        

        .remove_wrapp {
            height: 822px !important;
            position: relative !important;
        }

        .summary {
            padding-right: 0;
        }

        .marginleft {
            margin-left: 10px;
        }

        .mprice {
            text-decoration: line-through !important;
        }

        .zh-icon {
            color: rgb(120, 1, 22) !important;
        }

        .sop-font .zh-p .grey {
            color: grey;
        }

        .shweshops-chat-btn {
            background: #fff9e5 !important;
            border-radius: 7px !important;
            width: 200%;
            color: #85565f !important;
            font-size: 18px !important;
            font-weight: 600 !important;
            display: flex;
            box-shadow: 0px 0px 8px 0px #78011750;
        }

        .shweshops-chat-btn:hover {
            background: #fff2e5 !important;
            color: #85565f !important;
            box-shadow: 0px 0px 8px 0px #78011770;
        }

        .chat-width {
            width: 360px;
        }

        .userstyle {

            margin-bottom: 20px;
            margin-top: 12px;
            margin-left: 11px;
            color: grey;
            text-color: grey;
        }

        .leftgrey {
            margin-left: 5px;
            color: grey;
        }

        .product_title {
            text-transform: none !important;
        }

        .sn-product-outstock {
            color: red !important;
        }

        .kid {
            font-size: 22px;
        }

        .couple {
            height: 22px;
            color: #d80007;
        }

        .women {
            font-size: 22px;
            color: #F7BEC0;
        }

        .men {
            font-size: 22px;
            color: #2E8BC0;
        }

        .unisex {
            font-size: 22px;
            color: #000000;
        }

        .elementor-size-default .product-name .size-content .elementor-widget-heading {
            border-bottom: 2px solid #a0793614;
        }

        .item_type {
            margin: 0 10px;
            font-weight: 400;
        }

        .item_tag_name {
            color: #780116 !important;
            text-decoration: underline !important;
        }

        .fbold {
            font-weight: bold;
        }

        .zh-addtocart-button {
            color: white !important;
        }

        .yk-product {
            border: 0px !important;
        }

        .sop-amount {
            font-weight: 600 !important;
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
            overflow: hidden;
            z-index: 111;
            top: 0;
            right: 0;
        }

        .ss-chat-wrapper {
            background: #780116;
            width: 35px;
            height: 35px;
            padding: 3px;
            border-radius: 50%;
        }

        .m-chat-wrapper {
            width: 36px;
            height: 36px;
        }

        .chat-with-us img:hover {
            cursor: pointer;
        }

        .chat-with-us-container {
            background: #ffffff;
            bottom: 110px;
            z-index: 999;
            border: 1px solid #c1c1c1;
            box-shadow: 0px 0px 8px 0px #78011750;
            border-radius: 10px;
            padding: 25px 0;
        }

        .chat-with-us-container ul li:hover {
            /* background: #efefef; */
            cursor: pointer;
        }

        .sn-buynow-button {
            /* zh-modify */
            background: #fff !important;
            border-radius: 5px !important;
            border-color: #780116 !important;
            width: 100% !important;
            color: #780116 !important;
            font-size: 18px !important;
            padding: 7px 0 !important;
            /*font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;*/
            font-weight: 600 !important;
        }

        .list-group-item-action:hover,
        .list-group-item-action:focus {
            z-index: 1;
            color: #00000000 !important;
            text-decoration: none;
            background-color: #00000000 !important;
        }

        .sn-buynow-button:hover {
            background: #f3f3f3b9 !important;
        }

        .zh-addtocart-button {
            background: #780116 !important;
            border-radius: 5px !important;
            border-color: #780116 !important;
            width: 100% !important;
            color: #fff !important;
            font-size: 18px !important;
            padding: 7px 0 !important;
            /*font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;*/
            font-weight: 600 !important;
        }

        .sop-product-image-d {
            width: 100% !important;

            aspect-ratio: 3/2;
            vertical-align: inherit !important;
        }

        .buy-font {
            font-size: 20px !important;
        }

        @media (max-width: 576px) {
            .chat-width {
                width: 100% !important;
            }

            .buy-font {
                font-size: 14px !important;
            }
        }

    </style>
@endpush
