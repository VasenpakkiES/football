 <?php
session_start();
include 'includes/header.php'; 
include 'db/db.php'; // Ensure this path is correct

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<main>
    <h2>Shop</h2>

    <section id="products">
        <div class="product-container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product-item'>";
                    echo "<img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "' class='product-img'>";
                    echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                    echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                    echo "<p>Price: $" . htmlspecialchars($row['price']) . "</p>";
                    echo "<button onclick=\"window.location.href='cart.php?action=add&id=" . htmlspecialchars($row['id']) . "'\">Add to Cart</button>";
                    echo "</div>";
                }
            } else {
                echo "<p>No products available at the moment.</p>";
            }
            ?>
        </div>
    </section>

    <button class="back-to-main" onclick="window.location.href='index.php'">Back to Main</button>
</main>

<?php include 'includes/footer.php'; ?>
