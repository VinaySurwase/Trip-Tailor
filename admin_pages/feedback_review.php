<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trip_tailor"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Delete Feedback Operation
if (isset($_GET['delete_feedback'])) {
    $feedback_id = intval($_GET['delete_feedback']);
    $sql = "DELETE FROM Feedback WHERE FeedbackID = $feedback_id";
    $conn->query($sql);
}

// Fetch Feedback Data
$sql = "SELECT f.FeedbackID, f.Description, f.Rating, d.DestinationName 
        FROM Feedback f 
        JOIN Destination d ON f.DestinationID = d.DestinationID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Review</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link your CSS file -->
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Admin Dashboard</h2>
            <ul class="user-tools">
                <li><a href="manage_destinations.php">Manage Destinations</a></li>
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="#">Review Feedback</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Review Feedback</h1>
                <p>View and manage user feedback on destinations.</p>
            </header>

            <!-- Feedback List -->
            <h2>Feedback</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Description</th>
                        <th>Rating</th>
                        <th>Destination</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $row['FeedbackID'] ?></td>
                                <td><?= $row['Description'] ?></td>
                                <td><?= $row['Rating'] ?>/5</td>
                                <td><?= $row['DestinationName'] ?></td>
                                <td>
                                    <a class="btn-delete" href="?delete_feedback=<?= $row['FeedbackID'] ?>">Delete</a>
                                </td>
                            </tr>
                    <?php } } else { ?>
                        <tr>
                            <td colspan="5">No feedback available.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
