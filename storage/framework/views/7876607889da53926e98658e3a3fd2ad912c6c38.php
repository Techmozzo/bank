<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="/dashboard/dist/assets/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="/dashboard/dist/assets/vendors/sweetalert2/dist/sweetalert2.css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('custom_content'); ?>
    <!-- Start:: content (Your custom content)-->
    <div class="container mt-lg">
        <?php echo $__env->make('layouts.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row">
            <div class="col-lg-12 mb-md">
                <div class="card-header d-flex jusitify-space-between">
                    <h2 class="p-1 m-0 text-16 font-weight-semi">Confirmation Requests</h2>
                    <div class="flex-grow-1"></div>
                    <div>
                        <a type="button" class="btn btn-opacity btn-primary btn-sm my-sm mr-sm"
                            href="<?php echo e(route('confirmation-requests.create')); ?>" title="Create Request">Create Request</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="mt-l mb-lg"></div>
                        
                        <?php if($confirmation_requests->count() > 0): ?>
                            <table class="table nowrap" id="datatableScrollXY" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Opening Date</th>
                                        <th>Closing Date</th>
                                        <th>Initiator</th>
                                        <th>Authorization Status</th>
                                        <th>Confirmation Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $confirmation_requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($request->name); ?></td>
                                            <td><?php echo e($request->opening_date); ?></td>
                                            <td><?php echo e($request->closing->date); ?></td>
                                            <td><?php echo e($request->auditor->name()); ?></td>
                                            <td>
                                                <?php if($request->authorization_status == 0): ?>
                                                    <span class="badge badge-warning">Pending</span>
                                                <?php elseif($request->authorization_status == 1): ?>
                                                    <span class="badge badge-success">Authorized</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($request->confirmation_status == 0): ?>
                                                    <span class="badge badge-warning">Pending</span>
                                                <?php elseif($request->confirmation_status == 1): ?>
                                                    <span class="badge badge-success">Completed</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo e(url('/comfirmation-requests/'.encrypt($request->id).'/edit')); ?>"
                                                    title="Edit request"><span class="material-icons">edit_note</span></a>
                                                &nbsp;
                                                <?php if($request->is_verified): ?>
                                                    <a class="unverify-item text-warning" data-id="<?php echo e(encrypt($request->id)); ?>"
                                                        data-message="Yes, unverify it!" href="#"
                                                        title="Unverify request"><span
                                                            class="material-icons">unpublished</span></a>
                                                <?php else: ?>
                                                    <a class="verify-item text-success" data-id="<?php echo e(encrypt($request->id)); ?>"
                                                        data-message="Yes, verify it!" href="#"
                                                        title="Verify request"><span
                                                            class="material-icons">task_alt</span></a>
                                                <?php endif; ?>
                                                &nbsp;
                                                <a class="delete-item text-danger"
                                                    data-id="<?php echo e(encrypt($request->id)); ?>" href="#"
                                                    title="Delete request"><span class="material-icons">delete</span></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="text-danger"> There is no request.</div>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Start:: content (Your custom content)-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="/dashboard/dist/assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/dashboard/dist/assets/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/dashboard/dist/assets/js/pages/datatables/scrollDatatable.min.js"></script>
    <script src="/dashboard/dist/assets/vendors/sweetalert2/dist/sweetalert2.js"></script>
    <script src="/dashboard/dist/assets/js/custom.js"></script>
    <script>
        $('document').ready(function() {
            $('table').on('click', '.verify-item', function(e) {
                e.preventDefault();
                var itemId = $(this).attr('data-id');
                var message = $(this).attr('data-message');
                var url = '/comfirmation-requests/' + itemId + '/verification'
                confirmAction(url, '.verify-item', message);
            });

            $('table').on('click', '.unverify-item', function(e) {
                e.preventDefault();
                var itemId = $(this).attr('data-id');
                var message = $(this).attr('data-message');
                var url = '/comfirmation-requests/' + itemId + '/verification'
                confirmAction(url, '.unverify-item', message);
            });

            $('table').on('click', '.delete-item', function(e) {
                e.preventDefault();
                var itemId = $(this).attr('data-id');
                var url = '/comfirmation-requests/' + itemId + '/delete'
                confirmAction(url, '.delete-item');
            });
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/chukwuemekainya/Sites/audit-confirmation/auditor/resources/views/confirmation_requests/index.blade.php ENDPATH**/ ?>