<?php
// Include the config file for database connection
include 'config.php';

// Get the contact ID from the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the contact record
    $sql = "SELECT * FROM contacts WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    // If form is submitted, update the record
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        $updateSql = "UPDATE contacts SET name = :name, email = :email, subject = :subject, message = :message WHERE id = :id";
        $updateStmt = $conn->prepare($updateSql);

        // Bind parameters
        $updateStmt->bindParam(':name', $name);
        $updateStmt->bindParam(':email', $email);
        $updateStmt->bindParam(':subject', $subject);
        $updateStmt->bindParam(':message', $message);
        $updateStmt->bindParam(':id', $id);

        // Execute the query
        if ($updateStmt->execute()) {
            echo "<script>
                    alert('Contact updated successfully!');
                    window.location.href = '/online examination system/contact/read_contacts.php';
                  </script>";
        } else {
            echo "<script>alert('Error updating contact.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
            font-size: 2.5em;
        }

        form {
            width: 50%;
            margin: 40px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        @media only screen and (max-width: 768px) {
            form {
                width: 90%;
            }

            h1 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <h1>Update Contact</h1>
    <form method="POST">
        <input type="text" name="name" value="<?php echo htmlspecialchars($contact['name']); ?>" required>
        <input type="email" name="email" value="<?php echo htmlspecialchars($contact['email']); ?>" required>
        <input type="text" name="subject" value="<?php echo htmlspecialchars($contact['subject']); ?>" required>
        <textarea name="message" required><?php echo htmlspecialchars($contact['message']); ?></textarea>
        <button type="submit">Update Contact</button>
    </form>
</body>
</html>
