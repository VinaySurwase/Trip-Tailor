<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trip_tailor"; // Replace with your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Add Operation
if (isset($_POST['add_destination'])) {
    $name = $_POST['destination_name'];
    $type = $_POST['destination_type'];
    $location = $_POST['destination_location'];

    $sql = "INSERT INTO Destination (DestinationName, DestinationType, DestinationLocation) 
            VALUES ('$name', '$type', '$location')";
    $conn->query($sql);
}

if (isset($_POST['add_attraction'])) {
    $name = $_POST['attraction_name'];
    $type = $_POST['attraction_type'];
    $entry_fee = $_POST['entry_fee'];
    $description = $_POST['description'];
    $destination_id = $_POST['destination_id'];

    $sql = "INSERT INTO Attraction (AttractionName, AttractionType, EntryFee, Description, DestinationID) 
            VALUES ('$name', '$type', '$entry_fee', '$description', '$destination_id')";
    $conn->query($sql);
}

// Handle Delete Operation
if (isset($_GET['delete_destination'])) {
    $id = $_GET['delete_destination'];
    $sql = "DELETE FROM Destination WHERE DestinationID = $id";
    $conn->query($sql);
}

if (isset($_GET['delete_attraction'])) {
    $id = $_GET['delete_attraction'];
    $sql = "DELETE FROM Attraction WHERE AttractionID = $id";
    $conn->query($sql);
}

// Fetch Data
$destinations = $conn->query("SELECT * FROM Destination");
$attractions = $conn->query("SELECT * FROM Attraction");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Destinations & Attractions</title>
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

        button {
            background-color: #21215E;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2e2c72;
        }

        input, textarea, select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        .add-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
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
    </style></head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Admin Dashboard</h2>
            <ul class="user-tools">
                <li><a href="manage_users.php">Manage Users</a></li>
                <li><a href="reports.php">Manage Reports</a></li>
                <li><a href="#">Manage Destinations</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Manage Destinations & Attractions</h1>
                <p>Use the forms below to add, edit, or delete destinations and attractions.</p>
            </header>

            <div class="add-form">
                <!-- Add Destination Form -->
                <h2>Add Destination</h2>
                <form method="POST" action="manage_destinations.php">
                    <input type="text" name="destination_name" placeholder="Destination Name" required>
                    <input type="text" name="destination_type" placeholder="Destination Type" required>
                    <input type="text" name="destination_location" placeholder="Destination Location" required>
                    <button type="submit" name="add_destination">Add Destination</button>
                </form>
            </div>

            <br></br>
            <div class="add-form">
                <!-- Add Attraction Form -->
                <h2>Add Attraction</h2>
                <form method="POST" action="manage_destinations.php">
                    <input type="text" name="attraction_name" placeholder="Attraction Name" required>
                    <input type="text" name="attraction_type" placeholder="Attraction Type" required>
                    <input type="number" name="entry_fee" placeholder="Entry Fee" required>
                    <textarea name="description" placeholder="Description" required></textarea>
                    <select name="destination_id" required>
                        <option value="">Select Destination</option>
                        <?php while ($row = $destinations->fetch_assoc()) { ?>
                            <option value="<?= $row['DestinationID'] ?>"><?= $row['DestinationName'] ?></option>
                        <?php } ?>
                    </select>
                    <button type="submit" name="add_attraction">Add Attraction</button>
                </form>
            </div>
            <br></br>
            <!-- List Destinations -->
            <h2>Destinations</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $destinations->data_seek(0); // Reset result pointer
                    while ($row = $destinations->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['DestinationID'] ?></td>
                            <td><?= $row['DestinationName'] ?></td>
                            <td><?= $row['DestinationType'] ?></td>
                            <td><?= $row['DestinationLocation'] ?></td>
                            <td>
                                <a class="btn-delete" href="?delete_destination=<?= $row['DestinationID'] ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- List Attractions -->
            <br></br>
            <h2>Attractions</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Entry Fee</th>
                        <th>Description</th>
                        <th>Destination</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $attractions->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['AttractionID'] ?></td>
                            <td><?= $row['AttractionName'] ?></td>
                            <td><?= $row['AttractionType'] ?></td>
                            <td><?= $row['EntryFee'] ?></td>
                            <td><?= $row['Description'] ?></td>
                            <td><?= $row['DestinationID'] ?></td>
                            <td>
                                <a class="btn-delete" href="?delete_attraction=<?= $row['AttractionID'] ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
