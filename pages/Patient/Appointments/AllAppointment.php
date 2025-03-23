<?php
session_start();

// Check if the user is logged in and has the 'Admin' role
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'Patient') {
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
  <!-- <link rel="stylesheet" href="../assets/css/bootstrap.min.css" > -->
  <link rel="stylesheet" href="../../assets/css/jquery.dataTables.min.css" >
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
              <a class="dropdown-item preview-item hover:cursor-pointer" href="../Profile/profile.php">               
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
      <!-- partial:../../../partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas ml-0"  id="sidebar">
        <ul class="nav mt-5">
         <li class="nav-item">
            <a class="nav-link" href="../../../patient_dashboard.php">
              <i class="icon-box menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../../pages/Patient/Appointments/AllAppointment.php">
              <!-- <i class="icon-command menu-icon"></i> -->
              <span class="menu-title">Appointments</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../../pages/Patient/Payments/Payments.php">
              <!-- <i class="icon-help menu-icon"></i> -->
              <span class="menu-title">Payments</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../../pages/Patient/Reports/Reports.php">
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
                  <h2>All Appointment Form</h2>
                  <button type="button" class="btn btn-primary at-3" id="insertModal">Add Appointment</button>
                  <br>
                  <br>
                  <table id="dataTable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                      <td>appointment_id</td>
                      <td>Patient Name</td>
                      <td>Doctor Name</td>
                      <td>appointment_date</td>
                      <td>status</td>
                      <td>payment_status</td>
                      <td>consultation_fee</td>
                      <td>paid</td>
                      <td>Reminder</td>
                      <td>Actions</td>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
          </div> 
          <!--/   INsert Modal start -->

          <div class="modal" id="AppointmentModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h2 class="modal-title">Add Appointment</h2>
                      <button type="button " class="close" data-dismiss="modal" arial-label="close">
                        <span arial-hidden="true">&times;</span>
                      </button>

                  </div>
                          <div class="modal-body">
                          <form id="appointmentForm">
                            <div class="form-group">
                                <label for="patient_id">Patient</label>
                                <select id="patient_id" name="patient_id" class="form-control">
                                    <option value="">Select Patient</option>
                                    <!-- Patients will be loaded here -->
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="doctor_id">Doctor</label>
                                <select id="doctor_id" name="doctor_id" class="form-control">
                                    <option value="">Select Doctor</option>
                                    <!-- Doctors will be loaded here -->
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="appointment_date">Appointment Date</label>
                                <input type="datetime-local" id="appointment_date" name="appointment_date" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="consultation_fee">Consultation Fee ($)</label>
                                <input type="text" id="consultation_fee" name="consultation_fee" class="form-control" readonly>
                            </div>

                            <button type="submit" class="btn btn-primary">Book Appointment</button>
                          </form>



                          </div>

                      </div>

              </div>

          </div>
          <!--/   INsert Modal end --> 

          <!-- start Update Model  -->
          <div class="modal" id="edit_appointmentModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h2 class="modal-title">Update Appointment</h2>
                      <button type="button " class="close" data-dismiss="modal" arial-label="close">
                        <span arial-hidden="true">&times;</span>
                      </button>

                  </div>
                          <div class="modal-body">
                          <form id="edit_appointmentForm">
                            <div class="form-group">
                                <label for="patient_id">Patient</label>
                                <input type="hidden" id="appointment_id" name="appointment_id" class="form-control" >
                                <select id="edit_patient_id" name="edit_patient_id" class="form-control" readonly>
                                    <option value=""></option>
                                    <!-- Patients will be loaded here -->
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="doctor_id">Doctor</label>
                                <select id="edit_doctor_id" name="edit_doctor_id" class="form-control" readonly>
                                    <option value=""></option>
                                    <!-- Doctors will be loaded here -->
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="appointment_date">Appointment Date</label>
                                <input type="datetime-local" id="edit_appointment_date" name="edit_appointment_date" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="status">Status </label>
                                <select name="edit_status" id="edit_status" class="form-control" readonly>
                                  <option value="pending">pending</option>
                                  <option value=" Accepted">Accepted</option>
                                  <option value="Rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="appointment_status">Appointment status</label>
                                <select name="edit_appointmentStatus" id="edit_appointmentStatus" class="form-control" readonly>
                                  <option value="pending">pending</option>
                                  <option value="paid"> paid</option>
                                  <option value="unpaid">unpaid</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="consultation_fee">Consultation Fee ($)</label>
                                <input type="text" id="edit_consultation_fee" name="edit_consultation_fee" class="form-control" readonly>
                            </div>

                            <button type="submit" class="btn btn-primary">Report </button>
                          </form>

                          </div>

                      </div>

              </div>

          </div>
          <!-- Ends Update Model  -->
        <!-- content-wrapper ends -->
        <!-- partial:../../../partials/_footer.html -->
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
  <script src="../../assets/js/jquery-3.5.1.min.js" rel="stylesheet"></script>
  <script src="../../assets/js/jquery.dataTables.min.js" rel="stylesheet"></script>
 <!-- scripts -->
  <!-- container-scroller -->
   <!-- scripts -->
    <script>
      // $(document).ready(function(){
      //   $('#insertModal').click(function(){
      //     $('#AppointmentModal').modal('show');
      //     $('#appointmentForm')[0].reset();
      //   });
      //   displayData();
      //   // Load Patients & Doctors
      //   $.get("AllappointmentOpera.php?url=loadData", function (data) {
      //       const response = JSON.parse(data);

      //       // Load Patients
      //       if (response.Patients) {
      //           response.Patients.forEach(patient => {
      //               $("#patient_id").append(`<option value="${patient.patient_id}">${patient.fullName}</option>`);
      //           });
      //       }

      //       // Load Doctors
      //       if (response.Doctors) {
      //           response.Doctors.forEach(doctor => {
      //               $("#doctor_id").append(
      //                   `<option value="${doctor.doctor_id}" data-fee="${doctor.consultation_fee}">
      //                       ${doctor.fullName}
      //                   </option>`
      //               );
      //           });
      //       }
      //   });

      //   // Update Consultation Fee when Doctor is Selected
      //   $("#doctor_id").on("change", function () {
      //       let selectedFee = $(this).find(":selected").data("fee");
      //       $("#consultation_fee").val(selectedFee ? selectedFee : ""); // Set Fee in Input Field
      //   });
      //   // insert
      //   $('#appointmentForm').submit(function(e){
      //       // alert();
      //       e.preventDefault();
      //       const patient_id = $('#patient_id').val();
      //       const doctor_id = $('#doctor_id').val();
      //       const appointment_date = $('#appointment_date').val();
      //       const consultation_fee = $('#consultation_fee').val();
      //       const url ="AllappointmentOpera.php?url=createAppointment";
      //       const date ={patient_id:patient_id,doctor_id:doctor_id,appointment_date:appointment_date,consultation_fee:consultation_fee};
      //       $.post(url,date,function(res){
      //           alert(res)
      //           $('#AppointmentModal').modal('hide');
      //           $('#appointmentForm')[0].reset();
      //           displayData();
      //       });
      //   });
      //   //function fetch data in form
      //   $(document).on('click', '.editBtn', function (e) {
      //     $('#edit_patient_id').empty();
      //     $('#edit_doctor_id').empty();
      //             // Update Consultation Fee when Doctor is Selected
      //     $("#edit_doctor_id").on("change", function () {
      //         let selectedFee = $(this).find(":selected").data("fee");
      //         $("#edit_consultation_fee").val(selectedFee ? selectedFee : ""); // Set Fee in Input Field
      //     });

      //     // Get data from button attributes
      //     const appointment_id = $(this).data('appointment_id');
      //     const patient_id = $(this).data('patient_id');
      //     const doctor_id = $(this).data('doctor_id');
      //     const appointment_date = $(this).data('appointment_date');
      //     const status = $(this).data('status');
      //     const payment_status = $(this).data('payment_status');
      //     const consultation_fee = $(this).data('consultation_fee');

      //     // Set values to the form
      //     $('#appointment_id').val(appointment_id);
      //     $('#edit_appointment_date').val(appointment_date);
      //     $('#edit_status').val(status);
      //     $('#edit_appointmentStatus').val(payment_status);
      //     $('#edit_consultation_fee').val(consultation_fee);

      //     // Show the modal
      //     $('#edit_appointmentModal').modal('show');
      //   });
      //   $(document).on("click", ".editBtn", function (e) {
      //     // Clear and reset dropdowns
      //     $("#edit_patient_id").html('<option value="">Select Patient</option>');
      //     $("#edit_doctor_id").html('<option value="">Select Doctor</option>');
      //     $("#edit_appointmentStatus").html("");
      //     $("#edit_status").html("");

      //     // Get data from button attributes
      //     const appointmentData = {
      //         appointment_id: $(this).data("appointment_id"),
      //         patient_id: $(this).data("patient_id"),
      //         doctor_id: $(this).data("doctor_id"),
      //         appointment_date: $(this).data("appointment_date"),
      //         status: $(this).data("status"),
      //         payment_status: $(this).data("payment_status"),
      //         consultation_fee: $(this).data("consultation_fee"),
      //     };

      //     // Fetch Patients & Doctors
      //     $.get("AllappointmentOpera.php?url=loadData", function (response) {
      //         try {
      //             const data = JSON.parse(response);

      //             // Populate Patients Dropdown
      //             if (data.Patients) {
      //                 data.Patients.forEach((patient) => {
      //                     const selected = patient.patient_id == appointmentData.patient_id ? "selected" : "";
      //                     $("#edit_patient_id").append(
      //                         `<option value="${patient.patient_id}" ${selected}>${patient.fullName}</option>`
      //                     );
      //                 });
      //             }

      //             // Populate Doctors Dropdown
      //             if (data.Doctors) {
      //                 data.Doctors.forEach((doctor) => {
      //                     const selected = doctor.doctor_id == appointmentData.doctor_id ? "selected" : "";
      //                     $("#edit_doctor_id").append(
      //                         `<option value="${doctor.doctor_id}" data-fee="${doctor.consultation_fee}" ${selected}>
      //                             ${doctor.fullName}
      //                         </option>`
      //                     );
      //                 });
      //             }

      //             // Populate Payment Status
      //             const paymentOptions = ["pending", "paid", "unpaid"];
      //             paymentOptions.forEach((ps) => {
      //                 const selected = ps == appointmentData.payment_status ? "selected" : "";
      //                 $("#edit_appointmentStatus").append(`<option value="${ps}" ${selected}>${ps}</option>`);
      //             });

      //             // Populate Status
      //             const statusOptions = ["pending", "Accepted", "Rejected"];
      //             statusOptions.forEach((st) => {
      //                 const selected = st == appointmentData.status ? "selected" : "";
      //                 $("#edit_status").append(`<option value="${st}" ${selected}>${st}</option>`);
      //             });

      //             // Set Consultation Fee based on selected doctor
      //             let selectedFee = $("#edit_doctor_id").find(":selected").attr("data-fee") || appointmentData.consultation_fee;
      //             $("#edit_consultation_fee").val(selectedFee);
      //         } catch (error) {
      //             console.error("Error parsing JSON:", error);
      //         }
      //     });

      //     // Set form values
      //     $("#appointment_id").val(appointmentData.appointment_id);
      //     $("#edit_appointment_date").val(appointmentData.appointment_date);

      //     // Show the modal
      //     $("#edit_appointmentModal").modal("show");
      //   });

      //     //function update data 
      //     $('#edit_appointmentForm').submit(function(e){
      //             // alert('hello');
      //             e.preventDefault();
      //             const formData= $(this).serialize();
      //             // alert(formdata);
      //             $.ajax({
      //                 type: 'POST',
      //                 url: 'AllappointmentOpera.php?url=UpdateAppointment',
      //                 data: formData,
      //                 dataType: 'json',
      //                 success:function(result){
      //                     alert(result.message);
      //                     $('#edit_appointmentModal').modal('hide');
      //                     $('#edit_appointmentForm')[0].reset();
      //                     displayData();

      //                 }
      //             });
                  
      //     });
      //     //function delete 
      //     $(document).on('click','.deleteBtn',function(e){
      //         // alert('done');
      //         const userid = $(this).data('id')
      //         if(confirm('are you sure delete data')){
      //             // alert(userid);
      //             $.post('AllappointmentOpera.php?url=deleteAppointment',
      //                 { id:userid},function(res){
      //                 alert(res);
      //                     displayData();
      //                 });


      //         }
      //     });
      //     //display the Data
      //     function displayData(){
      //         $.ajax({
      //                 url:'AllappointmentOpera.php?url=displayAllAppointment',
      //                 success: function(res){
      //                     const rows = JSON.parse(res);
      //                     let tableData = '';
      //                     rows.forEach(rows => {
      //                         tableData +=`
      //                         <tr>
      //                         <td> ${rows.appointment_id}</td>
      //                         <td> ${rows.patient_fullName}</td>
      //                         <td> ${rows.doctor_fullName}</td>
      //                         <td> ${rows.appointment_date}</td>
      //                         <td> ${rows.status}</td>
      //                         <td> ${rows.payment_status}</td>
      //                         <td> ${rows.consultation_fee}</td>
      //                         <td> ${rows.paid}</td>
      //                         <td> ${rows.reminder}</td>
      //                         <td> 
      //                         <button class="btn btn-success btn-sm editBtn" data-appointment_id="${rows.appointment_id}"  data-patient_id="${rows.patient_id}" data-doctor_id="${rows.doctor_id}" data-appointment_date="${rows.appointment_date}" data-status="${rows.status}"  data-payment_status="${rows.payment_status}" data-consultation_fee="${rows.consultation_fee}"  >View</button>
      //                         <button class="btn btn-danger btn-sm deleteBtn" data-id="${rows.appointment_id}">Delete</button> 
      //                         </td> 
      //                         </tr>`;
                              
      //                     });
                        
      //                     if($.fn.DataTable.isDataTable('#dataTable'))
      //                           {
      //                               $('#dataTable').DataTable().clear().destroy();
      //                           }
      //                           $('#dataTable tbody').html(tableData);

      //                           $('#dataTable').DataTable({
                                    
      //                               Paging: true,
      //                               Searching: true,
      //                               ordering: true,
      //                               responsive: true
                                    
      //                           });
                          
      //                 }
      //             })
      //     }
      // });

  $(document).ready(function(){
    $('#insertModal').click(function(){
        $('#AppointmentModal').modal('show');
        $('#appointmentForm')[0].reset();
    });

    displayData();

    // Load Patients & Doctors
    $.get("AllappointmentOpera.php?url=loadData", function (data) {
        const response = JSON.parse(data);

        // Load Patients
        if (response.Patients) {
            response.Patients.forEach(patient => {
                $("#patient_id").append(`<option value="${patient.patient_id}">${patient.fullName}</option>`);
            });
        }

        // Load Doctors
        if (response.Doctors) {
            response.Doctors.forEach(doctor => {
                $("#doctor_id").append(
                    `<option value="${doctor.doctor_id}" data-fee="${doctor.consultation_fee}">
                        ${doctor.fullName}
                    </option>`
                );
            });
        }
    });

    // Update Consultation Fee when Doctor is Selected
    $("#doctor_id").on("change", function () {
        let selectedFee = $(this).find(":selected").data("fee");
        $("#consultation_fee").val(selectedFee ? selectedFee : ""); // Set Fee in Input Field
    });

    // Insert Appointment

    $('#appointmentForm').submit(function(e) {
      e.preventDefault();

      // Validate form fields
      let isValid = true;
      $(this).find('input[required], select[required]').each(function() {
          if ($(this).val() === '') {
              isValid = false;
              $(this).addClass('is-invalid');
          } else {
              $(this).removeClass('is-invalid');
          }
      });

      if (!isValid) {
          Swal.fire({
              title: "Error!",
              text: "Please fill all required fields.",
              icon: "error",
              confirmButtonText: "OK",
          });
          return;
      }

      // Collect form data
      const formData = $(this).serialize();

      // Send AJAX request
      $.ajax({
          type: 'POST',
          url: 'AllappointmentOpera.php?url=createAppointment',
          data: formData,
          dataType: 'json',
          success: function(response) {
              if (response.status === 'success') {
                  Swal.fire({
                      title: 'Success!',
                      text: response.message,
                      icon: 'success',
                      confirmButtonText: 'OK',
                  }).then(() => {
                      $('#AppointmentModal').modal('hide');
                      $('#appointmentForm')[0].reset();
                      displayData(); // Refresh the data table
                  });
              } else {
                  Swal.fire({
                      title: 'Error!',
                      text: response.message,
                      icon: 'error',
                      confirmButtonText: 'OK',
                  });
              }
          },
          error: function() {
              Swal.fire({
                  title: 'Error!',
                  text: 'An error occurred while submitting the form.',
                  icon: 'error',
                  confirmButtonText: 'OK',
              });
          }
      });
     });

    // Edit Appointment
    $(document).on('click', '.editBtn', function (e) {
        $('#edit_patient_id').empty();
        $('#edit_doctor_id').empty();

        // Update Consultation Fee when Doctor is Selected
        $("#edit_doctor_id").on("change", function () {
            let selectedFee = $(this).find(":selected").data("fee");
            $("#edit_consultation_fee").val(selectedFee ? selectedFee : ""); // Set Fee in Input Field
        });

        // Get data from button attributes
        const appointment_id = $(this).data('appointment_id');
        const patient_id = $(this).data('patient_id');
        const doctor_id = $(this).data('doctor_id');
        const appointment_date = $(this).data('appointment_date');
        const status = $(this).data('status');
        const payment_status = $(this).data('payment_status');
        const consultation_fee = $(this).data('consultation_fee');

        // Set values to the form
        $('#appointment_id').val(appointment_id);
        $('#edit_appointment_date').val(appointment_date);
        $('#edit_status').val(status);
        $('#edit_appointmentStatus').val(payment_status);
        $('#edit_consultation_fee').val(consultation_fee);

        // Show the modal
        $('#edit_appointmentModal').modal('show');
    });

    // Delete Appointment
    $(document).on('click', '.deleteBtn', function(e) {
        const appointment_id = $(this).data('id');

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
                    url: 'AllappointmentOpera.php?url=deleteAppointment',
                    data: { id: appointment_id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Deleted!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK',
                            }).then(() => {
                                displayData(); // Refresh the data table
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while deleting the appointment.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    }
                });
            }
        });
    });

    // Display Data
    function displayData(){
        $.ajax({
            url: 'AllappointmentOpera.php?url=displayAllAppointment',
            success: function(res){
                const rows = JSON.parse(res);
                let tableData = '';
                rows.forEach(rows => {
                    tableData +=`
                    <tr>
                        <td>${rows.appointment_id}</td>
                        <td>${rows.patient_fullName}</td>
                        <td>${rows.doctor_fullName}</td>
                        <td>${rows.appointment_date}</td>
                        <td>${rows.status}</td>
                        <td>${rows.payment_status}</td>
                        <td>${rows.consultation_fee}</td>
                        <td>${rows.paid}</td>
                        <td>${rows.reminder}</td>
                        <td>
                            
                            <button class="btn btn-danger btn-sm deleteBtn" data-id="${rows.appointment_id}">Delete</button>
                        </td>
                    </tr>`;
                });

                if($.fn.DataTable.isDataTable('#dataTable')){
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
     <script src="../../assets/js/bootstrap.bundle.min.js" rel="stylesheet"></script>
   <!-- end scripts -->
  <!-- base:js -->
  <!-- <script src="../../../vendors/base/vendor.bundle.base.js"></script> -->
  <!-- end inject -->
  <!-- inject:js -->
  <script src="../../../js/off-canvas.js"></script>
  <script src="../../../js/hoverable-collapse.js"></script>
  <script src="../../../js/template.js"></script>
  <!-- end inject -->
  <!-- plugin js for this page -->
  <script src="../../../vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="../../../vendors/select2/select2.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../../../js/file-upload.js"></script>
  <script src="../../../js/typeahead.js"></script>
  <script src="../../../js/select2.js"></script>
  <!-- End custom js for this page -->
</body>

</html>
