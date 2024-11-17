<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['UserID'])) {
    header("Location: login.php"); // Redirect to login if not authenticated
    exit();
}

// Get UserID from the session
$userId = $_SESSION['UserID'];


include 'php/connection.php';
// Fetch the user's name
$stmt = $conn->prepare("SELECT Name FROM User WHERE UserID = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$userName = ($result->num_rows > 0) ? $result->fetch_assoc()['Name'] : "User";

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Dashboard</title>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Trip Tailor</h2>
            <h3>User Tools</h3>
            <ul class="user-tools">
                <li><a href="php/destinationlist.php">Explore and Select destinations</a></li>
                <li><a href="Itinerary.php">Manage your Itinerary</a></li>
                <li><a href="#">Report and Feedback</a></li>
                <li><a href="#">Profile Management</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="destinations">
                <div class="destination-card">
                    <img src="img/image8.jpg" alt="Hawa Mahal, Jaipur">
                    <p class="text-overlay">Hawa Mahal, Jaipur</p>
                </div>
                <div class="destination-card">
                    <img src="img/imaage12.webp" alt="Taj Mahal, Agra">
                    <p class="text-overlay">Taj Mahal, Agra</p>
                </div>
                <div class="destination-card">
                    <img src="img/image13.webp" alt="Backwaters, Kerala">
                    <p class="text-overlay">Backwaters, Kerala</p>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Welcome,</h1>
                <div class="user-profile">
                    <span><?php echo htmlspecialchars($userName); ?></span>
                    <div class="user-image"></div>
                </div>
            </div>

            <div class="calendar-container">
                <div class="header1">
                    <h2 class="calendar-title">Calendar</h2>
                    <button id="choose-month-year" class="nav-btn">Choose Month & Year</button>
                </div>
                <table class="calendar">
                    <thead>
                        <tr>
                            <th>Sun</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                        </tr>
                    </thead>
                    <tbody id="calendar-body">
                        <!-- Dates displayed here -->
                    </tbody>
                </table>

                <!-- Modal for selecting month and year -->
                <div id="modal" class="modal">
                    <div class="modal-content">
                        <span id="close-modal">&times;</span>
                        <h3>Select Month and Year</h3>
                        <label for="month-select">Month:</label>
                        <select id="month-select">
                            <!-- Options -->
                        </select>
                        <label for="year-select">Year:</label>
                        <input type="number" id="year-select" min="1900" max="2100" value="2024">
                        <button id="confirm-selection" class="nav-btn">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="scripts/dashboard.js"></script>
</body>

</html>