<?php
// Include the config file for database connection
include 'config.php';

// Handle delete action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['id'])) {
    $contactId = $_POST['id'];

    $deleteSql = "DELETE FROM contacts WHERE id = :id";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bindParam(':id', $contactId, PDO::PARAM_INT);

    if ($deleteStmt->execute()) {
        $message = "Contact deleted successfully.";
    } else {
        $message = "Failed to delete contact.";
    }
}

// Fetch all contacts from the database
$sql = "SELECT * FROM contacts ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contacts</title>
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

        table {
            width: 80%;
            margin: 40px auto;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 10px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td {
            color: #555;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        .nav-button {
            display: block;
            width: 200px;
            margin: 40px auto;
            padding: 10px;
            text-align: center;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .nav-button:hover {
            background-color: #0056b3;
        }

        @media only screen and (max-width: 768px) {
            table {
                width: 100%;
            }

            th, td {
                padding: 10px;
                font-size: 14px;
            }

            h1 {
                font-size: 2em;
            }
        }
    </style>
    <script>
        // Confirm delete action
        function confirmDelete() {
            return confirm("Are you sure you want to delete this contact?");
        }
    </script>
</head>
<body>
    <h1>Contact Messages</h1>

    <?php if (isset($message)): ?>
        <script>alert('<?php echo $message; ?>');</script>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?php echo htmlspecialchars($contact['id']); ?></td>
                    <td><?php echo htmlspecialchars($contact['name']); ?></td>
                    <td><?php echo htmlspecialchars($contact['email']); ?></td>
                    <td><?php echo htmlspecialchars($contact['subject']); ?></td>
                    <td><?php echo htmlspecialchars($contact['message']); ?></td>
                    <td>
                        <form action="" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="delete-btn" onclick="return confirmDelete()">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="/online examination system/admin/admin_dashboard.html" class="nav-button">Go to Dashboard</a>
</body>
</html>
