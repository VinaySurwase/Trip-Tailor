<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    // Prepare the SQL query
    $sql = "INSERT INTO `user`(`Name`, `Email`, `Password`, `Phone`, `age`, `gender`) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssis", $name, $email, $password, $phone, $dob, $gender);

        if ($stmt->execute()) {
            $_SESSION['UserID'] = $stmt->insert_id; // Store UserID in session
            // Redirect to destinationType.html
            header("Location: ../destinationType.html");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $conn->error;
    }

    $conn->close();
}
