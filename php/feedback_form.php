<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['UserID'])) {
    die("Access denied. Please log in.");
}

if (!isset($_GET['ItineraryID'])) {
    die("Itinerary not selected.");
}

$itineraryID = $_GET['ItineraryID'];

// Fetch itinerary details
$sqlItinerary = "
    SELECT i.ItineraryID, i.StartDate, i.EndDate, d.DestinationName, d.DestinationID 
    FROM itinerary i
    INNER JOIN destination d ON i.DestinationID = d.DestinationID
    WHERE i.ItineraryID = ?";
$stmt = $conn->prepare($sqlItinerary);
$stmt->bind_param("i", $itineraryID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Invalid itinerary ID.");
}
$itinerary = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Provide Feedback and Report</title>
  <link rel="stylesheet" href="../css/feedback_form.css">
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <h2>Trip Tailor</h2>
      <h3>User Tools</h3>
      <ul class="user-tools">
        <li><a href="destinationlist.php">Explore and Select Destinations</a></li>
        <li><a href="../Itinerary.php">Manage Your Itinerary</a></li>
        <li><a href="feedback_report.php">Report and Feedback</a></li>
        <li><a href="profile_management.php">Profile Management</a></li>
      </ul>
    </div>
    <main class="main-content">
      <header>
        <h1>Feedback and Report for <?php echo $itinerary['DestinationName']; ?></h1>
        <p><?php echo $itinerary['StartDate']; ?> to <?php echo $itinerary['EndDate']; ?></p>
      </header>
      <form method="POST" action="submit_feedback.php" class="form-feedback">
        <input type="hidden" name="ItineraryID" value="<?php echo $itineraryID; ?>">
        <input type="hidden" name="DestinationID" value="<?php echo $itinerary['DestinationID']; ?>">
        <label for="Feedback">Your Feedback:</label>
        <textarea name="Feedback" id="Feedback" required></textarea>
        <label for="Rating">Rate Your Experience (1-5):</label>
        <input type="number" name="Rating" id="Rating" min="1" max="5" required>
        <button type="submit">Submit Feedback</button>
      </form>
      
      <form method="POST" action="submit_report.php" class="form-feedback">
        <input type="hidden" name="ItineraryID" value="<?php echo $itineraryID; ?>">
        <label for="ReportDescription">Report Description:</label>
        <textarea name="ReportDescription" id="ReportDescription" required></textarea>
        <label for="TotalSpent">Total Spent:</label>
        <input type="number" name="TotalSpent" id="TotalSpent" min="0" required>
        <button type="submit">Submit Report</button>
      </form>
    </main>
  </div>
</body>
</html>
