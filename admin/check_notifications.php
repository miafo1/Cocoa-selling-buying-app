<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "cocoa");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Admin ID (Assuming admin has a user ID of 1)
$admin_id = 1;

// Query to count unread messages for the admin
$sql = "SELECT COUNT(*) as unread_count FROM messages WHERE recipient_id = ? AND is_read = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$unread_count = $row['unread_count'];

echo json_encode(['unread_count' => $unread_count]);

$stmt->close();
$conn->close();
?>
