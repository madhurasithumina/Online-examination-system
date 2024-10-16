<?php
include 'config.php';

$sql = "SELECT * FROM help_support";
$stmt = $conn->prepare($sql);
$stmt->execute();
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Help & Support Tickets</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tickets as $ticket): ?>
            <tr>
                <td><?= $ticket['id'] ?></td>
                <td><?= $ticket['name'] ?></td>
                <td><?= $ticket['email'] ?></td>
                <td><?= $ticket['subject'] ?></td>
                <td><?= $ticket['message'] ?></td>
                <td><?= $ticket['created_at'] ?></td>
                <td>
                    <a href="/online examination system/help/h_update.php?id=<?= $ticket['id'] ?>" class="btn-update">Edit</a> 
                    | 
                    <a href="/online examination system/help/h_delete.php?id=<?= $ticket['id'] ?>" class="btn-delete" onclick="return confirmDelete()">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Add Button to Navigate to User Index -->
<div class="navigation-button">
    <a href="/online examination system/user/user_index.html" class="btn-navigate">Go to User Dashboard</a>
</div>

<script>
function confirmDelete() {
    return confirm('Are you sure you want to delete this ticket?');
}
</script>

<!-- Updated CSS -->
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f0f8ff, #87cefa);
        margin: 0;
        padding: 20px;
    }

    h2 {
        text-align: center;
        margin-bottom: 40px;
        color: #444;
        font-size: 30px;
        font-weight: bold;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        position: relative;
        padding-bottom: 10px;
        margin-top: 0; /* Ensure h2 is aligned with the top */
    }

    h2:after {
        content: '';
        width: 50px;
        height: 3px;
        background-color: #1e90ff;
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
    }

    table {
        width: 100%;
        max-width: 1200px;
        border-collapse: collapse;
        background-color: #ffffff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
        margin-top: 20px;
        margin-left: auto;
        margin-right: auto; /* Center the table horizontally but keep it at the top */
    }

    thead {
        background: linear-gradient(135deg, #1e90ff, #00bfff);
        color: white;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    th, td {
        padding: 20px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
    }

    th {
        font-size: 14px;
        font-weight: bold;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }

    tbody tr {
        transition: background-color 0.3s ease;
    }

    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tbody tr:hover {
        background-color: rgba(30, 144, 255, 0.1);
        box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.05);
    }

    td {
        font-size: 16px;
        color: #333;
    }

    td a {
        text-decoration: none;
        padding: 10px 15px;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.3s ease;
        display: inline-block;
    }

    .btn-update {
        background-color: #28a745; /* Green */
        color: white;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-update:hover {
        background-color: #218838;
        transform: translateY(-3px);
    }

    .btn-delete {
        background-color: #dc3545; /* Red */
        color: white;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-delete:hover {
        background-color: #c82333;
        transform: translateY(-3px);
    }

    td a {
        margin-right: 10px;
    }

    /* Add Button Styling */
    .navigation-button {
        text-align: center;
        margin-top: 30px;
    }

    .btn-navigate {
        padding: 12px 20px;
        background-color: #1e90ff;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-navigate:hover {
        background-color: #007bff;
        transform: translateY(-3px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        body {
            padding: 20px;
        }

        h2 {
            font-size: 22px;
        }

        table {
            font-size: 14px;
        }

        th, td {
            padding: 15px;
        }

        td a {
            padding: 8px 12px;
        }

        .btn-navigate {
            padding: 10px 18px;
        }
    }
</style>
