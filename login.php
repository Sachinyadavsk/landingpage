<?php
require('confige.php');
require('functions.inc.php');
$msg='';
if(isset($_POST['submit'])){
	$username=get_safe_value($con,$_POST['username']);
	$password=get_safe_value($con,$_POST['password']);
   $role=get_safe_value($con,$_POST['role']);
	$sql="select * from users where email='$username'";
	$res=mysqli_query($con,$sql);
	$count=mysqli_num_rows($res);
	if($count>0){
		$row=mysqli_fetch_assoc($res);
			$verify=password_verify($password,$row['password']);
			if($verify==1){
			$_SESSION['ADMIN_LOGIN']='yes';
			$_SESSION['ADMIN_ID']=$row['id'];
			$_SESSION['ADMIN_USERNAME']=$username;
            $_SESSION['ROLE']=$row['role'];
			header('location:active_thema.php');
			die();
			}
			else{
			$msg="Please enter correct login details";
			}
	}else{
		$msg="Please enter correct login details";	
	}
	
}
?>
<!doctype html>
<html class="no-js" lang="">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Login Page</title>
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
   <body class="bg-dark">
      <div class="sufee-login d-flex align-content-center flex-wrap">
         <div class="container">
            <div class="login-content">
               <div class="login-form mt-150">
                   <div class="">
                       <p><b>Hello! let's get started</b></p>
                       <p>Sign in to continue.</p>
                   </div>
                  <form method="post">
                     <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                     </div>
                     <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                     </div>
                     <!--<div class="form-group">-->
                     <!--   <label>Role</label>-->
                     <!--   <select name="role" class="form-control" required>-->
                     <!--       <option value="">--Select--</option>-->
                     <!--       <option value="admin">Admin</option>-->
                     <!--       <option value="user">User</option>-->
                     <!--       </select>-->
                     <!--</div>-->
                     <div class="my-2 d-flex justify-content-between align-items-center">
					    <div class="form-check">
					        <label class="form-check-label text-muted">
					            <input type="checkbox" class="form-check-input" required>
					            <i class="input-helper"></i>Keep me signed in</label>
					            </div><a href="!#" class="auth-link text-black">
					                Forgot password?</a></div>
                     <button type="submit" name="submit" class="btn btn-dark btn-flat m-b-30 m-t-30">Sign in</button>
					</form>
					
					<div class="signup_head">Don't have an account?&nbsp;<a href="register.php">Create</a></div>
					<div class="field_error"><?php echo $msg?></div>
               </div>
            </div>
         </div>
      </div>
      <script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
      <script src="assets/js/popper.min.js" type="text/javascript"></script>
      <script src="assets/js/plugins.js" type="text/javascript"></script>
      <script src="assets/js/main.js" type="text/javascript"></script>
   </body>
</html>