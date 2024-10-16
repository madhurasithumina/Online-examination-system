<?php
// Include the config file for database connection
include 'config.php';

// Fetch exams from the database
$sql = "SELECT * FROM exams";
$stmt = $conn->prepare($sql);
$stmt->execute();
$exams = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #4CAF50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .btn {
            padding: 8px 16px;
            font-size: 14px;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
        }

        .btn-edit {
            background-color: #007BFF;
            color: white;
        }

        .btn-edit:hover {
            background-color: #0056b3;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        a {
            text-decoration: none;
        }

        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 1px solid #ccc;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            z-index: 1000;
            border-radius: 5px;
        }

        .popup p {
            margin: 0;
            font-size: 16px;
            color: #4CAF50;
        }

        .popup button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            margin-top: 10px;
            border-radius: 5px;
        }

        .popup button:hover {
            background-color: #45a049;
        }

        .btn-dashboard {
            display: block;
            width: 200px;
            margin: 30px auto;
            text-align: center;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-dashboard:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        // Function to show success popup
        function showPopup(message) {
            const popup = document.getElementById('popup');
            popup.querySelector('p').innerText = message;
            popup.style.display = 'block';
        }

        // Function to close the popup
        function closePopup() {
            const popup = document.getElementById('popup');
            popup.style.display = 'none';
            // Optionally, refresh the page or redirect
            location.reload();
        }

        // Function to handle delete confirmation and display popup
        function confirmDelete(examId) {
            if (confirm("Are you sure you want to delete this exam?")) {
                // Redirect to delete script, passing the exam ID
                window.location.href = "/online examination system/exam/exam_delete.php?id=" + examId;
                // Show popup message after redirection
                showPopup('Exam deleted successfully.');
                return false; // Prevent default anchor behavior
            }
            return false; // Cancel delete
        }
    </script>
</head>
<body>
    <h1>Exam Details</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Exam Name</th>
                <th>Date</th>
                <th>Duration</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($exams as $exam): ?>
                <tr>
                    <td><?php echo htmlspecialchars($exam['id']); ?></td>
                    <td><?php echo htmlspecialchars($exam['exam_name']); ?></td>
                    <td><?php echo htmlspecialchars($exam['exam_date']); ?></td>
                    <td><?php echo htmlspecialchars($exam['duration']); ?></td>
                    <td><?php echo htmlspecialchars($exam['status']); ?></td>
                    <td>
                        <a href="/online examination system/exam/exam_update.php?id=<?php echo $exam['id']; ?>" class="btn btn-edit">Edit</a>
                        <a href="/online examination system/exam/exam_delete.php?id=<?php echo $exam['id']; ?>" class="btn btn-delete" onclick="return confirmDelete(<?php echo $exam['id']; ?>)">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Popup for delete confirmation -->
    <div id="popup" class="popup">
        <p>Exam deleted successfully.</p>
        <button onclick="closePopup()">OK</button>
    </div>

    <!-- Button to navigate to exam dashboard -->
    <a href="/online examination system/ex_dashboard/exam_dashboard.html" class="btn-dashboard">Go to Dashboard</a>
</body>
</html>
