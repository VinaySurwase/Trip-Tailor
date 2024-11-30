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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attractions</title>
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

        .sidebar a {
            background-color: transparent;
            border: 1px solid white;
            color: white;
            padding: 10px 30px;
            border-radius: 15px;
            cursor: pointer;
            font-weight: lighter;
            text-decoration: none;
            font-size: 1.15vw;
            width: 80%;
            display: inline-block;
        }

        .sidebar a:hover {
            background-color: white;
            color: #21215E;
        }

        .main-content {
            width: 75%;
            background-color: #ffffff;
            padding: 30px;
        }

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

        .btn-sort {
            display: inline-block;
            color: #21215E;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .btn-sort:hover {
            background-color: #EDF2FC;
        }

        .save-btn {
            color: #0957D0;
            background-color: #EDF2FC;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1rem;
            border: none;
        }

        .save-btn:hover {
            color: #21215E;
        }

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

            .btn-sort {
                font-size: 0.8rem;
                padding: 6px 12px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <h2>Attractions</h2>
            <a href="destinationlist.php">Back to Destinations</a>
        </div>
        <div class="main-content">
            <header>
                <h1>Available Attractions</h1>
            </header>
            <a class="btn-sort" href="attractionlist.php?destinationId=<?= $destinationId ?>&sort=activity">Sort by Preferred Activity</a>
            <a class="btn-sort" href="attractionlist.php?destinationId=<?= $destinationId ?>&sort=price_asc">Sort by Entry Fee (Asc)</a>
            <a class="btn-sort" href="attractionlist.php?destinationId=<?= $destinationId ?>&sort=price_desc">Sort by Entry Fee (Desc)</a>
            <form action="finalizeitinerary.php" method="POST">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Entry Fee</th>
                            <th>Activity Type</th>
                            <th>Select</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $attractionResult->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['AttractionName'] ?></td>
                                <td><?= $row['Description'] ?></td>
                                <td><?= $row['EntryFee'] ?></td>
                                <td><?= $row['ActivityType'] ?></td>
                                <td><input type="checkbox" name="attractions[]" value="<?= $row['AttractionID'] ?>"></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <button class="save-btn" type="submit">Save Selections</button>
            </form>
        </div>
    </div>
</body>

</html>