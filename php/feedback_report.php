<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['UserID'])) {
    die("Access denied. Please log in.");
}

$userID = $_SESSION['UserID'];

// Fetch user's itineraries
$sqlItineraries = "
    SELECT ItineraryID, StartDate, EndDate, d.DestinationName 
    FROM itinerary i
    INNER JOIN destination d ON i.DestinationID = d.DestinationID
    WHERE i.UserID = ?";
$stmtItin = $conn->prepare($sqlItineraries);
$stmtItin->bind_param("i", $userID);
$stmtItin->execute();
$resultItineraries = $stmtItin->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Itineraries</title>
  <link rel="stylesheet" href="../css/report.css">
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <h2>Trip Tailor</h2>
      <h3>User Tools</h3>
      <ul class="user-tools">
        <li><a href="../dashboard.php">Dashboard</a></li>
        <li><a href="destinationlist.php">Explore and Select Destinations</a></li>
        <li><a href="../Itinerary.php">Manage your Itinerary</a></li>
        <li><a href="feedback_report.php">Report and Feedback</a></li>
        <li><a href="profile_management.php">Profile Management</a></li>
      </ul>
    </div>
    <main class="main-content">
      <header>
        <h1>Your Itineraries</h1>
        <p>Select a trip to provide feedback or share your experience.</p>
      </header>
      <div class="travel-plans">
        <?php while ($row = $resultItineraries->fetch_assoc()): ?>
        <div class="plan">
          <a href="feedback_form.php?ItineraryID=<?php echo $row['ItineraryID']; ?>">
            <h3><?php echo $row['DestinationName']; ?></h3>
            <p><?php echo $row['StartDate']; ?> to <?php echo $row['EndDate']; ?></p>
          </a>
        </div>
        <?php endwhile; ?>
      </div>
    </main>
  </div>
</body>
</html>
