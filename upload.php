<?php
if ($_FILES['file']) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
    echo json_encode(["file_path" => $target_file, "status" => "success"]);
} else {
    echo json_encode(["status" => "error"]);
}
?>
