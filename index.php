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
        <h2 class="text-3xl mt-5 text-black p-3 overflow-hidden"> Doctor Appointment System</h2>
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
              <a class="dropdown-item preview-item hover:cursor-pointer" href="pages/Admin/Profile/profile.php">               
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
        <ul class="nav mt-5">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="icon-box menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/Admin/Users/Users.php">
              <!-- <i class="icon-file menu-icon"></i> -->
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Users</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/Admin/Doctors/Doctors.php">
              <!-- <i class="icon-file menu-icon"></i> -->
              <span class="menu-title">Doctors</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/Admin/Patients/Patients.php">
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
                <li class="nav-item"> <a class="nav-link" href="pages/Admin/AcceptAppointment/Accept.php">Accept Appointment</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/Admin/RejectAppointment/Reject.php">Reject Appointment</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/Admin/Appointments/AllAppointment.php">All Appointment</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/Admin/Payments/Payments.php">
              <!-- <i class="icon-help menu-icon"></i> -->
              <span class="menu-title">Payments</span>
            </a>

            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basics" aria-expanded="false" aria-controls="ui-basics">
                <!-- <i class="icon-disc menu-icon"></i> -->
                <span class="menu-title">Reports</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="ui-basics">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="pages/Admin/Reports/DoctorReport.php"> Doctor of Reports </a></li>
                  <li class="nav-item"> <a class="nav-link" href="pages/Admin/Reports/PatientReport.php">Patient of  Report</a></li>
                </ul>
              </div>
            </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
                  <h2 class="text-center mb-4">Dashboard Overview</h2>
        <div class="row">
            <!-- Total Users -->
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3 shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-2x"></i>
                        <h5 class="card-title mt-2">Total Users</h5>
                        <h3 id="totalUsers">0</h3>
                    </div>
                </div>
            </div>

            <!-- Total Doctors -->
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3 shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-user-md fa-2x"></i>
                        <h5 class="card-title mt-2">Total Doctors</h5>
                        <h3 id="totalDoctors">0</h3>
                    </div>
                </div>
            </div>

            <!-- Total Patients -->
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3 shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-procedures fa-2x"></i>
                        <h5 class="card-title mt-2">Total Patients</h5>
                        <h3 id="totalPatients">0</h3>
                    </div>
                </div>
            </div>

            <!-- Total Appointments -->
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3 shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-check fa-2x"></i>
                        <h5 class="card-title mt-2">Total Appointments</h5>
                        <h3 id="totalAppointments">0</h3>
                    </div>
                </div>
            </div>

            <!-- Total Appointment Accepted -->
            <div class="col-md-4">
                <div class="card text-white bg-info mb-3 shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                        <h5 class="card-title mt-2">Appointments Accepted</h5>
                        <h3 id="totalAccepted">0</h3>
                    </div>
                </div>
            </div>

            <!-- Total Appointment Rejected -->
            <div class="col-md-4">
                <div class="card text-white bg-secondary mb-3 shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-times-circle fa-2x"></i>
                        <h5 class="card-title mt-2">Appointments Rejected</h5>
                        <h3 id="totalRejected">0</h3>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="col-md-4">
                <div class="card text-white bg-dark mb-3 shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-dollar-sign fa-2x"></i>
                        <h5 class="card-title mt-2">Total Revenue</h5>
                        <h3 id="totalRevenue">$0</h3>
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
  <script>
        $(document).ready(function() {
            $.get("get_dashboard_data.php", function(response) {
                let data = JSON.parse(response);
                $("#totalUsers").text(data.totalUsers);
                $("#totalDoctors").text(data.totalDoctors);
                $("#totalPatients").text(data.totalPatients);
                $("#totalAppointments").text(data.totalAppointments);
                $("#totalAccepted").text(data.totalAccepted);
                $("#totalRejected").text(data.totalRejected);
                $("#totalRevenue").text(data.totalRevenue);
            });
        });
    </script>
  <!-- container-scroller -->

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

