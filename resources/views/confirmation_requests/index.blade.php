@extends('layouts.dashboard')
@section('css')
    <link rel="stylesheet" href="/dashboard/dist/assets/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="/dashboard/dist/assets/vendors/sweetalert2/dist/sweetalert2.css" />
@endsection
@section('custom_content')
    <!-- Start:: content (Your custom content)-->
    <div class="container mt-lg">
        @include('layouts.message')
        @include('layouts.validation_error')
        <div class="row">
            <div class="col-lg-12 mb-md">
                <div class="card-header d-flex jusitify-space-between">
                    <h2 class="p-1 m-0 text-16 font-weight-semi">Confirmation Requests</h2>
                    <div class="flex-grow-1"></div>
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
                                            <td>{{ getPeriodDayAndMonth($request->opening_period) . ' ' . getYearsRangeInStringFormat(getYearsInRange($request->opening_period, $request->closing_period)) }}
                                            </td>
                                            <td>{{ $request->auditor->name() }}</td>
                                            <td>
                                                @switch($request->authorization_status)
                                                    @case($request->authorization_status == 'APPROVED')
                                                        <span class="badge badge-success">APPROVED</span>
                                                    @break
                                                    @case($request->authorization_status == 'CANCELLED')
                                                        <span class="badge badge-danger">CANCELLED</span>
                                                    @break
                                                    @case($request->authorization_status == 'DECLINED')
                                                        <span class="badge badge-danger">DECLINED</span>
                                                    @break
                                                    @default
                                                        <span class="badge badge-warning">PENDING</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                @switch($request->confirmation_status)
                                                    @case($request->confirmation_status == 'APPROVED')
                                                        <span class="badge badge-success">APPROVED</span>
                                                    @break
                                                    @case($request->confirmation_status == 'CANCELLED')
                                                        <span class="badge badge-danger">CANCELLED</span>
                                                    @break
                                                    @case($request->confirmation_status == 'DECLINED')
                                                        <span class="badge badge-danger">DECLINED</span>
                                                    @break
                                                    @default
                                                        <span class="badge badge-warning">PENDING</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <a class="text-primary"
                                                    href="{{ route('confirmation-requests.show', encrypt_helper($request->id)) }}"
                                                    title="View request"><span class="material-icons">visibility</span></a>
                                                &nbsp;
                                                @if($request->confirmation_status == 'PENDING')
                                                    <a href="#" title="Approval Request" class="approval-request"
                                                        data-id="{{ $request->id }}" data-name="{{ $request->name }}"><span
                                                            class="material-icons">thumb_up_alt</span></a>
                                                    &nbsp;
                                                    <a class="delete-item text-danger decline-request" href="#"
                                                        data-id="{{ $request->id }}" data-name="{{ $request->name }}"
                                                        title="Decline request"><span
                                                            class="material-icons">thumb_down_alt</span></a>
                                                @endif
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

    {{-- File Upload Modal --}}
    <div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="approvalModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="approvalModal"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <div class="col-md-10 offset-md-1 mb-sm mt-lg">
                            <form method="POST" id="statement-form" action="{{ route('approve.request') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <!-- Form fields -->
                                <div class="form-group">
                                    <label for="statement">Upload Statement</label>
                                    <input type="file" class="form-control @error('statement') is-invalid @enderror"
                                        name="statement" required>
                                    <div class="mt-xs"></div>
                                    <textarea class="form-control" placeholder="Any Additional Information" cols="10"
                                    rows="5" style="border: solid thin #EEE; border-radius: 5px;" name="comment" ></textarea>
                                    <input type="hidden" class="form-control" name="confirmation_request" required />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" form="statement-form" class="btn btn-primary">Approve</button>
                </div>
            </div>
        </div>
    </div>

    {{-- File Upload Modal --}}
    <div class="modal fade" id="declineModal" tabindex="-1" role="dialog" aria-labelledby="declineModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="declineModal"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <div class="col-md-10 offset-md-1 mb-sm mt-lg">
                            <form method="POST" id="decline-form" action="{{route('decline.request')}}">
                                @csrf
                                <!-- Form fields -->
                                <div class="form-group">
                                    <textarea class="form-control @error('comment') is-invalid @enderror" placeholder="State your reason" cols="10"
                                        rows="5" style="border: solid thin #EEE; border-radius: 5px;" name="comment" required></textarea>
                                    <input type="hidden" class="form-control" name="confirmation_request" required />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" form="decline-form" class="btn btn-primary">Decline</button>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('script')
    <script src="/dashboard/dist/assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/dashboard/dist/assets/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/dashboard/dist/assets/js/pages/datatables/scrollDatatable.min.js"></script>
    <script src="/dashboard/dist/assets/vendors/sweetalert2/dist/sweetalert2.js"></script>
    <script src="/dashboard/dist/assets/js/custom.js"></script>
    <script>
        $('document').ready(function() {
            $('body').on('click', '.table .approval-request', function(e) {
                e.preventDefault();
                let request_id = $(this).data('id');
                let company_name = $(this).data('name');
                $('#approvalModal .modal-title').text('Approve ' + company_name + ' Confirmation Request');
                $('#approvalModal input[name=confirmation_request]').val(request_id);
                $('#approvalModal').modal('show');
            });

            $('body').on('click', '.table .decline-request', function(e) {
                e.preventDefault();
                let request_id = $(this).data('id');
                let company_name = $(this).data('name');
                $('#declineModal .modal-title').text('State Reason Declining');
                $('#declineModal input[name=confirmation_request]').val(request_id);
                $('#declineModal').modal('show');
            })

            // $('#myModal').on('hidden.bs.modal', function() {
            //     $(this).find('form')[0].reset();
            //     $(this).find('.alert').remove();
            //     // Add any additional reset actions you need
            // });
        });
    </script>
@endsection
