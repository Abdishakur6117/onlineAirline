<?php
include 'pages/Connection/connection.php';
$db = new DatabaseConnection();
$conn = $db->getConnection(); 

$patient_id = 1; // Halkan waa in dynamically loo helaa user-ka hadda login garay

// Xisaabinta wadar tirada xogaha muhiimka ah
$totalAppointmentsQuery = "SELECT COUNT(*) AS total FROM appointments WHERE patient_id = ?";
$acceptedAppointmentsQuery = "SELECT COUNT(*) AS total FROM appointments WHERE patient_id = ? AND status = 'Accepted'";
$rejectedAppointmentsQuery = "SELECT COUNT(*) AS total FROM appointments WHERE patient_id = ? AND status = 'Rejected'";
$totalPaymentsQuery = "SELECT SUM(amount) AS total FROM payments WHERE patient_id = ?";

// Recent appointments (4-ta ugu dambeysay)
$recentAppointmentsQuery = "SELECT a.id, d.name as doctor_name, a.date, a.status FROM appointments a 
                            JOIN doctors d ON a.doctor_id = d.id 
                            WHERE a.patient_id = ? ORDER BY a.date DESC LIMIT 4";

$stmt = $conn->prepare($totalAppointmentsQuery);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$totalAppointments = $stmt->get_result()->fetch_assoc()['total'];

$stmt = $conn->prepare($upcomingAppointmentsQuery);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$upcomingAppointments = $stmt->get_result()->fetch_assoc()['total'];

$stmt = $conn->prepare($acceptedAppointmentsQuery);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$acceptedAppointments = $stmt->get_result()->fetch_assoc()['total'];

$stmt = $conn->prepare($rejectedAppointmentsQuery);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$rejectedAppointments = $stmt->get_result()->fetch_assoc()['total'];

$stmt = $conn->prepare($totalPaymentsQuery);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$totalPayments = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

$stmt = $conn->prepare($recentAppointmentsQuery);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$recentAppointments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

echo json_encode([
    "totalAppointments" => $totalAppointments,
    "upcomingAppointments" => $upcomingAppointments,
    "acceptedAppointments" => $acceptedAppointments,
    "rejectedAppointments" => $rejectedAppointments,
    "totalPayments" => $totalPayments,
    "recentAppointments" => $recentAppointments
]);
?>