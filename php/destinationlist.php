<?php

session_start();
include 'connection.php';
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}
// Assuming UserID is stored in session after login
$userId = $_SESSION['UserID'];

// Query user preferences
$userPrefQuery = "SELECT Pref_DestinationType FROM User WHERE UserID = $userId";
$userPrefResult = $conn->query($userPrefQuery);
$userPref = $userPrefResult->fetch_assoc()['Pref_DestinationType'];

// Fetch destinations
$destinationQuery = "SELECT DestinationID, DestinationName, DestinationLocation FROM Destination";
if (isset($_GET['sort'])) {
    $destinationQuery .= " WHERE DestinationType = '$userPref'";
}
$destinationResult = $conn->query($destinationQuery);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Destinations</title>
</head>

<body>
    <h1>Destinations</h1>
    <button onclick="window.location.href='destinationlist.php?sort=1'">Sort by Preferred Type</button>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Location</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $destinationResult->fetch_assoc()): ?>
            <tr>
                <td><?= $row['DestinationName'] ?></td>
                <td><?= $row['DestinationLocation'] ?></td>
                <td>
                    <form action="adddestination.php" method="POST">
                        <input type="hidden" name="DestinationID" value="<?= $row['DestinationID'] ?>">
                        <button type="submit">Select</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>