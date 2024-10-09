<?php
// Enable error logging and session start at the beginning of the file
ini_set('display_errors', 0); // Do not show errors on the webpage
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', 'error_log.txt'); // Log errors in 'error_log.txt' file
error_reporting(E_ALL); // Report all types of errors

session_start(); // Start the session to manage user sessions

include 'header.php'; // Include the header
include 'db/db.php'; // Include the mysql
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
    // Retrieve and sanitize form input
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $street_address = htmlspecialchars(trim($_POST['street_address']));
    $city = htmlspecialchars(trim($_POST['city']));
    $postal_code = htmlspecialchars(trim($_POST['postal_code']));
    $country = htmlspecialchars(trim($_POST['country']));
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));

    // Server-side validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($street_address) || empty($city) || empty($postal_code) || empty($country) || empty($username) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!preg_match("/^\\+[1-9][0-9]{7,14}$/", $phone)) {
        $error = "Phone number must be a valid international format (e.g., +358457552300).";
    } elseif (strlen($username) < 4) {
        $error = "Username must be at least 4 characters long.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check for existing username or email
        $stmt = $conn->prepare("SELECT customer_id FROM customer WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username or email already taken.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Insert new user data into the database
            $stmt = $conn->prepare("INSERT INTO customer (first_name, last_name, email, phone, street_address, city, postal_code, country, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssss", $first_name, $last_name, $email, $phone, $street_address, $city, $postal_code, $country, $username, $hashed_password);

            if ($stmt->execute()) {
                $_SESSION['username'] = $username;
                header("Location: welcome.php"); // Redirect to welcome page on success
                exit();
            } else {
                $error = "Registration failed. Please try again.";
                error_log("Registration Error: " . $stmt->error); // Log the error in the file
            }
        }
        $stmt->close();
    }

    // Log server-side validation errors if any
    if ($error) {
        error_log("Validation Error: " . $error);
    }
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Flower Shop</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to the external stylesheet -->
    <script>
        // Client-side validation for matching passwords
        function validateForm() {
            let password = document.getElementById("password").value;
            let confirmPassword = document.getElementById("confirm_password").value;

            if (password !== confirmPassword) {
                alert("Passwords do not match!");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Register for Flower Shop</h2>
        <!-- Display error message if any -->
        <p class="error"><?php echo $error; ?></p>
        <form method="post" action="" onsubmit="return validateForm();">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" pattern="\\+[1-9][0-9]{7,14}" title="Phone number must be in the international format." required>

            <label for="street_address">Street Address:</label>
            <input type="text" id="street_address" name="street_address" required>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" required>

            <label for="postal_code">Postal Code:</label>
            <input type="text" id="postal_code" name="postal_code" required>

            <label for="country">Country:</label>
            <input type="text" id="country" name="country" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" minlength="4" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" minlength="6" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>
