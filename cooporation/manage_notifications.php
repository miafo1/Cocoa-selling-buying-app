<?php
session_start();
// Database connection
$conn = new mysqli("localhost", "root", "", "cocoa");

// Check if connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in and has the 'admin' role
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'delegue_corp') {
    $admin_id = $_SESSION['user_id']; // Get admin's user ID from session

    // Fetch all users along with their roles and corporation (if applicable)
    $sql = "
        SELECT u.id, u.name, u.role, c.name as corporation_name 
        FROM users u 
        LEFT JOIN corporation_members cm ON u.id = cm.user_id 
        LEFT JOIN corporation_delegates cd ON u.id = cd.user_id 
        LEFT JOIN corporations c ON c.id = COALESCE(cm.corporation_id, cd.corporation_id)
        WHERE u.role != 'admin'
    ";
    $result = $conn->query($sql);

    // Handle message sending
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recipient_id'], $_POST['message'])) {
        $recipient_id = $_POST['recipient_id'];
        $message = $_POST['message'];

        $stmt = $conn->prepare("INSERT INTO messages (sender_id, recipient_id, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $admin_id, $recipient_id, $message);
        $stmt->execute();
        $stmt->close();

        echo "<p>Message sent successfully!</p>";
    }

    // Fetch all messages for the admin
    $sql_messages = "SELECT * FROM messages WHERE recipient_id = ? ORDER BY sent_at DESC";
    $stmt_messages = $conn->prepare($sql_messages);
    $stmt_messages->bind_param("i", $admin_id);
    $stmt_messages->execute();
    $messages_result = $stmt_messages->get_result();
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Notifications</title>
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
            #exit {
                width: 140px;
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
                        $('#img_box').css({'background-image': 'url(' + e.target.result + ')'});
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    </head>
    <body>
        <h1>Admin Notifications</h1>

        <!-- List all users and provide a form to send messages -->
        <div class="container-fluid px-4">
            <div class="row mt-4">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <h4>Admin Notifications</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="" enctype="multipart/form-data">
                                <div class="col-md-6 mb-3">
                                    <label for="recipient">Select User to Message:</label>
                                    <select name="recipient_id" id="recipient" required>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <option value="<?php echo $row['id']; ?>">
                                                <?php
                                                    echo $row['name'] . " (" . $row['role'];
                                                    if (!empty($row['corporation_name'])) {
                                                        echo " - " . $row['corporation_name'];
                                                    }
                                                    echo ")";
                                                ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="message">Message:</label><br>
                                    <textarea name="message" id="message" rows="4" cols="50"></textarea><br><br>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="video">Upload Video:</label>
                                    <input type="file" name="video" id="video" accept="video/*"><br><br>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <button type="submit">Send Message</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h2>Received Messages</h2>
        <ul>
        <?php while ($message_row = $messages_result->fetch_assoc()): ?>
            <li>
                <strong>Message:</strong> <?php echo $message_row['message']; ?> <br>
                <strong>Sent At:</strong> <?php echo $message_row['sent_at']; ?> <br>

                <?php if (!empty($message_row['video_path'])): ?>
                    <strong>Video:</strong> 
                    <video width="320" height="240" controls>
                        <source src="<?php echo $message_row['video_path']; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <br>
                <?php endif; ?>

                <form action="mark_as_read.php" method="post" style="display:inline;">
                    <input type="hidden" name="message_id" value="<?php echo $message_row['id']; ?>">
                    <button type="submit">Mark as Read</button>
                </form>

                <form action="delete_message.php" method="post" style="display:inline;">
                    <input type="hidden" name="message_id" value="<?php echo $message_row['id']; ?>">
                    <button type="submit">Delete</button>
                </form>
            </li>
        <?php endwhile; ?>
        </ul>
    </body>
    </html>

    <?php
    $stmt_messages->close();
    $conn->close();
} else {
    // Redirect or show an error if the user is not authorized
    echo "Unauthorized access!";
    exit;
}
?>
