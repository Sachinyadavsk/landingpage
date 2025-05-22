<?php
require('confige.php');
require('functions.inc.php');
$msg = '';

if (isset($_POST['submit'])) {
    $name = get_safe_value($con, $_POST['name']);
    $email = get_safe_value($con, $_POST['email']);
    $mobile = get_safe_value($con, $_POST['mobile']);
    $password = get_safe_value($con, $_POST['password']);
    $confirm_password = get_safe_value($con, $_POST['confirm_password']);
    
    // Get IP Address
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // Get Device Information (Basic)
    $device = $_SERVER['HTTP_USER_AGENT'];

    // Validate if passwords match
    if ($password !== $confirm_password) {
        $msg = "Passwords do not match!";
    } else {
        // Check if email or mobile already exists
        $checkUser = "SELECT * FROM users WHERE email='$email' OR mobile='$mobile'";
        $res = mysqli_query($con, $checkUser);
        if (mysqli_num_rows($res) > 0) {
            $msg = "Email or Mobile Number already exists!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $role = 'user';

            // Insert user data
            $sql = "INSERT INTO users (name, email, mobile, role, password, ip, device, reset_token, created_at) 
                    VALUES ('$name', '$email', '$mobile', '$role', '$hashed_password', '$ip', '$device', NULL, NOW())";

            if (mysqli_query($con, $sql)) {
                header('Location: login.php?success=1');
                exit;
            } else {
                $msg = "Error: " . mysqli_error($con);
            }
        }
    }
}
?>

<!doctype html>
<html class="no-js" lang="">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Register Page</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="assets/css/normalize.css">
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      <link rel="stylesheet" href="assets/css/themify-icons.css">
      <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">
      <link rel="stylesheet" href="assets/css/flag-icon.min.css">
      <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
      <link rel="stylesheet" href="assets/css/style.css">
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
   </head>
   <style>
        .password-wrapper {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 76%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
   <body class="bg-dark">
      <div class="sufee-login d-flex align-content-center flex-wrap">
         <div class="container">
            <div class="login-content">
               <div class="login-form">
                   <div class="">
                       <p>Signing up is easy. It only takes a few steps</p>
                   </div>
                  <form method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input type="number" name="mobile" class="form-control" placeholder="Mobile Number" required>
                        </div>
                        
                        <!-- Password Field with Toggle -->
                        <div class="form-group password-wrapper">
                            <label>Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                            <i class="fa fa-eye toggle-password" onclick="togglePassword('password', this)"></i>
                        </div>
                    
                        <!-- Confirm Password Field with Toggle -->
                        <div class="form-group password-wrapper">
                            <label>Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                            <i class="fa fa-eye toggle-password" onclick="togglePassword('confirm_password', this)"></i>
                        </div>
                    
                        <div class="mb-4">
                            <div class="form-check">
                                <label class="form-check-label text-muted">
                                    <input type="checkbox" class="form-check-input">
                                    <i class="input-helper"></i>I agree to all Terms &amp; Conditions
                                </label>
                            </div>
                        </div>
                    
                        <button type="submit" name="submit" class="btn btn-dark btn-flat m-b-30 m-t-30">Sign in</button>
                    </form>
					
					<div class="signup_head">Already have an account? &nbsp;<a href="login.php">Login</a></div>
					<div class="field_error"><?php echo $msg?></div>
               </div>
            </div>
         </div>
      </div>
      <script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
      <script src="assets/js/popper.min.js" type="text/javascript"></script>
      <script src="assets/js/plugins.js" type="text/javascript"></script>
      <script src="assets/js/main.js" type="text/javascript"></script>
      <script>
        function togglePassword(fieldId, icon) {
            var passwordField = document.getElementById(fieldId);
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
        </script>
   </body>
</html>