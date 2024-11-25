<?php 
//include('authenticate.php'); becaus authentication is not giving
// session_start();
include('../includes/connection.php');
$con = connection('cocoa');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ajout Ville/Village</title>
	
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
	
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: url('../images/4.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        /* Dark overlay for better readability */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Adjust opacity */
            z-index: 0;
        }

        /* Container styling */
        .container-fluid {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            width: 500px;
            max-width: 100%;
        }

        /* Form input styling */
        form {
            display: flex;
            flex-direction: column;
        }

        form label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        form input, form select {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Submit button styling */
        input[type="submit"] {
            background-color: #6b3d0c; /* Cocoa color */
            color: white;
            border: none;
            cursor: pointer;
            padding: 15px;
            font-size: 18px;
            transition: background-color 0.3s ease;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: #4e2908; /* Darker cocoa color */
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
                <div class="row mt-4">

                    <div class="col-md-12">
                        <?php include ('../message.php') ?>
                        <div class="card">
                            <div class="card-header">
                                <h4>AJOUT VILLE/VILLAGE
                                    <a href="townview.php" class="btn btn-danger float-end">Retour</a>
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="../code.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="">Liste DE REGION</label>
                                            <?php
                                            $regionl = "SELECT * FROM region";
                                            $regionl_run = mysqli_query($con, $regionl);
                                            if (mysqli_num_rows($regionl_run) > 0) {
                                                ?>
                                            <select name="idregion" required="" class="form-control">
                                                    <option value="">------ Click pour selectioner une region----</option>
                                                    <?php
                                                    foreach ($regionl_run as $regionl_item){
                                                        ?>
                                                    <option value="<?= $regionl_item['idregion'] ?>"><?= $regionl_item['nameregion'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <?php
                                            } else {
                                                ?>
                                                <h5>PAS DE REGION DISPONIBLE!!</h5>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">NOME DE VILLE/VILLAGE</label>
                                            <input type="text" required name="nametown" required="" class="form-control">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="">Status</label>
                                            <input type="checkbox" name="status" value="1" width="70px" height="70px" />

                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <button type="submit" class="btn btn-primary" name="townadd">ENREGISTRER VILLE/VILLAGE</button>
                                        </div>
                                    </div>
                                </form>                         
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
	
	
	

	
	
	
	
