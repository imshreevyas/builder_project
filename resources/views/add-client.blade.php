<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Add Client</title>

    <meta name="description" content="" />

    <!-- Icons. Uncomment required icon fonts -->
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
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Client /</span> Add Client</h4>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="card mb-4">
                                    <h5 class="card-header">Client Details</h5>
                                    <!-- Account -->
                                    <div class="card-body">
                                        <form id="addClient">
                                            @csrf
                                            <div class="row">
                                                <div class="mb-3 col-md-4">
                                                    <label for="firstName" class="form-label">Company name</label>
                                                    <input class="form-control" type="text" id="company_name"
                                                        name="company_name" placeholder="Enter Company name"
                                                        autofocus />
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label for="email" class="form-label">Machine Name</label>
                                                    <input class="form-control" type="text" id="machine_name"
                                                        name="machine_name" placeholder="Enter Machine Name" />
                                                </div>

                                                <div class="mb-3 col-md-4">
                                                    <label for="email" class="form-label">Serial Number</label>
                                                    <input class="form-control" type="text" id="serial_number"
                                                        name="serial_number" placeholder="Enter Serial Number" />
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label for="email" class="form-label">Select Data Valid Date</label>
                                                    <input class="form-control" type="date" id="valid_till"
                                                        name="valid_till" />
                                                </div>
                                                <div class="mb-3 col-md-12">
                                                    <label for="email" class="form-label">Machine Details</label>
                                                    <textarea class="form-control" type="text" id="machine_details"
                                                        name="machine_details"
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
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-primary me-2" value="0"
                                                    onclick="createDocumentDiv(this)">Add New Document</button>
                                                <button type="submit" name="process" id="process" value="add"
                                                    class="btn btn-primary me-2" style="float:right">Save
                                                    changes</button>
                                                <button type="reset" class="btn btn-outline-secondary">Reset
                                                    Form</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /Account -->

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
    $('#addClient').on('submit', function(e) {

        $('#process').text('Please Wait... Uploading files and creating Client');
        e.preventDefault();
        var formdata = new FormData(this);
        formdata.append('process', $('#process').val());
        axios.post(`${url}/addClient`, formdata).then(function(response) {
            // handle success
            $('#process').text('Save Changes');
            show_Toaster(response.data.message, response.data.type)
            if (response.data.type === 'success') {
                setTimeout(() => {
                    window.location.href = `${url}/add-client`;
                }, 500);
            }
        }).catch(function(err) {
            $('#process').text('Save Changes');
            show_Toaster(err.response.data.message, 'error')
        })
    });


    function createDocumentDiv(e) {
        var lastkey = $(e).val();
        lastkey++;
        var html = `
        
        <div class="row docrow-${lastkey}">
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