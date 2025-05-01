<?php
header('Content-Type: application/json');
require_once '../Connection/connection.php';

$action = $_GET['action'] ?? '';

try {
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    
    switch ($action) {            
        case 'display_staff':
            display_staff($conn);
            break;
            
        case 'create_staff':
            create_staff($conn);
            break;
            
        case 'update_staff':
            update_staff($conn);
            break;
            
        case 'delete_staff':
            delete_staff($conn);
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

function display_staff($conn) {
    $query = "
        SELECT 
            id,
            full_name,
            gender,
            position,
            phone_number,
            address,
            email,
            hire_date
        FROM staff 
    ";
    
    $stmt = $conn->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function create_staff($conn) {
    $required = ['staff_name', 'gender','position','phone_number','address','email'];
    $data = [];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        $data[$field] = $_POST[$field];
    }
    // Insert record
    $stmt = $conn->prepare("
        INSERT INTO staff 
        (full_name, gender,position,phone_number,address,email) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    
    $success = $stmt->execute([
        $data['staff_name'],
        $data['gender'],
        $data['position'],
        $data['phone_number'],
        $data['address'],
        $data['email']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'staff recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record staff');
    }
}

function update_staff($conn) {
    // Accept both 'edit_id' and 'id' as the identifier
    $id = $_POST['edit_id'] ?? $_POST['id'] ?? null;
    
    $required = [
        'id' => $id,
        'name' => $_POST['edit_staff_name'] ?? null,
        'gender' => $_POST['edit_gender'] ?? null,
        'position' => $_POST['edit_position'] ?? null,
        'phone_number' => $_POST['edit_phone_number'] ?? null,
        'address' => $_POST['edit_address'] ?? null,
        'email' => $_POST['edit_email'] ?? null
    ];
    
    // Validate required fields
    foreach ($required as $field => $value) {
        if (empty($value)) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
    }
    
    // Update record
    $stmt = $conn->prepare("
        UPDATE staff SET
            full_name = ?,
            gender = ?,
            position = ?,
            phone_number = ?,
            address = ?,
            email = ?
        WHERE id = ?
    ");
    
    $success = $stmt->execute([
        $required['name'],
        $required['gender'],
        $required['position'],
        $required['phone_number'],
        $required['address'],
        $required['email'],
        $required['id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'staff updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update staff');
    }
}

function delete_staff($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('Staff ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM staff WHERE id = ?");
    $success = $stmt->execute([$_POST['id']]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Staff deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete Staff');
    }
}
?>