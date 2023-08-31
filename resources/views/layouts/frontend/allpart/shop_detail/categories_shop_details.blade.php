<div class=" ">
    <div id="main-content" class="mt-2 col-sm-12 col-xs-12 sop-font">
        @if(!empty($allcatcount) )


            <div class=" g-0 sop-font px-md-3" style="">
            {{-- <div class="mb-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading px-4 px-md-5">
                <div class="elementor-widget-container d-flex justify-content-start ">
                    <h3 class="elementor-heading-title elementor-size-default" style="font-family: sans-serif!important">
                        Categories
                    </h3>
                </div>
            </div> --}}

            <div class="main-content">
                <div id='categories_slide' class="owl-carousel owl-theme w-100 ">

                    @foreach($allcatcount as $acc)
                    
                        @if($acc->catcount != 0)
                        
                            <div class="col-12">
                                <article class="post-wrapper align-items-center">
                                    <div class="text-center post-img p-3">
                                        <a class="" href="{{url($shop_data->withoutspace_shopname.'/'.$acc->category_id.'/'.$shop_data->id)}}">
                                            <img src="{{url('test/forcategory/'.$acc->category_id.'.jpg')}}"
                                                style="width:76px !important;height:80px !important;border-radius:50% !important;"
                                                class="attachment-ftc_blog_shortcode_thumb size-ftc_blog_shortcode_thumb wp-post-image lazyloaded yk-image rounded-circle category-bg   
                                                @if($shop_data->premium == 'gold') category-bg-gold @endif"
                                                alt="">
                                        </a>
                                        
                                    </div>
                                    <div class="post-info text-center">
                                        <header class="entry-header">
                                            <!-- Blog Title -->
                                            <h3 class="yk-product-title ">
                                                <a class="zh-amount" href="{{url($shop_data->shop_name.'/'.$acc->category_id.'/'.$shop_data->id)}}">
                                                    {{$acc->mm_name}}
                                                </a>
                                                <label class="zh_cat_count"> ( {{$acc->catcount}})  </label>
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

        </div>

        @endif

    </div>
</div>


