<?php
require_once '../db.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['destination_submit'])) {
        $des_name = $_POST['des_name'];
        $des_description = $_POST['des_description'];

        // Handle image upload to local folder
        $des_image = null;
        if (isset($_FILES['des_image']) && $_FILES['des_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $fileName = uniqid() . '-' . basename($_FILES['des_image']['name']); // Unique filename
            $uploadPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['des_image']['tmp_name'], $uploadPath)) {
                $des_image = $uploadPath; // Store relative path in DB
            } else {
                echo "<p>Failed to upload image.</p>";
            }
        }

        $stmt = $pdo->prepare("INSERT INTO destinations (des_name, des_description, des_image) VALUES (?, ?, ?)");
        $stmt->execute([$des_name, $des_description, $des_image]);
    }

    if (isset($_POST['tour_submit'])) {
        $tour_name = $_POST['tour_name'];
        $tour_description = $_POST['tour_description'];
        $tour_highlights = $_POST['tour_highlights'];
        $tour_suitablefor = $_POST['tour_suitablefor'];
        $tour_guidPrice = $_POST['tour_guidPrice'];
        $tour_airLine = $_POST['tour_airLine'];

        $stmt = $pdo->prepare("INSERT INTO tours (tour_name, tour_description, tour_highlights, tour_suitablefor, tour_guidPrice, tour_airLine) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$tour_name, $tour_description, $tour_highlights, $tour_suitablefor, $tour_guidPrice, $tour_airLine]);
    }

    if (isset($_POST['enquiry_submit'])) {
        $tour_id = $_POST['tour_id'];
        $tourname = $_POST['tourname'];
        $enq_modifications = $_POST['enq_modifications'];
        $enq_dateOfDeparture = $_POST['enq_dateOfDeparture'];
        $enq_tripDuration = $_POST['enq_tripDuration'];
        $enq_noOfAdults = $_POST['enq_noOfAdults'];
        $enq_noOfChild = $_POST['enq_noOfChild'];
        $enq_bugetPerPerson = $_POST['enq_bugetPerPerson'];
        $enq_standardHotel = $_POST['enq_standardHotel'];
        $enq_noOfRooms = $_POST['enq_noOfRooms'];
        $enq_departureAirport = $_POST['enq_departureAirport'];
        $enq_flightClass = $_POST['enq_flightClass'];
        $enq_interests = $_POST['enq_interests'];

        $stmt = $pdo->prepare("INSERT INTO enquiry (tour_id, tourname, enq_modifications, enq_dateOfDeparture, enq_tripDuration, enq_noOfAdults, enq_noOfChild, enq_bugetPerPerson, enq_standardHotel, enq_noOfRooms, enq_departureAirport, enq_flightClass, enq_interests) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$tour_id, $tourname, $enq_modifications, $enq_dateOfDeparture, $enq_tripDuration, $enq_noOfAdults, $enq_noOfChild, $enq_bugetPerPerson, $enq_standardHotel, $enq_noOfRooms, $enq_departureAirport, $enq_flightClass, $enq_interests]);
    }

    echo "<p>Data inserted successfully!</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data - Bamboo</title>
    <link rel="stylesheet" href="../css/styleInsert.css">
</head>
<body>
    <div class="container">
        <h1>Insert Data into Bamboo Database</h1>

        <!-- Destinations Form -->
        <h2>Add Destination</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="des_name" placeholder="Destination Name" required><br>
            <textarea name="des_description" placeholder="Description"></textarea><br>
            <input type="file" name="des_image" accept="image/*"><br>
            <button type="submit" name="destination_submit">Add Destination</button>
        </form>

        <!-- Tours Form -->
        <h2>Add Tour</h2>
        <form method="POST">
            <input type="text" name="tour_name" placeholder="Tour Name" required><br>
            <textarea name="tour_description" placeholder="Description"></textarea><br>
            <textarea name="tour_highlights" placeholder="Highlights"></textarea><br>
            <input type="text" name="tour_suitablefor" placeholder="Suitable For"><br>
            <input type="number" name="tour_guidPrice" placeholder="Guide Price" step="0.01"><br>
            <input type="text" name="tour_airLine" placeholder="Airline"><br>
            <button type="submit" name="tour_submit">Add Tour</button>
        </form>

        <!-- Enquiry Form -->
        <h2>Add Enquiry</h2>
        <form method="POST">
            <input type="number" name="tour_id" placeholder="Tour ID"><br>
            <input type="text" name="tourname" placeholder="Tour Name"><br>
            <textarea name="enq_modifications" placeholder="Modifications"></textarea><br>
            <input type="date" name="enq_dateOfDeparture" placeholder="Departure Date"><br>
            <input type="number" name="enq_tripDuration" placeholder="Trip Duration (days)"><br>
            <input type="number" name="enq_noOfAdults" placeholder="Number of Adults"><br>
            <input type="number" name="enq_noOfChild" placeholder="Number of Children"><br>
            <input type="number" name="enq_bugetPerPerson" placeholder="Budget Per Person" step="0.01"><br>
            <input type="text" name="enq_standardHotel" placeholder="Hotel Standard"><br>
            <input type="number" name="enq_noOfRooms" placeholder="Number of Rooms"><br>
            <input type="text" name="enq_departureAirport" placeholder="Departure Airport"><br>
            <input type="text" name="enq_flightClass" placeholder="Flight Class"><br>
            <textarea name="enq_interests" placeholder="Interests"></textarea><br>
            <button type="submit" name="enquiry_submit">Add Enquiry</button>
        </form>
    </div>
</body>
</html>