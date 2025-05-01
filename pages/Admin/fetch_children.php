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
            date_of_birth,
            parent_name,
            parent_number,
            address,
            registration_date
        FROM beneficiaries 
            WHERE full_name LIKE :search OR gender LIKE :search";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['search' => "%$searchTerm%"]);

    $children = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['data' => $children]);

} catch (Exception $e) {
    echo json_encode(['data' => [], 'error' => $e->getMessage()]);
}
?>
