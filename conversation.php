<?php
// Include database connection
include('includes/connection.php');
$conn = connection('cocoa');

// Start session to get acheteur's ID
session_start();
$acheteur_id = $_SESSION['user_id']; // Assuming user_id is stored in session when acheteur logs in

// Fetch all corporations and their delegates
$query = "
    SELECT corporations.id AS corporation_id, corporations.name AS corporation_name, corporations.address, users.id AS delegate_id, users.name AS delegate_name
    FROM corporations
    JOIN corporation_delegates ON corporations.id = corporation_delegates.corporation_id
    JOIN users ON corporation_delegates.user_id = users.id
    WHERE users.role = 'delegue_corp'
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acheteur - View Corporations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: url('images/bg-title-02.jpg') no-repeat center center fixed;
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
<?php
include 'header.php';
?>
<div class="container mt-4">
    <h1>Corporations</h1>

    <div class="row">
        <?php

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['corporation_name']; ?></h5>
                            <p class="card-text"><strong>Address:</strong> <?= $row['address']; ?></p>
                            <p class="card-text"><strong>Delegate:</strong> <?= $row['delegate_name']; ?></p>

                            <!-- Send Message Form -->
                            <form action="send_message.php" method="POST">
                                <div class="form-group">
                                    <label for="message">Message:</label>
                                    <textarea name="message" id="message" class="form-control" required></textarea>
                                </div>
                                <input type="hidden" name="acheteur_id" value="<?= $acheteur_id; ?>">
                                <input type="hidden" name="delegate_id" value="<?= $row['delegate_id']; ?>">
                                <input type="hidden" name="corporation_id" value="<?= $row['corporation_id']; ?>">
                                <button type="submit" class="btn btn-primary">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No corporations available at the moment.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
