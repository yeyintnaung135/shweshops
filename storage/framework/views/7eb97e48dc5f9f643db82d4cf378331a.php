


<div id="preminum" class="col-12 d-none show_dev">
    <div id="primary2" class="sop-font">
        
        <div class="mt-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading px-4 px-md-5 d-flex justify-content-end">
            <div class="elementor-widget-container d-flex justify-content-between">
                <h3 class="elementor-heading-title elementor-size-default" style="font-family: sans-serif!important">သင့်အတွက်စိန်ရွှေရတနာများ</h3>
            </div>
            <?php if(count($recommendedProducts) > 0): ?>

            <div>
                <a class="btn see-more-button" href="<?php echo e(url('seeallforyou')); ?>" style="white-space: nowrap; border-radius: 7px;">See All <i class="fas fa-angle-right"></i></a>
            </div>
            <?php endif; ?>
        </div>
        
        <?php if(count($recommendedProducts) == 0): ?>
        <div class="sn-no-items">
            <div class="sn-cross-sign"></div>
            <i class="fa-solid fa-box-open"></i>
            <span>No Items Found.</span>
        </div>
        <?php else: ?>
        
        <div class="col-12 mt-4 main-content">
            <div id='recommended4U_slide' class="owl-carousel owl-theme w-100 ps-4 px-md-5">
                <?php $__currentLoopData = $recommendedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <article class="post-wrapper">
                    <div class="post-img sop-img">
                        <a class="" href="<?php echo e(url('/'.$product->withoutspace_shopname.'/product_detail/'.$product->id)); ?>">
                            <?php if(empty($product->default_photo)): ?>
                            <img src="<?php echo e(filedopath($product->check_photo)); ?>" class="sn-shop-image attachment-ftc_blog_shortcode_thumb size-ftc_blog_shortcode_thumb wp-post-image lazyloaded  sop-image-w-h"alt="">
                            <?php else: ?>
                            <img src="<?php echo e(filedopath($product->check_photo)); ?>"class="sn-shop-image attachment-ftc_blog_shortcode_thumb size-ftc_blog_shortcode_thumb wp-post-image lazyloaded  sop-image-w-h"
                            alt="">
                            <?php endif; ?>
                        </a>

                        <h3 class="yk-product-title "><a class="sop-font-content sop-font mt-2" style="font-family: sans-serif!important"
                            href="<?php echo e(url('/'.$product->shop_name_url.'/product_detail/'.$product->id)); ?>"><?php echo e(\Illuminate\Support\Str::limit($product->item_name, 12, '...')); ?></a>
                        </h3>
                    </div>
                    <div class="post-info">
                        <p class="product-text-eng" style="font-size: 16px; font-weight: bold;">
                            <?php echo $product->mm_price; ?>

                        </p>
                    </div>
                </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>


<?php $__env->startPush('custom-scripts'); ?>
    <script type="text/javascript">
    $('#recommended4U_slide').owlCarousel({
        loop: false,
        margin: 20,
        responsiveClass: true,
        autoplay: false,
        dots: false,
        autoplayTimeout: 6000,
        autoplayHoverPause: true,

        responsive: {
            0: {
                items: 2,
                stagePadding: 0,
            },
            600: {
                items: 2,
                stagePadding: 0,
            },
            900: {
                items: 3,
                stagePadding: 0,
            },
            1200: {
                items: 4,
                stagePadding: 0,
            },
            1400: {
                items: 6,
                stagePadding: 0,
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH P:\xampp\htdocs\shweshops\resources\views/front/recommendedForYou.blade.php ENDPATH**/ ?>