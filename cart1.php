<?php
// Start session
session_start();

// Include database connection
require 'includes/db.php';

// Function to get product details
function getProductDetails($productId) {
    global $conn;
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Calculate total price
$totalPrice = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cartItems = $_SESSION['cart'];
} else {
    $cartItems = [];
}

foreach ($cartItems as $itemId => $quantity) {
    $product = getProductDetails($itemId);
    $totalPrice += $product['price'] * $quantity;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Shopping Cart</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="about.php">About Us</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <h2>Your Cart</h2>
        <?php if (!empty($cartItems)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $itemId => $quantity): ?>
                        <?php $product = getProductDetails($itemId); ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($quantity); ?></td>
                            <td><?php echo htmlspecialchars($product['price']); ?> USD</td>
                            <td><?php echo htmlspecialchars($product['price'] * $quantity); ?> USD</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p>Total Price: <?php echo htmlspecialchars($totalPrice); ?> USD</p>
            <a href="checkout.php" class="btn">Proceed to Checkout</a>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
        <a href="index.php" class="btn">Back to Main</a>
    </main>

    <footer>
        <?php include 'includes/footer.php'; ?>
    </footer>
</body>
</html>
