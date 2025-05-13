<?php
header('Content-Type: application/json');
require_once '../Connection/connection.php';

$action = $_GET['action'] ?? '';

try {
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    
    switch ($action) { 
        case 'display_aircraft':
            display_aircraft($conn);
            break;
            
        case 'create_aircraft':
            create_aircraft($conn);
            break;
            
        case 'update_aircraft':
            update_aircraft($conn);
            break;
            
        case 'delete_aircraft':
            delete_aircraft($conn);
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

function display_aircraft($conn) {
    $query = "
        SELECT 
            aircraft_id,
            model,
            manufacturer,
            capacity,
            created_at
        FROM aircrafts 
    ";
    
    $stmt = $conn->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function create_aircraft($conn) {
    $required = ['model', 'manufacturer','capacity'];
    $data = [];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        $data[$field] = $_POST[$field];
    }
    // Insert record
    $stmt = $conn->prepare("
        INSERT INTO aircrafts 
        (model, manufacturer,capacity ) 
        VALUES (?, ?, ?)
    ");
    
    $success = $stmt->execute([
        $data['model'],
        $data['manufacturer'],
        $data['capacity']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Aircraft recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record Aircraft');
    }
}

function update_aircraft($conn) {
    // Accept both 'edit_id' and 'id' as the identifier
    $id = $_POST['edit_id'] ?? $_POST['id'] ?? null;
    
    $required = [
        'id' => $id,
        'model' => $_POST['edit_model'] ?? null,
        'manufacturer' => $_POST['edit_manufacturer'] ?? null,
        'capacity' => $_POST['edit_capacity'] ?? null
    ];
    
    // Validate required fields
    foreach ($required as $field => $value) {
        if (empty($value)) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
    }
    // Update record
    $stmt = $conn->prepare("
        UPDATE aircrafts SET
            model = ?,
            manufacturer = ?,
            capacity = ?
        WHERE aircraft_id = ?
    ");
    
    $success = $stmt->execute([
        $required['model'],
        $required['manufacturer'],
        $required['capacity'],
        $required['id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Aircraft updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update Aircraft');
    }
}

function delete_aircraft($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('Aircraft ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM aircrafts WHERE aircraft_id = ?");
    $success = $stmt->execute([$_POST['id']]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Aircraft deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete Aircraft');
    }
}
?>