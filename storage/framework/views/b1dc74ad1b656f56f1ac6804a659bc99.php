       <!-- user register   -->
       <div class="modal-header register-header">
        <div class="d-block w-100">
            <div class="d-flex justify-content-center w-100 " id="shweShops">
                <img class=" item pe-3 " src="<?php echo e(url('test/img/logo-m.png')); ?>"
                    style="height: 40px;padding-bottom:5px" />
                <p class="sop-lr-h">Shwe Shops</p>
            </div>
            <h4 class="modal-title text-center white-text w-100 font-weight-bold py-2"
                style="font-weight: bold;font-size: 20px;">
                Register
            </h4>
        </div>
    </div>
    <div class="modal-body register-body">
        <div class="p-3">
            <!-- phone -->
            <div class="md-form mb-3">
                <label data-error="wrong" data-success="right" for="userName" class="sop-lr-l">Name</label>
                <input type="text" name="username" class="form-control sop-lr-in" id="userName"
                    style="background-color: #F3F4F9;">

                <span class="error_name invalid-feedback d-none" role="alert"></span>

            </div>
            <div class="md-form mb-3">
                <label data-error="wrong" data-success="right" for="regPhoneNumber"
                    class="sop-lr-l">Phone</label>
                <input type="text" value="" name="phone" class="form-control sop-lr-in"
                    id="regPhoneNumber" style="background-color: #F3F4F9;">

                <span class="error_phone invalid-feedback d-none" role="alert"></span>

            </div>

            <div class="md-form mb-3 text-center">
                <a type="button" href="javascript:void(0);" class="userLogin user-login-link-text"
                    aria-pressed="true" style="color: #0d6efd !important;">
                    <?php echo e(__('အကောင့်ဝင်ရန်')); ?>

                </a>
            </div>

            <div class="md-form">
                <input type="button" value=" <?php echo e(__('Register')); ?>" class="btn yk-btn-success w-100"
                    id="register"
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
    <!-- user register end  --><?php /**PATH P:\xampp\htdocs\shweshops\resources\views/front/auth/userregister.blade.php ENDPATH**/ ?>