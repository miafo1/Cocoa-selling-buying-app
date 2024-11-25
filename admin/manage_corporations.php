<?php  
//session_start();
include('../includes/connection.php');
$con = connection('cocoa');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajout Ville/Village</title>
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
                        <a href="addcorporation.php" class="btn btn-primary float-end">AJOUTER UNE COOPERATIVE</a>
                        <h4>VOIR LES COOPERATIVES</h4>
                    </div>
                    <div class="card-body">
                        <table id="myDataTable" class="table table-bordered">
                            <thead>
                                <tr>
                                
                <th>ID</th>
                <th>Nome de cooperative</th>
                <th>Address</th>
                <th>VILLE/VILLAGE</th>
                <th>Delegue</th>
                <th>Edit</th>
                <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
            $query = "SELECT c.id, c.name, c.address, ci.namcity, u.name as delegate_name 
                      FROM corporations c
                      JOIN city ci ON ci.idcity = c.idcity
                      JOIN corporation_delegates cd ON cd.corporation_id = c.id
                      JOIN users u ON u.id = cd.user_id";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($corporation = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?= $corporation['id']; ?></td>
                        <td><?= $corporation['name']; ?></td>
                        <td><?= $corporation['address']; ?></td>
                        <td><?= $corporation['namcity']; ?></td>
                        <td><?= $corporation['delegate_name']; ?></td>
                        <td>
                            <a href="corporation_edit.php?id=<?= $corporation['id']; ?>">MODIFIER</a>
                            <form action="../code.php" method="POST">
                                <button type="submit" name="delete_corporation_btn" value="<?= $corporation['id']; ?>">SUPRIMER</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='6'>Aucune Cooperation trouver</td></tr>";
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
