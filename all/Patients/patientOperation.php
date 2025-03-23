<?php
$route = $_REQUEST['url'];
$route();
function displayPatient(){
    include '../Connection/connection.php';
    include '../Connection/code.php';

    $db = new DatabaseConnection();
    $database = $db->getConnection();
    
    // SQL Query to join Doctors and Users tables on user_id
    $query = 'SELECT Patients.*, Users.fullName FROM Patients JOIN Users ON Patients.user_id = Users.user_id';

    // Prepare and execute the query
    $stmt = $database->prepare($query);
    $stmt->execute();

    // Fetch the results
    $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the results as JSON
    echo json_encode($doctors);
}
function loadData(){
  include '../Connection/connection.php';
  $db = new DatabaseConnection();
  $conn =$db->getConnection();
  try {
    $usersQuery = "SELECT user_id, fullName FROM Users WHERE role = 'Patient' ";
    // $coursesQuery = "SELECT id, name FROM courses";

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
//insert users
// function createPatient(){
//   include '../Connection/connection.php';
//   $db = new DatabaseConnection();
//   $conn =$db->getConnection();

//   $user_id =$_POST['user_id'];
//   $date_of_birth =$_POST['date_of_birth'];
//   $gender =$_POST['gender'];
//   $bloodType =$_POST['bloodType'];
//   $address =$_POST['address'];

//   if(!$user_id){
//     echo json_encode(["status" => "error", "message" => "user_id  is required."]);
//       return;
//   }
//   if(!$date_of_birth){
//     echo json_encode(["status" => "error", "message" => "date_of_birth  is required."]);
//       return;
//   }
//   if(!$gender){
//     echo json_encode(["status" => "error", "message" => " gender  is required."]);
//       return;
//   }
//   if(!$bloodType){
//     echo json_encode(["status" => "error", "message" => " bloodType  is required."]);
//       return;
//   }
//   if(!$address){
//     echo json_encode(["status" => "error", "message" => " address  is required."]);
//       return;
//   }
//   //checks User_id
//   $user_idCheck = "SELECT * FROM Patients  WHERE    user_id   =:user_id ";
//   $stm =$conn->prepare($user_idCheck);
//   $stm->bindParam(':user_id ',$user_id);
//   $stm->execute();
//   $user_idExists = $stm->fetchColumn();
//   if($user_idExists > 0){
//     echo json_encode(["status" => "error", "message" => 'user_id already exists ']);
//     return;

//   }

//    // INSERT query with correct column names in database
//    $query = "INSERT INTO Patients   (user_id ,date_of_birth  ,gender,blood_type ,address) VALUES (:user_id,:date_of_birth,:gender,:bloodType,:address)";
//    $stm= $conn->prepare($query);
//    $stm->bindParam(':user_id', $user_id);
//    $stm->bindParam(':date_of_birth', $date_of_birth);
//    $stm->bindParam(':gender', $gender);
//    $stm->bindParam(':bloodType', $bloodType);
//    $stm->bindParam(':address', $address);
  

//     if($stm->execute()){
//       echo json_encode(["status"=>"success",  "message"=>' data saved successfully']); 
//       return;
//     }else{
//       echo json_encode(['status'=>'error', "message"=>'data are  not saved']);
//     }

// }
function createPatient(){
  include '../Connection/connection.php';
  $db = new DatabaseConnection();
  $conn = $db->getConnection();
  
  $user_id = $_POST['user_id'];
  $date_of_birth = $_POST['date_of_birth'];
  $gender = $_POST['gender'];
  $bloodType = $_POST['bloodType'];
  $address = $_POST['address'];

  // check all fields are filled
  if (!$user_id) {
    echo json_encode(["status" => "error", "message" => "user_id is required."]);
    return;
  }
  if (!$date_of_birth) {
    echo json_encode(["status" => "error", "message" => "date_of_birth is required."]);
    return;
  }
  if (!$gender) {
    echo json_encode(["status" => "error", "message" => "gender is required."]);
    return;
  }
  if (!$bloodType) {
    echo json_encode(["status" => "error", "message" => "bloodType is required."]);
    return;
  }
  if (!$address) {
    echo json_encode(["status" => "error", "message" => "address is required."]);
    return;
  }

  // check user_id
  $user_idCheck = "SELECT COUNT(*) FROM Patients WHERE user_id = :user_id";
  $stm = $conn->prepare($user_idCheck);
  $stm->bindParam(':user_id', $user_id);
  $stm->execute();
  $user_idExists = $stm->fetchColumn();

  if ($user_idExists > 0) {
    echo json_encode(["status" => "error", "message" => "user_id already exists."]);
    return;
  }

  // insert data
  $query = "INSERT INTO Patients (user_id, date_of_birth, gender, blood_type, address)  VALUES (:user_id, :date_of_birth, :gender, :blood_type, :address)";
  $stm = $conn->prepare($query);
  $stm->bindParam(':user_id', $user_id);
  $stm->bindParam(':date_of_birth', $date_of_birth);
  $stm->bindParam(':gender', $gender);
  $stm->bindParam(':blood_type', $bloodType);
  $stm->bindParam(':address', $address);

  if ($stm->execute()) {
    echo json_encode(["status" => "success", "message" => "Data saved successfully"]);
  } else {
    echo json_encode(["status" => "error", "message" => "Data was not saved"]);
  }
}
//Update
// function UpdatePatient(){
//   include '../Connection/connection.php';
//   $db = new DatabaseConnection();
//   $conn =$db->getConnection();

//   $patient_id = $_POST['patient_id'] ;
//   $edit_user_id = $_POST['edit_user_id'] ;
//   $edit_dob = $_POST['edit_date_of_birth'] ;
//   $edit_gender = $_POST['edit_gender'] ;
//   $edit_blood_type = $_POST['edit_bloodType'] ;
//   $edit_address = $_POST['edit_address'] ;
  
  
//   if (!$patient_id) {
//     echo json_encode(["status"=>"error", "message"=>' Patient_id are required']); 
//          return;
//   }
//   if (!$edit_user_id) {
//     echo json_encode(["status"=>"error", "message"=>' User_id are required']); 
//          return;
//   }
//   if (!$edit_dob) {
//     echo json_encode(["status" => "error", "message" => 'DOB is required']);
//     return;
//   }
//   if (!$edit_gender) {
//     echo json_encode(["status" => "error", "message" => 'Gender is required']);
//     return;
//   }
//   if (!$edit_blood_type) {
//     echo json_encode(["status" => "error", "message" => 'Blood_type is required']);
//     return;
//   }
//   if (!$edit_address) {
//     echo json_encode(["status" => "error", "message" => 'Address is required']);
//     return;
//   }


  
//    // INSERT query with correct column names in database
//    $query = "UPDATE  Patients SET patient_id=:user_id ,user_id=:special ,date_of_birth=:availability ,gender=:consultation,blood_type=:hhh,address=:jjjj WHERE doctor_id=:doctor_id";
//    $stm= $conn->prepare($query);
//    $stm->bindParam(':patient_id', $doctor_id);
//    $stm->bindParam(':user_id', $user_id);
//    $stm->bindParam(':special', $special);
//    $stm->bindParam(':availability', $availability);
//    $stm->bindParam(':consultation', $consultation);
  
//     if($stm->execute()){
//       echo json_encode(["status"=>"success",  "message"=>' Updated successfully']); 
//       return;
//     }else{
//       echo json_encode(['status'=>'error', "message"=>'Update are  not successfully']);
//     }

// }
function UpdatePatient(){
  include '../Connection/connection.php';
  $db = new DatabaseConnection();
  $conn = $db->getConnection();

  $patient_id = $_POST['patient_id'];
  $edit_user_id = $_POST['edit_user_id'];
  $edit_dob = $_POST['edit_date_of_birth'];
  $edit_gender = $_POST['edit_gender'];
  $edit_blood_type = $_POST['edit_bloodType'];
  $edit_address = $_POST['edit_address'];

  //check all fields are filled
  if (!$patient_id) {
    echo json_encode(["status" => "error", "message" => "Patient ID is required."]);
    return;
  }
  if (!$edit_user_id) {
    echo json_encode(["status" => "error", "message" => "User ID is required."]);
    return;
  }
  if (!$edit_dob) {
    echo json_encode(["status" => "error", "message" => "Date of Birth is required."]);
    return;
  }
  if (!$edit_gender) {
    echo json_encode(["status" => "error", "message" => "Gender is required."]);
    return;
  }
  if (!$edit_blood_type) {
    echo json_encode(["status" => "error", "message" => "Blood Type is required."]);
    return;
  }
  if (!$edit_address) {
    echo json_encode(["status" => "error", "message" => "Address is required."]);
    return;
  }

  // insert data into database
  $query = "UPDATE Patients SET user_id = :user_id, date_of_birth = :dob, gender = :gender, blood_type = :blood_type, address = :address WHERE patient_id = :patient_id";

  $stm = $conn->prepare($query);
  $stm->bindParam(':user_id', $edit_user_id);
  $stm->bindParam(':dob', $edit_dob);
  $stm->bindParam(':gender', $edit_gender);
  $stm->bindParam(':blood_type', $edit_blood_type);
  $stm->bindParam(':address', $edit_address);
  $stm->bindParam(':patient_id', $patient_id);

  // Execute Query
  if ($stm->execute()) {
    echo json_encode(["status" => "success", "message" => "Updated successfully"]);
  } else {
    echo json_encode(["status" => "error", "message" => "Update failed"]);
  }
}

//delete 
function DeletePatient() {
  include '../Connection/connection.php';
  $db = new DatabaseConnection();
  $conn = $db->getConnection();

  // Collect data from POST request
  $patient_id = $_POST['id'];
  if(!$patient_id )
    {
        echo json_encode(["status"=>"error", 
         "message"=>' UserID are required']); 
         return;
    }

  // Prepare and execute the DELETE query
  $stmt = $conn->prepare("DELETE FROM Patients WHERE patient_id = :patient_id");
  $stmt->bindParam(':patient_id', $patient_id);

  if ($stmt->execute()) {
      echo json_encode(["status" => "success", "message" => "Patient deleted successfully!"]);
  } else {
      echo json_encode(["status" => "error", "message" => "Failed to delete Patient."]);
  }
}
?>