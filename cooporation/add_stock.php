<?php
session_start(); // Start the session

include('../includes/connection.php');
$conn = connection('cocoa');

// Ensure user is logged in and session has user_id
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$delegate_id = $_SESSION['user_id']; // Get delegate ID from session

// Fetch corporation delegate's corporation
$sql_corp = "SELECT corporation_id FROM corporation_delegates WHERE user_id = ?";
$stmt_corp = $conn->prepare($sql_corp);
if (!$stmt_corp) {
    die("Error preparing query: " . $conn->error);
}

$stmt_corp->bind_param("i", $delegate_id);
if (!$stmt_corp->execute()) {
    die("Error executing query: " . $stmt_corp->error);
}

$result_corp = $stmt_corp->get_result();
if (!$result_corp) {
    die("Error fetching results: " . $stmt_corp->error);
}

$corporation = $result_corp->fetch_assoc();
if (!$corporation) {
    die("Corporation not found for delegate ID: " . $delegate_id);
}

$corporation_id = $corporation['corporation_id']; // Successfully retrieved corporation ID

// Handle form submission for adding stock
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $picture = $_FILES['picture']['name'];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($picture);
    if (!move_uploaded_file($_FILES['picture']['tmp_name'], $target_file)) {
        die("Error uploading the picture.");
    }

    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];
    $location = $_POST['location'];
    $status = $_POST['status'];  // Get the selected status from the form

    $stmt = $conn->prepare("INSERT INTO stocks (corporation_id, picture, quantity, unit_price, location, status) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error preparing insert query: " . $conn->error);
    }

    $stmt->bind_param("isidss", $corporation_id, $target_file, $quantity, $unit_price, $location, $status);
    if ($stmt->execute()) {
        echo "<p>Stock added successfully!</p>";
    } else {
        echo "Error adding stock: " . $stmt->error;
    }

    $stmt->close();
}

$stmt_corp->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajout stock</title>
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style type="text/css">
        .container {
            margin-top: 40px;
            padding: 20px;
        }
        #img_box {
            background-image: url('images/default_avatar_0.png'); 
            background-size: 100%;
            background-repeat: no-repeat;
            background-color: #ddd;
            height: 150px; 
            width: 150px;
        }
    </style>
    <script type="text/javascript">
        $(function() {
            $('#img_box').click(function() {
                $('#picture').click();
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#img_box').css({'background-image': 'url(' + e.target.result + ')'});
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</head>
<body>
<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Stock
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
                        <a href="viewstock.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <!-- Image Upload -->
                        <div class="form-group">
                            <div id="img_box" class="rounded float-right border"></div>
                            <label for="picture">Picture:</label>
                            <input type="file" name="picture" id="picture" required onchange="readURL(this);">
                        </div>

                        <!-- Quantity -->
                        <div class="col-md-6 mb-3">
                            <label for="quantity">Quantity:</label>
                            <input type="number" name="quantity" id="quantity" required class="form-control">
                        </div>

                        <!-- Unit Price -->
                        <div class="col-md-6 mb-3">
                            <label for="unit_price">Unit Price:</label>
                            <input type="text" name="unit_price" id="unit_price" required class="form-control">
                        </div>

                        <!-- Location -->
                        <div class="col-md-6 mb-3">
                            <label for="location">Location:</label>
                            <input type="text" name="location" id="location" required class="form-control">
                        </div>

                        <!-- Stock Status Dropdown -->
                        <div class="col-md-6 mb-3">
                            <label for="status">Status:</label>
                            <select name="status" id="status" required class="form-control">
                                <option value="available">Available</option>
                                <option value="reserved">Reserved</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-primary">Publish Stock</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
