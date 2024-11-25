<?php
include('includes/connection.php');
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
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard | Cocoa-Corp</title>
    <!-- Meta tags and external files here -->
    <link href='../fullcalendar/assets/css/fullcalendar.css' rel='stylesheet' />
    <script src='../fullcalendar/assets/js/jquery-1.10.2.js' type="text/javascript"></script>
    <script src='../fullcalendar/assets/js/fullcalendar.js' type="text/javascript"></script>
</head>
<body style="background-color: #ededed;">
    <section id="section">
        <div id="wrapper">
            <!-- Sidebar -->
            <div id="sidebar-wrapper" style="position: fixed;">
                <div class="text-center" id="brand" style="margin-top: 15px;">
                    <img src="../images/logo.png" class="img-fluid rounded" alt="Cocoa Logo"/>
                    <h3>Cocoa Platform</h3>
                </div>
                <hr style="border-color: #222; width: 90%;" />
                <ul class="sidebar-nav">
                    <li><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="#"><i class="fa fa-users"></i> Manage Buyers</a></li>
                    <li><a href="#"><i class="fa fa-building"></i> Manage Corporations</a></li>
                    <li><a href="#"><i class="fa fa-user-tie"></i> Manage Coaches</a></li>
                    <li><a href="#"><i class="fa fa-users-cog"></i> Manage Members</a></li>
                    <li><a href="#"><i class="fa fa-file-alt"></i> Region</a></li>
                    <li><a href="#"><i class="fa fa-user"></i> Ville/Village</a></li>
                    <li><a href="#"><i class="fa fa-power-off"></i> Logout</a></li>
                </ul>
            </div>
            <!-- Sidebar End -->

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div class="container-fluid">
                    <!-- Dashboard Metrics -->
                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="card alert-primary" style="overflow: hidden; height: 103px;">
                                <div class="card-title">
                                    <small>Total</small><br/>Corporations
                                </div>
                                <div class="card-body">
                                    <?php echo $totalCorporations; ?> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="card alert-success" style="overflow: hidden; height: 103px;">
                                <div class="card-title">
                                    <small>Total</small><br/>Users
                                </div>
                                <div class="card-body">
                                    <?php echo $totalUsers; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="card alert-info" style="overflow: hidden; height: 103px;">
                                <div class="card-title">
                                    <small>Total</small><br/>Messages
                                </div>
                                <div class="card-body">
                                    <?php echo $totalMessages; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br/><hr/><br/>

                    <!-- File Upload Form -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lead d-block text-center" style="margin: 10px;">
                                Upload Files
                            </div>
                            <form name="file_upload_form" id="file_upload_form" method="POST" enctype="multipart/form-data">
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

                    <br/><hr/><br/>

                    <!-- Calendar -->
                    <div class="row" id="calendar-body">
                        <div class="col-md-12">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function(){
            // Initialize Calendar
            var calendar = $('#calendar').fullCalendar({
                header: {
                    left: 'title',
                    center: 'agendaDay,agendaWeek,month',
                    right: 'prev,next today'
                },
                editable: true,
                selectable: true,
                defaultView: 'month',
                events: [
                    {
                        title: 'Sample Event',
                        start: new Date()
                    },
                ]
            });
        });
    </script>
</body>
</html>
