<?php
session_start();
header('Content-Type: application/json');
require_once '../Connection/connection.php';

$action = $_GET['action'] ?? '';

try {
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    
    switch ($action) {                  
        case 'display_ticket':
          display_ticket($conn);
            break;
            
        default:
            throw new Exception('Invalid action');
    }
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

function display_ticket($conn) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'passenger') {
        echo json_encode([
            'status' => 'error',
            'message' => 'User not logged in or not a passenger'
        ]);
        return;
    }

    $passenger_id = $_SESSION['user_id'];
  $query = "
      SELECT 
          t.ticket_id,
          CONCAT(ps.first_name, ' ', ps.last_name) AS passenger_name,
          t.issue_date,
          t.barcode,
          f.flight_number,
          f.origin,
          f.destination,
          b.seat_number
      FROM tickets t
      JOIN bookings b ON t.booking_id = b.booking_id
      JOIN flights f ON b.flight_id = f.flight_id
      JOIN passengers ps ON b.passenger_id = ps.passenger_id
       WHERE b.passenger_id = ?
  ";

  try {
    $stmt = $conn->prepare($query);
    $stmt->execute([$passenger_id]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => $results
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
}

?>