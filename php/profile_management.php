<?php
session_start();
include 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['UserID'];

// Fetch user details from the database
$sql = "SELECT Name, Email, Phone, Age, Gender FROM user WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found!";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile Management</title>
    <link rel="stylesheet" type="text/css" href="../css/profilemanagement.css">
</head>
<body>
    <div class="profile-container">
        <h2>Your Profile</h2>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['Name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['Email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['Phone']); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($user['Age']); ?></p>
        <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['Gender']); ?></p>

        <a href="edit_profile.php">Edit Profile</a>
        <a href="../dashboard.php" class="back-button">Back</a>
    </div>
</body>
</html>
