<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['UserID'])) {
    die("Access denied. Please log in.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_SESSION['UserID'];
    $destinationID = $_POST['DestinationID'];
    $feedback = $_POST['Feedback'];
    $rating = $_POST['Rating'];

    // Validate that the selected destination belongs to the user
    $validateSql = "
        SELECT 1 
        FROM itinerary i 
        WHERE i.DestinationID = ? AND i.UserID = ?";
    $validateStmt = $conn->prepare($validateSql);
    $validateStmt->bind_param("ii", $destinationID, $userID);
    $validateStmt->execute();
    $validateResult = $validateStmt->get_result();

    if ($validateResult->num_rows > 0) {
        // Insert feedback into the database
        $insertSql = "
            INSERT INTO feedback (DestinationID, Description, Rating) 
            VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("isi", $destinationID, $feedback, $rating);
        if ($insertStmt->execute()) {
            echo "Feedback submitted successfully!";
            echo "<br><a href='feedback_report.php'>Go Back</a>";
        } else {
            echo "Error submitting feedback: " . $conn->error;
        }
    } else {
        echo "Invalid destination selection.";
    }
}
?>
