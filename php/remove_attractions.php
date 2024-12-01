<?php
// Start session to verify user login
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}
include 'connection.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ItineraryID = intval($_POST['ItineraryID']);
    $AttractionID = intval($_POST['AttractionID']);

    // Remove the attraction from the itinerary
    $deleteQuery = "DELETE FROM ItineraryAttraction WHERE ItineraryID = ? AND AttractionID = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("ii", $ItineraryID, $AttractionID);

    if ($stmt->execute()) {
        echo "Attraction removed successfully.";
    } else {
        echo "Error removing attraction.";
    }

    $stmt->close();
    $conn->close();
    header("Location: ../itineray_details.php?ItineraryID=".$ItineraryID);
    exit();
}
?>
