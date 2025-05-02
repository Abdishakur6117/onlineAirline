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
              <!-- <div class="card"> -->
                <!-- <div class="card-body"> -->
                  <h2>Feeding Record Form</h2>
                  <button type="button" class="btn btn-primary at-3" id="insertModal">Add FeedingRecord</button>
                  <br>
                  <br>
                  <table id="dataTable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                      <td>ID</td>
                      <td>Children Name</td>
                      <td>Program Name</td>
                      <td>Meal Name</td>
                      <td>Feeding Date</td>
                      <td>Quantity</td>
                      <td>Remarks</td>
                      <td>User Name</td>
                      <td>Created at</td>
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
          <div class="modal fade" id="feedingRecordModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" >Add New Feeding Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="feedingRecordForm" method="POST" action="" >
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="staff">Children Name </label>
                            <select class="form-control"  name="children_id" id="children_id">
                              <option value="">Select Children</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="gender">Feeding Program Name </label>
                            <select class="form-control" name="feeding_program_id" id="feeding_program_id">
                              <option value="">Select Feeding Program</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="position">Meal Name </label>
                            <select class="form-control" name="meal_id" id="meal_id">
                              <option value="">Select Meal</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="quantity">Quantity </label>
                            <input type="text" class="form-control" id="quantity" name="quantity">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="remarks">Remarks </label>
                            <input type="text" class="form-control" id="remarks" name="remarks">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="email">User Name </label>
                            <select class="form-control" name="user_id" id="user_id">
                              <option value="">Select User</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" >Save</button>
                      </div>
                    </form> 
                  </div>
                          

                </div>

              </div>

          </div>
          <!--/   INsert Modal end --> 

          <!-- start Update Model  -->
          <div class="modal fade" id="edit_feedingRecordModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" >Update  feeding Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="edit_feedingRecordForm" method="POST" action="" >
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="staff">Children Name </label>
                            <input type="hidden" class="form-control" id="edit_id" name="edit_id">
                            <select class="form-control"  name="edit_children_id" id="edit_children_id">
                              <option value="">Select Children</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="gender">Feeding Program Name </label>
                            <select class="form-control" name="edit_feeding_program_id" id="edit_feeding_program_id">
                              <option value="">Select Feeding Program</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="position">Meal Name </label>
                            <select class="form-control" name="edit_meal_id" id="edit_meal_id">
                              <option value="">Select Meal</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="quantity">Quantity </label>
                            <input type="text" class="form-control" id="edit_quantity" name="edit_quantity">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="remarks">Remarks </label>
                            <input type="text" class="form-control" id="edit_remarks" name="edit_remarks">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="email">User Name </label>
                            <select class="form-control" name="edit_user_id" id="edit_user_id">
                              <option value="">Select User</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="date">Feeding Date </label>
                            <input type="date" class="form-control" id="edit_feedingDate" name="edit_feedingDate">
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
          $('#feedingRecordModal').modal('show');
          $('#feedingRecordForm')[0].reset();
      });
      
      // Initial data loading
      displayData();
      loadChildren();
      loadFeedingProgram();
      loadMeal();
      loadUser();
      // Load children for dropdown
      function loadChildren() {
          $.ajax({
              url: 'feeding_recordOpera.php?action=get_children',
              method: 'GET',
              dataType: 'json',
              success: function(response) {
                  if(response.status === 'success' && response.data) {
                      const $select = $('#children_id, #edit_children_id');
                      $select.empty().append('<option value="">Select Children</option>');
                      
                      response.data.forEach(children => {
                          $select.append($('<option>', {
                              value: children.id,
                              text: children.full_name
                          }));
                      });
                  } else {
                      showError('Failed to load children');
                  }
              },
              error: function() {
                  showError('Network error loading children');
              }
          });
      }
      // Load feeding program for dropdown
      function loadFeedingProgram() {
          $.ajax({
              url: 'feeding_recordOpera.php?action=get_feedingProgram',
              method: 'GET',
              dataType: 'json',
              success: function(response) {
                  if(response.status === 'success' && response.data) {
                      const $select = $('#feeding_program_id, #edit_feeding_program_id');
                      $select.empty().append('<option value="">Select Feeding program</option>');
                      
                      response.data.forEach(feedingProgram => {
                          $select.append($('<option>', {
                              value: feedingProgram.id,
                              text: feedingProgram.program_name
                          }));
                      });
                  } else {
                      showError('Failed to load feeding program');
                  }
              },
              error: function() {
                  showError('Network error loading feeding program');
              }
          });
      }

      // Load meals  for dropdown
      function loadMeal() {
          $.ajax({
              url: 'feeding_recordOpera.php?action=get_meals',
              method: 'GET',
              dataType: 'json',
              success: function(response) {
                  if(response.status === 'success' && response.data) {
                      const $select = $('#meal_id, #edit_meal_id');
                      $select.empty().append('<option value="">Select  Meal</option>');
                      
                      response.data.forEach(meal => {
                          $select.append($('<option>', {
                              value: meal.id,
                              text: meal.meal_name
                          }));
                      });
                  } else {
                      showError('Failed to load  Meals');
                  }
              },
              error: function() {
                  showError('Network error loading Meals');
              }
          });
      }

      // Load users  for dropdown
      function loadUser() {
          $.ajax({
              url: 'feeding_recordOpera.php?action=get_user',
              method: 'GET',
              dataType: 'json',
              success: function(response) {
                  if(response.status === 'success' && response.data) {
                      const $select = $('#user_id, #edit_user_id');
                      $select.empty().append('<option value="">Select  Users</option>');
                      
                      response.data.forEach(user => {
                          $select.append($('<option>', {
                              value: user.id,
                              text: user.username
                          }));
                      });
                  } else {
                      showError('Failed to load  users');
                  }
              },
              error: function() {
                  showError('Network error loading users');
              }
          });
      }
      
      // Create feeding record record
      $('#feedingRecordForm').submit(function(e) {
          e.preventDefault();
          
          $.ajax({
              type: 'POST',
              url: 'feeding_recordOpera.php?action=create_feeding_record',
              data: $(this).serialize(),
              dataType: "json",
              success: function(res) {
                  if (res.status === 'success') {
                      showSuccess(res.message, function() {
                          $('#feedingRecordModal').modal('hide');
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
          const feedingRecordData = {
              id: $(this).data('id'),
              beneficiary_id: $(this).data('beneficiary_id'),
              feeding_program_id: $(this).data('feeding_program_id'),
              meal_id: $(this).data('meal_id'),
              quantity: $(this).data('quantity'),
              remarks: $(this).data('remarks'),
              feeding_date: $(this).data('feeding_date'),
              recorded_by: $(this).data('recorded_by')
          };
          
          $('#edit_id').val(feedingRecordData.id);
          $('#edit_children_id').val(feedingRecordData.beneficiary_id);
          $('#edit_feeding_program_id').val(feedingRecordData.feeding_program_id);
          $('#edit_meal_id').val(feedingRecordData.meal_id);
          $('#edit_feedingDate').val(feedingRecordData.feeding_date);
          $('#edit_quantity').val(feedingRecordData.quantity);
          $('#edit_remarks').val(feedingRecordData.remarks);
          $('#edit_user_id').val(feedingRecordData.recorded_by);
          
          $('#edit_feedingRecordModal').modal('show');
      });
      // Update this part in your JavaScript
      $('#edit_feedingRecordForm').submit(function(e) {
          e.preventDefault();
          const submitBtn = $(this).find('[type="submit"]');
          submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
          
          // Prepare data with correct field names
          const formData = {
              edit_id: $('#edit_id').val(),
              edit_children_id: $('#edit_children_id').val(),
              edit_feeding_program_id: $('#edit_feeding_program_id').val(),
              edit_meal_id: $('#edit_meal_id').val(),
              edit_feedingDate: $('#edit_feedingDate').val(),
              edit_quantity: $('#edit_quantity').val(),
              edit_remarks: $('#edit_remarks').val(),
              edit_user_id: $('#edit_user_id').val()
          };
          
          $.ajax({
              url: 'feeding_recordOpera.php?action=update_feeding_record',
              method: 'POST',
              data: formData,
              dataType: 'json',
              success: function(response) {
                  if(response.status === 'success') {
                      showSuccess(response.message, function() {
                          $('#edit_feedingRecordModal').modal('hide');
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
                  submitBtn.prop('disabled', false).html('Update Feeding Record');
              }
          });
      });
      
      // Delete attendance record
      $(document).on('click', '.deleteBtn', function() {
          const feedingRecord_id = $(this).data('id');
          
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
                      url: 'feeding_recordOpera.php?action=delete_feeding_record',
                      data: { id: feedingRecord_id },
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
              url: 'feeding_recordOpera.php?action=display_feeding_record',
              dataType: 'json',
              success: function(rows) {
                  let tableData = '';
                  rows.forEach(row => {
                      tableData += `
                      <tr>
                          <td>${row.id}</td>
                          <td>${row.children_name}</td>
                          <td>${row.feeding_program_name}</td>
                          <td>${row.meal_name}</td>
                          <td>${row.feeding_date}</td>
                          <td>${row.quantity}</td>
                          <td>${row.remarks}</td>
                          <td>${row.user_name}</td>
                          <td>${row.created_at}</td>
                          <td>
                              <button class="btn btn-warning btn-sm editBtn" 
                                  data-id="${row.id}" 
                                  data-beneficiary_id="${row.beneficiary_id}"
                                  data-feeding_program_id="${row.feeding_program_id}"
                                  data-meal_id="${row.meal_id}"
                                  data-feeding_date="${row.feeding_date}"
                                  data-quantity="${row.quantity}"
                                  data-remarks="${row.remarks}"
                                  data-recorded_by="${row.recorded_by}">
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
