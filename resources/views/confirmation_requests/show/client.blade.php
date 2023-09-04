<!DOCTYPE html>
<html>

<head>
    <base href="" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="/dashboard/dist/assets/images/favicon2.png">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,400;0,500;0,600;0,700;1,400&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" />

    {{-- Remove in terms of times of style  conflict --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <link rel="stylesheet" href="/dashboard/dist/assets/css/vendors.bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.9.1/styles/github.min.css" />
    <link rel="stylesheet" href="/dashboard/dist/assets/css/main.bundle.min.css" />
    <link rel="stylesheet" href="/dashboard/dist/assets/css/custom.css" />
</head>

<body>
    <div class="container mt-lg">
        @include('layouts.message')
        <div class="row">
            <div class="col-lg-12 mb-md">
                <div class="card-header d-flex jusitify-space-between">
                    <h2 class="p-1 m-0 text-16 font-weight-semi">{{ $confirmation_request->name }} Confirmation
                        requests for
                        {{ $period }} </h2>
                    <div class="flex-grow-1"></div>
                    <div>
                        {{-- <a type="button" class="btn btn-opacity btn-primary btn-sm my-sm mr-sm"
                            href="{{ route('confirmation-requests.create') }}" title="Create Request">Create
                            Request</a> --}}
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="mt-l mb-lg"></div>
                        {{-- <div class="d-flex justify-content-center"> --}}
                        <!-- Display the PDF -->
                        <embed src="/store/confirmation_requests/{{ $confirmation_request->file }}"
                            type="application/pdf" width="100%" height="600px" />

                        <!-- Action Buttons -->
                        <div>
                            @if (!$signatory->status)
                                <a type="button" class="btn btn-opacity btn-primary btn-sm my-sm mr-sm"
                                    href="{{ route('request.sign', ['id' => encrypt_helper($confirmation_request->id), 'signatory' => encrypt_helper($signatory->id) ]) }}" title="Sign Now">Sign Now</a>

                                <form action="#" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-opacity btn-danger btn-sm my-sm mr-sm">Action
                                        2</button>
                                </form>
                            @endif
                        </div>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/dashboard/dist/assets/js/vendors.bundle.min.js"></script>
    <script src="/dashboard/dist/assets/js/main.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.9.1/highlight.min.js"></script>
    <script src="/dashboard/dist/assets/vendors/autonumeric/autonumeric.min.js"></script>
</body>

</html>
