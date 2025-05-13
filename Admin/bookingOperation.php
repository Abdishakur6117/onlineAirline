<?php
header('Content-Type: application/json');
require_once '../Connection/connection.php';

$action = $_GET['action'] ?? '';

try {
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    
    switch ($action) { 
        case 'get_passenger':
            get_passenger($conn);
            break;           
        case 'get_flight':
            get_flight($conn);
            break;           
        case 'display_booking':
            display_booking($conn);
            break;
            
        case 'create_booking':
            create_booking($conn);
            break;
            
        case 'update_booking':
            update_booking($conn);
            break;
            
        case 'delete_booking':
            delete_booking($conn);
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

function get_passenger($conn) {
    $stmt = $conn->query("
        SELECT 
            passenger_id, 
            CONCAT(first_name, ' ', last_name) AS full_name 
        FROM passengers 
        ORDER BY first_name
    ");
    
    echo json_encode([
        'status' => 'success',
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ]);
}
function get_flight($conn) {
    $stmt = $conn->query("SELECT flight_id, flight_number FROM flights ORDER BY flight_number");
    echo json_encode([
        'status' => 'success',
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ]);
}


function display_booking($conn) {
    $query = "
        SELECT 
            b.booking_id,
            p.passenger_id,
            CONCAT(p.first_name, ' ', p.last_name) AS full_name,
            f.flight_id,
            f.flight_number,
            b.seat_number,
            b.booking_date,
            b.status
        FROM bookings b
        JOIN passengers p ON b.passenger_id = p.passenger_id
        JOIN flights f ON b.flight_id = f.flight_id
    ";
    
    $stmt = $conn->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
function create_booking($conn) {
    $required = ['passenger_id', 'flight_id','seat_number','booking_date','status'];
    $data = [];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        
        // Convert datetime-local format to MySQL DATETIME format
        if ($field === 'booking_date') {
            $data[$field] = str_replace('T', ' ', $_POST[$field]);
        } else {
            $data[$field] = $_POST[$field];
        }
    }

    // Check for available seats
    $stmt = $conn->prepare("SELECT available_seats FROM flights WHERE flight_id = ?");
    $stmt->execute([$data['flight_id']]);
    $flight = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$flight) {
        throw new Exception('Flight not found');
    }

    if ($flight['available_seats'] <= 0) {
        throw new Exception('Diyaaradan waa buuxdaa');
    }

    // Check for duplicate seat booking
    $stmt = $conn->prepare("
        SELECT booking_id FROM bookings 
        WHERE seat_number = ? AND passenger_id = ?
    ");
    $stmt->execute([$data['seat_number'], $data['passenger_id']]);
    if ($stmt->rowCount() > 0) {
        throw new Exception('Booking record already exists for this seat number on this flight');
    }

    // Insert booking
    $stmt = $conn->prepare("
        INSERT INTO bookings 
        (passenger_id, flight_id, seat_number, booking_date, status) 
        VALUES (?, ?, ?, ?, ?)
    ");
    
    $success = $stmt->execute([
        $data['passenger_id'],
        $data['flight_id'],
        $data['seat_number'],
        $data['booking_date'],
        $data['status']
    ]);

    if ($success) {
        // Reduce available seats by 1
        $stmt = $conn->prepare("UPDATE flights SET available_seats = available_seats - 1 WHERE flight_id = ?");
        $stmt->execute([$data['flight_id']]);

        echo json_encode([
            'status' => 'success',
            'message' => 'Booking recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record booking');
    }
}
function update_booking($conn) {
    // Accept both 'edit_id' and 'id' as the identifier
    $id = $_POST['edit_id'] ?? $_POST['id'] ?? null;
    
    $required = [
        'id' => $id,
        'passenger_id' => $_POST['edit_passenger_id'] ?? null,
        'flight_id' => $_POST['edit_flight_id'] ?? null,
        'seat_number' => $_POST['edit_seat_number'] ?? null,
        'booking_date' => $_POST['edit_booking_date'] ?? null,
        'status' => $_POST['edit_status'] ?? null
    ];
    
    // Validate required fields
    foreach ($required as $field => $value) {
        if (empty($value)) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
    }
    
    // Check for duplicate (excluding current record)
    $stmt = $conn->prepare("
        SELECT booking_id FROM bookings 
        WHERE seat_number = ?  AND passenger_id != ?
    ");
    $stmt->execute([
        $required['seat_number'],
        $required['id']
    ]);
    if ($stmt->rowCount() > 0) {
        throw new Exception('booking with this seat_number already exists.');
    }
    // Update record
    $stmt = $conn->prepare("
        UPDATE bookings SET
            passenger_id = ?,
            flight_id = ?,
            seat_number = ?,
            booking_date = ?,
            status = ?
        WHERE booking_id = ?
    ");
    
    $success = $stmt->execute([
        $required['passenger_id'],
        $required['flight_id'],
        $required['seat_number'],
        $required['booking_date'],
        $required['status'],
        $required['id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'booking updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update booking');
    }
}
function delete_booking($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('Booking ID is required');
    }

    $conn->beginTransaction(); // Start transaction

    try {
        $booking_id = $_POST['id'];

        // 1. Hel flight_id ee booking-ka
        $stmt = $conn->prepare("SELECT flight_id FROM bookings WHERE booking_id = ?");
        $stmt->execute([$booking_id]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$booking) {
            throw new Exception('Booking not found');
        }

        $flight_id = $booking['flight_id'];

        // 2. Hel current available_seats iyo total_seats ee flight-ka
        $stmt = $conn->prepare("SELECT available_seats, total_seats FROM flights WHERE flight_id = ?");
        $stmt->execute([$flight_id]);
        $flight = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$flight) {
            throw new Exception('Flight not found');
        }

        $available_seats = (int)$flight['available_seats'];
        $total_seats = (int)$flight['total_seats'];

        // 3. Delete related payments
        $stmt = $conn->prepare("DELETE FROM payments WHERE booking_id = ?");
        $stmt->execute([$booking_id]);

        // 4. Delete related tickets
        $stmt = $conn->prepare("DELETE FROM tickets WHERE booking_id = ?");
        $stmt->execute([$booking_id]);

        // 5. Delete the booking
        $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = ?");
        $success = $stmt->execute([$booking_id]);

        if ($success) {
            // 6. Haddii available_seats < total_seats, kordhi hal
            $stmt = $conn->prepare("
                UPDATE flights 
                SET available_seats = available_seats + 1 
                WHERE flight_id = ? AND available_seats < total_seats
            ");
            $stmt->execute([$flight_id]);

            $conn->commit(); // Dhammaan OK
            echo json_encode([
                'status' => 'success',
                'message' => 'Booking, ticket, and payment deleted successfully. Seat restored (if within limit).'
            ]);
        } else {
            $conn->rollBack();
            throw new Exception('Failed to delete booking');
        }

    } catch (Exception $e) {
        $conn->rollBack();
        throw $e;
    }
}



?>