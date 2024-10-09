<?php
// Enable error reporting
ini_set('display_errors', 0); // Do not show errors on the webpage
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', 'error_log.txt'); // Specify error log file location (in the root folder of the project)
error_reporting(E_ALL); // Report all types of errors

session_start(); // Ensure sessions are started at the top of the page when needed
session_start();
include 'includes/header.php';
include 'db/db.php';

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flower Shop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Flower Shop</h1>
        <p>We offer a wide variety of fresh flowers and gifts for every occasion.</p>

        <!-- Check if user is logged in -->
        <?php if (isset($_SESSION['username'])): ?>
            <p>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <p><a href="login.php">Login</a> or <a href="register.php">Register</a> to place an order.</p>
        <?php endif; ?>

        <div class="product-list">
            <h2>Featured Products</h2>
            <div class="products">
                <div class="product-item">
                    <img src="images/roses.jpg" alt="Roses">
                    <h3>Roses</h3>
                    <p>€15.99</p>
                </div>
                <div class="product-item">
                    <img src="images/tulips.jpg" alt="Tulips">
                    <h3>Tulips</h3>
                    <p>€12.99</p>
                </div>
                <div class="product-item">
                    <img src="images/lilies.jpg" alt="Lilies">
                    <h3>Lilies</h3>
                    <p>€18.99</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>
