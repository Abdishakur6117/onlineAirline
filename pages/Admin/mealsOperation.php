<?php
header('Content-Type: application/json');
require_once '../Connection/connection.php';

$action = $_GET['action'] ?? '';

try {
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    
    switch ($action) {            
        case 'display_meals':
            display_meals($conn);
            break;
            
        case 'create_meal':
            create_meal($conn);
            break;
            
        case 'update_meal':
            update_meal($conn);
            break;
            
        case 'delete_meal':
            delete_meal($conn);
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

function display_meals($conn) {
    $query = "
        SELECT 
            id,
            meal_name,
            meal_description,
            calories
        FROM meals 
    ";
    
    $stmt = $conn->query($query);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function create_meal($conn) {
    $required = ['meal_name', 'meal_description','calories'];
    $data = [];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
        $data[$field] = $_POST[$field];
    }
    // Insert record
    $stmt = $conn->prepare("
        INSERT INTO meals 
        (meal_name, meal_description,calories) 
        VALUES (?, ?, ?)
    ");
    
    $success = $stmt->execute([
        $data['meal_name'],
        $data['meal_description'],
        $data['calories']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Meals recorded successfully'
        ]);
    } else {
        throw new Exception('Failed to record Meals');
    }
}

function update_meal($conn) {
    // Accept both 'edit_id' and 'id' as the identifier
    $id = $_POST['edit_id'] ?? $_POST['id'] ?? null;
    
    $required = [
        'id' => $id,
        'name' => $_POST['edit_meal_name'] ?? null,
        'description' => $_POST['edit_meal_description'] ?? null,
        'calories' => $_POST['edit_calories'] ?? null
    ];
    
    // Validate required fields
    foreach ($required as $field => $value) {
        if (empty($value)) {
            throw new Exception(ucfirst(str_replace('_', ' ', $field)) . ' is required');
        }
    }
    
    // Update record
    $stmt = $conn->prepare("
        UPDATE meals SET
            meal_name = ?,
            meal_description = ?,
            calories = ?
        WHERE id = ?
    ");
    
    $success = $stmt->execute([
        $required['name'],
        $required['description'],
        $required['calories'],
        $required['id']
    ]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Meals updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update Meals');
    }
}

function delete_meal($conn) {
    if (empty($_POST['id'])) {
        throw new Exception('Meals ID is required');
    }
    
    $stmt = $conn->prepare("DELETE FROM meals WHERE id = ?");
    $success = $stmt->execute([$_POST['id']]);
    
    if ($success) {
        echo json_encode([
            'status' => 'success',
            'message' => 'meals deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete meals');
    }
}
?>