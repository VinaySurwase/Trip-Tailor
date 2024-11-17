<?php

session_start();
include 'connection.php';
$userId = $_SESSION['UserID'];
$startDate = $_POST['StartDate'];
$endDate = $_POST['EndDate'];


if (isset($_SESSION['itineraryId'])) {
    $itineraryId = $_SESSION['itineraryId'];
    $updateQuery = "UPDATE Itinerary SET StartDate = '$startDate', EndDate = '$endDate' WHERE UserID = $userId AND ItineraryID = $itineraryId ";
    $conn->query($updateQuery);

    echo "Itinerary saved successfully!";
    header("Location: ../dashboard.php");
    exit();
    // Use $itineraryId for any operations
} else {
    die("Error: Itinerary ID not found.");
}
