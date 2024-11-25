<?php
// Uncomment session handling if needed for authentication
session_start();
include('includes/connection.php');
$con = connection('cocoa');

if (isset($_POST['add_to_cart'])) {
    $product_description = $_POST['product_description'];
    $product_image = $_POST['product_image'];
    $product_location = $_POST['product_location'];
    $user_id = $_SESSION['user_id']; // Get the user ID from the session

    $select_cart = mysqli_query($con, "SELECT * FROM cart WHERE descriptionland = '$product_description' AND user_id = '$user_id'");

    if (mysqli_num_rows($select_cart) > 0) {
        $message[] = 'Product already added to cart';
    } else {
        $insert_product = mysqli_query($con, "INSERT INTO cart (location, descriptionland, image, user_id) VALUES('$product_location', '$product_description', '$product_image', '$user_id')");
        $message[] = 'Product added to cart successfully';
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cocoa|web</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        /* Basic styles omitted for brevity */
    </style>
</head>
<body>
<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">' . $message . 
             '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
             </div>';
    }
}

include 'headercard.php';
?>

<div class="container-fluid mt-4">
    <section class="products">
        <h1 class="heading">Available Stocks</h1>
        <div class="row">

            <?php
            // Fetch all available stocks without filtering by stock_id
            $select_products = mysqli_query($con, "SELECT s.id, s.picture, s.quantity, s.unit_price, s.total_price, s.location, s.status, c.name as corporation_name 
            FROM stocks s
            JOIN corporations c ON s.corporation_id = c.id");

            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_products)) {
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="uploads/<?php echo $fetch_product['picture']; ?>" class="card-img-top" alt="Product Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $fetch_product['corporation_name']; ?></h5>
                                <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#details<?php echo $fetch_product['id']; ?>">Details</button>
                                <div id="details<?php echo $fetch_product['id']; ?>" class="collapse mt-2">
                                    <p><strong>Quantity:</strong> <?php echo isset($fetch_product['quantity']) ? $fetch_product['quantity'] : 'N/A'; ?></p>
                                    <p><strong>Unit Price:</strong> <?php echo isset($fetch_product['unit_price']) ? $fetch_product['unit_price'] : 'N/A'; ?></p>
                                    <p><strong>Total Price:</strong> <?php echo isset($fetch_product['total_price']) ? $fetch_product['total_price'] : 'N/A'; ?> fr</p>
                                    <p><strong>Location:</strong> <?php echo isset($fetch_product['location']) ? $fetch_product['location'] : 'N/A'; ?></p>
                                </div>

                                <!-- Add to Cart Form -->
                                <form action="" method="post" class="mt-3">
                                    <input type="hidden" name="product_description" value="<?php echo $fetch_product['corporation_name']; ?>">
                                    <input type="hidden" name="product_image" value="<?php echo $fetch_product['picture']; ?>">
                                    <input type="hidden" name="product_location" value="<?php echo $fetch_product['location']; ?>">
                                    <?php if ($fetch_product['status'] == 'reserved') { ?>
                                        <span class="reserved">THIS STOCK IS RESERVED</span>
                                        <button class="btn btn-secondary" disabled>Reserved</button>
                                    <?php } else { ?>
                                        <button type="submit" class="btn btn-primary" name="add_to_cart">Add to Cart</button>
                                    <?php } ?>
                                </form>

                                <!-- Send Message Form -->
                                <form action="send_message.php" method="post" class="mt-3">
                                    <input type="hidden" name="stock_id" value="<?php echo $fetch_product['id']; ?>">
                                    <input type="hidden" name="recipient_id" value="<?php echo $fetch_product['corporation_name']; ?>"> <!-- Corporation ID as recipient -->
                                    <input type="hidden" name="message" value="I am interested in your stock with the description: <?php echo $fetch_product['corporation_name']; ?>">
                                    <button type="submit" class="btn btn-warning">Send Message to Corporation</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo '<div class="col-12 text-center"><h2>No Stock Available</h2></div>';
            }
            ?>

        </div>
    </section>
</div>

<!-- jQuery and Bootstrap JS for collapse functionality -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<!-- Custom JS File Link -->
<script src="script.js"></script>
</body>
</html>
