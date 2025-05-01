<?php 
$route = $_REQUEST['url'];
$route();

// session_start();
function login() {
    include 'pages/Connection/connection.php';
    $db = new DatabaseConnection();
    $conn = $db->getConnection();

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!$username) {
        echo json_encode(["status" => "error", "message" => 'username is required']);
        return;
    }
    if (!$password) {
        echo json_encode(["status" => "error", "message" => 'Password is required']);
        return;
    }

    // Query to check the user in the database, adding the status and deleted_at conditions
    $query = 'SELECT * FROM users WHERE username = :username';
    $stm = $conn->prepare($query);
    $stm->execute(['username' => $username]);
    $userData = $stm->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
        // Check if password matches
        if ($password == $userData['password']) {  // Use password_verify for hashed passwords
            session_start();
            $_SESSION['user'] = $userData['username'];
            $_SESSION['id'] = $userData['id'];
            $_SESSION['role'] = $userData['role'];  // Save user role in the session
            $_SESSION['username'] = $userData['username'];

            echo json_encode(["status" => "success", "message" => 'User logged in successfully', "role" => $userData['role']]);
        } else {
            echo json_encode(["status" => "error", "message" => 'Incorrect password']);
        }
    } else {
        echo json_encode(["status" => "error", "message" => 'User not found, or inactive or deleted']);
    }
}


?>