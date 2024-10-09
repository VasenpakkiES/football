<?php
session_start();
include 'includes/header.php';
include 'includes/login.php';
include 'db/db.php'; // Include your database configuration

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Function to get cart items with product details
function getCartItems() {
    global $conn; // Use your database connection
    $items = [];
    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("
        SELECT p.id AS product_id, p.name, p.price, c.quantity 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    return $items;
}

// Display cart items
$cartItems = getCartItems();
?>
<?php include 'includes/header.php'; ?>
<main>
    <h2>Your Shopping Cart</h2>
    <?php if (empty($cartItems)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($cartItems as $item):
                    $itemTotal = $item['price'] * $item['quantity'];
                    $total += $itemTotal;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo htmlspecialchars($item['price']); ?> €</td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($itemTotal); ?> €</td>
                    <td>
                        <a href="remove_from_cart.php?id=<?php echo $item['product_id']; ?>">Remove</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Total: <?php echo htmlspecialchars($total); ?> €</h3>
        <a href="checkout.php">Proceed to Checkout</a>
    <?php endif; ?>
</main>
<?php include 'includes/footer.php'; ?>
