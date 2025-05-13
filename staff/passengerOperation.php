<?php
header('Content-Type: application/json');
require_once '../Connection/connection.php';

$action = $_GET['action'] ?? '';

try {
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    
    switch ($action) { 
        case 'display_passenger':
            display_passenger($conn);
            break;
            
        case 'create_passenger':
            create_passenger($conn);
            break;
            
        case 'update_passenger':
            update_passenger($conn);
            break;
            
        case 'delete_passenger':
            delete_passenger($conn);
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

function display_passenger($conn) {
    $query = "
        SELECT 
            passenger_id,
            first_name,
            last_name,
            email,
            phone,
            gender,
            passport_no,
            date_of_birth,
            nationality,
            address,
            created_at
        FROM passengers 
    ";
    
    $stmt = $conn->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function create_passenger($conn) {
    $required = ['first_name', 'last_name','email','phone','gender','passport_no','DOB','nationality','address'];
    $data = [];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        $data[$field] = $_POST[$field];
    }

    // Check for duplicate username 
    $stmt = $conn->prepare("
        SELECT passenger_id FROM passengers 
        WHERE email = ?  
    ");
    $stmt->execute([$data['email']]);
    if ($stmt->rowCount() > 0) {
        throw new Exception('passenger record already exists for this email');
    }
    // Insert record
    $stmt = $conn->prepare("
        INSERT INTO passengers 
        (first_name, last_name,email,phone,gender , passport_no,date_of_birth ,nationality ,address ) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    $success = $stmt->execute([
        $data['first_name'],
        $data['last_name'],
        $data['email'],
        $data['phone'],
        $data['gender'],
        $data['passport_no'],
        $data['DOB'],
        $data['nationality'],
        $data['address']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'passenger recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record passenger');
    }
}

function update_passenger($conn) {
    // Accept both 'edit_id' and 'id' as the identifier
    $id = $_POST['edit_id'] ?? $_POST['id'] ?? null;
    
    $required = [
        'id' => $id,
        'first_name' => $_POST['edit_first_name'] ?? null,
        'last_name' => $_POST['edit_last_name'] ?? null,
        'email' => $_POST['edit_email'] ?? null,
        'phone' => $_POST['edit_phone'] ?? null,
        'gender' => $_POST['edit_gender'] ?? null,
        'passport_no' => $_POST['edit_passport_no'] ?? null,
        'date_of_birth' => $_POST['edit_DOB'] ?? null,
        'nationality' => $_POST['edit_nationality'] ?? null,
        'address' => $_POST['edit_address'] ?? null
    ];
    
    // Validate required fields
    foreach ($required as $field => $value) {
        if (empty($value)) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
    }
    
    // Check for duplicate (excluding current record)
    $stmt = $conn->prepare("
        SELECT passenger_id FROM passengers 
        WHERE email = ?  AND passenger_id != ?
    ");
    $stmt->execute([
        $required['email'],
        $required['id']
    ]);
    if ($stmt->rowCount() > 0) {
        throw new Exception('A user with this username already exists.');
    }
    // Update record
    $stmt = $conn->prepare("
        UPDATE passengers SET
            first_name = ?,
            last_name = ?,
            email = ?,
            phone = ?,
            gender = ?,
            passport_no = ?,
            date_of_birth = ?,
            nationality = ?,
            address = ?
        WHERE passenger_id = ?
    ");
    
    $success = $stmt->execute([
        $required['first_name'],
        $required['last_name'],
        $required['email'],
        $required['phone'],
        $required['gender'],
        $required['passport_no'],
        $required['date_of_birth'],
        $required['nationality'],
        $required['address'],
        $required['id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'passenger updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update passenger');
    }
}

function delete_passenger($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('Passenger ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM passengers WHERE passenger_id = ?");
    $success = $stmt->execute([$_POST['id']]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'passenger deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete passenger');
    }
}
?>