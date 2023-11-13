      <!-- user login   -->
      <div class="modal-header user-login-header border">
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
    <div class="modal-body user-login-body">
        <div class="p-3">
            <!-- phone -->
            <input id="loginbeforebuynow" name="frombuynow" type="hidden" value="">
            <input id="loginbeforemessenger" name="frommessenger" type="hidden" value="">
            <input id="loginbeforepayment" name="frompayment" type="hidden" value="">
            <div class="md-form mb-3">
                <label data-error="wrong" data-success="right" for="phoneNumber" class="sop-lr-l">Phone</label>
                <input type="text" value="" name="phone" class="form-control sop-lr-in"
                    id="phoneNumber" style="background-color: #F3F4F9;">

                <span class="error_login_phone invalid-feedback d-none" role="alert"></span>

            </div>

            <div class="md-form mb-3 text-center">
                <a type="button" href="javascript:void(0);" class="userRegister" aria-pressed="true"
                    style="color: #0d6efd !important;">
                    <?php echo e(__('အကောင့်မရှိလျှင်')); ?> <?php echo e(__('အကောင့်သစ်ဖွင့်ရန်')); ?>

                </a>
            </div>

            <div class="md-form">
                <input type="button" value=" <?php echo e(__('Login')); ?>" class="btn yk-btn-success w-100"
                    id="login"
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
    <!-- user login end  --><?php /**PATH P:\xampp\htdocs\shweshops\resources\views/front/auth/userlogin.blade.php ENDPATH**/ ?>