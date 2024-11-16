<?php
session_start();
include 'connection.php'; 

if (isset($_GET['activity'])) {
    // Get the selected activity from the URL
    $selectedActivity = $_GET['activity'];
    
    // Store it in session for future use
    $_SESSION['Pref_ActivityType'] = $selectedActivity;

    // Optionally, store it in the database
    $userID = $_SESSION['UserID'];
    $stmt = $conn->prepare("UPDATE User SET Pref_ActivityType = ? WHERE UserID = ?");
    $stmt->bind_param("si", $selectedActivity, $userID);
    $stmt->execute();
    $stmt->close();

    // Redirect to the dashboard 
    header("Location: ../dashboard.php");
    exit();
} else {
    echo "No activity selected.";
}
?>
