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
    <link rel="stylesheet" href="styles.css"> <!-- Link your CSS file -->
</head>
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

            <!-- Add Admin Form -->
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

            <!-- Update Own Details -->
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
