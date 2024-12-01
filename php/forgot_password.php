<?php


include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the passwords match
    if ($new_password !== $confirm_password) {
        echo "Passwords do not match!";
    } else {
              

        // Update the password in the database
        $sql = "UPDATE user SET Password = ? WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $new_password, $email);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            // Password updated successfully, redirect to Login page
            header("Location: ../Login.html");
            exit(); // Ensure no further code is executed after redirection
        } else {
            echo "Error: Email not found or password could not be updated.";
        }

        $stmt->close();
    }
}
$conn->close();
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../css/forgetpassword.css" >
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form method="POST" action="forgot_password.php">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" placeholder="Enter new password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter new password" required>

            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
