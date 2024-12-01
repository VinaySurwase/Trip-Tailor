<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}
include 'php/connection.php';

if (!isset($_GET['ItineraryID'])) {
    echo "Itinerary ID not provided.";
    exit();
}

$ItineraryID = intval($_GET['ItineraryID']);


$sql = "
    SELECT 
        d.DestinationName,
        i.StartDate,
        i.EndDate,
        a.AttractionName,
        a.Description,
        a.AttractionID
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

if (!empty($itineraryDetails)) {
    $destinationName = $itineraryDetails[0]['DestinationName'];
    $startDate = date("d-m-Y", strtotime($itineraryDetails[0]['StartDate']));
    $endDate = date("d-m-Y", strtotime($itineraryDetails[0]['EndDate']));
    $attractionIDs = array_column($itineraryDetails, 'AttractionID');
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
    <style>
        .remove-btn {
            background: none;
            color: #0957D0 ;
            border: none ;
            text-decoration: none ;
        }

        .remove-btn:hover {
            color: red ;
        }
    </style>
</head>

<body>
    <div class="container">
        <button class="back-btn" onclick="window.history.back();">BACK</button>
        <h1 class="title"><?= htmlspecialchars($destinationName) ?></h1>
        <p class="date-range"><?= htmlspecialchars($startDate) ?> to <?= htmlspecialchars($endDate) ?></p>
        <button class="add-new-btn" onclick="window.location.href='php/add_attraction.php?ItineraryID=<?= htmlspecialchars($ItineraryID) ?>'">Add New</button>


        <div class="card-list">
            <?php foreach ($itineraryDetails as $attraction): ?>
                <div class="card">
                    <h2><?= htmlspecialchars($attraction['AttractionName']) ?></h2>
                    <p><?= htmlspecialchars($attraction['Description']) ?></p>
                    <form method="POST" action="php/remove_attractions.php">
                        <input type="hidden" name="ItineraryID" value="<?= htmlspecialchars($ItineraryID) ?>">
                        <input type="hidden" name="AttractionID" value="<?= htmlspecialchars($attraction['AttractionID']) ?>">
                        <button type="submit" class="remove-btn">Remove</button>
                    </form>
                </div>
            <?php endforeach; ?>

        </div>

        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] === 'AttractionAlreadyExists') {
                echo "<p style='color: red;'>This attraction is already in your itinerary.</p>";
            }
        }

        if (isset($_GET['success'])) {
            if ($_GET['success'] === 'AttractionAdded') {
                echo "<p style='color: green;'>Attraction added successfully!</p>";
            }
        }
        ?>


    </div>
</body>

</html>