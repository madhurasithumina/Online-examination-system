<?php
// Include the config file for database connection
include 'config.php';

// Check if the ID is set in the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL query to delete the exam
    $sql = "DELETE FROM exams WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Exam deleted successfully.";
    } else {
        echo "Error deleting exam.";
    }
} else {
    echo "No ID provided.";
}
?>

<a href="/online examination system/exam/exam_detail.php">Back to Exam Details</a>
