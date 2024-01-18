<?php
session_start();

$role = $_SESSION['role'];

if ($role !== "manager" || !isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}

$loggedInUser = $_SESSION['username'];

require_once("dbconfig.php");

$sql = "SELECT order_num, supplier, product, quantity, amnt, approved, placedtime FROM tempords ORDER BY placedtime ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Manager Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/main.css">
  <style>
    /* Your CSS styles */
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
  table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #333;
            padding: 10px;
            text-align: left;
            color: black;
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
          /* Style the hyperlink to make it stand out */
          a {
            color: #007BFF; /* Link color */
            text-decoration: none; /* Remove underline */
            
        }

        /* Change link color on hover */
        a:hover {
            color: #0056b3; /* Hover color */
        }
        td a {
            text-align: center;
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
    <!-- Your sidebar and navigation content -->
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
  

  <div id="content" class="p-4 p-md-5 pt-5" style="background-image: url('images/bg-03.png');">
    <h2 class="mb-4">Orders To Be Approved</h2>

    <?php
    if ($result->num_rows > 0) {
      echo '<table>
            <tr>
                <th>Order No.</th>
                <th>Supplier</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total Amount</th>
                <th>Placed time</th>
                
            </tr>';

      while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td align="center"> <b> <a href="order_details.php?id=' . $row['order_num'] . '&supplier=' . $row['supplier'] . ' ">' . $row['order_num'] . '</b> </td>
                <td> <b><u> <a href="order_details.php?id=' . $row['order_num'] . '&supplier=' . $row['supplier'] . '">' . $row['supplier'] . '</td>
                <td> <b> <a href="order_details.php?id=' . $row['order_num']  . '&supplier=' . $row['supplier'] . '">' . $row['product'] . '</td>
                <td> <b> <a href="order_details.php?id=' . $row['order_num']  . '&supplier=' . $row['supplier'] . '">' . $row['quantity'] . '</td>
                <td> <b> <a href="order_details.php?id=' . $row['order_num']  . '&supplier=' . $row['supplier'] . '">' . $row['amnt'] . '</td>
                <td> <b> <a href="order_details.php?id=' . $row['order_num']  . '&supplier=' . $row['supplier'] . '">' . $row['placedtime'] . '</u> </td>
            </tr>';
      }

      echo '</table>';
    } else {
      echo "No data found.";
    }

    $conn->close();
    ?>

  </div>

  <script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
</body>

</html>
