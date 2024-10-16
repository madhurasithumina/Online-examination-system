<?php
// Include the config file for database connection
include 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];

    $sql = "INSERT INTO feedback (name, email, comment) VALUES (:name, :email, :comment)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':comment', $comment);

    if ($stmt->execute()) {
        $message = "Feedback submitted successfully!";
    } else {
        $message = "Error: " . $stmt->errorInfo()[2];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function showPopupAndRedirect(message) {
            alert(message);  // Show success message in a popup
            window.location.href = '/online examination system/feedback/f_read.php';  // Redirect to f_read.php after submission
        }

        <?php if (!empty($message)): ?>
        window.onload = function() {
            showPopupAndRedirect('<?php echo $message; ?>');
        };
        <?php endif; ?>
    </script>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: url('/online examination system/images/background.jpg') no-repeat center center fixed;
    background-size: cover;
}

.feedback-form-container {
    width: 50%;
    margin: 100px auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

h1 {
    text-align: center;
    color: #333;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    margin-bottom: 10px;
    font-weight: bold;
    color: #333;
}

input[type="text"],
input[type="email"],
textarea {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

textarea {
    height: 100px;
    resize: none;
}

.submit-btn {
    background-color: #28a745;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

.submit-btn:hover {
    background-color: #218838;
}
</style>
</head>
<body>
    <div class="feedback-form-container">
        <h1>Submit Your Feedback</h1>
        <form method="POST" action="">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required><br>

            <label for="comment">Comment:</label>
            <textarea name="comment" id="comment" required></textarea><br>

            <input type="submit" value="Submit Feedback" class="submit-btn">
        </form>
    </div>
</body>
</html>
