<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flower Shop</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <h1>Welcome to Our Flower Shop</h1>
    </header>
    <?php include 'navbar.php'; ?>
/* header above */

/*footer below */
<footer class="footer">
    <p>&copy; 2024 Flower Shop, Helsinki, Finland. All rights reserved.</p>
</footer>
</body>
</html>

/* navbar
<nav class="navbar">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="flowers.php">Flowers</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="gifts.php">Gifts</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="contact.php">Contact</a></li>
    </ul>
</nav>
*/ db.php */

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flower_shop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>