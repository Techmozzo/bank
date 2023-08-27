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

        .address {}

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
            margin-block: 25px;
        }

        .signatory {
            display: flex;
            flex-flow: row wrap;
        }

        .signatory input {
            border: none;
            border-bottom: #ccc solid thin;
            width: 100%;
        }

        .signatory input:focus {
            border: none !important;
        }

        .signatory p {
            text-align: center;
        }


        .input-group {
            width: 40%;
        }

        .flex-grow-1 {
            flex-grow: 1;
        }
    </style>
</head>

<body>
    <div class="letter-container">

        <div class="content">

            <div class="address">
                {{$company->name}}, <br />
                {{$company->address->house_number}},<br />
                {{$company->address->city}},<br />
                {{$company->address->state}}, {{$company->address->country}}.<br />
                <p>{{ date('F j, Y') }}</p>
            </div>

            <div class="salutation">
                Dear Sir/Madam,
            </div>
            <div class="header">
                <h4>Bank Circularization from our Auditors </h4>
            </div>
            <div>
                Our auditors,{{$company->address->name}} are currently engaged in the examination
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
                <div class="input-group">
                    <input type="text" name="first_name">
                    <p>Name and Designation</p>
                </div>
                <div class="flex-grow-1"></div>
                <div class="input-group">
                    <input type="text" name="first_name">
                    <p>Authorized signature</p>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
