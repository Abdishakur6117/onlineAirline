<?php
$route = $_REQUEST['url'];
$route();
function displayUser(){
  include '../../Connection/connection.php';
  include '../../Connection/code.php';
  $db = new DatabaseConnection();
  $database =$db->getConnection();
  $query= new myCode($database);
  // print_r($query->selectAll('students'));
  echo json_encode($query->selectAll('Users'));
}

function createUser() {
    include '../../Connection/connection.php';
    $db = new DatabaseConnection();
    $conn = $db->getConnection();

    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    // Validation
    if (!$fullName || !$email || !$userName || !$password || !$phone) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        return;
    }

    // Check if email already exists
    $emailCheck = "SELECT * FROM Users WHERE email = :email";
    $stm = $conn->prepare($emailCheck);
    $stm->bindParam(':email', $email);
    $stm->execute();
    if ($stm->fetchColumn() > 0) {
        echo json_encode(["status" => "error", "message" => "Email already exists."]);
        return;
    }

    // Insert user
    $query = "INSERT INTO Users (fullName, email, userName, password, phone) VALUES (:fullName, :email, :userName, :password, :phone)";
    $stm = $conn->prepare($query);
    $stm->bindParam(':fullName', $fullName);
    $stm->bindParam(':email', $email);
    $stm->bindParam(':userName', $userName);
    $stm->bindParam(':password', $password);
    $stm->bindParam(':phone', $phone);

    if ($stm->execute()) {
        echo json_encode(["status" => "success", "message" => "User created successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to create user."]);
    }
}
//fetch roles from
function getRoles() {
  include '../../Connection/connection.php';
  $db = new DatabaseConnection();
  $conn = $db->getConnection();

  $query = "SHOW COLUMNS FROM Users WHERE Field = 'role'";
  $stmt = $conn->prepare($query);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  // Extract ENUM values
  $type = $result['Type']; // e.g., "enum('Admin','Doctor','Patient')"
  preg_match("/^enum\((.*)\)$/", $type, $matches);
  $enumValues = array_map(function ($value) {
      return trim($value, "'");
  }, explode(",", $matches[1]));

  echo json_encode(["roles" => $enumValues]);
}
//fetch status from
function getStatus() {
  include '../../Connection/connection.php';
  $db = new DatabaseConnection();
  $conn = $db->getConnection();

  $query = "SHOW COLUMNS FROM Users WHERE Field = 'status'";
  $stmt = $conn->prepare($query);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  // Extract ENUM values
  $type = $result['Type']; // e.g., "enum('active','inactive')"
  preg_match("/^enum\((.*)\)$/", $type, $matches);
  $enumValues = array_map(function ($value) {
      return trim($value, "'");
  }, explode(",", $matches[1]));

  echo json_encode(["status" => $enumValues]);
}
//update users

function UpdateUser() {
    include '../../Connection/connection.php';
    $db = new DatabaseConnection();
    $conn = $db->getConnection();

    // Collect data from POST request
    $user_id = $_POST['edit_user_id'];
    $fullName = $_POST['edit_fullName'];
    $email = $_POST['edit_email'];
    $username = $_POST['edit_userName']; // Get password from form
    $password = $_POST['edit_password'];
    $phone = $_POST['edit_phone'];
    $status = $_POST['edit_status'];
    $role = $_POST['edit_role'];

    // Start with a basic update query without password
    if (!empty($password)) {
        // If password is provided, use it directly (without hashing)
        $query = 'UPDATE Users 
                  SET fullName = :fullName, email = :email, username = :username, password = :password, phone = :phone, status = :status, role = :role, deleted_at = NULL 
                  WHERE user_id = :user_id';
    } else {
        // If password is empty, update other fields without touching password
        $query = 'UPDATE Users 
                  SET fullName = :fullName, email = :email, username = :username, phone = :phone, status = :status, role = :role, deleted_at = NULL 
                  WHERE user_id = :user_id';
    }

    // Prepare and execute the query
    $stmt = $conn->prepare($query);

    if (!empty($password)) {
        // If password is provided, bind the password as it is
        $stmt->execute([
            ':user_id' => $user_id,
            ':fullName' => $fullName,
            ':email' => $email,
            ':username' => $username,
            ':password' => $password,
            ':phone' => $phone,
            ':status' => 'active',  // Set status to active
            ':role' => $role
        ]);
    } else {
        // If password is not provided, update other fields only
        $stmt->execute([
            ':user_id' => $user_id,
            ':fullName' => $fullName,
            ':email' => $email,
            ':username' => $username,
            ':phone' => $phone,
            ':status' => 'active',  // Set status to active
            ':role' => $role
        ]);
    }

    // Return success response
    echo json_encode(["status" => "success", "message" => "User updated successfully!"]);
}

function DeleteUser() {
  include '../../Connection/connection.php';
  $db = new DatabaseConnection();
  $conn = $db->getConnection();

  // Collect data from POST request
  $user_id = $_POST['id'];
  if(!$user_id )
    {
        echo json_encode(["status"=>"error", 
         "message"=>' user_id are required']); 
         return;
    }

  // Prepare and execute the DELETE query
  $stmt = $conn->prepare("DELETE FROM Users WHERE user_id = :user_id");
  $stmt->bindParam(':user_id', $user_id);

  if ($stmt->execute()) {
      echo json_encode(["status" => "success", "message" => "Users deleted successfully!"]);
  } else {
      echo json_encode(["status" => "error", "message" => "Failed to delete user."]);
  }
}
?>