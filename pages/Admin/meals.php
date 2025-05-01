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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <a class="nav-link" href="../../index.php">
              <i class="fas fa-tachometer-alt menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/Admin/children.php">
              <i class="fas fa-child menu-icon"></i>
              <span class="menu-title">Children</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/Admin/feeding.php">
              <i class="fas fa-utensils menu-icon"></i>
              <span class="menu-title">Feeding Program</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/Admin/meals.php">
              <i class="fas fa-hamburger menu-icon"></i>
              <span class="menu-title">Meals</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/Admin/staff.php">
              <i class="fas fa-user-tie menu-icon"></i>
              <span class="menu-title">Staff</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/Admin/users.php">
              <i class="fas fa-users-cog menu-icon"></i>
              <span class="menu-title">Users</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/Admin/feeding_record.php">
              <i class="fas fa-notes-medical menu-icon"></i>
              <span class="menu-title">Feeding Records</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/Admin/nutrition.php">
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
                  <a class="nav-link" href="../../pages/Admin/childrenReport.php">Children Reports</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="../../pages/Admin/staffReport.php">Staff Reports</a>
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
              <!-- <div class="card"> -->
                <!-- <div class="card-body"> -->
                  <h2>Meals Form</h2>
                  <button type="button" class="btn btn-primary at-3" id="insertModal">Add Meals</button>
                  <br>
                  <br>
                  <table id="dataTable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                      <td>ID</td>
                      <td>Meal Name</td>
                      <td>Meal Description</td>
                      <td>Calories</td>
                      <td>Actions</td>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                <!-- </div> -->
              <!-- </div> -->
          </div> 
          <!--/   INsert Modal start -->
          <div class="modal fade" id="mealModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" >Add New Meals</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="mealForm" method="POST" action="" >
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="program">Meal Name </label>
                            <input type="text" class="form-control" id="meal_name" name="meal_name">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="description">Meal Description </label>
                            <input type="text" class="form-control" id="meal_description" name="meal_description">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="start">Calories </label>
                            <input type="number" class="form-control" id="calories" name="calories">
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" >Save</button>
                      </div>
                    </form> 
                  </div>
                          

                </div>

              </div>

          </div>
          <!--/   INsert Modal end --> 

          <!-- start Update Model  -->
          <div class="modal fade" id="edit_mealModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" >Update  Meals</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="edit_mealForm" method="POST" action="" >
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="program">Meal Name </label>
                            <input type="hidden" class="form-control" id="edit_id" name="edit_id">
                            <input type="text" class="form-control" id="edit_meal_name" name="edit_meal_name">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="description">Meal Description </label>
                            <input type="text" class="form-control" id="edit_meal_description" name="edit_meal_description">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="start">Calories </label>
                            <input type="number" class="form-control" id="edit_calories" name="edit_calories">
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" >Update</button>
                      </div>
                    </form> 
                  </div>
                          

                </div>

              </div>

          </div>
          <!-- Ends Update Model  -->
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
    $(document).ready(function() {
      // Initialize modals and load data
      $('#insertModal').click(function() {
          $('#mealModal').modal('show');
          $('#mealForm')[0].reset();
      });
      
      // Initial data loading
      displayData();
      
      // Create attendance record
      $('#mealForm').submit(function(e) {
          e.preventDefault();
          
          $.ajax({
              type: 'POST',
              url: 'mealsOperation.php?action=create_meal',
              data: $(this).serialize(),
              dataType: "json",
              success: function(res) {
                  if (res.status === 'success') {
                      showSuccess(res.message, function() {
                          $('#mealModal').modal('hide');
                          displayData();
                      });
                  } else {
                      showError(res.message);
                  }
              },
              error: function() {
                  showError('An error occurred while submitting the form.');
              }
          });
      });
      
      // Edit attendance record
      $(document).on('click', '.editBtn', function() {
          const mealData = {
              id: $(this).data('id'),
              name: $(this).data('name'),
              description: $(this).data('meal_description'),
              calories: $(this).data('calories')
          };
          
          $('#edit_id').val(mealData.id);
          $('#edit_meal_name').val(mealData.name);
          $('#edit_meal_description').val(mealData.description);
          $('#edit_calories').val(mealData.calories);
          
          $('#edit_mealModal').modal('show');
      });
      // Update this part in your JavaScript
      $('#edit_mealForm').submit(function(e) {
          e.preventDefault();
          const submitBtn = $(this).find('[type="submit"]');
          submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
          
          // Prepare data with correct field names
          const formData = {
              edit_id: $('#edit_id').val(),
              edit_meal_name: $('#edit_meal_name').val(),
              edit_meal_description: $('#edit_meal_description').val(),
              edit_calories: $('#edit_calories').val()
          };
          
          $.ajax({
              url: 'mealsOperation.php?action=update_meal',
              method: 'POST',
              data: formData,
              dataType: 'json',
              success: function(response) {
                  if(response.status === 'success') {
                      showSuccess(response.message, function() {
                          $('#edit_mealModal').modal('hide');
                          displayData();
                      });
                  } else {
                      showError(response.message);
                  }
              },
              error: function(xhr) {
                  showError('An error occurred: ' + xhr.statusText);
              },
              complete: function() {
                  submitBtn.prop('disabled', false).html('Update meal');
              }
          });
      });
      
      // Delete attendance record
      $(document).on('click', '.deleteBtn', function() {
          const meal_id = $(this).data('id');
          
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
                      url: 'mealsOperation.php?action=delete_meal',
                      data: { id: meal_id },
                      dataType: 'json',
                      success: function(res) {
                          if (res.status === 'success') {
                              showSuccess(res.message, function() {
                                  displayData();
                              });
                          } else {
                              showError(res.message);
                          }
                      },
                      error: function() {
                          showError('An error occurred while deleting.');
                      }
                  });
              }
          });
      });
      
      // Display attendance data in table
      function displayData() {
          $.ajax({
              url: 'mealsOperation.php?action=display_meals',
              dataType: 'json',
              success: function(rows) {
                  let tableData = '';
                  rows.forEach(row => {
                      tableData += `
                      <tr>
                          <td>${row.id}</td>
                          <td>${row.meal_name}</td>
                          <td>${row.meal_description}</td>
                          <td>${row.calories}</td>
                          <td>
                              <button class="btn btn-warning btn-sm editBtn" 
                                  data-id="${row.id}" 
                                  data-name="${row.meal_name}"
                                  data-meal_description="${row.meal_description}"
                                  data-calories="${row.calories}">
                                  Edit
                              </button>
                              <button class="btn btn-danger btn-sm deleteBtn" 
                                  data-id="${row.id}">
                                  Delete
                              </button>
                          </td>
                      </tr>`;
                  });
                  
                  if($.fn.DataTable.isDataTable('#dataTable')) {
                      $('#dataTable').DataTable().destroy();
                  }
                  
                  $('#dataTable tbody').html(tableData);
                  initDataTable();
              },
              error: function() {
                  showError('Failed to load feeding program data');
              }
          });
      }
      
      // Initialize DataTable
      function initDataTable() {
          $('#dataTable').DataTable({
              paging: true,
              searching: true,
              ordering: true,
              responsive: true
          });
      }
      
      // Helper function to show success messages
      function showSuccess(message, callback) {
          Swal.fire({
              title: 'Success!',
              text: message,
              icon: 'success',
              confirmButtonText: 'OK',
              timer: 3000
          }).then(callback);
      }
      
      // Helper function to show error messages
      function showError(message) {
          Swal.fire({
              title: 'Error!',
              text: message,
              icon: 'error',
              confirmButtonText: 'OK'
          });
      }
    });
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
