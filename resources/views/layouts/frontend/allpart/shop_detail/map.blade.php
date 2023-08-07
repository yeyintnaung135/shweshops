{{-- map (change with dynamic degrees) --}}

<div class="container-fluid px-lg-5 show_dev ">
    <div class="row flex-column-reverse flex-md-row">
        <div class="col-lg-6 col-12">
            <div class="d-lg-flex justify-content-center align-items-center h-100 ">
                <div class="d-flex justify-content-center ">
                     <div class="">
                        <div class="mb-3 d-flex d-lg-block justify-content-center justify-content-lg-start ">
                            <h1 class="sop-sans mb-1 font-weight-bolder">Shop</h1>
                            <h1 class="sop-sans sop-color-vermilion mx-2 mx-md-0">Address</h1>
                        </div>
                        <div class="text-center text-md-start font-weight-bolder">
                            <p class="content sop-opacity-8 m-0 animation address" style="font-size: 1.1em">
                                {{ $shop_data->address }}
                            </p>
                            <div class="txtcol"><a style="color: #780116!important;">... See More</a></div>
                              {{-- <p class=" content sop-opacity-8 m-0 animation address">
                                 {{ $shop_data->address }}</p>

                           <div class="txtcol"><a style="color: #780116!important;">                            <div class="txtcol"><a style="color: #780116!important;">... See More</a></div></a></div> --}}
                        </div>
                     </div>
                </div>

            </div>
        </div>
        <div class="col-lg-6 col-12">

            @if(!isset($shop_data->map) || is_null($shop_data->map) || empty($shop_data->map))
            <iframe class="sop-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15472351.946258605!2d87.60098124688682!3d18.778995379761387!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x305652a7714e2907%3A0xba7b0ee41c622b11!2sMyanmar%20(Burma)!5e0!3m2!1sen!2smm!4v1657253955978!5m2!1sen!2smm" width="2000" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

            @else
            <iframe class="sop-map" src="{{ $shop_data->map }}" width="2000" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            @endif
        </div>
    </div>
    <!-- <div class=" text-center">
        <a href="https://www.google.com/maps/@16.887797,96.19803,19z?hl=en" class="sop-sans">Open in Google Map &nbsp; <i class="fa-solid fa-angle-right"></i></a>
    </div> -->
</div>

{{-- map --}}
@push('css')
    <style>
        .address{
            word-break: break-word;
            white-space: pre-line;
            overflow-wrap: break-word;
            -ms-word-break: break-word;
            word-break: break-word;
            -ms-hyphens: auto;
            -moz-hyphens: auto;
            -webkit-hyphens: auto;
            hyphens: auto;
        }

        .expandMoreContent{
            width: 100%;
            overflow: hidden;
            transition: 0.5s ease-in-out;
            position: relative;
            max-height: 50px;
        }
        .expandMoreHolder{
            display: none;
        }
        .expandMoreContent.expand-active{
            height: auto;
            transition: 0.5s ease-in-out;
        }

        .expandMoreHolder{
            cursor: pointer;
        }

        @media only screen and (max-width: 576px) {
        .sop-map{
            max-height: 300px;
        }
    }
    </style>
@endpush
