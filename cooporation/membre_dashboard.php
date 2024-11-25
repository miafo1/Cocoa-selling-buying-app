<?php
session_start();
include('../includes/connection.php');
$con = connection('cocoa');

// Check if the user ID is set in the session
if (!isset($_SESSION['user_id'])) {
    die("User not logged in!");
}

// Fetch files and videos sent by Formateur for the corporation member
$user_id = $_SESSION['user_id'];
$query = "
    SELECT * 
    FROM formateur_resources 
    WHERE formateur_id IN (
        SELECT user_id 
        FROM corporation_members 
        WHERE user_id = '$user_id'
    )";

$result = mysqli_query($con, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($con));
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background: #f4f4f4;
        }
        .container {
            margin-top: 50px;
        }
        .resource-card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: 0.3s;
            margin-bottom: 30px;
        }
        .resource-card:hover {
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        .resource-card img {
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center">Welcome, Corporation Member</h1>
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="col-md-4">
            <div class="card resource-card">
                <?php if ($row['resource_type'] == 'video'): ?>
                    <video width="100%" controls>
                        <source src="<?php echo $row['resource_path']; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php else: ?>
                    <img src="images/file_placeholder.png" alt="File">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['description']; ?></h5>
                        <a href="<?php echo $row['resource_path']; ?>" download class="btn btn-primary">Download File</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>
