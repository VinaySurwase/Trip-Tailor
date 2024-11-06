<?php
session_start();
include 'connection.php'; // Assuming you have connection.php set up to connect to the database

if (isset($_GET['destination'])) {
    // Get the selected destination from the URL
    $selectedDestination = $_GET['destination'];
    
    // Store it in session for future use
    $_SESSION['Pref_DestinationType'] = $selectedDestination;

    // Optionally, store it in the database
    $userID = $_SESSION['UserID'];
    $stmt = $conn->prepare("UPDATE User SET Pref_DestinationType = ? WHERE UserID = ?");
    $stmt->bind_param("si", $selectedDestination, $userID);
    $stmt->execute();
    $stmt->close();

    // Redirect to attractiontype.html
    header("Location: ../ActivityType.html");
    exit();
} else {
    echo "No destination selected.";
}
?>
