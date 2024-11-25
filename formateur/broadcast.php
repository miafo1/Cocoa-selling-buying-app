<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "cocoa");

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['upload_file']) && isset($_POST['recipient'])) {
    // Handle file upload
    $upload_dir = "../uploads/";
    $file_name = basename($_FILES["upload_file"]["name"]);
    $file_path = $upload_dir . $file_name;

    // Ensure the uploads directory exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Move the uploaded file to the server's directory
    if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $file_path)) {
        // File successfully uploaded
        $recipient_type = $_POST['recipient'];
        $admin_id = 1;  // Assuming the admin has a user ID of 1
        $message = "You have received a new file: <a href='" . $file_path . "'>" . $file_name . "</a>";

        // Fetch recipients based on the selected option
        $recipients = [];
        if ($recipient_type === 'users') {
            $sql = "SELECT id FROM users WHERE role != 'admin'";
        } elseif ($recipient_type === 'corporations') {
            // Fetch all corporation members and delegates
            $sql = "
                SELECT DISTINCT u.id 
                FROM users u
                JOIN corporation_members cm ON u.id = cm.user_id
                UNION
                SELECT u.id 
                FROM users u
                JOIN corporation_delegates cd ON u.id = cd.user_id
            ";
        } elseif ($recipient_type === 'formateurs') {
            $sql = "SELECT id FROM users WHERE role = 'formateur'";
        }

        // Execute the query and fetch all recipients
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $recipients[] = $row['id'];
        }

        // Broadcast the message to all recipients
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, recipient_id, message) VALUES (?, ?, ?)");
        foreach ($recipients as $recipient_id) {
            $stmt->bind_param("iis", $admin_id, $recipient_id, $message);
            $stmt->execute();
        }

        echo "<p>File uploaded and message sent to " . count($recipients) . " recipients.</p>";
    } else {
        echo "<p>There was an error uploading the file.</p>";
    }
}


// Handle message and video upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recipient_id'])) {
    $sender_id = 1; // Assuming admin's ID is 1
    $recipient_id = $_POST['recipient_id'];
    $message = $_POST['message'];

    // Handle video upload
    $video_path = null;
    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $target_dir = "../uploads/videos/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $video_file = $target_dir . basename($_FILES["video"]["name"]);
        $video_file_type = strtolower(pathinfo($video_file, PATHINFO_EXTENSION));

        // Validate file type (only allow video files)
        $allowed_types = array("mp4", "avi", "mov", "mpeg");
        if (in_array($video_file_type, $allowed_types)) {
            if (move_uploaded_file($_FILES["video"]["tmp_name"], $video_file)) {
                $video_path = $video_file;
            } else {
                echo "<p>Error uploading video.</p>";
            }
        } else {
            echo "<p>Invalid video format. Only MP4, AVI, MOV, and MPEG are allowed.</p>";
        }
    }

    // Insert message and video (if uploaded) into the database
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, recipient_id, message, video_path) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $sender_id, $recipient_id, $message, $video_path);
    if ($stmt->execute()) {
        echo "<p>Message sent successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>
