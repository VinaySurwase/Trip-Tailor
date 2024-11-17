<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['UserID'])) {
    die("Access denied. Please log in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itineraryID = $_POST['ItineraryID'];
    $reportDescription = $_POST['ReportDescription'];
    $totalSpent = $_POST['TotalSpent'];

    if (empty($reportDescription) || empty($totalSpent)) {
        die("All fields are required.");
    }

    // Insert report into the database
    $sqlInsertReport = "
        INSERT INTO report (ItineraryID, Description, TotalSpent) 
        VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sqlInsertReport);
    $stmt->bind_param("isd", $itineraryID, $reportDescription, $totalSpent);

    if ($stmt->execute()) {
        echo "Report submitted successfully.";
        echo "<br><a href='feedback_report.php'>Go Back</a>";
    } else {
        echo "Error submitting report: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    die("Invalid request method.");
}
?>
