<?php
session_start();
require_once 'db_connection.php'; // Include a file for database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['userid'];
    $password = $_POST['password'];

    // Query the database to check if the user exists
    $query = "SELECT * FROM userlist WHERE userid = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // User found, set session variables
        $_SESSION['username'] = $username;
        header("Location:admin_dash.php"); // Redirect to a dashboard or home page
    } else {
        // Invalid login credentials
        echo "Invalid username or password. <a href='login.php'>Try again</a>";
    }
}
?>
