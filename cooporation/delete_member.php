<?php
// Include database connection
include('db_connection.php');

// Delete member
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Remove from corporation members table
    $sql = "DELETE FROM corporation_members WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Delete the user
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    echo "Member deleted successfully!";
}
?>
