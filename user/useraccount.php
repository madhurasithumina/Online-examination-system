<?php
session_start();
require_once "config.php";

// Check if the user is logged in, if not redirect them to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: /online examination system/user/login.php");
    exit();
}

$user_id = $_SESSION['id'];
$username = '';
$email = '';

// Fetch user details
$sql = "SELECT username, email FROM users WHERE id = :id";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $username = $row['username'];
            $email = $row['email'];
        }
    }
    unset($stmt);
}

// Handle Delete user account
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $sql = "DELETE FROM users WHERE id = :id";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Unset session variables and destroy the session on successful delete
            session_destroy();
            header("Location: /online examination system/user/register.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f8ff; /* Light blue background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .account-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 100%;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            color: #34495e;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
            color: #2c3e50;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 10px;
        }

        button:hover {
            background-color: #2980b9;
        }

        .delete-btn {
            background-color: #e74c3c;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        .logout-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #34495e;
            text-decoration: none;
            font-weight: 500;
        }

        .logout-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .account-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="account-container">
        <h2>Your Account</h2>
        <div class="info">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        </div>
        
        <form action="update.php" method="get">
            <button type="submit">Update</button>
        </form>

        <form action="useraccount.php" method="post">
            <input type="hidden" name="delete" value="true">
            <button type="submit" class="delete-btn">Delete Account</button>
        </form>

        <a href="/online examination system/user/logout.php" class="logout-link">Logout</a>

        <!-- Main Menu Button -->
        <form action="/online examination system/user_index.html">
            <button type="submit">Main Menu</button>
        </form>
    </div>

</body>
</html>
