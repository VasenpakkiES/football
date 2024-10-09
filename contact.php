<?php 
include 'includes/header.php'; 
?>

<main>
    <h2>Contact Us</h2>
    <p>We'd love to hear from you. Please fill out the form below, and we'll get back to you as soon as possible.</p>
    <form action="contact_process.php" method="post">
        <!-- Form fields -->
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br><br>

        <label for="telephone">Telephone:</label>
        <input type="tel" id="telephone" name="telephone" required><br><br>

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="street_address">Street Address:</label>
        <input type="text" id="street_address" name="street_address" required><br><br>

        <label for="po_box">PO Box:</label>
        <input type="text" id="po_box" name="po_box"><br><br>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" required><br><br>

        <label for="country">Country:</label>
        <input type="text" id="country" name="country" required><br><br>

        <button type="submit">Submit</button>
    </form>

    <button class="back-to-main" onclick="window.location.href='index.php'">Back to Main</button>
</main>

<?php include 'includes/footer.php'; ?>
