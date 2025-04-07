<?php
session_start();

// Check if the user is logged in and has the 'Admin' role
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'Admin') {
    // Redirect to login page if not logged in or not an Admin
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Regal Admin</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../../vendors/base/vendor.bundle.base.css">
  <!-- end inject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../../vendors/select2/select2.min.css">
  <link rel="stylesheet" href="../../../vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../../css/style.css">
  <!-- end inject -->
  <link rel="shortcut icon" href="../../../images/favicon.png" />
  <!-- links assets -->
  <!-- <link rel="stylesheet" href="../assets/css/bootstrap.min.css" > -->
  <link rel="stylesheet" href="../../assets/css/jquery.dataTables.min.css" >
  <!-- end links assets -->
  <style>
    .footer {
    position: fixed;
    bottom: 0;
    width: calc(118% - 280px); /* Default width marka sidebar furan */
    transition: width 0.3s ease-in-out;
}

  </style>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:../../../partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
          <li class="nav-item nav-search d-none d-lg-block">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="search">
                  <i class="icon-search"></i>
                </span>
              </div>
              <input type="text" class="form-control" placeholder="Search Projects.." aria-label="search" aria-describedby="search">
            </div>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown d-flex mr-4 ">
            <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-toggle="dropdown">
              <!-- <i class="icon-cog"></i> -->
              <i class="icon-head"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Profile</p>
              <p class="mb-0 font-weight-normal float-left dropdown-header">Email: <?= htmlspecialchars($_SESSION['email']); ?></p>
              <a class="dropdown-item preview-item hover:cursor-pointer" href="../Profile/profile.php">               
                  <i class="icon-head"></i>
                  <span class="menu-title">Profile</span> 
              </a>
              <a class="dropdown-item preview-item cursor-pointer" href="../../../logout.php">
                  <i class="icon-inbox"></i> 
                  <span class="menu-title">Logout</span>
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../../partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav mt-5">
          <li class="nav-item">
            <a class="nav-link" href="../../../index.php">
              <i class="icon-box menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../../pages/Admin/Users/Users.php">
              <!-- <i class="icon-file menu-icon"></i> -->
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Users</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../../pages/Admin/Doctors/Doctors.php">
              <!-- <i class="icon-file menu-icon"></i> -->
              <span class="menu-title">Doctors</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../../pages/Admin/Patients/Patients.php">
              <!-- <i class="icon-pie-graph menu-icon"></i> -->
              <span class="menu-title">Patients</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <!-- <i class="icon-disc menu-icon"></i> -->
              <span class="menu-title">Appointments</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../../../pages/Admin/AcceptAppointment/Accept.php">Accept Appointment</a></li>
                <li class="nav-item"> <a class="nav-link" href="../../../pages/Admin/RejectAppointment/Reject.php">Reject Appointment</a></li>
                <li class="nav-item"> <a class="nav-link" href="../../../pages/Admin/Appointments/AllAppointment.php">All Appointment</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../../pages/Admin/Payments/Payments.php">
              <!-- <i class="icon-help menu-icon"></i> -->
              <span class="menu-title">Payments</span>
            </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basics" aria-expanded="false" aria-controls="ui-basics">
                <!-- <i class="icon-disc menu-icon"></i> -->
                <span class="menu-title">Reports</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-basics">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="../../../pages/Admin/Reports/DoctorReport.php"> Doctor of Reports </a></li>
                  <li class="nav-item"> <a class="nav-link" href="../../../pages/Admin/Reports/PatientReport.php">Patient of  Report</a></li>
                </ul>
              </div>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">        
        <div class="content-wrapper">
          <div class="body">
              <h2>Report Form</h2>
              <button type="button" class="btn btn-primary" id="insertModal">Add Report</button>
              <br><br><hr>

              <h2>Reports List</h2>
              <table id="reportsTable" class="table">
                  <thead>
                      <tr>
                          <th>Report ID</th>
                          <th>User ID</th>
                          <th>Appointment ID</th>
                          <th>Payment ID</th>
                          <th>Report Type</th>
                          <th>Description</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody></tbody>
              </table>
          </div> 
           <!-- Modal for adding/editing report -->
          <div class="modal" id="reportModal" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title">Add/Edit Report</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <form id="reportForm">
                              <input type="hidden" id="report_id" name="report_id"> <!-- For editing -->

                              <label for="user_id">User ID:</label>
                               <select id="user_id" name="user_id" class="form-control" ></select>

                              <label for="appointment_id">Appointment ID:</label>
                              <select id="appointment_id" name="appointment_id" class="form-control">
                                  <option value="">Select Appointment</option>
                              </select><br>

                              <label for="payment_id">Payment ID:</label>
                               <select id="payment_id" name="payment_id" class="form-control">
                                  <option value="">Select Payment</option>
                              </select><br>

                              <label for="report_type">Report Type:</label>
                              <select id="report_type" name="report_type" class="form-control">
                                  <option value="appointment">Appointment</option>
                                  <option value="payment">Payment</option>
                              </select><br>

                              <label for="description">Description:</label>
                              <textarea id="description" name="description" class="form-control" ></textarea><br>

                              <button type="submit" class="btn btn-primary">Save Report</button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>


          <!-- start Update Model  -->
          <div class="modal" id="edit_userModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h2 class="modal-title">Add User</h2>
                      <button type="button " class="close" data-dismiss="modal" arial-label="close">
                        <span arial-hidden="true">&times;</span>
                      </button>

                  </div>
                          <div class="modal-body">
                                  <form id="editForm" method="POST" action="">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">fullName</label>
                                        <input type="hidden" class="form-control" id="edit_user_id" name="edit_user_id" >
                                        <input type="name" class="form-control" id="edit_fullName" name="edit_fullName" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">email</label>
                                        <input type="email" class="form-control" id="edit_email" name="edit_email" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">userName</label>
                                        <input type="text" class="form-control" id="edit_userName" name="edit_userName" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">password</label>
                                        <input type="password" class="form-control" id="edit_password" name="edit_password" placeholder="Leave blank to keep current password" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="number" class="form-label">phone</label>
                                        <input type="number" class="form-control" id="edit_phone" name="edit_phone" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="number" class="form-label">phone</label>
                                        <select name="edit_role" id="edit_role" class="form-control">
                                          <option value=""></option>
                                        </select>
                                    </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <!-- <button  class="close" >Close</button> -->
                                        
                                    
                                  </form>


                          </div>

                      </div>

              </div>

          </div>
          <!-- Ends Update Model  -->
        <!-- content-wrapper ends -->
        <!-- partial:../../../partials/_footer.html -->
        <!-- partial -->
      </div>
      <footer class="footer bg-light text-center py-3">
        <div class="container">
            <span class="text-muted">Copyright © bootstrap.com 2025</span>
        </div>
    </footer>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- script bootstrap -->
  <script src="../../assets/js/jquery-3.5.1.min.js" rel="stylesheet"></script>
  <script src="../../assets/js/jquery.dataTables.min.js" rel="stylesheet"></script>
 <!-- scripts -->
  <!-- container-scroller -->
   <!-- scripts -->
    <script>
      // $(document).ready(function(){
      //   $('#insertModal').click(function(){
      //     $('#reportModal').modal('show');
      //     $('#reportForm')[0].reset();
      //   });
      //   displayData();
      //   //fetch data user id 
      //   // $.get("report_action.php?url=loadData", function(data) {
      //   //   const response = JSON.parse(data);

      //   //   // Check if Users exist in the response
      //   //   if (response.Users) {
      //   //       // Loop through each user and append them to the select dropdown
      //   //       response.Users.forEach(user => {
      //   //           $("#user_id").append(`<option value="${user.user_id}">${user.fullName}</option>`);
      //   //       });
      //   //   } else {
      //   //       console.log("No users found.");
      //   //   }
      //   // });

      //   //display the Data
      //   function displayData(){
      //       $.ajax({
      //               url:'report_action.php?url=displayReport',
      //               success: function(res){
      //                   const rows = JSON.parse(res);
      //                   let tableData = '';
      //                   rows.forEach(rows => {
      //                       tableData +=`
      //                       <tr>
      //                       <td> ${rows.report_id }</td>
      //                       <td> ${rows.user_id }</td>
      //                       <td> ${rows.appointment_id }</td>
      //                       <td> ${rows.payment_id }</td>
      //                       <td> ${rows.report_type }</td>
      //                       <td> ${rows.description}</td>
      //                       <td> ${rows.created_at }</td>
      //                       <td> 
      //                       <button class="btn btn-warning btn-sm editBtn" data-user_id="${rows.report_id}"  data-fullname="${rows.user_id}" data-email="${rows.appointment_id}" data-username="${rows.payment_id}" data-password="${rows.report_type}"  data-phone="${rows.description}" data-status="${rows.status}"  >Edit</button>
      //                       <button class="btn btn-danger btn-sm deleteBtn" data-id="${rows.report_id}">Delete</button> 
      //                       </td> 
      //                       </tr>`;
                            
      //                   });
                       
      //                   if($.fn.DataTable.isDataTable('#dataTable'))
      //                         {
      //                             $('#dataTable').DataTable().clear().destroy();
      //                         }
      //                         $('#dataTable tbody').html(tableData);

      //                         $('#dataTable').DataTable({
                                  
      //                             Paging: true,
      //                             Searching: true,
      //                             ordering: true,
      //                             responsive: true
                                  
      //                         });
                        
      //               }
      //           })
      //   }
      // });

      $(document).ready(function() {
        $('#insertModal').click(function(){
          $('#reportModal').modal('show');
          $('#reportForm')[0].reset();
        });
        // displayData();
        // On change of the role selection (Doctor/Patient)
        $('#role_selection').on('change', function() {
            // Get the selected role (Doctor or Patient)
            var selectedRole = $(this).val();

            if (selectedRole) {
                // Fetch data based on the selected role (Doctor or Patient)
                $.get("report_action.php?url=loadData", { role: selectedRole }, function(data) {
                    const response = JSON.parse(data);

                    // Clear the previous options in the dropdown
                    $('#user_id').html('<option value="">Select ' + selectedRole + '</option>');

                    // Check if the corresponding role data exists
                    if (response[selectedRole]) {
                        // Loop through the data and append to the dropdown
                        response[selectedRole].forEach(function(user) {
                            $('#user_id').append(`<option value="${user.user_id}">${user.fullName}</option>`);
                        });
                    } else {
                        console.log("No " + selectedRole + "s found.");
                    }
                });
            } else {
                // If no role is selected, clear the dropdowns
                $('#user_id').html('<option value="">Select Doctor/Patient</option>');
                $('#appointment_id').html('<option value="">Select Appointment</option>');
                $('#payment_id').html('<option value="">Select Payment</option>');
            }
        });

        // Function to load appointments and payments
        function loadAppointmentsAndPayments() {
            // Load appointment data
            $.get("report_action.php?url=loadAppointments", function(data) {
                const response = JSON.parse(data);

                $('#appointment_id').html('<option value="">Select Appointment</option>');
                if (response.appointments) {
                    response.appointments.forEach(function(appointment) {
                        $('#appointment_id').append(`<option value="${appointment.appointment_id}">${appointment.appointment_name}</option>`);
                    });
                }
            });

            // Load payment data
            $.get("report_action.php?url=loadPayments", function(data) {
                const response = JSON.parse(data);

                $('#payment_id').html('<option value="">Select Payment</option>');
                if (response.payments) {
                    response.payments.forEach(function(payment) {
                        $('#payment_id').append(`<option value="${payment.payment_id}">${payment.payment_name}</option>`);
                    });
                }
            });
        }

        // Load appointments and payments when the page loads
        loadAppointmentsAndPayments();
      });
    </script>

     <script src="../../assets/js/bootstrap.bundle.min.js" rel="stylesheet"></script>
   <!-- end scripts -->
  <!-- base:js -->
  <!-- <script src="../../../vendors/base/vendor.bundle.base.js"></script> -->
  <!-- end inject -->
  <!-- inject:js -->
  <script src="../../../js/off-canvas.js"></script>
  <script src="../../../js/hoverable-collapse.js"></script>
  <script src="../../../js/template.js"></script>
  <!-- end inject -->
  <!-- plugin js for this page -->
  <script src="../../../vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="../../../vendors/select2/select2.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../../../js/file-upload.js"></script>
  <script src="../../../js/typeahead.js"></script>
  <script src="../../../js/select2.js"></script>
  <!-- End custom js for this page -->
</body>

</html>
