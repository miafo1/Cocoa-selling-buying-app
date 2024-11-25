<?php
// send_message.php

include('includes/connection.php');
$con = connection('cocoa');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stock_id = $_POST['stock_id'];
    $recipient_id = $_POST['recipient_id'];
    $message = $_POST['message'];

    // Assuming the sender is the current logged-in user
    // Replace this with the session-based user ID if authentication is active
    $sender_id = $_SESSION['user_id'];

    // Insert the message into the database
    $insert_message = mysqli_query($con, "INSERT INTO messages (sender_id, recipient_id, message, sent_at) VALUES ('$sender_id', '$recipient_id', '$message', NOW())");

    if ($insert_message) {
        // Redirect or show success message
        echo "Message sent successfully!";
        header('Location: view_stock.php?stock_id=' . $stock_id);
    } else {
        echo "Failed to send message!";
    }
}
?>
