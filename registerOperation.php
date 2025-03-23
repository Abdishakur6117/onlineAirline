<?php
$route = $_REQUEST['url'];
$route();

function registration() {
    include 'pages/Connection/connection.php';

    // Enable error reporting for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Get form data
    $fullName = $_POST['fullName'] ?? '';
    $email = $_POST['email'] ?? '';
    $userName = $_POST['userName'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';  // Get confirmPassword
    $phone = $_POST['phone'] ?? '';
    $DOB = $_POST['DOB'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $bloodType = $_POST['bloodType'] ?? '';
    $address = $_POST['address'] ?? '';

    // Server-side validation
    if (!$fullName) {
        echo json_encode(["status" => "error", "message" => 'Full Name is required']);
        return;
    }
    if (!$email) {
        echo json_encode(["status" => "error", "message" => 'Email is required']);
        return;
    }
    if (!$userName) {
        echo json_encode(["status" => "error", "message" => 'User Name is required']);
        return;
    }
    if (!$password) {
        echo json_encode(["status" => "error", "message" => 'Password is required']);
        return;
    }
    if ($password !== $confirmPassword) {
        echo json_encode(["status" => "error", "message" => 'Passwords do not match!']);
        return;
    }
    if (!$DOB) {
        echo json_encode(["status" => "error", "message" => 'Date of Birth is required']);
        return;
    }
    if (!$gender) {
        echo json_encode(["status" => "error", "message" => 'Gender is required']);
        return;
    }
    if (!$phone) {
        echo json_encode(["status" => "error", "message" => 'Phone is required']);
        return;
    }
    if (!$bloodType) {
        echo json_encode(["status" => "error", "message" => 'Blood Type is required']);
        return;
    }
    if (!$address) {
        echo json_encode(["status" => "error", "message" => 'Address is required']);
        return;
    }

 

    try {
        $db = new DatabaseConnection();
        $conn = $db->getConnection();

         //checks emails
      $emailCheck = "SELECT * FROM Users WHERE email =:email ";
      $stm =$conn->prepare($emailCheck);
      $stm->bindParam(':email',$email);
      $stm->execute();
      $emailExists = $stm->fetchColumn();
      if($emailExists > 0){
        echo json_encode(["status" => "error", "message" => 'Email already exists ']);
        return;

      }

        // Start a transaction to ensure atomicity
        $conn->beginTransaction();
    

        // Insert data into the Users table
        $stmt = $conn->prepare("INSERT INTO Users (fullName, email, UserName, password, phone) 
                                VALUES (:fullName, :email, :UserName, :password, :phone)");
        $stmt->bindParam(':fullName', $fullName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':UserName', $userName);
        $stmt->bindParam(':password', $password);  // Store hashed password
        $stmt->bindParam(':phone', $phone);
        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            echo json_encode([
                'status' => 'error',
                'message' => 'SQL Error: ' . $errorInfo[2]
            ]);
            return;
        }

        // Get the inserted user's ID
        $userId = $conn->lastInsertId();

        // Insert data into the Patients table (linking the user via userId)
        $stmt2 = $conn->prepare("INSERT INTO Patients (user_id, date_of_birth, gender, blood_type, address) 
                                 VALUES (:userId, :date_of_birth, :gender, :blood_type, :address)");
        $stmt2->bindParam(':userId', $userId);
        $stmt2->bindParam(':date_of_birth', $DOB);
        $stmt2->bindParam(':gender', $gender);
        $stmt2->bindParam(':blood_type', $bloodType);
        $stmt2->bindParam(':address', $address);
        if (!$stmt2->execute()) {
            $errorInfo = $stmt2->errorInfo();
            echo json_encode([
                'status' => 'error',
                'message' => 'SQL Error: ' . $errorInfo[2]
            ]);
            return;
        }

        // Commit the transaction
        $conn->commit();

        // Return success response
        echo json_encode([
            'status' => 'success',
            'message' => 'Signup successful!'
        ]);

    } catch (Exception $e) {
        // Rollback the transaction if any error occurs
        $conn->rollBack();
        echo json_encode([
            'status' => 'error',
            'message' => 'Something went wrong. Please try again later.',
            'error_details' => $e->getMessage()  // Log the exception message for debugging
        ]);
    }
}
?>
