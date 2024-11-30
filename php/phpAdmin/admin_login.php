<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include your database connection file
include '../connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and get input data
    $adminid = mysqli_real_escape_string($conn, $_POST['adminid']);
    $user_password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check database connection
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Query to check if the admin exists
    $query = "SELECT * FROM admin WHERE AdminID = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare statement failed: " . $conn->error);
    }

    $stmt->bind_param("s", $adminid);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Check if admin exists and the password is correct
    if ($admin && $user_password === $admin['Password']) {
        // Store admin info in session
        $_SESSION['AdminID'] = $admin['AdminID'];
        $_SESSION['admin_name'] = $admin['Name'];

        // Redirect to a dashboard or home page
        header("Location: ../../admin_pages/admin_dashboard.html");
        exit();
    } else {
        // Authentication failed
        $error_message = "Invalid Admin ID or Password.";
        $_SESSION['error_message'] = $error_message;

        // Redirect back to login page with error
        header("Location: admin_login.php");
        exit();
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
