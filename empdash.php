<?php
session_start();
$role = $_SESSION['role'];

if ($role !== "emp" || !isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect to the login page if role is different or user not logged in
    exit();
}

$loggedInUser = $_SESSION['username'];
?>

<!doctype html>
<html lang="en">
  <head>
  	<title>Employees Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/main.css">
<style>
  h2,p{
   color: #fff;
  }
  .content-bg{
  
  
  justify-content: center;
  align-items: center;

  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;
  position: relative;
  z-index: 1; 
  
  }
  .content-bg::before{
    content: "";

  position: absolute;
  z-index: -1;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  background-color: rgba(55, 55, 55, 0.9);
  }
    /* Style the branding text */
  </style>
    
  </head>
  <body>
   
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
	        </button>
        </div>
	  		<div class="img bg-wrap text-center py-4" style="background-image: url(images/bg_1.jpg);">
	  			<div class="user-logo">
	  				
          <h3>Welcome, <?php echo $loggedInUser; ?>!</h3>
	  			</div>
	  		</div>
        <ul class="list-unstyled components mb-5">
          <li class="active">
            <a href="empdash.php"><span class="mr-3"> Home</a></span>
          </li>
          <li>
              <a href="neworder.php"><span class="mr-3"> New Order</a></span>
          </li>
          <li>
            <a href="logout.php"><span class="mr-3"> Log Out</a> </span>
          </li>
        </ul>
        <div class="navbar-branding">
            <h1 align="center" class="animation a1" style="color:white;">STANDARD SALES</h1>
        </div>
    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5 " style="background-image: url('images/bg-03.png');">

        <h2 class="mb-4">Employees Dashboard</h2>
        <p>Based in Choma along the Great North Road we are perfectly situated to offer transport services to a wide range of locations and industries. With a fleet of over 30 heavy duty trucks capable of long range cross-border transport of bulk loads, we are the ideal transportation partner.</p>
            <!-- Your existing content -->
            <div id="myCarousel" class="carousel slide mt-5" data-ride="carousel" style="max-width: 1200px; margin: 0 auto;">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/img_0031.jpeg" class="d-block w-100" alt="Slide 1" style="max-height: 500px; object-fit: cover;">
                <!-- You can add captions or content for the slide if needed -->
            </div>
            <div class="carousel-item">
                <img src="images/img_0194.jpeg" class="d-block w-100" alt="Slide 2" style="max-height: 500px; object-fit: cover;">
                <!-- You can add captions or content for the slide if needed -->
            </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
      </div>
      
  
		</div>
    <script>
    // JavaScript for automatic sliding every 2 seconds
    document.addEventListener('DOMContentLoaded', function() {
        $('.carousel').carousel({
            interval: 4000 // Adjust this value to set the interval time in milliseconds (here, 2000ms = 2 seconds)
        });
    });
</script>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>