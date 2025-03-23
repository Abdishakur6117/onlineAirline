<?php 
$route = $_REQUEST['url'];
$route();

function login() {
    include 'pages/Connection/connection.php';
    $db = new DatabaseConnection();
    $conn = $db->getConnection();

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!$email) {
        echo json_encode(["status" => "error", "message" => 'Email is required']);
        return;
    }
    if (!$password) {
        echo json_encode(["status" => "error", "message" => 'Password is required']);
        return;
    }

    // Query to check the user in the database, adding the status and deleted_at conditions
    $query = 'SELECT * FROM users WHERE email = :email AND status = "active" AND deleted_at IS NULL';
    $stm = $conn->prepare($query);
    $stm->execute(['email' => $email]);
    $userData = $stm->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
        // Check if password matches
        if ($password == $userData['password']) {  // Use password_verify for hashed passwords
            session_start();
            $_SESSION['user'] = $userData['email'];
            $_SESSION['user_id'] = $userData['user_id'];
            $_SESSION['role'] = $userData['role'];  // Save user role in the session
            $_SESSION['email'] = $userData['email'];

            echo json_encode(["status" => "success", "message" => 'User logged in successfully', "role" => $userData['role']]);
        } else {
            echo json_encode(["status" => "error", "message" => 'Incorrect password']);
        }
    } else {
        echo json_encode(["status" => "error", "message" => 'User not found, or inactive or deleted']);
    }
}


?>