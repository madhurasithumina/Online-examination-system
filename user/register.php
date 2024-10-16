<?php
require_once "config.php";

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Check if passwords match
    if ($password != $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user into the database
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);

            // Execute the query
            if ($stmt->execute()) {
                echo "<script>alert('Registration successful!'); window.location.href='/online examination system/user/login.php';</script>"; // Show success alert and redirect
                exit();
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
        unset($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('/online examination system/images/background.jpg'); /* Add your own background image */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            transition: transform 0.3s;
        }

        .form-container:hover {
            transform: scale(1.02);
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border-color 0.3s ease;
            font-family: 'Roboto', sans-serif;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #3498db;
            outline: none;
        }

        button[type="submit"] {
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
            margin-top: 15px;
        }

        button[type="submit"]:hover {
            background-color: #2980b9;
        }

        .error {
            color: #e74c3c;
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }

        @media (max-width: 600px) {
            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Create Account</h2>
        <form action="/online examination system/user/register.php" method="post" id="registerForm">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
                <span class="error-message" id="usernameError"></span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <span class="error-message" id="emailError"></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <span class="error-message" id="passwordError"></span>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <span class="error-message" id="confirmPasswordError"></span>
            </div>
            <button type="submit" id="submitBtn">Register</button>
            <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
        </form>
    </div>

    <script>
        // Real-time validation
        document.getElementById('registerForm').addEventListener('input', function (e) {
            const username = document.getElementById('username');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');

            let usernameError = '';
            let emailError = '';
            let passwordError = '';
            let confirmPasswordError = '';

            // Username validation
            if (username.value.length < 3) {
                usernameError = 'Username must be at least 3 characters long.';
                document.getElementById('usernameError').textContent = usernameError;
            } else {
                document.getElementById('usernameError').textContent = '';
            }

            // Email validation (simple regex for email format)
            const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            if (!email.value.match(emailPattern)) {
                emailError = 'Please enter a valid email address.';
                document.getElementById('emailError').textContent = emailError;
            } else {
                document.getElementById('emailError').textContent = '';
            }

            // Password validation (min length 6)
            if (password.value.length < 6) {
                passwordError = 'Password must be at least 6 characters long.';
                document.getElementById('passwordError').textContent = passwordError;
            } else {
                document.getElementById('passwordError').textContent = '';
            }

            // Confirm password validation
            if (password.value !== confirmPassword.value) {
                confirmPasswordError = 'Passwords do not match.';
                document.getElementById('confirmPasswordError').textContent = confirmPasswordError;
            } else {
                document.getElementById('confirmPasswordError').textContent = '';
            }

            // Disable submit button if there are errors
            const submitBtn = document.getElementById('submitBtn');
            if (usernameError || emailError || passwordError || confirmPasswordError) {
                submitBtn.disabled = true;
            } else {
                submitBtn.disabled = false;
            }
        });

        // Final check before submission
        document.getElementById('registerForm').addEventListener('submit', function (e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                e.preventDefault(); // Prevent form submission
                alert('Passwords do not match! Please correct and try again.');
            }
        });
    </script>

</body>
</html>
