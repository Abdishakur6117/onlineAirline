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
  <link rel="stylesheet" href="../../assets/css/jquery.dataTables.min.css" >
  <script src="../../assets/js/sweetalert.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- end links assets -->
  <style>
    .footer {
      position: fixed;
      bottom: 0;
      width: calc(118% - 280px); /* Default width marka sidebar furan */
      transition: width 0.3s ease-in-out;
    }

    /* Ensure forms stack vertically on smaller screens */
    .form-container {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .form-container .form {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Make forms take up full width on small screens */
    @media (max-width: 768px) {
      .form-container .form {
        width: 100%;
      }
    }

    /* Add a small margin between forms */
    .form-container .form + .form {
      margin-top: 20px;
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
              <a class="dropdown-item preview-item hover:cursor-pointer" href="profile.php">               
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
      <div class="main-panel">        
        <div class="content-wrapper">
          <div class="row justify-content-center width-full">
            <!-- Forms Container -->
            <div class="col-md-8 form-container">
              <!-- Update Profile Form -->
              <div class="form">
                <h4 class="mb-3 text-center">Update Profile</h4>
                <form id="updateProfileForm">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <!-- Pre-fill the input with current username -->
                        <input type="text" id="username" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <!-- Pre-fill the input with current email -->
                        <input type="email" id="email" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                </form>

              </div>

              <!-- Update Password Form -->
              <div class="form">
                <h4 class="mb-3 text-center">Update Password</h4>
                <form id="updatePasswordForm">
                    <div class="mb-3">
                        <label class="form-label">Old Password</label>
                        <input type="password" id="oldPassword" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" id="newPassword" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" id="confirmPassword" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Update Password</button>
                </form>
              </div>
            </div>
          </div> 
        </div>
        <footer class="footer bg-light text-center py-3">
          <div class="container">
              <span class="text-muted">Copyright © bootstrap.com 2025</span>
          </div>
        </footer>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="../../assets/js/jquery-3.5.1.min.js"></script>
  <script src="../../assets/js/jquery.dataTables.min.js"></script>
  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
  <script>
    // Function to show SweetAlert
    function showAlert(status, message) {
        if (status === "success") {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: message,
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
                timer: 3000 // Auto-close after 3 seconds
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: message,
                confirmButtonText: 'Try Again',
                confirmButtonColor: '#d33',
                timer: 3000 // Auto-close after 3 seconds
            });
        }
    }

      $("#updateProfileForm").submit(function(e) {
          e.preventDefault();
          $.post("update_profile.php", {
              username: $("#username").val(),
              email: $("#email").val()
          }, function(response) {
               let res = JSON.parse(response);
            showAlert(res.status, res.message);
          });
      });

      $("#updatePasswordForm").submit(function(e) {
          e.preventDefault();
          let newPassword = $("#newPassword").val();
          let confirmPassword = $("#confirmPassword").val();

          if (newPassword !== confirmPassword) {
             showAlert("error", "Passwords do not match!"); // Show error if passwords don't match
            return;
          }

          $.post("update_password.php", {
              oldPassword: $("#oldPassword").val(),
              newPassword: newPassword
          }, function(response) {
              let res = JSON.parse(response);
                showAlert(res.status, res.message);
                
          });
      });
  </script>
</body>

</html>
