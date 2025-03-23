<?php
require_once('fpdf.php'); // If you use FPDF library for server-side PDF generation

// Database connection
    include '../../Connection/connection.php';
$db = new DatabaseConnection();
$conn = $db->getConnection();

// Capture POST data from the AJAX request
$patient_id = $_POST['patient_id'];

// Fetch patient data from the database
$query = 'SELECT * FROM patients WHERE patient_id = :patient_id';
$stm = $conn->prepare($query);
$stm->execute(['patient_id' => $patient_id]);
$patientData = $stm->fetch(PDO::FETCH_ASSOC);

// Check if the data was retrieved successfully
if ($patientData) {
    // Create PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    
    // Add patient details to PDF
    $pdf->Cell(40, 10, 'Patient Report');
    $pdf->Ln();
    $pdf->Cell(40, 10, "Patient ID: " . $patientData['patient_id']);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Patient Name: " . $patientData['fullName']);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Date of Birth: " . $patientData['DOB']);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Gender: " . $patientData['gender']);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Blood Type: " . $patientData['bloodType']);
    $pdf->Ln();
    $pdf->Cell(40, 10, "Address: " . $patientData['address']);
    $pdf->Ln();

    // Output PDF to the browser
    $pdf->Output();
} else {
    // If no data is found for the given patient ID
    echo json_encode(["status" => "error", "message" => "Patient not found"]);
}
?>
