<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['UserID'];

$sql = "SELECT Name, Email, Phone FROM user WHERE UserID = ?";
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $Phone = $_POST['Phone'];

    // Update the user's details
    $updateSql = "UPDATE user SET Name = ?, Email = ?, Phone = ? WHERE UserID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("sssi", $Name, $Email, $Phone, $userID);

    if ($updateStmt->execute()) {
        echo "Profile updated successfully!";
        header("Location: profile_management.php");
        exit();
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="../css/edit_profile.css">
    <style>
        body {
            background-color: #e7f2f4;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Your Profile</h2>
        <form method="POST" action="">
            <label for="Name">Username:</label>
            <input type="text" name="Name" id="Name" value="<?php echo htmlspecialchars($user['Name']); ?>" required>
            <br><br>

            <label for="Email">Email:</label>
            <input type="email" name="Email" id="Email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
            <br><br>

            <label for="Phone">Phone:</label>
            <input type="text" name="Phone" id="Phone" value="<?php echo htmlspecialchars($user['Phone']); ?>" required>
            <br><br>

            <button type="submit">Update Profile</button>
        </form>

        <!-- Back Button -->
        <a href="javascript:history.back();" class="back-button">Back</a>
    </div>
</body>
</html>
