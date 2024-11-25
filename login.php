<?php
session_start();  // Start the session at the very beginning
include('includes/connection.php');
$con = connection('cocoa');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['pwd']);

    // Query to check email
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name']; // Storing the name for welcome message
            $_SESSION['email'] = $user['email']; // Storing the email
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            switch ($user['role']) {
                case 'acheteur':
                    header("Location: view_stock.php");
                    break;
                case 'formateur':
                    header("Location: formateur/Forma_dashboard.php");
                    break;
                case 'delegue_corp':
                    header("Location: cooporation/Delegeuco_dashboard.php");
                    break;
                case 'membre_corp':
                    header("Location: cooporation/membre_dashboard.php");
                    break;
                case 'admin':
                    header("Location: admin/dashboard.php");
                    break;
                default:
                    echo "Role not defined.";
                    break;
            }
            exit(); // Always exit after a header redirection
        } else {
            // Password does not match
            header("Location: login_admin.php?invalid=1");
            exit();
        }
    } else {
        // Email not found
        echo "Email not found.";
    }
}
?>
