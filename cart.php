<?php
session_start();
include('includes/connection.php');
$con = connection('cocoa');

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($con, "DELETE FROM cart WHERE id = '$remove_id'");
    header('location:cart.php');
}

if (isset($_GET['delete_all'])) {
    mysqli_query($con, "DELETE FROM cart");
    header('location:cart.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>

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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f4f4f4;
        }

        table img {
            border-radius: 5px;
        }

        .delete-btn {
            color: #e74c3c;
            text-decoration: none;
        }

        .delete-btn:hover {
            color: #c0392b;
        }

        .table-bottom {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .option-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .option-btn:hover {
            background-color: #2980b9;
        }

        .checkout-btn {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2ecc71;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

    <section class="shopping-cart">
        <h1 class="heading">Shopping Cart</h1>

        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Location</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $select_cart = mysqli_query($con, "SELECT * FROM cart");
                $grand_total = 0;
                if (mysqli_num_rows($select_cart) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                        $grand_total += 5000; // Increment grand_total by 5000fr for each item
                ?>

                <tr>
                    <td><img src="uploads/posts/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
                    <td><?php echo $fetch_cart['location']; ?></td>
                    <td><?php echo $fetch_cart['descriptionland']; ?></td>
                    <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('Remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> Remove</a></td>
                </tr>

                <?php
                    }
                } else {
                    echo '<tr><td colspan="4" class="text-center">Your cart is empty!</td></tr>';
                }
                ?>

                <tr class="table-bottom">
                    <td><a href="view_stock.php?" class="option-btn" style="margin-top: 0;">Continue Reserving</a></td>
                    <td colspan="2">Grand Total</td>
                    <td><?php echo $grand_total; ?>fr</td>
                </tr>
            </tbody>
        </table>

        <div class="checkout-btn">
            <a href="checkout.php?grand_total=<?php echo $grand_total; ?>" class="btn">Proceed to Checkout</a>
        </div>

    </section>

</div>

<!-- Custom JS File Link -->
<script src="script.js"></script>

</body>
</html>
