<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "cocoa");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message_id = $_POST['message_id'];

// Delete the message
$sql = "DELETE FROM messages WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $message_id);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: manage_notifications.php");
?>
