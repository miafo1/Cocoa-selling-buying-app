<?php
session_start();
include('../includes/connection.php');
$conn = connection('cocoa');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in.");
}

$delegate_id = $_SESSION['user_id']; // Assuming delegate's user ID is stored in the session

// Query to fetch corporation_id
$sql = "SELECT corporation_id FROM corporation_delegates WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $delegate_id);

if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}

$result = $stmt->get_result();
$corporation = $result->fetch_assoc();

// Check if a corporation is found for the delegate
if (!$corporation) {
    die("Error: No corporation found for the delegate.");
}

$corporation_id = $corporation['corporation_id']; // Dynamically fetched corporation ID

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $idregion = $_POST['idregion'];
    $city_id = $_POST['idcity'];
    $image_name = null;

    // Check if an image was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $image_name = time() . '_' . $image['name']; // Unique name
        $image_path = '../uploads/' . $image_name;
        
        // Move the image to the desired folder
        if (!move_uploaded_file($image['tmp_name'], $image_path)) {
            die("Error uploading the image.");
        }
    }

    // Insert new member user
    $sql = "INSERT INTO users (name, email, phone, password, role, idregion, idcity, photo) 
            VALUES (?, ?, ?, ?, 'membre_corp', ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiiis", $name, $email, $phone, $password, $idregion, $city_id, $image_name);

    if ($stmt->execute()) {
        // Get the new user's ID
        $new_user_id = $stmt->insert_id;

        // Add the user as a member of the corporation
        $sql = "INSERT INTO corporation_members (corporation_id, user_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $corporation_id, $new_user_id);
        
        if ($stmt->execute()) {
            echo "Member added successfully!";
        } else {
            echo "Error adding member to the corporation: " . $stmt->error;
        }
    } else {
        echo "Error adding user: " . $stmt->error;
    }
}
?>


<!DOCTYPE html>
<html>
<head>
<title>Cocoa|web</title>
    <!-- Stylesheets and scripts as before -->
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	
	<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		
	<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	
	<link href="./Carousel Template for Bootstrap_files/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./Carousel Template for Bootstrap_files/carousel.css" rel="stylesheet">
	
	<!-- fontawesome CDN -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	
	<style type="text/css" rel="stylesheet" >
		.container
		{
			margin-top:40px;
			padding:20px;
		}
		#img_box
		{
			background-image: url('images/default_avatar_0.png'); 
			background-size: 100%;
			background-repeat: no-repeat;
			background-color:#ddd;
			height:150px; 
			width:150px;
		}
		#exit
		{
				width:140px;
		}
	
	</style>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	
	
	
	<script type="text/javascript">
		$(function(){
			$('#img_box').click(function(){
				$('#s_image').click();
					console.log($('#s_image').val());
			});
		});
		function readURL(input) {
					if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
						$('#img_box')
							.css({'background-image':'url('+ e.target.result+')'});
					};

					reader.readAsDataURL(input.files[0]);
				}
			}
	</script>
    <script>
        // Ensure image upload preview works as expected
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('img_box').style.backgroundImage = 'url(' + e.target.result + ')';
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
                    <h4>Add Member to Corporation
                    <a href="view_members.php" class="btn btn-danger float-end">Retour</a>
                    </h4>

                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <!-- Image upload section -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="img_box" class="rounded float-right border"></div>
                                    <input type="file" name="image" id="s_image" style="display:none;" onchange="readURL(this);">
                                </div>
                            </div>
                        </div>

                        <!-- Member Details Form -->
                        <div class="col-md-6 mb-3">
                            <label for="name">Member Name</label>
                            <input type="text" name="name" class="form-control" required />
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control" required />
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" required />
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" required />
                        </div>

                        <!-- Region Dropdown -->
                            <div class="col-md-6 mb-3">
                                <label for="idregion">Select Region</label>
                                <select name="idregion" class="form-control" required>
                                    <option value="">Select a region</option>
                                    <?php
                                    // Query to fetch regions dynamically
                                    $region_query = "SELECT * FROM region WHERE statusregion='0'";
                                    $region_result = mysqli_query($conn, $region_query);
                                    if ($region_result) {
                                        while ($region = mysqli_fetch_assoc($region_result)) {
                                            echo "<option value='{$region['idregion']}'>{$region['nameregion']}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>


                        <!-- City Dropdown -->
                        <div class="col-md-6 mb-3">
                            <label for="idcity">Select City</label>
                            <select name="idcity" class="form-control" required>
                                <option value="">Select a city</option>
                                <?php
                                // Query to fetch cities dynamically
                                $city_query = "SELECT * FROM city WHERE statuscity='0'";
                                $city_result = mysqli_query($conn, $city_query);
                                if ($city_result) {
                                    while ($city = mysqli_fetch_assoc($city_result)) {
                                        echo "<option value='{$city['idcity']}'>{$city['namcity']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-primary">Add Member</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Trigger -->
<script>
    document.getElementById('img_box').addEventListener('click', function() {
        document.getElementById('s_image').click();
    });
</script>
</body>
</html>
