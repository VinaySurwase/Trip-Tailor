<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['UserID'])) {
    die("Access denied. Please log in.");
}

$userID = $_SESSION['UserID'];

// Fetch destinations the user has traveled to
$sqlDestinations = "
    SELECT DISTINCT d.DestinationID, d.DestinationName 
    FROM itinerary i
    INNER JOIN destination d ON i.DestinationID = d.DestinationID
    WHERE i.UserID = ?";
$stmtDest = $conn->prepare($sqlDestinations);
$stmtDest->bind_param("i", $userID);
$stmtDest->execute();
$resultDestinations = $stmtDest->get_result();

// Fetch user's itineraries
$sqlItineraries = "
    SELECT ItineraryID, StartDate, EndDate 
    FROM itinerary 
    WHERE UserID = ?";
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
    <title>Feedback and Reports</title>
</head>
<body>
    <h1>Submit Feedback</h1>
    <form method="POST" action="submit_feedback.php">
        <label for="DestinationID">Select a destination:</label>
        <select name="DestinationID" id="DestinationID" required>
            <?php while ($row = $resultDestinations->fetch_assoc()): ?>
                <option value="<?php echo $row['DestinationID']; ?>">
                    <?php echo $row['DestinationName']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <br>
        <label for="Feedback">Feedback:</label>
        <textarea name="Feedback" id="Feedback" required></textarea>
        <br>
        <label for="Rating">Rating:</label>
        <input type="number" name="Rating" id="Rating" min="1" max="5" required>
        <br>
        <button type="submit">Submit Feedback</button>
    </form>

    <h1>Submit Report</h1>
    <form method="POST" action="submit_report.php">
        <label for="ItineraryID">Select an itinerary:</label>
        <select name="ItineraryID" id="ItineraryID" required>
            <?php while ($row = $resultItineraries->fetch_assoc()): ?>
                <option value="<?php echo $row['ItineraryID']; ?>">
                    <?php echo "Itinerary " . $row['ItineraryID'] . " (From: " . $row['StartDate'] . " To: " . $row['EndDate'] . ")"; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <br>
        <label for="Description">Report Description:</label>
        <textarea name="Description" id="Description" required></textarea>
        <br>
        <label for="TotalSpent">Total Spent:</label>
        <input type="number" name="TotalSpent" id="TotalSpent" step="0.01" required>
        <br>
        <button type="submit">Submit Report</button>
    </form>
</body>
</html>
