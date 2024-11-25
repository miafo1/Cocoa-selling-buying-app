<?php
// Include database connection
include('../includes/connection.php');
$conn = connection('cocoa');

// Get delegate's corporation ID
session_start();
$delegate_id = $_SESSION['user_id'];
$sql = "SELECT corporation_id FROM corporation_delegates WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $delegate_id);
$stmt->execute();
$result = $stmt->get_result();
$corporation = $result->fetch_assoc();
$corporation_id = $corporation['corporation_id'];

// Fetch all members of the delegate's corporation
$sql = "SELECT u.id, u.name, u.email FROM users u 
        JOIN corporation_members cm ON u.id = cm.user_id
        WHERE cm.corporation_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $corporation_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<table>";
echo "<tr><th>Name</th><th>Email</th><th>Actions</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td>
                <a href='update_member.php?id={$row['id']}'>Update</a>
                <a href='delete_member.php?id={$row['id']}'>Delete</a>
            </td>
          </tr>";
}
echo "</table>";
?>
