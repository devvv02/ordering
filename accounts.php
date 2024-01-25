<?php
session_start();
$role = $_SESSION['role'];
if($role != "manager"){
  header("Location: index.php"); // Redirect to the login page if role is different
  exit();
}// Check if the user is logged in
elseif (!isset($_SESSION['username'])) {
  header("Location: index.php"); // Redirect to the login page if not logged in
  exit();
}

// Display user information
$loggedInUser = $_SESSION['username'];


// You can fetch additional user data from the database if needed

?>

<!doctype html>
<html lang="en">
  <head>
  	<title>Manager Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/style1.css">
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

   /* Add CSS styles for the buttons */
   .button-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Style buttons on hover */
        .button:hover {
            background-color: #0056b3;
        }

        /* Add CSS styles for the tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #333;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:nth-child(odd) {
            background-color: #fff;
        }

        /* Add CSS to remove table border radius */
        table {
            border-radius: 0;
        }
        .hidden {
        display: none;
}
.navbar-branding {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    color: white;
    padding: 10px;
    text-align: center;
  }

  #content {
    position: relative;
    padding-bottom: 30px; /* Adjust this value to create enough space for the branding text */
  }
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
            <a href="hrdash.php"><span class="mr-3"> Home</a></span>
          </li>
          <li>
              <a href="allorders.php"><span class="mr-3"> Orders Placed</a></span>
          </li>
          <li>
            <a href="invoicehist.php"><span class="mr-3"> Invoice History</a></span>
          </li>
          <li>
            <a href="credhist.php"><span class="mr-3"> Credits history</a></span>
          </li>
          <li>
            <a href="accounts.php"><span class="mr-3"> Payments</a></span>
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

        <h2 class="mb-4">Pay Credits</h2>
        <div class="button-container">
    </div>
    <!--Pay Credits forms-->
    <div class="form-container" id="credform">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

            <label><h6 style="color:black"><b>Gas Station:<b></h6></label>
            <select id="supplier" name="supplier" required>
                  <option value="Oxman (Pandamatenga)">Oxman (Pandamatenga)</option>
                  <option value="Tuli (Martins Drift)">Tuli (Martins Drift)</option>
                  <option value="Kwanokeng (Phakalane)">Kwanokeng (Phakalane)</option>
                  <option value="Kwanokeng (Francistown)">Kwanokeng (Francistown)</option>
            </select>
<br>
            <label><br><h6 style="color:black"><b>Payment:<b></h6></label>
            <input type="number" id="credits" name="credits" required>

            <br>
            <p><br><button type="submit" name="submit">Submit</button></p>



    </form>
    </div>
    <?php
        if (isset($_POST['submit'])) {
            require_once("dbconfig.php");

            $supplier = $_POST['supplier'];
            $credits = $_POST['credits'];

            $creditsql = "INSERT INTO `creds`(`supplier`, `credited`, `paidby`) VALUES ('$supplier','$credits','$loggedInUser')";
            $fetchsql = "SELECT availcreds FROM accs WHERE supplier = '$supplier'";
            $res = mysqli_query($conn, $fetchsql);
            $row = mysqli_fetch_array($res);
            $availcreds = $row[0];
            $totalbalance = $availcreds + $credits;

            $updatesql = "UPDATE accs SET availcreds='$totalbalance' WHERE supplier='$supplier'";

            if ($conn->query($creditsql) === TRUE && $conn->query($updatesql) === TRUE) {
                echo "<script>alert('Payment Credited Successfully And Balance Is Updated.'); window.location.href = 'accounts.php';</script>";
            }

            $conn->close();
        }
        ?>

      </div>
      
  
		</div>


  </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>