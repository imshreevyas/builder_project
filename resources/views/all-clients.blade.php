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


                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Clients /</span> Manage</h4>
                        <div class="card">
                            <div style="display: flex;">
                                <h5 class="card-header">Manage Clients</h5>
                            </div>
                            <div class="table table-responsive">
                                <table id="table_id" class="display">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Company Name</th>
                                            <th>Machine Name</th>
                                            <th>Serial Number</th>
                                            <th>Validity Date</th>
                                            <th>Download QR code</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @php($i = 1)
                                        @foreach ($clients as $singleclients)
                                        <tr>
                                            <td>{{ $i++; }}</td>
                                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                                {{$singleclients->company_name}} </td>
                                            <td>{{$singleclients->machine_name}}</td>
                                            <td>{{$singleclients->serial_number}}</td>
                                            <td>{{ $singleclients->valid_till }}</td>
                                            <td><a
                                                    href="generateQRCode/{{ $singleclients->user_id.'/'.$singleclients->company_name }}">Downlaod
                                                    QR Code</a></td>
                                            <td>
                                                <a type="button" onclick="getDocument('{{$singleclients['user_id']}}')"
                                                    title="Client Documents"><i
                                                        class="menu-icon tf-icons bx bx-file"></i></a>
                                                <a href="clientDetails/{{ $singleclients['user_id'] }}"
                                                    title="Client Details"><i
                                                        class="menu-icon tf-icons bx bx-show"></i></a>
                                                <a type="button" onclick="editEmp({{$singleclients}})"
                                                    title="Edit Client Details"><i
                                                        class="menu-icon tf-icons bx bx-edit"></i></a>
                                                <a type="button"
                                                    onclick="deleteClient('{{$singleclients->id}}', '{{$singleclients->user_id}}')"
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editEmployee">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Edit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        {{-- contact details --}}
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="firstName" class="form-label">Company name</label>
                                <input class="form-control" type="text" id="company_name" name="company_name"
                                    placeholder="Enter Company name" autofocus />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="email" class="form-label">Machine Name</label>
                                <input class="form-control" type="text" id="machine_name" name="machine_name"
                                    placeholder="Enter Machine Name" />
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="email" class="form-label">Serial Number</label>
                                <input class="form-control" type="text" id="serial_number" name="serial_number"
                                    placeholder="Enter Serial Number" />
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="email" class="form-label">Select Data Validity Date</label>
                                <input class="form-control" type="date" id="valid_till" name="valid_till"
                                    placeholder="Enter Serial Number" />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="email" class="form-label">Machine Details</label>
                                <textarea class="form-control" type="text" id="machine_details" name="machine_details"
                                    placeholder="Enter Machine Details"></textarea>
                            </div>
                        </div>

                        <br>
                        <br>
                        <div class="row docrow-0">
                            <hr>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Document Name</label>
                                <input class="form-control" type="text" id="documents[0][name]"
                                    name="documents[0][name]" placeholder="Enter Document Name" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">Select Documents</label>
                                <input class="form-control" type="file" id="documents[0][file]"
                                    name="documents[0][file]" autofocus />
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary me-2" value="0"
                            onclick="createDocumentDiv(this)">Add Document</button>
                        <button type="submit" class="btn btn-primary" id="process" name="process" value="update">Save
                            changes</button>
                        <button type="button" class="btn btn-outline-secondary" onclick="closeModal()">
                            Close
                        </button>
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

    <!-- Document Delete Modal -->
    <div class="modal fade" id="docModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="editEmployee">
                    @csrf
                    <input type="hidden" name="emp_id" id="emp_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Edit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="docDiv row container" id="docdiv"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" onclick="closeModal()">
                            Close</button>
                    </div>
            </div>
            </form>
        </div>
    </div>



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
        $('.newRow').remove(); //remove all add on documents
        $('#editEmployee')[0].reset(); // remove all data in inputs
        $('#basicModal').modal('hide'); //hide the modal 
    }

    function closeModal() {
        $('.docCol').remove(); //remove all add on documents
        $('#docModal').modal('hide'); //hide the modal 
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


    function editEmp(data) {

        console.log(data.valid_till);
        $('#emp_id').val(data.id)
        $('#company_name').val(data.company_name)
        $('#machine_name').val(data.machine_name)
        $('#serial_number').val(data.serial_number)
        $('#valid_till').val(data.valid_till)
        $('#machine_details').val(data.machine_details)
        $('#process').val('update')
        $('#process').attr('user_id', data.user_id)
        $('#basicModal').modal('show');
    }


    $('#editEmployee').submit(function(e) {
        e.preventDefault();
        var formdata = new FormData(this);
        formdata.append('process', $('#process').val());
        formdata.append('user_id', $('#process').attr('user_id'));
        axios.post(`${url}/addClient`, formdata).then(function(response) {
            // handle success
            show_Toaster(response.data.message, response.data.type)
            if (response.data.type === 'success') {
                setTimeout(() => {
                    window.location.href = `${url}/all-client`;
                }, 500);
            }
        }).catch(function(err) {
            show_Toaster(err.response.data.message, 'error')
        })
    });

    function deleteClient(id, user_id) {
        if (confirm('Are you sure?')) {
            axios.post(`${url}/deleteClient`, {
                id,
                user_id
            }).then(function(response) {
                // handle success
                show_Toaster(response.data.message, response.data.type)
                if (response.data.type === 'success') {
                    setTimeout(() => {
                        window.location.href = `${url}/all-client`;
                    }, 500);
                }
            }).catch(function(err) {
                show_Toaster(err.response.data.message, 'error')
            })
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


    function getDocument(user_id) {

        $('.docCol').remove();
        axios.get(`${url}/getDocument/${user_id}`).then(function(response) {
            // handle success
            show_Toaster(response.data.message, response.data.type)
            if (response.data.type === 'success') {
                var html = response.data.html;
                $('#docdiv').append(html);
                $('#docModal').modal('show');
            }
        }).catch(function(err) {
            show_Toaster(err.response.data.message, 'error')
        })
    }

    function deleteDoc(e) {

        var user_id = $(e).attr('data-user_id');
        var id = $(e).attr('data-id');
        axios.get(`${url}/deleteDocument/${user_id}/${id}`).then(function(response) {
            // handle success
            show_Toaster(response.data.message, response.data.type)
            if (response.data.type === 'success') {
                setTimeout(() => {
                    window.location.href = `${url}/all-client`;
                }, 1000);
            }
        }).catch(function(err) {
            show_Toaster(err.response.data.message, 'error')
        })
    }
    </script>
</body>

</html>