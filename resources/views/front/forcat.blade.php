@extends('layouts.frontend.frontend')
@section('content')
    @include('layouts.frontend.allpart.for_mobile')
{{--MENU--}}
@include('layouts.frontend.allpart.upper_menu')
{{-- @include('layouts.frontend.allpart.menu', ['display' => "hide"]) --}}
@include('layouts.frontend.allpart.menu', ['display' => "product"])
@include('layouts.frontend.allpart.mobile_search', ['display' => "product"])
{{-- end Menu--}}

    <div id="page" class="site my-0 py-0">
    <!--.site-content-contain -->
        <div class="mx-0 px-md-5 show_breadcrumb_">
            <div class="">
                <div id="main-content" class="mt-2 mb-5 col-sm-12 col-xs-12 ">
                    <products_filter
                        :initialitems="{{$data}}"
                        :discount="'no'"
                        :cat_list="{{$cat_list}}" 
                        :maincat_list="'{{$maincat_list}}'"
                        :cat_id="['{{$cat_id}}']"
                        :maincat_id="'{{$maincat_id}}'"
                        :shop_ids="{{$shop_ids}}"
                        :selected_shop="'all'"
                        :sort="'all'"
                        :selected_gems="[]"
                        :gender="'all'"
                        :additional="'no'"
                    ></products_filter>
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

</script>
@endpush
@push('css')
    <style>
        .remove_wrapp{
            height: 500px !important;
            position:relative !important;
        }

    </style>
@endpush



