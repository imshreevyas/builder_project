<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Manage User Payments</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <script src="https://code.jquery.com/jquery-3.6.3.js"
        integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js">
    </script>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
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


                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">User Payments /</span> Manage
                        </h4>

                        <div class="card">
                            <div style="display: flex;">
                                <h5 class="card-header">Manage User Payments <button type="button"
                                        class="btn btn-primary btn-sm" id="addUserPayment" name="addUserPayment"
                                        onclick="addUserPayment(this)" data-map_id="{{ $map_id }}"
                                        data-user_id="{{ $user_id }}" value="update">Add
                                        User Payment </button></h5>

                            </div>
                            <div class="table table-responsive">
                                <table id="table_id" class="display">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Properties Name</th>
                                            <th>Amount</th>
                                            <th>Emi Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @php($i = 1)
                                        @foreach ($payments as $singledata)
                                        <tr>
                                            <td>{{ $i++; }}</td>
                                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                                {{ $singledata['property']['property_name']}} </td>
                                            <td>{{ $singledata['emi_amount'] }}</td>
                                            <td>{{ date('d M, Y',strtotime($singledata['due_date']))}}</td>
                                            <td>@if($singledata['status'] == 0)
                                                <span class="badge bg-warning">Pending</span>
                                                @else
                                                <span class="badge bg-success">Paid</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($singledata['status'] == 0)
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="updateStatus(this)" data-id="{{ $singledata['id'] }}"
                                                    data-map_id="{{ $singledata['map_id'] }}"
                                                    data-user_id="{{ $singledata['user_id'] }}"
                                                    title="Update Client Data">Update Payment Status</button>
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    onclick="sendReminder('{{ $singledata['user_id'] }}','{{ $singledata['id'] }}')">Send
                                                    EMI
                                                    Reminder</button>
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

    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="paymentUpdateForm">
                    @csrf
                    <input type="hidden" name="id" id="id" class="id">
                    <input type="hidden" name="map_id" id="map_id" class="map_id">
                    <input type="hidden" name="user_id" id="user_id" class="user_id">
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
                        <button type="submit" class="btn btn-primary" id="process" name="process" value="update">Update
                            Status</button>
                        <button type="button" class="btn btn-outline-secondary" onclick="closeModal()">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addUserPaymentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="paymentAddForm">
                    @csrf
                    <input type="hidden" name="map_id" id="id" class="map_id">
                    <input type="hidden" name="user_id" id="user_id" class="user_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Add Payment Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        {{-- contact details --}}
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">Emi Amount</label>
                                <input class="form-control" type="text" id="emi_amount" name="emi_amount"
                                    placeholder="Enter EMI Amount" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">Emi Date</label>
                                <input class="form-control" type="date" id="due_date" name="due_date" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary process" id="process" name="process"
                            value="update">Add
                            Payment</button>
                        <button type="button" class="btn btn-outline-secondary" onclick="closeModal()">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
    .docDiv {
        column-gap: 15px;
        row-gap: 12px;
        align-items: center;
        justify-content: center;
    }

    .docDiv .docCol {
        padding: 10px 10px;
        border: 1px solid #c3c3c3;
        display: flex;
        justify-content: space-between;
    }
    </style>

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
    function closeModal() {
        $('#paymentForm')[0].reset(); // remove all data in inputs
        $('#basicModal').modal('hide'); //hide the modal 
    }

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

    $(document).ready(function() {
        $('#table_id').DataTable();
    });

    function updateStatus(e) {
        $('.id').val($(e).attr('data-id'))
        $('.map_id').val($(e).attr('data-map_id'))
        $('.user_id').val($(e).attr('data-user_id'))
        $('.process').val('update');
        $('#basicModal').modal('show');
    }

    function addUserPayment(e) {
        $('.map_id').val($(e).attr('data-map_id'))
        $('.user_id').val($(e).attr('data-user_id'))
        $('.process').val('add');
        $('#addUserPaymentModal').modal('show');
    }


    $('#paymentAddForm').submit(function(e) {
        e.preventDefault();
        var formdata = new FormData(this);
        formdata.append('process', $('.process').val());
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

    function sendReminder(user_id, id) {
        var formdata = new FormData();
        formdata.append('user_id', user_id);
        formdata.append('id', id);
        axios.post(`${url}/admin/sendReminder`, formdata).then(function(response) {
            // handle success
            show_Toaster(response.data.message, response.data.type);
        }).catch(function(err) {
            show_Toaster(err.response.data.message, 'error')
        })
    };


    $('#paymentUpdateForm').submit(function(e) {
        e.preventDefault();
        var formdata = new FormData(this);
        formdata.append('process', $('.process').val());
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