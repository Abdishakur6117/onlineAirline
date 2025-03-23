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
  <!-- inject:css -->
  <link rel="stylesheet" href="../../../css/style.css">
  <!-- end inject -->
  <link rel="shortcut icon" href="../../../images/favicon.png" />
  <link rel="stylesheet" href="../../assets/css/jquery.dataTables.min.css" >
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .footer {
    position: fixed;
    bottom: 0;
    width: calc(120% - 285px); /* Default width marka sidebar furan */
    transition: width 0.3s ease-in-out;
    }

  </style>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:../../../partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <h2 class="text-3xl mt-5 text-black p-3">Online Doctor Appointment System</h2>
      </div>
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
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Users</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../../pages/Admin/Doctors/Doctors.php">
              <!-- <i class="icon-pie-graph menu-icon"></i> -->
              <span class="menu-title">Doctors</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../../pages/Admin/Patients/Patients.php">
              <!-- <i class="icon-command menu-icon"></i> -->
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
            <a class="nav-link" href="../../../pages/Admin/Reports/Reports.php">
              <!-- <i class="icon-book menu-icon"></i> -->
              <span class="menu-title">Reports</span>
            </a>
          </li>
        </ul>
      </nav>
      
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="body">
          <h2>Doctor Form</h2>
          <button type="button" class="btn btn-primary at-3" id="insertModal">Add Doctor</button>
          <br>
          <br>
          <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
              <td>doctor_id </td>
              <td>Doctor Name </td>
              <td>specialization </td>
              <td>availability </td>
              <td>consultation_fee </td>
              <td>created_at</td>
              <td>Actions</td>
            </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
          <!--/   INsert Modal start -->

          <div class="modal" id="DoctorModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h2 class="modal-title">Add Doctor</h2>
                      <button type="button " class="close" data-dismiss="modal" arial-label="close">
                        <span arial-hidden="true">&times;</span>
                      </button>

                  </div>
                          <div class="modal-body">
                                  <form id="DoctorForm" method="POST" action="">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">user_id</label>
                                        <select name="user_id" id="user_id" class="form-control">
                                          <option value="">Select Users</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">specialization</label>
                                        <select name="special" id="special" class="form-control">
                                          <option value="">select specialization</option>
                                          <option value="Cardiologist">Cardiologist</option>
                                          <option value="Dentist">Dentist</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">availability</label>
                                        <select name="availability" id="availability" class="form-control">
                                          <option value="">select AVailability Doctor</option>
                                          <option value="Saturday to Monday, 9AM - 5PM">Saturday to Monday, 9AM - 5PM"</option>
                                          <option value="Monday to Thursday, 9AM - 5PM">Monday to Thursday, 9AM - 5PM</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="number" class="form-label">consultation_fee</label>
                                        <input type="number" class="form-control" id="consultation" name="consultation" >
                                    </div>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <!-- <button  class="close" >Close</button> -->
                                        
                                    
                                  </form>


                          </div>

                      </div>

              </div>

          </div>
          <!--/   INsert Modal end --> 
          <!-- start Update Model  -->
          <div class="modal" id="editModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h2 class="modal-title">Update Doctor</h2>
                      <button type="button " class="close" data-dismiss="modal" arial-label="close">
                        <span arial-hidden="true">&times;</span>
                      </button>

                  </div>
                          <div class="modal-body">
                            <form id="edit_DoctorForm" method="POST" action="">
                              <div class="mb-3">
                                  <label for="edit_doctor_id" class="form-label">Select Doctor</label>
                                  <select name="edit_doctor_id" id="edit_doctor_id" class="form-control">
                                      <option value="">Select doctor</option>
                                  </select>
                              </div>
                              <div class="mb-3">
                                  <label for="edit_special" class="form-label">Specialization</label>
                                  <select name="edit_special" id="edit_special" class="form-control">
                                      <option value="">Select specialization</option>
                                      <option value="Cardiologist">Cardiologist</option>
                                      <option value="Dentist">Dentist</option>
                                  </select>
                              </div>
                              <div class="mb-3">
                                  <label for="edit_availability" class="form-label">Availability</label>
                                  <select name="edit_availability" id="edit_availability" class="form-control">
                                      <option value="">Select Availability</option>
                                      <option value="Saturday to Monday, 9AM - 5PM">Saturday to Monday, 9AM - 5PM</option>
                                      <option value="Monday to Thursday, 9AM - 5PM">Monday to Thursday, 9AM - 5PM</option>
                                  </select>
                              </div>
                              <div class="mb-3">
                                  <label for="edit_consultation" class="form-label">Consultation Fee</label>
                                  <input type="text" class="form-control" id="edit_consultation" name="edit_consultation" readonly>
                              </div>
                              <button type="submit" class="btn btn-primary">Update</button>
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
  <!-- scripts -->
  <script src="../../assets/js/jquery-3.5.1.min.js" rel="stylesheet"></script>
  <script src="../../assets/js/jquery.dataTables.min.js" rel="stylesheet"></script>
  <!-- scripts -->
   <script>
    $(document).ready(function(){
        $('#insertModal').click(function(){
          $('#DoctorModal').modal('show');
          $('#DoctorForm')[0].reset();
        });
        displayData();
        // fetch id users
        //fetch id from member to save user table
        $.get("doctorOperation.php?url=loadData", function (data) {
          const response = JSON.parse(data);

          if (response.Users ) {
            response.Users .forEach(user  => {
              $("#user_id").append(`<option value="${user.user_id}">${user.fullName}</option>`);
            });
          }
        });
        // insert
        $('#DoctorForm').submit(function(e) {
          e.preventDefault();

          // Validate form fields
          let isValid = true;
          $(this).find('input[required], select[required]').each(function() {
              if ($(this).val() === '') {
                  isValid = false;
                  $(this).addClass('is-invalid');
              } else {
                  $(this).removeClass('is-invalid');
              }
          });

          if (!isValid) {
              Swal.fire({
                  title: "Error!",
                  text: "Please fill all required fields.",
                  icon: "error",
                  confirmButtonText: "OK",
              });
              return; // Stop the function if the form is not valid
          }

          // Collect form data
          const user_id = $('#user_id').val();
          const specialization = $('#special').val();
          const availability = $('#availability').val();
          const consultation_fee = $('#consultation').val();
          const url = "doctorOperation.php?url=createDoctor";
          const data = {
              user_id: user_id,
              special: specialization,
              availability: availability,
              consultation: consultation_fee
          };

          // Send AJAX request
          $.post(url, data, function(res) {
              const response = JSON.parse(res); // Parse the JSON response
              if (response.status === 'success') {
                  Swal.fire({
                      title: 'Success!',
                      text: response.message,
                      icon: 'success',
                      confirmButtonText: 'OK',
                  }).then(() => {
                      $('#DoctorModal').modal('hide');
                      $('#DoctorForm')[0].reset();
                      displayData(); // Refresh the data table
                  });
              } else {
                  Swal.fire({
                      title: 'Error!',
                      text: response.message,
                      icon: 'error',
                      confirmButtonText: 'OK',
                  });
              }
          }).fail(function() {
              Swal.fire({
                  title: 'Error!',
                  text: 'An error occurred while submitting the form.',
                  icon: 'error',
                  confirmButtonText: 'OK',
              });
          });
      });
      $(document).on('click', '.editBtn', function(e) {
        // Deji variables ka hor AJAX-ka
        const edit_doctor_id = $(this).data('doctor_id');
        const edit_user_id = $(this).data('user_id');
        const edit_special = $(this).data('special');
        const edit_availability = $(this).data('availability');
        const edit_consultation = $(this).data('consultation');

        $('#edit_doctor_id').empty();

        $.get("doctorOperation.php?url=loadDoctors", function(data) {
            const response = JSON.parse(data);

            if (response.Users) {
                response.Users.forEach(user => {
                    // Isbeddel "user.doctor_id" -> "user.user_id" (waa in user_id la isticmaalo)
                    const selected = user.user_id == edit_user_id ? 'selected' : '';
                    $("#edit_doctor_id").append(`
                        <option value="${user.user_id}" data-fee="${user.consultation_fee}" ${selected}>
                            ${user.fullName}
                        </option>
                    `);
                });

                // Deji qiimaha input fields KADIB AJAX-ka
                $('#edit_doctor_id').val(edit_user_id); // Halkan value waa user_id
                $('#edit_user_id').val(edit_user_id);
                $('#edit_special').val(edit_special);
                $('#edit_availability').val(edit_availability);
                $('#edit_consultation').val(edit_consultation);

                // Ku dar event listener cusub
                $("#edit_doctor_id").on("change", function() {
                    let selectedFee = $(this).find(":selected").data("fee");
                    $("#edit_consultation").val(selectedFee || "");
                });
            }
        });

        $('#editModal').modal('show');
      });
        //function update data 
        $('#edit_DoctorForm').submit(function(e) {
            e.preventDefault();

            // Validate form fields
            let isValid = true;
            $(this).find('input[required], select[required]').each(function() {
                if ($(this).val() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            if (!isValid) {
                Swal.fire({
                    title: "Error!",
                    text: "Please fill all required fields.",
                    icon: "error",
                    confirmButtonText: "OK",
                });
                return;
            }

            // Collect form data
            const formData = $(this).serialize();

            // Send AJAX request
            $.ajax({
                type: 'POST',
                url: 'doctorOperation.php?url=UpdateDoctor',
                data: formData,
                dataType: 'json',
                success: function(result) {
                    if (result.status === 'success') {
                        Swal.fire({
                            title: 'Success!',
                            text: result.message,
                            icon: 'success',
                            confirmButtonText: 'OK',
                        }).then(() => {
                            $('#editModal').modal('hide');
                            $('#edit_DoctorForm')[0].reset();
                            displayData(); // Refresh the data table
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: result.message,
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while updating the doctor.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                    });
                }
            });
        });
        //function delete 
        $(document).on('click', '.deleteBtn', function(e) {
            const userid = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'doctorOperation.php?url=DeleteDoctor',
                        data: { id: userid },
                        dataType: 'json',
                        success: function(res) {
                            if (res.status === 'success') {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: res.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                }).then(() => {
                                    displayData(); // Refresh the data table
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: res.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred while deleting the doctor.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });
                        }
                    });
                }
            });
        });
        //display the Data
        function displayData(){
            $.ajax({
                    url:'doctorOperation.php?url=displayDoctor',
                    success: function(res){
                        const rows = JSON.parse(res);
                        let tableData = '';
                        rows.forEach(rows => {
                            tableData +=`
                            <tr>
                            <td> ${rows.doctor_id}</td>
                            <td> ${rows.fullName}</td>
                            <td> ${rows.specialization}</td>
                            <td> ${rows.availability}</td>
                            <td> ${rows.consultation_fee}</td>
                            <td> ${rows.created_at}</td>
                            <td> 
                            <button class="btn btn-warning btn-sm editBtn" data-doctor_id="${rows.doctor_id}"  data-user_id="${rows.user_id}" data-special="${rows.specialization}" data-availability="${rows.availability}" data-consultation="${rows.consultation_fee}"  >Edit</button>
                            <button class="btn btn-danger btn-sm deleteBtn" data-id="${rows.doctor_id}">Delete</button> 
                            </td> 
                            </tr>`;
                            
                        });
                       
                        if($.fn.DataTable.isDataTable('#dataTable'))
                              {
                                  $('#dataTable').DataTable().clear().destroy();
                              }
                              $('#dataTable tbody').html(tableData);

                              $('#dataTable').DataTable({
                                  
                                  Paging: true,
                                  Searching: true,
                                  ordering: true,
                                  responsive: true
                                  
                              });
                        
                    }
                })
        }
      });
   </script>
   <script src="../../assets/js/bootstrap.bundle.min.js" rel="stylesheet"></script>
  <!-- container-scroller -->
  <!-- base:js -->
  <!-- <script src="../../../vendors/base/vendor.bundle.base.js"></script> -->
  <!-- end inject -->
  <!-- inject:js -->
  <script src="../../../js/off-canvas.js"></script>
  <script src="../../../js/hoverable-collapse.js"></script>
  <script src="../../../js/template.js"></script>
  <!-- end inject -->
  <!-- plugin js for this page -->
  <script src="../../../vendors/chart.js/Chart.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../../../js/chart.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
