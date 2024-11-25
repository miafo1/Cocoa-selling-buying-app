<?php
session_start(); 
// Database connection
include('../includes/connection.php');
$conn = connection('cocoa');

// Check if delegate is logged in
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access. Please log in as a delegate.");
}

$delegate_id = $_SESSION['user_id'];

// Fetch the corporation ID for the logged-in delegate
$sql = "SELECT corporation_id FROM corporation_delegates WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $delegate_id);
$stmt->execute();
$result = $stmt->get_result();
$corporation = $result->fetch_assoc();

// Check if a corporation was found for this delegate
if (!$corporation) {
    die("No corporation found for this delegate.");
}

$corporation_id = $corporation['corporation_id'];

// Fetch all members of the delegate's corporation
$sql = "SELECT u.id, u.name, u.email FROM users u 
        JOIN corporation_members cm ON u.id = cm.user_id
        WHERE cm.corporation_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $corporation_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Members</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>MODIFIER MEMBERS
                        <a href="Delegeuco_dashboard.php" class="btn btn-danger float-end">Retour</a>
						<a href="add_member.php" class="btn btn-danger float-end">Ajouter</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr><th>Name</th><th>Email</th><th>Actions</th></tr>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td>
                                    <a href='update_member.php?id=<?php echo $row['id']; ?>' class="btn btn-warning">Update</a>
                                    <a href='delete_member.php?id=<?php echo $row['id']; ?>' class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
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
