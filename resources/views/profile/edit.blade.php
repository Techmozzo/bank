@extends('layouts.dashboard')
@section('custom_content')
    <!-- Start:: content (Your custom content)-->
    <div class="subheader px-lg">
        <div class="subheader-container">
            <div class="subheader-main">
                <nav class="ul-breadcrumb" aria-label="breadcrumb">
                    <ol class="ul-breadcrumb-items">
                        <li class="breadcrumb-home"><a href="{{ route('home') }}"> <i class="material-icons">home</i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
            <div class="flex-grow-1"></div>
        </div>
    </div>

    <div class="ul-invoice-header-v1-items d-flex justify-content-between flex-column">
        <div class="ul-invoice-v1-header-left d-flex justify-content-end flex-wrap">
            <div>
                <label>Referral Code : </label>
                <input id="referral-code" class="text-gray-500" size="25" readonly
                    value="{{ $user->referral->code }}" style="border:none;" />
            </div>
            <div style="margin-left: -30px;">
                <button type="button" class="btn btn-primary btn-sm" id="copy-referral-code" title="Copy">
                    <i class="fa fa-copy"></i>Copy
                </button>
            </div>
        </div>
    </div>

    <div class="container my-lg d-flex flex-column">
        <div class="doc-section-title d-flex justify-content-center">
            <h2 class="doc-section-title">User Information</h2>
        </div>
        @include('layouts.message')
        <div class="doc-example d-flex justify-content-center">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12 d-lg-block d-none">
                    <div class="sidebar sticky-bar p-4 rounded shadow">
                        <div class="widget">
                            <h5 class="widget-title">Transactions :</h5>
                            <div class="row mt-4">
                                <div class="col-6 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-user-plus fea icon-ex-md text-primary mb-1">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="8.5" cy="7" r="4"></circle>
                                        <line x1="20" y1="8" x2="20" y2="14"></line>
                                        <line x1="23" y1="11" x2="17" y2="11"></line>
                                    </svg>
                                    <h5 class="mb-0">{{ $transactionCount }}</h5>
                                    <p class="text-muted mb-0">Transactions</p>
                                </div>
                                <div class="col-6 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-users fea icon-ex-md text-primary mb-1">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                    <h5 class="mb-0">$ {{ number_format($user->finance->current_balance, 2) }}</h5>
                                    <p class="text-muted mb-0">Current Bal.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-12">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <div class="position-relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-user fea icon-sm icons">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <input name="first_name" id="first" type="text"
                                            class="form-control pl-5 @error('first_name') is-invalid @enderror"
                                            value="{{ $user->first_name }}" placeholder="First Name :" required>
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <div class="position-relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-user-check fea icon-sm icons">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="8.5" cy="7" r="4"></circle>
                                            <polyline points="17 11 19 13 23 9"></polyline>
                                        </svg>
                                        <input name="last_name" id="last" type="text"
                                            class="form-control pl-5 @error('last_name') is-invalid @enderror"
                                            value="{{ $user->last_name }}" placeholder="Last Name :" required>
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Your Email</label>
                                    <div class="position-relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-mail fea icon-sm icons">
                                            <path
                                                d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                            </path>
                                            <polyline points="22,6 12,13 2,6"></polyline>
                                        </svg>
                                        <input name="email" readonly id="email" type="email"
                                            class="form-control pl-5" value="{{ $user->email }}"
                                            placeholder="Your email :" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone No</label>
                                    <div class="position-relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-phone fea icon-sm icons">
                                            <path
                                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                            </path>
                                        </svg>
                                        <input name="phone" id="number" type="number" class="form-control pl-5"
                                            value="{{ $user->phone }}" placeholder="Phone :">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Country</label>
                                    <div class="position-relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-bookmark fea icon-sm icons">
                                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                        </svg>
                                        <input name="country" type="text" class="form-control pl-5"
                                            value="{{ $user->address !== null ? $user->address->country : '' }}"
                                            placeholder="Country :">
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-md-12">
                                <div class="form-group">
                                    <label>Referral Code</label>
                                    <div class="position-relative">
                                        <div class="ul-invoice-header-v1-items d-flex justify-content-between flex-column">
                                            <div class="ul-invoice-v1-header-left d-flex justify-content-between flex-wrap">
                                                <div>
                                                    <input id="referral-code" class="text-gray-500 form-control" size="25" readonly
                                                        value="{{ $user->referral->code }}"  />
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-primary btn-sm" id="copy-referral-code">
                                                        <i class="fa fa-copy"></i> Copy Referral Code
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-raised btn-raised-primary">Save Change</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Start:: content (Your custom content)-->
@endsection

@section('script')
    <!--SCRIPT TO COPY REFERRER CODE-->
    <script>
        $(document).ready(function() {
            $('#copy-referral-code').on('click', function() {
                var copyText = document.getElementById('referral-code');
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand('copy');
                alert("Copied : " + copyText.value);
            })
        })
    </script>
@endsection
