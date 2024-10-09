<?php include 'includes/header.php'; ?>

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
$username = $_SESSION['username'];

// Fetch user data based on username
$stmt = $conn->prepare("SELECT first_name, last_name, email, phone, street_address, city, postal_code, country FROM customer WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($first_name, $last_name, $email, $phone, $street_address, $city, $postal_code, $country);
$stmt->fetch();
$stmt->close();

// Update user data
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
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!preg_match("/^\+[1-9][0-9]{7,14}$/", $phone)) {
        $error = "Phone number must be in the international format.";
    } else {
        // Update user data in the database
        $stmt = $conn->prepare("UPDATE customer SET first_name = ?, last_name = ?, email = ?, phone = ?, street_address = ?, city = ?, postal_code = ?, country = ? WHERE username = ?");
        $stmt->bind_param("sssssssss", $first_name, $last_name, $email, $phone, $street_address, $city, $postal_code, $country, $username);

        if ($stmt->execute()) {
            $success = "Profile updated successfully!";
        } else {
            $error = "Failed to update profile. Please try again.";
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
    <title>Profile - Flower Shop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h2>Your Profile</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" pattern="\+[1-9][0-9]{7,14}" title="Phone number must be in the international format." required>
            <label for="street_address">Street Address:</label>
            <input type="text" id="street_address" name="street_address" value="<?php echo htmlspecialchars($street_address); ?>" required>
            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($city); ?>" required>
            <label for="postal_code">Postal Code:</label>
            <input type="text" id="postal_code" name="postal_code" value="<?php echo htmlspecialchars($postal_code); ?>" required>
            <label for="country">Country:</label>
            <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($country); ?>" required>
            <button type="submit">Update Profile</button>
        </form>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>
