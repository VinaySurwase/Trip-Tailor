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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinations</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Styling */
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

        /* Sidebar Styling */
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

        .sidebar .user-tools {
            list-style: none;
            width: 100%;
            padding: 0;
        }

        .sidebar {
            /* margin: 20px 0; */
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

        /* Main Content Styling */
        .main-content {
            width: 75%;
            background-color: #ffffff;
            padding: 30px;
        }

        /* Header Styling */
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

        /* Button Styling */
        .select-btn {
            display:flex ;
            justify-self:center ;
            color: #0957D0;
            background-color: #EDF2FC;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.9rem;
            border: none ;
        }

        .select-btn:hover {
            /* background-color: darkred; */
            color: #21215E;
        }

        .btn-sort {
            display: flex ;
            justify-self: end ;
            color: #21215E;
            /* background-color: #21215E; */
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .btn-sort:hover {
            background-color: #EDF2FC;
            /* text-decoration: underline ; */
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
            <h2>Destinations</h2>
            <a href="../dashboard.php" >Back to Dashboard</a>
        </div>
        <div class="main-content">
            <h1>Available Destinations</h1>
            <a class="btn-sort" href="destinationlist.php?sort=1">Sort by Preferred Type</a>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $destinationResult->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['DestinationName'] ?></td>
                            <td><?= $row['DestinationLocation'] ?></td>
                            <td>
                                <form action="adddestination.php" method="POST">
                                    <input type="hidden" name="DestinationID" value="<?= $row['DestinationID'] ?>">
                                    <button class="select-btn" type="submit">Select</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>