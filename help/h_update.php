<?php
include 'config.php';

$id = $_GET['id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $sql = "UPDATE help_support SET name = :name, email = :email, subject = :subject, message = :message WHERE id = :id";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute(['name' => $name, 'email' => $email, 'subject' => $subject, 'message' => $message, 'id' => $id]);
        echo "<script>alert('Ticket updated successfully!'); window.location.href='/online examination system/help/h_read.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
} else {
    $stmt = $conn->prepare("SELECT * FROM help_support WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $ticket = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<form method="post" action="">
    <label for="name">Name</label>
    <input type="text" id="name" name="name" value="<?= $ticket['name'] ?>" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?= $ticket['email'] ?>" required>

    <label for="subject">Subject</label>
    <input type="text" id="subject" name="subject" value="<?= $ticket['subject'] ?>" required>

    <label for="message">Message</label>
    <textarea id="message" name="message" required><?= $ticket['message'] ?></textarea>

    <button type="submit">Update</button>
</form>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #e0f7fa, #80deea);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    form {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        padding: 40px;
        width: 100%;
        max-width: 500px;
        transition: box-shadow 0.3s ease;
    }

    form:hover {
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }

    label {
        font-size: 14px;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
        display: block;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    input[type="text"],
    input[type="email"],
    textarea {
        width: 100%;
        padding: 12px;
        margin: 10px 0 20px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        font-size: 16px;
        transition: border 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    textarea:focus {
        border-color: #1e90ff;
        outline: none;
    }

    textarea {
        height: 150px;
        resize: none;
    }

    button {
        width: 100%;
        padding: 15px;
        background-color: #1e90ff;
        color: white;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    button:hover {
        background-color: #007bff;
        transform: translateY(-3px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        form {
            padding: 30px;
            width: 100%;
            max-width: 400px;
        }

        button {
            padding: 12px;
            font-size: 14px;
        }
    }
</style>
