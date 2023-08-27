@extends('layouts.dashboard')
@section('css')
    <link rel="stylesheet" href="/dashboard/dist/assets/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="/dashboard/dist/assets/vendors/sweetalert2/dist/sweetalert2.css" />
@endsection
@section('custom_content')
    <!-- Start:: content (Your custom content)-->
    <div class="container mt-lg">
        @include('layouts.message')
        <div class="row">
            <div class="col-lg-12 mb-md">
                <div class="card-header d-flex jusitify-space-between">
                    <h2 class="p-1 m-0 text-16 font-weight-semi">Confirmation Requests</h2>
                    <div class="flex-grow-1"></div>
                    <div>
                        <a type="button" class="btn btn-opacity btn-primary btn-sm my-sm mr-sm"
                            href="{{route('confirmation-requests.create')}}" title="Create Request">Create Request</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="mt-l mb-lg"></div>
                        {{-- <div class="d-flex justify-content-center"> --}}
                        @if ($confirmation_requests->count() > 0)
                            <table class="table nowrap" id="datatableScrollXY" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Period</th>
                                        <th>Initiator</th>
                                        <th>Authorization</th>
                                        <th>Confirmation</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($confirmation_requests as $request)
                                        <tr>
                                            <td>{{ $request->name }}</td>
                                            <td>{{ getPeriodDayAndMonth($request->opening_period) .' '. getYearsRangeInStringFormat(getYearsInRange($request->opening_period, $request->closing_period))}}</td>
                                            <td>{{ $request->auditor->name() }}</td>
                                            <td>
                                                @if ($request->authorization_status == 0)
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif ($request->authorization_status == 1)
                                                    <span class="badge badge-success">Authorized</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($request->confirmation_status == 0)
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif ($request->confirmation_status == 1)
                                                    <span class="badge badge-success">Completed</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ url('/comfirmation-requests/'.encrypt($request->id).'/edit') }}"
                                                    title="Edit request"><span class="material-icons">edit_note</span></a>
                                                &nbsp;
                                                @if ($request->is_verified)
                                                    <a class="unverify-item text-warning" data-id="{{ encrypt($request->id) }}"
                                                        data-message="Yes, unverify it!" href="#"
                                                        title="Unverify request"><span
                                                            class="material-icons">unpublished</span></a>
                                                @else
                                                    <a class="verify-item text-success" data-id="{{ encrypt($request->id) }}"
                                                        data-message="Yes, verify it!" href="#"
                                                        title="Verify request"><span
                                                            class="material-icons">task_alt</span></a>
                                                @endif
                                                &nbsp;
                                                <a class="delete-item text-danger"
                                                    data-id="{{ encrypt($request->id) }}" href="#"
                                                    title="Delete request"><span class="material-icons">delete</span></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-danger"> There is no request.</div>
                        @endif
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Start:: content (Your custom content)-->
@endsection
@section('script')
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
@endsection
