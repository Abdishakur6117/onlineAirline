<?php
session_start();
include '../../Connection/connection.php';

$db = new DatabaseConnection();
$conn = $db->getConnection();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Return error if the user is not logged in
    die(json_encode(["status" => "error", "message" => "Unauthorized access!"]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input to avoid SQL injection and ensure clean data
    $oldPassword = isset($_POST['oldPassword']) ? trim($_POST['oldPassword']) : '';
    $newPassword = isset($_POST['newPassword']) ? trim($_POST['newPassword']) : '';

    if (empty($oldPassword) || empty($newPassword)) {
        // Ensure both fields are provided
        die(json_encode(["status" => "error", "message" => "Old and new passwords are required!"]));
    }

    $id = $_SESSION['user_id'];

    // Prepare and execute the query to fetch user details
    $query = "SELECT password, status, deleted_at FROM Users WHERE user_id=:id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the account is deleted or inactive
        if ($result['deleted_at'] !== null) {
            die(json_encode(["status" => "error", "message" => "Your account is deleted and cannot be updated!"]));
        }

        if ($result['status'] !== 'active') {
            die(json_encode(["status" => "error", "message" => "Your account is not active!"]));
        }

        // Compare the plain text old password
        if ($oldPassword !== $result['password']) {
            die(json_encode(["status" => "error", "message" => "Old password is incorrect!"]));
        }

        // Update the password in the database
        $updateQuery = "UPDATE users SET password=:newPassword WHERE user_id=:id";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bindParam(':newPassword', $newPassword, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            die(json_encode(["status" => "success", "message" => "Password updated successfully!"]));
        } else {
            die(json_encode(["status" => "error", "message" => "Error updating password!"]));
        }
    } else {
        die(json_encode(["status" => "error", "message" => "Database query failed!"]));
    }
}
?>
