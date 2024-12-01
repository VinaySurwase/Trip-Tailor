<?php
// Database connection
$servername = "localhost:3307";
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
            align-items: center;
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
            text-align: center;
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

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
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

        .btn-delete {
            color: white;
            background-color: red;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .btn-delete:hover {
            background-color: darkred;
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

            .btn-delete {
                font-size: 0.8rem;
                padding: 6px 12px;
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
