<?php
session_start();
include 'includes/header.php';
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture all the form fields
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $street_address = trim($_POST['street_address']);
    $city = trim($_POST['city']);
    $postal_code = trim($_POST['postal_code']);
    $country = trim($_POST['country']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Server-side validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($street_address) || empty($city) || empty($postal_code) || empty($country) || empty($username) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!preg_match("/^\+[1-9][0-9]{7,14}$/", $phone)) {
        $error = "Phone number must be a valid international format (e.g., +358457552300).";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if the username or email already exists
        $stmt = $conn->prepare("SELECT id FROM customer WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username or email already taken.";
        } else {
            // Insert new customer with hashed password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO customer (first_name, last_name, email, phone, street_address, city, postal_code, country, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssss", $first_name, $last_name, $email, $phone, $street_address, $city, $postal_code, $country, $username, $hashed_password);

            if ($stmt->execute()) {
                $_SESSION['username'] = $username;
                header("Location: welcome.php");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
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
    <title>Register - Flower Shop</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Register for Flower Shop</h2>
        <p class="error"><?php echo $error; ?></p>
        <form method="post" action="">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" pattern="\+[1-9][0-9]{7,14}" title="Phone number must be in the international format." required>
            <label for="street_address">Street Address:</label>
            <input type="text" id="street_address" name="street_address" required>
            <label for="city">City:</label>
            <input type="text" id="city" name="city" required>
            <label for="postal_code">Postal Code:</label>
            <input type="text" id="postal_code" name="postal_code" required>
            <label for="country">Country:</label>
            <input type="text" id="country" name="country" required>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
<?php include 'footer.php'; ?>
