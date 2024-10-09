<?php
session_start();
require 'db.php';

$total_items = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item_id => $quantity) {
        $total_items += $quantity;
    }
}
?>

<div class="cart-summary">
    <a href="cart.php">Cart (<?php echo $total_items; ?> items)</a>
</div>
