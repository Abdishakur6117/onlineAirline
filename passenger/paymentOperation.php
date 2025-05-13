<?php
session_start();
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
        case 'get_flight_price_by_passenger':
        get_flight_price_by_passenger($conn);
        break;                     
        case 'display_payment':
            display_payment($conn);
            break;
            
        case 'create_payment':
            create_payment($conn);
            break;
            
        case 'update_payment':
            update_payment($conn);
            break;
            
        case 'delete_payment':
            delete_payment($conn);
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

// Fetching passengers for dropdown
function get_passenger($conn) {

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'passenger') {
        echo json_encode([
            'status' => 'error',
            'message' => 'User not logged in or not a passenger'
        ]);
        return;
    }

    $passenger_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("
        SELECT 
            b.booking_id,
            ps.passenger_id, 
            CONCAT(ps.first_name, ' ', ps.last_name) AS full_name,
            f.price
        FROM bookings b
        JOIN passengers ps ON b.passenger_id = ps.passenger_id
        JOIN flights f ON b.flight_id = f.flight_id
        WHERE b.passenger_id = ?
        ORDER BY ps.first_name
    ");
    
    $stmt->execute([$passenger_id]);

    echo json_encode([
        'status' => 'success',
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ]);
}


// Fetch flight price by passenger ID
function get_flight_price_by_passenger($conn) {
    if (!isset($_GET['booking_id'])) {
        echo json_encode(['status' => 'fail', 'message' => 'booking ID is missing']);
        return;
    }

    $passengerId = $_GET['booking_id'];

    $stmt = $conn->prepare("
        SELECT f.price
        FROM bookings b
        JOIN flights f ON b.flight_id = f.flight_id
        WHERE b.booking_id = :booking_id
        LIMIT 1
    ");
    $stmt->execute(['booking_id' => $passengerId]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => $data ? 'success' : 'fail',
        'data' => $data ?: []
    ]);
}
// function display_payment($conn) {
//     if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'passenger') {
//         throw new Exception('User not logged in or not a passenger');
//     }

//     $passenger_id = $_SESSION['user_id'];
//     $query = "
//         SELECT 
//             p.payment_id,
//             CONCAT(ps.first_name, ' ', ps.last_name) AS passenger_name,
//             f.flight_number,
//             p.amount,
//             p.total_amount,
//             p.remainder,
//             p.payment_date,
//             p.method
//         FROM payments p
//         JOIN bookings b ON p.booking_id = b.booking_id
//         JOIN passengers ps ON b.passenger_id = ps.passenger_id
//         JOIN flights f ON b.flight_id = f.flight_id
//          WHERE b.passenger_id = ?
//     ";

