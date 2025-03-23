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
                  <h2>Payment Form</h2>
                  <button type="button" class="btn btn-primary at-3" id="insertModal">Add Users</button>
                  <br>
                  <br>
                  <table id="dataTable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                      <td>payment_id</td>
                      <td>appointment_id</td>
                      <td>amount</td>
                      <td>payment_method</td>
                      <td>transaction_id</td>
                      <td>payment_date</td>
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

          <div class="modal" id="paymentModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h2 class="modal-title">Add User</h2>
                      <button type="button " class="close" data-dismiss="modal" arial-label="close">
                        <span arial-hidden="true">&times;</span>
                      </button>

                  </div>
                          <div class="modal-body">
                                  <form id="paymentForm" method="POST" action="">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Appointment Name</label>
                                        <select name="Appointment_id" id="Appointment_id" class="form-control" >
                                          <option value="">--Select Appointment Name--</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="amount" class="form-label">Total Amount</label>
                                        <input type="number" class="form-control" id="total" name="total"  readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="amount" class="form-label">amount</label>
                                        <input type="number" class="form-control" id="amount" name="amount" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="payment_method" class="form-label">payment_method</label>
                                        <select name="payment_method" id="payment_method" class="form-control" >
                                          <option value="">--Select Payment Method--</option>
                                          <option value="cash">Cash</option>
                                          <option value="card">Card</option>
                                          <option value="online">Online</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="transaction_id" class="form-label">Transaction ID</label>
                                        <input type="text" class="form-control" id="transaction_id" name="transaction_id" >
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
          <div class="modal" id="edit_paymentModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h2 class="modal-title">Add User</h2>
                      <button type="button " class="close" data-dismiss="modal" arial-label="close">
                        <span arial-hidden="true">&times;</span>
                      </button>

                  </div>
                          <div class="modal-body">
                                  <form id="edit_paymentForm" method="POST" action="">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Appointment Name</label>
                                        <input type="hidden" class="form-control" id="payment_id" name="payment_id">
                                        <select name="edit_Appointment_id" id="edit_Appointment_id" class="form-control" >
                                          <option value="">--Select Appointment Name--</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="amount" class="form-label">Total Amount</label>
                                        <input type="number" class="form-control" id="edit_total" name="edit_total"  readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="amount" class="form-label">amount</label>
                                        <input type="number" class="form-control" id="edit_amount" name="edit_amount" >
                                    </div>
                                    <div class="mb-3">
                                        <label for="payment_method" class="form-label">payment_method</label>
                                        <select name="edit_payment_method" id="edit_payment_method" class="form-control" >
                                          <option value="">--Select Payment Method--</option>
                                          <option value="cash">Cash</option>
                                          <option value="card">Card</option>
                                          <option value="online">Online</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="transaction_id" class="form-label">Transaction ID</label>
                                        <input type="text" class="form-control" id="edit_transaction_id" name="edit_transaction_id" >
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
          $('#paymentModal').modal('show');
          $('#paymentForm')[0].reset();
        });
        displayData();
        //fetch id from member to save user table
        $.get("paymentOperation.php?url=loadData", function(data) {
          try {
              const response = JSON.parse(data);
              
              if (response.status === 'success' && response.appointments) {
                  // Clear previous options
                  $("#Appointment_id").empty();
                  
                  // Add default option
                  $("#Appointment_id").append('<option value="">Select Appointment</option>');
                  
                  // Add appointments with their consultation_fee and fullName
                  response.appointments.forEach(appointment => {
                      $("#Appointment_id").append(
                          `<option value="${appointment.appointment_id}" data-fee="${appointment.consultation_fee}">
                              ${appointment.fullName}
                          </option>`
                      );
                  });
              } else {
                  console.error('Error:', response.message);
              }
          } catch (e) {
              console.error('Parsing error:', e);
          }
      }).fail(function(jqXHR, textStatus, errorThrown) {
          console.error('Request failed:', textStatus, errorThrown);
      });

      // When an appointment is selected, show the consultation fee in the 'total' field
      $("#Appointment_id").change(function() {
          var selectedOption = $("#Appointment_id option:selected");
          var consultationFee = selectedOption.data("fee"); // Get the consultation fee from the data attribute

          if (consultationFee) {
              // Set the total input field with the consultation fee
              $("#total").val(consultationFee);
          } else {
              // Clear the total field if no consultation fee is found
              $("#total").val('');
          }
      });
        // insert
        $('#appointmentForm').submit(function(e){
            // alert();
            e.preventDefault();
            const appointment_id = $('#Appointment_id').val();
            const amount = $('#amount').val();
            const payment_method = $('#payment_method').val();
            const Transaction_id = $('#transaction_id').val();
            const url ="paymentOperation.php?url=createPayment";
            const date ={Appointment_id:appointment_id,amount:amount,payment_method:payment_method,transaction_id:Transaction_id};
            $.post(url,date,function(res){
                alert(res)
                $('#paymentModal').modal('hide');
                $('#paymentForm')[0].reset();
                displayData();
            });
        });
        //function fetch data in form
      $(document).on('click', '.editBtn', function(e) { 
            // Prevent the default action if needed
            e.preventDefault();

            // Get the data attributes from the clicked button
            const payment_id = $(this).data('payment_id');
            const appointment_id = $(this).data('appointment_id');
            const amount = $(this).data('amount');
            const payment_method = $(this).data('payment_method');
            const Transaction = $(this).data('transaction');

            // Populate the modal fields with the retrieved data
            $('#payment_id').val(payment_id);
            $('#edit_amount').val(amount);
            $('#edit_payment_method').val(payment_method);
            $('#edit_transaction_id').val(Transaction);

            // Function to load appointments and populate the select dropdown
            $.get("paymentOperation.php?url=loadData", function(data) {
                try {
                    const response = JSON.parse(data);

                    if (response.status === 'success' && response.appointments) {
                        // Clear previous options in the dropdown
                        $("#edit_Appointment_id").empty();

                        // Add a default option
                        $("#edit_Appointment_id").append('<option value="">Select Appointment</option>');

                        // Variable to hold the consultation fee
                        let consultationFee = null;

                        // Add each appointment as an option with its consultation fee and appointment name
                        response.appointments.forEach(appointment => {
                            const selected = appointment.appointment_id == appointment_id ? 'selected' : '';

                            // If the appointment is selected, save the consultation fee
                            if (appointment.appointment_id == appointment_id) {
                                consultationFee = appointment.consultation_fee;
                            }

                            $("#edit_Appointment_id").append(
                                `<option value="${appointment.appointment_id}" ${selected} data-fee="${appointment.consultation_fee}">
                                    ${appointment.fullName}
                                </option>`
                            );
                        });

                        // Set the default selected value for the appointment_id
                        $('#edit_Appointment_id').val(appointment_id);

                        // Set the total field with the consultation fee of the selected appointment
                        if (consultationFee) {
                            $("#edit_total").val(consultationFee);
                        }

                    } else {
                        console.error('Error:', response.message);
                    }
                } catch (e) {
                    console.error('Parsing error:', e);
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Request failed:', textStatus, errorThrown);
            });

            // When an appointment is selected, show the consultation fee in the 'total' field
            $("#edit_Appointment_id").change(function() {
                var selectedOption = $("#edit_Appointment_id option:selected");
                var consultationFee = selectedOption.data("fee"); // Get the consultation fee from the data attribute

                if (consultationFee) {
                    // Set the total input field with the consultation fee
                    $("#edit_total").val(consultationFee);
                } else {
                    // Clear the total field if no consultation fee is found
                    $("#edit_total").val('');
                }
            });

            // Show the modal
            $('#edit_paymentModal').modal('show');
      });
        //function update data 
        $('#edit_paymentForm').submit(function(e){
                // alert('hello');
                e.preventDefault();
                const formData= $(this).serialize();
                // alert(formdata);
                $.ajax({
                    type: 'POST',
                    url: 'paymentOperation.php?url=UpdatePayment',
                    data: formData,
                    dataType: 'json',
                    success:function(result){
                        alert(result.message);
                        $('#edit_paymentModal').modal('hide');
                        $('#edit_paymentForm')[0].reset();
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
                $.post('paymentOperation.php?url=DeletePayment',
                    { id:userid},function(res){
                    alert(res);
                        displayData();
                    });


            }
        });
        //display the Data
        function displayData(){
            $.ajax({
                url: 'paymentOperation.php?url=displayPayment',
                success: function(res){
                    const rows = JSON.parse(res);
                    let tableData = '';
                    rows.forEach(row => {
                        tableData += `
                            <tr>
                                <td> ${row.payment_id} </td>
                                <td> ${row.fullName} </td>
                                <td> ${row.amount} </td>
                                <td> ${row.payment_method} </td>
                                <td> ${row.transaction_id} </td>
                                <td> ${row.payment_date} </td>
                              
                                <td>
                                    <button class="btn btn-warning btn-sm editBtn" 
                                            data-payment_id="${row.payment_id}" 
                                            data-appointment_id="${row.appointment_id}" 
                                            data-amount="${row.amount}" 
                                            data-payment_method="${row.payment_method}" 
                                            data-transaction="${row.transaction_id}"  
                                            data-phone="${row.payment_status}" 
                                            data-edi_role="${row.payment_date}">
                                        Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm deleteBtn" data-id="${row.payment_id}">
                                        Delete
                                    </button>
                                </td> 
                            </tr>`;
                    });

                    if($.fn.DataTable.isDataTable('#dataTable')) {
                        $('#dataTable').DataTable().clear().destroy();
                    }
                    $('#dataTable tbody').html(tableData);

                    $('#dataTable').DataTable({
                        paging: true,
                        searching: true,
                        ordering: true,
                        responsive: true
                    });
                }
            });
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
