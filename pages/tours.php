<?php
require_once '../db.php';

// Get des_id from URL
$des_id = isset($_GET['des_id']) ? (int)$_GET['des_id'] : 0;

// Fetch destination details
$stmt = $pdo->prepare("SELECT * FROM destinations WHERE des_id = ?");
$stmt->execute([$des_id]);
$destination = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch tours for this destination
if ($destination) {
    $stmt = $pdo->prepare("SELECT * FROM tours WHERE des_id = ?");
    $stmt->execute([$des_id]);
    $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $tours = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tours for <?php echo $destination ? htmlspecialchars($destination['des_name']) : 'Unknown'; ?> - Bamboo Travel</title>
    <link rel="stylesheet" href="../css/styletours.css">
</head>
<body>
    <div class="container">
        <!-- Header with destination image -->
        <header class="tour-header">
            <?php if ($destination && $destination['des_image']): ?>
                <img src="<?php echo htmlspecialchars($destination['des_image']); ?>" alt="<?php echo htmlspecialchars($destination['des_name']); ?>" class="header-image">
            <?php endif; ?>
            <h1>Tours for <?php echo $destination ? htmlspecialchars($destination['des_name']) : 'Unknown Destination'; ?></h1>
        </header>

        <!-- Back link -->
        <a href="../index.php" class="back-link">Back to Destinations</a>

        <!-- Main content -->
        <section class="tour-content">
            <?php if ($destination): ?>
                <?php if (count($tours) > 0): ?>
                    <div class="tour-list">
                        <?php foreach ($tours as $tour): ?>
                            <article class="tour">
                                <h2><?php echo htmlspecialchars($tour['tour_name']); ?></h2>
                                <p><strong>Description:</strong> <?php echo htmlspecialchars($tour['tour_description']); ?></p>
                                <p><strong>Highlights:</strong> <?php echo htmlspecialchars($tour['tour_highlights']); ?></p>
                                <p><strong>Suitable For:</strong> <?php echo htmlspecialchars($tour['tour_suitablefor']); ?></p>
                                <p><strong>Guide Price:</strong> $<?php echo number_format($tour['tour_guidPrice'], 2); ?></p>
                                <p><strong>Airline:</strong> <?php echo htmlspecialchars($tour['tour_airLine']); ?></p>
                                <a href="enquiry.php?tour_id=<?php echo $tour['tour_id']; ?>" class="enquiry-button">Request Enquiry</a>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="no-tours">No tours available for this destination.</p>
                <?php endif; ?>
            <?php else: ?>
                <p class="no-tours">Destination not found.</p>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>