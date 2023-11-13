<div>
<?php if(session()->has('message')): ?>
        <?php $__env->startPush('scripts'); ?>
            <script>
            $(function () {
            const Toast = Swal.mixin({
            toast: true,
            position: 'top-center',
            confirmButtonText:'Close',
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
            })

            Toast.fire({
            customClass : {
            title: 'swal-yk-title'
            },
            icon: 'success',
            title: "<?php echo e(session()->get('message')); ?>",

            })
            });
            </script>
        <?php $__env->stopPush(); ?>

<?php endif; ?>
</div>
<?php /**PATH P:\xampp\htdocs\shweshops\resources\views/components/alert.blade.php ENDPATH**/ ?>