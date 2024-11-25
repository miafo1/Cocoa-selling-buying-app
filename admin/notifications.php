<?php
include('../includes/connection.php');
$con = connection('cocoa');
// Fetch messages for the admin
$sql = "SELECT * FROM messages WHERE recipient_id = ? ORDER BY sent_at DESC";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo "<div class='message'>";
    echo "<p><strong>Message from User " . $row['sender_id'] . ":</strong></p>";
    echo "<p>" . $row['message'] . "</p>";
    echo "<p>Sent on: " . $row['sent_at'] . "</p>";
    echo "<a href='reply.php?message_id=" . $row['id'] . "'>Reply</a> | ";
    echo "<a href='delete.php?message_id=" . $row['id'] . "'>Delete</a>";
    echo "</div>";
}

// Mark all messages as read
$update_sql = "UPDATE messages SET is_read = 1 WHERE recipient_id = ?";
$update_stmt = $con->prepare($update_sql);
$update_stmt->bind_param("i", $admin_id);
$update_stmt->execute();
?>
