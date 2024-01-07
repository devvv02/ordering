<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Page</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="indexstyle.css">
</head>
<body>
<div class="container">
  <div class="left">
    <div class="header">
      <h1 class="animation a1">WELCOME TO STANDARD SALES</h1>
      <h4 class="animation a2"><b>Log in to your account using username and password</b></h4>
    </div>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <div class="form">
        <input type="text" class="form-field animation a3" placeholder="Username" name="username" required>
        <input type="password" class="form-field animation a4" placeholder="Password" name="pass" required>
        <p> </p>
        <button type="submit" class="animation a6"> Log In </button>
      </div>
    </form>
  </div>
  <div class="right"></div>
</div>

<?php
session_start();
require_once("dbconfig.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['pass']);

    $query = "SELECT password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($storedHashedPassword, $role);
    $stmt->fetch();

    var_dump($storedHashedPassword); // Debug: Check what's stored in the password variable
    var_dump(password_verify($password, $storedHashedPassword)); // Debug: Verify password comparison


    if ($storedHashedPassword && password_verify($password, $storedHashedPassword)) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        
        if ($role === 'manager') {
          ?><script> windows.location.href = "hrdash.php"; </script><?php
            header("Location: hrdash.php"); // Redirect to the manager dashboard
            exit();
        } elseif ($role === 'emp') {
            header("Location: empdash.php"); // Redirect to the employee dashboard
            exit();
        }
    } else {
        header("Location: index.php?loginFailed=true"); // Redirect to login page with a flag indicating failed login
        exit();
    }

    $stmt->close();
}

mysqli_close($conn);
?>

</body>
</html>
