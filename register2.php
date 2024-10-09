<?php
session_start();
$host = "localhost";
$dbname = "flower_shop";
$db_username = "root";
$db_password = "";
$conn = new mysqli($host, $db_username, $db_password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $street_address = trim($_POST['street_address']);
    $city = trim($_POST['city']);
    $postal_code = trim($_POST['postal_code']);
    $country = trim($_POST['country']);

    // Validate input
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($street_address) || empty($city) || empty($postal_code) || empty($country)) {
        $error = "All fields are required.";
    } elseif (!preg_match("/^[A-Za-z]+$/", $first_name)) {
        $error = "First name can only contain letters.";
    } elseif (!preg_match("/^[A-Za-z]+$/", $last_name)) {
        $error = "Last name can only contain letters.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!preg_match("/^\+[1-9][0-9]{7,14}$/", $phone)) {
        $error = "Phone number must be in international format.";
    } elseif (!preg_match("/^[0-9]{5}$/", $postal_code)) {
        $error = "Postal code must be a 5-digit number.";
    } elseif (!preg_match("/^[A-Za-z ]+$/", $city) || !preg_match("/^[A-Za-z ]+$/", $country)) {
        $error = "City and Country can only contain letters.";
    } else {
        // Prepare statement to insert user data
        $stmt = $conn->prepare("INSERT INTO customers (first_name, last_name, email, phone, street_address, city, postal_code, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $first_name, $last_name, $email, $phone, $street_address, $city, $postal_code, $country);

        if ($stmt->execute()) {
            $success = "Registration successful!";
        } else {
            $error = "Failed to register. Please try again.";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - Flower Shop</title>
</head>
<body>
    <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p class="success"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>

    <!-- Client-Side Validation Form -->
    <form id="registrationForm" method="post" action="">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required pattern="[A-Za-z]+" title="Only letters are allowed.">

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required pattern="[A-Za-z]+" title="Only letters are allowed.">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required pattern="\+[1-9][0-9]{7,14}" title="Phone number must be in international format (e.g., +358457552300).">

        <label for="street_address">Street Address:</label>
        <input type="text" id="street_address" name="street_address" required>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" required pattern="[A-Za-z ]+" title="Only letters are allowed.">

        <label for="postal_code">Postal Code:</label>
        <input type="text" id="postal_code" name="postal_code" required pattern="[0-9]{5}" title="Must be a 5-digit postal code.">

        <label for="country">Country:</label>
        <input type="text" id="country" name="country" required pattern="[A-Za-z ]+" title="Only letters are allowed.">

        <button type="submit">Register</button>
    </form>
</body>
</html>
