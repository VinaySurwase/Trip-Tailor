<?php
session_start();
$destinationId = $_GET['destinationId'];


include 'connection.php';
$userId = $_SESSION['UserID'];

// Query user preferences
$userPrefQuery = "SELECT Pref_ActivityType FROM User WHERE UserID = $userId";
$userPrefResult = $conn->query($userPrefQuery);
$userPref = $userPrefResult->fetch_assoc()['Pref_ActivityType'];

// Fetch attractions
$attractionQuery = "SELECT AttractionID, AttractionName, Description, EntryFee, ActivityType FROM Attraction WHERE DestinationID = $destinationId";
if (isset($_GET['sort'])) {
    if ($_GET['sort'] == "activity") {
        $attractionQuery .= " AND ActivityType = '$userPref'";
    } elseif ($_GET['sort'] == "price_asc") {
        $attractionQuery .= " ORDER BY EntryFee ASC";
    } elseif ($_GET['sort'] == "price_desc") {
        $attractionQuery .= " ORDER BY EntryFee DESC";
    }
}
$attractionResult = $conn->query($attractionQuery);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Attractions</title>
</head>

<body>
    <h1>Attractions</h1>
    <button onclick="window.location.href='attractionlist.php?destinationId=<?= $destinationId ?>&sort=activity'">Sort by Preferred Activity</button>
    <button onclick="window.location.href='attractionlist.php?destinationId=<?= $destinationId ?>&sort=price_asc'">Sort by Entry Fee (Asc)</button>
    <button onclick="window.location.href='attractionlist.php?destinationId=<?= $destinationId ?>&sort=price_desc'">Sort by Entry Fee (Desc)</button>
    <form action="finalizeitinerary.php" method="POST">
        <table border="1">
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Entry Fee</th>
                <th>Activity Type</th>
                <th>Select</th>
            </tr>
            <?php while ($row = $attractionResult->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['AttractionName'] ?></td>
                    <td><?= $row['Description'] ?></td>
                    <td><?= $row['EntryFee'] ?></td>
                    <td><?= $row['ActivityType'] ?></td>
                    <td><input type="checkbox" name="attractions[]" value="<?= $row['AttractionID'] ?>"></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <button type="submit">Save Selections</button>
    </form>
</body>

</html>