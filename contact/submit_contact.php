<?php
// Include the config file for database connection
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Insert the data into the contacts table
    $sql = "INSERT INTO contacts (name, email, subject, message) VALUES (:name, :email, :subject, :message)";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':subject', $subject);
    $stmt->bindParam(':message', $message);

    // Execute the query
    if ($stmt->execute()) {
        // If the message is sent successfully, trigger a JavaScript alert and redirect
        echo "<script>
                alert('Message sent successfully!');
                window.location.href = '/online examination system/contact/read_contacts.php';
              </script>";
    } else {
        // In case of error, you can show an error message
        echo "<script>
                alert('Error sending message. Please try again.');
                window.history.back();
              </script>";
    }
}
?>