//     try {
//         $stmt = $conn->query($query);
//         $stmt->execute([$passenger_id]);
//         $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//         echo json_encode($results);
//     } catch (PDOException $e) {
//         echo json_encode(['error' => $e->getMessage()]);
//     }
// }
function display_payment($conn) {
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
            p.payment_id,
            CONCAT(ps.first_name, ' ', ps.last_name) AS passenger_name,
            f.flight_number,
            p.amount,
            p.total_amount,
            p.remainder,
            p.payment_date,
            p.method
        FROM payments p
        JOIN bookings b ON p.booking_id = b.booking_id
        JOIN passengers ps ON b.passenger_id = ps.passenger_id
        JOIN flights f ON b.flight_id = f.flight_id
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

function create_payment($conn) {
    $required = ['booking_id', 'total_amount', 'amount', 'payment_date', 'method'];
    $data = [];

    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
         // Convert datetime-local format to MySQL DATETIME format
        if ($field === 'payment_date') {
            $data[$field] = str_replace('T', ' ', $_POST[$field]);
        } else {
            $data[$field] = $_POST[$field];
        }
    }

    // Validation: amount ma aha inuu ka bato total_amount
    if ($data['amount'] > $data['total_amount']) {
        throw new Exception('Amount cannot be greater than the total amount');
    }

    // Check if a previous payment exists for this booking
    $stmt = $conn->prepare("SELECT * FROM payments WHERE booking_id = ?");
    $stmt->execute([$data['booking_id']]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        // Payment horey u jiray
        if ($existing['remainder'] == 0) {
            throw new Exception('Full payment has already been made for this booking');
        }

        $newAmount = $existing['amount'] + $data['amount'];
        if ($newAmount > $data['total_amount']) {
            throw new Exception('Total payment exceeds required amount');
        }

        $newRemainder = $data['total_amount'] - $newAmount;

        // Update existing payment
        $stmt = $conn->prepare("
            UPDATE payments
            SET amount = ?, payment_date = ?, method = ?, remainder = ?, total_amount = ?
            WHERE booking_id = ?
        ");
        $success = $stmt->execute([
            $newAmount,
            $data['payment_date'],
            $data['method'],
            $newRemainder,
            $data['total_amount'],
            $data['booking_id']
        ]);
    } else {
        // Insert new payment
        $remainder = $data['total_amount'] - $data['amount'];
        $stmt = $conn->prepare("
            INSERT INTO payments 
            (booking_id, total_amount, amount, payment_date, method, remainder)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $success = $stmt->execute([
            $data['booking_id'],
            $data['total_amount'],
            $data['amount'],
            $data['payment_date'],
            $data['method'],
            $remainder
        ]);
        $newRemainder = $remainder;
    }

    // If payment is completed, update status and generate ticket
    if ($success && $newRemainder == 0) {
        // Update booking status
        $stmt = $conn->prepare("UPDATE bookings SET status = 'confirmed' WHERE booking_id = ?");
        $stmt->execute([$data['booking_id']]);

        // Check if ticket already exists
        $stmt = $conn->prepare("SELECT ticket_id FROM tickets WHERE booking_id = ?");
        $stmt->execute([$data['booking_id']]);
        $ticketExists = $stmt->fetchColumn();

        if (!$ticketExists) {
            // Insert new ticket
            $issue_date = date('Y-m-d');
            $barcode = 'TK-' . strtoupper(uniqid());

            $stmt = $conn->prepare("
                INSERT INTO tickets (booking_id, issue_date, barcode)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$data['booking_id'], $issue_date, $barcode]);
        }
    }

    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Payment processed successfully',
            'remainder' => $newRemainder
        ]);
    } else {
        throw new Exception('Failed to process payment');
    }
}

