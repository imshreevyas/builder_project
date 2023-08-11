<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Contact form</title>
    <meta name="description" content="Contact Form">
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
        style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;">
        <tr>
            <td>
                <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"
                    align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px;">
                                        <h1
                                            style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:'Rubik',sans-serif;">
                                            Below are the details from Contact Form</h1>
                                        <span
                                            style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                                        <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">

                                        <div class="row text-left">
                                            <div class="col-md-12">
                                            <table class="table table-bordered table-reponsive" style="border:1px solid #e3e3e3;border-collapse: collapse;padding:15px">
                                                <tbody>
                                                    <tr style="border:1px solid #e3e3e3">
                                                        <td style="border:1px solid #e3e3e3">Full Name</td>
                                                        <td style="border:1px solid #e3e3e3">{{ $name }}</td>
                                                    </tr>
                                                    <tr style="border:1px solid #e3e3e3">
                                                        <td style="border:1px solid #e3e3e3">Email</td>
                                                        <td style="border:1px solid #e3e3e3">{{ $email }}</td>
                                                    </tr>
                                                    <tr style="border:1px solid #e3e3e3">
                                                        <td style="border:1px solid #e3e3e3">Mobile Number</td>
                                                        <td style="border:1px solid #e3e3e3">{{ $mobile_number }}</td>
                                                    </tr>
                                                    <tr style="border:1px solid #e3e3e3">
                                                        <td style="border:1px solid #e3e3e3">Company Number</td>
                                                        <td style="border:1px solid #e3e3e3">{{ $company_number }}</td>
                                                    </tr>
                                                    <tr style="border:1px solid #e3e3e3">
                                                        <td style="border:1px solid #e3e3e3">Address</td>
                                                        <td style="border:1px solid #e3e3e3">{{ $address }}</td>
                                                    </tr>
                                                    <tr style="border:1px solid #e3e3e3">
                                                        <td style="border:1px solid #e3e3e3">Requirements</td>
                                                        <td style="border:1px solid #e3e3e3">{{ $requirements }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--/100% body table-->
</body>

</html>
