<?php
session_start();
include 'includes/header.php'; 
include 'db/db.php';
include 'cart.php'; ?>

<main>
    <h2>Gifts</h2>
    <div class="product-container">
        <?php
        $sql = "SELECT * FROM gifts";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product-item'>";
                echo "<img src='" . htmlspecialchars($row['image_url']) . "' alt='" . htmlspecialchars($row['name']) . "' class='product-img'>";
                echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                echo "<p>Price: $" . htmlspecialchars($row['price']) . "</p>";
                echo "<button onclick=\"window.location.href='cart.php?action=add&id=" . htmlspecialchars($row['id']) . "'\">Add to Cart</button>";
                echo "</div>";
            }
        } else {
            echo "<p>No gifts available at the moment.</p>";
        }
        ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
