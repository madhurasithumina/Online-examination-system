<?php
// Include the config file for database connection
include 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_name = $_POST['exam_name'];
    $exam_date = $_POST['exam_date'];
    $duration = $_POST['duration'];

    // SQL query to insert the exam
    $sql = "INSERT INTO exams (exam_name, exam_date, duration) VALUES (:exam_name, :exam_date, :duration)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':exam_name', $exam_name);
    $stmt->bindParam(':exam_date', $exam_date);
    $stmt->bindParam(':duration', $duration);

    if ($stmt->execute()) {
        // On success, redirect to exam_detail.php with a success message
        echo "<script>
                alert('Exam registered successfully.');
                window.location.href = '/online examination system/exam/exam_detail.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('Error registering exam.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Exam</title>
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
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #4CAF50;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        select, input[type="date"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
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
        // Function to validate exam name and duration in real time
        function validateForm() {
            const examName = document.forms["examForm"]["exam_name"].value;
            const duration = document.forms["examForm"]["duration"].value;

            if (examName === "" || duration === "") {
                alert("Please fill in all fields.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Register Exam</h1>
        <form name="examForm" method="POST" onsubmit="return validateForm()">
            <label for="exam_name">Exam Name:</label>
            <select name="exam_name" required>
                <option value="">Select Exam</option>
                <option value="Mathematics">Mathematics</option>
                <option value="History">History</option>
                <option value="Science">Science</option>
            </select>

            <label for="exam_date">Exam Date:</label>
            <input type="date" name="exam_date" required>

            <label for="duration">Duration:</label>
            <select name="duration" required>
                <option value="">Select Duration</option>
                <option value="1h">1 Hour</option>
                <option value="1.5h">1.5 Hours</option>
                <option value="2h">2 Hours</option>
            </select>

            <input type="submit" value="Register Exam" class="submit-btn">
        </form>
        <a href="/online examination system/exam/exam_detail.php" class="back-link">Back to Exam List</a>
    </div>
</body>
</html>
