<?php
header('Content-Type: application/json');
require_once '../Connection/connection.php';

$action = $_GET['action'] ?? '';

try {
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    
    switch ($action) { 
        case 'get_staff':
            get_staff($conn);
            break;           
        case 'display_user':
            display_user($conn);
            break;
            
        case 'create_user':
            create_user($conn);
            break;
            
        case 'update_user':
            update_user($conn);
            break;
            
        case 'delete_user':
            delete_user($conn);
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

function get_staff($conn) {
    $stmt = $conn->query("SELECT id, full_name FROM staff ORDER BY full_name");
    echo json_encode([
        'status' => 'success',
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ]);
}

function display_user($conn) {
    $query = "
        SELECT 
            u.id,
            u.username,
            u.password,
            u.role,
            s.id as staff_id,
            s.full_name as staff_name,
            u.created_at
        FROM users u
        JOIN staff s ON u.staff_id = s.id
    ";
    
    $stmt = $conn->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function create_user($conn) {
    $required = ['username', 'password','confirmPassword','role','staff_id'];
    $data = [];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        $data[$field] = $_POST[$field];
    }

    // Check for duplicate username 
    $stmt = $conn->prepare("
        SELECT id FROM users 
        WHERE username = ?  
    ");
    $stmt->execute([$data['username']]);
    if ($stmt->rowCount() > 0) {
        throw new Exception('users record already exists for this username');
    }
     if ($data['password'] !== $data['confirmPassword']) {
    throw new Exception('Passwords do not match');
    }
    // Insert record
    $stmt = $conn->prepare("
        INSERT INTO users 
        (username, password,role,staff_id) 
        VALUES (?, ?, ?, ?)
    ");
    
    $success = $stmt->execute([
        $data['username'],
        $data['password'],
        $data['role'],
        $data['staff_id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'users recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record users');
    }
}

function update_user($conn) {
    // Accept both 'edit_id' and 'id' as the identifier
    $id = $_POST['edit_id'] ?? $_POST['id'] ?? null;
    
    $required = [
        'id' => $id,
        'username' => $_POST['edit_username'] ?? null,
        'role' => $_POST['edit_role'] ?? null,
        'staff_id' => $_POST['edit_staff_id'] ?? null
    ];
    
    // Validate required fields
    foreach ($required as $field => $value) {
        if (empty($value)) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
    }
    
    // Check for duplicate (excluding current record)
    $stmt = $conn->prepare("
        SELECT id FROM users 
        WHERE username = ?  AND id != ?
    ");
    $stmt->execute([
        $required['username'],
        $required['id']
    ]);
    if ($stmt->rowCount() > 0) {
        throw new Exception('A user with this username already exists.');
    }
    // Update record
    $stmt = $conn->prepare("
        UPDATE users SET
            username = ?,
            role = ?,
            staff_id = ?
        WHERE id = ?
    ");
    
    $success = $stmt->execute([
        $required['username'],
        $required['role'],
        $required['staff_id'],
        $required['id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'user updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update user');
    }
}

function delete_user($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('User ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $success = $stmt->execute([$_POST['id']]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'user deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete user');
    }
}
?>