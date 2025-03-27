<?php
// report.php
if (isset($_GET['fullName']) && isset($_GET['specialist']) && isset($_GET['availability']) && isset($_GET['consultation_fee'])) {
    $fullName = $_GET['fullName'];
    $specialist = $_GET['specialist'];
    $availability = $_GET['availability'];
    $consultation_fee = $_GET['consultation_fee'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Report - <?php echo htmlspecialchars($fullName); ?></title>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --accent-color: #e74c3c;
            --light-gray: #f8f9fa;
            --dark-gray: #343a40;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px;
            background-color: #f5f5f5;
        }
        
        .report-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        .report-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--primary-color);
        }
        
        .report-header h2 {
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 28px;
        }
        
        .report-date {
            color: #777;
            font-style: italic;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 15px;
            box-shadow: 0 2px 3px rgba(0,0,0,0.1);
        }
        
        table thead tr {
            background-color: var(--primary-color);
            color: white;
            text-align: left;
        }
        
        table th,
        table td {
            padding: 15px;
            border: 1px solid #ddd;
        }
        
        table tbody tr {
            border-bottom: 1px solid #ddd;
        }
        
        table tbody tr:nth-of-type(even) {
            background-color: var(--light-gray);
        }
        
        table tbody tr:last-of-type {
            border-bottom: 2px solid var(--primary-color);
        }
        
        table tbody tr:hover {
            background-color: #e9f7fe;
        }
        
        .highlight {
            font-weight: bold;
            color: var(--accent-color);
        }
        
        .print-btn {
            display: block;
            width: 150px;
            margin: 30px auto 0;
            padding: 12px 20px;
            font-size: 16px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }
        
        .print-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        @media print {
            body {
                background-color: white;
                padding: 0;
                font-size: 12pt;
            }
            
            .report-container {
                box-shadow: none;
                padding: 0;
            }
            
            .print-btn {
                display: none;
            }
            
            table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <div class="report-header">
            <h2>Doctor Professional Report</h2>
            <div class="report-date">Generated on: <?php echo date('F j, Y'); ?></div>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Specialization</th>
                    <th>Availability</th>
                    <th>Consultation Fee</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong><?php echo htmlspecialchars($fullName); ?></strong></td>
                    <td><?php echo htmlspecialchars($specialist); ?></td>
                    <td><?php echo htmlspecialchars($availability); ?></td>
                    <td class="highlight">$<?php echo number_format(htmlspecialchars($consultation_fee), 2); ?></td>
                </tr>
            </tbody>
        </table>
        
        <button class="print-btn" onclick="window.print()">
            <i class="fas fa-print"></i> Print Report
        </button>
    </div>

    <!-- Optional: Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>