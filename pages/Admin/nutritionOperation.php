<?php
header('Content-Type: application/json');
require_once '../Connection/connection.php';

$action = $_GET['action'] ?? '';

try {
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    
    switch ($action) {            
        case 'get_children':
            get_children($conn);
            break;
        case 'display_nutrition':
            display_nutrition($conn);
            break;
            
        case 'create_nutrition':
            create_nutrition($conn);
            break;
            
        case 'update_nutrition':
            update_nutrition($conn);
            break;
            
        case 'delete_nutrition':
            delete_nutrition($conn);
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
function display_nutrition($conn) {
    $query = "
        SELECT 
            n.id,
            b.id as beneficiary_id,
            b.full_name as children_name,
            n.assessment_date,
            n.weight,
            n.height,
            n.muac,
            n.health_notes,
            n.created_at
        FROM nutrition_assessments n
        JOIN beneficiaries b ON n.beneficiary_id = b.id
    ";
    
    $stmt = $conn->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function create_nutrition($conn) {
    $required = ['children_id', 'weight','height','Mid_Upper','health_note'];
    $data = [];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        $data[$field] = $_POST[$field];
    }
    // Insert record
    $stmt = $conn->prepare("
        INSERT INTO nutrition_assessments 
        (beneficiary_id, weight,height,muac,health_notes) 
        VALUES (?, ?, ?, ?, ?)
    ");
    
    $success = $stmt->execute([
        $data['children_id'],
        $data['weight'],
        $data['height'],
        $data['Mid_Upper'],
        $data['health_note']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Nutrition Assessment Record recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record Nutrition Assessment Record');
    }
}

function update_nutrition($conn) {
    // Accept both 'edit_id' and 'id' as the identifier
    $id = $_POST['edit_id'] ?? $_POST['id'] ?? null;
    $required = [
        'id' => $id,
        'beneficiary_id' => $_POST['edit_children_id'] ?? null,
        'assessment_date' => $_POST['edit_assessment_date'] ?? null,
        'weight' => $_POST['edit_weight'] ?? null,
        'height' => $_POST['edit_height'] ?? null,
        'muac' => $_POST['edit_Mid_Upper'] ?? null,
        'health_note' => $_POST['edit_health_note'] ?? null
    ];
    
    // Validate required fields
    foreach ($required as $field => $value) {
        if (empty($value)) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
    }
    
    // Update record
    $stmt = $conn->prepare("
        UPDATE nutrition_assessments SET
            beneficiary_id = ?,
            assessment_date = ?,
            weight = ?,
            height = ?,
            muac = ?,
            health_notes = ?
        WHERE id = ?
    ");
    
    $success = $stmt->execute([
        $required['beneficiary_id'],
        $required['assessment_date'],
        $required['weight'],
        $required['height'],
        $required['muac'],
        $required['health_note'],
        $required['id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Nutrition Assessment updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update Nutrition Assessment');
    }
}

function delete_nutrition($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('Nutrition Assessment  ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM nutrition_assessments WHERE id = ?");
    $success = $stmt->execute([$_POST['id']]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Nutrition Assessment deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete Nutrition Assessment');
    }
}
?>