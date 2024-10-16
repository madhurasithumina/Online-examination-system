<?php
// Include the config file for database connection
include 'config.php';

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

        td a {
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 4px;
            color: white;
            margin-right: 5px;
            transition: background-color 0.3s ease;
        }

        a.edit-btn {
            background-color: #f39c12;
        }

        a.edit-btn:hover {
            background-color: #e67e22;
        }

        a.delete-btn {
            background-color: #e74c3c;
        }

        a.delete-btn:hover {
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
</head>
<body>
    <h1>Contact Messages</h1>

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
                        <a href="/online examination system/contact/update_contact.php?id=<?php echo $contact['id']; ?>" class="edit-btn">Edit</a>
                        <a href="/online examination system/contact/delete_contact.php?id=<?php echo $contact['id']; ?>" class="delete-btn" onclick="return confirmDelete()">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="/online examination system/user_index.html" class="nav-button">Go to Home</a>

    <script>
        // Confirm delete action and show success message after deletion
        function confirmDelete() {
            const confirmed = confirm("Are you sure you want to delete this contact?");
            if (confirmed) {
                setTimeout(function() {
                    alert("Contact deleted successfully!");
                }, 500); // Delay to mimic server response
                return true;
            } else {
                return false;
            }
        }
    </script>
</body>
</html>
