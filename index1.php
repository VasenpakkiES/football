<?php 
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once 'includes/header.php'; 
include_once 'db/db.php'; 
include_once 'cart.php';
include_once 'includes/footer.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flower Shop</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Welcome to Our Flower Shop</h1>
        <!-- Cart Summary -->
        <div class="cart">
            <?php
            $total_items = 0;
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item_id => $quantity) {
                    $total_items += $quantity;
                }
            }
            ?>
            <a href="cart.php">Cart (<?php echo $total_items; ?> items)</a>
        </div>
    </header>
    
    <!-- Your page content -->
    <main>
        <section id="hero">
            <h2> Eero Siljanderin Kukka & Ruukkukauppa, (www-sivut, 10.9.2024) </h2>
            <p> Tervetuloa ostoksille! Yhden pysähdyksen taktiikalla Kukat & Ruukut kotiisi sanoo kukkakauppiaasi Eero Siljander. Tavoittanet minut tel.+++358987654321. Hi ! Your one-stop shop for exquisite flowers and arrangements delivered right to your door. Discover our wide range of beautiful blooms, perfect for any occasion.</p>
            <button class="shop-now" onclick="window.location.href='shop.php'">Shop Now</button>
        </section>

        <section id="featured">
            <h2>Featured Flowers</h2>
            <div class="featured-container">
                <div class="featured-item">
                    <img src="images/roses.jpg" alt="Roses">
                    <h3>Roses</h3>
                    <p> Ruusuja hopeamaljaan ? Tästä! Elegant roses available in various colors and arrangements. Perfect for any occasion.</p>
                </div>
                <div class="featured-item">
                    <img src="images/tulips.jpg" alt="Tulips">
                    <h3>Tulips</h3>
                    <p> Tulppaanit kevääsi iloiksi Eerolta ! Bright and vibrant tulips to brighten up your day. Available in a range of hues.</p>
                </div>
                <div class="featured-item">
                    <img src="images/lilies.jpg" alt="Lilies">
                    <h3>Lilies</h3>
                    <p> Elegantit Eeron liljat antavat tilallesi Lookkia! Beautiful lilies with a delicate fragrance, perfect for adding elegance to any space.</p>
                </div>
                <div class="featured-item">
                    <img src="images/sunflowers.jpg" alt="Sunflowers">
                    <h3>Sunflowers</h3>
                    <p> Hauskoja auringonkukkia yleiskukiksi koristeluun Eerolta! Cheerful sunflowers to brighten up any room. Ideal for a sunny disposition.</p>
                </div>
                <div class="featured-item">
                    <img src="images/daisies.jpg" alt="Daisies">
                    <h3>Daisies</h3>
                    <p> Eeron perinteiset päivänkakkarat luovat elegantin tunnelman! Tilaan kuin tilaan! Classic daisies to bring a touch of simplicity and charm to your home.</p>
                </div>
            </div>
        </section>

        <section id="promotions">
            <div class="promotion">
                <h3>Seasonal Sale</h3>
                <p> Kauden tuotteista saat Eerolta 20% alennuksen. Enjoy 20% off on all seasonal flowers. Limited time offer!</p>
                <button class="promo-button" onclick="window.location.href='shop.php'">Shop Now</button>
            </div>
            <div class="promotion">
                <h3>Free Delivery</h3>
                <p> Eero toimittaa kukat ja ruukut ja tarvikkeet Riihimäellä ja Hyvinkäälle ilmaiseksi, kun tilaat vähintään 100 €. Get free delivery on all orders over 100 €. No code needed.</p>
                <button class="promo-button" onclick="window.location.href='shop.php'">Order Now</button>
            </div>
        </section>
    </main>
    <script src="js/script.js"></script>
</body>
</html>
