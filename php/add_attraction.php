<?php
// Start session to retrieve UserID or ensure the user is logged in
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location: ../Login.html");
    exit();
}
include 'connection.php';




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get ItineraryID and AttractionID
    $ItineraryID = intval($_GET['ItineraryID']);
    $AttractionID = intval($_POST['AttractionID']);

    // Validate inputs
    if (!$ItineraryID || !$AttractionID) {
        echo "Invalid input.";
        exit();
    }

    // Check if the attraction already exists in the itinerary
    $checkQuery = "SELECT COUNT(*) as count FROM ItineraryAttraction WHERE ItineraryID = ? AND AttractionID = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $ItineraryID, $AttractionID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if ($row['count'] > 0) {
        // Attraction already exists, redirect with an error message
        header("Location: ../itineray_details.php?ItineraryID=$ItineraryID&error=AttractionAlreadyExists");
        exit();
    }

    // Insert the attraction into the itinerary
    $insertQuery = "INSERT INTO ItineraryAttraction (ItineraryID, AttractionID) VALUES (?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ii", $ItineraryID, $AttractionID);

    if ($stmt->execute()) {
        // Redirect to itinerary_details.php
        header("Location: ../itineray_details.php?ItineraryID=$ItineraryID&success=AttractionAdded");
        exit();
    } else {
        echo "Error adding attraction: " . $stmt->error;
    }

    $stmt->close();
}




// Get ItineraryID from URL parameter
if (!isset($_GET['ItineraryID'])) {
    echo "Itinerary ID not provided.";
    exit();
}

$ItineraryID = intval($_GET['ItineraryID']);

// Fetch the DestinationID associated with the ItineraryID
$destinationQuery = "SELECT DestinationID FROM Itinerary WHERE ItineraryID = ?";
$stmt = $conn->prepare($destinationQuery);
$stmt->bind_param("i", $ItineraryID);
$stmt->execute();
$stmt->bind_result($DestinationID);
$stmt->fetch();
$stmt->close();

if (!$DestinationID) {
    echo "Invalid Itinerary ID.";
    exit();
}

// Fetch attractions associated with the DestinationID
$attractionsQuery = "SELECT AttractionID, AttractionName FROM Attraction WHERE DestinationID = ?";
$stmt = $conn->prepare($attractionsQuery);
$stmt->bind_param("i", $DestinationID);
$stmt->execute();
$result = $stmt->get_result();
$attractions = [];
while ($row = $result->fetch_assoc()) {
    $attractions[] = $row;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Attraction</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="container">
        <h1>Add New Attraction</h1>
        <form method="POST" action="add_attraction.php?ItineraryID=<?= htmlspecialchars($ItineraryID) ?>">
            <input type="hidden" name="ItineraryID" value="<?= htmlspecialchars($ItineraryID) ?>">
            <label for="AttractionID">Select Attraction:</label>
            <select name="AttractionID" id="AttractionID" required>
                <?php foreach ($attractions as $attraction): ?>
                    <option value="<?= $attraction['AttractionID'] ?>">
                        <?= htmlspecialchars($attraction['AttractionName']) ?>
                    </option>
                <?php endforeach; ?>
            </select> 
            <button type="submit">Add</button>
        </form>
        <button onclick="window.history.back();">Back</button>
    </div>
</body>

</html>
