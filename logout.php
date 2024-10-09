<?php
// Enable error reporting
ini_set('display_errors', 0); // Do not show errors on the webpage
ini_set('log_errors', 1); // Enable error logging
ini_set('error_log', 'error_log.txt'); // Specify error log file location (in the root folder of the project)
error_reporting(E_ALL); // Report all types of errors

session_start(); // Ensure sessions are started at the top of the page when needed
include 'includes/header.php';
include 'db/db.php';
// Destroy all session variables and end the session
session_unset();
session_destroy();

// Redirect to the index page after logout
header("Location: index.php");
exit();
?>