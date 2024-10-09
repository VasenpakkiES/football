<?php
session_start();
include 'includes/header.php';
include 'db/db.php'; // Include your database configuration

// Function to remove an item from the cart
function removeFromCart($product_id) {
    global $conn; // Use your database connection
    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Removing products from the cart
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    removeFromCart($product_id);
    header("Location: cart.php"); // Redirect to cart after removing
    exit();
} else {
    echo "Product ID is required!";
}
?>
