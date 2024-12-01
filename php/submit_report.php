<head><link rel="stylesheet" href="../css/feedback_form.css">
</head>
<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['UserID'])) {
    die("<div class='container'><div class='sidebar'><h2>Access Denied</h2></div>
         <div class='main-content'><header><h1>Please Log In</h1></header></div></div>");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itineraryID = $_POST['ItineraryID'];
    $reportDescription = $_POST['ReportDescription'];
    $totalSpent = $_POST['TotalSpent'];

    if (empty($reportDescription) || empty($totalSpent)) {
        die("<div class='container'><div class='sidebar'><h2>Error</h2></div>
             <div class='main-content'><header><h1>All Fields Are Required</h1></header></div></div>");
    }

    $sqlInsertReport = "
        INSERT INTO report (ItineraryID, Description, TotalSpent) 
        VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sqlInsertReport);
    $stmt->bind_param("isd", $itineraryID, $reportDescription, $totalSpent);

    echo "<div class='container'>
            <div class='sidebar'>
                <h2>User Panel</h2>
                <ul class='user-tools'>
                    <li><a href='dashboard.php'>Dashboard</a></li>
                    <li><a href='logout.php'>Logout</a></li>
                </ul>
            </div>
            <div class='main-content'>";

    if ($stmt->execute()) {
        echo "<header><h1>Report Submitted Successfully</h1></header>
              <a href='feedback_report.php' class='button'>Go Back</a>";
    } else {
        echo "<header><h1>Error Submitting Report</h1></header>
              <p>" . $stmt->error . "</p>";
    }

    echo "</div></div>";

    $stmt->close();
    $conn->close();
} else {
    die("<div class='container'><div class='sidebar'><h2>Error</h2></div>
         <div class='main-content'><header><h1>Invalid Request Method</h1></header></div></div>");
}
?>
