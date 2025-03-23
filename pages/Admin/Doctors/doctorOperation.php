<?php
$route = $_REQUEST['url'];
$route();
function displayDoctor(){
    include '../../Connection/connection.php';
    include '../../Connection/code.php';

    $db = new DatabaseConnection();
    $database = $db->getConnection();
    
    // SQL Query to join Doctors and Users tables on user_id
    $query = 'SELECT Doctors.*, Users.fullName FROM Doctors JOIN Users ON Doctors.user_id = Users.user_id';

    // Prepare and execute the query
    $stmt = $database->prepare($query);
    $stmt->execute();

    // Fetch the results
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the results as JSON
    echo json_encode($doctors);
}

function loadData(){
  include '../../Connection/connection.php';
  $db = new DatabaseConnection();
  $conn =$db->getConnection();
  try {
    $usersQuery = "SELECT user_id, fullName FROM Users WHERE role = 'Doctor' ";

    $usersStmt = $conn->prepare($usersQuery);
    // $coursesStmt = $conn->prepare($coursesQuery);

    $usersStmt->execute();
    // $coursesStmt->execute();

    $users = $usersStmt->fetchAll(PDO::FETCH_ASSOC);
    // $courses = $coursesStmt->fetchAll(PDO::FETCH_ASSOC);
    

    echo json_encode(['Users' => $users]);
  } catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
  }
}
function loadDoctors() {
    include '../../Connection/connection.php';
    $db = new DatabaseConnection();
    $conn = $db->getConnection();

    try {
        // Isticmaal PDO, ma ahan MySQLi
        $sql = "SELECT u.user_id, u.fullName, d.doctor_id, d.consultation_fee 
                FROM Users u
                JOIN doctors d ON u.user_id = d.user_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC); // Isticmaal fetchAll() ee PDO

        echo json_encode(["Users" => $users]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Query failed: " . $e->getMessage()]);
    }
}

function createDoctor() {
  include '../../Connection/connection.php';
  $db = new DatabaseConnection();
  $conn = $db->getConnection();

  $user_id = $_POST['user_id']; // Waa user_id oo waa la wadaagayaa
  $specialization = $_POST['special'];
  $availability = $_POST['availability'];
  $consultation_fee = $_POST['consultation'];

  // Hubinta in dhammaan xogta loo baahan yahay la helay
  if (!$user_id) {
      echo json_encode(["status" => "error", "message" => "user_id is required."]);
      return;
  }
  if (!$specialization) {
      echo json_encode(["status" => "error", "message" => "specialization is required."]);
      return;
  }
  if (!$availability) {
      echo json_encode(["status" => "error", "message" => "availability is required."]);
      return;
  }
  if (!$consultation_fee) {
      echo json_encode(["status" => "error", "message" => "consultation_fee is required."]);
      return;
  }

  // Hubinta haddii user_id uu horey ugu jiro `Doctors` table
  $user_idCheck = "SELECT COUNT(*) FROM Doctors WHERE user_id = :user_id";
  $stm = $conn->prepare($user_idCheck);
  $stm->bindParam(':user_id', $user_id);
  $stm->execute();
  $user_idExists = $stm->fetchColumn();

  if ($user_idExists > 0) {
      echo json_encode(["status" => "error", "message" => "user_id already exists in Doctors."]);
      return;
  }

  // Query-ga INSERT
  $query = "INSERT INTO Doctors (user_id, specialization, availability, consultation_fee) 
            VALUES (:user_id, :specialization, :availability, :consultation_fee)";
  $stm = $conn->prepare($query);
  $stm->bindParam(':user_id', $user_id);
  $stm->bindParam(':specialization', $specialization);
  $stm->bindParam(':availability', $availability);
  $stm->bindParam(':consultation_fee', $consultation_fee);

  if ($stm->execute()) {
      echo json_encode(["status" => "success", "message" => "Doctor data saved successfully"]);
  } else {
      echo json_encode(["status" => "error", "message" => "Doctor data was not saved"]);
  }
}

//Update
function UpdateDoctor(){
  include '../../Connection/connection.php';
  $db = new DatabaseConnection();
  $conn =$db->getConnection();

  $doctor_id = $_POST['edit_doctor_id'] ;
  $user_id = $_POST['edit_doctor_id'] ;
  $special = $_POST['edit_special'] ;
  $availability = $_POST['edit_availability'] ;
  $consultation = $_POST['edit_consultation'] ;
  
  
  if (!$doctor_id) {
    echo json_encode(["status"=>"error", "message"=>' Doctor_id are required']); 
         return;
  }
  if (!$user_id) {
    echo json_encode(["status"=>"error", "message"=>' User_id are required']); 
         return;
  }
  if (!$special) {
    echo json_encode(["status" => "error", "message" => 'Special is required']);
    return;
  }
  if (!$availability) {
    echo json_encode(["status" => "error", "message" => 'Availability is required']);
    return;
  }
  if (!$consultation) {
    echo json_encode(["status" => "error", "message" => 'Consultation is required']);
    return;
  }


  
   // INSERT query with correct column names in database
   $query = "UPDATE  Doctors SET user_id=:user_id ,specialization=:special ,availability=:availability ,consultation_fee=:consultation WHERE doctor_id=:doctor_id";
   $stm= $conn->prepare($query);
   $stm->bindParam(':doctor_id', $doctor_id);
   $stm->bindParam(':user_id', $user_id);
   $stm->bindParam(':special', $special);
   $stm->bindParam(':availability', $availability);
   $stm->bindParam(':consultation', $consultation);
  
    if($stm->execute()){
      echo json_encode(["status"=>"success",  "message"=>' Updated successfully']); 
      return;
    }else{
      echo json_encode(['status'=>'error', "message"=>'Update are  not successfully']);
    }

}
function DeleteDoctor() {
  include '../../Connection/connection.php';
  $db = new DatabaseConnection();
  $conn = $db->getConnection();

  // Collect data from POST request
  $doctor_id = $_POST['id'];
  if(!$doctor_id )
    {
        echo json_encode(["status"=>"error", 
         "message"=>' UserID are required']); 
         return;
    }

  // Prepare and execute the DELETE query
  $stmt = $conn->prepare("DELETE FROM Doctors WHERE doctor_id = :doctor_id");
  $stmt->bindParam(':doctor_id', $doctor_id);

  if ($stmt->execute()) {
      echo json_encode(["status" => "success", "message" => "User deleted successfully!"]);
  } else {
      echo json_encode(["status" => "error", "message" => "Failed to delete user."]);
  }
}


?>