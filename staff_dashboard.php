<?php
session_start();

// Check if the user is logged in and has the 'Staff' role
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'Staff') {
    // Redirect to login page if not logged in or not an Staff
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
  <title>Online Feeding Management System</title>
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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
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
              <p class="mb-0 font-weight-normal float-left dropdown-header">username: <?= htmlspecialchars($_SESSION['username']); ?></p>
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
            <a class="nav-link" href="staff_dashboard.php">
              <i class="fas fa-tachometer-alt menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/Staff/children.php">
              <i class="fas fa-child menu-icon"></i>
              <span class="menu-title">Children</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/Staff/feeding_record.php">
              <i class="fas fa-notes-medical menu-icon"></i>
              <span class="menu-title">Feeding Records</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/Staff/nutrition.php">
              <i class="fas fa-heartbeat menu-icon"></i>
              <span class="menu-title">Nutrition Assessments</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basics" aria-expanded="false" aria-controls="ui-basics">
              <i class="fas fa-chart-line menu-icon"></i>
              <span class="menu-title">Reports</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basics">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="pages/Staff/childrenReport.php">Children Reports</a>
                </li>
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
              <!-- Total Children -->
              <div class="col-md-3">
                  <div class="card text-white bg-primary mb-3 shadow">
                      <div class="card-body text-center">
                          <i class="fas fa-child fa-2x"></i>
                          <h5 class="card-title mt-2">Total Children</h5>
                          <h3 id="totalChildren">0</h3>
                      </div>
                  </div>
              </div>

              <!-- Total Feeding Records -->
              <div class="col-md-4">
                  <div class="card text-white bg-secondary mb-3 shadow">
                      <div class="card-body text-center">
                          <i class="fas fa-clipboard-list fa-2x"></i>
                          <h5 class="card-title mt-2">Total Feeding Records</h5>
                          <h3 id="totalFeedingRecords">0</h3>
                      </div>
                  </div>
              </div>

              <!-- Total Nutrition Assessments -->
              <div class="col-md-4">
                  <div class="card text-white bg-dark mb-3 shadow">
                      <div class="card-body text-center">
                          <i class="fas fa-notes-medical fa-2x"></i>
                          <h5 class="card-title mt-2">Total Nutrition Assessments</h5>
                          <h3 id="totalNutritionAssessments">$0</h3>
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
        $.get("get_staff.php", function(response) {
            let data = JSON.parse(response);
            $("#totalChildren").text(data.totalChildren);
            $("#totalFeedingRecords").text(data.totalFeedingRecords);
            $("#totalNutritionAssessments").text(data.totalNutritionAssessments);
        });
    });

  </script>
  <!-- container-scroller -->

  <!-- base:js -->
  <script src="vendors/base/vendor.bundle.base.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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