function update_payment($conn) {
    // Accept both 'edit_id' and 'id' as the identifier
    $id = $_POST['edit_id'] ?? $_POST['id'] ?? null;

    $required = [
        'id' => $id,
        'edit_booking_id' => $_POST['edit_booking_id'] ?? null,
        'edit_total_amount' => $_POST['edit_total_amount'] ?? null,
        'edit_amount' => $_POST['edit_amount'] ?? null,
        'edit_payment_date' => $_POST['edit_payment_date'] ?? null,
        'edit_method' => $_POST['edit_method'] ?? null
    ];

    // Validate required fields
    foreach ($required as $field => $value) {
        if ($value === null || $value === '') {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
    }

    // Convert to float for comparison
    $total_amount = floatval($required['edit_total_amount']);
    $amount = floatval($required['edit_amount']);

    // Validate amount not greater than total
    if ($amount > $total_amount) {
        throw new Exception('Amount paid cannot be greater than total amount.');
    }

    // Calculate remainder
    $remainder = $total_amount - $amount;

    // Check for duplicate (excluding current record)
    $stmt = $conn->prepare("
        SELECT payment_id FROM payments 
        WHERE booking_id = ? AND payment_id != ?
    ");
    $stmt->execute([
        $required['edit_booking_id'],
        $required['id']
    ]);

    if ($stmt->rowCount() > 0) {
        throw new Exception('Payment with this booking_id already exists.');
    }

    // Update payment record
    $stmt = $conn->prepare("
        UPDATE payments SET
            booking_id = ?,
            total_amount = ?,
            amount = ?,
            remainder = ?,
            payment_date = ?,
            method = ? 
        WHERE payment_id = ?
    ");
    
    $success = $stmt->execute([
        $required['edit_booking_id'],
        $total_amount,
        $amount,
        $remainder,
        $required['edit_payment_date'],
        $required['edit_method'],
        $required['id']
    ]);

    if ($success) {
        // If remainder is 0, update booking status to 'confirmed' (if status was 'pending' before)
        if ($remainder == 0) {
            // Update booking status to confirmed
            $stmt = $conn->prepare("UPDATE bookings SET status = 'confirmed' WHERE booking_id = ?");
            $stmt->execute([$required['edit_booking_id']]);

            // Check if ticket already exists for this booking_id
            $stmt = $conn->prepare("SELECT ticket_id FROM tickets WHERE booking_id = ?");
            $stmt->execute([$required['edit_booking_id']]);
            $ticketExists = $stmt->fetchColumn();

            // If ticket exists, delete it before creating a new one
            if ($ticketExists) {
                // Delete existing ticket
                $stmt = $conn->prepare("DELETE FROM tickets WHERE booking_id = ?");
                $stmt->execute([$required['edit_booking_id']]);
            }

            // Now create a new ticket
            $issue_date = date('Y-m-d');
            $barcode = 'TK-' . strtoupper(uniqid());

            $stmt = $conn->prepare("
                INSERT INTO tickets (booking_id, issue_date, barcode)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$required['edit_booking_id'], $issue_date, $barcode]);
        }

        // If remainder is not 0, set the booking status to 'pending' and delete the ticket
        if ($remainder != 0) {
            // Update booking status to 'pending' if remainder is not zero
            $stmt = $conn->prepare("UPDATE bookings SET status = 'pending' WHERE booking_id = ?");
            $stmt->execute([$required['edit_booking_id']]);

            // Check if ticket already exists for this booking_id
            $stmt = $conn->prepare("SELECT ticket_id FROM tickets WHERE booking_id = ?");
            $stmt->execute([$required['edit_booking_id']]);
            $ticketExists = $stmt->fetchColumn();

            // If ticket exists, delete it
            if ($ticketExists) {
                $stmt = $conn->prepare("DELETE FROM tickets WHERE booking_id = ?");
                $stmt->execute([$required['edit_booking_id']]);
            }
        }

        // Return success response
        echo json_encode([
            'status' => 'success',
            'message' => 'Payment updated successfully and ticket handled if necessary.'
        ]);
    } else {
        throw new Exception('Failed to update payment');
    }
}
function delete_payment($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('Payment ID is required');
    }

    $payment_id = $_POST['id'];

    $conn->beginTransaction();

    try {
        // 1. Hel booking_id laga helo payment_id
        $stmt = $conn->prepare("SELECT booking_id FROM payments WHERE payment_id = ?");
        $stmt->execute([$payment_id]);
        $payment = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$payment) {
            throw new Exception('Payment not found');
        }

        $booking_id = $payment['booking_id'];

        // 2. Hel flight_id laga helo booking_id
        $stmt = $conn->prepare("SELECT flight_id FROM bookings WHERE booking_id = ?");
        $stmt->execute([$booking_id]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$booking) {
            throw new Exception('Booking not found');
        }

        $flight_id = $booking['flight_id'];

        // 3. Delete ticket
        $stmt = $conn->prepare("DELETE FROM tickets WHERE booking_id = ?");
        $stmt->execute([$booking_id]);

        // 4. Update booking status to 'pending'
        $stmt = $conn->prepare("UPDATE bookings SET status = 'pending' WHERE booking_id = ?");
        $stmt->execute([$booking_id]);

        // 5. Increase available seats by 1 in flights
        $stmt = $conn->prepare("UPDATE flights SET available_seats = available_seats + 1 WHERE flight_id = ?");
        $stmt->execute([$flight_id]);

        // 6. Delete the payment
        $stmt = $conn->prepare("DELETE FROM payments WHERE payment_id = ?");
        $success = $stmt->execute([$payment_id]);

        if ($success) {
            $conn->commit();
            echo json_encode([
                'status' => 'success',
                'message' => 'Payment deleted, ticket removed, booking status set to pending, and available seat updated'
            ]);
        } else {
            $conn->rollBack();
            throw new Exception('Failed to delete payment');
        }
    } catch (Exception $e) {
        $conn->rollBack();
        throw $e;
    }
}

?>