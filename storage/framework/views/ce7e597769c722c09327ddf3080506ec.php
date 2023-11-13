
     
     <?php if (isset($component)) { $__componentOriginal71c6471fa76ce19017edc287b6f4508c = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.wrappercomponent','data' => ['divId' => 'catwrap','toshowId' => 'catdiv']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('wrappercomponent'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['div-id' => 'catwrap','toshow-id' => 'catdiv']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal71c6471fa76ce19017edc287b6f4508c)): ?>
<?php $component = $__componentOriginal71c6471fa76ce19017edc287b6f4508c; ?>
<?php unset($__componentOriginal71c6471fa76ce19017edc287b6f4508c); ?>
<?php endif; ?>

     
                        <div id="catdiv" class="col-12 mt-lg-4 mt-2 main-content d-none show_dev">

                            <!-- CAtegories -->

                            <div id='categories_slide' class="owl-carousel owl-theme w-100 ">


                                <?php $__currentLoopData = $cat_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $acc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                     <?php if($acc->catcount != 0): ?>
                                            <div class="col-12">
                                                <article class="post-wrapper">
                                                    <div class="text-center post-img">
                                                        <a class=""
                                                           href="<?php echo e(url('see_by_categories/'.$acc->category_id)); ?>">


                                                                <img src="<?php echo e(url('test/forcategory/'.$acc->category_id.'.jpg')); ?>"
                                                                style="width:76px !important;height:80px !important;border-radius:50% !important;"
                                                                    class="attachment-ftc_blog_shortcode_thumb size-ftc_blog_shortcode_thumb wp-post-image lazyloaded yk-image rounded-circle"
                                                                    alt="">
                                                        </a>
                                                    </div>
                                                    <div class="post-info text-center">
                                                            <header class="entry-header">
                                                                <!-- Blog Title -->
                                                                <h3 class="yk-product-title "><a class="zh-amount sop-font"
                                                                                                 href="<?php echo e(url('see_by_categories/'.$acc->category_id)); ?>">
                                                                    <?php echo e($acc->mm_name); ?>

                                                                    <h3 class="zh_cat_count"> ( <?php echo e($acc->catcount); ?> )  </h3>
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
                                     <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>


                        </div>
<?php /**PATH P:\xampp\htdocs\shweshops\resources\views/layouts/frontend/allpart/categories.blade.php ENDPATH**/ ?>