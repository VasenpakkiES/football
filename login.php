<?php
// Enable error reporting and logging settings
ini_set('display_errors', 0); // Do not show errors on the webpage
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', 'error_log.txt'); // Specify the error log file location (in the root folder of the project)
error_reporting(E_ALL); // Report all types of errors

session_start(); // Ensure sessions are started at the top of the page when needed

include 'includes/header.php';
include 'db/db.php'; // Include the database connection file

$host = "localhost";
$dbname = "flower_shop";
$db_username = "root";
$db_password = "";
$conn = new mysqli($host, $db_username, $db_password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("Connection failed. Please try again later.");
}

$error = '';
$success = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form input
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Server-side validation
    if (empty($email) || empty($password)) {
        $error = "Email and password are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } else {
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT customer_id, password FROM customer WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id; // Store user ID in session
                header("Location: welcome.php"); // Redirect to welcome page
                exit;
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "No user found with this email.";
        }
        $stmt->close();
    }

    // Log server-side validation errors if any
    if ($error) {
        error_log("Login Error: " . $error);
    }
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Flower Shop</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to the external stylesheet -->
    <script>
        // Client-side validation or JavaScript logic can be added here
    </script>
</head>
<body>
    <div class="container">
        <h2>Login to Your Flower Shop Account</h2>

        <!-- Display error message if any -->
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form id="loginForm" method="post" action="">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required minlength="6">

            <button type="submit">Login</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?> <!-- Include the footer -->
</body>
</html>
