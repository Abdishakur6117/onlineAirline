<?php
header('Content-Type: application/json');
require_once '../Connection/connection.php';

$action = $_GET['action'] ?? '';

try {
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    
    switch ($action) { 
        case 'get_aircraft':
            get_aircraft($conn);
            break;           
        case 'display_flight':
            display_flight($conn);
            break;
            
        case 'create_flight':
            create_flight($conn);
            break;
            
        case 'update_flight':
            update_flight($conn);
            break;
            
        case 'delete_flight':
            delete_flight($conn);
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

function get_aircraft($conn) {
    $stmt = $conn->query("SELECT aircraft_id, model FROM aircrafts ORDER BY model");
    echo json_encode([
        'status' => 'success',
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ]);
}

function display_flight($conn) {
    $query = "
        SELECT 
            f.flight_id,
            f.flight_number,
            f.origin,
            f.destination,
            f.departure_date,
            f.departure_time,
            f.arrival_time,
            f.total_seats,
            f.available_seats,
            f.price,
            a.aircraft_id as aircraft_id,
            a.model as model
        FROM flights f
        JOIN aircrafts a ON f.aircraft_id = a.aircraft_id
    ";
    
    $stmt = $conn->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function create_flight($conn) {
    $required = ['flight_number', 'origin','destination','departure_date','departure_time','arrival_time','total_seats','available_seats','price','aircraft_id'];
    $data = [];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        $data[$field] = $_POST[$field];
    }

    // Check for duplicate username 
    $stmt = $conn->prepare("
        SELECT flight_id FROM flights 
        WHERE flight_number = ?  
    ");
    $stmt->execute([$data['flight_number']]);
    if ($stmt->rowCount() > 0) {
        throw new Exception('flight record already exists for this flight_number');
    }
    // Insert record
    $stmt = $conn->prepare("
        INSERT INTO flights 
        (flight_number, origin,destination,departure_date,departure_time , arrival_time, total_seats, available_seats,price ,aircraft_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    $success = $stmt->execute([
        $data['flight_number'],
        $data['origin'],
        $data['destination'],
        $data['departure_date'],
        $data['departure_time'],
        $data['arrival_time'],
        $data['total_seats'],
        $data['available_seats'],
        $data['price'],
        $data['aircraft_id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'flight recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record flight');
    }
}

function update_flight($conn) {
    // Accept both 'edit_id' and 'id' as the identifier
    $id = $_POST['edit_id'] ?? $_POST['id'] ?? null;
    
    $required = [
        'id' => $id,
        'flight_number' => $_POST['edit_flight_number'] ?? null,
        'origin' => $_POST['edit_origin'] ?? null,
        'destination' => $_POST['edit_destination'] ?? null,
        'departure_date' => $_POST['edit_departure_date'] ?? null,
        'departure_time' => $_POST['edit_departure_time'] ?? null,
        'arrival_time' => $_POST['edit_arrival_time'] ?? null,
        'total_seats' => $_POST['edit_total_seats'] ?? null,
        'available_seats' => $_POST['edit_available_seats'] ?? null,
        'price' => $_POST['edit_price'] ?? null,
        'aircraft_id' => $_POST['edit_aircraft_id'] ?? null
    ];
    
    // Validate required fields
    foreach ($required as $field => $value) {
        if (empty($value)) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
    }
    
    // Check for duplicate (excluding current record)
    $stmt = $conn->prepare("
        SELECT flight_id FROM flights 
        WHERE flight_number = ?  AND flight_id != ?
    ");
    $stmt->execute([
        $required['flight_number'],
        $required['id']
    ]);
    if ($stmt->rowCount() > 0) {
        throw new Exception('flight with this flight_number already exists.');
    }
    // Update record
    $stmt = $conn->prepare("
        UPDATE flights SET
            flight_number = ?,
            origin = ?,
            destination = ?,
            departure_date = ?,
            departure_time = ?,
            arrival_time = ?,
            total_seats = ?,
            available_seats = ?,
            price = ?,
            aircraft_id = ?
        WHERE flight_id = ?
    ");
    
    $success = $stmt->execute([
        $required['flight_number'],
        $required['origin'],
        $required['destination'],
        $required['departure_date'],
        $required['departure_time'],
        $required['arrival_time'],
        $required['total_seats'],
        $required['available_seats'],
        $required['price'],
        $required['aircraft_id'],
        $required['id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'flight updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update flight');
    }
}

function delete_flight($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('Flight ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM flights WHERE flight_id = ?");
    $success = $stmt->execute([$_POST['id']]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'flight deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete flight');
    }
}
?>