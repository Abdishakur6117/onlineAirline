<?php
session_start();
require_once '../Connection/connection.php'; 
$db = new DatabaseConnection();
$pdo = $db->getConnection();

header('Content-Type: application/json');

$searchTerm = $_POST['searchTerm'] ?? '';

try {
    $query = "
        SELECT 
            ps.passenger_id,
            CONCAT(ps.first_name, ' ', ps.last_name) AS passenger_name,
            ps.email,
            ps.phone,
            ps.gender,
            ps.passport_no,
            ps.date_of_birth,
            ps.nationality,
            ps.address,
            ps.created_at
        FROM passengers ps
        WHERE 
            CONCAT(ps.first_name, ' ', ps.last_name) LIKE :search
            OR ps.email LIKE :search
            OR ps.phone LIKE :search
            OR ps.gender LIKE :search
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['search' => "%$searchTerm%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['data' => $results]);

} catch (Exception $e) {
    echo json_encode(['data' => [], 'error' => $e->getMessage()]);
}

?>
