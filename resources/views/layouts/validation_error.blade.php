@if ($errors->any())
    <div class="alert alert-danger" style="padding: 5px;">
        <button type="button" class="close" data-dismiss="alert">×</button>
        @foreach ($errors->all() as $error)
            <p style="margin-bottom:0; padding-left:10px;">{{ $error }}</p>
        @endforeach
    </div>
@endif
