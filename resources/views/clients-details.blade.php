<?php

use Illuminate\Support\Facades\Storage;

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Employees</title>

    <script src="{{asset('assets/js/axios.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <meta name="description" content="" />

    <style>
    body {
        background: rgb(204, 204, 204);
        width: 100%;
        margin: 0px;
    }

    page {
        background: white;
        display: block;
        margin: 0 auto;
        box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
    }

    page[size="A4"] {
        width: 21cm;
        height: auto;
        padding-bottom: 15px;
    }

    @media print {

        body,
        page {
            margin: 0;
            box-shadow: 0;
        }
    }

    .header {
        top: 25px;
        width: auto;
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
        margin: 13px;
        column-gap: 10%;
    }

    .footer {
        width: auto;
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin: 13px;
        bottom: 0;
    }

    .content {
        margin: 20px;
    }



    .header .desc {
        text-align: end;
    }

    .content h4 {
        font-size: 25px;
        border-top: 1px solid #eee;
        padding: 15px;
    }

    table {
        border: 1px solid #ccc;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        width: 100%;
        table-layout: fixed;
    }

    table caption {
        font-size: 1.5em;
        margin: .5em 0 .75em;
    }

    table tr {
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        padding: .35em;
    }

    table th,
    table td {
        padding: .625em;
        text-align: center;
    }

    table th {
        font-size: .85em;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    @media screen and (max-width: 600px) {
        .header .desc {
            text-align: start;
        }

        .document-row {
            overflow-y: hidden;
        }

        .header {
            display: grid;
            padding: 15px;
            text-align: left;
            margin: 0px;
        }

        page[size="A4"] {
            width: auto;
            height: 29.7cm;
        }

        table {
            border: 0;
        }

        table caption {
            font-size: 1.3em;
        }

        table thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

        table tr {
            border-bottom: 3px solid #ddd;
            display: block;
            margin-bottom: .625em;
        }

        table td {
            border-bottom: 1px solid #ddd;
            display: block;
            font-size: .8em;
            text-align: left;
        }

        table td::before {
            /*
            * aria-label has no advantage, it won't be read inside a table
            content: attr(aria-label);
            */
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
        }

        table td:last-child {
            border-bottom: 0;
        }
    }


    a {
        cursor: pointer;
    }

    .company-name {
        font-size: 20px;
    }

    .document-row {
        display: flex;
        flex-direction: row;
        column-gap: 8px;
    }

    .document-box {
        width: auto;
        padding: 20px;
    }



    /*Form CSS*/
    input[type=text],
    select,
    textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: vertical;
    }

    form label {
        padding: 12px 12px 4px 5px;
        display: inline-block;
    }

    button {
        background-color: #04AA6D;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 10px;
    }

    button:hover {
        background-color: #45a049;
    }

    .container {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
        margin-top: 25px;
    }

    .col-25 {
        float: left;
        width: 25%;
        margin-top: 6px;
    }

    .col-75 {
        float: left;
        width: 75%;
        margin-top: 6px;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    /* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
    @media screen and (max-width: 600px) {

        .col-25,
        .col-75,
        input[type=submit] {
            width: 100%;
            margin-top: 0;
        }
    }
    </style>
</head>

<body>
    <page size="A4">

        <div class="header">
            <div class="logo">
                <img src="{{ url('storage/app/'.$data['admin_data']['logo']) }}" alt="Company Logo"
                    style="height: 100px;width: 100px;">
            </div>
            <div class="company-name">
                <h4>{{ $data['admin_data']['name'] }}</h4>
            </div>
            <div class="desc">
                <p>{{ $data['admin_data']['address'] }}</p>
                <p><a href="{!! $data['admin_data']['website'] !!}"
                        target="_blank">{{ $data['admin_data']['website'] }}</a>
                </p>
                <p><a href="https://api.whatsapp.com/send?phone={{ str_replace(' ', '', $data['admin_data']['mobile']) }}"
                        title="Share on whatsapp">{{ $data['admin_data']['mobile'] }}</a>
                </p>
            </div>

        </div>
        <div class="content">

            <h4><b>Client Details</b></h4>
            <table class="table table-responsive table-sm table-bordered text-center">
                <thead>
                    <th>Company Name</th>
                    <th>Machine Name</th>
                    <th>Serial Number</th>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $data['client_data']['company_name'] }}</td>
                        <td>{{ $data['client_data']['machine_name'] }}</td>
                        <td>{{ $data['client_data']['serial_number'] }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="col-md-12">
                <br>
                <h4><b>Machine Details</b></h4>
                <p>{{ $data['client_data']['machine_details'] }}</p>
            </div>

            <h4><b>Documents</b></h4>
            <div class="document-row">
                @if(count($data['documents']) > 0)
                @foreach($data['documents'] as $singleDocument)

                <div class="document-box" style="border:1px solid #c3c3c3; padding:10px">
                    <a href="{{ url('downloadDoc/'.$singleDocument['user_id'].'/'.$singleDocument['id']) }}">
                        <i class="menu-icon tf-icons bx bx-file"></i>
                        <label for="">{{ $singleDocument['document_name'] }}</label>
                    </a>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        <div class="footer">
            <div class="container">
                <h4>Contact Form</h4>
                <form id="contactForm">
                    @csrf
                    <div class="row">
                        <div class="col-75">
                            <label for="fname">Full Name <span style="color:red">*</span></label>
                            <input type="text" id="name" name="name" placeholder="Your Fullnane">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-75">
                            <label for="fname">Email <span style="color:red">*</span> </label>
                            <input type="text" id="email" name="email" placeholder="Your Email ID">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-75">
                            <label for="fname">Mobile <span style="color:red">*</span> </label>
                            <input type="text" id="mobile_number" name="mobile_number" placeholder="Your Mobile Number">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-75">
                            <label for="fname">Company Number <span style="color:red">*</span> </label>
                            <input type="text" id="company_number" name="company_number"
                                placeholder="Your Company Number">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-75">
                            <label for="fname">Address <span style="color:red">*</span> </label>
                            <textarea type="text" id="address" name="address" placeholder="Your Address"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-75">
                            <label for="fname">Requirement <span style="color:red">*</span> </label>
                            <textarea type="text" id="requirements" name="requirements"
                                placeholder="Your Requirement"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <button type="submit" id="user_id">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </page>
</body>

@include('include.footer')
<script>
const url = "{{ url('') }}";
$('#contactForm').on('submit', function(e) {
    e.preventDefault();
    var formdata = new FormData(this);
    axios.post(`${url}/contactForm`, formdata).then(function(response) {
        // handle success
        show_Toaster(response.data.message, response.data.type)
        $('#contactForm')[0].reset()
    }).catch(function(err) {
        show_Toaster(err.response.data.message, 'error')
    })
});
</script>

</html>