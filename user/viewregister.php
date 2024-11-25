<?php  
//session_start();
include('../includes/connection.php');
$con = connection('cocoa');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajout Membre</title>
    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <style>
        .container { margin-top:40px; padding:20px; }
    </style>
    <script>
        $(document).ready(function() {
            $('#myDataTable').DataTable();
        });
    </script>
</head>
<body>
    <div class="container-fluid px-4">
        <h1 class="mt-4">USERS/ADMIN</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item">Users</li>
        </ol>
        <div class="row">
            <div class="col-md-12">
                <?php include('../message.php'); ?>
                <div class="card">
                    <div class="card-header">
                        <a href="registeradd.php" class="btn btn-primary float-end">ENREGISTRE UN UTILISATEUR</a>
                        <h4>ENREGISTRE UN UTILISATEUR</h4>
                    </div>
                    <div class="card-body">
                        <table id="myDataTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Photo</th>
                                    <th>Nome</th>
                                    <th>Telephone</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Cart de Permision</th>
                                    <th>MODIFIER</th>
                                    <th>SUPRIMER</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM users";
                                $query_run = mysqli_query($con, $query);
                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $row) {
                                        ?>
                                        <tr>
                                            <td><?= $row['id']; ?></td>
                                            <td><img src="uploads/<?= $row['photo'] != '0' ? $row['photo'] : 'default_avatar_0.png'; ?>" width="50" height="50"></td>
                                            <td><?= $row['name']; ?></td>
                                            <td><?= $row['phone']; ?></td>
                                            <td><?= $row['email']; ?></td>
                                            <td><?= ucfirst($row['role']); ?></td>
                                            <td><?= $row['permission_card'] != '0' ? $row['permission_card'] : 'No Permission Card'; ?></td>
                                            <td><a href="registeredit.php?id=<?= $row['id']; ?>" class="btn btn-success">MODIFIER</a></td>
                                            <td>
                                                <form action="../code.php" method="POST">
                                                    <button type="submit" name="delete_btn" value="<?= $row['id']; ?>" class="btn btn-danger">SUPRIMER</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="9">PAS DE ENREGISTREMENT DISPONIBLE</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
