<?php
$patientId = $_GET['patient_id'] ?? '';
if (!$patientId) {
    die("Patient ID is required.");
}

include '../../Connection/connection.php';
$db = new DatabaseConnection();
$conn = $db->getConnection();

// Corrected SQL Query
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Report</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Patient Report</h2>
    
    <!-- Patient Details -->
    <h3>Patient Information</h3>
    <p>Name: <?= htmlspecialchars($patient['patient_fullName']) ?></p>
    <p>DOB: <?= htmlspecialchars($patient['date_of_birth']) ?></p>
    <p>Gender: <?= htmlspecialchars($patient['gender']) ?></p>
    <p>Blood Type: <?= htmlspecialchars($patient['blood_type']) ?></p>
    <p>Address: <?= htmlspecialchars($patient['address']) ?></p>
    <p>Registration Date: <?= htmlspecialchars($patient['registration_date']) ?></p>

    <!-- Appointments Table -->
    <h3>Appointments</h3>
    <?php if (!empty($patient['appointment_date'])) : ?>
        <table>
            <thead>
                <tr>
                    <th>Appointment Date</th>
                    <th>Doctor</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php do { ?>
                    <tr>
                        <td><?= htmlspecialchars($patient['appointment_date']) ?></td>
                        <td><?= htmlspecialchars($patient['doctor_fullName']) ?? 'N/A' ?></td>
                        <td><?= htmlspecialchars($patient['payment_status']) ?></td>
                    </tr>
                <?php } while ($patient = $stmt->fetch(PDO::FETCH_ASSOC)); ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No appointments found.</p>
    <?php endif; ?>

    <button onclick="window.print()">Print Report</button>
</body>
</html>