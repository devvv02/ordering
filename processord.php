<?php
session_start();

$role = $_SESSION['role'];

if ($role !== "emp" || !isset($_SESSION['username'])) {
  header("Location: index.php"); // Redirect to the login page if the role is different or not logged in
  exit();
}

$loggedInUser = $_SESSION['username'];

$supplier = $product = $quantity = $rate = $fleetNumber = $vehicleNumber = $driverName = $totalAmnt = ''; // Initialize variables
// ordernumber generator function
  $prefix = 'INV';
  $suffix = 'SS';
  $sequenceFile = 'sequence.txt';  // File to store the current sequence number

  // Read the current sequence number from the file
  $startNumber = (int) file_get_contents($sequenceFile);

  // Generate the sequential part with leading zeros
  $sequentialPart = str_pad($startNumber, 4, '0', STR_PAD_LEFT);

  // Create the order number by combining the prefix, sequential part, and suffix
  $orderNumber = $prefix . $sequentialPart . $suffix;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $supplier = $_POST["supplier"];
  $product = $_POST["product"];
  $quantity = $_POST["quantity"];
  $rate = $_POST["rate"];
  $fleetNumber = $_POST["fleet"];
  $vehicleNumber = $_POST["vehiclenum"];
  $driverName = $_POST["driver"];
  $totalAmnt = $quantity * $rate;


  if (isset($_POST['confirm'])) {
    require_once('dbconfig.php');

    $insertSql = "INSERT INTO `tempords` (`order_num`, `supplier`, `product`, `quantity`, `rate`, `amnt`, `fleet`, `horse`, `driver`,`approved`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'No')";

    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("sssssssss", $orderNumber, $supplier, $product, $quantity, $rate, $totalAmnt, $fleetNumber, $vehicleNumber, $driverName);
    $stmt->execute();

    if ($stmt) {
       // Increment the sequence number for the next order
  $startNumber++;

  // Write the updated sequence number back to the file
  file_put_contents($sequenceFile, $startNumber);

      ?>
      <script>
        alert("Your order was successfully placed.");
        window.location.href = "neworder.php";
      </script>
      <?php
    } else {
      echo "Error inserting the order: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
    exit();
  }
}
?>

<!DOCTYPE html>
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
    /* Your custom styles */
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
label {
    color: white; /* Set the font color to white */
    /* Additional styling */

    /* Add any other styles you need */
  } 
  </style>
</head>
<body>
  <div class="wrapper d-flex align-items-stretch">
    <!-- Your sidebar and navigation content -->
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

  <div id="content" class="p-4 p-md-5 pt-5" style="background-image: url('images/bg-03.png');">
    <h2 class="mb-4">Order Preview</h2>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <label for="orderNumber">Order Number:</label>
      <input type="text" id="orderNumber" name="ordernum" value="<?php echo $orderNumber; ?>" readonly>
      <!-- Repeat the same for other form fields -->
      <label for="supplier">Supplier Name:</label>
        <input type="text" id="supplier" name="supplier" value="<?php echo $supplier; ?>" readonly>

        <label for="product">Product:</label>
        <input type="text" id="product" name="product" value="<?php echo $product; ?>" readonly>

        <label for="quantity">Quantity:</label>
        <input type="text" id="quantity" name="quantity" value="<?php echo $quantity; ?>" readonly>

        <label for="quantity">Total Amount:</label>
        <input type="text" id="totalAmnt" name="totalAmnt" value="<?php echo $totalAmnt; ?> as per <?php echo $rate; ?> rate" readonly>

        <input type="hidden" id="rate" name="rate" value="<?php echo $rate; ?>" readonly>

        <label for="fleetNumber">Fleet Number:</label>
        <input type="text" id="fleetNumber" name="fleet" value="<?php echo $fleetNumber; ?>" readonly>

        <label for="vehicleNumber">Vehicle Number:</label>
        <input type="text" id="vehicleNumber" name="vehiclenum" value="<?php echo $vehicleNumber; ?>" readonly>

        <label for="driverName">Driver Name:</label>
        <input type="text" id="driverName" name="driver" value="<?php echo $driverName; ?>" readonly>
        <br><br>
      <button type="submit" class="submit-button" value="Approve!" name="confirm">Confirm</button>
    </form>
  </div>

  <!-- Your JavaScript for dynamic input population and other functionalities -->
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>
