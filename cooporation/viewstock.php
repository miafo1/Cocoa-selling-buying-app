<?php
session_start(); // Start the session

include('../includes/connection.php');
$conn = connection('cocoa');

// Ensure user is logged in and session has user_id
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$delegate_id = $_SESSION['user_id']; // Get delegate ID from session

// Fetch stocks published by the delegate's corporation
$sql = "SELECT s.id, s.picture, s.quantity, s.unit_price, s.location, s.status 
        FROM stocks s 
        JOIN corporation_delegates cd ON s.corporation_id = cd.corporation_id 
        WHERE cd.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $delegate_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Manage Published Stock</title>
    <!-- Add your CSS and JS here -->
</head>
<body>
    <h2>Manage Published Stock
    <a href="Delegeuco_dashboard.php" class="btn btn-danger float-end">Back</a>
    </h2>

    

        <div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <table class="table table-bordered">
        <thead>
            <tr>
                <th>Picture</th>
                <th>Quantity (kg)</th>
                <th>Unit Price (/kg)</th>
                <th>Location</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><img src="<?php echo $row['picture']; ?>" alt="Stock Image" width="50"></td>
                    <td><?php echo $row['quantity'] . ' kg'; ?></td>
                    <td><?php echo $row['unit_price'] . ' /kg'; ?></td>
                    <td><?php echo $row['location']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <a href="edit_stock.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a> |
                        <a href="delete_stock.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this stock?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
                </div>
            </div>
        </div>
    </div>
</div>

           
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
