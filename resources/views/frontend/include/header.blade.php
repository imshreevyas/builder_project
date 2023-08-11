<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('assets/favicon.png') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">
    <!-- animate CSS -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/animate.css') }}">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/owl.carousel.min.css') }}">
    <!-- themify CSS -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/themify-icons.css') }}">
    <!-- flaticon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/flaticon.css') }}">
    <!-- fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/fontawesome/css/all.min.css') }}">
    <!-- magnific CSS -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/gijgo.min.css') }}">
    <!-- niceselect CSS -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/nice-select.css') }}">
    <!-- slick CSS -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/slick.css') }}">
    <!-- style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">

    <script src="{{asset('assets/js/axios.min.js')}}"></script>
</head>

<style>
html {
    scroll-behavior: smooth;
}
</style>

<body>
    <!--::header part start::-->
    <header class="main_menu">
        <div class="sub_menu">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-6">
                        <div class="sub_menu_right_content">
                            <span>Top destinations</span>
                            <a href="azerbaijan">Azerbaijan</a>
                            <a href="georgia">Georgia</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6">
                        <div class="sub_menu_social_icon">
                            <span><i class="flaticon-phone-call"></i><a
                                    href="tel:{{ $contact_details['mobile'] }}">{{ $contact_details['mobile'] }}</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main_menu_iner">
            <div class="container">
                <div class="row align-items-center ">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg navbar-light justify-content-between">
                            <a class="navbar-brand" href="{{ url('/') }}"> <img
                                    src="{{ asset('assets/logo-main.png') }}" alt="logo" height="100"> </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse main-menu-item justify-content-center"
                                id="navbarSupportedContent">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('/azerbaijan') }}">Azerbaijan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('/georgia') }}">Georgia</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('/contact') }}">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header part end-->