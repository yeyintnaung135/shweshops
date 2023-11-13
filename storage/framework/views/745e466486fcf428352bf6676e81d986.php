<div class="remove_wrapp" id="<?php echo e($divId); ?>" style="height: 222px !important;">
    <div id="ct-loadding" class="style5 yk-wrapper ">
        <div class="ct-spinner5">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
</div>
<?php $__env->startPush('custom-scripts'); ?>
    <script>
       if(document.getElementById('<?php echo e($divId); ?>').offsetHeight > 0){
           document.getElementById('<?php echo e($toshowId); ?>').classList.remove('d-none');
           document.getElementById('<?php echo e($divId); ?>').classList.add('d-none');
       }


    </script>

<?php $__env->stopPush(); ?>
<?php /**PATH P:\xampp\htdocs\shweshops\resources\views/components/wrappercomponent.blade.php ENDPATH**/ ?>