<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Regal Admin</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- end inject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- end inject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
  <link rel="stylesheet" href="../assets/css/jquery.dataTables.min.css" >
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
          <li class="nav-item dropdown d-flex">
            <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">
              <!-- <i class="icon-air-play mx-0"></i> -->
              <i class="icon-bell"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Notification</p>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <img src="../../images/faces/face4.jpg" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h6 class="preview-subject ellipsis font-weight-normal">David Grey
                  </h6>
                  <p class="font-weight-light small-text text-muted mb-0">
                    The meeting is cancelled
                  </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <img src="../../images/faces/face2.jpg" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h6 class="preview-subject ellipsis font-weight-normal">Tim Cook
                  </h6>
                  <p class="font-weight-light small-text text-muted mb-0">
                    New product launch
                  </p>
                </div>
              </a>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <img src="../../images/faces/face3.jpg" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content flex-grow">
                  <h6 class="preview-subject ellipsis font-weight-normal"> Johnson
                  </h6>
                  <p class="font-weight-light small-text text-muted mb-0">
                    Upcoming board meeting
                  </p>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item dropdown d-flex mr-4 ">
            <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-toggle="dropdown">
              <!-- <i class="icon-cog"></i> -->
              <i class="icon-head"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Profile</p>
              <a class="dropdown-item preview-item hover:cursor-pointer" href="profile.php">               
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
      <!-- partial:../../partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="user-profile">
          <div class="user-image">
            <img src="../../images/faces/face28.png">
          </div>
          <div class="user-name">
              Edward Spencer
          </div>
          <div class="user-designation">
              Developer
          </div>
        </div>
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="../../index.php">
              <i class="icon-box menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/Users/Users.php">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Users</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/Doctors/Doctors.php">
              <!-- <i class="icon-pie-graph menu-icon"></i> -->
              <span class="menu-title">Doctors</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/Patients/Patients.php">
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
                <li class="nav-item"> <a class="nav-link" href="../../pages/AcceptAppointment/Accept.php">Accept Appointment</a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/RejectAppointment/Reject.php">Reject Appointment</a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/Appointments/AllAppointment.php">All Appointment</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/Payments/Payments.php">
              <!-- <i class="icon-help menu-icon"></i> -->
              <span class="menu-title">Payments</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/Reports/Reports.php">
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
            <h2>Patient Form</h2>
            <button type="button" class="btn btn-primary at-3" id="insertModal">Add Patient</button>
            <br>
            <br>
            <table id="dataTable" class="table table-striped table-bordered">
              <thead>
              <tr>
                <td>patient_id  </td>
                <td>Patient Name </td>
                <td>date_of_birth  </td>
                <td>gender</td>
                <td>blood_type  </td>
                <td>address</td>
                <td>registration_date</td>
                <td>Actions</td>
              </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
        <!--/   INsert Modal start -->
        <div class="modal" id="PatientModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h2 class="modal-title">Add Patient</h2>
                      <button type="button " class="close" data-dismiss="modal" arial-label="close">
                        <span arial-hidden="true">&times;</span>
                      </button>

                  </div>
                          <div class="modal-body">
                                  <form id="PatientForm" method="POST" action="">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">user_id</label>
                                        <select name="user_id" id="user_id" class="form-control">
                                          <option value="">Select Users</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="date" class="form-label">date_of_birth</label>
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="text" class="form-label">gender</label>
                                        <select name="gender" id="gender" class="form-control">
                                          <option value="">select  Gender</option>
                                          <option value="Male">Male</option>
                                          <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="number" class="form-label">blood_type</label>
                                        <select name="bloodType" id="bloodType" class="form-control">
                                          <option value="">select Blood Type </option>
                                          <option value="A+">A+</option>
                                          <option value="A-">A-</option>
                                          <option value="B+">B+</option>
                                          <option value="B-">B-</option>
                                          <option value="O+">O+</option>
                                          <option value="O-">O-</option>
                                          <option value="AB+">AB+</option>
                                          <option value="AB-">AB-</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="text" class="form-label">address</label>
                                        <input type="text" class="form-control" id="address" name="address" >
                                    </div>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <!-- <button  class="close" >Close</button> -->
                                        
                                    
                                  </form>


                          </div>

                      </div>

              </div>

        </div>
          <!--/   INsert Modal end --> 
          <!-- update modal -->
          <div class="modal" id="edit_Modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h2 class="modal-title">Update Patient</h2>
                      <button type="button " class="close" data-dismiss="modal" arial-label="close">
                        <span arial-hidden="true">&times;</span>
                      </button>

                  </div>
                          <div class="modal-body">
                                  <form id="edit_PatientForm" method="POST" action="">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">user_id</label>
                                        <input type="hidden" class="form-control" id="patient_id" name="patient_id">
                                        <select name="edit_user_id" id="edit_user_id" class="form-control">
                                          <option value="">Select Users</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="date" class="form-label">date_of_birth</label>
                                        <input type="date" class="form-control" id="edit_date_of_birth" name="edit_date_of_birth" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="text" class="form-label">gender</label>
                                        <select name="edit_gender" id="edit_gender" class="form-control">
                                          <option value="male">male</option>
                                          <option value="female">female</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="number" class="form-label">blood_type</label>
                                        <select name="edit_bloodType" id="edit_bloodType" class="form-control">
                                          <option value="A+">A+</option>
                                          <option value="A-">A-</option>
                                          <option value="B+">B+</option>
                                          <option value="B-">B-</option>
                                          <option value="O+">O+</option>
                                          <option value="O-">O-</option>
                                          <option value="AB+">AB+</option>
                                          <option value="AB-">AB-</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="text" class="form-label">address</label>
                                        <input type="text" class="form-control" id="edit_address" name="edit_address" >
                                    </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <!-- <button  class="close" >Close</button> -->
                                        
                                    
                                  </form>


                          </div>

                      </div>

              </div>

          </div>
          <!--end  update modal -->
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
  <!-- scripts -->
  <script src="../assets/js/jquery-3.5.1.min.js" rel="stylesheet"></script>
  <script src="../assets/js/jquery.dataTables.min.js" rel="stylesheet"></script>
  <!-- scripts -->
   <script>
    $(document).ready(function(){
        $('#insertModal').click(function(){
          $('#PatientModal').modal('show');
          $('#PatientForm')[0].reset();
        });
        displayData();
        // fetch id users
        //fetch id from member to save user table
        $.get("patientOperation.php?url=loadData", function (data) {
          const response = JSON.parse(data);

          if (response.Users ) {
            response.Users .forEach(user  => {
              $("#user_id").append(`<option value="${user.user_id}">${user.fullName}</option>`);
            });
          }
        });
        // insert
        $('#PatientForm').submit(function(e){
            // alert();
            e.preventDefault();
            const user_id = $('#user_id').val();
            const date_of_birth = $('#date_of_birth').val();
            const gender = $('#gender').val();
            const bloodType = $('#bloodType').val();
            const address = $('#address').val();
            const url ="patientOperation.php?url=createPatient";
            const date ={user_id:user_id,date_of_birth:date_of_birth,gender:gender,bloodType:bloodType,address:address};
            $.post(url,date,function(res){
                alert(res)
                $('#PatientModal').modal('hide');
                $('#PatientForm')[0].reset();
                displayData();
            });
        });
        //function fetch data in form
        $(document).on('click','.editBtn',function(e){ 
          $('#edit_user_id').empty();
          //fetch id from member to save user table
          $.get("patientOperation.php?url=loadData", function (data) {
            const response = JSON.parse(data);

            if (response.Users ) {
              response.Users .forEach(user  => {
                const selected = user.user_id == edit_user_id ? 'selected' : '';
                $("#edit_user_id").append(`<option value="${user.user_id}"${selected}>${user.fullName}</option>`);
              });
            }
          });
            const patient_id =$(this).data('patient_id');
            const edit_user_id =$(this).data('user_id');
            const edit_date_of_birth =$(this).data('dob');
            const edit_gender =$(this).data('edit_gender');
            const edit_bloodType =$(this).data('blood_type');
            const edit_address =$(this).data('address');
            $('#patient_id').val(patient_id);
            $('#edit_user_id').val(edit_user_id);
            $('#edit_date_of_birth').val(edit_date_of_birth);
            $('#edit_gender').val(edit_gender);
            $('#edit_bloodType').val(edit_bloodType);
            $('#edit_address').val(edit_address);

            $('#edit_Modal').modal('show');
        });
        //function update data 
        $('#edit_PatientForm').submit(function(e){
                // alert('hello');
                e.preventDefault();
                const formData= $(this).serialize();
                // alert(formdata);
                $.ajax({
                    type: 'POST',
                    url: 'patientOperation.php?url=UpdatePatient',
                    data: formData,
                    dataType: 'json',
                    success:function(result){
                        alert(result.message);
                        $('#edit_Modal').modal('hide');
                        $('#edit_PatientForm')[0].reset();
                        displayData();

                    }
                });
                
        });
        //function delete 
        $(document).on('click','.deleteBtn',function(e){
            // alert('done');
            const userid = $(this).data('id')
            if(confirm('are you sure delete data')){
                // alert(userid);
                $.post('patientOperation.php?url=DeletePatient',
                    { id:userid},function(res){
                    alert(res);
                        displayData();
                    });


            }
        });
        //display the Data
        function displayData(){
            $.ajax({
                    url:'patientOperation.php?url=displayPatient',
                    success: function(res){
                        const rows = JSON.parse(res);
                        let tableData = '';
                        rows.forEach(rows => {
                            tableData +=`
                            <tr>
                            <td> ${rows.patient_id}</td>
                            <td> ${rows.fullName}</td>
                            <td> ${rows.date_of_birth}</td>
                            <td> ${rows.gender}</td>
                            <td> ${rows.blood_type}</td>
                            <td> ${rows.address}</td>
                            <td> ${rows.registration_date}</td>
                            <td> 
                            <button class="btn btn-warning btn-sm editBtn" data-patient_id="${rows.patient_id}"  data-user_id="${rows.user_id}" data-dob="${rows.date_of_birth}" data-edit_gender="${rows.gender}" data-blood_type="${rows.blood_type}"  data-address="${rows.address}">Edit</button>
                            <button class="btn btn-danger btn-sm deleteBtn" data-id="${rows.patient_id}">Delete</button> 
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
  <script src="../assets/js/bootstrap.bundle.min.js" rel="stylesheet"></script>
  <!-- container-scroller -->
  <!-- base:js -->
  <!-- <script src="../../vendors/base/vendor.bundle.base.js"></script> -->
  <!-- end inject -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <!-- end inject -->
  <!-- plugin js for this page -->
  <script src="../../vendors/chart.js/Chart.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../../js/chart.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
