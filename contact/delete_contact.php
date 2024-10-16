<?php
// Include the config file for database connection
include 'config.php';

// Check if the ID is set in the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the contact record
    $sql = "DELETE FROM contacts WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    // Execute the query
    if ($stmt->execute()) {
        echo "Contact deleted successfully!";
    } else {
        echo "Error deleting contact.";
    }
}
?>
