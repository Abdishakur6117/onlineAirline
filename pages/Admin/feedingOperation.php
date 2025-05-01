<?php
header('Content-Type: application/json');
require_once '../Connection/connection.php';

$action = $_GET['action'] ?? '';

try {
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    
    switch ($action) {            
        case 'display_feeding':
            display_feeding($conn);
            break;
            
        case 'create_feeding':
            create_feeding($conn);
            break;
            
        case 'update_feeding':
            update_feeding($conn);
            break;
            
        case 'delete_feeding':
            delete_feeding($conn);
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

function display_feeding($conn) {
    $query = "
        SELECT 
            id,
            program_name,
            description,
            start_date,
            end_date
        FROM feeding_programs 
    ";
    
    $stmt = $conn->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function create_feeding($conn) {
    $required = ['program_name', 'description','start_date','end_date'];
    $data = [];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        $data[$field] = $_POST[$field];
    }
    // Insert record
    $stmt = $conn->prepare("
        INSERT INTO feeding_programs 
        (program_name, description,start_date,end_date) 
        VALUES (?, ?, ?, ?)
    ");
    
    $success = $stmt->execute([
        $data['program_name'],
        $data['description'],
        $data['start_date'],
        $data['end_date']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'feeding program recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record feeding program');
    }
}

function update_feeding($conn) {
    // Accept both 'edit_id' and 'id' as the identifier
    $id = $_POST['edit_id'] ?? $_POST['id'] ?? null;
    
    $required = [
        'id' => $id,
        'name' => $_POST['edit_program_name'] ?? null,
        'description' => $_POST['edit_description'] ?? null,
        'start' => $_POST['edit_start_date'] ?? null,
        'end' => $_POST['edit_end_date'] ?? null
    ];
    
    // Validate required fields
    foreach ($required as $field => $value) {
        if (empty($value)) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
    }
    
    // Update record
    $stmt = $conn->prepare("
        UPDATE feeding_programs SET
            program_name = ?,
            description = ?,
            start_date = ?,
            end_date = ?
        WHERE id = ?
    ");
    
    $success = $stmt->execute([
        $required['name'],
        $required['description'],
        $required['start'],
        $required['end'],
        $required['id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'feeding program updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update feeding program');
    }
}

function delete_feeding($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('Feeding ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM feeding_programs WHERE id = ?");
    $success = $stmt->execute([$_POST['id']]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'feeding Program deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete feeding Program');
    }
}
?>