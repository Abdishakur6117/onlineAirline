<?php
require_once('fpdf.php'); // If you use FPDF library for server-side PDF generation

// Capture POST data
$payment_id = $_POST['payment_id'];
$appointment_name = $_POST['appointment_name'];
$total_amount = $_POST['total_amount'];
$amount = $_POST['amount'];
$payment_method = $_POST['payment_method'];
$transaction_id = $_POST['transaction_id'];

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Payment Report');
$pdf->Ln();
$pdf->Cell(40, 10, "Payment ID: $payment_id");
$pdf->Ln();
$pdf->Cell(40, 10, "Appointment Name: $appointment_name");
$pdf->Ln();
$pdf->Cell(40, 10, "Total Amount: $total_amount");
$pdf->Ln();
$pdf->Cell(40, 10, "Amount Paid: $amount");
$pdf->Ln();
$pdf->Cell(40, 10, "Payment Method: $payment_method");
$pdf->Ln();
$pdf->Cell(40, 10, "Transaction ID: $transaction_id");

// Output PDF to browser
$pdf->Output();
?>
