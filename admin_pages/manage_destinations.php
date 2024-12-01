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
    <link rel="stylesheet" href="styles.css"> <!-- Link your CSS here -->
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Admin Dashboard</h2>
            <ul class="user-tools">
                <li><a href="#">Manage Users</a></li>
                <li><a href="#">Manage Reports</a></li>
                <li><a href="#">Manage Destinations</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Manage Destinations & Attractions</h1>
                <p>Use the forms below to add, edit, or delete destinations and attractions.</p>
            </header>

            <!-- Add Destination Form -->
            <h2>Add Destination</h2>
            <form method="POST" action="manage_destinations.php">
                <input type="text" name="destination_name" placeholder="Destination Name" required>
                <input type="text" name="destination_type" placeholder="Destination Type" required>
                <input type="text" name="destination_location" placeholder="Destination Location" required>
                <button type="submit" name="add_destination">Add Destination</button>
            </form>

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
