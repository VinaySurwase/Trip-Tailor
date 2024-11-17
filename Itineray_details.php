<?php
// Start session to retrieve UserID or ensure the user is logged in
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}
include 'php/connection.php';

// Get ItineraryID from URL parameter
if (!isset($_GET['ItineraryID'])) {
    echo "Itinerary ID not provided.";
    exit();
}

$ItineraryID = intval($_GET['ItineraryID']);

// Query to fetch itinerary details and associated attractions
$sql = "
    SELECT 
        d.DestinationName,
        i.StartDate,
        i.EndDate,
        a.AttractionName,
        a.Description
    FROM 
        Itinerary i
    JOIN 
        Destination d ON i.DestinationID = d.DestinationID
    JOIN 
        ItineraryAttraction ia ON i.ItineraryID = ia.ItineraryID
    JOIN 
        Attraction a ON ia.AttractionID = a.AttractionID
    WHERE 
        i.ItineraryID = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ItineraryID);
$stmt->execute();
$result = $stmt->get_result();

$itineraryDetails = [];
while ($row = $result->fetch_assoc()) {
    $itineraryDetails[] = $row;
}

$stmt->close();
$conn->close();

// Extract common itinerary data (DestinationName, StartDate, EndDate)
if (!empty($itineraryDetails)) {
    $destinationName = $itineraryDetails[0]['DestinationName'];
    $startDate = date("d-m-Y", strtotime($itineraryDetails[0]['StartDate']));
    $endDate = date("d-m-Y", strtotime($itineraryDetails[0]['EndDate']));
} else {
    echo "No attractions found for the selected itinerary.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip-tailor</title>
    <link rel="stylesheet" href="css/itinerary_details.css">
</head>
<body>
    <div class="container">
        <button class="back-btn" onclick="window.history.back();">BACK</button>
        <h1 class="title"><?= htmlspecialchars($destinationName) ?></h1>
        <p class="date-range"><?= htmlspecialchars($startDate) ?> to <?= htmlspecialchars($endDate) ?></p>
        <button class="add-new-btn">Add New</button>
        <div class="card-list">
            <?php foreach ($itineraryDetails as $attraction): ?>
                <div class="card">
                    <h2><?= htmlspecialchars($attraction['AttractionName']) ?></h2>
                    <p><?= htmlspecialchars($attraction['Description']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
