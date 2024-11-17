<?php
// Start session to retrieve UserID (ensure user is logged in)
session_start();
if (!isset($_SESSION['UserID'])) {
  header("Location: login.php");
  exit();
}

$UserID = $_SESSION['UserID']; // Assuming UserID is stored in session after login

include 'php/connection.php';

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch itineraries with expected cost
$sql = "
    SELECT 
        i.ItineraryID,
        d.DestinationName,
        i.StartDate,
        i.EndDate,
        COALESCE(SUM(a.EntryFee), 0) AS ExpectedCost
    FROM 
        Itinerary i
    JOIN 
        Destination d ON i.DestinationID = d.DestinationID
    LEFT JOIN 
        ItineraryAttraction ia ON i.ItineraryID = ia.ItineraryID
    LEFT JOIN 
        Attraction a ON ia.AttractionID = a.AttractionID
    WHERE 
        i.UserID = ?
    GROUP BY 
        i.ItineraryID, d.DestinationName, i.StartDate, i.EndDate
    ORDER BY 
        i.StartDate ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $UserID);
$stmt->execute();
$result = $stmt->get_result();

$itineraries = [];
while ($row = $result->fetch_assoc()) {
  $itineraries[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel Plans</title>
  <link rel="stylesheet" href="css/itinerary.css">
</head>

<body>
  <div class="container">
    <div class="sidebar">
      <h2>Trip Tailor</h2>
      <h3>User Tools</h3>
      <ul class="user-tools">
        <li><a href="php/destinationlist.php">Explore and Select destinations</a></li>
        <li><a href="Itinerary.html">Manage your Itinerary</a></li>
        <li><a href="#">Report and Feedback</a></li>
        <li><a href="#">Profile Management</a></li>
      </ul>
    </div>
    <main class="main-content">
      <header>
        <h1>Your Travel Plans</h1>
        <button class="new-journey"><a href="php/destinationlist.php">New Journey</a></button>
      </header>
      <div class="travel-plans">
        <?php if (empty($itineraries)): ?>
          <p>No itineraries found. Start planning your journey!</p>
        <?php else: ?>
          <?php foreach ($itineraries as $plan): ?>
            <div class="plan">
              <a href="#">
                <h3><?= htmlspecialchars($plan['DestinationName']) ?></h3>
                <p><?= htmlspecialchars(date("d-m-Y", strtotime($plan['StartDate']))) ?> to <?= htmlspecialchars(date("d-m-Y", strtotime($plan['EndDate']))) ?></p>
                <p>Expected: Rs <?= htmlspecialchars(number_format($plan['ExpectedCost'])) ?></p>
              </a>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </main>
  </div>
</body>

</html>