<?php
include 'config.php';

$id = $_GET['id'];

$sql = "DELETE FROM help_support WHERE id = :id";
$stmt = $conn->prepare($sql);

try {
    $stmt->execute(['id' => $id]);
    echo "<script>alert('Ticket deleted successfully!'); window.location.href = '/online examination system/help/h_read.php';</script>";
} catch (PDOException $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
}
?>
