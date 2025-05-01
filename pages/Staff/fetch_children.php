<?php
session_start();
require_once '../Connection/connection.php';

$db = new DatabaseConnection();
$pdo = $db->getConnection();

header('Content-Type: application/json');

$searchTerm = $_POST['searchTerm'] ?? '';
$created_by = $_SESSION['id'] ?? null; // ID-ga userka login-ka ah

if (!$created_by) {
    echo json_encode(['data' => [], 'error' => 'User not authenticated']);
    exit;
}

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
              WHERE 
                (full_name LIKE :search OR gender LIKE :search)
                AND created_by = :created_by";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'search' => "%$searchTerm%",
        'created_by' => $created_by
    ]);

    $children = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['data' => $children]);

} catch (Exception $e) {
    echo json_encode(['data' => [], 'error' => $e->getMessage()]);
}
?>
