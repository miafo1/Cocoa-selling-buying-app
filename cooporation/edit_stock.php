<?php
session_start();
include('../includes/connection.php');
$conn = connection('cocoa');

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$delegate_id = $_SESSION['user_id'];
$stock_id = $_GET['id'];

// Fetch the stock details
$sql = "SELECT * FROM stocks WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $stock_id);
$stmt->execute();
$result = $stmt->get_result();
$stock = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];
    $location = $_POST['location'];
    $status = $_POST['status'];

    // Update stock details
    $sql_update = "UPDATE stocks SET quantity = ?, unit_price = ?, location = ?, status = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("idssi", $quantity, $unit_price, $location, $status, $stock_id);
    $stmt_update->execute();
    
    echo "<p>Stock updated successfully!</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Edit Stock</title>
</head>
<body>
    <h2>Edit Stock
    <a href="viewstock.php" class="btn btn-danger float-end">Back</a>
    </h2>

    <form method="POST">
        <div>
            <label for="quantity">Quantity (kg):</label>
            <input type="number" name="quantity" id="quantity" value="<?php echo $stock['quantity']; ?>" required>
        </div>
        <div>
            <label for="unit_price">Unit Price (/kg):</label>
            <input type="text" name="unit_price" id="unit_price" value="<?php echo $stock['unit_price']; ?>" required>
        </div>
        <div>
            <label for="location">Location:</label>
            <input type="text" name="location" id="location" value="<?php echo $stock['location']; ?>" required>
        </div>
        <div>
            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="available" <?php if ($stock['status'] == 'available') echo 'selected'; ?>>Available</option>
                <option value="reserved" <?php if ($stock['status'] == 'reserved') echo 'selected'; ?>>Reserved</option>
            </select>
        </div>
        <div>
            <button type="submit">Update Stock</button>
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
