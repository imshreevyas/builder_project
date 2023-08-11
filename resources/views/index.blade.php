<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard</title>

    <meta name="description" content="" />

    <!-- Favicon -->

    @include('include.header')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            @include('include.sidebar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                @include('include.nav')

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->


                    <div class="container-xxl flex-grow-1 container-p-y">


                        <div class="card">

                            <div class="card-header">
                                <h2>Basic Details</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!--2nd row-->
                                    <div class="col-3 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <span class="d-block mb-1 avatar-initial rounded text-primary"><i
                                                        class="menu-icon tf-icons bx bx-user"></i>Total Clients</span>
                                                <h3 class="card-title text-nowrap mb-2">
                                                    {{ $details[0]->client_created }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <span class="d-block mb-1 avatar-initial rounded text-primary"><i
                                                        class="menu-icon tf-icons bx bx-user"></i>Total Storage Used
                                                    (Mb)</span>
                                                <h3 class="card-title text-nowrap mb-2">{{ $details[0]->storage_used }}
                                                    Mb
                                                </h3>
                                            </div>
                                        </div>
                                    </div>

                                    <!--/ 2nd row -->
                                </div>
                            </div>

                        </div>

                        <br>
                        <div class="card">

                            <div class="card-header">
                                <h2>Plan Details</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!--2nd row-->
                                    <div class="col-3 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <span class="d-block mb-1 avatar-initial rounded text-primary"><i
                                                        class="menu-icon tf-icons bx bx-user"></i>Package Name</span>
                                                <h3 class="card-title text-nowrap mb-2">
                                                    {{ $details[0]->package->package_name }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <span class="d-block mb-1 avatar-initial rounded text-primary"><i
                                                        class="menu-icon tf-icons bx bx-user"></i>Clients Limit</span>
                                                <h3 class="card-title text-nowrap mb-2">{{ $details[0]->client_limit }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <span class="d-block mb-1 avatar-initial rounded text-primary"><i
                                                        class="menu-icon tf-icons bx bx-user"></i>Total Storage
                                                    Limit</span>
                                                <h3 class="card-title text-nowrap mb-2">{{ $details[0]->storage_limit }}
                                                    Mb
                                                </h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-3 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <span class="d-block mb-1 avatar-initial rounded text-primary"><i
                                                        class="menu-icon tf-icons bx bx-user"></i>Expiry Date</span>
                                                <h3 class="card-title text-nowrap mb-2">
                                                    {{ date('d M, Y', strtotime($details[0]->expiry_date)) }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>


                                    <!--/ 2nd row -->
                                </div>
                            </div>

                        </div>


                    </div>
                    <!-- / Content -->



                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    @include('include.footer')
    <script>
    function show_Toaster(message, type) {
        var success = "#00b09b, #96c93d";
        var error = "#a7202d, #ff4044";
        var ColorCode = type == "success" ? success : error;
        return Toastify({
            text: message,
            duration: -1,
            close: true,
            gravity: "bottom", // top or bottom
            position: "center", // left, center or right
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: `linear-gradient(to right, ${ColorCode})`,
            },
        }).showToast();
    }
    </script>

    @if(isset($expiry_notice) && !empty($expiry_notice))
    <script>
    show_Toaster('{{ $expiry_notice }}', 'error')
    </script>
    @endif
</body>

</html>