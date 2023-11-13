<?php $__env->startSection('title', 'MOE Admin Team | Site Setting'); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="wrapper">
        <!-- Navbar -->
        <?php echo $__env->make('backend.super_admin.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <?php echo $__env->make('backend.super_admin.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="content-wrapper">
            <?php if (isset($component)) { $__componentOriginal71c6471fa76ce19017edc287b6f4508c = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal71c6471fa76ce19017edc287b6f4508c)): ?>
<?php $component = $__componentOriginal71c6471fa76ce19017edc287b6f4508c; ?>
<?php unset($__componentOriginal71c6471fa76ce19017edc287b6f4508c); ?>
<?php endif; ?>
            <section class="content-header">
                <?php if (isset($component)) { $__componentOriginal71c6471fa76ce19017edc287b6f4508c = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.title','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Site Settings <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal71c6471fa76ce19017edc287b6f4508c)): ?>
<?php $component = $__componentOriginal71c6471fa76ce19017edc287b6f4508c; ?>
<?php unset($__componentOriginal71c6471fa76ce19017edc287b6f4508c); ?>
<?php endif; ?>
            </section>
            <section class="content row container mx-auto">
                <ul class="list-group col-12 col-md-6 mx-1 mx-md-4">
                    <?php $__currentLoopData = $sitesettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sitesetting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div><?php echo e($sitesetting->name); ?> feature is <span id="toggleText<?php echo e($sitesetting->id); ?>"></span>
                            </div>
                            <div class="custom-control custom-switch">
                                <input type="hidden" id="<?php echo e($sitesetting->id); ?>">
                                <input type="checkbox" name="settings" class="custom-control-input"
                                    id="settingToggle<?php echo e($sitesetting->id); ?>" name='machine_state'>
                                <label class="custom-control-label" id="statusText"
                                    for="settingToggle<?php echo e($sitesetting->id); ?>"></label>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </section>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        var sitesettings = <?php echo json_encode($sitesettings); ?>;
        sitesettings.forEach(sitesetting => {
            if (sitesetting.action == "on") {
                $('#settingToggle' + sitesetting.id).prop('checked', true);
            } else {
                $('#settingToggle' + sitesetting.id).prop('checked', false);
            }
            document.getElementById('toggleText' + sitesetting.id).innerHTML = sitesetting.action;
            // if(sitesetting.id == 2) {
            //   $('#settingToggle'+sitesetting.id).prop('disabled', true);
            // }
        });

        var checkboxes = $('[name="settings"]');

        checkboxes.on('change', function() {
            var parentDiv = document.getElementById(this.id).parentNode;
            var divId = parentDiv.querySelector("input[type=hidden]").id;
            var action;
            if (this.checked) {
                action = "on";
            } else {
                action = "off";
            }
            $.ajax({
                method: "GET",
                url: " <?php echo e(route('backside.super_admin.superadmin.update_action')); ?>",
                cache: false,
                dataType: "json",
                data: {
                    id: divId,
                    action: action,
                },
                error: function(err) {
                    // console.log(err);
                },
                success: function(response) {
                    document.getElementById('toggleText' + divId).innerHTML = response.action;
                    // console.log(response);
                },
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.super_admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH P:\xampp\htdocs\shweshops\resources\views/backend/super_admin/sitesetting/all.blade.php ENDPATH**/ ?>