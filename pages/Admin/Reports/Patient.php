<?php
$patientId = $_GET['patient_id'] ?? '';
if (!$patientId) {
    die("Patient ID is required.");
}

include '../../Connection/connection.php';
$db = new DatabaseConnection();
$conn = $db->getConnection();

$sql = "SELECT 
            p.*, 
            u_patient.fullName AS patient_fullName,
            a.appointment_date, 
            a.payment_status, 
            u_doctor.fullName AS doctor_fullName
        FROM patients p
        LEFT JOIN users u_patient ON p.user_id = u_patient.user_id
        LEFT JOIN appointments a ON p.patient_id = a.patient_id
        LEFT JOIN doctors d ON a.doctor_id = d.doctor_id
        LEFT JOIN users u_doctor ON d.user_id = u_doctor.user_id
        WHERE p.patient_id = :patient_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':patient_id', $patientId);
$stmt->execute();

$patient = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$patient) {
    die("Patient not found.");
}

// Store first patient record
$firstPatient = $patient;
$appointments = [];

// Collect all appointments
do {
    if (!empty($patient['appointment_date'])) {
        $appointments[] = $patient;
    }
} while ($patient = $stmt->fetch(PDO::FETCH_ASSOC));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Report - <?= htmlspecialchars($firstPatient['patient_fullName']) ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 20px;
        }
        .patient-info {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            box-shadow: 0 2px 3px rgba(0,0,0,0.1);
        }
        th {
            background-color: #3498db;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e9f7fe;
        }
        .no-appointments {
            text-align: center;
            color: #7f8c8d;
            font-style: italic;
            padding: 20px;
        }
        .print-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 20px 0;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .print-btn:hover {
            background-color: #2980b9;
        }
        @media print {
            .print-btn {
                display: none;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Patient Medical Report</h1>
        <p>Generated on: <?= date('F j, Y') ?></p>
    </div>

    <div class="patient-info">
        <h2>Patient Information</h2>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Full Name:</span>
                <span><?= htmlspecialchars($firstPatient['patient_fullName']) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Date of Birth:</span>
                <span><?= htmlspecialchars($firstPatient['date_of_birth']) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Gender:</span>
                <span><?= htmlspecialchars($firstPatient['gender']) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Blood Type:</span>
                <span><?= htmlspecialchars($firstPatient['blood_type']) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Address:</span>
                <span><?= htmlspecialchars($firstPatient['address']) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Registration Date:</span>
                <span><?= htmlspecialchars($firstPatient['registration_date']) ?></span>
            </div>
        </div>
    </div>

    <h2>Appointment History</h2>
    <?php if (!empty($appointments)) : ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Doctor</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appointment) : ?>
                    <tr>
                        <td><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                        <td><?= htmlspecialchars($appointment['doctor_fullName']) ?? 'N/A' ?></td>
                        <td>
                            <span style="color: <?= $appointment['payment_status'] === 'Paid' ? 'green' : 'red' ?>;">
                                <?= htmlspecialchars($appointment['payment_status']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="no-appointments">
            <p>No appointment records found for this patient.</p>
        </div>
    <?php endif; ?>

    <button class="print-btn" onclick="window.print()"><i class="fas fa-print"></i>Print Report</button>
    <!-- Optional: Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>