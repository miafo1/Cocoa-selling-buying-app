<?php 
//include('authenticate.php'); becaus authentication is not giving
// session_start();
include('../includes/connection.php');
$con = connection('cocoa');
?>
<!DOCTYPE html>
<html>
<head>
	<title>VOIR LES REGION</title>
	
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
	
	<style type="text/css" rel="stylesheet" >
		.container
		{
			margin-top:40px;
			padding:20px;
		}
		#img_box
		{
			background-image: url('images/default_avatar_0.png'); 
			background-size: 100%;
			background-repeat: no-repeat;
			background-color:#ddd;
			height:150px; 
			width:150px;
		}
		#exit
		{
				width:140px;
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
						$('#img_box')
							.css({'background-image':'url('+ e.target.result+')'});
					};

					reader.readAsDataURL(input.files[0]);
				}
			}
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
                                <a href="regionadd.php" class="btn btn-primary float-end">Ajouter une Region</a>
                                <h4>Enregistre une Region</h4>
                            </div>
                            <div class="card-body">

                                <table id="myDataTable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome de Region</th>
                                          <th>Status</th>
                                           
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT * FROM region WHERE statusregion !='2'";
                                        $query_run = mysqli_query($con, $query);

                                        if (mysqli_num_rows($query_run) > 0) {

                                            foreach ($query_run as $row) {
                                                ?>
                                                <tr>
                                                    <td><?= $row['idregion']; ?></td>
                                                    <td><?= $row['nameregion']; ?></td>
                                                    
                                                    <td>
                                                        <?php
                                                        if ($row['statusregion'] == '1') {
                                                            echo 'Hidden';
                                                        } else {
                                                            echo 'Vsible';
                                                        }
                                                        ?>
                                                    </td>

                                                    <td><a href="regionedit.php?id=<?= $row['idregion']; ?>" class="btn btn-success">MODIFIER</a></td>

                                                    <td>
                                                        <form action="../code.php" method="POST">
                                                            <button type="submit" name="regiondelete" value="<?= $row['idregion']; ?>" class="btn btn-danger">SUPRIMER</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="6">PAS D'ENREGISTEMENT POUR LE MOMENT</td>
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
	
	
	

	
	
	
	
