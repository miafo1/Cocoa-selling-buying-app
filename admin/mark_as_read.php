<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "cocoa");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message_id = $_POST['message_id'];

// Update message to mark it as read
$sql = "UPDATE messages SET is_read = 1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $message_id);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: manage_notifications.php");
?>
