<div class="footer-mobile">
    <div class="mobile-home">
        <a href="<?php echo e(url('/')); ?>">
            <i class="zh-icon fa fa-home" style="<?php if(Request::path() == "/" || Request::path() == "unittest/index"): ?> color:#780116 !important; <?php else: ?> color:#666666 !important; <?php endif; ?>"></i>
            Home </a>
    </div>
    <div class="mobile-home">
        <a href="<?php echo e(url('see_by_categories')); ?>">

            <i class="zh-icon fa-solid fa-magnifying-glass" style="<?php if(Request::path() == "see_by_categories"): ?> color:#780116 !important; <?php else: ?> color:#666666 !important; <?php endif; ?>"></i>
            Search</a>
    </div>
    <div
        class="sop-mobile-nav ">
        <a2cicon-com></a2cicon-com>
    </div>



    <div class="mobile-home">
        <a href="<?php echo e(url('/shops')); ?>">
            <div class="position-relative">
                <i class="fas fa-store" style="<?php if(Request::path() == "shops"): ?> color:#780116 !important; <?php else: ?> color:#666666 !important; <?php endif; ?>" id="mobileFootHeart"></i>
                
            </div>

            Shop</a>

    </div>

    <?php if(isset(Auth::guard('web')->user()->id)): ?>
        <form type="hidden" id="fav-server"  method="POST" style="display: none;">
            <?php echo csrf_field(); ?>
        </form>
        <form type="hidden" id="selection-server"  method="POST" style="display: none;">
            <?php echo csrf_field(); ?>
        </form>
        <div class="mobile-account">
            <a href="<?php echo e(route('backside.user.user_profile')); ?>">
                <!--<i class="zh-icon fa-solid fa-arrow-right-from-bracket" style="color:#780116 !important;"></i>-->
                <!--Logout-->
                <i class="zh-icon fa-solid fa-user-gear a-arrow-right-from-bracket" style="color:#666666 !important;"></i>
                Profile
            </a>
        </div>

    <?php elseif(isset(Auth::guard('shop_owners_and_staffs')->user()->id)): ?>
        <div class="mobile-account">
            <a href="<?php echo e(url('backside/shop_owner/detail')); ?>">
                <i class="zh-icon fa-solid fa-user-gear" style="color:#666666 !important;"></i>
                Shop Owner
            </a>
        </div>

    <?php elseif(isset(Auth::guard('shop_owners_and_staffs')->user()->id)): ?>
        <div class="mobile-account">
            <a href="<?php echo e(url('backside/shop_owner/detail')); ?>" title="Logout">
                <i class="zh-icon fa-solid fa-user-gear" style="color:#666666 !important;"></i>
                Shop
            </a>
        </div>
    <?php else: ?>
        <div class="mobile-account">

            <a href="" class="checkForm" title="checkForm" data-toggle="modal" data-target="#orangeModalSubscription">
                <i class="zh-icon fa fa-user" style="color:#666666 !important;"></i>
                Login</a>

        </div>
    <?php endif; ?>


</div>

<?php echo $__env->make('layouts.frontend.allpart.noti', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php echo $__env->make('front.auth.confirm_logout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- zh pop up -->
<?php echo $__env->make('front.auth.popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- end zh pop up -->

<?php /**PATH P:\xampp\htdocs\shweshops\resources\views/layouts/frontend/allpart/mobile_footer.blade.php ENDPATH**/ ?>