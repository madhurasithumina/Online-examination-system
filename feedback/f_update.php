<?php
// Include the config file for database connection
include 'config.php';

// Check if the ID is set in the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing feedback record
    $sql = "SELECT * FROM feedback WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    // Fetch the record as an associative array
    $feedback = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Check if feedback record exists
    if (!$feedback) {
        echo "Feedback not found.";
        exit;
    }
} else {
    echo "No ID provided.";
    exit;
}

// Update feedback record if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['comment'];

    $updateSql = "UPDATE feedback SET name = :name, email = :email, comment = :comment WHERE id = :id";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bindParam(':name', $name);
    $updateStmt->bindParam(':email', $email);
    $updateStmt->bindParam(':comment', $comment);
    $updateStmt->bindParam(':id', $id);

    if ($updateStmt->execute()) {
        // Show success message using JavaScript
        echo "<script>
                alert('Feedback updated successfully.');
                window.location.href = '/online examination system/feedback/f_read.php';
              </script>";
        exit();
    } else {
        echo "Error updating feedback.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Feedback</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: #343a40;
            margin-bottom: 20px;
        }
        form {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            display: inline-block;
            width: 400px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            text-align: left;
        }
        input, textarea {
            width: 100%;
            margin: 10px 0;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        @media (max-width: 480px) {
            form {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<h1>Update Feedback</h1>

<form method="POST" action="">
    <label for="name">Your Name</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($feedback['name']); ?>" required>
    
    <label for="email">Your Email</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($feedback['email']); ?>" required>
    
    <label for="comment">Your Comment</label>
    <textarea id="comment" name="comment" required><?php echo htmlspecialchars($feedback['comment']); ?></textarea>
    
    <input type="submit" value="Update Feedback">
</form>

</body>
</html>
