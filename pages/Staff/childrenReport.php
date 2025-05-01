<?php
session_start();

// Check if the user is logged in and has the 'Admin' role
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'Staff') {
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
  <title>Online Feeding Management System</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- end inject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../vendors/select2/select2.min.css">
  <link rel="stylesheet" href="../../vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- links assets -->
  <!-- <link rel="stylesheet" href="../assets/css/bootstrap.min.css" > -->
  <link rel="stylesheet" href="../assets/css/jquery.dataTables.min.css" >
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
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
    <!-- partial:../../partials/_navbar.html -->
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
              <a class="dropdown-item preview-item cursor-pointer" href="../../logout.php">
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
      <!-- partial:../../partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav mt-5">
          <li class="nav-item">
            <a class="nav-link" href="../../staff_dashboard.php">
              <i class="fas fa-tachometer-alt menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/Staff/children.php">
              <i class="fas fa-child menu-icon"></i>
              <span class="menu-title">Children</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/Staff/feeding_record.php">
              <i class="fas fa-notes-medical menu-icon"></i>
              <span class="menu-title">Feeding Records</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/Staff/nutrition.php">
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
                  <a class="nav-link" href="../../pages/Staff/childrenReport.php">Children Reports</a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">        
        <div class="content-wrapper">
          <div class="body">
                  <label for="Employee">Children:</label><br>
                  <input type="text" id="children_name" placeholder="Enter Children Name">
                  <button onclick="searchChildren()">Search</button>
                  <table id="children_table" class=" display nowrap"  style="width:100%; display:none;">
                    <thead>
                    <tr>
                      <td>ID</td>
                      <td>Children Name</td>
                      <td> Gender</td>
                      <td>Date of Birth</td>
                      <td>Parent Name</td>
                      <td>Parent Number</td>
                      <td>Address</td>
                      <td>Registration Date</td>
                      <td>Actions</td>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
          </div> 
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
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
  <script src="../assets/js/jquery-3.5.1.min.js" rel="stylesheet"></script>
  <script src="../assets/js/jquery.dataTables.min.js" rel="stylesheet"></script>
 <!-- scripts -->
  <!-- container-scroller -->
   <!-- scripts -->


  <script>
    let childrenTable;

    function searchChildren() {
        const searchTerm = $('#children_name').val();
        
        if (!childrenTable) {
            childrenTable = $('#children_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: 'fetch_children.php',
                    type: 'POST',
                    data: function(d) {
                        d.searchTerm = searchTerm;
                    }
                },
                columns: [
                    { data: 'id' },
                    { data: 'full_name' },
                    { data: 'gender' },
                    { data: 'date_of_birth' },
                    { data: 'parent_name' },
                    { data: 'parent_number' },
                    { data: 'address' },
                    { data: 'registration_date' },
                    { 
                        data: null,
                        render: function(data, type, row) {
                            return `<button class="btn btn-primary" onclick="report(${row.id})">View</button>`;
                        }
                    }
                ],
                paging: true,
                searching: true,
                ordering: true,
                responsive: true,
                initComplete: function() {
                    $('#children_table').show();
                }
            });
        } else {
            childrenTable.ajax.reload();
        }
    }
    function report(id) {
        window.open('children_print.php?id=' + id, '_blank');
    }
  </script>
     <script src="../assets/js/bootstrap.bundle.min.js" rel="stylesheet"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <!-- end scripts -->
  <!-- base:js -->
  <!-- <script src="../../vendors/base/vendor.bundle.base.js"></script> -->
  <!-- end inject -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <!-- end inject -->
  <!-- plugin js for this page -->
  <script src="../../vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="../../vendors/select2/select2.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../../js/file-upload.js"></script>
  <script src="../../js/typeahead.js"></script>
  <script src="../../js/select2.js"></script>
  <!-- End custom js for this page -->
</body>

</html>
