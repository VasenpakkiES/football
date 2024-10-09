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

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $product_id = (int) $_GET['id'];

    if ($_GET['action'] == 'add') {
        // Check if the product ID exists in the database
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Add product to cart
            if (!isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] = 1;
            } else {
                $_SESSION['cart'][$product_id]++;
            }
        }
    }

    if ($_GET['action'] == 'remove') {
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Flower Shop</title>
</head>
<body>
<div>
    <h2>Your Shopping Cart</h2>
    <?php
    if (!empty($_SESSION['cart'])) {
        $total = 0;
        foreach ($_SESSION['cart'] as $id => $quantity) {
            // Fetch product details from the database
            $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $product = $stmt->get_result()->fetch_assoc();

            echo "<div>";
            echo "<p>Product: " . htmlspecialchars($product['name']) . "</p>";
            echo "<p>Quantity: " . htmlspecialchars($quantity) . "</p>";
            echo "<p>Price: $" . htmlspecialchars($product['price'] * $quantity) . "</p>";
            echo "<a href='cart.php?action=remove&id=" . $id . "'>Remove</a>";
            echo "</div>";
            
            $total += $product['price'] * $quantity;
        }
        echo "<h3>Total: $" . $total . "</h3>";
    } else {
        echo "<p>Your cart is empty.</p>";
    }
    ?>
</div>
</body>
</html>

<?php include 'includes/footer.php'; ?>
