<?php
// Start the session and include the database connection
session_start();
include('../includes/connection.php');
$con = connection('cocoa');

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $corporation_id = $_GET['id'];

    // Fetch the corporation details
    $query = "SELECT c.id, c.name, c.address, c.idcity, ci.namcity, cd.user_id as delegate_id
              FROM corporations c
              JOIN city ci ON ci.idcity = c.idcity
              LEFT JOIN corporation_delegates cd ON cd.corporation_id = c.id
              WHERE c.id = '$corporation_id'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $corporation = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['message'] = "No corporation found with the provided ID.";
        header("Location: manage_corporation.php");
        exit(0);
    }
} else {
    $_SESSION['message'] = "No ID provided.";
    header("Location: manage_corporation.php");
    exit(0);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Corporation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    
    <style>
        .container { margin-top:40px; padding:20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Corporation</h2>
        <?php include('../message.php'); ?>
        <form action="../code.php" method="POST">
            <input type="hidden" name="corporation_id" value="<?= $corporation['id']; ?>">
            <div class="form-group">
                <label for="corporation_name">Corporation Name</label>
                <input type="text" name="corporation_name" class="form-control" value="<?= $corporation['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="corporation_address">Address</label>
                <input type="text" name="corporation_address" class="form-control" value="<?= $corporation['address']; ?>" required>
            </div>
            <div class="form-group">
                <label for="idcity">City</label>
                <select name="idcity" class="form-control" required>
                    <?php
                    // Fetch all cities
                    $city_query = "SELECT * FROM city";
                    $city_result = mysqli_query($con, $city_query);
                    while ($city = mysqli_fetch_assoc($city_result)) {
                        $selected = ($city['idcity'] == $corporation['idcity']) ? 'selected' : '';
                        echo "<option value='{$city['idcity']}' $selected>{$city['namcity']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="delegate_id">Delegate</label>
                <select name="delegate_id" class="form-control" required>
                    <?php
                    // Fetch all users who could be delegates (excluding the current one)
                    $delegate_query = "SELECT id, name FROM users WHERE role IN ('delegue_corp', 'admin')";
                    $delegate_result = mysqli_query($con, $delegate_query);
                    while ($delegate = mysqli_fetch_assoc($delegate_result)) {
                        $selected = ($delegate['id'] == $corporation['delegate_id']) ? 'selected' : '';
                        echo "<option value='{$delegate['id']}' $selected>{$delegate['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="update_corporation_btn" class="btn btn-primary">Update Corporation</button>
            <a href="manage_corporations.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
