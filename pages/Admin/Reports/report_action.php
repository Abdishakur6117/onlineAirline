<?php
// Assuming you're using PDO for the database connection

include '../../Connection/connection.php';
$db = new DatabaseConnection();
$conn = $db->getConnection();

if ($_GET['url'] == 'searchDoctor') {
    $doctor = $_GET['doctor'];  // Get the doctor name from the GET request
    $disease = $_GET['disease'];  // Get the disease name from the GET request

    try {
        // SQL query to search for doctors based on the input
        $query = "SELECT d.fullName, d.specialty, p.availability, d.consultation_fee 
                  FROM Doctors d 
                  JOIN Patients p ON d.user_id = p.doctor_id
                  WHERE d.fullName LIKE :doctor AND p.disease LIKE :disease";

        $stmt = $conn->prepare($query);
        $stmt->bindValue(':doctor', '%' . $doctor . '%');  // Use LIKE for partial match
        $stmt->bindValue(':disease', '%' . $disease . '%');  // Use LIKE for partial match
        $stmt->execute();

        // Fetch the results
        $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the results as JSON
        if (count($doctors) > 0) {
            echo json_encode(['status' => 'success', 'data' => $doctors]);
        } else {
            echo json_encode(['status' => 'success', 'data' => []]);
        }
    } catch (Exception $e) {
        // In case of an error, return an error message
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
