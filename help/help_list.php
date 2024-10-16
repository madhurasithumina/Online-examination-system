<?php
// Include the config file for database connection
include 'config.php';

// Fetch help tickets from the database
$sql = "SELECT * FROM help_support";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Check if there are any rows returned
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle delete action if triggered
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $ticketId = $_GET['id'];

    $deleteSql = "DELETE FROM help_support WHERE id = :id";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bindParam(':id', $ticketId, PDO::PARAM_INT);

    if ($deleteStmt->execute()) {
        header("Location:/online examination system/help/h_delete.php?message=deleted");
        exit();
    } else {
        $error = "Failed to delete the ticket.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Tickets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-top: 30px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .btn-back {
            background-color: #007bff;
            margin-top: 20px;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        // Function to show alert messages
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body>

    <h1>Help Tickets</h1>

    <?php if (isset($_GET['message']) && $_GET['message'] === 'deleted'): ?>
        <script>showAlert('Ticket deleted successfully.');</script>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (count($tickets) > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($tickets as $ticket): ?>
            <tr>
                <td><?php echo htmlspecialchars($ticket['id']); ?></td>
                <td><?php echo htmlspecialchars($ticket['name']); ?></td>
                <td><?php echo htmlspecialchars($ticket['email']); ?></td>
                <td><?php echo htmlspecialchars($ticket['subject']); ?></td>
                <td><?php echo htmlspecialchars($ticket['message']); ?></td>
                <td>
                    <!-- Delete button -->
                    <form action="" method="GET" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $ticket['id']; ?>">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit" class="btn btn-delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No help tickets found</p>
    <?php endif; ?>

    <!-- Back to Main Menu Button -->
    <form action="/online examination system/admin/admin_dashboard.html" method="GET" style="margin-top: 20px;">
        <button type="submit" class="btn btn-back">Back to Dashboard</button>
    </form>

</body>
</html>
