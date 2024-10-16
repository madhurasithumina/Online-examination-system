<?php
// Include the config file for database connection
include 'config.php';

// Check if the ID is set in the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing exam record
    $sql = "SELECT * FROM exams WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $exam = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if exam record exists
    if (!$exam) {
        echo "Exam not found.";
        exit;
    }
}

// Update exam record if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_name = $_POST['exam_name'];
    $exam_date = $_POST['exam_date'];
    $duration = $_POST['duration'];

    $updateSql = "UPDATE exams SET exam_name = :exam_name, exam_date = :exam_date, duration = :duration WHERE id = :id";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bindParam(':exam_name', $exam_name);
    $updateStmt->bindParam(':exam_date', $exam_date);
    $updateStmt->bindParam(':duration', $duration);
    $updateStmt->bindParam(':id', $id);

    if ($updateStmt->execute()) {
        // Return success response to be handled by JavaScript
        echo "<script>
                window.onload = function() {
                    showPopup('Exam updated successfully!');
                }
              </script>";
    } else {
        echo "<script>alert('Error updating exam.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Exam</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        select, input[type="date"], input[type="submit"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
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

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            color: #007BFF;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        // Function to show success popup
        function showPopup(message) {
            const popup = document.getElementById('popup');
            popup.querySelector('p').innerText = message;
            popup.style.display = 'block';
        }

        // Function to close the popup and redirect to exam_detail.php
        function closePopup() {
            const popup = document.getElementById('popup');
            popup.style.display = 'none';
            // Redirect to the exam details page
            window.location.href = '/online examination system/exam/exam_detail.php';
        }
    </script>
</head>
<body>

<div class="container">
    <h1>Update Exam</h1>
    <form method="POST">
        <label for="exam_name">Exam Name:</label>
        <select name="exam_name" required>
            <option value="Mathematics" <?php if ($exam['exam_name'] == 'Mathematics') echo 'selected'; ?>>Mathematics</option>
            <option value="Science" <?php if ($exam['exam_name'] == 'Science') echo 'selected'; ?>>Science</option>
            <option value="History" <?php if ($exam['exam_name'] == 'History') echo 'selected'; ?>>History</option>
        </select>

        <label for="exam_date">Exam Date:</label>
        <input type="date" name="exam_date" value="<?php echo htmlspecialchars($exam['exam_date']); ?>" required>

        <label for="duration">Duration:</label>
        <select name="duration" required>
            <option value="1h" <?php if ($exam['duration'] == '1h') echo 'selected'; ?>>1 Hour</option>
            <option value="1.5h" <?php if ($exam['duration'] == '1.5h') echo 'selected'; ?>>1.5 Hours</option>
            <option value="2h" <?php if ($exam['duration'] == '2h') echo 'selected'; ?>>2 Hours</option>
        </select>

        <input type="submit" value="Update Exam">
    </form>
    <a href="/online examination system/exam/exam_detail.php" class="back-link">Back to Exam List</a>
</div>

<!-- Popup for success message -->
<div id="popup" class="popup">
    <p>Exam updated successfully!</p>
    <button onclick="closePopup()">OK</button>
</div>

</body>
</html>
