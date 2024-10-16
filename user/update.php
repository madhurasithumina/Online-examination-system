<?php
session_start();
require_once "config.php";

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: /online examination system/user/login.php");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['id'];

// Initialize variables
$new_username = $new_email = "";
$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = trim($_POST['username']);
    $new_email = trim($_POST['email']);

    // Validate that both fields are not empty
    if (empty($new_username) || empty($new_email)) {
        $error = "Both fields are required.";
    } else {
        // Update the user in the database
        $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bindParam(":username", $new_username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $new_email, PDO::PARAM_STR);
            $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // If update is successful, update session variables
                $_SESSION['username'] = $new_username;
                echo "<script>alert('Update successful!'); window.location.href = '/online examination system/user/useraccount.php';</script>";
                exit();
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
        unset($stmt);
    }
}

// Retrieve current user details
$sql = "SELECT username, email FROM users WHERE id = :id";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $new_username = $row['username'];
            $new_email = $row['email'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #34495e;
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            font-size: 24px;
            color: #2980b9;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        .error {
            color: #e74c3c;
            text-align: center;
            margin-top: 10px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #2980b9;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Update Your Account</h2>
        <form action="/online examination system/user/update.php" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($new_username); ?>" required>
            
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($new_email); ?>" required>

            <button type="submit">Update</button>
            <div class="error"><?php echo $error; ?></div>
        </form>
        <a href="/online examination system/user/useraccount.php" class="back-link">Back to Account</a>
    </div>

</body>
</html>
