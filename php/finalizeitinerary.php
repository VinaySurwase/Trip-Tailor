<?php

session_start();
include 'connection.php';
$userId = $_SESSION['UserID'];
$attractions = $_POST['attractions'];


if (isset($_SESSION['itineraryId'])) {
    $itineraryId = $_SESSION['itineraryId'];
    foreach ($attractions as $attractionId) {
        $insertQuery = "INSERT INTO ItineraryAttraction (ItineraryID, AttractionID) VALUES ($itineraryId, $attractionId)";
        $conn->query($insertQuery);
    }
    

} else {
    die("Error: Itinerary ID not found.");
}


header("Location: ../journeydate.html");
?>
