<?php
$route = $_REQUEST['url'];
$route();
function displayAllAppointment(){
    include '../../Connection/connection.php';
    include '../../Connection/code.php';

    // Start session to get logged-in patient info
    session_start();
    
    // Check if the user is logged in and has the 'Patient' role
    if (!isset($_SESSION['user']) || $_SESSION['role'] != 'Patient') {
        // Redirect to login page if not logged in or not a Patient
        header("Location: login.php");
        exit();
    }
    
    $db = new DatabaseConnection();
    $database = $db->getConnection();

    // Get the logged-in patient's user_id
    $patient_user_id = $_SESSION['user_id'];

    // SQL Query to join Appointments, Doctors, Patients, and Users for fullName, 
    // and filter by the logged-in patient's user_id, with additional filters for active appointments and non-deleted records
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
              JOIN Users AS UsersPatient ON Patients.user_id = UsersPatient.user_id
              WHERE Patients.user_id = :patient_user_id
              AND UsersPatient.status = "active"
              AND UsersPatient.deleted_at IS NULL';  // Exclude soft-deleted patients based on Users table

    // Prepare and execute the query
    $stmt = $database->prepare($query);
    $stmt->bindParam(':patient_user_id', $patient_user_id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the results
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the results as JSON
    echo json_encode($appointments);
}


function loadData() {
    include '../../Connection/connection.php';
    $db = new DatabaseConnection();
    $conn = $db->getConnection();

    session_start(); // Start the session to access the logged-in user data

    // Check if the user is logged in and is a patient
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["status" => "error", "message" => "User is not logged in."]);
        return;
    }

    $loggedInUserId = $_SESSION['user_id']; // Get the logged-in user ID

    try {
        // Fetch Active Patient Data for the logged-in user
        $patientsQuery = "SELECT p.patient_id, u.fullName 
                          FROM Patients p 
                          JOIN Users u ON p.user_id = u.user_id 
                          WHERE u.role = 'Patient' 
                          AND u.status = 'active' 
                          AND u.deleted_at IS NULL 
                          AND u.user_id = :loggedInUserId"; // Filter by logged-in user
        $patientsStmt = $conn->prepare($patientsQuery);
        $patientsStmt->bindParam(':loggedInUserId', $loggedInUserId);
        $patientsStmt->execute();
        $patients = $patientsStmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch Active Doctors with status 'active' and deleted_at is NULL
        $doctorsQuery = "SELECT d.doctor_id, u.fullName, d.consultation_fee 
                         FROM Doctors d 
                         JOIN Users u ON d.user_id = u.user_id 
                         WHERE u.role = 'Doctor' 
                         AND u.status = 'active' 
                         AND u.deleted_at IS NULL";
        $doctorsStmt = $conn->prepare($doctorsQuery);
        $doctorsStmt->execute();
        $doctors = $doctorsStmt->fetchAll(PDO::FETCH_ASSOC);

        // Load Appointments (filter by active status)
        $appointmentQuery = "SELECT appointment_id, patient_id, doctor_id, appointment_date, status, payment_status, consultation_fee 
                             FROM Appointments 
                             WHERE patient_id = :patient_id"; // Filter appointments for the logged-in patient
        $appointmentStmt = $conn->prepare($appointmentQuery);
        $appointmentStmt->bindParam(':patient_id', $patients[0]['patient_id']);
        $appointmentStmt->execute();
        $appointments = $appointmentStmt->fetchAll(PDO::FETCH_ASSOC);

        // Return JSON
        echo json_encode([
            'Patients' => $patients,
            'Doctors' => $doctors,
            'Appointments' => $appointments // if you want to include appointments
        ]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}


function createAppointment() {
    include '../../Connection/connection.php';
    $db = new DatabaseConnection();
    $conn = $db->getConnection();

    // Collecting data from POST request
    $patient_id = $_POST['patient_id'];  
    $doctor_id = $_POST['doctor_id'];  
    $appointment_date = $_POST['appointment_date'];  
    $consultation_fee = $_POST['consultation_fee'];  

    // Check if all required fields are provided
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

    try {
        // Prepare the SQL query to insert the appointment data
        $query = "INSERT INTO Appointments (patient_id, doctor_id, appointment_date, consultation_fee, status, payment_status, reminder) 
                  VALUES (:patient_id, :doctor_id, :appointment_date, :consultation_fee, 'pending', 'pending', 0)";
        $stm = $conn->prepare($query);
        $stm->bindParam(':patient_id', $patient_id);
        $stm->bindParam(':doctor_id', $doctor_id);
        $stm->bindParam(':appointment_date', $appointment_date);
        $stm->bindParam(':consultation_fee', $consultation_fee);

        // Execute the query
        if ($stm->execute()) {
            echo json_encode(["status" => "success", "message" => "Appointment created successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to create appointment, check your query"]);
        }
    } catch (PDOException $e) {
        // Log the exception message for debugging
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
    } catch (Exception $e) {
        // Catch any other unexpected exceptions
        echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    }
}

function deleteAppointment() {
    include '../../Connection/connection.php';
    $db = new DatabaseConnection();
    $conn = $db->getConnection();

    // Collect data from POST request
    $appointment_id = $_POST['id'];

    // Validate appointment_id
    if(!$appointment_id) {
        echo json_encode(["status" => "error", "message" => 'Appointment ID is required']);
        return;
    }

    // Fetch the patient_id associated with the appointment_id to update the Users table
    $stmt = $conn->prepare("SELECT patient_id FROM Appointments WHERE appointment_id = :appointment_id");
    $stmt->bindParam(':appointment_id', $appointment_id);
    $stmt->execute();
    
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$appointment) {
        echo json_encode(["status" => "error", "message" => "Appointment not found"]);
        return;
    }

    $patient_id = $appointment['patient_id'];

    // Update the Users table for the patient (soft delete: set deleted_at to NOW())
    $stmt = $conn->prepare("UPDATE Users SET deleted_at = NOW(), status='inactive' WHERE user_id = (SELECT user_id FROM Patients WHERE patient_id = :patient_id)");
    $stmt->bindParam(':patient_id', $patient_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Appointment soft deleted successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to soft delete Appointment."]);
    }
}


?>