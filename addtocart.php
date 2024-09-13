<?php
session_start();

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Add product to session cart
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    $_SESSION['cart'][] = $product_id;

    // Redirect back to products page or cart page
    header('Location: cart.php');
}
?>

/* products.php - add to each product */

/* cart.php */

<?php include 'includes/header.php'; ?>
<?php include 'db.php'; ?>

<main>

    <h2>Your Shopping Cart</h2>
    <form action="addtocart.php" method="POST">
    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
    <button type="submit">Add to Cart</button>
</form>
    
    <div class="cart-items">
        <?php
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $product_id) {
                // Fetch product details from database
                $sql = "SELECT * FROM products WHERE id=$product_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<div class='cart-item'>";
                    echo "<img src='" . $row["image"] . "' alt='" . $row["name"] . "'>";
                    echo "<h3>" . $row["name"] . "</h3>";
                    echo "<p>Price: $" . $row["price"] . "</p>";
                    echo "</div>";
                }
            }
        } else {
            echo "<p>Your cart is empty.</p>";
        }

        // Close connection
        $conn->close();
        ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
