<?php
session_start();

// Check if the user is logged in and has the 'Admin' role
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'staff') {
    header("Location: login.php");
    exit();
}

require_once '../Connection/connection.php';

$db = new DatabaseConnection();
$pdo = $db->getConnection();

// Get passenger ID
$passengerId = $_GET['id'] ?? null;
if (!$passengerId) {
    echo "Invalid passenger ID.";
    exit();
}

// Fetch passenger details
$passengerQuery = "
    SELECT 
        ps.passenger_id,
        CONCAT(ps.first_name, ' ', ps.last_name) AS passenger_name,
        ps.gender,
        ps.email,
        ps.phone,
        ps.passport_no,
        ps.date_of_birth,
        ps.nationality,
        ps.address,
        ps.created_at
    FROM passengers ps 
    WHERE ps.passenger_id = :id
";
$stmt = $pdo->prepare($passengerQuery);
$stmt->execute(['id' => $passengerId]);
$passenger = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$passenger) {
    echo "Passenger not found.";
    exit();
}

// Fetch booking, flight, ticket
$bookingQuery = "
    SELECT 
        b.booking_id, 
        b.seat_number, 
        b.flight_id, 
        f.flight_number, 
        f.origin, 
        f.destination, 
        f.departure_date,
        t.ticket_id,
        t.barcode
    FROM bookings b
    JOIN flights f ON b.flight_id = f.flight_id
    LEFT JOIN tickets t ON b.booking_id = t.booking_id
    WHERE b.passenger_id = :id
";
$stmt = $pdo->prepare($bookingQuery);
$stmt->execute(['id' => $passengerId]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch payment only if booking exists
$payment = null;
if ($booking && isset($booking['booking_id'])) {
    $paymentQuery = "
        SELECT 
            p.payment_id,
            p.amount,
            p.payment_date,
            p.method
        FROM payments p
        WHERE p.booking_id = :booking_id
    ";
    $stmt = $pdo->prepare($paymentQuery);
    $stmt->execute(['booking_id' => $booking['booking_id']]);
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Passenger Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
            padding: 30px;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            margin-bottom: 30px;
            border-radius: 12px;
            border: none;
            box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        }
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-top: 25px;
        }
        .table th {
            background: #2c3e50;
            color: white;
        }
        .btn-print {
            margin-top: 30px;
        }
        .alert-custom {
            background-color: #f9d6d5;
            color: #a94442;
            border: 1px solid #e6c1c0;
            padding: 15px;
            border-radius: 6px;
        }
        @media print {
            body {
                background: white;
                font-size: 12px;
                padding: 0;
            }
            .card {
                box-shadow: none;
                border: none;
            }
            .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<h2 class="text-center mb-5">Passenger Report</h2>

<div class="container">
    <!-- Passenger Details -->
    <div class="card">
        <div class="card-body">
            <h4 class="mb-3 text-primary"><strong>Passenger Details:</strong></h4>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Full Name:</strong> <?= htmlspecialchars($passenger['passenger_name']) ?></p>
                    <p><strong>Gender:</strong> <?= htmlspecialchars($passenger['gender']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($passenger['email']) ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($passenger['phone']) ?></p>
                    <p><strong>Passport Number:</strong> <?= htmlspecialchars($passenger['passport_no']) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Date of Birth:</strong> <?= htmlspecialchars($passenger['date_of_birth']) ?></p>
                    <p><strong>Nationality:</strong> <?= htmlspecialchars($passenger['nationality']) ?></p>
                    <p><strong>Address:</strong> <?= htmlspecialchars($passenger['address']) ?></p>
                    <p><strong>Registration Date:</strong> <?= htmlspecialchars($passenger['created_at']) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Flight Details -->
    <?php if ($booking): ?>
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 text-primary"><strong>Flight Details:</strong></h4>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Flight Number:</strong> <?= htmlspecialchars($booking['flight_number']) ?></p>
                        <p><strong>Route:</strong> <?= htmlspecialchars($booking['origin']) ?> → <?= htmlspecialchars($booking['destination']) ?></p>
                        <p><strong>Departure Date:</strong> <?= htmlspecialchars($booking['departure_date']) ?></p>
                        <p><strong>Seat Number:</strong> <?= htmlspecialchars($booking['seat_number']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Ticket ID:</strong> <?= htmlspecialchars($booking['ticket_id'] ?? 'N/A') ?></p>
                        <p><strong>Ticket Barcode:</strong> <?= htmlspecialchars($booking['barcode'] ?? 'N/A') ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-custom">This passenger has no booking or flight information available.</div>
    <?php endif; ?>

    <!-- Payment Details -->
    <?php if ($payment): ?>
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 text-primary"><strong>Payment Details:</strong></h4>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Payment Amount:</strong> $<?= htmlspecialchars($payment['amount']) ?></p>
                        <p><strong>Payment Date:</strong> <?= htmlspecialchars($payment['payment_date']) ?></p>
                        <p><strong>Payment Method:</strong> <?= htmlspecialchars($payment['method']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif ($booking): ?>
        <div class="alert alert-custom">This booking has no payment record available.</div>
    <?php endif; ?>

    <!-- Print Button -->
    <div class="text-center">
        <button class="btn btn-primary btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Print Report
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
