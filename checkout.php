<?php
session_start();
include('includes/connection.php');
$con = connection('cocoa');

if (isset($_POST['order_btn'])) {
    if (!isset($_SESSION['user_id'])) {
        die('User not logged in.');
    }

    $acheteur_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $city = $_POST['city'];
    $country = $_POST['country'];

    // Verify that the acheteur_id exists in users table
    $user_check = mysqli_query($con, "SELECT id FROM users WHERE id = '$acheteur_id'");
    if (mysqli_num_rows($user_check) == 0) {
        die('Invalid user ID.');
    }

    // Fetch items from cart
    $cart_query = mysqli_query($con, "SELECT * FROM cart");
    $total_price = 0;
    $reserved_stocks = [];

    if (mysqli_num_rows($cart_query) > 0) {
        while ($product_item = mysqli_fetch_assoc($cart_query)) {
            $total_price += 5000; // Assume price is fixed per item for now
            $reserved_stocks[] = $product_item; // Storing reserved items
        }
    }

    // Insert the transaction into the `transactions` table
    $detail_query = mysqli_query($con, "INSERT INTO transactions (name, email, phonenumber, city, country, acheteur_id) VALUES('$name', '$email', '$telephone', '$city', '$country', '$acheteur_id')") or die('query failed');
    $transaction_id = mysqli_insert_id($con); // Get transaction ID

    // Mark stocks as 'reserved' and send message to corporation
    foreach ($reserved_stocks as $stock) {
      $stock_id = $stock['id'];
  
      // Query to get the corporation_id
      $corporation_id_query = mysqli_query($con, "SELECT corporation_id FROM stocks WHERE id = '$stock_id'");
      if (!$corporation_id_query) {
          die('Query failed: ' . mysqli_error($con));
      }
  
      $corporation_id_row = mysqli_fetch_assoc($corporation_id_query);
      if ($corporation_id_row && isset($corporation_id_row['corporation_id'])) {
          $corporation_id = $corporation_id_row['corporation_id'];
      } else {
          die('Corporation ID not found for stock ID ' . $stock_id);
      }
  
      // Update stock status to 'reserved'
      mysqli_query($con, "UPDATE stocks SET status = 'reserved' WHERE id = '$stock_id'");
  
      // Send a message to the corporation
      $message = "A stock has been reserved by $name ($email, $telephone). Please prepare the stock for delivery.";
      mysqli_query($con, "INSERT INTO messages (sender_id, recipient_id, message) VALUES ('$acheteur_id', '$corporation_id', '$message')");
  }
  
    // Clear the cart after reservation
    mysqli_query($con, "DELETE FROM cart");

    // Confirmation message
    echo "
    <div class='order-message-container'>
        <div class='message-container'>
            <h3>Thank you for reserving!</h3>
            <div class='order-detail'></div>
            <div class='customer-details'>
                <p>Your name: <span>$name</span></p>
                <p>Your email: <span>$email</span></p>
                <p>Your phone: <span>$telephone</span></p>
                <p>Your address: <span>$city, $country</span></p>
                <p>(*You will be contacted soon*)</p>
            </div>
            <a href='view_stock.php' class='btn'>Continue Reserving</a>
        </div>
    </div>
    ";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .heading {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .checkout-form {
            margin: 0 auto;
            max-width: 800px;
        }

        .display-order {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .display-order span {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        .flex {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .inputBox {
            flex: 1 1 45%;
            margin-bottom: 20px;
        }

        .inputBox span {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .inputBox input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #2ecc71;
            color: #fff;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #27ae60;
        }

        .order-message-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .message-container {
            max-width: 600px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        .order-detail, .customer-details {
            margin-bottom: 20px;
        }

        .customer-details p {
            margin: 10px 0;
        }

        .customer-details span {
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

    <section class="checkout-form">
        <h1 class="heading">Complete Your Order</h1>

        <form action="" method="post">
            <div class="display-order">
                <?php
                $select_cart = mysqli_query($con, "SELECT * FROM cart");
                if (mysqli_num_rows($select_cart) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                ?>
                <span><?= $fetch_cart['descriptionland']; ?> (<?= $fetch_cart['location']; ?>)</span>
                <?php
                    }
                } else {
                    echo "<div class='display-order'><span>Your cart is empty!</span></div>";
                }
                ?>
            </div>

            <div class="flex">
                <div class="inputBox">
                    <span>Your Name</span>
                    <input type="text" placeholder="Enter your name" name="name" required>
                </div>
                <div class="inputBox">
                    <span>Your Email</span>
                    <input type="email" placeholder="Enter your email" name="email" required>
                </div>
                <div class="inputBox">
                    <span>Telephone</span>
                    <input type="tel" placeholder="e.g. 671343867" name="telephone" required>
                </div>
                <div class="inputBox">
                    <span>City</span>
                    <input type="text" placeholder="e.g. Yaoundé" name="city" required>
                </div>
                <div class="inputBox">
                    <span>Country</span>
                    <input type="text" placeholder="e.g. Cameroon" name="country" required>
                </div>
            </div>

            <input type="submit" value="Order Now" name="order_btn" class="btn">
        </form>
    </section>

</div>

<!-- Custom JS File Link -->
<script src="script.js"></script>

</body>
</html>
