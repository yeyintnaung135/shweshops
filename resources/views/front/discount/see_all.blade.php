@extends('layouts.frontend.frontend')
@section('content')
@include('layouts.frontend.allpart.for_mobile')
@include('layouts.frontend.allpart.upper_menu')
@include('layouts.frontend.allpart.menu', ['display' => "hide"])
{{-- @include('layouts.frontend.allpart.mobile_search') --}}

    <div id="page" class="site my-0 py-0">

    <!--.site-content-contain -->
        <div class="site-content-contain">

        </div>
        <div class="mx-4 px-md-5 show_breadcrumb_">
            <div class="row">


                <div id="main-content" class="mt-2 col-sm-12 col-xs-12  mb-5">






                    {{--                    new item--}}
                    {{-- <see_all_forcat :title_prop="'ALL DISCOUNT ITEMS'"></see_all_forcat>  --}}
                    <products_filter
                      :initialitems="{{$new_items}}"
                      :discount=true
                      :cat_list="{{$cat_list}}"
                      :cat_id="[]"
                      :shop_ids="{{$shop_ids}}"
                      :selected_shop="'{{$shopid}}'"
                      :sort="'discountpercent'"
                      :selected_gems="[]"
                      :gender="'all'"
                      :additional="'no'"
                    ></products_filter>

                </div>
                <div class="col-12" style="height: 222px !important;position:relative !important">
                    @include('layouts.frontend.allpart.loading_wrapper')

                </div>




                {{-- <!-- Right Sidebar -->--}}
            </div>
        </div>
    </div>
    {{--<!-- #content -->--}}
    {{--    <!-- .site-content-contain -->--}}

    <div class="pt-5">
        @include('layouts.frontend.allpart.footer')
    </div>
    <div class="ftc-close-popup"></div>

    @include('layouts.frontend.allpart.mobile_footer')

    <div id="to-top" class="scroll-button">
        <a class="scroll-button" href="javascript:void(0)" title="Back to Top">Back to Top</a>
    </div>

    <div class="popupshadow" style="display:none"></div>



@endsection
@push('script')
@endpush
