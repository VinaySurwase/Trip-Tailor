<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your DB username
$password = ""; // Replace with your DB password
$dbname = "trip_tailor"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete user if requested
if (isset($_GET['delete'])) {
    $UserID = intval($_GET['delete']); // Get user ID from query string
    $deleteQuery = "DELETE FROM User WHERE UserID = $UserID";
    if ($conn->query($deleteQuery) === TRUE) {
        $message = "User deleted successfully.";
    } else {
        $message = "Error deleting user: " . $conn->error;
    }
}
// Fetch all users
$query = "SELECT UserID, Name, Email, Pref_DestinationType, Pref_ActivityType FROM User";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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

        .sidebar .user-tools li {
            margin: 20px 0;
            text-align: center;
        }

        .sidebar .user-tools li a {
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

        .sidebar .user-tools li a:hover {
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
            color: white;
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
    <h1>Manage Users</h1>
    <?php
    // Show delete message
    if (isset($message)) {
        echo "<p style='color: green; font-weight: bold;'>$message</p>";
    }
    ?>
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Preferred Destination</th>
                <th>Preferred Activity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['UserID'] . "</td>";
                    echo "<td>" . $row['Name'] . "</td>";
                    echo "<td>" . $row['Email'] . "</td>";
                    echo "<td>" . $row['Pref_DestinationType'] . "</td>";
                    echo "<td>" . $row['Pref_ActivityType'] . "</td>";
                    echo "<td><a class='btn-delete' href='manage_users.php?delete=" . $row['UserID'] . "'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>

<?php
$conn->close();
?>