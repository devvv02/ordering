<?php
session_start();
$role = $_SESSION['role'];
if ($role != "manager") {
    header("Location: index.php"); // Redirect to the login page if role is different
    exit();
} elseif (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect to the login page if not logged in
    exit();
}

$loggedInUser = $_SESSION['username'];

?>

<!doctype html>
<html lang="en">

<head>
    <title>Manager Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Your stylesheet and other CSS -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/main.css">
 

    <style>
        /* Your existing styles */
        h5{
        color:white;
    }
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

  input[type="text"] {
            border: 1px solid #333;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px; /* Adjust the font size as needed */
            width: 100%;
        }

        /* Make read-only inputs appear like regular text */
        input[readonly] {
            border: none;
            background-color: white;
            color: black;
        }
        .navbar-branding {
    position: absolute;
    bottom:0;
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
  .submit-button {
  background-color: blue;
  color: white;
  padding: 10px 20px;
  border-radius: 5px;
  border: none;
  cursor: pointer;
  font-size: 16px;
}

.submit-button:hover {
  background-color: darkblue;
}
    </style>

</head>

<body>

    <div class="wrapper d-flex align-items-stretch">
        <!-- Sidebar -->
        <nav id="sidebar">
            <!-- Your sidebar content -->
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

        <!-- Page Content -->
        <div id="content" class="p-4 p-md-5 pt-5 " style="background-image: url('images/bg-03.png');">

            <h2 class="mb-4">Order Details</h2>

            <!-- PHP code to fetch data from the database -->
            <?php
            if (isset($_GET['id']) && isset($_GET['supplier'])) {
                // Your existing code to fetch order details
                  // Sanitize the input to prevent SQL injection
                  require_once("dbconfig.php");
        $id = $conn->real_escape_string($_GET['id']);
        $credsupplier = $conn->real_escape_string($_GET['supplier']);

        // Query to fetch order details based on the ID
        $sql = "SELECT order_num, supplier, product, quantity, rate, amnt, fleet, horse, driver FROM tempords WHERE order_num = '$id'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
        } else {
            echo '<p class="center-text">No data found for the selected order.</p>';
        }
        $fetchsql = "SELECT availcreds FROM accs WHERE supplier= '$credsupplier'";
        $availres = $conn->query($fetchsql);
        if ($availres->num_rows > 0){
          while ($availsupplier = $availres->fetch_assoc()) {
            $availableCredits = $availsupplier["availcreds"];
            //echo $availableCredits;
          }}else{echo 'Error';}

            } elseif (isset($_POST['approve'])) {
                require_once('dbconfig.php');

                // All your existing variables initialization
                $orderNumber = $_POST["ordernum"];
                $supplier = $_POST["supplier"];
                $product = $_POST["product"];
                $quantity = $_POST["quantity"];
                $rate = $_POST["rate"];
                $fleetNumber = $_POST["fleet"];
                $vehicleNumber = $_POST["vehiclenum"];
                $driverName = $_POST["driver"];
                $totalAmnt = $_POST["amnt"];
                $availableCredits = $_POST["credits"];
                $idToDelete = $_POST["ordernum"]; 

                // Logic to handle various suppliers
                $insertSql = "";
                $supplierTable = "";
                if ($supplier === "Oxman (Pandamatenga)") {
                    $insertSql = "INSERT INTO `gs1` (`order_num`, `supplier`, `product`, `quantity`, `rate`, `amnt`, `fleet`, `horse`, `driver`,`approved`) 
                    VALUES ('$orderNumber', '$supplier', '$product', '$quantity', '$rate', '$totalAmnt', '$fleetNumber', '$vehicleNumber', '$driverName', 'Yes')";
                    $supplierTable = "accs";
                } elseif ($supplier === "Tuli (Martins Drift)") {
                    // Assign query and table for Tuli
                    $insertSql = "INSERT INTO `gs2` (`order_num`, `supplier`, `product`, `quantity`, `rate`, `amnt`, `fleet`, `horse`, `driver`,`approved`) 
                    VALUES ('$orderNumber', '$supplier', '$product', '$quantity', '$rate', '$totalAmnt', '$fleetNumber', '$vehicleNumber', '$driverName', 'Yes')";
                    $supplierTable = "accs";
             
                } elseif ($supplier === "Kwanokeng (Phakalane)") {
                    // Assign query and table for Kwanokeng (Phakalane)
                    $insertSql = "INSERT INTO `gs3` (`order_num`, `supplier`, `product`, `quantity`, `rate`, `amnt`, `fleet`, `horse`, `driver`,`approved`) 
                    VALUES ('$orderNumber', '$supplier', '$product', '$quantity', '$rate', '$totalAmnt', '$fleetNumber', '$vehicleNumber', '$driverName', 'Yes')";
                    $supplierTable = "accs";
             
                } elseif ($supplier === "Kwanokeng (Francistown)") {
                    // Assign query and table for Kwanokeng (Francistown)
                    $insertSql = "INSERT INTO `gs4` (`order_num`, `supplier`, `product`, `quantity`, `rate`, `amnt`, `fleet`, `horse`, `driver`,`approved`) 
                    VALUES ('$orderNumber', '$supplier', '$product', '$quantity', '$rate', '$totalAmnt', '$fleetNumber', '$vehicleNumber', '$driverName', 'Yes')";
                    $supplierTable = "accs";
             
                }

                if ($insertSql !== "" && $supplierTable !== "") {
                    $sql = "DELETE FROM tempords WHERE order_num = '$orderNumber'";
                    $newcred = $availableCredits - $totalAmnt;
                    $updatesql = "UPDATE $supplierTable SET availcreds='$newcred' WHERE supplier='$supplier'";

                    if ($conn->query($insertSql) && $conn->query($sql) && $conn->query($updatesql)) {
                        ?>
                        <script>
                            alert("Order was successfully approved.");
                            <?php if($supplier === 'Oxman (Pandamatenga)'){
                              ?>
                              window.location.href = "invoicehist.php?table=gs1";
                              <?php
                            } elseif($supplier === 'Tuli (Martins Drift)'){
                              ?>
                              window.location.href = "invoicehist.php?table=gs2";
                              <?php
                            } elseif($supplier === 'Kwanokeng (Phakalane)'){
                              ?>
                              window.location.href = "invoicehist.php?table=gs3";
                              <?php
                            } elseif($supplier === 'Kwanokeng (Francistown)'){
                              ?>
                              window.location.href = "invoicehist.php?table=gs4";
                              <?php
                            }
                            ?>
                            
                        </script>
            <?php
                    $conn->close();
                }
            }
        }
        ?>

        <!-- Your HTML forms and elements -->
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <p>
        <label for="orderNumber">Order Number:</label>
        <input type="text" id="orderNumber" name="ordernum" value="<?php echo $row['order_num']; ?>" readonly>

        <label for="supplier">Supplier Name:</label>
        <input type="text" id="supplier" name="supplier" value="<?php echo $row['supplier']; ?>" readonly>

        <label for="product">Product:</label>
        <input type="text" id="product" name="product" value="<?php echo $row['product']; ?>" readonly>

        <label for="quantity">Quantity:</label>
        <input type="text" id="quantity" name="quantity" value="<?php echo $row['quantity']; ?>" readonly>

        <label for="fleetNumber">Rate:</label>
        <input type="text" id="rate" name="rate" value="<?php echo $row['rate']; ?>" readonly>

        <label for="quantity">Total Amount:</label>
        <input type="text" id="totalAmnt" name="amnt" value="<?php echo $row['amnt']; ?>" readonly>

        <label for="fleetNumber">Credit Available:</label>
        <input type="text" id="credits" name="credits" value="<?php echo $availableCredits; ?>" readonly>

        <label for="fleetNumber">Fleet Number:</label>
        <input type="text" id="fleetNumber" name="fleet" value="<?php echo $row['fleet']; ?>" readonly>

        <label for="vehicleNumber">Vehicle Number:</label>
        <input type="text" id="vehicleNumber" name="vehiclenum" value="<?php echo $row['horse']; ?>" readonly>

        <label for="driverName">Driver Name:</label>
        <input type="text" id="driverName" name="driver" value="<?php echo $row['driver']; ?>" readonly>
        <br><br>
        <button type="submit" class="submit-button" value="Approve!" name="approve">Approve!</button>
        </p>
    </form>

        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
