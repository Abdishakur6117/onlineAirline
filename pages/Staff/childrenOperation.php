<?php
header('Content-Type: application/json');
require_once '../Connection/connection.php';

session_start();

// ✅ Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'User not authenticated'
    ]);
    exit;
}

$action = $_GET['action'] ?? '';

try {
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    
    switch ($action) {            
        case 'display_children':
            display_children($conn);
            break;
            
        case 'create_children':
            create_children($conn);
            break;
            
        case 'update_children':
            update_children($conn);
            break;
            
        case 'delete_children':
            delete_children($conn);
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

function display_children($conn) {
    $staff_id = $_SESSION['id'];

    $query = "
        SELECT 
            id,
            full_name,
            gender,
            date_of_birth,
            parent_name,
            parent_number,
            address,
            registration_date
        FROM beneficiaries 
        WHERE created_by = ?
    ";


    $stmt = $conn->prepare($query);
    $stmt->execute([$staff_id]);

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}


function create_children($conn) {
    $required = ['children_name', 'gender','date','parent_name','parent_number','address'];
    $data = [];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        $data[$field] = $_POST[$field];
    }
    $created_by =$_SESSION['id'];
    // Insert record
    $stmt = $conn->prepare("
        INSERT INTO beneficiaries 
        (full_name, gender,date_of_birth,parent_name,parent_number,address,created_by) 
        VALUES (?, ?, ?, ?, ?, ?,?)
    ");
    
    $success = $stmt->execute([
        $data['children_name'],
        $data['gender'],
        $data['date'],
        $data['parent_name'],
        $data['parent_number'],
        $data['address'],
        $created_by,
        $created_by
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Children recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record Children');
    }
}

function update_children($conn) {
    // Accept both 'edit_id' and 'id' as the identifier
    $id = $_POST['edit_id'] ?? $_POST['id'] ?? null;
    
    $required = [
        'id' => $id,
        'name' => $_POST['edit_children_name'] ?? null,
        'gender' => $_POST['edit_gender'] ?? null,
        'date' => $_POST['edit_date'] ?? null,
        'parent_name' => $_POST['edit_parent_name'] ?? null,
        'parent_number' => $_POST['edit_parent_number'] ?? null,
        'address' => $_POST['edit_address'] ?? null
    ];
    
    // Validate required fields
    foreach ($required as $field => $value) {
        if (empty($value)) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
    }
    
    // Update record
    $stmt = $conn->prepare("
        UPDATE beneficiaries SET
            full_name = ?,
            gender = ?,
            date_of_birth = ?,
            parent_name = ?,
            parent_number = ?,
            address = ?
        WHERE id = ?
    ");
    
    $success = $stmt->execute([
        $required['name'],
        $required['gender'],
        $required['date'],
        $required['parent_name'],
        $required['parent_number'],
        $required['address'],
        $required['id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'children updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update children');
    }
}

function delete_children($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('Children ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM beneficiaries WHERE id = ?");
    $success = $stmt->execute([$_POST['id']]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'children deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete children');
    }
}
?>