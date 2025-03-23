<?php
$route = $_REQUEST['url'];
$route();
function displayRejectedAppointment(){
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
              JOIN Users AS UsersPatient ON Patients.user_id = UsersPatient.user_id
               WHERE Appointments.status = "Rejected"'
             ;

    // Prepare and execute the query
    $stmt = $database->prepare($query);
    $stmt->execute();

    // Fetch the results
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the results as JSON
    echo json_encode($appointments);
}
?>