<?php
session_start();
require_once "config.php";

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location:/online examination system/user/login.php");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Delete user from the database
    $sql = "DELETE FROM users WHERE id = :id";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Destroy session and redirect to login page
            session_destroy();
            header("Location: /online examination system/user/login.php");
            exit();
        } else {
            echo "Something went wrong. Please try again.";
        }
    }
    unset($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Account</title>
</head>
<body>
    <h2>Delete Your Account</h2>
    <p>Are you sure you want to delete your account? This action cannot be undone.</p>
    <form action="delete.php" method="post">
        <button type="submit">Delete My Account</button>
    </form>
    <a href="/online examination system/user/useraccount.php">Cancel</a>
</body>
</html>
