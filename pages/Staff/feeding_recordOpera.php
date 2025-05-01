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
        case 'get_children':
            get_children($conn);
            break;
        case 'get_feedingProgram':
            get_feedingProgram($conn);
            break;
        case 'get_meals':
            get_meals($conn);
            break;
        case 'get_user':
            get_user($conn);
            break;
        case 'display_feeding_record':
            display_feeding_record($conn);
            break;
            
        case 'create_feeding_record':
            create_feeding_record($conn);
            break;
            
        case 'update_feeding_record':
            update_feeding_record($conn);
            break;
            
        case 'delete_feeding_record':
            delete_feeding_record($conn);
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

function get_children($conn) {
    $stmt = $conn->query("SELECT id, full_name FROM beneficiaries ORDER BY full_name");
    echo json_encode([
        'status' => 'success',
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ]);
}
function get_feedingProgram($conn) {
    $stmt = $conn->query("SELECT id, program_name FROM feeding_programs ORDER BY program_name");
    echo json_encode([
        'status' => 'success',
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ]);
}
function get_meals($conn) {
    $stmt = $conn->query("SELECT id, meal_name FROM meals ORDER BY meal_name");
    echo json_encode([
        'status' => 'success',
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ]);
}
function get_user($conn) {
    $stmt = $conn->query("SELECT id, username FROM users ORDER BY username");
    echo json_encode([
        'status' => 'success',
        'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
    ]);
}
function display_feeding_record($conn) {
     $staff_id = $_SESSION['id'];

    $query = "
        SELECT 
            f.id,
            b.id as beneficiary_id,
            b.full_name as children_name,
            fp.id as feeding_program_id,
            fp.program_name as feeding_program_name,
            m.id as meal_id,
            m.meal_name as meal_name,
            f.feeding_date,
            f.quantity,
            f.remarks,
            u.id as recorded_by,
            u.username as user_name,
            f.created_at
        FROM feeding_records f 
        JOIN beneficiaries b ON f.beneficiary_id = b.id
        JOIN feeding_programs fp ON f.feeding_program_id = fp.id
        JOIN meals m ON f.meal_id = m.id
        JOIN users u ON f.recorded_by = u.id
        WHERE recorded_by = ?
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->execute([$staff_id]);

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function create_feeding_record($conn) {
    $required = ['children_id', 'feeding_program_id','meal_id','quantity','remarks','user_id'];
    $data = [];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        $data[$field] = $_POST[$field];
    }
    //  $created_by =$_SESSION['id'];
    // Insert record
    $stmt = $conn->prepare("
        INSERT INTO feeding_records 
        (beneficiary_id, feeding_program_id,meal_id,quantity,remarks,recorded_by) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    
    $success = $stmt->execute([
        $data['children_id'],
        $data['feeding_program_id'],
        $data['meal_id'],
        $data['quantity'],
        $data['remarks'],
        $data['user_id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'feeding Record recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record feeding Record');
    }
}

function update_feeding_record($conn) {
    // Accept both 'edit_id' and 'id' as the identifier
    $id = $_POST['edit_id'] ?? $_POST['id'] ?? null;
    
    $required = [
        'id' => $id,
        'beneficiary_id' => $_POST['edit_children_id'] ?? null,
        'feeding_program_id' => $_POST['edit_feeding_program_id'] ?? null,
        'meal_id' => $_POST['edit_meal_id'] ?? null,
        'feeding_date' => $_POST['edit_feedingDate'] ?? null,
        'quantity' => $_POST['edit_quantity'] ?? null,
        'remarks' => $_POST['edit_remarks'] ?? null,
        'recorded_by' => $_POST['edit_user_id'] ?? null
    ];
    
    // Validate required fields
    foreach ($required as $field => $value) {
        if (empty($value)) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
    }
    
    // Update record
    $stmt = $conn->prepare("
        UPDATE feeding_records SET
            beneficiary_id = ?,
            feeding_program_id = ?,
            meal_id = ?,
            feeding_date = ?,
            quantity = ?,
            remarks = ?,
            recorded_by = ?
        WHERE id = ?
    ");
    
    $success = $stmt->execute([
        $required['beneficiary_id'],
        $required['feeding_program_id'],
        $required['meal_id'],
        $required['feeding_date'],
        $required['quantity'],
        $required['remarks'],
        $required['recorded_by'],
        $required['id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'feeding Record updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update feeding Record');
    }
}

function delete_feeding_record($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('Feeding Record ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM feeding_records WHERE id = ?");
    $success = $stmt->execute([$_POST['id']]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'feeding Record deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete feeding Record');
    }
}
?>