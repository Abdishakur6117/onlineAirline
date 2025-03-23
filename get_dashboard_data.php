<?php
include 'pages/Connection/connection.php';
$db = new DatabaseConnection();
$conn = $db->getConnection();

// Get total number of users, doctors, patients, appointments
$totalUsers = $conn->query("SELECT COUNT(*) as count FROM Users")->fetch(PDO::FETCH_ASSOC)['count'];
$totalDoctors = $conn->query("SELECT COUNT(*) as count FROM Users WHERE role='Doctor'")->fetch(PDO::FETCH_ASSOC)['count'];
$totalPatients = $conn->query("SELECT COUNT(*) as count FROM Users WHERE role='Patient'")->fetch(PDO::FETCH_ASSOC)['count'];

$totalAppointments = $conn->query("SELECT COUNT(*) as count FROM appointments")->fetch(PDO::FETCH_ASSOC)['count'];
$totalAccepted = $conn->query("SELECT COUNT(*) as count FROM appointments WHERE status='accepted'")->fetch(PDO::FETCH_ASSOC)['count'];
$totalRejected = $conn->query("SELECT COUNT(*) as count FROM appointments WHERE status='rejected'")->fetch(PDO::FETCH_ASSOC)['count'];

$totalRevenue = $conn->query("SELECT SUM(amount) as revenue FROM payments")->fetch(PDO::FETCH_ASSOC)['revenue'] ?? 0;

$response = [
    "totalUsers" => $totalUsers,
    "totalDoctors" => $totalDoctors,
    "totalPatients" => $totalPatients,
    "totalAppointments" => $totalAppointments,
    "totalAccepted" => $totalAccepted,
    "totalRejected" => $totalRejected,
    "totalRevenue" => number_format($totalRevenue, 2) . " USD"
];

echo json_encode($response);
?>
