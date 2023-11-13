
            <!-- shop Owner Login form  -->
            <div class="modal-header header3">
                <div class="d-block w-100">
                    <div class="d-flex justify-content-center w-100 " id="shweShops">
                        <img class=" item pe-3 " src="<?php echo e(url('test/img/logo-m.png')); ?>"
                            style="height: 40px;padding-bottom:5px" />
                        <p class="sop-lr-h">Shwe Shops</p>
                    </div>

                    <h4 class="modal-title text-center white-text w-100 font-weight-bold py-2"
                        style="font-weight: bold;font-size: 20px;">
                        Shop Owner Login
                    </h4>
                </div>

            </div>
            <div class="modal-body body-3">
                <div class="p-3">
                    <form method="POST" action="<?php echo e(url('backside/shop_owner/login')); ?>">
                        <?php echo e(Form::hidden('url', URL::previous())); ?>

                        <?php echo csrf_field(); ?>
                        <input id="loginbeforesupport" name="fromsupport" type="hidden" value="">

                        <input id="loginbeforebuynow" name="frombuynow" type="hidden" value="">
                        <div class="md-form mb-5">
                            <label data-error="wrong" data-success="right" for="form3"
                                class="sop-lr-l">Phone</label>
                            <input type="text" name="value" value="09" class="form-control sop-lr-in "
                                style="border-color: #808080;background-color: #F3F4F9;" required>
                        </div>
                        <div class="md-form position-relative">

                            <label for="password" class="sop-lr-l">Password</label>
                            <div class="position-relative d-flex flex-column">
                           
                                <input type="password" name="password" id="password" class="sop-lr-in form-control"
                                    style="background-color: #F3F4F9;" required>
                                <i class="fas fa-eye-slash " id="togglePassword" onclick="toggleEye(this)"></i>
                                <?php if(Session::has('error')): ?>
                                    <span class="text-danger font-weight-bolder">
                                        <?php echo e(Session::get('error')); ?>

                                    </span>
                                <?php endif; ?>

                            </div>


                        </div>

                        <div class="form-check mb-4 d-flex flex-row no-gutters" style="margin-top: 31px;">
                            <div class="col-6 justify-content-start">

                                <input type="checkbox" class="form-check-input" id="exampleCheck1"
                                    style="cursor: pointer">
                                <label class="form-check-label sop-lr-rf" for="exampleCheck1">Remember Me</label>
                            </div>
                            <div class="col-6 d-flex justify-content-end">

                                <a href="javascript:void(0)"
                                    class="float-right  sop-lr-rf forgotpasswordbutton">Forgot Password?</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn yk-btn-success sop-submit w-100"
                                style=" background-color: #780116!important;
                                    color: white;
                                    width: 100% !important;
                                    border-radius: 10px;
                                    height: 44px;
                                    ">
                                <?php echo e(__('Login')); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- shop Owner Login end  --><?php /**PATH P:\xampp\htdocs\shweshops\resources\views/front/auth/shopownerlogin.blade.php ENDPATH**/ ?>