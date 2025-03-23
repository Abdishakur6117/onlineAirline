<?php
// $route = $_REQUEST['url'];
// $route();
function displayPayment(){
    include '../../Connection/connection.php';
    include '../../Connection/code.php';
    $db = new DatabaseConnection();
    $database = $db->getConnection();
    $query = new myCode($database);

    // Modify the query to join Payment, Appointment, Patient, and User tables
$sql = "SELECT 
    p.payment_id, 
    p.appointment_id, 
    p.amount, 
    p.payment_method, 
    p.transaction_id, 
    p.payment_date, 
    u.fullName AS fullName
FROM Payments p
INNER JOIN Appointments a ON p.appointment_id = a.appointment_id
INNER JOIN Patients pt ON a.patient_id = pt.patient_id
INNER JOIN Users u ON pt.user_id = u.user_id;
";

$stmt = $database->prepare($sql);
$stmt->execute();

$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output to confirm results
if (empty($payments)) {
    echo json_encode(['status' => 'error', 'message' => 'No data found']);
} else {
    echo json_encode($payments);
}

}


?>