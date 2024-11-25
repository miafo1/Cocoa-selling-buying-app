<?php
session_start();
// if (!isset($_SESSION['type'])){
// 	header("Location: ../index.php");
// 	exit();
// }
//$_SESSION['type'] = 'admin';
#
include('../includes/connection.php');
$con = connection('cocoa');
// Fetch total users, corporations, and messages
$totalUsersQuery = "SELECT COUNT(*) AS totalUsers FROM users";
$totalMessagesQuery = "SELECT COUNT(*) AS totalMessages FROM messages"; // Adjust table name for messages
$totalCorporationsQuery = "SELECT COUNT(*) AS totalCorporations FROM corporations";

$totalUsersResult = mysqli_query($con, $totalUsersQuery);
$totalMessagesResult = mysqli_query($con, $totalMessagesQuery);
$totalCorporationsResult = mysqli_query($con, $totalCorporationsQuery);

$totalUsers = mysqli_fetch_assoc($totalUsersResult)['totalUsers'];
$totalMessages = mysqli_fetch_assoc($totalMessagesResult)['totalMessages'];
$totalCorporations = mysqli_fetch_assoc($totalCorporationsResult)['totalCorporations'];
?>
<!-- DASHBOARD ==> ADMIN LOGIN -->
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Dashbord | Cacao-Corp</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> -->
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.0.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<link href="../bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
	<!-- <link rel="stylesheet" type="text/css" href="../font-awesome-5/css/fontawesome-all.min.css"> -->
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
<!-- FONTAWESOME CDN FILE -->
	<!--mdboostrap-->
	<!-- DataTables CSS -->
<link href="css/addons/datatables.min.css" rel="stylesheet">
<!-- DataTables JS -->
<script href="js/addons/datatables.min.js" rel="stylesheet"></script>

