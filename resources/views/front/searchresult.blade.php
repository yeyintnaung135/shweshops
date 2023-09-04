@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
    {{--MENU--}}
    @include('layouts.frontend.allpart.upper_menu')
    @include('layouts.frontend.allpart.menu', ['display' => "product"])
    @include('layouts.frontend.allpart.mobile_search')
    {{-- end Menu--}}

    <div id="page" class="site my-0 py-0">


        <!--.site-content-contain -->
        <div class="site-content-contain">

        </div>
        <div class="mx-4 px-md-5 show_breadcrumb_">
            <div class="row">


                <div id="main-content" class="mt-2 mb-5 col-sm-12 col-xs-12 ">

                    {{-- <see_all_forcat
                        :title_prop="'ALL ITEMS'"
                    ></see_all_forcat> --}}

                    <products_filter
                      :typesearchfromblade="'{{$searchtext}}'"
                      :initialitems="[]"
                      :maincat_id="'all'" 
                      :discount=false
                      :cat_list="{{$cat_list}}"
                      :cat_id="[]"
                      :shop_ids="{{$shop_ids}}"
                      :selected_shop="'all'"
                      :sort="'latest'"
                      :selected_gems="[]"
                      :gender="'all'"
                      :additional="'no'"
                    ></products_filter>

                </div>
                <div class="col-12">
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
        <a class="" onclick="scrollToTop()" title="Back to Top">Back to Top</a>
    </div>

    <div class="popupshadow" style="display:none"></div>



@endsection
@push('custom-scripts')
    <script>
    $(document).ready(function () {
        $("#items").click(function () {
            $(".s_items_nav").addClass('active');
            $(".s_shops_nav").removeClass('active');
            $(".s_news_nav").removeClass('active');
            $(".s_events_nav").removeClass('active');
        });
        $("#shops").click(function () {
            $(".s_shops_nav").addClass('active');
            $(".s_items_nav").removeClass('active');
            $(".s_news_nav").removeClass('active');
            $(".s_events_nav").removeClass('active');
        });
        $("#news").click(function () {
            $(".s_news_nav").addClass('active');
            $(".s_items_nav").removeClass('active');
            $(".s_shops_nav").removeClass('active');
            $(".s_events_nav").removeClass('active');
        });
        $("#events").click(function () {
            $(".s_events_nav").addClass('active');
            $(".s_items_nav").removeClass('active');
            $(".s_news_nav").removeClass('active');
            $(".s_shops_nav").removeClass('active');
        });
    });

    </script>
@endpush

@push('css')
<style>
.remove_wrapp{
    height: 222px !important;
    position:relative !important;
}
</style>

@endpush


