<?php
$route = $_REQUEST['url'];
$route();
function getDoctor() {
    include '../../Connection/connection.php';
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    // Get the POST data
    $doctor_name = $_POST['doctor_name'] ?? '';
    $specialist = $_POST['specialist'] ?? '';

    // Fetch doctor details using JOIN
    $sql = "SELECT users.fullName, doctors.specialization, doctors.availability,doctors.consultation_fee 
            FROM users 
            INNER JOIN doctors ON users.user_id = doctors.user_id 
            WHERE users.fullName = :name AND doctors.specialization = :specialist";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":name", $doctor_name);
    $stmt->bindParam(":specialist", $specialist);
    $stmt->execute();

    $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($doctor) {
        echo json_encode(["status" => "success", "data" => $doctor]);
    } else {
        echo json_encode(["status" => "error", "message" => "Doctor not found."]);
    }
}
// function getPatient() {
//     include '../../Connection/connection.php';
//     $db = new DatabaseConnection();
//     $conn = $db->getConnection();
//     // Get the POST data
//     $patient_name = $_POST['patient_name'] ?? '';
//     // $specialist = $_POST['specialist'] ?? '';

//     // Fetch doctor details using JOIN
//     $sql = "SELECT  users.fullName, patients.date_of_birth, patients.gender,patients.blood_type, patients.address, patients.registration_date 
//             FROM users 
//             INNER JOIN patients ON users.user_id = patients.user_id 
//             WHERE users.fullName = :name ";

//     $stmt = $conn->prepare($sql);
//     $stmt->bindParam(":name", $patient_name);
//     // $stmt->bindParam(":specialist", $specialist);
//     $stmt->execute();

//     $doctor = $stmt->fetch(PDO::FETCH_ASSOC);

//     if ($doctor) {
//         echo json_encode(["status" => "success", "data" => $doctor]);
//     } else {
//         echo json_encode(["status" => "error", "message" => "Doctor not found."]);
//     }
// }
function getPatient() {
    include '../../Connection/connection.php';
    $db = new DatabaseConnection();
    $conn = $db->getConnection();

    // Get the POST data
    $patient_name = $_POST['patient_name'] ?? '';

    // Correct SQL query (removed PHP-style comments)
    $sql = "SELECT 
                patients.patient_id,  -- Include patient_id
                users.fullName, 
                patients.date_of_birth, 
                patients.gender,
                patients.blood_type, 
                patients.address, 
                patients.registration_date 
            FROM users 
            INNER JOIN patients ON users.user_id = patients.user_id 
            WHERE users.fullName = :name";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":name", $patient_name);
    $stmt->execute();

    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($patient) {
        echo json_encode(["status" => "success", "data" => $patient]);
    } else {
        echo json_encode(["status" => "error", "message" => "Patient not found."]);
    }
}
?>
