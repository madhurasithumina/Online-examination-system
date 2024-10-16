<?php
// Include the config file for database connection
include 'config.php';



// Check if the ID is set in the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the delete statement
    $sql = "DELETE FROM feedback WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to feedback list with a success message
        header("Location: /online examination system/feedback/f_read.php?message=deleted");
        exit();
    } else {
        // Fetch error information
        $errorInfo = $stmt->errorInfo();
        echo "Error deleting feedback: " . $errorInfo[2];
    }
} else {
    echo "No ID provided for deletion.";
}

// Close the connection (optional)
$conn = null;
?>
