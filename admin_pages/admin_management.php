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

// Handle Add Admin
if (isset($_POST['add_admin'])) {
    $name = $_POST['admin_name'];
    $password = $_POST['admin_password'];

    $sql = "INSERT INTO Admin (Name, Password) VALUES ('$name', '$password')";
    $conn->query($sql);
}

// Handle Delete Admin
if (isset($_GET['delete_admin'])) {
    $admin_id = intval($_GET['delete_admin']);
    $sql = "DELETE FROM Admin WHERE AdminID = $admin_id";
    $conn->query($sql);
}

// Handle Update Own Details
if (isset($_POST['update_details'])) {
    $admin_id = intval($_POST['admin_id']);
    $name = $_POST['admin_name'];
    $password = $_POST['admin_password'];

    $sql = "UPDATE Admin SET Name = '$name', Password = '$password' WHERE AdminID = $admin_id";
    $conn->query($sql);
}

// Fetch All Admin Accounts
$sql = "SELECT * FROM Admin";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Management</title>
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
                <li><a href="feedback_review.php">Review Feedback</a></li>
                <li><a href="#">Admin Management</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Admin Management</h1>
                <p>Manage admin accounts and update your details.</p>
            </header>

            <div class="add-form">
                <section>
                    <h2>Add New Admin</h2>
                    <form method="POST" action="admin_management.php">
                        <label for="admin_name">Name:</label>
                        <input type="text" id="admin_name" name="admin_name" required>
                        
                        <label for="admin_password">Password:</label>
                        <input type="password" id="admin_password" name="admin_password" required>
                        
                        <button type="submit" name="add_admin">Add Admin</button>
                    </form>
                </section>
            </div>

            <br></br>
            <div class="add-form">
                <section>
                    <h2>Update Your Details</h2>
                    <form method="POST" action="admin_management.php">
                        <input type="hidden" name="admin_id" value="<?= $_GET['current_admin_id'] ?? '' ?>"> <!-- Replace with logged-in Admin ID -->

                        <label for="update_name">Name:</label>
                        <input type="text" id="update_name" name="admin_name" required>
                        
                        <label for="update_password">New Password:</label>
                        <input type="password" id="update_password" name="admin_password" required>
                        
                        <button type="submit" name="update_details">Update</button>
                    </form>
                </section>
            </div>

            <br></br>
            <!-- Admin List -->
            <section>
                <h2>Admin Accounts</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $row['AdminID'] ?></td>
                                    <td><?= $row['Name'] ?></td>
                                    <td>
                                        <?php if ($row['AdminID'] != ($_GET['current_admin_id'] ?? 0)) { ?> 
                                            <!-- Prevent deletion of the logged-in admin -->
                                            <a class="btn-delete" href="?delete_admin=<?= $row['AdminID'] ?>">Delete</a>
                                        <?php } else { ?>
                                            <span>Cannot Delete</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                        <?php } } else { ?>
                            <tr>
                                <td colspan="3">No admins found.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
