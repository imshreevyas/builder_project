<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Manage Employees</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
  
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>

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
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Employees /</span> Manage</h4>
                <div class="card">
                    <div style="display: flex;">
                      <h5 class="card-header">Manage Employees</h5>
                    </div>
                    <div class="table-responsive">
                      <table id="table_id" class="display">
                        <thead>
                          <tr>
                            <th>Emp code</th>
                            <th>Emp name</th>
                            <th>Emp department</th>
                            <th>Emp designation</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                          @foreach ($employees as $employee)
                          <tr>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> {{$employee->empCode}} </td>
                            <td>{{$employee->firstName.' '.$employee->lastName}}</td>
                            <td>
                              {{$employee->department}}
                            </td>
                            <td>{{$employee->designation}}</td>
                            <td>
                              <a type="button" onclick="editEmp({{$employee}})"><i class="menu-icon tf-icons bx bx-edit"></i></a>
                              <a type="button" onclick="deleteEmp({{$employee->id}})"><i class="menu-icon tf-icons bx bx-trash"></i></a>
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
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            
              {{-- contact details --}}
              <div class="row">
                <div class="mb-3 col-md-6">
                  <label for="firstName" class="form-label">First Name</label>
                  <input
                    class="form-control"
                    type="text"
                    id="firstName"
                    name="firstName"
                    placeholder="first name"
                    autofocus
                  />
                </div>
                <div class="mb-3 col-md-6">
                  <label for="lastName" class="form-label">Last Name</label>
                  <input class="form-control" type="text" name="lastName" id="lastName" placeholder="last name" />
                </div>
                <div class="mb-3 col-md-6">
                  <label for="email" class="form-label">E-mail</label>
                  <input
                    class="form-control"
                    type="text"
                    id="email"
                    name="email"
                    placeholder="mail@example.com"
                  />
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label" for="phoneNumber">Phone Number</label>
                  <div class="input-group input-group-merge">
                    <span class="input-group-text">IN (+91)</span>
                    <input
                      type="text"
                      id="mobile"
                      name="mobile"
                      class="form-control"
                      placeholder="8105550111"
                    />
                  </div>
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label">Employee code</label>
                  <input type="text" class="form-control" id="empCode" name="empCode" placeholder="Employee code" />
                </div>
                <div class="mb-3 col-md-6">
                  <label for="department" class="form-label">Department</label>
                  <input
                    type="text"
                    class="form-control"
                    id="department"
                    name="department"
                    placeholder="Accounts"
                  />
                </div>
                <div class="mb-3 col-md-6">
                  <label for="department" class="form-label">Designation</label>
                  <input
                    type="text"
                    class="form-control"
                    id="designation"
                    name="designation"
                    placeholder="Employee Designation"
                  />
                </div>
                <div class="mb-3 col-md-6">
                  <label for="address" class="form-label">Address</label>
                  <input type="text" class="form-control" id="address" name="address" placeholder="Address" />
                </div>
               
                <div class="mb-3 col-md-6">
                  <label for="joining" class="form-label">Joining Date</label>
                  <input
                    type="date"
                    class="form-control"
                    id="joiningDate"
                    name="joiningDate"
                  />
                </div>
                <div class="mb-3 col-md-6">
                  <label for="ctc" class="form-label">CTC</label>
                  <input
                    type="text"
                    class="form-control"
                    id="ctc"
                    name="ctc"
                    placeholder="e.g 600000"
                  />
                </div>
              </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Close
            </button>
            <button type="submit" class="btn btn-primary">Save changes</button>
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
        </script>
    <script>
      $(document).ready( function () {
          $('#table_id').DataTable();
      } );
      function editEmp(data){
        $('#emp_id').val(data.id)
        $('#firstName').val(data.firstName)
        $('#lastName').val(data.lastName)
        $('#email').val(data.email)
        $('#mobile').val(data.mobile)
        $('#address').val(data.address)
        $('#ctc').val(data.ctc)
        $('#department').val(data.department)
        $('#designation').val(data.designation)
        $('#empCode').val(data.empCode)
        $('#joiningDate').val(data.joiningDate)
        $('#basicModal').modal('show');
      }
      $('#editEmployee').submit(function(e){
          e.preventDefault();
          axios.post(`${url}/addEmployee`,new FormData(this)).then(function (response) {
                  // handle success
                  show_Toaster(response.data.message,response.data.type)
                  if (response.data.type === 'success') {
                      setTimeout(() => {
                          window.location.href = `${url}/manage-emp`;
                      }, 500);
                  }
              }).catch(function (err) {
                  show_Toaster(err.response.data.message,'error')
          })
      });
      function deleteEmp(id){
        if (confirm('Are you sure?')) {
          axios.post(`${url}/deleteEmployee`,{id:id}).then(function (response) {
                  // handle success
                  show_Toaster(response.data.message,response.data.type)                      
                  if (response.data.type === 'success') {
                    setTimeout(() => {
                          window.location.href = `${url}/manage-emp`;
                    }, 500);
                  }
              }).catch(function (err) {
                  show_Toaster(err.response.data.message,'error')
          })
        }
      }
    </script>
  </body>
</html>
