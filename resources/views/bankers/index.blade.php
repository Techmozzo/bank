@extends('layouts.dashboard')
@section('css')
    <link rel="stylesheet" href="/dashboard/dist/assets/vendors/sweetalert2/dist/sweetalert2.css" />
@endsection
@section('custom_content')
    <!-- Start:: content (Your custom content)-->
    <div class="container pt-lg">
        @include('layouts.message')
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    @foreach ($bankers as $banker)
                        <div class="col-xl-4 col-lg-4 mb-md">
                            <div class="card {{ $banker->is_blocked ? 'bg-warning' : '' }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-md">
                                        <div class="initials top admin">
                                            <h3>{{ strtoupper($banker->initials()) }}
                                            </h3>
                                        </div>
                                        <div class="d-flex flex-wrap justify-content-end">
                                            <h6 class="m-0">{!! $banker->is_verified && $banker->is_verified == 1
                                                ? "<span class='text-success'>Verified</span>"
                                                : "<span class='text-danger'>Unverified</span>" !!}
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
                                                    href="{{ url('#' . encrypt_helper($banker->id) . '/create') }}"><i
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
                                                href="#">{{ $banker->profile->first_name }}
                                                {{ $banker->profile->last_name }}</a>
                                        </p>
                                        <div class="mb-md">
                                            <div class="">
                                                <strong>{{ $banker->email }}</strong>
                                            </div>
                                        </div>

                                        <div class="mb-md">
                                            <div class="">
                                                <strong>{{ $banker->profile->phone }}</strong>
                                            </div>
                                        </div>

                                        <div class="mb-md">
                                            <div class="">
                                                <strong>{{ $banker->confirmation_request_count }} Request
                                                    Confirmations</strong>
                                            </div>
                                        </div>

                                        <div class="card-footer d-flex align-items-center justify-content-between py-sm">
                                            <div class="d-flex flex-wrap justify-content-end">
                                                @if ($banker->is_verified == 1)
                                                    <a class="btn btn-opacity btn-danger btn-sm my-sm mr-sm unverify-item"
                                                        href="#" data-id="{{ encrypt_helper($banker->id) }}"
                                                        data-message="Yes, unverify banker">Unverify
                                                    </a>
                                                @elseif($banker->is_verified == 0)
                                                    <a class="btn btn-opacity btn-primary btn-sm my-sm mr-sm verify-item"
                                                        href="#" data-id="{{ encrypt_helper($banker->id) }}"
                                                        data-message="Yes, verify banker">Verify
                                                    </a>
                                                @endif
                                            </div>

                                            <div class="d-flex flex-wrap justify-content-end">
                                                @if ($banker->is_blocked)
                                                    <button type="button"
                                                        class="btn btn-opacity btn-success btn-sm my-sm mr-sm block-item"
                                                        data-id="{{ encrypt_helper($banker->id) }}"
                                                        data-message="Yes, unblock banker">UNBLOCK
                                                    </button>
                                                @elseif (!$banker->is_blocked)
                                                    <button type="button"
                                                        class="btn btn-opacity btn-danger btn-sm my-sm mr-sm block-item"
                                                        data-id="{{ encrypt_helper($banker->id) }}"
                                                        data-message="Yes, block banker">BLOCK
                                                    </button>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="card-footer d-flex align-items-center justify-content-between py-sm">
                                            <p class="text-muted text-small m-0">
                                                {{ \Carbon\Carbon::parse($banker->created_at)->addHour()->format('M d Y') }}
                                            </p>
                                            <div class="d-flex flex-wrap justify-content-end">
                                                <button type="button"
                                                    class="btn btn-opacity btn-danger btn-sm my-sm mr-sm delete-item"
                                                    data-id="{{ encrypt_helper($banker->id) }}">DELETE
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Start:: content (Your custom content)-->
@endsection

@section('script')
    <script src="/dashboard/dist/assets/vendors/sweetalert2/dist/sweetalert2.js"></script>
    <script src="/dashboard/dist/assets/js/custom.js"></script>
    <script>
        $('document').ready(function() {

            $('.verify-item').on('click', function(e) {
                e.preventDefault();
                var itemId = $(this).attr('data-id');
                var message = $(this).attr('data-message');
                var url = '/bankers/' + itemId + '/verification'
                confirmAction(url, '.verify-item', message);
            });

            $('.unverify-item').on('click', function(e) {
                e.preventDefault();
                var itemId = $(this).attr('data-id');
                var message = $(this).attr('data-message');
                var url = '/audiors/' + itemId + '/verification'
                confirmAction(url, '.unverify-item', message);
            });

            $('.delete-item').on('click', function() {
                var itemId = $(this).attr('data-id');
                var url = '/bankers/' + itemId + '/delete'
                confirmAction(url, '.delete-item');
            });

            $('.block-item').on('click', function() {
                var itemId = $(this).attr('data-id');
                var message = $(this).attr('data-message');
                var url = '/bankers/' + itemId + '/block'
                confirmAction(url, '.block-item', message);
            });

            $('.block-item').on('click', function(e) {
                var itemId = $(this).attr('data-id');
                var message = $(this).attr('data-message');
                var url = '/bankers/' + itemId + '/block'
                confirmAction(url, '.unblock-item', message);
            });
        });
    </script>
@endsection
