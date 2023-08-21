<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="/dashboard/dist/assets/vendors/sweetalert2/dist/sweetalert2.css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom_content'); ?>
    <!-- Start:: content (Your custom content)-->
    <div class="container pt-lg">
        <?php echo $__env->make('layouts.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <?php $__currentLoopData = $auditors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $auditor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xl-4 col-lg-4 mb-md">
                            <div class="card <?php echo e($auditor->is_blocked ? 'bg-warning' : ''); ?>">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-md">
                                        <div class="initials top admin">
                                            <h3><?php echo e(strtoupper($auditor->initials())); ?>

                                            </h3>
                                        </div>
                                        <div class="d-flex flex-wrap justify-content-end">
                                            <h6 class="m-0"><?php echo $auditor->is_verified && $auditor->is_verified == 1
                                                ? "<span class='text-success'>Verified</span>"
                                                : "<span class='text-danger'>Unverified</span>"; ?>

                                            </h6>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-light rounded-circle btn-sm btn-icon" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="material-icons">more_horiz</i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#"><i
                                                        class="material-icons icon icon-sm">email</i>Send Email</a>
                                                <a class="dropdown-item"
                                                    href="<?php echo e(url('#' . encrypt($auditor->id) . '/create')); ?>"><i
                                                        class="material-icons icon icon-sm">add_box</i>Create
                                                    Transaction</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="material-icons icon icon-sm">person_add</i>Add Account</a>
                                                <a class="dropdown-item" href="#"><i
                                                        class="material-icons icon icon-sm">visibility</i>View Accounts</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <p class="card-title mb-2">
                                            <a class="link-alt font-weight-semi"
                                                href="#"><?php echo e($auditor->profile->first_name); ?>

                                                <?php echo e($auditor->profile->last_name); ?></a>
                                        </p>
                                        <div class="mb-md">
                                            <div class="">
                                                <strong><?php echo e($auditor->email); ?></strong>
                                            </div>
                                        </div>

                                        <div class="mb-md">
                                            <div class="">
                                                <strong><?php echo e($auditor->profile->phone); ?></strong>
                                            </div>
                                        </div>

                                        <div class="mb-md">
                                            <div class="">
                                                <strong><?php echo e($auditor->confirmation_request_count); ?> Request Confirmations</strong>
                                            </div>
                                        </div>

                                        <div class="card-footer d-flex align-items-center justify-content-between py-sm">
                                            <div class="d-flex flex-wrap justify-content-end">
                                                <?php if($auditor->is_verified == 1): ?>
                                                    <a class="btn btn-opacity btn-danger btn-sm my-sm mr-sm unverify-item"
                                                        href="#" data-id="<?php echo e(encrypt($auditor->id)); ?>" data-message="Yes, unverify auditor">Unverify
                                                    </a>
                                                <?php elseif($auditor->is_verified == 0): ?>
                                                    <a class="btn btn-opacity btn-primary btn-sm my-sm mr-sm verify-item"
                                                    href="#" data-id="<?php echo e(encrypt($auditor->id)); ?>" data-message="Yes, verify auditor">Verify
                                                    </a>
                                                <?php endif; ?>
                                            </div>

                                            <div class="d-flex flex-wrap justify-content-end">
                                                <?php if($auditor->is_blocked): ?>
                                                    <button type="button"
                                                        class="btn btn-opacity btn-success btn-sm my-sm mr-sm block-item"
                                                        data-id="<?php echo e(encrypt($auditor->id)); ?>" data-message="Yes, unblock auditor">UNBLOCK
                                                    </button>
                                                <?php elseif(!$auditor->is_blocked): ?>
                                                    <button type="button"
                                                        class="btn btn-opacity btn-danger btn-sm my-sm mr-sm block-item"
                                                        data-id="<?php echo e(encrypt($auditor->id)); ?>" data-message="Yes, block auditor">BLOCK
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="card-footer d-flex align-items-center justify-content-between py-sm">
                                            <p class="text-muted text-small m-0">
                                                <?php echo e(\Carbon\Carbon::parse($auditor->created_at)->addHour()->format('M d Y')); ?>

                                            </p>
                                            <div class="d-flex flex-wrap justify-content-end">
                                                <button type="button"
                                                    class="btn btn-opacity btn-danger btn-sm my-sm mr-sm delete-item"
                                                    data-id="<?php echo e(encrypt($auditor->id)); ?>">DELETE
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Start:: content (Your custom content)-->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="/dashboard/dist/assets/vendors/sweetalert2/dist/sweetalert2.js"></script>
    <script src="/dashboard/dist/assets/js/custom.js"></script>
    <script>
        $('document').ready(function() {

            $('.verify-item').on('click', function(e) {
                e.preventDefault();
                var itemId = $(this).attr('data-id');
                var message = $(this).attr('data-message');
                var url = '/auditors/' + itemId + '/verification'
                confirmAction(url, '.verify-item', message);
            });

            $('.unverify-item').on('click',  function(e) {
                e.preventDefault();
                var itemId = $(this).attr('data-id');
                var message = $(this).attr('data-message');
                var url = '/audiors/' + itemId + '/verification'
                confirmAction(url, '.unverify-item', message);
            });

            $('.delete-item').on('click',  function() {
                var itemId = $(this).attr('data-id');
                var url = '/auditors/' + itemId + '/delete'
                confirmAction(url, '.delete-item');
            });

            $('.block-item').on('click', function() {
                var itemId = $(this).attr('data-id');
                var message = $(this).attr('data-message');
                var url = '/auditors/' + itemId + '/block'
                confirmAction(url, '.block-item', message);
            });

            $('.block-item').on('click', function(e) {
                var itemId = $(this).attr('data-id');
                var message = $(this).attr('data-message');
                var url = '/auditors/' + itemId + '/block'
                confirmAction(url, '.unblock-item', message);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/chukwuemekainya/Sites/audit-confirmation/auditor/resources/views/auditors/index.blade.php ENDPATH**/ ?>