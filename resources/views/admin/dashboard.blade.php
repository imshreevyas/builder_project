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

            @include('admin.sidebar')
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
                                                        class="menu-icon tf-icons bx bx-user"></i>Total Property</span>
                                                <h3 class="card-title text-nowrap mb-2">{{ $packagecount ?: 0 }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <span class="d-block mb-1 avatar-initial rounded text-primary"><i
                                                        class="menu-icon tf-icons bx bx-user"></i>Total EMI
                                                    Received</span>
                                                <h3 class="card-title text-nowrap mb-2">{{ $paymentcount ?: 0 }}</h3>
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
                                        <h5 class="card-header">This Month Comin EMI</h5>
                                    </div>
                                    <div class="table table-responsive">
                                        <table id="table_id" class="display">
                                            <thead>
                                                <tr>
                                                    <th>Sr No.</th>
                                                    <th>User Name</th>
                                                    <th>Property Name</th>
                                                    <th>Emi Amount</th>
                                                    <th>Due Date</th>
                                                    <th>Status</th>
                                                    <th>action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0">
                                                @php($i = 1)
                                                @foreach ($payments as $singledata)
                                                <tr>
                                                    <td>{{ $i++; }}</td>
                                                    <td>{{ $singledata['user']['name'] }} </td>
                                                    <td>{{ $singledata['property']['property_name'] }}</td>
                                                    <td>{{ $singledata['emi_amount'] }}</td>
                                                    <td>{{ date('d M, Y', strtotime($singledata['due_date'])) }}</td>
                                                    <td>@if($singledata['status'] == 0)
                                                        <span class="badge bg-warning">Pending</span>
                                                        @else
                                                        <span class="badge bg-success">Paid</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($singledata['status'] == 0)
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="updateStatus(this)"
                                                            data-id="{{ $singledata['id'] }}"
                                                            data-map_id="{{ $singledata['map_id'] }}"
                                                            data-user_id="{{ $singledata['user_id'] }}"
                                                            title="Update Client Data">Update Payment Status</button>
                                                        @else
                                                        ----
                                                        @endif
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

        <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="paymentForm">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="map_id" id="map_id">
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Payment Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            {{-- contact details --}}
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="firstName" class="form-label">Transaction ID</label>
                                    <input class="form-control" type="text" id="transaction_id" name="transaction_id"
                                        placeholder="Enter Transaction ID" />
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="email" class="form-label">Remarks</label>
                                    <textarea class="form-control" type="text" id="remark" name="remark"
                                        placeholder="Enter Remarks"></textarea>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="email" class="form-label">Amount Received ? </label>
                                    <input type="checkbox" id="status" name="status" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="process" name="process"
                                value="update">Update
                                Status</button>
                            <button type="button" class="btn btn-outline-secondary" onclick="closeModal()">
                                Close
                            </button>
                        </div>
                </div>
                </form>
            </div>
        </div>
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
    });

    function show_Toaster(message, type) {
        var success = "#00b09b, #96c93d";
        var error = "#a7202d, #ff4044";
        var ColorCode = type == "success" ? success : error;
        return Toastify({
            text: message,
            duration: 3000,
            close: true,
            gravity: "bottom", // top or bottom
            position: "center", // left, center or right
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: `linear-gradient(to right, ${ColorCode})`,
            },
        }).showToast();
    }


    function closeModal() {
        $('#paymentForm')[0].reset(); // remove all data in inputs
        $('#basicModal').modal('hide'); //hide the modal 
    }

    function updateStatus(e) {
        $('#id').val($(e).attr('data-id'))
        $('#map_id').val($(e).attr('data-map_id'))
        $('#user_id').val($(e).attr('data-user_id'))
        $('#process').val('update');
        $('#basicModal').modal('show');
    }

    $('#paymentForm').submit(function(e) {
        e.preventDefault();
        var formdata = new FormData(this);
        formdata.append('process', $('#process').val());
        axios.post(`${url}/admin/updateUserPaymentDetails`, formdata).then(function(response) {
            // handle success
            show_Toaster(response.data.message, response.data.type)
            if (response.data.type === 'success') {
                setTimeout(() => {
                    location.reload();
                }, 500);
            }
        }).catch(function(err) {
            show_Toaster(err.response.data.message, 'error')
        })
    });
    </script>
</body>

</html>