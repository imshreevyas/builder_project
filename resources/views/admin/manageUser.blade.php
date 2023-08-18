<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Manage Clients</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <script src="https://code.jquery.com/jquery-3.6.3.js"
        integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js">
    </script>

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


                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Users /</span> Manage</h4>
                        <div class="card">
                            <div style="display: flex;">
                                <h5 class="card-header">Manage Users</h5>
                                <h5 class="card-header">
                                    <a type="button" class="btn btn-outline-secondary btn-small text-red"
                                        onclick="showAddUser()" title="Edit Client Details">Add
                                        New</a>
                                </h5>
                            </div>
                            <div class="table table-responsive">
                                <table id="table_id" class="display">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @php($i = 1)
                                        @foreach ($users as $singledata)
                                        <tr>
                                            <td>{{ $i++; }}</td>
                                            <td>{{ $singledata['name'] }} </td>
                                            <td>{{ $singledata['email'] }}</td>
                                            <td>{{ $singledata['mobile'] }}</td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" id="status-{{ $singledata['id'] }}"
                                                        onclick="updateUserStatus(this)"
                                                        data-key="{{ $singledata['id'] }}"
                                                        data-value="{{ $singledata['status'] == 1 ? '0' : '1' }}"
                                                        {{ $singledata['status'] == 1 ? 'checked' : '' }}>
                                                    <span class="slider"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <a type="button" onclick="showAddProperty('{{$singledata['id']}}')"
                                                    title="Add New Property"><i
                                                        class="menu-icon tf-icons bx bx-building"></i></a>
                                                <a type="button" onclick="editUser({{ json_encode($singledata) }})"
                                                    title="Edit Client Details"><i
                                                        class="menu-icon tf-icons bx bx-edit"></i></a>
                                                <a type="button" onclick="deleteUser('{{$singledata['id']}}')"
                                                    title="Delete Client Data"><i
                                                        class="menu-icon tf-icons bx bx-trash"></i></a>
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="editUser">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="key" id="key">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">User Details</h5>
                        <button type="button" class="btn-close" onclick="closeModal()" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        {{-- contact details --}}
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">User name</label>
                                <input class="form-control" type="text" id="name" name="name"
                                    placeholder="Enter User name" autofocus />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input class="form-control" type="text" id="email" name="email"
                                    placeholder="Enter Email Id" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Mobile Number</label>
                                <input class="form-control" type="text" id="mobile" name="mobile"
                                    placeholder="Enter Mobile Number" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Password</label>
                                <input class="form-control" type="text" id="dcrypt_password" name="dcrypt_password"
                                    placeholder="Enter Password" />
                            </div>

                        </div>
                        <hr>
                        <div class="row property-div"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="process" name="process" value="update">Save
                            changes</button>
                        <button type="button" class="btn btn-primary" id="append_property" data-value="0"
                            onclick="appendProperty(this)" value="update">Add
                            Property</button>
                    </div>
            </div>
            </form>
        </div>
    </div>

    <!-- Payment Add Modal -->
    <div class="modal fade" id="propertyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="userPropertyForm">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id">
                    <input type="hidden" class="key" name="key" id="key">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">User Payment Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            onclick="clearUserPropertyModal()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <table class="table table-responsive table-bordered">
                                <thead>
                                    <th>Property Name</th>
                                    <th>Emi Amount</th>
                                    <th>Emi Count</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody class="userPropertyTable"></tbody>
                            </table>
                        </div>

                        <hr>
                        <div class="row user-property-div"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="appendUserProperty(this)" class="btn btn-primary" data-value="0"
                            id="append_user_property" name="process" value="update">Add New Property</button>
                        <button type="submit" class="btn btn-primary" id="process" name="process" value="update">Save
                            changes</button>
                    </div>
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
    async function appendProperty(e) {
        var key = $(e).attr('data-value');
        var newValue = parseInt(key) + 1;
        axios.get(`${url}/admin/getPropertyOptions`).then(function(response) {
            var html = `<div class="row property-div-${key}">
                <div class="mb-3 col-md-4">
                    <label for="email" class="form-label">Property Name</label>
                    <select name="property[${key}][property_id]" id="property[${key}][property_id]" class="form-control">
                        <option value="0">Select Property</option>
                        ${response.data.data}
                    </select>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="email" class="form-label">Emi Amount</label>
                    <input class="form-control" type="text" id="property[${key}][emi_amount]" name="property[${key}][emi_amount]"
                        placeholder="Amount" />
                </div>
                <div class="mb-3 col-md-2">
                    <label for="email" class="form-label">No of EMI</label>
                    <input class="form-control" type="text" id="property[${key}][emi_count]" name="property[${key}][emi_count]"
                        placeholder="No of EMI" />
                </div>
                <div class="mb-3 col-md-2">
                    <label for="email" class="form-label">1st EMI Date</label>
                    <input class="form-control" type="date" id="property[${key}][first_emi_date]" name="property[${key}][first_emi_date]"/>
                </div>
                <div class="mb-3 col-md-1">
                    <button type="button" class="btn-danger btn btn-sm" onclick="deleteDiv('property-div-${key}')"><i class="menu-icon tf-icons bx bx-trash"></i></button>
                </div>
            </div>`;

            $('.property-div').append(html);
            $(e).attr('data-value', newValue);
        }).catch(function(err) {
            return err;
        })
    }

    async function appendUserProperty(e) {
        var key = $(e).attr('data-value');
        var newValue = parseInt(key) + 1;
        axios.get(`${url}/admin/getPropertyOptions`).then(function(response) {
            var html = `<div class="row property-div-${key}">
                <div class="mb-3 col-md-4">
                    <label for="email" class="form-label">Property Name</label>
                    <select name="property[${key}][property_id]" id="property[${key}][property_id]" class="form-control">
                        <option value="0">Select Property</option>
                        ${response.data.data}
                    </select>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="email" class="form-label">Emi Amount</label>
                    <input class="form-control" type="text" id="property[${key}][emi_amount]" name="property[${key}][emi_amount]"
                        placeholder="Amount" />
                </div>
                <div class="mb-3 col-md-2">
                    <label for="email" class="form-label">No of EMI</label>
                    <input class="form-control" type="text" id="property[${key}][emi_count]" name="property[${key}][emi_count]"
                        placeholder="No of EMI" />
                </div>
                <div class="mb-3 col-md-2">
                    <label for="email" class="form-label">1st EMI Date</label>
                    <input class="form-control" type="date" id="property[${key}][first_emi_date]" name="property[${key}][first_emi_date]"/>
                </div>
                <div class="mb-3 col-md-1">
                    <button type="button" class="btn-danger btn btn-sm" onclick="deleteDiv('property-div-${key}')"><i class="menu-icon tf-icons bx bx-trash"></i></button>
                </div>
            </div>`;

            $('.user-property-div').append(html);
            $(e).attr('data-value', newValue);
        }).catch(function(err) {
            return err;
        })
    }

    function deleteDiv(key) {
        $(`.${key}`).remove();
    }

    function closeModal() {
        $('.property-div').html(''); //remove all add on documents
        $('#editUser')[0].reset(); // remove all data in inputs
        $('#basicModal').modal('hide'); //hide the modal 
    }

    function clearUserPropertyModal() {
        $('.user-property-div').html(''); //remove all add on documents
        $('.userPropertyTable').html(''); //remove all add on documents
        $('#userPropertyForm')[0].reset(); // remove all data in inputs
        $('#propertyModal').modal('hide'); //hide the modal 
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


    function editUser(data) {
        $('#id').val(data.id)
        $('#name').val(data.name)
        $('#email').val(data.email)
        $('#mobile').val(data.mobile)
        $('#emi_amount').val(data.emi_amount)
        $('#emi_count').val(data.emi_count)
        $('#emi_expiry_date').val(data.emi_expiry_date)
        $('#dcrypt_password').val(data.dcrypt_password)
        $("#property_id").val(data.property_id);
        $('#process').val('update')
        $('#basicModal').modal('show');
    }

    function showAddUser() {
        document.getElementById("editUser").reset();
        $('#process').val('add')
        $('#basicModal').modal('show');
    }

    function showAddProperty(user_id) {
        // $('#basicModal3').modal('show');
        // return;
        axios.post(`${url}/admin/getUserProperties`, {
            user_id
        }).then(function(response) {
            $('#user_id').val(user_id);
            $('.userPropertyTable').html(response.data.data)
            $('#propertyModal').modal('show');
        }).catch(function(err) {
            return err;
        })

    }

    function closeEMI(e) {

        if (confirm('Are you sure?')) {
            var user_id = $(e).attr('data-user_id');
            var map_id = $(e).attr('data-map_id');
            $(e).text('Please wait...');
            axios.post(`${url}/admin/closeUserProperty`, {
                user_id,
                map_id
            }).then(function(response) {
                show_Toaster(response.data.message, response.data.type)
                $('.userPropertyTable').html(response.data.data)
                $('#propertyModal').modal('show');
            }).catch(function(err) {
                return err;
            })
        }

    }

    function showAddPayment(key) {
        document.getElementById("addUserPayment").reset();
        $('#process').val('add')
        $('.key').val(key)
        $('#basicModal3').modal('show');
    }


    $('#editUser').submit(function(e) {
        e.preventDefault();
        var formdata = new FormData(this);
        formdata.append('process', $('#process').val());
        axios.post(`${url}/admin/addUser`, formdata).then(function(response) {
            // handle success
            show_Toaster(response.data.message, response.data.type)
            if (response.data.type === 'success') {
                setTimeout(() => {
                    window.location.href = `${url}/admin/allUsers`;
                }, 500);
            }
        }).catch(function(err) {
            show_Toaster(err.response.data.message, 'error')
        })
    });

    $('#userPropertyForm').submit(function(e) {
        e.preventDefault();
        var formdata = new FormData(this);
        axios.post(`${url}/admin/addUserProperty`, formdata).then(function(response) {
            // handle success
            show_Toaster(response.data.message, response.data.type)
            if (response.data.type === 'success') {
                $('.userPropertyTable').html(response.data.data)
                $('.user-property-div').html('');
            }
        }).catch(function(err) {
            show_Toaster(err.response.data.message, 'error')
        })
    });

    function deleteUser(id) {
        if (confirm('Are you sure?')) {
            axios.post(`${url}/admin/deleteUser`, {
                id,
            }).then(function(response) {
                // handle success
                show_Toaster(response.data.message, response.data.type)
                if (response.data.type === 'success') {
                    setTimeout(() => {
                        window.location.href = `${url}/admin/allUsers`;
                    }, 500);
                }
            }).catch(function(err) {
                show_Toaster(err.response.data.message, 'error')
            })
        }
    }

    function updateUserStatus(e) {
        value = $(e).attr('data-value');
        if (confirm('Are you sure, you want to ' + (value == 1 ? 'Activate' : 'Deactivate'))) {
            id = $(e).attr('data-key');

            axios.post(`${url}/admin/updateUserStatus`, {
                id,
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

    function createDocumentDiv(e) {
        var lastkey = $(e).val();
        lastkey++;
        var html = `
        
        <div class="row newRow docrow-${lastkey}">
        <hr>
            <div class="mb-3 col-md-5">
                <label for="email" class="form-label">Document Name</label>
                <input class="form-control" type="text" id="documents[${lastkey}][name]"
                    name="documents[${lastkey}][name]" placeholder="Enter Document Name" />
            </div>
            <div class="mb-3 col-md-5">
                <label for="firstName" class="form-label">Select Documents</label>
                <input class="form-control" type="file" id="documents[${lastkey}][file]"
                    name="documents[${lastkey}][file]" />
            </div>
            <div class="mb-3 col-md-1">
                <button type="button" class="btn btn-danger" onclick="deleteRow('docrow-${lastkey}')"><i class="menu-icon tf-icons bx bxs-trash"></i></button>
            </div>

        </div>
        `;

        $(e).val(lastkey)
        $('.docrow-0').append(html);
    }

    function deleteRow(className) {
        $(`.${className}`).remove();
    }
    </script>
</body>

</html>