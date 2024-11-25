<?php
//include('authenticate.php'); becaus authentication is not giving
session_start();
include('./includes/connection.php');
$con = connection('cocoa');
// ADD USER    ++++++++++++++++++++++++++
if (isset($_POST['add_btn'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_as = $_POST['role_as'];
    $idregion = $_POST['idregion'];
    $idcity = $_POST['idcity'];
    

    // File upload for user image
    $image = $_FILES['image']['name'];
    $image_temp = $_FILES['image']['tmp_name'];
    $image_path = 'uploads/' . $image;
    move_uploaded_file($image_temp, $image_path);  // Move file to the uploads directory

    // File upload for permission card (Acheteur only)
    $permission_card = $_FILES['permission_card']['name'] ?? '0';
    $permission_card_temp = $_FILES['permission_card']['tmp_name'];
    if ($role_as == 'acheteur') {
        $permission_card_path = 'uploads/' . $permission_card;
        move_uploaded_file($permission_card_temp, $permission_card_path);
    } else {
        $permission_card = '0';  // Set to default if not Acheteur
    }

    // Insert query
    $query = "INSERT INTO users (name, phone, email, password, role, photo, idregion, idcity, permission_card) 
              VALUES ('$name', '$phone', '$email', '$password', '$role_as', '$image_path', '$idregion', '$idcity', '$permission_card')";

    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['message'] = "User Added Successfully";
        header('location: user/viewregister.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong";
        header('location: user/viewregister.php');
        exit(0);
    }
}


// UPDATE  USER@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
if (isset($_POST['update_btn'])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']); // Assuming the password is being hashed
    $role_as = $_POST['role_as'];
   

    $query = "UPDATE users SET name='$name', phone='$phone', email='$email', password='$password', role='$role_as' WHERE id='$user_id'";

    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['message'] = "User Updated Successfully";
        header('location: user/viewregister.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong";
        header('location: user/registeredit.php?id='.$user_id);
        exit(0);
    }
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image = $_FILES['image']['name'];
        $path = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $path);
    
        // Update the user's photo in the database
        $query = "UPDATE users SET photo='$image' WHERE id='$user_id'";
        mysqli_query($con, $query);
    }
    
}

// DELETE USER   *****************************
if (isset($_POST['delete_btn'])) {
    $user_id = $_POST['delete_btn'];
    
    // Delete the user from the database
    $query = "DELETE FROM users WHERE id='$user_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['message'] = "User Deleted Successfully";
        header('location: user/viewregister.php');
        exit(0);
    } else {
        $_SESSION['message'] = "User Deletion Failed";
        header('location: user/viewregister.php');
        exit(0);
    }
}

// ADD cooperation   *****************************
if (isset($_POST['add_corporation_btn'])) {
    $corporation_name = $_POST['corporation_name'];
    $corporation_address = $_POST['corporation_address'];
    $idcity = $_POST['idcity'];
    $delegate_id = $_POST['delegate_id']; // User ID of the corporation delegate

    // Start a transaction to ensure both corporation and delegate are inserted together
    mysqli_begin_transaction($con);

    try {
        // Insert corporation
        $insert_corporation_query = "INSERT INTO corporations (name, address, idcity) VALUES ('$corporation_name', '$corporation_address', '$idcity')";
        $corporation_inserted = mysqli_query($con, $insert_corporation_query);
        
        if ($corporation_inserted) {
            // Get the last inserted corporation ID
            $corporation_id = mysqli_insert_id($con);

            // Insert the delegate into corporation_delegates table
            $insert_delegate_query = "INSERT INTO corporation_delegates (corporation_id, user_id) VALUES ('$corporation_id', '$delegate_id')";
            $delegate_inserted = mysqli_query($con, $insert_delegate_query);

            // Update the user's role to delegue_corp in the users table
            $update_user_role_query = "UPDATE users SET role = 'delegue_corp' WHERE id = '$delegate_id'";
            $role_updated = mysqli_query($con, $update_user_role_query);

            if ($delegate_inserted && $role_updated) {
                mysqli_commit($con);
                $_SESSION['message'] = "Corporation and delegate assigned successfully.";
                header("Location: admin/manage_corporations.php");
                exit(0);
            } else {
                throw new Exception("Failed to assign delegate or update role.");
            }
        } else {
            throw new Exception("Failed to create corporations");
        }
    } catch (Exception $e) {
        mysqli_rollback($con);
        $_SESSION['message'] = $e->getMessage();
        header("Location: admin/manage_corporations.php");
        exit(0);
    }
}

