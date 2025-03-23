<?php
session_start();
include '../../Connection/connection.php';

$db = new DatabaseConnection();
$conn = $db->getConnection();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die(json_encode(["status" => "error", "message" => "Unauthorized access!"]));
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user ID from session and sanitize user input
    $id = $_SESSION['user_id'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    // Validate inputs
    if (empty($username) || empty($email)) {
        die(json_encode(["status" => "error", "message" => "Username and email are required!"]));
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die(json_encode(["status" => "error", "message" => "Invalid email format!"]));
    }

    // Check if the user account is deleted or inactive
    $query = "SELECT role, status, deleted_at FROM Users WHERE user_id=:id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->bindColumn('role', $role);
    $stmt->bindColumn('status', $status);
    $stmt->bindColumn('deleted_at', $deleted_at);
    $stmt->fetch();

    if ($deleted_at !== null) {
        die(json_encode(["status" => "error", "message" => "Your account is deleted and cannot be updated!"]));
    }

    if ($status !== 'active') {
        die(json_encode(["status" => "error", "message" => "Your account is not active!"]));
    }

    // Check if the new email is already in use by another user
    $query = "SELECT user_id FROM Users WHERE email=:email AND user_id != :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        die(json_encode(["status" => "error", "message" => "Email already exists!"]));
    }

    // Update user profile information
    $query = "UPDATE users SET username=:username, email=:email WHERE user_id=:id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        die(json_encode(["status" => "success", "message" => "Profile updated successfully!"]));
    } else {
        die(json_encode(["status" => "error", "message" => "Error updating profile!"]));
    }
    
}

// Close the database connection at the end (optional but a good practice)
$conn = null;
?>
