<?php
// Start session to retrieve UserID or ensure the user is logged in
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location: ../Login.html");
    exit();
}
include 'connection.php';




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get ItineraryID and AttractionID
    $ItineraryID = intval($_GET['ItineraryID']);
    $AttractionID = intval($_POST['AttractionID']);

    // Validate inputs
    if (!$ItineraryID || !$AttractionID) {
        echo "Invalid input.";
        exit();
    }

    // Check if the attraction already exists in the itinerary
    $checkQuery = "SELECT COUNT(*) as count FROM ItineraryAttraction WHERE ItineraryID = ? AND AttractionID = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $ItineraryID, $AttractionID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if ($row['count'] > 0) {
        // Attraction already exists, redirect with an error message
        header("Location: ../itineray_details.php?ItineraryID=$ItineraryID&error=AttractionAlreadyExists");
        exit();
    }

    // Insert the attraction into the itinerary
    $insertQuery = "INSERT INTO ItineraryAttraction (ItineraryID, AttractionID) VALUES (?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ii", $ItineraryID, $AttractionID);

    if ($stmt->execute()) {
        // Redirect to itinerary_details.php
        header("Location: ../itineray_details.php?ItineraryID=$ItineraryID&success=AttractionAdded");
        exit();
    } else {
        echo "Error adding attraction: " . $stmt->error;
    }

    $stmt->close();
}




// Get ItineraryID from URL parameter
if (!isset($_GET['ItineraryID'])) {
    echo "Itinerary ID not provided.";
    exit();
}

$ItineraryID = intval($_GET['ItineraryID']);

// Fetch the DestinationID associated with the ItineraryID
$destinationQuery = "SELECT DestinationID FROM Itinerary WHERE ItineraryID = ?";
$stmt = $conn->prepare($destinationQuery);
$stmt->bind_param("i", $ItineraryID);
$stmt->execute();
$stmt->bind_result($DestinationID);
$stmt->fetch();
$stmt->close();

if (!$DestinationID) {
    echo "Invalid Itinerary ID.";
    exit();
}

// Fetch attractions associated with the DestinationID
$attractionsQuery = "SELECT AttractionID, AttractionName FROM Attraction WHERE DestinationID = ?";
$stmt = $conn->prepare($attractionsQuery);
$stmt->bind_param("i", $DestinationID);
$stmt->execute();
$result = $stmt->get_result();
$attractions = [];
while ($row = $result->fetch_assoc()) {
    $attractions[] = $row;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Attraction</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 2%;
            background-color: #e7f2f4;
        }

        /* Form container styling */
        .form-container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 480px;
            text-align: center;
            animation: fadeIn 0.4s ease-in-out;
        }

        /* Fade-in animation */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Title styling */
        h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        /* Form label styling */
        label {
            font-size: 1.1rem;
            color: #333;
            text-align: left;
            display: block;
            margin-bottom: 8px;
        }

        /* Input field styling */
        input,
        select {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            color: #333;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #21215e;
            background-color: #fff;
        }
        .submit-btn {
            width: 100% ;
        }
        /* Button styling */
        button {
            background-color: #21215e;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1.1rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s ease;
            margin-top: 15px;
            width: 50% ;
        }

        button:hover {
            background-color: #3a3a92;
            transform: translateY(-3px);
        }

        button:active {
            transform: translateY(1px);
        }

        /* Back button styling */
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1rem;
            color: #21215e;
            background-color: #f1f1f1;
            border: 1px solid #ccc;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .back-button:hover {
            background-color: #e0e0e0;
            transform: scale(1.05);
        }

        .back-button:active {
            background-color: #d4d4d4;
            transform: scale(1);
        }

        /* Responsive styling for small devices */
        @media (max-width: 480px) {
            .form-container {
                padding: 20px;
                max-width: 100%;
            }

            input,
            button,
            .back-button {
                font-size: 1rem;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h1>Add New Attraction</h1>
            <form method="POST" action="add_attraction.php?ItineraryID=<?= htmlspecialchars($ItineraryID) ?>">
                <input type="hidden" name="ItineraryID" value="<?= htmlspecialchars($ItineraryID) ?>">
                <label for="AttractionID">Select Attraction:</label>
                <select name="AttractionID" id="AttractionID" required>
                    <?php foreach ($attractions as $attraction): ?>
                        <option value="<?= $attraction['AttractionID'] ?>">
                            <?= htmlspecialchars($attraction['AttractionName']) ?>
                        </option>
                    <?php endforeach; ?>
                </select> 
                <button class="submit-btn" type="submit">Add</button>
            </form> 
            <button class="back-button" onclick="window.history.back();">Back</button>
        </div>
    </div>
</body>

</html>