<!-- DataTables Select CSS -->
<link href="css/addons/datatables-select.min.css" rel="stylesheet">
<!-- DataTables Select JS -->
<script href="js/addons/datatables-select.min.js" rel="stylesheet"></script>

	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.min.js"></script> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.3/croppie.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/4.0.0/cropper.js"></script>

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="../bootstrap/jquery/jquery2.2.4.min.js"></script>
	<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
	<!-- CALENDER -->
	<link href='../fullcalendar/assets/css/fullcalendar.css' rel='stylesheet' />
	<link href='../fullcalendar/assets/css/fullcalendar.print.css' rel='stylesheet' media='print' />
	<script src='../fullcalendar/assets/js/jquery-1.10.2.js' type="text/javascript"></script>
	<script src='../fullcalendar/assets/js/jquery-ui.custom.min.js' type="text/javascript"></script>
	<script src='../fullcalendar/assets/js/fullcalendar.js' type="text/javascript"></script>
	<!-- /CALENDER -->
	<link rel="stylesheet" type="text/css" href="../css/dashbord.css">
	<script type="text/javascript" src="../js/add_tab.js"></script>
	<script type="text/javascript" src="../js/fetch_tms.js"></script>
	<script type="text/javascript" src="../js/fetch_location.js"></script>
	<script type="text/javascript" src="../js/sweetalert.min.js"></script>
		<link rel="stylesheet" href="../student/css/flaticon.css">
	<!-- <a class="navbar-brand" href="#" style="width: 149px;"><?php //echo $tution['name'];?></a> -->
	<style type="text/css">
		/* CALENDAR */
			#calendar-body {
				margin-top: 40px;
				text-align: center;
				font-size: 14px;
				font-family: "Helvetica Nueue",Arial,Verdana,sans-serif;
				background-color: #fff;
				}

			#wrap {
				width: 1100px;
				margin: 0 auto;
				}

			#external-events {
				float: left;
				width: 150px;
				padding: 0 10px;
				text-align: left;
				}

			#external-events h4 {
				font-size: 16px;
				margin-top: 0;
				padding-top: 1em;
				}

			.external-event { /* try to mimick the look of a real event */
				margin: 10px 0;
				padding: 2px 4px;
				background: #3366CC;
				color: #fff;
				font-size: .85em;
				cursor: pointer;
				}

			#external-events p {
				margin: 1.5em 0;
				font-size: 11px;
				color: #666;
				}

			#external-events p input {
				margin: 0;
				vertical-align: middle;
				}

			#calendar {
		/* 		float: right; */
		        margin: 0 auto;
				width: 900px;
				background-color: #FFFFFF;
				border-radius: 6px;
		        box-shadow: 0 1px 2px #C3C3C3;
			}


	</style>
	<script type="text/javascript">
		$(document).ready(function(){

				// NOTICE
			$('#btn_notice').click(function(){
				var data = $('#notice_form .input').serializeArray();
				
				var date = new Date();
				if (date.getMonth() < 10) {month = '0'+date.getMonth();}else{month = date.getMonth();}
				if (date.getDate() < 10) {day = '0'+date.getDate();}else{day = date.getDate();}
				var currentDate = date.getFullYear()+'-'+month+'-'+day;
				var currentTime = date.getHours()+':'+date.getMinutes()+':'+date.getSeconds();

				data.push({name:'func',value:'ins_notice'},{name:'tutionId',value:tution},{name:'date',value:currentDate},{name:'time',value:currentTime});
				console.log(data);
				$('#notice').html();
				$.ajax({
					url:'../processes/notice.process.php',
					method:'POST',
					data:data,
					success:function(data){
						//alert(data);
						if (data == 1){
							swal("Done","Notice Posted successfuly","success");
						}
						else if(data == 'empty'){
							swal("Hmm!","Notice Body is Empty!","warning");
						}
						else{
							swal("Error!","Message not sent. \n"+data,"error");
						}
					}
				});
			});

			// show Branch, Student and Staff pane
			$('.card').click(function(){
				var id = $(this).attr('rel');
				$('#'+id).click();
			});

			// Calendar--------------------------------------------------------------------------------------------
		    var date = new Date();
			var d = date.getDate();
			var m = date.getMonth();
			var y = date.getFullYear();

			/*  className colors
			className: default(transparent), important(red), chill(pink), success(green), info(blue)
			*/
			/* initialize the external events
			-----------------------------------------------------------------*/
			$('#external-events div.external-event').each(function() {

				// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
				// it doesn't need to have a start or end
				var eventObject = {
					title: $.trim($(this).text()) // use the element's text as the event title
				};

				// store the Event Object in the DOM element so we can get to it later
				$(this).data('eventObject', eventObject);

				// make the event draggable using jQuery UI
				$(this).draggable({
					zIndex: 999,
					revert: true,      // will cause the event to go back to its
					revertDuration: 0  //  original position after the drag
				});

			});

			/* initialize the calendar
			-----------------------------------------------------------------*/
			var calendar =  $('#calendar').fullCalendar({
				header: {
					left: 'title',
					center: 'agendaDay,agendaWeek,month',
					right: 'prev,next today'
				},
				editable: true,
				firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
				selectable: true,
				defaultView: 'month',

				axisFormat: 'h:mm',
				columnFormat: {
	                month: 'ddd',    // Mon
	                week: 'ddd d', // Mon 7
	                day: 'dddd M/d',  // Monday 9/7
	                agendaDay: 'dddd d'
	            },
	            titleFormat: {
	                month: 'MMMM yyyy', // September 2009
	                week: "MMMM yyyy", // September 2009
	                day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
	            },
				allDaySlot: false,
				selectHelper: true,
				select: function(start, end, allDay) {
					var title = prompt('Event Title:');
					if (title) {
						calendar.fullCalendar('renderEvent',
							{
								title: title,
								start: start,
								end: end,
								allDay: allDay
							},
							true // make the event "stick"
						);
					}
					calendar.fullCalendar('unselect');
				},
				droppable: true, // this allows things to be dropped onto the calendar !!!
				drop: function(date, allDay) { // this function is called when something is dropped

					// retrieve the dropped element's stored Event Object
					var originalEventObject = $(this).data('eventObject');

					// we need to copy it, so that multiple events don't have a reference to the same object
					var copiedEventObject = $.extend({}, originalEventObject);

					// assign it the date that was reported
					copiedEventObject.start = date;
					copiedEventObject.allDay = allDay;

					// render the event on the calendar
					// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
					$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

					// is the "remove after drop" checkbox checked?
					if ($('#drop-remove').is(':checked')) {
						// if so, remove the element from the "Draggable Events" list
						$(this).remove();
					}

				},

				events: [
					{
						title: 'Salary Calculation',
						start: new Date(y, m, 1)
					},
					
				],
			});
			// \Calender--------------------------------------------------------------------------------------------


		});

	</script>
