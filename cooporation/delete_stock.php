<?php
session_start();
include('../includes/connection.php');
$conn = connection('cocoa');

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$stock_id = $_GET['id'];

// Delete the stock
$sql = "DELETE FROM stocks WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $stock_id);
$stmt->execute();

echo "<p>Stock deleted successfully.</p>";
header('Location: manage_stocks.php'); // Redirect back to manage stocks page
?>

<?php
$stmt->close();
$conn->close();
?>
