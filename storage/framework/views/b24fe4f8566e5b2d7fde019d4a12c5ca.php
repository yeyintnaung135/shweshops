<div class="tz-parent modal modal-bottom sop xs fade" id="orangeModalSubscription" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true">
    <button type="button" class="modal-close bg-0" data-dismiss="modal" aria-label="Close">
        <i class="fa-solid fa-xmark"></i> Close
    </button>
    <div class="modal-dialog modal-notify modal-warning tz-modal-notify " role="document">
        <!--Content-->
        <div class="modal-content border-0" style="background-color: #F3F4F9;">
            <!-- Select Login  -->
            <div class="modal-header select-login-header border-0" style="margin-top: -12px;">
                <div class="w-100 d-flex justify-content-center">
                    <div class="d-flex justify-content-around align-items-center w-50">
                        <div class="login-select-logo">
                            <img class="w-100" src="<?php echo e(url('test/img/logo-m.png')); ?>" />
                        </div>
                        <div class="select-login-title">
                            <h3 class="text-white mt-2">
                                Login As
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body select-login-body p-0 border-0">
                <div class="row justify-content-center p-lg-0 mobile-padding-login-btn">
                    <div
                        class="col-12 col-md-4 custom-rounded-left select-login-btn-height d-flex justify-content-center align-items-center py-2 userLogin">
                        <div class="d-block user">
                            <div class="font-weight-bolder text-center">
                                <i class="fas fa-user text-light" style="font-size: 30px"></i>
                            </div>
                            <a type="button"href="javascript:void(0)" aria-pressed="true"
                                class="text-light font-weight-bolder mr-3">User</a>
                        </div>
                    </div>
                    <div
                        class="col-12 col-md-4 custom-rounded-right select-login-btn-height d-flex justify-content-center align-items-center py-2 shopLogin">
                        <div class="d-block shopowner">
                            <div class="font-weight-bolder text-center ">
                                <i class="fas fa-store text-light" style="font-size: 30px"></i>
                            </div>
                            <a type="button" href="javascript:void(0)" aria-pressed="true"
                                class="text-light font-weight-bolder">Shop Owner</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Select Login end  -->

            <?php echo $__env->make('front.auth.userlogin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- request name login   -->
            <div class="modal-header request-name-header border">
                <div class="d-block w-100">
                    <div class="d-flex justify-content-center w-100 " id="shweShops">
                        <img class=" item pe-3 " src="<?php echo e(url('test/img/logo-m.png')); ?>"
                            style="height: 40px;padding-bottom:5px" />
                        <p class="sop-lr-h">Shwe Shops</p>
                    </div>
                    <h4 class="modal-title text-center white-text w-100 font-weight-bold py-2"
                        style="font-weight: bold;font-size: 20px;">
                        Login To ShweShops
                    </h4>
                </div>
            </div>
            <div class="modal-body request-name-body">
                <div class="p-3">
                    <!-- phone -->
                    <div class="md-form mb-5">
                        <label data-error="wrong" data-success="right" for="requestName" class="sop-lr-l">Name</label>
                        <input type="text" name="username" class="form-control sop-lr-in" id="requestName"
                            style="background-color: #F3F4F9;">

                        <span class="error_login_phone invalid-feedback d-none" role="alert"></span>

                    </div>


                    <div class="md-form">
                        <input type="button" value=" <?php echo e(__('Submit')); ?>" class="btn yk-btn-success w-100"
                            id="sentName"
                            style="
                            background-color: #780116!important;
                            color: white;
                            width: 100% !important;
                            border-radius: 10px;
                            height: 44px;
                            " />
                    </div>
                </div>
            </div>
            <!-- request name end  -->

            <?php echo $__env->make('front.auth.userregister', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('front.auth.shopownerlogin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php echo $__env->make('front.auth.codevertification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



            <?php echo $__env->make('front.auth.forgetpassword', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <!-- forgotpassword Code end  -->


    </div> <!--- Content End ----->

</div>

</div>

<?php $__env->startPush('css'); ?>
    <style>
        /* .phone_start_number{
                            position: absolute;
                            top:0;
                            left:0;
                        } */
        form #togglePassword {
            position: absolute;
            top: 20px;
            right: 10px;
            cursor: pointer;
        }

        .user-login-link-text {
            font-size: 15px !important;
        }

        .tz-parent {
            background-image: url("<?php echo e(asset('images/login_cover.jpg')); ?>");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            object-fit: cover;
            background-size: 100%;
            opacity: 1 !important;
            background-size: cover;
        }

        .tz-parent .modal button:hover {
            background: transparent !important;

        }

        .sop-resend-otp {
            border-radius: 10px !important;
            min-width: 100px;
        }

        .sop-resend-otp:hover,
        .sop-resend-otp:focus {
            background: transparent !important;
            color: #780116 !important;
            border: solid 1px #780116;
        }

        .sop-submit-otp {
            color: #780116 !important;
            border: solid 1px #780116;
            min-width: 100px;
        }

        .login-select-logo {
            width: 100px;

        }

        .tz-parent .modal-close {
            position: absolute !important;
            right: 0;
            top: 0;
            background-color: transparent !important;
            color: #ffffff !important;
            letter-spacing: 3px;
        }

        .fa-xmark {
            transition: transform 0.3s ease-out;
        }

        .modal-close:hover .fa-xmark {
            transform: rotate(90deg);
        }

        .tz-modal-notify {
            bottom: 0px !important;
        }

        .tz-parent .modal-content {
            margin-top: 10em;
            background: transparent !important;

        }

        .tz-parent .modal-header.select-login-header {
            background-color: transparent !important;
            color: #ffffff;
        }

        .tz-parent .modal-header.select-login-header h3 {
            font-weight: 900;
        }

        .tz-parent .select-login-btn-height {
            height: 170px;
            cursor: pointer;
        }

        .tz-parent .custom-rounded-left {
            background-color: rgb(120, 1, 22);
            border-radius: 6px 0px 0px 6px;
        }

        .tz-parent .custom-rounded-right {
            background-color: rgb(106, 192, 254);
            border-radius: 0px 6px 6px 0px;
        }

        .tz-parent .userLogin {
            font-size: 20px;
            font-weight: 1000;

        }

        .tz-parent .user {
            transition: transform 0.3s ease-in;
        }

        .tz-parent .userLogin:hover .user {
            transform: scale(1.09);
        }

        .tz-parent .shopLogin {
            font-size: 20px;
            font-weight: 1000;
            transition: transform 0.2s ease-in;

        }

        .tz-parent .shopowner {
            transition: transform 0.2s ease-in;
        }

        .tz-parent .shopLogin:hover .shopowner {
            transform: scale(1.09);
        }


        .tz-parent .modal-header.user-login-header {
            background-color: #fff;

        }

        .tz-parent .modal-body.user-login-body {
            background-color: #fff;
        }

        .tz-parent .modal-header.request-name-header {
            background-color: #fff;

        }

        .tz-parent .modal-body.request-name-body {
            background-color: #fff;
        }

        .tz-parent .modal-header.register-header {
            background-color: #fff;

        }

        .tz-parent .modal-body.register-body {
            background-color: #fff;
        }

        .tz-parent .modal-header.header3 {
            background-color: #fff;

        }

        .tz-parent .modal-body.body-3 {
            background-color: #fff;
        }



        .tz-parent .modal-header.header4 {
            background-color: #fff;

        }

        #codecheckforreg {
            background-color: #fff;
        }

        .tz-parent .modal-header.header5 {
            background-color: #fff;

        }

        .forgotpassword {
            background-color: #fff;
        }

        .confirm {
            background-color: #fff;
        }



        /* tz section end */

        .sop-lr-h {
            margin: 0;
            display: flex;
            align-items: center;
            font-size: 26px;
            font-family: sans-serif;
            font-weight: 800;
            color: rgb(120, 1, 22) !important;
        }

        .sop-lr-in {
            border: 2px solid #8080807b !important;
            background-color: #F3F4F9;
            border-radius: 10px !important;
        }

        .sop-lr-l {
            color: #808080 !important;
            font-weight: 600 !important;
        }

        .sop-lr-rf {
            font-family: sans-serif !important;
            font-weight: 600 !important;
            color: #808080 !important;
            font-size: 0.9em;
            cursor: pointer;
        }

        .tz-parent .modal-footer {
            border: none !important;
        }

        .zh-eye-picon:hover button i {
            color: black;

        }

        .zh-eye-picon:focus button i {
            color: black;

        }

        .zh-eye-picon:hover button i {
            transform: scale(1)
        }

        .zh-eye-picon button i {
            display: flex;
            color: #808080;
            transform: scale(0.9);


        }

        .zh-eye-picon {
            bottom: 0;
        }

        .sop .is-invalid {
            border-color: #dc3545 !important;
            padding-right: none !important;
            background-image: none !important;
            background: none !important;
            background-repeat: no-repeat;
            background-position: none;
            background-size: none;
        }

        .tz-parent .tz-btn {
            background-color: #780116 !important;
            color: #ffffff;
            /* width: 100% !important; */
            border-radius: 10px;
            height: 44px;
            margin-left: 10px;
        }

        .zh-eye-picon {
            height: 50px;
            top: 0;
        }

        @media only screen and (max-width: 1396px) {
            .zh-eye-picon {
                height: 38px;
            }

            .login-select-logo {
                width: 60px;
            }

            .select-login-title h3 {
                font-weight: 500;
            }

            .user i {
                font-size: 20px !important;
            }

            .shopowner i {
                font-size: 20px !important;
            }

            .select-login-btn-height {
                height: 100px;
                margin-bottom: 0.5em;
            }

            .mobile-padding-login-btn {
                padding: 0px 30px 0px 30px;
            }

            .modal-backdrop {
                /* background-image: url("<?php echo e(asset('images/login-cover-mobile.jpg')); ?>") !important; */
                background-image: url("<?php echo e(asset('images/login_cover.jpg')); ?>") !important;
                ;
                background-repeat: no-repeat;
                /* background-attachment: fixed; */
                background-position: 100%;
                background-size: 100% 100%;
                object-fit: cover;
                object-position: center;
                background-size: cover;
            }
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('JsScripts.Front.login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php /**PATH P:\xampp\htdocs\shweshops\resources\views/front/auth/popup.blade.php ENDPATH**/ ?>