<!DOCTYPE html>
<html>

<head>
    <title>Confirmation Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.5em;
        }

        table {
            width: 100%;
        }

        table td{
            padding: 20px;
        }

        td p {
            text-align: center;
        }

        .salutation {
            margin: 50px 0;
        }

        .letter-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .content {
            margin-bottom: 20px;
        }

        body div {
            margin-bottom: 25px !important;
        }
        .signatory input {
            border: none;
            border-bottom: #ccc solid thin;
            width: 100%;
        }

        .signatory input:focus {
            border: none !important;
        }
    </style>
</head>

<body>
    <div class="letter-container">

        <div class="content">

            <div class="address">
                {{ $company->name }}, <br />
                {{ $company->address }},<br />
                {{ $company->city }},<br />
                {{ $company->state }}, {{ $company->country }}.<br />
                <p>{{ date('F j, Y') }}</p>
            </div>

            <div class="salutation">
                Dear Sir/Madam,
            </div>
            <div class="header">
                <h4>Bank Circularization from our Auditors </h4>
            </div>
            <div>
                Our auditors, {{ $company->name }} are currently engaged in the examination
                of our financial statements for the period ended {{ $period }}. In connection
                therewith, they would be sending to you a letter requesting for our banking information with you. Kindly
                furnish them with the information they require relating to the period they are auditing.
            </div>

            <div>
                Thank you for your continuous cooperation.
            </div>

            <div>
                Signed by the authorized signatories:
            </div>

            <div class="signatory">
                <table class="table table-bordered mb-5" >
                    <tbody>
                        @foreach ($signatories as $signatory)
                            <tr>
                                <td>
                                    <div class="input-group">
                                        <input type="text" name="name[]" value="{{ $signatory->name }}">
                                    </div>
                                    <p>Name and Designation</p>
                                </td>
                                <td >
                                    <div class="input-group" style="padding-top: 20px;">
                                        <input type="text" name="signature[]">
                                    </div>
                                    <p>Authorized signature</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
