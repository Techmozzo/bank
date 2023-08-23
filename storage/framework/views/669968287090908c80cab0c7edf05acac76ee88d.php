<?php $__currentLoopData = array_slice(old('signatory_email', []), 1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="mt-xxl mb-lg d-flex jusitify-space-between"></div>
    <h2 class="p-1 m-0 text-16 font-weight-semi text-center">New Signatory</h2>
    <div class="form-group">
        <label class="control-label" for="signatory_name[]">Name</label>
        <input type="text" class="form-control" id="signatory_name[]" name="signatory_name[]"
            value="<?php echo e(old('signatory_name.' . $key)); ?>" required />
    </div>

    <div class="form-group">
        <label class="control-label" for="signatory_email[]">Email</label>
        <input type="email" class="form-control" id="signatory_email[]" name="signatory_email[]"
            value="<?php echo e(old('signatory_email.' . $key)); ?>" required />
    </div>

    <div class="form-group">
        <label class="control-label" for="signatory_phone[]">Phone</label>
        <input type="text" class="form-control" id="signatory_phone[]" name="signatory_phone[]"
            value="<?php echo e(old('signatory_phone.' . $key)); ?>" required />
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /Users/chukwuemekainya/Sites/audit-confirmation/auditor/resources/views/confirmation_requests/validation_data.blade.php ENDPATH**/ ?>