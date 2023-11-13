

<?php $__env->startSection('title', __('Not Found')); ?>
<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center align-items-center min-vh-100">
                <h1>Item Not Found</h1>
            </div>
        </div>
    </div>
    <!-- <div id="notfound">
        <div class="notfound">
            <div class="notfound-404 mb-5">
                <h1>4<span>0</span>4</h1>
            </div>
            <p>The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
            <a href="/">home page</a>
        </div>
    </div> -->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH P:\xampp\htdocs\shweshops\resources\views/errors/404.blade.php ENDPATH**/ ?>