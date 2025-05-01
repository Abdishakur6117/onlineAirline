<?php
include 'pages/Connection/connection.php';
$db = new DatabaseConnection();
$conn = $db->getConnection();

// Get total number of beneficiaries
$totalBeneficiaries = $conn->query("SELECT COUNT(*) as count FROM beneficiaries")->fetch(PDO::FETCH_ASSOC)['count'];

// Get total number of feeding programs
$totalFeedingPrograms = $conn->query("SELECT COUNT(*) as count FROM feeding_programs")->fetch(PDO::FETCH_ASSOC)['count'];

// Get total number of meals
$totalMeals = $conn->query("SELECT COUNT(*) as count FROM meals")->fetch(PDO::FETCH_ASSOC)['count'];

// Get total number of staff
$totalStaff = $conn->query("SELECT COUNT(*) as count FROM staff")->fetch(PDO::FETCH_ASSOC)['count'];

// Get total number of feeding records
$totalFeedingRecords = $conn->query("SELECT COUNT(*) as count FROM feeding_records")->fetch(PDO::FETCH_ASSOC)['count'];

// Get total number of users (children, doctors, patients, etc.)
$totalUsers = $conn->query("SELECT COUNT(*) as count FROM users")->fetch(PDO::FETCH_ASSOC)['count'];

// Get total number of nutrition assessments
$totalNutritionAssessments = $conn->query("SELECT COUNT(*) as count FROM nutrition_assessments")->fetch(PDO::FETCH_ASSOC)['count'];

// Create the response array with the fetched data
$response = [
    "totalChildren" => $totalBeneficiaries,  // Assuming Beneficiaries = Children
    "totalFeedingPrograms" => $totalFeedingPrograms,
    "totalMeals" => $totalMeals,
    "totalStaff" => $totalStaff,
    "totalUsers" => $totalUsers,  // This can be the total of all user roles
    "totalFeedingRecords" => $totalFeedingRecords,
    "totalNutritionAssessments" => $totalNutritionAssessments
];

// Return the data as JSON
echo json_encode($response);
?>
