@foreach (array_slice(old('signatory_email', []), 1) as $key => $value)
    <div class="mt-xxl mb-lg d-flex jusitify-space-between"></div>
    <h2 class="p-1 m-0 text-16 font-weight-semi text-center">Additional Signatory</h2>
    <div class="form-group">
        <label class="control-label" for="signatory_name[]">Name</label>
        <input type="text" class="form-control" id="signatory_name[]" name="signatory_name[]"
            value="{{ old('signatory_name.' . $key) }}" required />
    </div>

    <div class="form-group">
        <label class="control-label" for="signatory_email[]">Email</label>
        <input type="email" class="form-control" id="signatory_email[]" name="signatory_email[]"
            value="{{ old('signatory_email.' . $key) }}" required />
    </div>

    <div class="form-group">
        <label class="control-label" for="signatory_phone[]">Phone</label>
        <input type="text" class="form-control" id="signatory_phone[]" name="signatory_phone[]"
            value="{{ old('signatory_phone.' . $key) }}" required />
    </div>
@endforeach
