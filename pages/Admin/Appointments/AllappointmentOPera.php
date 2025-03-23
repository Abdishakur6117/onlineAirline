<?php
$route = $_REQUEST['url'];
$route();
function displayAllAppointment(){
  include '../../Connection/connection.php';
  include '../../Connection/code.php';

    $db = new DatabaseConnection();
    $database = $db->getConnection();
    
    // SQL Query to join Appointments, Doctors, Patients, and Users for fullName
    $query = 'SELECT 
                Appointments.*, 
                Doctors.doctor_id, 
                Doctors.user_id AS doctor_user_id, 
                Patients.patient_id, 
                Patients.user_id AS patient_user_id, 
                UsersDoctor.fullName AS doctor_fullName, 
                UsersPatient.fullName AS patient_fullName
              FROM Appointments
              JOIN Doctors ON Appointments.doctor_id = Doctors.doctor_id
              JOIN Patients ON Appointments.patient_id = Patients.patient_id
              JOIN Users AS UsersDoctor ON Doctors.user_id = UsersDoctor.user_id
              JOIN Users AS UsersPatient ON Patients.user_id = UsersPatient.user_id';

    // Prepare and execute the query
    $stmt = $database->prepare($query);
    $stmt->execute();

    // Fetch the results
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the results as JSON
    echo json_encode($appointments);
}


function loadData(){
  include '../../Connection/connection.php';
  $db = new DatabaseConnection();
  $conn = $db->getConnection();
  
  try {
      // Fetch Patients
      $patientsQuery = "SELECT p.patient_id, u.fullName FROM Patients p JOIN Users u ON p.user_id = u.user_id WHERE u.role = 'Patient'";
      $patientsStmt = $conn->prepare($patientsQuery);
      $patientsStmt->execute();
      $patients = $patientsStmt->fetchAll(PDO::FETCH_ASSOC);
  
      // Fetch Doctors
      $doctorsQuery = "SELECT d.doctor_id, u.fullName, d.consultation_fee FROM Doctors d JOIN Users u ON d.user_id = u.user_id WHERE u.role = 'Doctor'";
      $doctorsStmt = $conn->prepare($doctorsQuery);
      $doctorsStmt->execute();
      $doctors = $doctorsStmt->fetchAll(PDO::FETCH_ASSOC);
      // Load Appointments (si status & payment_status loo helo)
      $appointmentQuery = "SELECT appointment_id, patient_id, doctor_id, appointment_date, status, payment_status, consultation_fee 
                           FROM Appointments";
      $appointmentStmt = $conn->prepare($appointmentQuery);
      $appointmentStmt->execute();
      // $response['Appointments'] = $appointmentStmt->fetchAll(PDO::FETCH_ASSOC);
  
      // Return JSON
      // echo json_encode($response);
  
      echo json_encode(['Patients' => $patients, 'Doctors' => $doctors]);
  } catch (Exception $e) {
      echo json_encode(["status" => "error", "message" => $e->getMessage()]);
  }


}

  

