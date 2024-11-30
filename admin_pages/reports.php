<?php
// Start session to verify admin login
session_start();

// Replace with actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trip_tailor"; // Replace with your DB name

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total users registered
$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM User";
$totalUsersResult = $conn->query($totalUsersQuery);
$totalUsers = $totalUsersResult->fetch_assoc()['total_users'];

// Fetch most popular destinations
$popularDestinationsQuery = "
    SELECT Destination.DestinationName, COUNT(Itinerary.DestinationID) AS visit_count
    FROM Itinerary
    JOIN Destination ON Itinerary.DestinationID = Destination.DestinationID
    GROUP BY Itinerary.DestinationID
    ORDER BY visit_count DESC
    LIMIT 5";
$popularDestinationsResult = $conn->query($popularDestinationsQuery);

// Fetch most popular attractions
$popularAttractionsQuery = "
    SELECT Attraction.AttractionName, COUNT(ItineraryAttraction.AttractionID) AS visit_count
    FROM ItineraryAttraction
    JOIN Attraction ON ItineraryAttraction.AttractionID = Attraction.AttractionID
    GROUP BY ItineraryAttraction.AttractionID
    ORDER BY visit_count DESC
    LIMIT 5";
$popularAttractionsResult = $conn->query($popularAttractionsQuery);

// Fetch average ratings for destinations
$destinationRatingsQuery = "
    SELECT Destination.DestinationName, AVG(Feedback.Rating) AS average_rating
    FROM Feedback
    JOIN Destination ON Feedback.DestinationID = Destination.DestinationID
    GROUP BY Feedback.DestinationID
    ORDER BY average_rating DESC";
$destinationRatingsResult = $conn->query($destinationRatingsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reports</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Admin Dashboard</h2>
            <ul class="user-tools">
                <li><a href="admin_management.php">Manage Admins</a></li>
                <li><a href="#">Reports</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Reports</h1>
                <p>View summarized data and insights.</p>
            </header>

            <!-- Total Users -->
            <section>
                <h2>Total Users Registered</h2>
                <p><strong><?php echo $totalUsers; ?></strong> users have registered on the platform.</p>
            </section>

            <!-- Most Popular Destinations -->
            <section>
                <h2>Most Popular Destinations</h2>
                <table>
                    <tr>
                        <th>Destination Name</th>
                        <th>Number of Visits</th>
                    </tr>
                    <?php while ($row = $popularDestinationsResult->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['DestinationName']); ?></td>
                            <td><?php echo $row['visit_count']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </section>

            <!-- Most Popular Attractions -->
            <section>
                <h2>Most Popular Attractions</h2>
                <table>
                    <tr>
                        <th>Attraction Name</th>
                        <th>Number of Visits</th>
                    </tr>
                    <?php while ($row = $popularAttractionsResult->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['AttractionName']); ?></td>
                            <td><?php echo $row['visit_count']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </section>

            <!-- Average Ratings for Destinations -->
            <section>
                <h2>Average Ratings for Destinations</h2>
                <table>
                    <tr>
                        <th>Destination Name</th>
                        <th>Average Rating</th>
                    </tr>
                    <?php while ($row = $destinationRatingsResult->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['DestinationName']); ?></td>
                            <td><?php echo round($row['average_rating'], 2); ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </section>
        </div>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
