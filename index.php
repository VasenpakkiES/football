<?php 
include 'includes/header.php'; 
include 'db/db.php';
?>

    <main>
        <section id="hero">
            <h2>Eero Siljanderin Kukka & Ruukkukauppa, 2024</h2>
            <p>Tervetuloa ostoksille! Yhden pysähdyksen taktiikalla Kukat & Ruukut kotiisi sanoo kukkakauppiaasi Eero Siljander...</p>
            <button class="shop-now" onclick="window.location.href='shop.php'">Shop Now</button>
        </section>

        <section id="featured">
        <h2>Featured Flowers</h2>
        <!-- This is the correct way to define the container -->
        <div class="featured-container">
            <!-- Featured Item 1 -->
            <div class="featured-item">
                <img src="images/roses.jpg" alt="Roses">
                <h3>Roses</h3>
                <p>Elegant roses available in various colors and arrangements.</p>
            </div>
            <!-- Featured Item 2 -->
            <div class="featured-item">
                <img src="images/tulips.jpg" alt="Tulips">
                <h3>Tulips</h3>
                <p>Bright and vibrant tulips to brighten up your day.</p>
            </div>
            <!-- Featured Item 3 -->
            <div class="featured-item">
                <img src="images/lilies.jpg" alt="Lilies">
                <h3>Lilies</h3>
                <p>Beautiful lilies with a delicate fragrance.</p>
            </div>
            <!-- Featured Item 4 -->
            <div class="featured-item">
                <img src="images/sunflowers.jpg" alt="Sunflowers">
                <h3>Sunflowers</h3>
                <p>Cheerful sunflowers to brighten any room.</p>
            </div>
            <!-- Featured Item 5 -->
            <div class="featured-item">
                <img src="images/daisies.jpg" alt="Daisies">
                <h3>Daisies</h3>
                <p>Classic daisies to bring charm to your home.</p>
            </div>
        </div> <!-- End of .featured-container -->
    </section>

        <section id="promotions">
        <div class="promotion">
            <h3>Seasonal Sale</h3>
            <p>Kauden tuotteista saat Eerolta 20% alennuksen. Enjoy 20% off on all seasonal flowers. Limited time offer!</p>
            <button class="promo-button" onclick="window.location.href='shop.php'">Shop Now</button>
        </div>
        <div class="promotion">
            <h3>Free Delivery</h3>
            <p>Eero toimittaa kukat ja ruukut ja tarvikkeet Riihimäellä ja Hyvinkäälle ilmaiseksi, kun tilaat vähintään 100 €. Get free delivery on all orders over 100 €. No code needed.</p>
            <button class="promo-button" onclick="window.location.href='shop.php'">Order Now</button>
        </div>
    </section>
</main>

<?php
    include('footer.php');
?>
