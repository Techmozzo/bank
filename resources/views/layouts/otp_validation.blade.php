@extends('layouts.auth')
@section('css')
    <link rel="stylesheet" href="/dashboard/dist/assets/css/pages/session/session.v1.min.css">
@endsection
@section('custom_content')
    <div class="page-wrap slate">
        <div class="session-form-hold">
            <div class="card text-center">
                <div class="card-body">
                    @include('layouts.message')
                    <form method="POST" action={{$action}}>
                        @csrf
                        <i class="material-icons">lock</i>
                        <p class="text-muted mb-xxl">Token Validation</p>
                        <div class="input-group  input-light mb-md">
                            <input id="otp" type="text" class="form-control @error('otp') is-invalid @enderror"
                                name="otp" value="{{ old('otp') }}" required autocomplete="email" autofocus
                                placeholder="Enter Your 6 Digit OTP">
                            @error('otp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-raised btn-raised-primary btn-block mb-md">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
