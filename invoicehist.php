<?php
session_start();

$role = $_SESSION['role'];

if ($role !== "manager" || !isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$loggedInUser = $_SESSION['username'];
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
        <!-- Sidebar and navigation content -->
        <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <!-- Your existing sidebar content -->
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
        <h2 class="mb-4">Invoice History</h2>
        <div class="button-container">
            <!-- Buttons to display different tables -->
            <a class="button" href="?table=gs1">Oxman (Pandamatenga)</a>
            <a class="button" href="?table=gs2">Tuli (Martins Drift)</a>
            <a class="button" href="?table=gs3">Kwanokeng (Phakalane)</a>
            <a class="button" href="?table=gs4">Kwanokeng (Francistown)</a>
        </div>

        <?php
        if (isset($_GET['table'])) {
            $selectedTable = $_GET['table'];
            if($selectedTable == 'gs1'){
                $credtable = "Oxman (Pandamatenga)";
            }elseif ($selectedTable == 'gs2') {
                $credtable = "Tuli (Martins Drift)";
            }elseif ($selectedTable == 'gs3') {
                $credtable = "Kwanokeng (Phakalane)";
            }elseif($selectedTable == 'gs4'){
                $credtable = "Kwanokeng (Francistown)";
            }

            require_once("dbconfig.php");

            // Query to calculate the sum of credits for different suppliers
            $fetchsql = "SELECT availcreds FROM accs WHERE supplier= '$credtable'";
            $availres = $conn->query($fetchsql);

            if ($availres->num_rows > 0) {
                while ($availsupplier = $availres->fetch_assoc()) {
                    $availableCredits = $availsupplier["availcreds"];
                    echo "<h4 style='color:white;'>Total Credits: " . number_format($availableCredits, 2) . "</h4>";
                }
            } else {
                echo 'Error';
            }

            // Query to fetch data from the selected table
            $sql = "SELECT * FROM $selectedTable";
            $result = $conn->query($sql);

            // Display the data in an HTML table
            if ($result->num_rows > 0) {
                echo '<table>
                        <tr>
                            <th>Order No.</th>
                            <th>Supplier</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Invoice Amount</th>
                            <th>Fleet</th>
                            <th>Horse</th>
                            <th>Driver</th>
                            <th>Approval Time</th>
                            <th>Generate PDF</th>
                        </tr>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td align="center"> <b>' . $row['order_num'] . '</b> </td>
                            <td>' . $row['supplier'] . '</td>
                            <td>' . $row['product'] . '</td>
                            <td>' . $row['quantity'] . '</td>
                            <td>' . $row['amnt'] . '</td>
                            <td>' . $row['fleet'] . '</td>
                            <td>' . $row['horse'] . '</td>
                            <td>' . $row['driver'] . '</td>
                            <td>' . $row['approval_time'] . '</td>
                            <td> <a href="test2.php?id=' . $row['order_num'] . '&supplier=' . $row['supplier'] . '" class="btn btn-secondary">Download PDF</a> </td> 
                            
                        </tr>';
                }

                echo '</table>';
            } else {
                echo "No data found in $selectedTable.";
            }
            $conn->close();
        }
        ?>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
