<?php
session_start();
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session to store user data

include 'connection.php'; // Include your database connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and get input data
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check database connection
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Query to check if the email exists
    $query = "SELECT * FROM user WHERE Email = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare statement failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Debugging: Check if user data is fetched
    if (!$user) {
        echo "No user found with the provided email.";
    }

    // Check if user exists and the password is correct
    if ($user && $user_password === $user['Password']) {

        // Store user info in session
        $_SESSION['UserID'] = $user['UserID'];
        $_SESSION['user_name'] = $user['Name'];
        // Redirect to a dashboard or home page
        header("Location: ../dashboard.php");
        exit();
    } else {
        // Authentication failed
        $error_message = "Invalid email or password.";
        echo $error_message; // For debugging
    }

    $stmt->close();
}

$conn->close();
