<div class="ftc-mobile-wrapper">
    <div class="menu-text sop-sans d-flex justify-content-between align-items-center logo-nav-m"
        style="background: #000000!important;color:rgb(255, 255, 255);">
        <div class="d-flex justify-content-start align-items-end">
            <div style="width: 100px">
                <img src="<?php echo e(url('test/img/logo-m.png')); ?>"style="width:100%;object-fit:cover;" class=""
                    alt="" style="">
            </div>
            <p class="logo-sop mb-0">Shwe Shops</p>
        </div>

        <button type="button" class="btn btn-toggle-canvas btn-danger d-flex justify-content-center align-items-center"
            data-toggle="offcanvas">
            <i class="fa fa-close"></i>
        </button>

    </div>
    <div class=" ps-3 pt-3 sop-menus">
        <div class="menu-text sop-sans " style="background: transparent!important;color:black;">
            <h3>Menu</h3>
        </div>
        <div class="menu-mobile">
            <div class="">
                <div class="">
                    <a title="" href="<?php echo e(url('/')); ?>" class="d-flex">
                        
                        <i class="fi fi-rs-home col-2"></i>
                        ပင်မ
                    </a>
                </div>
            </div>
        </div>
        <div class="menu-mobile">
            <div class="">
                <div class="">
                    <a title="" href="<?php echo e(url('/shops')); ?>" class="d-flex">
                        
                        <i class="fi fi-rs-shop col-2"></i>
                        ဆိုင်များ
                    </a>
                </div>
            </div>
        </div>
        <div class="menu-mobile">
            <div class="">
                <div class="">
                    <a title="" href="<?php echo e(url('/news')); ?>" class="d-flex">
                        <i class="fas fa-newspaper col-2"></i>
                        သတင်း နှင့် ပွဲများ
                    </a>
                </div>
            </div>
        </div>
        <div class="menu-mobile d-none">
            <div class="    ">
                <div class="">
                    <a title="" href="<?php echo e(url('/see_all_discount/all')); ?>" class="d-flex text-capitalize">
                        <i class="fa-solid fa-exclamation col-2 ps-2"></i>
                        <span class="sop-sans">Promotions&nbsp;</span>များ
                    </a>
                </div>
            </div>
        </div>

        <div class="menu-text sop-sans mt-3" style="background: transparent!important;color:black;">
            <h3>quick links</h3>

        </div>
        <div class="menu-mobile">
            <div class="">
                <div class="">
                    <a title="" href="<?php echo e(url('see_all_new')); ?>" class="d-flex">
                        
                        <i class="fi fi-rs-confetti col-2"></i>
                        အသစ်ရောက် ပစ္စည်းများ
                    </a>
                </div>
            </div>
        </div>
        <div class="menu-mobile">
            <div class="">
                <div class="">
                    <a title="" href="<?php echo e(url('see_all_pop')); ?>" class="d-flex">
                        
                        <i class="fi fi-rr-crown col-2"></i>
                        လူကြိုက်များသော ပစ္စည်းများ
                    </a>
                </div>
            </div>
        </div>
        <div class="menu-mobile">
            <div class="    ">
                <div class="">
                    <a title="" href="<?php echo e(url('/see_all_discount/all')); ?>" class="text-capitalize d-flex">
                        
                        <i class="fi fi-rr-megaphone col-2"></i>
                        <span class="sop-sans">Discount&nbsp;</span>ပစ္စည်းများ
                    </a>
                </div>
            </div>
        </div>
        <div class="menu-mobile">
            <div class="    ">
                <div class="sop-sans">
                    <a title="" href="<?php echo e(url('/myfav/see_all')); ?>" class="d-flex">
                        <i class="fa-regular fa-heart col-2"></i>
                        wishlist
                    </a>
                </div>
            </div>
        </div>
        <div class="menu-mobile">
            <div class="    ">
                <div class="">
                    <a title="" href="<?php echo e(url('mycart/see_all')); ?>" class=" d-flex">
                        
                        <i class="fi fi-rs-shopping-cart-check col-2"></i>
                        ‌ရွေးထားတာလေးများ
                    </a>
                </div>
            </div>
        </div>
        <div class="menu-mobile">
            <div class="    ">
                <div class="">
                    <a title="" href="<?php echo e(url('directory/all')); ?>" class=" d-flex">
                        
                        <i class="fi fi-rs-shop col-2"></i>
                        Shops Directory
                    </a>
                </div>
            </div>
        </div>

        <div class="menu-mobile">
            <div class="">
                <div class="sop-sans">
                    <a title="" href="<?php echo e(url('/support')); ?>" class=" d-flex">
                        <i class="fi fi-rr-comment-info col-2"></i>

                        Help & Support
                    </a>
                </div>
            </div>
        </div>
        <div class="menu-mobile">
            <div class="">
                <div class="sop-sans">
                    <a title="" href="<?php echo e(url('/contact-us')); ?>" class=" d-flex">
                        <i class="fi fi-rr-comment-info col-2"></i>

                        Contact us
                    </a>
                </div>
            </div>
        </div>

        <div class="menu-mobile">
            <div class="">
                <div class="sop-sans">
                    <a title="" href="<?php echo e(url('/')); ?>" class="d-none sop-disable d-flex">
                        <i class="fa-solid fa-headphones-simple  col-2"></i>
                        customer service
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php
        use App\Models\AppFile;
        $appFile = AppFile::where('user_type', 'Regular User')
            ->where('operating_system', 'Android')
            ->first();
    ?>

    <?php if($appFile): ?>
        <div class="text-center mx-3 d-grid gap-2">
            <a href="" class="btn btn-primary rounded-pill btn-block text-light" type="button"
                data-toggle="modal" data-target="#appDownloadMobileModal" style="background-color:#780116">
                <i class="fa-solid fa-download"></i> Download now</a>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="appDownloadMobileModal" tabindex="-1"
            aria-labelledby="appDownloadMobileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center  border-0">
                        <h5 class="modal-title text-color" id="appDownloadMobileModalLabel">
                            DOWNLOAD SHWESHOPS
                        </h5>
                    </div>
                    <div class="modal-body text-center  border-0">
                        <p class="text-dark">Are you sure you want to download?</p>
                    </div>
                    <div class="modal-footer justify-content-center  border-0">
                        <button type="button" class="btn btn-outline-danger px-4" data-dismiss="modal">No</button>
                        <a href="<?php echo e(route('front.app-files.download', $appFile)); ?>"
                            class="btn btn-success text-light px-4">Yes</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    
    
    
    
    

    
    <div class="header-mobile-social d-flex justify-content-center mt-5">
        <ul>
            <li class=""><a href="https://www.facebook.com/shweshops123"><i
                        class="fab fa-facebook-f fa-size"></i>.</a></li>
            <li class="d-none"><a href="#"><i class="fab fa-twitter fa-size"></i></i>.</a></li>
            <li class="d-none"><a href="#"><i class="fab fa-instagram fa-size"></i>.</a></li>
        </ul>
    </div>


