<?php
session_start();
if (isset($_SESSION['Email_Session'])) {
  header("Location: homepage/homelog.php");
  die();
}


include('config.php');
$msg = "";
$Error_Pass = "";
if (isset($_GET['Verification'])) {
  $raquet = mysqli_query($conx, "SELECT * FROM register WHERE CodeV='{$_GET['Verification']}'");
  if (mysqli_num_rows($raquet) > 0) {
    $query = mysqli_query($conx, "UPDATE register SET verification='1' WHERE CodeV='{$_GET['Verification']}'");
    if ($query) {
      $rowv = mysqli_fetch_assoc($raquet);
      header("Location: verifywelcome.php?id='{$rowv['id']}'");
    }else{
      header("Location: index.php");
    }
  } else {
    header("Location: index.php");
  }
}
if (isset($_POST['submit'])) {
  $email = mysqli_real_escape_string($conx, $_POST['email']);
  $Pass = mysqli_real_escape_string($conx, md5($_POST['Password']));
  $sql = "SELECT * FROM register WHERE email='{$email}' and Password='{$Pass}'";
  $resulte = mysqli_query($conx, $sql);
  if (mysqli_num_rows($resulte) === 1) {
    $row = mysqli_fetch_assoc($resulte);
    if ($row['verification'] === '1') {
      $_SESSION['Email_Session']=$email;
      header("Location: homepage/homelog.php");
    }else{$msg = "<div class='alert alert-info'>First Verify Your Account</div>";}
  }else{
    $msg = "<div class='alert alert-danger'>Email or Password is not match</div>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>" />
  <link rel="icon" href="img/pnplogo.png">
  <title>PNP Login</title>
  <style>
    .alert {
      padding: 1rem;
      border-radius: 5px;
      color: white;
      margin: 1rem 0;
      font-weight: 500;
      width: 65%;
    }

    .alert-success {
      background-color: #42ba96;
    }

    .alert-danger {
      background-color: #fc5555;
    }

    .alert-info {
      background-color: #2E9AFE;
    }

    .alert-warning {
      background-color: #ff9966;
    }
    .Forget-Pass{
      display: flex;
      width: 65%;
    }
    .Forget{
      color: #2E9AFE;
      font-weight: 500;
      text-decoration: none;
      margin-left: auto;
      
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="" method="POST" class="sign-in-form">
          <h2 class="title">Log In</h2>
          <?php echo $msg ?>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="email" placeholder="Email" required/>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="Password" placeholder="Password" required/>
          </div>
          <div class="Forget-Pass">
          <a href="Forget.php" class="Forget">Forget Password?</a></div>
          <input type="submit" name="submit" value="Login" class="btn solid" />
          <p class="social-text">Visit our social platforms</p>
          <div class="social-media">
            <a href="https://www.facebook.com/pnp.pio" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://twitter.com/pnphotline?lang=en" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="https://www.instagram.com/pnp_pio/" class="social-icon">
                            <i class="fab fa-instagram"></i>
                        </a>
            
          </div>
        </form>
      </div>
    </div>

    

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h2>Don't have an account? <br>Sign up here!</br></h2>
          <p class="invitext">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
            ex ratione. Aliquid!
          </p>
          <a href="SignUp.php" class="btn transparent" id="sign-in-btn" style="padding:10px 20px;text-decoration:none">
            Sign Up
          </a>
       
    </div>
  </div>

  <script src="app.js"></script>
</body>

<div class="logo-container">
    <img src="img/pnplogo.png" alt="Logo" class="logo" />
  </div>

</html>