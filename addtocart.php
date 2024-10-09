<?php
session_start();
include 'includes/db_config.php'; // Include your database configuration

// Function to add an item to the cart
function addToCart($product_id, $quantity) {
    global $conn; // Use your database connection

    $user_id = $_SESSION['user_id'];

    // Check if the item already exists in the cart
    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Item exists, update the quantity
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("iii", $quantity, $user_id, $product_id);
        $stmt->execute();
    } else {
        // Item does not exist, insert a new entry
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);
        $stmt->execute();
    }
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Adding products to the cart
if (isset($_GET['id']) && isset($_GET['quantity'])) {
    $product_id = intval($_GET['id']);
    $quantity = intval($_GET['quantity']);
    
    // Check if quantity is valid
    if ($quantity > 0) {
        addToCart($product_id, $quantity);
        header("Location: cart.php"); // Redirect to cart after adding
        exit();
    } else {
        echo "Invalid quantity!";
    }
} else {
    echo "Product ID and quantity are required!";
}
?>
