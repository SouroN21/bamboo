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

    <!-- Hero Section with Slideshow -->
    <section class="hero">
        <div class="slideshow">
            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1545569341-9eb8b30979d9?q=80&w=2070&auto=format&fit=crop');"></div>
            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1490077476659-095159692ab5?q=80&w=2011&auto=format&fit=crop');"></div>
            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1518546305927-5a555bb7020d?q=80&w=2069&auto=format&fit=crop');"></div>
        </div>
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
            <p>© <?php echo date('Y'); ?> Bamboo Travel. All rights reserved.</p>
            <p>Email: <a href="mailto:info@bambootravel.co.uk">info@bambootravel.co.uk</a> | Phone: 020 7720 9285</p>
        </div>
    </footer>
</body>
</html>