<?php
session_start();

// Check if the user is logged in and has the 'passenger' role
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'passenger') {
    // Redirect to login page if not logged in or not an passenger
    header("Location: login.php");
    exit();
}
?>



<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- <link rel="stylesheet" href="../assets/vendor/datatables/css/dataTables.bootstrap4.css"> -->
    <title>Online Airline</title>
    <style>
        .nav-left-sidebar .navbar-nav .nav-item {
            margin-top: 10px;
        }
        .nav-left-sidebar {
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
        }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="../passenger_dashboard.php">Online Airline</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item">
                            <div id="custom-search" class="top-search-bar">
                                <input class="form-control" type="text" placeholder="Search..">
                            </div>
                        </li>
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../assets/images/avatar-1.jpg" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name"><?php echo htmlspecialchars($_SESSION['user']); ?> </h5>
                                    <span class="status"></span><span class="ml-2"><?php echo htmlspecialchars($_SESSION['role']); ?></span>
                                </div>
                                <a class="dropdown-item" href="../logout.php"><i class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light ">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-item ">
                                <a class="nav-link  margin-top-10" href="../passenger_dashboard.php"><i class="fa fa-fw fa-user-circle"></i>Dashboard</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fab fa-fw fa-wpforms"></i>Flights</a>
                                <div id="submenu-4" class="collapse submenu" >
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="../passenger/flight.php">List  Flight</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-5" aria-controls="submenu-5"><i class="fas fa-fw fa-table"></i>Booking</a>
                                <div id="submenu-5" class="collapse submenu" >
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="../passenger/Booking.php">List  Booking</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-fw fa-file"></i> Payments </a>
                                <div id="submenu-6" class="collapse submenu" >
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="../passenger/payment.php">List  Payment</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-fw fa-inbox"></i>Tickets <span class="badge badge-secondary">New</span></a>
                                <div id="submenu-7" class="collapse submenu" >
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="../passenger/ticket.php">List Ticket</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <h2>Ticket Form</h2>
                    <br>
                    <br>
                    <table id="dataTable" class="table table-striped table-bordered">
                      <thead>
                          <tr>
                              <td>Ticket ID</td>
                              <td>Passenger Name</td>
                              <td>Issue Date</td>
                              <td>Barcode</td>
                              <td>Actions</td>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                </div>

                  <!-- Ticket Info Card -->
                  <div id="ticketCard" class="card mt-4 d-none">
                      <div class="card-body">
                          <h5 class="card-title">Ticket Details</h5>
                          <p><strong>Ticket ID:</strong> <span id="cardTicketId"></span></p>
                          <p><strong>Passenger Name:</strong> <span id="cardPassengerName"></span></p>
                          <p><strong>Issue Date:</strong> <span id="cardIssueDate"></span></p>
                          <p><strong>Barcode (QR):</strong></p>
                          <p><strong>Flight:</strong> <span id="cardFlight"></span></p>
                          <p><strong>Route:</strong> <span id="cardRoute"></span></p>
                          <p><strong>Seat Number:</strong> <span id="cardSeat"></span></p>
                          <div id="cardBarcodeQR"></div> <!-- Halkan QR code-ka -->
                          <button id="downloadBtn" class="btn btn-primary mt-3">Download</button>
                      </div>
                  </div>
            </div>

            <!-- ============================================================== -->
                                 <!-- footer -->
            <!-- ============================================================== -->
            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            Copyright © 2018 Concept. All rights reserved. Dashboard by <a href="https://colorlib.com/wp/">Colorlib</a>.
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->

        <!-- ============================================================== -->
    </div>
    
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
<!-- jQuery first -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
 <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
 <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
 <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
 <!-- Ku dar jsPDF CDN haddii aad rabto PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>  
