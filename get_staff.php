<?php
include 'pages/Connection/connection.php';
$db = new DatabaseConnection();
$conn = $db->getConnection();

session_start();

// Make sure the user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(["error" => "User not authenticated"]);
    exit;
}

$user_id = $_SESSION['id']; // Get the user ID from the session

// Get total number of beneficiaries (created by the logged-in user)
$totalBeneficiaries = $conn->prepare("SELECT COUNT(*) as count FROM beneficiaries WHERE created_by = ?");
$totalBeneficiaries->execute([$user_id]);
$totalBeneficiaries = $totalBeneficiaries->fetch(PDO::FETCH_ASSOC)['count'];
// Get total number of feeding records (created by the logged-in user)
$totalFeedingRecords = $conn->prepare("SELECT COUNT(*) as count FROM feeding_records WHERE recorded_by = ?");
$totalFeedingRecords->execute([$user_id]);
$totalFeedingRecords = $totalFeedingRecords->fetch(PDO::FETCH_ASSOC)['count'];

// Get total number of nutrition assessments (created by the logged-in user)
$totalNutritionAssessments = $conn->prepare("SELECT COUNT(*) as count FROM nutrition_assessments WHERE created_by = ?");
$totalNutritionAssessments->execute([$user_id]);
$totalNutritionAssessments = $totalNutritionAssessments->fetch(PDO::FETCH_ASSOC)['count'];

// Create the response array with the fetched data
$response = [
    "totalChildren" => $totalBeneficiaries,
    "totalFeedingRecords" => $totalFeedingRecords,
    "totalNutritionAssessments" => $totalNutritionAssessments
];

// Return the data as JSON
echo json_encode($response);
?>
