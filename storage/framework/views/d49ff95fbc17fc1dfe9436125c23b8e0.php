<?php if (isset($component)) { $__componentOriginal71c6471fa76ce19017edc287b6f4508c = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.wrappercomponent','data' => ['divId' => 'preminumwrap','toshowId' => 'preminum']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('wrappercomponent'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['div-id' => 'preminumwrap','toshow-id' => 'preminum']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal71c6471fa76ce19017edc287b6f4508c)): ?>
<?php $component = $__componentOriginal71c6471fa76ce19017edc287b6f4508c; ?>
<?php unset($__componentOriginal71c6471fa76ce19017edc287b6f4508c); ?>
<?php endif; ?>


<div id="preminum" class="col-12 d-none show_dev">
    <div id="primary2" class="sop-font">
        
        <div class="mt-4 elementor-element elementor-element-3205fef1 elementor-widget elementor-widget-heading px-4 px-md-5 d-flex justify-content-end">
            <div class="elementor-widget-container d-flex justify-content-between">
                <h3 class="elementor-heading-title elementor-size-default" style="font-family: sans-serif!important">Premium ဆိုင်များ</h3>
            </div>
            <div>
                <a class="btn see-more-button" href="/premium_shops" style="white-space: nowrap; border-radius: 7px;">See All <i class="fas fa-angle-right"></i></a>
            </div>
        </div>
        <?php if(count($premium) == 0): ?>
        <div class="sn-no-items">
            <div class="sn-cross-sign"></div>
            <i class="fa-solid fa-box-open"></i>
            <span>No Premium Shops Available.</span>
        </div>
        <?php else: ?>
        
        <div class="col-12 mt-4 main-content ">
            <div id='pshop_slide' class="owl-carousel owl-theme w-100 px-md-5">
                <?php $__currentLoopData = $premium; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <article class="post-wrapper">
                    <div class="post-img sop-img">
                        <a class="" href="<?php echo e(url('/'.$shop->withoutspace_shopname)); ?>">
                            <?php if(empty($shop->shop_logo)): ?>
                            <img src="test/test1.jpg"class="attachment-ftc_blog_shortcode_thumb size-ftc_blog_shortcode_thumb wp-post-image lazyloaded  sop-image-w-h"alt="">
                            <?php else: ?>
                            <img src="<?php echo e(filedopath('/shop_owner/logo/mid/'.$shop->shop_logo)); ?>"class="attachment-ftc_blog_shortcode_thumb size-ftc_blog_shortcode_thumb wp-post-image lazyloaded  sop-image-w-h p-1 px-2"
                            alt="">
                            <img src="<?php echo e(url('/images/directory/banner/Frame 925.png')); ?>" alt="" srcset="" class="kanok-frame">
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="post-info">
                        <header class="entry-header">
                            <!-- Blog Title -->
                            <h3 class="yk-product-title ps-2"><a class="sop-font-content sop-font mt-2" style="font-family: sans-serif!important"
                                href="<?php echo e(url('/'.$shop->withoutspace_shopname)); ?>"><?php echo e(\Illuminate\Support\Str::limit($shop->shop_name, 12, '...')); ?></a>
                            </h3>
                            <!-- Blog Author -->
                            <span class="vcard author" style=""></span>
                            <!-- Blog Categories -->
                        </header>
                        <div class="clear"></div>
                        
                        <div class="clear"></div>
                        
                    </div>
                </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('custom-scripts'); ?>
<script>
$(document).ready(function () {
    $('#pshop_slide').owlCarousel({
        loop: true,
        margin: 20,
        responsiveClass: true,
        autoplay: true,
        dots: false,
        autoplayTimeout: 6000,
        autoplayHoverPause: true,

        responsive: {
            0: {
                items: 1.5,
                stagePadding: 20,
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
                items: 5,
                stagePadding: 0,
            }
        }
    });
});
</script>
<?php $__env->stopPush(); ?><?php /**PATH P:\xampp\htdocs\shweshops\resources\views/layouts/frontend/allpart/shop_detail/premium_sellers.blade.php ENDPATH**/ ?>