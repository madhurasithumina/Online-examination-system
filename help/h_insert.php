<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $sql = "INSERT INTO help_support (name, email, subject, message) VALUES (:name, :email, :subject, :message)";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute(['name' => $name, 'email' => $email, 'subject' => $subject, 'message' => $message]);
        echo "<script>
                alert('Ticket added successfully!');
                window.location.href='/online examination system/help/h_read.php'; // Redirect after alert
              </script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>

<!-- HTML Form for inserting a ticket with enhanced styling -->
<form id="supportForm" method="post" action="">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="subject">Subject</label>
        <input type="text" id="subject" name="subject" required>
    </div>
    <div class="form-group">
        <label for="message">Message</label>
        <textarea id="message" name="message" required></textarea>
    </div>
    <button type="submit" class="btn-submit">Submit</button>
</form>

<script>
// Real-time validation for name, email, and message fields
document.getElementById('supportForm').addEventListener('submit', function(e) {
    let valid = true;
    
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const message = document.getElementById('message').value.trim();
    
    if (name.length < 3) {
        alert('Name must be at least 3 characters long.');
        valid = false;
    }
    if (!email.includes('@')) {
        alert('Please enter a valid email address.');
        valid = false;
    }
    if (message.length < 10) {
        alert('Message must be at least 10 characters long.');
        valid = false;
    }
    
    if (!valid) {
        e.preventDefault();
    }
});
</script>

<!-- Creative CSS for Form -->
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f0f0f0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    form {
        width: 60%;
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        animation: fadeIn 1s ease;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    input[type="text"], input[type="email"], textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    textarea {
        height: 100px;
    }

    .btn-submit {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        display: block;
        width: 100%;
    }

    .btn-submit:hover {
        background-color: #218838;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
