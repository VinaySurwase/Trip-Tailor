<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['UserID'])) {
    die("Access denied. Please log in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_SESSION['UserID'];
    $itineraryID = $_POST['ItineraryID'];
    $description = $_POST['Description'];
    $totalSpent = $_POST['TotalSpent'];

    // Validate that the selected itinerary belongs to the user
    $validateSql = "
        SELECT 1 
        FROM itinerary 
        WHERE ItineraryID = ? AND UserID = ?";
    $validateStmt = $conn->prepare($validateSql);
    $validateStmt->bind_param("ii", $itineraryID, $userID);
    $validateStmt->execute();
    $validateResult = $validateStmt->get_result();

    if ($validateResult->num_rows > 0) {
        // Insert report into the database
        $insertSql = "
            INSERT INTO report (ItineraryID, Description, TotalSpent) 
            VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("isd", $itineraryID, $description, $totalSpent);
        if ($insertStmt->execute()) {
            echo "Report submitted successfully!";
        } else {
            echo "Error submitting report: " . $conn->error;
        }
    } else {
        echo "Invalid itinerary selection.";
    }
}
?>
