
<?php $__env->startSection('content'); ?>
    <div class="container-fluid" >
        <div class="row">
            <div class="d-none col-12 col-lg-6  vh-100 d-lg-flex justify-content-center align-items-center super_admin_background">
            <a href="<?php echo e(url('/')); ?>">
                <div class="p-3 d-flex align-items-center">
                  <div class="">

                        <img src="<?php echo e(asset('test/img/logo-m.png')); ?>" alt="" width="100px">


                  </div>
                  <div class="ml-3">
                     <h1 class="font-weight-bolder text-light mt-3">Shweshops</h1>
                  </div>
                </div>
                </a>
            </div>
            <div class="col-12 col-lg-6  mt-lg-0 d-flex justify-content-center align-items-center p-0 mt-5">
                <div class="col-12 col-lg-6 p-lg-0 p-3">
                    <div class="col-12 mobile_super_admin_login_header">
                        <div class="d-flex justify-content-center align-items-center">
                        <img src="<?php echo e(asset('test/img/logo-m.png')); ?>" alt="" width="70px">
                            <h1 class="ml-3 mt-3 font-weight-bolder super_admin_secondary_text_color">Shweshops</h1>
                        </div>
                    </div>
                   <div class="login-header mb-5">
                      <h3 class="font-weight-bolder mobile_super_admin_login_font_size ">Login As Super Admin</h3>
                   </div>
                   <div class="login-form">
                    <form method="POST" action="<?php echo e(route('backside.super_admin.login')); ?>">
                       <?php echo csrf_field(); ?>
                        <div class="form-group">
                             <label for="email" class="font-weight-bolder"><?php echo e(__('Email')); ?></label>
                                <input id="email" type="email" class="form-control-lg form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <label for="password" class="font-weight-bolder"><?php echo e(__('Password')); ?></label>
                               <div class="position-relative ">
                               <input id="password" type="password" class="form-control form-control-lg <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="current-password">
                                <i class="fas fa-eye-slash " id="togglePassword" onclick="toggleEye(this)"></i>
                               </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        </div>
                        <div class="form-group mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>

                                    <label class="form-check-label text-black-50" for="remember">
                                        <?php echo e(__('Remember me')); ?>

                                    </label>
                                </div>
                                <div class="">
                                 <a class="btn btn-link text-black-50" href="<?php echo e(route('backside.super_admin.password.request')); ?>">
                                    
                                        <?php echo e(__('Forgot Your Password?')); ?>

                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="">
                                <button type="submit" class="admin_login_btn font-weight-bolder rounded-3">Login</button>


                            
                            </div>
                        </div>
                    </form>
                   </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
<style>
    form i {
        position: absolute;
        top :15px;
        right: 10px;
        cursor: pointer;
    }
    .login-header{
        position: relative;
    }
    .login-header::before{
        content: '';
        position: absolute;
        top: -20px;
        left: 0;
        width: 50px;
        height: 4px;
        background: #770016;
    }
    .super_admin_background{
        background-color: #770016;
    }

    .super_admin_secondary_text_color{
        color: #770016;
    }

    .admin_login_btn{
        width: 100%;
        height: auto;
        padding: 10px;
        background-color: #770016;
        border:0;
        color: #fff;
        font-weight: bolder;
        font-size: 17px;
    }

    .mobile_super_admin_login_header{
        display: none;
    }

    .circle_height{
        height: 130px;
    }


    @media screen and (max-width: 990px) {
        .login-header{
         text-align: center;
         font-size: 15px;
        }
        .login-header::before{
            display:none;
        }
        .mobile_super_admin_login_header{
            display: block;
        }
        .mobile_super_admin_login_font_size{
            font-size: 20px;
            font-weight: bolder;
        }
    }

    a:hover{
        text-decoration: none;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    function toggleEye(e){
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
            } else {
                x.type = "password";
            }
            $(e).toggleClass('fas fa-eye-slash fas fa-eye');
    }

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH P:\xampp\htdocs\shweshops\resources\views/auth/super_admin_login.blade.php ENDPATH**/ ?>