// UPDATE cooperation   *****************************
// ... existing code ...

if (isset($_POST['update_corporation_btn'])) {
    $corporation_id = $_POST['corporation_id'];
    $corporation_name = $_POST['corporation_name'];
    $corporation_address = $_POST['corporation_address'];
    $idcity = $_POST['idcity'];
    $delegate_id = $_POST['delegate_id'];

    // Start a transaction
    mysqli_begin_transaction($con);

    try {
        // Update corporation details
        $update_corporation_query = "UPDATE corporations SET name = '$corporation_name', address = '$corporation_address', idcity = '$idcity' WHERE id = '$corporation_id'";
        $corporation_updated = mysqli_query($con, $update_corporation_query);

        if ($corporation_updated) {
            // Check if delegate has changed
            // Fetch current delegate
            $current_delegate_query = "SELECT user_id FROM corporation_delegates WHERE corporation_id = '$corporation_id'";
            $current_delegate_result = mysqli_query($con, $current_delegate_query);

            if (mysqli_num_rows($current_delegate_result) > 0) {
                $current_delegate = mysqli_fetch_assoc($current_delegate_result);
                $current_delegate_id = $current_delegate['user_id'];

                if ($current_delegate_id != $delegate_id) {
                    // Update the delegate
                    $update_delegate_query = "UPDATE corporation_delegates SET user_id = '$delegate_id' WHERE corporation_id = '$corporation_id'";
                    $delegate_updated = mysqli_query($con, $update_delegate_query);

                    // Update roles
                    // Set new delegate's role to 'delegue_corp'
                    $update_new_delegate_role = "UPDATE users SET role = 'delegue_corp' WHERE id = '$delegate_id'";
                    $new_delegate_role_updated = mysqli_query($con, $update_new_delegate_role);

                    // Set previous delegate's role to 'admin' or any default role
                    $update_old_delegate_role = "UPDATE users SET role = 'admin' WHERE id = '$current_delegate_id'";
                    $old_delegate_role_updated = mysqli_query($con, $update_old_delegate_role);

                    if (!$delegate_updated || !$new_delegate_role_updated || !$old_delegate_role_updated) {
                        throw new Exception("Failed to update delegate or roles.");
                    }
                }
            } else {
                // No current delegate, insert new
                $insert_delegate_query = "INSERT INTO corporation_delegates (corporation_id, user_id) VALUES ('$corporation_id', '$delegate_id')";
                $delegate_inserted = mysqli_query($con, $insert_delegate_query);

                // Update new delegate's role
                $update_new_delegate_role = "UPDATE users SET role = 'delegue_corp' WHERE id = '$delegate_id'";
                $new_delegate_role_updated = mysqli_query($con, $update_new_delegate_role);

                if (!$delegate_inserted || !$new_delegate_role_updated) {
                    throw new Exception("Failed to assign new delegate.");
                }
            }

            mysqli_commit($con);
            $_SESSION['message'] = "Corporation updated successfully.";
            header("Location: admin/manage_corporations.php");
            exit(0);
        } else {
            throw new Exception("Failed to update corporation.");
        }
    } catch (Exception $e) {
        mysqli_rollback($con);
        $_SESSION['message'] = $e->getMessage();
        header("Location: admin/manage_corporations.php");
        exit(0);
    }
}


