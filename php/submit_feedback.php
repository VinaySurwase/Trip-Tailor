<head><link rel="stylesheet" href="../css/feedback_form.css">
</head>
<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['UserID'])) {
    die("<div class='container'>
            <div class='sidebar'>
                <h2>Access Denied</h2>
            </div>
            <div class='main-content'>
                <header>
                    <h1>Please Log In</h1>
                </header>
            </div>
         </div>");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_SESSION['UserID'];
    $destinationID = $_POST['DestinationID'];
    $feedback = $_POST['Feedback'];
    $rating = $_POST['Rating'];

    // Validate that the selected destination belongs to the user
    $validateSql = "
        SELECT 1 
        FROM itinerary i 
        WHERE i.DestinationID = ? AND i.UserID = ?";
    $validateStmt = $conn->prepare($validateSql);
    $validateStmt->bind_param("ii", $destinationID, $userID);
    $validateStmt->execute();
    $validateResult = $validateStmt->get_result();

    echo "<div class='container'>
            <div class='sidebar'>
                <h2>User Panel</h2>
                <ul class='user-tools'>
                    <li><a href='dashboard.php'>Dashboard</a></li>
                    <li><a href='logout.php'>Logout</a></li>
                </ul>
            </div>
            <div class='main-content'>";

    if ($validateResult->num_rows > 0) {
        // Insert feedback into the database
        $insertSql = "
            INSERT INTO feedback (DestinationID, Description, Rating) 
            VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("isi", $destinationID, $feedback, $rating);

        if ($insertStmt->execute()) {
            echo "<header>
                    <h1>Feedback Submitted Successfully!</h1>
                  </header>
                  <a href='feedback_report.php' class='button'>Go Back</a>";
        } else {
            echo "<header>
                    <h1>Error Submitting Feedback</h1>
                  </header>
                  <p>" . $conn->error . "</p>";
        }
    } else {
        echo "<header>
                <h1>Invalid Destination Selection</h1>
              </header>
              <p>Please choose a valid destination from your itinerary.</p>";
    }

    echo "</div></div>";

    $validateStmt->close();
    $conn->close();
} else {
    die("<div class='container'>
            <div class='sidebar'>
                <h2>Error</h2>
            </div>
            <div class='main-content'>
                <header>
                    <h1>Invalid Request Method</h1>
                </header>
            </div>
         </div>");
}
?>
