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
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../vendors/select2/select2.min.css">
  <link rel="stylesheet" href="../../vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- end inject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
  <!-- links assets -->
  <!-- <link rel="stylesheet" href="../assets/css/bootstrap.min.css" > -->
  <link rel="stylesheet" href="../assets/css/jquery.dataTables.min.css" >
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
      <nav class="sidebar sidebar-offcanvas ml-0"  id="sidebar">
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
              <!-- <div class="card"> -->
                <!-- <div class="card-body"> -->
                  <h2>User Form</h2>
                  <button type="button" class="btn btn-primary at-3" id="insertModal">Add Users</button>
                  <br>
                  <br>
                  <table id="dataTable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                      <td>user_id</td>
                      <td>fullName</td>
                      <td>email</td>
                      <td>UserName</td>
                      <td>password</td>
                      <td>phone</td>
                      <td>role</td>
                      <td>created_at</td>
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

          <div class="modal" id="userModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h2 class="modal-title">Add User</h2>
                      <button type="button " class="close" data-dismiss="modal" arial-label="close">
                        <span arial-hidden="true">&times;</span>
                      </button>

                  </div>
                          <div class="modal-body">
                                  <form id="UserForm" method="POST" action="">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">fullName</label>
                                        <input type="name" class="form-control" id="fullName" name="fullName" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">email</label>
                                        <input type="email" class="form-control" id="email" name="email" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">userName</label>
                                        <input type="text" class="form-control" id="userName" name="userName" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">password</label>
                                        <input type="password" class="form-control" id="password" name="password" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="number" class="form-label">phone</label>
                                        <input type="number" class="form-control" id="phone" name="phone" >
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
      $(document).ready(function(){
        $('#insertModal').click(function(){
          $('#userModal').modal('show');
          $('#userModal')[0].reset();
        });
        displayData();
        // insert
        $('#UserForm').submit(function(e){
            // alert();
            e.preventDefault();
            const fullName = $('#fullName').val();
            const email = $('#email').val();
            const userName = $('#userName').val();
            const password = $('#password').val();
            const phone = $('#phone').val();
            const url ="userOperation.php?url=createUser";
            const date ={fullName:fullName,email:email,userName:userName,password:password,phone:phone};
            $.post(url,date,function(res){
                alert(res)
                $('#userModal').modal('hide');
                $('#UserForm')[0].reset();
                displayData();
            });
        });
        //function fetch data in form
        $(document).on('click','.editBtn',function(e){ 
          $('#edit_role').empty();
            $.get("userOperation.php?url=getRoles", function (data) {
                  const response = JSON.parse(data);
                  response.roles.forEach(role => {
                      const selected = role == edit_role ? 'selected' : ''; // Set as selected if matches
                      $('#edit_role').append(`<option value="${role}" ${selected}>${role}</option>`);
                  });
            });
            const user_id =$(this).data('user_id');
            const fullName =$(this).data('fullname');
            const email =$(this).data('email');
            const userName =$(this).data('username');
            const password =$(this).data('password');
            const phone =$(this).data('phone');
            const edit_role =$(this).data('edi_role');
            $('#edit_user_id').val(user_id);
            $('#edit_fullName').val(fullName);
            $('#edit_email').val(email);
            $('#edit_userName').val(userName);
            $('#edit_password').val(password);
            $('#edit_phone').val(phone);
            $('#edit_role').val(edit_role);

            $('#edit_userModal').modal('show');
        });
        //function update data 
        $('#editForm').submit(function(e){
                // alert('hello');
                e.preventDefault();
                const formData= $(this).serialize();
                // alert(formdata);
                $.ajax({
                    type: 'POST',
                    url: 'userOperation.php?url=UpdateUser',
                    data: formData,
                    dataType: 'json',
                    success:function(result){
                        alert(result.message);
                        $('#edit_userModal').modal('hide');
                        $('#editForm')[0].reset();
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
                $.post('userOperation.php?url=deleteUser',
                    { id:userid},function(res){
                    alert(res);
                        displayData();
                    });


            }
        });
        //display the Data
        function displayData(){
            $.ajax({
                    url:'userOperation.php?url=displayUser',
                    success: function(res){
                        const rows = JSON.parse(res);
                        let tableData = '';
                        rows.forEach(rows => {
                            tableData +=`
                            <tr>
                            <td> ${rows.user_id}</td>
                            <td> ${rows.fullName}</td>
                            <td> ${rows.email}</td>
                            <td> ${rows.userName}</td>
                            <td> ${rows.password}</td>
                            <td> ${rows.phone}</td>
                            <td> ${rows.role}</td>
                            <td> ${rows.created_at}</td>
                            <td> 
                            <button class="btn btn-warning btn-sm editBtn" data-user_id="${rows.user_id}"  data-fullname="${rows.fullName}" data-email="${rows.email}" data-username="${rows.userName}" data-password="${rows.password}"  data-phone="${rows.phone}" data-edi_role="${rows.role}"  >Edit</button>
                            <button class="btn btn-danger btn-sm deleteBtn" data-id="${rows.user_id}">Delete</button> 
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