function createAppointment(){
  include '../../Connection/connection.php';
  $db = new DatabaseConnection();
  $conn = $db->getConnection();
  
  $patient_id = $_POST['patient_id'];  
  $doctor_id = $_POST['doctor_id'];  
  $appointment_date = $_POST['appointment_date'];  
  $consultation_fee = $_POST['consultation_fee'];  

  // Check if all fields are filled
  if (!$patient_id) {
    echo json_encode(["status" => "error", "message" => "Patient ID is required."]);
    return;
  }
  if (!$doctor_id) {
    echo json_encode(["status" => "error", "message" => "Doctor ID is required."]);
    return;
  }
  if (!$appointment_date) {
    echo json_encode(["status" => "error", "message" => "Appointment date is required."]);
    return;
  }
  if (!$consultation_fee) {
    echo json_encode(["status" => "error", "message" => "Consultation fee is required."]);
    return;
  }

  // Insert the appointment data
  $query = "INSERT INTO Appointments (patient_id, doctor_id, appointment_date, consultation_fee, status, payment_status, reminder) 
            VALUES (:patient_id, :doctor_id, :appointment_date, :consultation_fee, 'pending', 'pending', 0)";
  $stm = $conn->prepare($query);
  $stm->bindParam(':patient_id', $patient_id);
  $stm->bindParam(':doctor_id', $doctor_id);
  $stm->bindParam(':appointment_date', $appointment_date);
  $stm->bindParam(':consultation_fee', $consultation_fee);

  if ($stm->execute()) {
    echo json_encode(["status" => "success", "message" => "Appointment created successfully"]);
  } else {
    echo json_encode(["status" => "error", "message" => "Failed to create appointment"]);
  }
}
function UpdateAppointment() {
  include '../../Connection/connection.php';
  $db = new DatabaseConnection();
  $conn = $db->getConnection();

  // Retrieve form data
  $appointment_id = $_POST['appointment_id'];
  $patient_id = $_POST['edit_patient_id'];
  $doctor_id = $_POST['edit_doctor_id'];
  $appointment_date = $_POST['edit_appointment_date'];
  $status = $_POST['edit_status'];
  $payment_status = $_POST['edit_appointmentStatus'];
  $consultation_fee = $_POST['edit_consultation_fee'];

  // Validate required fields
  if (!$appointment_id) {
    echo json_encode(["status" => "error", "message" => "Appointment ID is required."]);
    return;
  }
  if (!$patient_id) {
    echo json_encode(["status" => "error", "message" => "Patient ID is required."]);
    return;
  }
  if (!$doctor_id) {
    echo json_encode(["status" => "error", "message" => "Doctor ID is required."]);
    return;
  }
  if (!$appointment_date) {
    echo json_encode(["status" => "error", "message" => "Appointment date is required."]);
    return;
  }
  if (!$status) {
    echo json_encode(["status" => "error", "message" => "Status is required."]);
    return;
  }
  if (!$payment_status) {
    echo json_encode(["status" => "error", "message" => "Payment status is required."]);
    return;
  }
  if (!$consultation_fee) {
    echo json_encode(["status" => "error", "message" => "Consultation fee is required."]);
    return;
  }

  // Update query for Appointments
  $query = "UPDATE Appointments 
            SET patient_id = :patient_id, 
                doctor_id = :doctor_id, 
                appointment_date = :appointment_date, 
                status = :status, 
                payment_status = :payment_status, 
                consultation_fee = :consultation_fee 
            WHERE appointment_id = :appointment_id";

  $stm = $conn->prepare($query);
  $stm->bindParam(':patient_id', $patient_id);
  $stm->bindParam(':doctor_id', $doctor_id);
  $stm->bindParam(':appointment_date', $appointment_date);
  $stm->bindParam(':status', $status);
  $stm->bindParam(':payment_status', $payment_status);
  $stm->bindParam(':consultation_fee', $consultation_fee);
  $stm->bindParam(':appointment_id', $appointment_id);

  // Execute the query
  if ($stm->execute()) {
    echo json_encode(["status" => "success", "message" => "Appointment updated successfully"]);
  } else {
    echo json_encode(["status" => "error", "message" => "Update failed"]);
  }
}

function deleteAppointment() {
  include '../../Connection/connection.php';
  $db = new DatabaseConnection();
  $conn = $db->getConnection();

  // Collect data from POST request
  $appointment_id = $_POST['id'];
  if(!$appointment_id )
    {
        echo json_encode(["status"=>"error", 
         "message"=>' UserID are required']); 
         return;
    }

  // Prepare and execute the DELETE query
  $stmt = $conn->prepare("DELETE FROM Appointments WHERE appointment_id = :appointment_id");
  $stmt->bindParam(':appointment_id', $appointment_id);

  if ($stmt->execute()) {
      echo json_encode(["status" => "success", "message" => "Appointment deleted successfully!"]);
  } else {
      echo json_encode(["status" => "error", "message" => "Failed to delete Patient."]);
  }
}
?>