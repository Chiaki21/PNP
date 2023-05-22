<?php
session_start();
if (isset($_SESSION['Email_Session'])) {
    header("Location: verifywelcome.php");
    die();
}
include('config.php');
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
$msg = "";
$Error_Pass="";
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conx, $_POST['Username']);
    $email = mysqli_real_escape_string($conx, $_POST['Email']);
    $Password = mysqli_real_escape_string($conx, md5($_POST['Password']));
    $Confirm_Password = mysqli_real_escape_string($conx, md5($_POST['Conf-Password']));
    $Code = mysqli_real_escape_string($conx, md5(rand()));
    if (mysqli_num_rows(mysqli_query($conx, "SELECT * FROM register where email='{$email}'")) > 0) {
        $msg = "<div class='alert alert-danger'>This Email:'{$email}' has been alredy existe.</div>";
    } else {
        if ($Password === $Confirm_Password) {
            $query = "INSERT INTO register(`Username`, `email`, `Password`, `CodeV`) values('$name','$email','$Password','$Code')";
            $result = mysqli_query($conx, $query);
            if ($result) {
                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->SMTPDebug = 0;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'thisisadummyacc4554@gmail.com';                     // SMTP username
                    $mail->Password   = 'fbcjfealmqrrtfhr';                            //SMTP password
                    $mail->SMTPSecure = 'Tls';            //Enable implicit TLS encryption
                    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('thisisadummyacc4554@gmail.com','PNP');
                    $mail->addAddress($email,$name);
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Welcome To My Website';
                    $mail->Body    = '<p> This is the Verifecation Link<b><a href="http://localhost/logemail/?Verification='.$Code.'">"http://localhost/logemail/?Verification='.$Code.'"</a></b></p>';

                    $mail->send();
                    
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                $msg = "<div class='alert alert-info'>we've send a verification code on Your email Address</div>";
            } else {
                $msg = "<div class='alert alert-danger'>Something was Wrong</div>";
                
            }
        } else {
            $msg = "<div class='alert alert-danger'>Password and Confirm Password is not match</div>";
            $Error_Pass='style="border:1px Solid red;box-shadow:0px 1px 11px 0px red"';
        }
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
    <title>Sign in & Sign up Form</title>
    <link rel="icon" href="img/pnplogo.png">
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
    </style>
    <script>
        function checkPasswordStrength() {
            const passwordInput = document.getElementById('password-input');
            const strengthText = document.getElementById('password-strength');

            const password = passwordInput.value;
            const strength = calculatePasswordStrength(password);

            strengthText.innerText = 'Password Strength: ' + strength;
            strengthText.style.color = 'white';
        }

        function calculatePasswordStrength(password) {
            // Perform your password strength calculation here
            // Return a string indicating the strength (e.g., weak, medium, strong)
            // You can customize this function according to your requirements
            if (password.length < 6) {
                return 'Weak';
            } else if (password.length < 8) {
                return 'Medium';
            } else {
                return 'Strong';
            }
        }
    </script>
</head>

<body>
    <div class="container sign-up-mode">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="" method="POST" class="sign-up-form">
                    <h2 class="title">Sign up</h2>
                    <?php echo $msg ?>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="Username" placeholder="Username" value="<?php if (isset($_POST['Username'])) {
                                                                                                echo $name;
                                                                                            } ?>" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="Email" placeholder="Email" value="<?php if (isset($_POST['Email'])) {
                                                                                        echo $email;
                                                                                    } ?>" required />
                    </div>
                    <div class="input-field" <?php echo $Error_Pass ?>>
                        <i class="fas fa-lock"></i>
                        <input type="password" name="Password" id="password-input" placeholder="Password" onkeyup="checkPasswordStrength()" required />
                    </div>
                    <div class="input-field" <?php echo $Error_Pass ?>>
                        <i class="fas fa-lock"></i>
                        <input type="password" name="Conf-Password" placeholder="Confirm Password" required />
                    </div>
                    <span id="password-strength"></span>
                    <input type="submit" name="submit" class="btn" value="Sign up" />
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
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h2>Already have an account? <br>Try logging in!</br></h2>
                    <p class="invitext">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
                        laboriosam ad deleniti.
                    </p>
                    <a href="index.php" class="btn transparent" id="sign-in-btn" style="padding:10px 20px;text-decoration:none">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
