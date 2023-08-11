<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard</title>

    <meta name="description" content="" />
    <script src="https://code.jquery.com/jquery-3.6.3.js"
        integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js">
    </script>
    <!-- Favicon -->

    <style>
    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
    </style>

    @include('include.header')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            @include('admin.sidebar2')
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
                        <div class="row">

                            <!--2nd row-->
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-3 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <span class="d-block mb-1 avatar-initial rounded text-primary"><i
                                                        class="menu-icon tf-icons bx bx-user"></i>Total Clients</span>
                                                <h3 class="card-title text-nowrap mb-2">{{ $usercount ?: 0 }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <span class="d-block mb-1 avatar-initial rounded text-primary"><i
                                                        class="menu-icon tf-icons bx bx-user"></i>Total Projects</span>
                                                <h3 class="card-title text-nowrap mb-2">{{ $packagecount ?: 0 }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!--/ 2nd row -->
                        </div>


                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div style="display: flex;">
                                        <h5 class="card-header">Latest 10 Users</h5>
                                    </div>
                                    <div class="table table-responsive">
                                        <table id="table_id" class="display">
                                            <thead>
                                                <tr>
                                                    <th>Sr No.</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Project</th>
                                                    <th>EMI</th>
                                                    <th>EMI Yrs</th>
                                                    <th>EMI Date (of every month)</th>
                                                    <th>Total EMI paid (Yrs Months)</th>
                                                    <th>Last EMI Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                                <tr>
                                                    <td>1</td>
                                                    <td>Shree Vyas </td>
                                                    <td>shreevyas65@gmail.com</td>
                                                    <td>7066498174</td>
                                                    <td>Ostwal Project</td>
                                                    <td>19555</td>
                                                    <td>30</td>
                                                    <td>2nd</td>
                                                    <td>2yrs 11Months</td>
                                                    <td>02-07-2023</td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked>
                                                            <span class="slider"></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Rohit Vyas </td>
                                                    <td>rohityas65@gmail.com</td>
                                                    <td>7066497574</td>
                                                    <td>Ostwal Project</td>
                                                    <td>25555</td>
                                                    <td>30</td>
                                                    <td>2nd</td>
                                                    <td>5 yrs 6 Months</td>
                                                    <td>02-07-2023</td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" checked>
                                                            <span class="slider"></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div style="display: flex;">
                                        <h5 class="card-header">Approve Payments</h5>
                                    </div>
                                    <div class="table table-responsive">
                                        <table id="table_id1" class="display">
                                            <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Amount</th>
                                                    <th>EMI Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                                @php($i = 1)
                                                @foreach ($ticket as $singleticket)
                                                <tr>
                                                    <td>{{ $singleticket['id'] }}</td>
                                                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                                        {{ $singleticket['user']['name'] }} </td>
                                                    <td>19555</td>
                                                    <td>
                                                        <a type="button" class="btn btn-success text-white"
                                                            onclick="getDocument('{{$singleticket['id']}}')"
                                                            title="Client Documents">Approve</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src={{asset("assets/vendor/libs/popper/popper.js")}}></script>
    <script src={{asset("assets/vendor/js/bootstrap.js")}}></script>
    <script src={{asset("assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js")}}></script>
    <script src={{asset("assets/vendor/js/menu.js")}}></script>
    <!-- endbuild -->
    <!-- Vendors JS -->
    <script src={{asset("assets/vendor/libs/apex-charts/apexcharts.js")}}></script>
    <!-- Main JS -->
    <script src={{asset("assets/js/main.js")}}></script>
    <!-- Page JS -->
    <script src={{asset("assets/js/dashboards-analytics.js")}}></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
    $(document).ready(function() {
        $('#table_id').DataTable();
        $('#table_id1').DataTable();
    });

    function updateUserStatus(e) {
        value = $(e).attr('data-value');
        id = $(e).attr('id');
        if (confirm('Are you sure, you want to ' + (value == 1 ? 'Activate' : 'Deactivate'))) {
            key = $(e).attr('data-key');

            axios.post(`${url}/admin/updateUserStatus`, {
                key,
                value,
            }).then(function(response) {
                // handle success
                show_Toaster(response.data.message, response.data.type)
                if (response.data.type === 'success') {

                    $(e).attr('data-value', (value == 1 ? 0 : 1));
                    document.getElementById(id).checked = value == 1 ? true : false;
                    // setTimeout(() => {
                    //     window.location.href = `${url}/admin/allUsers`;
                    // }, 500);
                }
            }).catch(function(err) {
                show_Toaster(err.response.data.message, 'error')
            })

        } else {
            document.getElementById(id).checked = value == 1 ? false : true;
            return false;
        }
    }
    </script>
</body>

</html>