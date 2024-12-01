<?php
session_start();
include 'connection.php';

if (isset($_GET['destination'])) {
    $selectedDestination = $_GET['destination'];

    $_SESSION['Pref_DestinationType'] = $selectedDestination;

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
