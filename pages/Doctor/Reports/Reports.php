<?php
session_start();

// Check if the user is logged in and has the 'Admin' role
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'Doctor') {
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
  <!-- inject:css -->
  <link rel="stylesheet" href="../../../css/style.css">
  <!-- end inject -->
  <link rel="shortcut icon" href="../../../images/favicon.png" />
  <link rel="stylesheet" href="../../assets/css/jquery.dataTables.min.css" >
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
            <a class="nav-link" href="../../../doctor_dashboard.php">
              
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="../../../pages/Doctor/Patients/Patients.php">
              <!-- <i class="icon-command menu-icon"></i> -->
              <span class="menu-title">Patients</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../../pages/Doctor/Appointments/AllAppointment.php">
              <!-- <i class="icon-command menu-icon"></i> -->
              <span class="menu-title">Appointments</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../../pages/Doctor/Payments/Payments.php">
              <!-- <i class="icon-help menu-icon"></i> -->
              <span class="menu-title">Payments</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../../pages/Doctor/Reports/Reports.php">
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
            <!-- <button type="button" class="btn btn-primary at-3" id="payment">Report Payment</button> -->
             <button type="button" class="btn btn-primary" id="payment">Report Payment</button>
            <button type="button" class="btn btn-primary at-3" id="appointment">Report Appointment</button>
            <button type="button" class="btn btn-primary at-3" id="patient">Report Patient</button>
            <br>
            <br>

            <!-- Table initially hidden -->
            <table id="dataTable" class="table table-striped table-bordered" style="display: none;">
              <thead>
                <tr>
                  <th>Payment ID</th>
                  <th>Patient Name</th>
                  <th>Amount</th>
                  <th>Payment Method</th>
                  <th>Transaction ID</th>
                  <th>Payment Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <!-- Data will be populated here via AJAX -->
              </tbody>
            </table>


          </div>
        </div>
        <!--/   INsert Modal start -->
          <div class="modal" id="paymentModel" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h2 class="modal-title">View Payment</h2>
                      <button type="button " class="close" data-dismiss="modal" arial-label="close">
                        <span arial-hidden="true">&times;</span>
                      </button>

                  </div>
                          <div class="modal-body">
                            <form id="paymentReport" method="POST">
                                <div class="mb-3">
                                    <label for="payment_id" class="form-label">Payment ID</label>
                                    <input type="text" class="form-control" id="payment_id" name="payment_id" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="appointment_name" class="form-label">Appointment Name</label>
                                    <input type="text" class="form-control" id="appointment_name" name="appointment_name" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="total_amount" class="form-label">Total Amount</label>
                                    <input type="text" class="form-control" id="total_amount" name="total_amount" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="text" class="form-control" id="amount" name="amount" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Payment Method</label>
                                    <input type="text" class="form-control" id="payment_method" name="payment_method" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="transaction_id" class="form-label">Transaction ID</label>
                                    <input type="text" class="form-control" id="transaction_id" name="transaction_id" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="transaction_id" class="form-label">Payment Date</label>
                                    <input type="text" class="form-control" id="paymentDate" name="paymentDate" readonly>
                                </div>
                                <button type="button" class="btn btn-primary" id="generateReportBtn">Generate Report</button>
                            </form>



                          </div>

                      </div>

              </div>

          </div>
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
  <!-- scripts -->
  <script src="../../assets/js/jquery-3.5.1.min.js" rel="stylesheet"></script>
  <script src="../../assets/js/jquery.dataTables.min.js" rel="stylesheet"></script>
  <!-- scripts -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
$(document).ready(function() {
  // Triggered when the 'Report Payment' button is clicked
    $('#payment').click(function() {
        $('#dataTable').show();  // Show the table

        $.ajax({
            url: 'paymentOperation.php',  // Your PHP endpoint
            type: 'GET',
            success: function(response) {
                // Log the response to inspect it
                console.log(response);

                // Check if the response contains data
                if (Array.isArray(response) && response.length > 0) {
                    // Clear any existing rows in the table
                    $('#dataTable tbody').empty();

                    // Populate the table with the response data
                    response.forEach(function(payment) {
                        $('#dataTable tbody').append(`
                            <tr>
                                <td>${payment.payment_id}</td>
                                <td>${payment.fullName}</td>
                                <td>${payment.amount}</td>
                                <td>${payment.payment_method}</td>
                                <td>${payment.transaction_id}</td>
                                <td>${payment.payment_date}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm editBtn"
                                            data-payment_id="${payment.payment_id}" 
                                            data-appointment_id="${payment.appointment_id}"
                                            data-amount="${payment.amount}"
                                            data-payment_method="${payment.payment_method}"
                                            data-transaction="${payment.transaction_id}">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    alert('No data found');
                }
            },
            error: function() {
                alert('Error fetching data');
            }
        });
    });

    // Trigger PDF generation when the button is clicked
    $('#generateReportBtn').click(function() {
        var paymentData = {
            payment_id: $('#payment_id').val(),
            appointment_name: $('#appointment_name').val(),
            amount: $('#amount').val(),
            payment_method: $('#payment_method').val(),
            transaction_id: $('#transaction_id').val(),
        };

        // Send the data to the PHP server using AJAX
        $.ajax({
            url: 'generate_pdf.php', // PHP script to handle the PDF generation
            type: 'POST',
            data: paymentData,
            success: function(response) {
                // After the data is processed, generate PDF client-side using jsPDF
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();

                // Add content to PDF from form data
                doc.text('Payment Report', 20, 20);
                doc.text('Payment ID: ' + paymentData.payment_id, 20, 30);
                doc.text('Appointment Name: ' + paymentData.appointment_name, 20, 40);
                doc.text('Amount Paid: ' + paymentData.amount, 20, 60);
                doc.text('Payment Method: ' + paymentData.payment_method, 20, 70);
                doc.text('Transaction ID: ' + paymentData.transaction_id, 20, 80);

                // Save the PDF
                doc.save('payment_report.pdf');
            },
            error: function() {
                alert('Error generating report.');
            }
        });
    });
        //   function displayData(){
        //     $.ajax({
        //         url: 'paymentOperation.php?url=displayPayment',
        //         success: function(res){
        //             const rows = JSON.parse(res);
        //             let tableData = '';
        //             rows.forEach(row => {
        //                 tableData += `
        //                     <tr>
        //                         <td> ${row.payment_id} </td>
        //                         <td> ${row.fullName} </td>
        //                         <td> ${row.amount} </td>
        //                         <td> ${row.payment_method} </td>
        //                         <td> ${row.transaction_id} </td>
        //                         <td> ${row.payment_date} </td>
                              
        //                         <td>
        //                              <button type="button" class="btn btn-primary at-3" id="payment" data-payment_id="${row.payment_id}" 
        //                                     data-appointment_name="${row.fullName}" 
        //                                     data-total_amount="${row.amount}" 
        //                                     data-amount="${row.payment_method}" 
        //                                     data-payment_method="${row.transaction_id}"  
        //                                     data-transaction_id="${row.payment_status}" 
        //                                     >View Details</button>
                                   
        //                         </td> 
        //                     </tr>`;
        //             });

        //             if($.fn.DataTable.isDataTable('#dataTable')) {
        //                 $('#dataTable').DataTable().clear().destroy();
        //             }
        //             $('#dataTable tbody').html(tableData);

        //             $('#dataTable').DataTable({
        //                 paging: true,
        //                 searching: true,
        //                 ordering: true,
        //                 responsive: true
        //             });
        //         }
        //     });
        // }
});
</script>

  <script src="../../assets/js/bootstrap.bundle.min.js" rel="stylesheet"></script>
  <!-- container-scroller -->
  <!-- base:js -->
  <!-- <script src="../../../vendors/base/vendor.bundle.base.js"></script> -->
  <!-- end inject -->
  <!-- inject:js -->
  <script src="../../../js/off-canvas.js"></script>
  <script src="../../../js/hoverable-collapse.js"></script>
  <script src="../../../js/template.js"></script>
  <!-- end inject -->
  <!-- plugin js for this page -->
  <script src="../../../vendors/chart.js/Chart.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../../../js/chart.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