//Suprimer une cooperative   +++++++++++++++++++++++++++++++++
if (isset($_POST['delete_corporation_btn'])) {
    $corporation_id = $_POST['delete_corporation_btn'];

    $delete_corporation_query = "DELETE FROM corporations WHERE id = '$corporation_id'";
    $delete_corporation_run = mysqli_query($con, $delete_corporation_query);

    if ($delete_corporation_run) {
        $_SESSION['message'] = "Corporation deleted successfully.";
        header("Location: admin/manage_corporations.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Corporation deletion failed.";
        header("Location: admin/manage_corporations.php");
        exit(0);
    }
}


//ADD A REGION   +++++++++++++++++++++++++++++++++
if (isset($_POST['regionadd'])) {

    $regionname = $_POST['nameregion'];
    $status = $_POST['status'] == true ? '1' : '0';

    $query = "INSERT INTO region (nameregion,statusregion) VALUES ('$regionname', '$status')";

    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['message'] = "Pegion Added Successfully";
        header('location: region/regionadd.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong";
        header('location: region/regionadd.php');
        exit(0);
    }
}
// REGION UPDATE  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
if (isset($_POST['regionupdate'])) {
    $region_id = $_POST['id'];
    $regionname = $_POST['nameregion'];

    $status = $_POST['status'] == true ? '1' : '0';

    $query = "UPDATE region SET nameregion='$regionname', statusregion='$status'
                    WHERE idregion='$region_id'";

    $query_run = mysqli_query($con, $query);

    if ($query_run) {

        $_SESSION['message'] = "Updated Successfully!!!!";
        header('location: region/regionview.php' );
        exit(0);
    } else {
        $_SESSION['message'] = "Something Went Wrong.!!!";
        header('location: region/regionedit.php?id=1');
        exit(0);
    }
}
// DELETE REGION   *****************************
if (isset($_POST['regiondelete'])) {

    $region_id = $_POST['regiondelete'];

    $query = "UPDATE region SET statusregion = '2' WHERE idregion ='$region_id' LIMIT 1";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['message'] = "Region Deleted Successfully";
        header('location: region/regionview.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong";
        header('location: region/regionview.php');
        exit(0);
    }
}
//ADD A CITY   +++++++++++++++++++++++++++++++++
if (isset($_POST['townadd'])) {
    $idregion = $_POST['idregion'];
    $townname = $_POST['nametown'];
    $status = isset($_POST['status']) ? '1' : '0';


    $query = "INSERT INTO city (idregion, namcity, statuscity) VALUES ('$idregion', '$townname', '$status')";

    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['message'] = "Ajouter avec success";
        header('location: ville/townview.php');
        exit(0);
    } else {
        $_SESSION['message'] = "oops! un petit problem";
        header('location: ville/townadd.php');
        exit(0);
    }
}
// CITY UPDATE  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
if (isset($_POST['townupdate'])) {
    $town_id = $_POST['id'];
    $townname = $_POST['nametown'];

    $status = $_POST['status'] == true ? '1' : '0';

    $query = "UPDATE city SET namecity='$townname', statuscity='$status'
                    WHERE idcity='$town_id'";

    $query_run = mysqli_query($con, $query);

    if ($query_run) {

        $_SESSION['message'] = " Avec success !!!!";
        header('location: ville/townadd.php' );
        exit(0);
    } else {
        $_SESSION['message'] = "oops! un petit problem";
        header('location: ville/townedit.php?id=1' );
        exit(0);
    }
}
// DELETE TOWN   *****************************
if (isset($_POST['towndelete'])) {

    $town_id = $_POST['towndelete'];

    // Update the correct column 'statuscity' instead of 'statustown'
    $query = "UPDATE city SET statuscity = '2' WHERE idcity ='$town_id' LIMIT 1";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['message'] = "Avec success !!!!";
        header('location: ville/townview.php');
        exit(0);
    } else {
        $_SESSION['message'] = "oops! un petit problem";
        header('location: ville/townview.php');
        exit(0);
    }
}




// Reservation delet   *****************************
if (isset($_POST['reservationdelete'])) {

    $town_id = $_POST['reservationdelete'];

    $query = "UPDATE town SET id = 'NULL' WHERE idtown ='$town_id' LIMIT 1";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['message'] = "Town Deleted Successfully";
        header('location: townview.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong";
        header('location: townview.php');
        exit(0);
    }
}

?>