<?php
session_start();

// Check if the user is logged in and has the 'emp' role, else redirect to the login page
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'emp') {
    header("Location: index.php");
    exit();
}

// Display user information
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
    <link rel="stylesheet" href="css/style1.css">
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
  /* Style for the fields that will be autofilled */
  .autofill-field {
    background-color: #d3d3d3; /* Change the background color as needed */
    color: #000; /* Change the text color as needed */
    font-style: bold; /* Optionally, you can use italic text */
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
        <h2 class="mb-4">Create A New Order</h2>
        <p>
        <div class="form-container">
        <form action="processord.php" method="POST">
        <!--
        <label><h6 style="color:black"><b>Order Number:<b></h6></label>
            <input type="number" id="ordernum" name="ordernum" required>-->

            <label><h6 style="color:black"><b>Supplier Name:<b></h6></label>
            <select id="supplier" name="supplier" required>
                  <option value="Oxman (Pandamatenga)">Oxman (Pandamatenga)</option>
                  <option value="Tuli (Martins Drift)">Tuli (Martins Drift)</option>
                  <option value="Kwanokeng (Phakalane)">Kwanokeng (Phakalane)</option>
                  <option value="Kwanokeng (Francistown)">Kwanokeng (Francistown)</option>
            </select>

            <label><h6 style="color:black"><b>Product:<b></h6></label>
            <select id="product" name="product" required>
                  <option value="Diesel">Diesel</option>
                  <option value="Petrol">Petrol</option>
            </select>
            
            <label><h6 style="color:black"><b>Quantity:<b></h6></label>
            <input type="number" id="quantity" name="quantity" required>

            <label><h6 style="color:black"><b>Rate:<b></h6></label>
            <input type="number" id="rate" name="rate" required>

            <label><h6 style="color:black"><b>Fleet Number:<b></h6></label>
            <input type="text" id="fleet" name="fleet" required>

            <label><h6 style="color:black"><b>Vehicle Number:<b></h6></label>
            <input type="text" id="vehicle" name="vehiclenum" class="autofill-field" required readonly>

            <label><h6 style="color:black"><b>Driver:<b></h6></label>
            <input type="text" id="drivername" name="driver" class="autofill-field" required readonly>
           
            
           

            <br>
            <p><br><button type="submit">Submit</button></p></form>
        </p>
        </div>
      </div>  
		</div>

    <!--Javascript-->
    <script>
  const textInput = document.getElementById("fleet");
  const inputField1 = document.getElementById("vehicle");
  const inputField2 = document.getElementById("drivername");

  textInput.addEventListener("input", function () {
    // Get the value from the text input field
    const inputValue = textInput.value;

    // Depending on the input value, update the other input fields
    if (inputValue === "064") {
      inputField1.value = "ABF8572";
      inputField2.value = "Levy Mutalife";
    } else if (inputValue === "065") {
      inputField1.value = "ABF8571";
      inputField2.value = "Darius";
    } else if (inputValue === "069") {
      inputField1.value = "AJB5437";
      inputField2.value = "Obert Tiyo";
    }else if (inputValue === "068") {
      inputField1.value = "ABJ5110";
      inputField2.value = "Mubita";
    }else if (inputValue === "067") {
      inputField1.value = "ABJ5109";
      inputField2.value = "Vincent Cheeba";
    }else if (inputValue === "065") {
      inputField1.value = "ABF8571";
      inputField2.value = "Darius Siabowa";
    }else if (inputValue === "101") {
      inputField1.value = "AKB3500ZM";
      inputField2.value = "Felix";
    }else if (inputValue === "092") {
      inputField1.value = "AKB2910";
      inputField2.value = "Festus Milumbe";
    }else if (inputValue === "066") {
      inputField1.value = "ABJ5100";
      inputField2.value = "Pasmore";
    } else if (inputValue === "071") {
      inputField1.value = "AJB88008";
      inputField2.value = "Clay Munene";
    } else if (inputValue === "075") {
      inputField1.value = "ABZ498";
      inputField2.value = "Lawrence Mayuwa";
    }else if (inputValue === "080") {
      inputField1.value = "ALB4961";
      inputField2.value = "Jeremiah";
    }else if (inputValue === "086") {
      inputField1.value = "AKB1460";
      inputField2.value = "Simon Chilokota";
    }else if (inputValue === "087") {
      inputField1.value = "AKB1464";
      inputField2.value = "Charles Hazemba";
    }else if (inputValue === "090") {
      inputField1.value = "AKB2210";
      inputField2.value = "Vincent";
    }else if (inputValue === "091") {
      inputField1.value = "AKB2670";
      inputField2.value = "Armstrong Hangoma";
    }else if (inputValue === "093") {
      inputField1.value = "AKB3164";
      inputField2.value = "Chrispine Hamaundu";
    }else if (inputValue === "094") {
      inputField1.value = "BAJ2075ZM";
      inputField2.value = "Frazer Hampande";
    }else if (inputValue === "095") {
      inputField1.value = "SS2018ZM";
      inputField2.value = "Jack Maambo";
    }else if (inputValue === "096") {
      inputField1.value = "BAL2881ZM";
      inputField2.value = "Kaluwe Nzombe";
    }else if (inputValue === "097") {
      inputField1.value = "BAL2882ZM";
      inputField2.value = "Phanuel Siachitema";
    }else if (inputValue === "098") {
      inputField1.value = "SS2020ZM";
      inputField2.value = "Chipoya Kayombo";
    }else if (inputValue === "099") {
      inputField1.value = "SS2021ZM";
      inputField2.value = "Willie Mweene";
    }else if (inputValue === "100") {
      inputField1.value = "SS2022ZM";
      inputField2.value = "Patson Kalich";
    }else if (inputValue === "102") {
      inputField1.value = "BAB2578";
      inputField2.value = "Rasoh Muleya";
    }else if (inputValue === "103") {
      inputField1.value = "BAV1944ZM";
      inputField2.value = "Josephat Zawe";
    }else if (inputValue === "104") {
      inputField1.value = "BAV1946ZM";
      inputField2.value = "Geoffrey Mphaka";
    } else if (inputValue === "106") {
      inputField1.value = "AKB3700ZM";
      inputField2.value = "Justine Hantambo";
    }else if (inputValue === "107") {
      inputField1.value = "BAZ5005ZM";
      inputField2.value = "Alick Siluwe";
    }else if (inputValue === "108") {
      inputField1.value = "SS2023ZM";
      inputField2.value = "Mespat Muntanga";
    }else if (inputValue === "110") {
      inputField1.value = "BBC8185";
      inputField2.value = "Killian";
    }else if (inputValue === "112") {
      inputField1.value = "ABK3968";
      inputField2.value = "Kennedy";
    }else if (inputValue === "113") {
      inputField1.value = "ABK3968";
      inputField2.value = "Emmanuel";
    }else {
      // Handle other input values or provide a default behavior
      inputField1.value = "";
      inputField2.value = "";
    }
  });
</script>
<!--
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");

    form.addEventListener("submit", function(event) {
      event.preventDefault(); // Prevent the form from submitting by default

      const orderNumber = document.getElementById("ordernum").value;

      fetch('check_order.php?orderNumber=' + orderNumber)
        .then(response => {
          if (response.ok) {
            form.submit(); // Order number doesn't exist, submit the form
          } else if (response.status === 409) {
            alert('Order number already exists. Please enter a different order number.');
          } else {
            alert('Error in checking the order number. Please try again.');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred. Please try again.');
        });
    });
  });
</script>-->


    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>