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
    <meta charset="UTF-8">
    <title>Children Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
            padding: 30px;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            margin-bottom: 40px;
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

<?php
require_once '../Connection/connection.php';

$db = new DatabaseConnection();
$pdo = $db->getConnection();

// Get children ID
$staffId = $_GET['id'] ?? null;
if (!$staffId) {
    echo "Invalid children ID.";
    exit();
}

// Fetch Staff details
$staffQuery = "SELECT 
            id,
            full_name,
            gender,
            position,
            phone_number,
            address,
            email,
            hire_date
        FROM staff  WHERE id = :id";
$stmt = $pdo->prepare($staffQuery);
$stmt->execute(['id' => $staffId]);
$staff = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$staff) {
    echo "staff not found.";
    exit();
}
?>

<h2 class="text-center mb-5">Staff Report</h2>

<div class="card">
    <div class="card-body">
        <h4 class="mb-3 text-primary"><strong>Staff Details:</strong> 
            
        </h4>

        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>FullName:</strong> <?= htmlspecialchars($staff['full_name']) ?></p>
                <p><strong>Gender:</strong> <?= htmlspecialchars($staff['gender']) ?></p>
                <p><strong>Position:</strong> <?= htmlspecialchars($staff['position']) ?></p>
                
                <p><strong>Address:</strong> <?= htmlspecialchars($staff['address']) ?></p>
            </div>
            <div class="col-md-6">
              <p><strong>Phone Number:</strong> <?= htmlspecialchars($staff['phone_number']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($staff['email']) ?></p>
                <p><strong>Hire Date:</strong> <?= htmlspecialchars($staff['hire_date']) ?></p>
            </div>
        </div>
    </div>
</div>

<div class="text-center">
    <button class="btn btn-primary btn-print" onclick="window.print()">
        <i class="fas fa-print"></i> Print Report
    </button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
