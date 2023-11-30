
     {{--                        //loader--}}
     <x-wrappercomponent div-id="catwrap" toshow-id="catdiv"></x-wrappercomponent>

     {{--                        //loader--}}
                        <div id="catdiv" class="col-12 mt-lg-4 mt-2 main-content d-none show_dev">

                            <!-- CAtegories -->

                            <div id='categories_slide' class="owl-carousel owl-theme w-100 ">


                                @foreach($cat_list as $acc)

                                     @if($acc->catcount != 0)
                                            <div class="col-12">
                                                <article class="post-wrapper">
                                                    <div class="text-center post-img">
                                                        <a class=""
                                                           href="{{url('see_by_categories/'.$acc->category_id)}}">


                                                                <img src="{{url('test/forcategory/'.$acc->category_id.'.jpg')}}"
                                                                style="width:76px !important;height:80px !important;border-radius:50% !important;"
                                                                    class="attachment-ftc_blog_shortcode_thumb size-ftc_blog_shortcode_thumb wp-post-image lazyloaded yk-image rounded-circle"
                                                                    alt="">
                                                        </a>
                                                    </div>
                                                    <div class="post-info text-center">
                                                            <header class="entry-header">
                                                                <!-- Blog Title -->
                                                                <h3 class="yk-product-title "><a class="zh-amount sop-font"
                                                                                                 href="{{url('see_by_categories/'.$acc->category_id)}}">
                                                                    {{$acc->mm_name}}
                                                                    <h3 class="zh_cat_count"> ( {{$acc->catcount}} )  </h3>
                                                                </a>

                                                                </h3>
                                                                <!-- Blog Author -->
                                                                <span class="vcard author" style=""></span>
                                                            <!-- Blog Categories -->
                                                            </header>
                                                        <div class="clear"></div>
                                                    </div>
                                                </article>
                                            </div>
                                     @endif
                                @endforeach

                            </div>


                        </div>
