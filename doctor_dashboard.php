<?php
session_start();

// Check if the user is logged in and has the 'Admin' role
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'Doctor') {
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
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css"/>
  <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="vendors/jquery-bar-rating/fontawesome-stars-o.css">
  <link rel="stylesheet" href="vendors/jquery-bar-rating/fontawesome-stars.css">
  <script src="pages/assets/js/jquery-3.5.1.min.js"></script>
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
  <style>
.sidebar {
  position: fixed;
  top: 5;
  bottom: 0;
  left: 0;
  z-index: 1000;
  transition: all 0.3s;
}

/* Main content adjustment */
.main-panel {
  margin-left: 240px;
  transition: all 0.3s;
}



/* Footer adjustment */
.footer {
  width: calc(100% - 280px);
  margin-left: 280px;
  transition: all 0.3s;
}


  </style>

</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
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
              <a class="dropdown-item preview-item hover:cursor-pointer" href="pages/Doctor/Profile/Profile.php">               
                  <i class="icon-head"></i>
                  <span class="menu-title">Profile</span> 
              </a>
              <a class="dropdown-item preview-item cursor-pointer" href="logout.php">
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
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav mt-5 overflow-hidden">
          <li class="nav-item">
            <a class="nav-link" href="doctor_dashboard.php">
              
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/Doctor/Patients/Patients.php">
              <!-- <i class="icon-pie-graph menu-icon"></i> -->
              <span class="menu-title">Patients</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/Doctor/Appointments/AllAppointment.php">
              <!-- <i class="icon-pie-graph menu-icon"></i> -->
              <span class="menu-title">Appointments</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/Doctor/Payments/Payments.php">
              <!-- <i class="icon-help menu-icon"></i> -->
              <span class="menu-title">Payments</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/Doctor/Reports/Reports.php">
              <!-- <i class="icon-book menu-icon"></i> -->
              <span class="menu-title">Reports</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <h2 class="text-center mb-4">Recent Data</h2>

          <div class="row">
              <!-- Recent Patients Table -->
              <div class="col-md-6">
                  <div class="card shadow">
                      <div class="card-header bg-primary text-white">
                          <h5 class="mb-0">Recent Patients (Last 4)</h5>
                      </div>
                      <div class="card-body">
                          <table class="table table-striped">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>Name</th>
                                      <th>Email</th>
                                      <th>Phone</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody id="recentPatientsTable">
                                  <tr>
                                      <!-- <td colspan="5" class="text-center">Loading...</td> -->
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>

              <!-- Recent Appointments Table -->
              <div class="col-md-6">
                  <div class="card shadow">
                      <div class="card-header bg-success text-white">
                          <h5 class="mb-0">Recent Appointments (Last 4)</h5>
                      </div>
                      <div class="card-body">
                          <table class="table table-striped">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>Doctor</th>
                                      <th>Date</th>
                                      <th>Status</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody id="recentAppointmentsTable">
                                  <tr>
                                      <!-- <td colspan="5" class="text-center">Loading...</td> -->
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard templates</a> from Bootstrapdash.com</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <script>
    $(document).ready(function() {
        $.get("get_recent_data.php", function(response) {
            let data = JSON.parse(response);

            // Populate Recent Patients Table
            let patientsHtml = "";
            if (data.recentPatients.length > 0) {
                data.recentPatients.forEach((patient, index) => {
                    patientsHtml += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${patient.name}</td>
                            <td>${patient.email}</td>
                            <td>${patient.phone}</td>
                            <td><button class="btn btn-sm btn-primary">View</button></td>
                        </tr>
                    `;
                });
            } else {
                // Corrected line
                patientsHtml = `<tr><td colspan="5" class="text-center">No recent patients</td></tr>`;
            }
            $("#recentPatientsTable").html(patientsHtml);

            // Populate Recent Appointments Table
            let appointmentsHtml = "";
            if (data.recentAppointments.length > 0) {
                data.recentAppointments.forEach((appointment, index) => {
                    appointmentsHtml += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${appointment.doctor_name}</td>
                            <td>${appointment.date}</td>
                            <td>${appointment.status}</td>
                            <td><button class="btn btn-sm btn-success">View</button></td>
                        </tr>
                    `;
                });
            } else {
                // Corrected line
                appointmentsHtml = `<tr><td colspan="5" class="text-center">No recent appointments</td></tr>`;
            }
            $("#recentAppointmentsTable").html(appointmentsHtml);
        });
    });

  </script>
  <!-- base:js -->
  <script src="vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

