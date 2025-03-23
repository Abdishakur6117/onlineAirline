<?php
include 'pages/Connection/connection.php';
$db = new DatabaseConnection();
$conn = $db->getConnection(); // Assuming this uses PDO

$doctor_id = 1; // Doctor ID-ga hada la login garay, waa in dynamically laga helo
$patient_id = 1; // Patient ID-ga hada la login garay

// 4-ta Patient ee ugu dambeeyay Doctor-kan uu la qabsaday
$recentPatientsQuery = "
    SELECT user_id AS patient_id, u.fullName, u.email, u.phone
    FROM users u
    JOIN appointments a ON u.id = a.patient_id
    WHERE a.doctor_id = :doctor_id
    ORDER BY a.created_at DESC
    LIMIT 4
";



// Using PDO's prepare method
$stmt = $conn->prepare($recentPatientsQuery);

// Binding parameters using bindParam (for PDO)
$stmt->bindParam(':doctor_id', $doctor_id, PDO::PARAM_INT);

// Executing the query
$stmt->execute();

// Fetching the results
$recentPatients = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 4-ta Appointment ee ugu dambeeyay Patient-kan uu qabsaday
$recentAppointmentsQuery = "
    SELECT a.id, d.fullName as doctor_name, a.date, a.status
    FROM appointments a
    JOIN doctors d ON a.doctor_id = d.id
    WHERE a.patient_id = :patient_id
    ORDER BY a.created_at DESC
    LIMIT 4
";

// Using PDO's prepare method for second query
$stmt = $conn->prepare($recentAppointmentsQuery);

// Binding parameters using bindParam (for PDO)
$stmt->bindParam(':patient_id', $patient_id, PDO::PARAM_INT);

// Executing the query
$stmt->execute();

// Fetching the results
$recentAppointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Returning the result as a JSON response
echo json_encode([
    "recentPatients" => $recentPatients,
    "recentAppointments" => $recentAppointments
]);
?>