</div>
<?php $__env->startPush('css'); ?>
    <style>
        @import url(<?php echo e(url('fonts/css/flaticon-straight.css')); ?>);
        @import url(<?php echo e(url('fonts/css/flaticon-rounded.css')); ?>);

        .logo-sop {
            line-height: 30px;
            font-size: 25px;
            padding-left: 5px;
            color: #f8af29;
        }

        .header-mobile-social {
            margin-top: 5px;
            padding-left: 0px !important;

        }

        .header-mobile-social ul {
            padding-left: 0 !important;
        }

        @media only screen and (max-width: 991px) {
            .ftc-mobile-wrapper {

                width: 400px !important;
            }

            /* .ftc-mobile-wrapper {
                                                transform: translate3d(-400px, 0, 0);
                                            } */
        }

        /* .sop-sans{
                                            font-family: sans-serif;
                                        } */
        .sop-sans a {
            font-size: 1.1rem !important;
            text-transform: capitalize;
        }

        .fa-size {
            font-size: 18px !important;
            color: #780116;
        }

        .logo-nav-m {
            box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
        }

        .ftc-mobile-wrapper .menu-text .btn-toggle-canvas.btn-danger {
            float: right;
            margin-right: 10px;
            background-color: white !important;
            border-color: #fffafa !important;
            color: #1B1A17;
            box-shadow: #fff;
        }

        .sop-menus i {

            font-size: 1.3rem;
            color: #780116;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php /**PATH P:\xampp\htdocs\shweshops\resources\views/layouts/frontend/allpart/for_mobile.blade.php ENDPATH**/ ?>