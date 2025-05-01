<?php
session_start();
require_once '../Connection/connection.php'; // Assumes this sets $pdo
$db = new DatabaseConnection();
$pdo = $db->getConnection();

header('Content-Type: application/json'); // Ensures JSON response

$searchTerm = $_POST['searchTerm'] ?? '';

try {
    $query = "SELECT 
            id,
            full_name,
            gender,
            position,
            phone_number,
            address,
            email,
            hire_date
        FROM staff 
            WHERE full_name LIKE :search OR gender LIKE :search";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['search' => "%$searchTerm%"]);

    $staff = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['data' => $staff]);

} catch (Exception $e) {
    echo json_encode(['data' => [], 'error' => $e->getMessage()]);
}
?>
