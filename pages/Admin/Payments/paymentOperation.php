<?php
$route = $_REQUEST['url'];
$route();
function displayPayment(){
    include '../../Connection/connection.php';
    include '../../Connection/code.php';
    $db = new DatabaseConnection();
    $database = $db->getConnection();
    $query = new myCode($database);

    // Modify the query to join Payment, Appointment, Patient, and User tables
    $sql = "SELECT 
                p.payment_id, 
                p.appointment_id, 
                p.amount, 
                p.payment_method, 
                p.transaction_id, 
                p.payment_date, 
                u.fullName AS fullName
            FROM Payments p
            LEFT JOIN Appointments a ON p.appointment_id = a.appointment_id
            LEFT JOIN Patients pt ON a.patient_id = pt.patient_id
            LEFT JOIN Users u ON pt.user_id = u.user_id"; // Assuming place_name is in the Users table (or use the appropriate column)

    // Prepare and execute the query
    $stmt = $database->prepare($sql);
    $stmt->execute();
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the data as a JSON response
    echo json_encode($payments);
}


//insert users
function createPayment(){
    include '../../Connection/connection.php';
    $db = new DatabaseConnection();
    $conn = $db->getConnection();
    
    $appointment_id = $_POST['Appointment_id'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $transaction_id = $_POST['transaction_id'];

    // Input validation
    if(!$appointment_id){
        echo json_encode(["status" => "error", "message" => "Appointment ID is required."]);
        return;
    }
    if(!$amount){
        echo json_encode(["status" => "error", "message" => "Amount is required."]);
        return;
    }
    if(!$payment_method){
        echo json_encode(["status" => "error", "message" => "Payment Method is required."]);
        return;
    }
    if(!$transaction_id){
        echo json_encode(["status" => "error", "message" => "Transaction ID is required."]);
        return;
    }

    // Check for unique transaction ID
    $transactionCheck = "SELECT COUNT(*) FROM Payments WHERE transaction_id = :transaction_id";
    $stmt = $conn->prepare($transactionCheck);
    $stmt->bindParam(':transaction_id', $transaction_id);
    $stmt->execute();
    if($stmt->fetchColumn() > 0){
        echo json_encode(["status" => "error", "message" => "Transaction ID already exists"]);
        return;
    }

    // Check if there's still a balance on the appointment
    $balanceCheck = "SELECT consultation_fee - paid AS balance FROM Appointments WHERE appointment_id = :appointment_id";
    $stmt = $conn->prepare($balanceCheck);
    $stmt->bindParam(':appointment_id', $appointment_id);
    $stmt->execute();
    $balance = $stmt->fetchColumn();

    // If balance is 0, do not allow further payments
    if ($balance <= 0) {
        echo json_encode(["status" => "error", "message" => "No outstanding balance, payment cannot be processed."]);
        return;
    }

    // If the amount to be paid is more than the remaining balance, reject the payment
    if ($amount > $balance) {
        echo json_encode(["status" => "error", "message" => "Payment amount exceeds outstanding balance."]);
        return;
    }

    // Start transaction
    $conn->beginTransaction();

    try {
        // Insert payment
        $insertQuery = "INSERT INTO Payments (appointment_id, amount, payment_method, transaction_id) 
                        VALUES (:appointment_id, :amount, :payment_method, :transaction_id)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bindParam(':appointment_id', $appointment_id);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':payment_method', $payment_method);
        $stmt->bindParam(':transaction_id', $transaction_id);
        $stmt->execute();

        // Update appointment
        $updateQuery = "UPDATE Appointments 
                        SET 
                            paid = paid + :amount,
                            Reminder = consultation_fee - paid,
                            payment_status = IF(consultation_fee - paid <= 0, 'paid', payment_status)
                        WHERE appointment_id = :appointment_id";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':appointment_id', $appointment_id);
        $stmt->execute();

        // Commit transaction
        $conn->commit();

        echo json_encode([ 
            "status" => "success", 
            "message" => "Payment recorded and appointment updated successfully"
        ]);

    } catch (PDOException $e) {
        // Rollback on error
        $conn->rollBack();
        echo json_encode([
            "status" => "error", 
            "message" => "Transaction failed: " . $e->getMessage()
        ]);
    }
}

//fetch roles from
function loadData() {
    include '../../Connection/connection.php';
    $db = new DatabaseConnection();
    $conn = $db->getConnection();

    try {
        $query = "SELECT a.appointment_id, u.fullName ,a.consultation_fee
                 FROM Appointments a
                 JOIN Patients p ON a.patient_id = p.patient_id
                 JOIN Users u ON p.user_id = u.user_id";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['status' => 'success', 'appointments' => $appointments]);
        
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
function UpdatePayment() {
    include '../../Connection/connection.php';
    $db = new DatabaseConnection();
    $conn = $db->getConnection();

    // Collect data from POST request
    $payment_id = $_POST['payment_id'];
    $appointment_id = $_POST['edit_Appointment_id'];
    $amount = $_POST['edit_amount'];
    $payment_method = $_POST['edit_payment_method'];
    $transaction_id = $_POST['edit_transaction_id'];

    // Prepare the update query for payment data
    $query = 'UPDATE Payments SET appointment_id = :appointment_id, amount = :amount, payment_method = :payment_method, transaction_id = :transaction_id WHERE payment_id = :payment_id';

    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':payment_id' => $payment_id,
        ':appointment_id' => $appointment_id,
        ':amount' => $amount,
        ':payment_method' => $payment_method,
        ':transaction_id' => $transaction_id
    ]);

    // Return success response
    echo json_encode(["status" => "success", "message" => "Payment updated successfully!"]);
}

function DeletePayment() {
  include '../../Connection/connection.php';
  $db = new DatabaseConnection();
  $conn = $db->getConnection();

  // Collect data from POST request
  $payment_id = $_POST['id'];
  if(!$payment_id )
    {
        echo json_encode(["status"=>"error", 
         "message"=>' payment_id are required']); 
         return;
    }

  // Prepare and execute the DELETE query
  $stmt = $conn->prepare("DELETE FROM Payments WHERE payment_id = :payment_id");
  $stmt->bindParam(':payment_id', $payment_id);

  if ($stmt->execute()) {
      echo json_encode(["status" => "success", "message" => "Payment deleted successfully!"]);
  } else {
      echo json_encode(["status" => "error", "message" => "Failed to delete user."]);
  }
}
?>