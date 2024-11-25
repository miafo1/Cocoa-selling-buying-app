<?php 
//include('authenticate.php'); becaus authentication is not giving
// session_start();
include('../includes/connection.php');
$con = connection('cocoa');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ajout Membre</title>
	
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
    <h1 class="mt-4">USERS</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Users</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>MODIFIER UTILISATEUR</h4>
                </div>
                <div class="card-body">

                    <?php
                    if(isset($_GET['id'])) {
                        $user_id = $_GET['id'];
                        $users = "SELECT * FROM users WHERE id='$user_id'";
                        $users_run = mysqli_query($con, $users);

                        if(mysqli_num_rows($users_run) > 0) {

                            foreach($users_run as $user) {

                            }
                            ?>
                            
                            <form action="../code.php" method="POST">
                                <input type="hidden" name="user_id" value="<?=$user['id'];?>">
                                <div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<div id="img_box" class="rounded float-right border"></div>
						<input type="file" accept="image/jpg, image/jpeg, image/png" name="image" class="image input" id="image" style="display:none;" onchange="readURL(this);"/>
					</div>
				</div>
			</div>
                    
                                <div class="col-md-6 mb-3">
                                    <label for="">NOME</label>
                                    <input type="text" required name="name" value="<?=$user['name'];?>" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="">NUMERO</label>
                                    <input type="text" required name="phone" value="<?=$user['phone'];?>" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="">Email</label>
                                    <input type="email" required name="email" value="<?=$user['email'];?>" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="">Password</label>
                                    <input type="password" required name="password" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="">Role</label>
                                    <select name="role_as"  required class="form-control">
                                        <option value="">--Selct Role</option>
                                        <option value="acheteur" <?=$user['role'] == 'acheteur' ? 'selected':'' ?> >ACHETEUR</option>

                                        <option value="formateur" <?=$user['role'] == 'formateur' ? 'selected':'' ?> >FORMATEUR</option>

                                        <option value="delegue_corp" <?=$user['role'] == 'delegue_corp' ? 'selected':'' ?> >DELEGUE CORP</option>

                                        <option value="membre_corp" <?=$user['role'] == 'membre_corp' ? 'selected':'' ?> >MEMBRE CORP</option>


                                    </select>
                                </div>

                                

                                <div class="col-md-12 mb-3">
                                    <button type="submit" class="btn btn-primary" name="update_btn">MODIFIER UTILISATEUR</button>
                                </div>
                            </form>

                            <?php

                        } else {

                            ?>
                            <h4>PAS DE ENREGISTREMENT DISPONIBLE</h4>
                            <?php
                        }
                    }
                    ?>
                                    
                </div>
            </div>
        </div>

    </div>
</div>


            <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
                    class="bi bi-arrow-up-short"></i></a>

            <div id="preloader"></div>
</body>
</html>
	
	
	

	
	
	
	
