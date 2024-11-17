<?php
session_start();
include 'connection.php';
$userId = $_SESSION['UserID'];
$destinationId = $_POST['DestinationID'];

// Insert into Itinerary table
$insertQuery = "INSERT INTO Itinerary (UserID, DestinationID) VALUES ($userId, $destinationId)";
$conn->query($insertQuery);
$itineraryId = $conn->insert_id;

if ($itineraryId) {
    $_SESSION['itineraryId'] = $itineraryId; // Store in session
    header("Location: attractionlist.php?destinationId=$destinationId"); // Redirect to the next page
    exit();
} else {
    die("Error: Unable to insert into Itinerary.");
}


// // Redirect to attractions
// header("Location: attractionlist.php?destinationId=$destinationId");
?>