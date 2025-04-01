<?php
require_once 'db.php';

// Fetch all destinations
$stmt = $pdo->query("SELECT * FROM destinations");
$destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bamboo Travel - Tailor-Made Asian Tours</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <h1 class="logo">Bamboo Travel</h1>
            <nav class="nav">
                <a href="#destinations">Destinations</a>
                <a href="#about">About Us</a>
                <a href="mailto:info@bambootravel.co.uk">Contact</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h2>Tailor-Made Tours to Asia</h2>
            <p>Explore the wonders of Asia with bespoke travel experiences crafted just for you.</p>
            <a href="#destinations" class="cta-button">Discover Destinations</a>
        </div>
    </section>

    <!-- Destinations Section -->
    <section id="destinations" class="destinations-section">
        <div class="container">
            <h2>Our Destinations</h2>
            <?php if (count($destinations) > 0): ?>
                <div class="destination-list">
                    <?php foreach ($destinations as $dest): ?>
                        <div class="destination">
                            <?php if ($dest['des_image']): ?>
                                <img src="<?php echo htmlspecialchars($dest['des_image']); ?>" alt="<?php echo htmlspecialchars($dest['des_name']); ?>">
                            <?php endif; ?>
                            <h3>
                                <a href="./pages/tours.php?des_id=<?php echo $dest['des_id']; ?>">
                                    <?php echo htmlspecialchars($dest['des_name']); ?>
                                </a>
                            </h3>
                            <p><?php echo htmlspecialchars($dest['des_description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="no-destinations">No destinations available at this time.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Bamboo Travel. All rights reserved.</p>
            <p>Email: <a href="mailto:info@bambootravel.co.uk">info@bambootravel.co.uk</a> | Phone: 020 7720 9285</p>
        </div>
    </footer>
</body>
</html>