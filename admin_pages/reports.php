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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #e7f2f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: max-content;
            margin: 0;
            padding-top: 3%;
            padding-bottom: 3%;
        }

        /* Main Container */
        .container {
            display: flex;
            background-color: white;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            width: 94%;
            height: auto;
            min-height: 90vh;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 25%;
            background-color: #21215E;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 20px 0 0 20px;
        }

        .sidebar h2 {
            margin-bottom: 40px;
            font-size: 2.5vw;
            padding-top: 20%;
            text-align: center;
        }

        .user-tools {
            list-style: none;
            padding: 0;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items:center
        }

        .user-tools li {
            margin: 20px 0;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .user-tools li a {
            background-color: transparent;
            border: 1px solid white;
            color: white;
            padding: 10px 30px;
            border-radius: 15px;
            cursor: pointer;
            font-weight: lighter;
            text-decoration: none;
            font-size: 1.15vw;
            text-align: center ;
            width: 80%;
            display: block;
        }

        .user-tools li a:hover {
            background-color: white;
            color: #2e2c72;
            text-decoration: none;
        }
        /* Main Content */
        .main-content {
            width: 75%;
            background-color: #ffffff;
            padding: 30px;
        }

        /* Header */
        header {
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 10px;
        }

        header p {
            font-size: 1rem;
            color: #555;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #21215E;
            color: white;
            font-weight: normal;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:hover td {
            background-color: #e5f4f5;
        }

        /* Sections */
        section {
            margin-bottom: 40px;
        }

        section h2 {
            font-size: 1.5rem;
            color: #21215E;
            margin-bottom: 15px;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-radius: 20px 20px 0 0;
            }

            .main-content {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            header h1 {
                font-size: 1.5rem;
            }

            table {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Trip-Tailor</h2>
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
