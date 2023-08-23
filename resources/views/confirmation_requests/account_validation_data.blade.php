@foreach (array_slice(old('account_name', []), 1) as $key => $value)
    <div class="mt-xxl mb-lg d-flex jusitify-space-between"></div>
    <h2 class="p-1 m-0 text-16 font-weight-semi text-center">Additional Signatory</h2>
    <div class="form-group">
        <label class="control-label" for="account_name[]">Account Name</label>
        <input type="text" class="form-control" id="account_name[]" name="account_name[]"
            value="{{ old('account_name.' . $key) }}" required />
    </div>

    <div class="form-group">
        <label class="control-label" for="account_number[]">Account Number</label>
        <input type="email" class="form-control" id="account_number[]" name="account_number[]"
            value="{{ old('account_number.' . $key) }}" required />
    </div>
@endforeach
