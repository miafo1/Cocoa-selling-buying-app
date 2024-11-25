<?php
// Include your database connection
include('includes/connection.php');
$conn = connection('cocoa');

// If this is an AJAX request to fetch cities based on region
if (isset($_POST['action']) && $_POST['action'] === 'fetch_cities' && isset($_POST['idregion'])) {
    $idregion = $_POST['idregion'];

    // Fetch cities for the selected region
    $query = "SELECT idcity, namcity FROM city WHERE idregion = ? AND statuscity = 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $idregion);
    $stmt->execute();
    $result = $stmt->get_result();

    $cities = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cities[] = [
                'idcity' => $row['idcity'],
                'namcity' => $row['namcity']
            ];
        }
    }
    // Return cities as JSON
    echo json_encode($cities);
    exit;
}

// If the form is submitted for registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // Handle registration form submission
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $idregion = $_POST['idregion'];
    $idcity = $_POST['idcity'];
    $address = $_POST['address'];

    // Handle permission card upload
    $permission_card = $_FILES['permission_card']['name'];
    $permission_card_tmp = $_FILES['permission_card']['tmp_name'];
    $permission_card_path = "uploads/" . $permission_card;

    // Move the uploaded file to the destination folder
    if (move_uploaded_file($permission_card_tmp, $permission_card_path)) {
        // Insert into users table
        $query = "INSERT INTO users (role, name, email, phone, password, idregion, idcity, address, permission_card) VALUES ('acheteur', ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssiiiss', $name, $email, $phone, $password, $idregion, $idcity, $address, $permission_card_path);
        
        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Registration failed: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Failed to upload permission card.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acheteur Registration</title>

    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: url('images/11.webp') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        /* Dark overlay for better readability */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Adjust opacity */
            z-index: 0;
        }

        /* Container styling */
        .container-fluid {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            width: 500px;
            max-width: 100%;
        }

        /* Form input styling */
        form {
            display: flex;
            flex-direction: column;
        }

        form label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        form input, form select {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Submit button styling */
        input[type="submit"] {
            background-color: #6b3d0c; /* Cocoa color */
            color: white;
            border: none;
            cursor: pointer;
            padding: 15px;
            font-size: 18px;
            transition: background-color 0.3s ease;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: #4e2908; /* Darker cocoa color */
        }
    </style>
   
</head>
<body>

<div class="container-fluid px-4">
    <h1>Acheteur Registration</h1>

    <form action="register_acheteur.php" method="POST" enctype="multipart/form-data">
        <div class="row">
            <!-- Other form fields (name, phone, email, etc.) -->
            <div class="col-md-6 mb-3">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" required class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required class="form-control">
            </div>

            <!-- Password -->
            <div class="col-md-6 mb-3">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required class="form-control">
            </div>

            <!-- Region -->
            <div class="col-md-6 mb-3">
                <label for="idregion">Region:</label>
                <select id="idregion" name="idregion" required class="form-control">
                    <option value="">Select Region</option>
                    <?php
                    // Fetch regions from the database
                    $query = "SELECT idregion, nameregion FROM region WHERE statusregion = 1";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['idregion']}'>{$row['nameregion']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- City -->
            <div class="col-md-6 mb-3">
                <label for="idcity">City:</label>
                <select id="idcity" name="idcity" required class="form-control">
                    <option value="">Select City</option>
                    <!-- Cities will be dynamically populated based on region selection -->
                </select>
            </div>

            <!-- Address -->
            <div class="col-md-6 mb-3">
                <label for="address">Address:</label>
                <input type="text" name="address" id="address" required class="form-control">
            </div>
			 <!-- Permission Card -->
			 <div class="col-md-6 mb-3">
                <label for="permission_card">Permission Card:</label>
                <input type="file" id="permission_card" name="permission_card" accept="image/*,application/pdf" required class="form-control">
            </div>

            <!-- Submit -->
            <div class="col-md-12 mb-3">
                <input type="submit" class="btn btn-primary" name="register" value="Register">
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#idregion').on('change', function () {
            var regionId = $(this).val();
            if (regionId) {
                $.ajax({
                    type: 'POST',
                    url: 'register_acheteur.php',
                    dataType: 'json',
                    data: {action: 'fetch_cities', idregion: regionId},
                    success: function (data) {
                        var citySelect = $('#idcity');
                        citySelect.empty();
                        citySelect.append('<option value="">Select City</option>');
                        $.each(data, function (index, city) {
                            citySelect.append('<option value="' + city.idcity + '">' + city.namcity + '</option>');
                        });
                    }
                });
            } else {
                $('#idcity').html('<option value="">Select City</option>');
            }
        });
    });
</script>

</body>
<
</html>
