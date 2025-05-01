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
$childrenId = $_GET['id'] ?? null;
if (!$childrenId) {
    echo "Invalid children ID.";
    exit();
}

// Fetch children details
$childrenQuery = "SELECT id, full_name, gender, date_of_birth, parent_name, parent_number, address, registration_date FROM beneficiaries WHERE id = :id";
$stmt = $pdo->prepare($childrenQuery);
$stmt->execute(['id' => $childrenId]);
$children = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$children) {
    echo "Child not found.";
    exit();
}

// Fetch feeding records
$feedingStmt = $pdo->prepare("
    SELECT 
        f.id,
        b.full_name AS children_name,
        fp.program_name AS feeding_program_name,
        m.meal_name AS meal_name,
        f.feeding_date,
        f.quantity,
        u.username AS user_name
    FROM feeding_records f 
    JOIN beneficiaries b ON f.beneficiary_id = b.id
    JOIN feeding_programs fp ON f.feeding_program_id = fp.id
    JOIN meals m ON f.meal_id = m.id
    JOIN users u ON f.recorded_by = u.id
    WHERE beneficiary_id = ?
");
$feedingStmt->execute([$children['id']]);
$feeding = $feedingStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch nutrition assessments
$attStmt = $pdo->prepare("SELECT assessment_date AS date, weight, height, muac, health_notes FROM nutrition_assessments WHERE beneficiary_id = ? ORDER BY assessment_date DESC LIMIT 30");
$attStmt->execute([$children['id']]);
$assessments = $attStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2 class="text-center mb-5">Children Report</h2>

<div class="card">
    <div class="card-body">
        <h4 class="mb-3 text-primary"><strong>FullName:</strong><?= htmlspecialchars($children['full_name']) ?> 
            
        </h4>

        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Gender:</strong> <?= htmlspecialchars($children['gender']) ?></p>
                <p><strong>DOB:</strong> <?= htmlspecialchars($children['date_of_birth']) ?></p>
                <p><strong>Parent Name:</strong> <?= htmlspecialchars($children['parent_name']) ?></p>
                <p><strong>Parent Number:</strong> <?= htmlspecialchars($children['parent_number']) ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Address:</strong> <?= htmlspecialchars($children['address']) ?></p>
                <p><strong>Registration Date:</strong> <?= htmlspecialchars($children['registration_date']) ?></p>
            </div>
        </div>

        <?php if (count($feeding)): ?>
            <div class="section-title">🍽️ Feeding Record History</div>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Children Name</th>
                        <th>Feeding Program</th>
                        <th>Meal</th>
                        <th>Feeding Date</th>
                        <th>Quantity</th>
                        <th>Recorded By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feeding as $feed): ?>
                        <tr>
                            <td><?= htmlspecialchars($feed['children_name']) ?></td>
                            <td><?= htmlspecialchars($feed['feeding_program_name']) ?></td>
                            <td><?= htmlspecialchars($feed['meal_name']) ?></td>
                            <td><?= htmlspecialchars($feed['feeding_date']) ?></td>
                            <td><?= htmlspecialchars($feed['quantity']) ?></td>
                            <td><?= htmlspecialchars($feed['user_name']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <?php if (count($assessments)): ?>
            <div class="section-title">🩺 Nutrition Assessment</div>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Weight (kg)</th>
                        <th>Height (cm)</th>
                        <th>MUAC (cm)</th>
                        <th>Health Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($assessments as $a): ?>
                        <tr>
                            <td><?= htmlspecialchars($a['date']) ?></td>
                            <td><?= htmlspecialchars($a['weight']) ?></td>
                            <td><?= htmlspecialchars($a['height']) ?></td>
                            <td><?= htmlspecialchars($a['muac']) ?></td>
                            <td><?= htmlspecialchars($a['health_notes']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
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
