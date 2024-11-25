<?php


if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $cart_query = mysqli_query($con, "SELECT COUNT(*) AS item_count FROM cart WHERE user_id = '$user_id'");
  $cart_data = mysqli_fetch_assoc($cart_query);
  $cart_item_count = $cart_data['item_count'];
} else {
  $cart_item_count = 0; // Set to 0 if no user is logged in
}

?>
<style type="text/css" rel="stylesheet" >
    .navbar-nav .nav-item .nav-link
    {
      color: #fff;
      font-size: 20px;
    }
    .nav-link:hover
    {
      text-decoration: none;
    }
    .btn-link
    {
      color: #fff;
      font-size: 20px;
    }
    .btn-link:hover
    {
      text-decoration: none;
      color: #ccc;
    }
    
    /*.carousel-inner {margin-top: 50px; margin-bottom: 50px;}
    .carousel-inner .carousel-item img
    {
      height: 100%;
      width: 100%;
    }
    .carousel-item
    {
      background-color: #fff;
      overflow-x: hidden;
    }
    #btprev: hover, #btnnext: hover
    {
      background-color: #000000;
    }
    .input-group{width:600px; height:60px;}
    .course_link{color: darkcyan;}
    #dropdownMenuLink
    { 
      background: transparent;
      transition: none;
    }
    #dropdownMenuLink:hover{
      border: 0px;
      transition: none;
      color: #ccc;
    }*/

  </style>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <img class="rounded-circle" src="images/10.webp" width="50" height="40" alt="TMS">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
        
      </li>
      <li class="nav-item">
      <a href="conversation.php" class="btn btn-danger float-end">Contacter une coorperative</a>
        
      </li>
    
    </ul>
    <div class="cart">
    <a href="cart.php"><i class="fa fa-shopping-cart"></i><span class="badge"><?php echo $cart_item_count; ?></span></a>
</div>

    <button class="btn btn-link my-2 my-sm-0" type="button" onclick="window.location.replace('index.php')">Logout</button>
  </div>
</nav>


