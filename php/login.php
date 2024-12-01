<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include 'connection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_password = mysqli_real_escape_string($conn, $_POST['password']);

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

    if (!$user) {
        echo "No user found with the provided email.";
    }

    if ($user && $user_password === $user['Password']) {

        $_SESSION['UserID'] = $user['UserID'];
        $_SESSION['user_name'] = $user['Name'];
        header("Location: ../dashboard.php");
        exit();
    } else {
        $error_message = "Invalid email or password.";
        echo $error_message;
    }

    $stmt->close();
}

$conn->close();