<script>
  $(document).ready(function () {

      displayData();

    //   function displayData() {
    //     $.ajax({
    //       url: 'ticketOperation.php?action=display_ticket',
    //       dataType: 'json',
    //       success: function (response) {
    //         if (!response || !Array.isArray(response)) {
    //           alert('Invalid data received from server');
    //           return;
    //         }

    //         let tableData = '';
    //         response.forEach(row => {
    //           tableData += `
    //             <tr>
    //               <td>${row.ticket_id}</td>
    //               <td>${row.passenger_name}</td>
    //               <td>${row.issue_date}</td>
    //               <td>${row.barcode}</td>
    //               <td>
    //                 <button class="btn btn-info btn-sm viewBtn"
    //                   data-id="${row.ticket_id}"
    //                   data-name="${row.passenger_name}"
    //                   data-date="${row.issue_date}"
    //                   data-barcode="${row.barcode}"
    //                   data-flight="${row.flight_number}"
    //                   data-from="${row.origin}"
    //                   data-to="${row.destination}"
    //                   data-seat="${row.seat_number}">
    //                   View
    //                 </button>
    //               </td>
    //             </tr>`;
    //         });

    //         if ($.fn.DataTable.isDataTable('#dataTable')) {
    //           $('#dataTable').DataTable().destroy();
    //         }

    //         $('#dataTable tbody').html(tableData);
    //         $('#dataTable').DataTable();

    //         // View button click
    //         $('.viewBtn').on('click', function () {
    //           const ticketId = $(this).data('id');
    //           const passengerName = $(this).data('name');
    //           const issueDate = $(this).data('date');
    //           const flightNumber = $(this).data('flight');
    //           const fromCity = $(this).data('from');
    //           const toCity = $(this).data('to');
    //           const seatNumber = $(this).data('seat');

    //           // Set text content
    //           $('#cardTicketId').text(ticketId);
    //           $('#cardPassengerName').text(passengerName);
    //           $('#cardIssueDate').text(issueDate);
    //           $('#cardFlight').text(flightNumber);
    //           $('#cardRoute').text(`${fromCity} → ${toCity}`);
    //           $('#cardSeat').text(seatNumber);

    //           // Short QR content
    //           const qrText = `
    //           Ticket: ${ticketId}
    //           Name: ${passengerName}
    //           Flight: ${flightNumber}
    //           Seat: ${seatNumber}
    //           Date: ${issueDate}
    //           `.trim();

    //           $('#cardBarcodeQR').empty();
    //           new QRCode(document.getElementById("cardBarcodeQR"), {
    //             text: qrText,
    //             width: 128,
    //             height: 128,
    //             useSVG: false
    //           });

    //           $('#ticketCard').removeClass('d-none');
    //         });
    //       },
    //       error: function (xhr, status, error) {
    //         alert('Failed to load ticket data: ' + error);
    //       }
    //     });
    //   }
    function displayData() {
        $.ajax({
            url: 'ticketOperation.php?action=display_ticket',
            dataType: 'json',
            success: function(response) {
            // Hubi in response uu leeyahay status=success iyo data (array)
            if (!response || response.status !== 'success' || !Array.isArray(response.data)) {
                alert('Invalid data received from server');
                return;
            }

            let tableData = '';
            response.data.forEach(row => {
                tableData += `
                <tr>
                    <td>${row.ticket_id}</td>
                    <td>${row.passenger_name}</td>
                    <td>${row.issue_date}</td>
                    <td>${row.barcode}</td>
                    <td>
                    <button class="btn btn-info btn-sm viewBtn"
                        data-id="${row.ticket_id}"
                        data-name="${row.passenger_name}"
                        data-date="${row.issue_date}"
                        data-barcode="${row.barcode}"
                        data-flight="${row.flight_number}"
                        data-from="${row.origin}"
                        data-to="${row.destination}"
                        data-seat="${row.seat_number}">
                        View
                    </button>
                    </td>
                </tr>`;
            });

            if ($.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable().destroy();
            }

            $('#dataTable tbody').html(tableData);
            $('#dataTable').DataTable();

            // View button click
            $('.viewBtn').on('click', function() {
                const ticketId = $(this).data('id');
                const passengerName = $(this).data('name');
                const issueDate = $(this).data('date');
                const flightNumber = $(this).data('flight');
                const fromCity = $(this).data('from');
                const toCity = $(this).data('to');
                const seatNumber = $(this).data('seat');

                // Set text content
                $('#cardTicketId').text(ticketId);
                $('#cardPassengerName').text(passengerName);
                $('#cardIssueDate').text(issueDate);
                $('#cardFlight').text(flightNumber);
                $('#cardRoute').text(`${fromCity} → ${toCity}`);
                $('#cardSeat').text(seatNumber);

                // Short QR content
                const qrText = `
                Ticket: ${ticketId}
                Name: ${passengerName}
                Flight: ${flightNumber}
                Seat: ${seatNumber}
                Date: ${issueDate}
                `.trim();

                $('#cardBarcodeQR').empty();
                new QRCode(document.getElementById("cardBarcodeQR"), {
                text: qrText,
                width: 128,
                height: 128,
                useSVG: false
                });

                $('#ticketCard').removeClass('d-none');
            });
            },
            error: function(xhr, status, error) {
            alert('Failed to load ticket data: ' + error);
            }
        });
    }

    // Download PDF
    $('#downloadBtn').on('click', function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const ticketId = $('#cardTicketId').text();
    const passengerName = $('#cardPassengerName').text();
    const issueDate = $('#cardIssueDate').text();
    const flightNumber = $('#cardFlight').text();
    const route = $('#cardRoute').text();
    const seatNumber = $('#cardSeat').text();

    const qrText = `
    Ticket: ${ticketId}
    Name: ${passengerName}
    Flight: ${flightNumber}
    Seat: ${seatNumber}
    Date: ${issueDate}
    `.trim();

    doc.setFontSize(14);
    doc.text("Ticket Details", 10, 10);
    doc.setFontSize(12);
    doc.text(`Ticket ID: ${ticketId}`, 10, 20);
    doc.text(`Passenger: ${passengerName}`, 10, 30);
    doc.text(`Flight: ${flightNumber}`, 10, 40);
    doc.text(`Route: ${route}`, 10, 50);
    doc.text(`Seat: ${seatNumber}`, 10, 60);
    doc.text(`Issue Date: ${issueDate}`, 10, 70);

    const qrImg = $('#cardBarcodeQR img')[0];
    if (qrImg) {
        doc.text("QR Code:", 10, 85);
        doc.addImage(qrImg.src, 'PNG', 10, 90, 50, 50);
    }

    doc.save(`ticket_${ticketId}.pdf`);
    });



  });
</script>
    
    <!-- bootstap bundle js -->
    <!-- slimscroll js -->
    <script src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="../assets/libs/js/main-js.js"></script>
</body>
</html>