</head>
<body style="background-color: #ededed;">

			  <section id="section">
			  	<div id="wrapper">

			  		   <!-- Sidebar -->
						 <div id="sidebar-wrapper" style="position: fixed;">
            <div class="text-center" id="brand" style="margin-top: 15px;">
                <img src="../images/admin_avatar_png.png" class="img-fluid rounded" alt="Cocoa Logo"/>
                <h3>Cocoa Platform</h3>
            </div>
            <hr style="border-color: #222; width: 90%;" />
            <ul class="sidebar-nav">
                <li><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
				<li>
    <a href="manage_notifications.php">
        <i class="fa fa-bell"></i> Publier un message 
        <span id="notification-count" class="badge" style="display:none;">0</span>
    </a>
</li>              
         
              
                <li><a href="../index.php"><i class="fa fa-power-off"></i> Logout</a></li>
            </ul>
        </div>
        <!-- Sidebar End -->
			

			  		<!-- PAGE CONTENT -->
			  		<div id="page-content-wrapper">
			  			<div class="container-fluid">
			  				
			  				<div class="row">
			  					<div class="col-md-5 offset-md-7 text-right" style="color: #ccc;font-size: 16px; position: relative;">
			  						<p style="margin: 0px;margin-bottom: 0px; /*position: absolute*/;">Welcome <?php echo $_SESSION['name'].' '.$_SESSION['email']; ?> (FORMATEUR)</p>
			  					</div>
			  				</div>

			  				 <!-- Tab Name -->
			  				<ul class="nav nav-tabs" id="tab-name-area" style="margin-top: 5px;">
			  					<li class="nav-item active" id="tab_home" rel="pane_home" onclick="activate_tab(this.id,this.rel);"><a class="nav-link"> Dashboard </a></li>
			  				</ul>
			  				<!-- /Tab Name -->

			  				<div class="tab-content" style="margin-top: 0px;">

			  					<!-- PANE_HOME -->
			  					<div class="tab-pane active" id="pane_home">
			  						<div class="panel panel-default" style="border-top: 0px; padding: 5px;">

			  							<!-- PANEL-BODY -->
			  							<div class="panel-body">
			  								<br/>
			  								<div class="row">
			  									<div class="col-md-4 col-sm-12 col-xs-12">
			  										<div class="card alert-primary" rel="b" style="overflow: hidden;height: 103px;">
			  											<div class="card-title">
			  												<small>Total</small><br/>Cooperation
			  											</div>
				  										<div class="card-body">
														  <?php echo $totalCorporations; ?> 
				  										</div>
			  										</div>
			  									</div>
			  									<div class="col-md-4 col-sm-12 col-xs-12">
			  										<div class="card alert-success" rel="st" style="overflow: hidden;height: 103px;">
			  											<div class="card-title">
			  												<small>Membre</small><br/>Total
			  											</div>
				  										<div class="card-body">
														  <?php echo $totalUsers; ?>
				  										</div>
			  										</div>
			  									</div>
			  									<div class="col-md-4 col-sm-12 col-xs-12">
			  										<div class="card alert-info" rel="s" style="overflow: hidden;height: 103px;">
			  											<div class="card-title">
			  												<small>Message</small><br/>Total
			  											</div>
				  										<div class="card-body">
														  <?php echo $totalMessages; ?>
				  										</div>
			  										</div>
			  									</div>
			  								</div>
			  									<br/>
												<br/>
												<hr>
												<br/>
			  								<div class="row" style="margin-top: 50px;">
			  									<div class="col-md-12">
			  										<div id="yearly_income_container">
			  											<canvas id="yearly_income" style="height: 300px;width: 100%"></canvas>
			  										</div>
			  										<span class="lead text-center d-block" style="margin: 10px;">Achat Vs. Vante</span>
			  									</div>
			  								</div>
												<br/>
												<br/>
												<hr>
												<br/>
			  								<div class="row">
				  								<div class="col-md-12">
				  									<div class="lead d-block text-center" style="margin: 10px;">
				  										ENVOYER UN FICHIER
				  									</div>
													  <form name="file_upload_form" id="file_upload_form" method="POST" enctype="multipart/form-data" action="broadcast.php">
														<div class="row">
															<div class="col-md-12">
																<input type="file" name="upload_file" id="upload_file" class="form-control" required />
															</div>
														</div>
														<div class="row" style="margin-top: 20px;">
															<div class="col-md-4">
																<label><input type="radio" name="recipient" value="users" required /> Send to Users</label>
															</div>
															<div class="col-md-4">
																<label><input type="radio" name="recipient" value="corporations" required /> Send to Corporations</label>
															</div>
															<div class="col-md-4">
																<label><input type="radio" name="recipient" value="formateurs" required /> Send to Formateurs</label>
															</div>
														</div>
														<div class="row" style="margin-top: 20px;">
															<div class="col-md-12 text-right">
																<button id="btn_upload" class="btn btn-outline-primary" type="submit">Upload and Send</button>
															</div>
														</div>
														</form>

				  								</div>
			  								</div>
											<br/>
											<br/>
											<hr>
											<br/>
			  								<div class="row" id="calendar-body">
			  									<div class="col-md-12">
			  										<div id='calendar'></div>
			  									</div>
			  								</div>

			  							</div>	<!-- PANEL-BODY CLOSE -->

			  						</div>
			  					</div>	<!-- TAB-PAN-HOME CLOSE-->
				
			  					<!-- DYNAMIC TAB CLOSE -->
			  				</div>	<!-- TAB-CONTENT CLOSE -->
							
							<!-- FOOTER -->
							<hr>
							<br/>
							<br/>
							<br/>
							<div id="footer-wrapper">
								<div class="row">
									
									<div class="col-md-3" style="padding-left: 75px;">
										<h3>Quick Links</h3>
										<ul>
											<li><a href="../index.php" target="_blank">Home</a></li>
											<li><a href="../aboutus.php" target="_blank">About Us</a></li>
											<li><a href="../contact.php" target="_blank">Contact us</a></li>
											<li><a href="../contact.php" target="_blank">Help</a></li>
										</ul>
									</div>
									<div class="col-md-3" style="padding-left: 75px;">
										<h3>Have a Question?</h3>
										<ul>
											<li class="contact-info"><i class="fa fa-map-marker"></i>Surat | Gujarat</li>
											<li class="contact-info"><i class="fa fa-phone"></i>+91 704-305-6077</li>
											<li class="contact-info"><i class="fa fa-envelope"></i>tms@gmail.com</li>
										</ul>
									</div>
									<div class="col-md-3 float-right" style="padding-left: 75px;">
										<p><span class="fas fa-arrow-up" style="font-size: 16px; color: darkgray;"></span><a href="#" style="color: darkgray; font-size: 15px;"> Back to top</a></p>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<ul class="social-media-list">
											<li class="bg-info">
												<a class="contact-icon" href="#"><i class="fab fa-facebook-f"></i></a>
											</li>
											<li class="bg-info">
												<a class="contact-icon" href="#"><i class="fab fa-twitter"></i></a>
											</li>
											<li class="bg-info">
												<a class="contact-icon" href="#"><i class="fab fa-instagram"></i></a>
											</li>
											<li class="bg-info">
												<a class="contact-icon" href="#"><i class="fab fa-google-plus-g"></i></a>
											</li>
										</ul>
									</div>
								</div>
								<div class="row">
									<div class="col-md-2 offset-md-5 text-center">
										<p>
										</p>
									</div>
								</div>
							</div>
							<!-- \FOOTER -->

			  			</div>	<!-- CONTAINER-FLUID CLOSE -->
			  		</div>	<!-- PAGE CONTENT CLOSE-->
			  	</div>
			  </section>

			
			  

			  <!-- <script type="text/javascript" src="../js/jquery_ui/jquery-ui.min.js"></script> -->
			  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
			  <!-- <script type="text/javascript" src="../js/Chart_js/dist/Chart.min.js"></script> -->
			  <script type="text/javascript" src="../js/reports.js"></script>
			  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

			  <!-- <link rel="stylesheet" type="text/css" href="../js/jquery-ui.css"> -->
			  <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

			  <script type="text/javascript">
		var removed_li; //	"id" of nav-item which is removed
		var n=1; // count number of branch increment | decrement "id"
		/* function to add New Branch in pane_branch */
		function add_branch(){
			n=n+1;
			bid ='branch'+n;
			data = '<tr id="newbranch'+n+'"><td><span class="badge" id="cont'+n+'" style="margin-top: 0px; margin-left: 0px; background: transparent; color:#000; font-size: 15px;">'+n+'.</span></td><td><input type="text" name="b_address[]" class="b_address input" id="b'+n+'_address" placeholder="Shop no. / Area" value=" "><span class="text-danger b_address_error" id="error-b'+n+'_address"></span></td><td><select name="b_state[]" id="b'+n+'_state" class="b_state input" onchange="fetchCities(this.value,\'b'+n+'_city\');"><option disabled selected value="0">State</option><?php foreach ($result as $r){echo '<option value="'.$r['stateID'].'" style="color:#111;">'.$r['stateName'].'</option>';}?></select><span class="text-danger" id="error-b'+n+'_state"></span></td><td><select id="b'+n+'_city" name="b_city[]" class="b_city input" style="border: 1px solid #ddd; width: 200px;"><option disabled selected>City</option></select><span class="text-danger" id="error-b'+n+'_city"></span></td><td><input type="text" name="b_phn[]" class="b_phn input" placeholder="Phone No." value=" "><span class="text-danger b_phn_error" id="error-b'+n+'_phn"> </span></td><td><button type="button" class="btn btn-danger btn-xs remove" onclick="remove_tr(\'newbranch'+n+'\');"><span class="glyphicon glyphicon-remove"></span></button></td></tr>';
			//alert(data);
			$('#new_branch_data').append(data);
			$('#'+n+'cont').html(n);
		}
		//---------------------------------------------------------

		// FUNCTION to Activate Tabs by cliking on them	: tab_branch, tab_stud, tab_staff, tab_report, tab_settings, tab_logout
		function activate_tab(tab_id,tab_rel){

				if (tab_id == removed_li){return;}	// If the TAB is ALREADY REMOVED

					// INACTIVE CURRENT "active" TAB ; "active" CLICKED TAB
					$('.nav-item.active').removeClass('active');
					$('#'+tab_id).addClass('active');

					// INACTIVE CURRENT "active" PANE ; "active" PANE OF CLICKED TAB
					$('.tab-pane.active').removeClass('active');
					
					$tab_pane = $('.nav-item.active').attr('rel');
					$('#'+$tab_pane).addClass('active');
				}

				function checkNotifications() {
    fetch('check_notifications.php')
        .then(response => response.json())
        .then(data => {
            const notificationCount = document.getElementById('notification-count');
            if (data.unread_count > 0) {
                notificationCount.textContent = data.unread_count;
                notificationCount.style.display = 'inline';  // Show the badge
            } else {
                notificationCount.style.display = 'none';   // Hide the badge
            }
        });
}

// Check notifications every 10 seconds
setInterval(checkNotifications, 10000);

		</script>
</body>
</html>




<!-- DASHBOARD ==> STAFF LOGIN -->

