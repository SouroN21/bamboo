<?php
require_once '../db.php';

// Handle destination form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_destination'])) {
    $des_name = $_POST['des_name'] ?? '';
    $des_description = $_POST['des_description'] ?? '';
    $des_image = '';

    if (isset($_FILES['des_image']) && $_FILES['des_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = './uploads/';
        $file_name = basename($_FILES['des_image']['name']);
        $des_image = $upload_dir . time() . '_' . $file_name; // Unique filename
        move_uploaded_file($_FILES['des_image']['tmp_name'], $des_image);
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO destinations (des_name, des_description, des_image) VALUES (?, ?, ?)");
        $stmt->execute([$des_name, $des_description, $des_image]);
        $dest_success = "Destination added successfully!";
    } catch (PDOException $e) {
        $dest_error = "Failed to add destination: " . $e->getMessage();
    }
}

// Handle tour form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_tour'])) {
    $des_id = $_POST['des_id'] ?? 0;
    $tour_name = $_POST['tour_name'] ?? '';
    $tour_description = $_POST['tour_description'] ?? '';
    $tour_highlights = $_POST['tour_highlights'] ?? '';
    $tour_suitablefor = $_POST['tour_suitablefor'] ?? '';
    $tour_guidPrice = $_POST['tour_guidPrice'] ?? '';
    $tour_airLine = $_POST['tour_airLine'] ?? '';

    try {
        $stmt = $pdo->prepare("INSERT INTO tours (des_id, tour_name, tour_description, tour_highlights, tour_suitablefor, tour_guidPrice, tour_airLine) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$des_id, $tour_name, $tour_description, $tour_highlights, $tour_suitablefor, $tour_guidPrice, $tour_airLine]);
        $tour_success = "Tour added successfully!";
    } catch (PDOException $e) {
        $tour_error = "Failed to add tour: " . $e->getMessage();
    }
}

// Fetch destinations for the tour form dropdown
$stmt = $pdo->query("SELECT des_id, des_name FROM destinations");
$destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Destinations & Tours - Bamboo Travel</title>
    <link rel="stylesheet" href="../css/styletours.css">
</head>
<body>
    <div class="container">
        <header class="tour-header">
            <h1>Add Destinations & Tours</h1>
        </header>

        <a href="../index.php" class="back-link">Back to Home</a>

        <section class="add-content">
            <!-- Destination Form -->
            <h2>Add a New Destination</h2>
            <?php if (isset($dest_success)): ?>
                <p class="success-message"><?php echo $dest_success; ?></p>
            <?php elseif (isset($dest_error)): ?>
                <p class="error-message"><?php echo $dest_error; ?></p>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data" class="add-form">
                <div class="form-group">
                    <label for="des_name">Destination Name</label>
                    <input type="text" id="des_name" name="des_name" required placeholder="e.g., Kyoto, Japan">
                </div>
                <div class="form-group">
                    <label for="des_description">Description</label>
                    <textarea id="des_description" name="des_description" placeholder="e.g., A city rich in history..."></textarea>
                </div>
                <div class="form-group">
                    <label for="des_image">Image</label>
                    <input type="file" id="des_image" name="des_image" accept="image/*">
                </div>
                <button type="submit" name="add_destination" class="submit-button">Add Destination</button>
            </form>

            <!-- Tour Form -->
            <h2>Add a New Tour</h2>
            <?php if (isset($tour_success)): ?>
                <p class="success-message"><?php echo $tour_success; ?></p>
            <?php elseif (isset($tour_error)): ?>
                <p class="error-message"><?php echo $tour_error; ?></p>
            <?php endif; ?>
            <form method="POST" class="add-form">
                <div class="form-group">
                    <label for="des_id">Destination</label>
                    <select id="des_id" name="des_id" required>
                        <option value="">Select a destination</option>
                        <?php foreach ($destinations as $dest): ?>
                            <option value="<?php echo $dest['des_id']; ?>"><?php echo htmlspecialchars($dest['des_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tour_name">Tour Name</label>
                    <input type="text" id="tour_name" name="tour_name" required placeholder="e.g., Kyoto Cultural Journey">
                </div>
                <div class="form-group">
                    <label for="tour_description">Description</label>
                    <textarea id="tour_description" name="tour_description" placeholder="e.g., Explore ancient temples..."></textarea>
                </div>
                <div class="form-group">
                    <label for="tour_highlights">Highlights</label>
                    <textarea id="tour_highlights" name="tour_highlights" placeholder="e.g., Kinkaku-ji, Bamboo Grove..."></textarea>
                </div>
                <div class="form-group">
                    <label for="tour_suitablefor">Suitable For</label>
                    <input type="text" id="tour_suitablefor" name="tour_suitablefor" placeholder="e.g., Families, History buffs">
                </div>
                <div class="form-group">
                    <label for="tour_guidPrice">Guide Price ($)</label>
                    <input type="number" id="tour_guidPrice" name="tour_guidPrice" step="0.01" min="0" placeholder="e.g., 1200.00">
                </div>
                <div class="form-group">
                    <label for="tour_airLine">Airline</label>
                    <input type="text" id="tour_airLine" name="tour_airLine" placeholder="e.g., Japan Airlines">
                </div>
                <button type="submit" name="add_tour" class="submit-button">Add Tour</button>
            </form>
        </section>
    </div>
</body>
</html>