<?php
require('top.inc.php');


$name = '';
$email  = '';
$password = '';
$mobile = '';
$skype  = '';
$whatsapp = '';
$telegram = '';
$facebook = '';
$msg = '';


  if (isset($_SESSION['ADMIN_ID']) && $_SESSION['ADMIN_ID'] != '') {
    $id = $_SESSION['ADMIN_ID'];
    $res = mysqli_query($con, "SELECT * FROM users WHERE id='$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $name = $row['name'];
        $email = $row['email'];
        $mobile = $row['mobile'];
        $skype = $row['skype'];
        $whatsapp = $row['whatsapp'];
        $telegram = $row['telegram'];
        $facebook = $row['facebook'];
    } else {
        header('location:setting.php');
        die();
    }
 }

if (isset($_POST['submit'])) {
    $name = get_safe_value($con, $_POST['name']);
    $email = get_safe_value($con, $_POST['email']);
    $mobile = get_safe_value($con, $_POST['mobile']);
    $skype = get_safe_value($con, $_POST['skype']);
    $whatsapp = get_safe_value($con, $_POST['whatsapp']);
    $telegram = get_safe_value($con, $_POST['telegram']);
    $facebook = get_safe_value($con, $_POST['facebook']);

    $res = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        if (isset($_SESSION['ADMIN_ID']) && $_SESSION['ADMIN_ID'] != '') {
            $getData = mysqli_fetch_assoc($res);
            if ($id == $getData['id']) {
                // Allowed to proceed for update
            } else {
                $msg = "Game already exists";
            }
        } else {
            $msg = "Game already exists";
        }
    }


        if ($msg == '') {
            if (isset($_SESSION['ADMIN_ID']) && $_SESSION['ADMIN_ID'] != '') {
                 $update_sql = "UPDATE users SET name='$name', email='$email', mobile='$mobile', skype='$skype', whatsapp='$whatsapp', telegram='$telegram', facebook='$facebook' WHERE id='$id'";
                 mysqli_query($con, $update_sql);
            } else {
                mysqli_query($con, "INSERT INTO users (name, email, mobile, skype, whatsapp, telegram, facebook) VALUES ('$name', '$email', '$mobile', '$skype', '$whatsapp', '$telegram', '$facebook')");
            }
            header('location:setting.php');
            die();
        }
    
}
?>

<!--change the passord -->

<?php
if (isset($_SESSION['ADMIN_ID']) && $_SESSION['ADMIN_ID'] != '') {
    $admin_id = $_SESSION['ADMIN_ID'];

    if (isset($_POST['change'])) {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password != $confirm_password) {
            $msg = "New and Confirm Password do not match!";
        } else {
            // Check old password
            // $check = mysqli_query($con, "SELECT * FROM users WHERE id='$admin_id' AND password='$old_password'");
              $result = mysqli_query($con, "SELECT password FROM users WHERE id='$admin_id'");
            if ($row = mysqli_fetch_assoc($result)) {
                // Verify old password
                if (password_verify($old_password, $row['password'])) {
                    // Hash and update new password
                    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                    $update = mysqli_query($con, "UPDATE users SET password='$hashed_password' WHERE id='$admin_id'");

                    if ($update) {
                        $msg = "<span style='color: green;'>Password changed successfully!</span>";
                    } else {
                        $msg = "Failed to update password.";
                    }
                } else {
                    $msg = "Old password is incorrect!";
                }
            } else {
                $msg = "User not found!";
            }
        }
    }
} else {
    header("Location: login.php");
    exit;
}
?>


<div class="content pb-0">
    <div class="orders">
                <div class="row">
                   <div class="col-sm-12 col-md-12 col-lg-12">
                       <div class="row">
                             <div class="col-sm-12 col-md-6 col-lg-6">
                                 <form method="post" enctype="multipart/form-data">
                                    <div class="card">
                                  <div class="card-body">
                                      <div class="card mb-3">
                                          <h5 class="card-title">User info</h5>
                                            <div class="info_details">
                                                <span class="info_id">id&nbsp;87520<?php echo $_SESSION['ADMIN_ID'];?></span>
                                                <span class="info_heading"><?php echo $_SESSION['ADMIN_USERNAME'];?></span>
                                            </div>
                                            <hr>
                                        <div class="form-group">
                                             <label for="disabledTextInput">Nickname</label>
                                           <input type="text" class="form-control" id="inlineFormInputName" placeholder="Nickname" name="name" required value="<?php echo $name;?>">
                                        </div>
                                        
                                         <div class="form-group">
                                             <label for="disabledTextInput">Email</label>
                                           <input type="email" class="form-control" id="inlineFormInputName" placeholder="Email" name="email" required value="<?php echo $email;?>">
                                        </div>
                                         <div class="form-group">
                                             <label for="disabledTextInput">Phone number</label>
                                           <input type="number" class="form-control" id="inlineFormInputName" placeholder="Phone number" name="mobile" required value="<?php echo $mobile;?>">
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                 <div class="form-group">
                                                     <label for="disabledTextInput">Skype</label>
                                                   <input type="text" class="form-control" id="inlineFormInputName" placeholder="Skype" name="skype" required value="<?php echo $skype;?>">
                                                </div>
                                                 <div class="form-group">
                                                     <label for="disabledTextInput">Telegram</label>
                                                   <input type="text" class="form-control" id="inlineFormInputName" placeholder="Telegram" name="telegram" required value="<?php echo $telegram;?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                     <label for="disabledTextInput">WhatsApp</label>
                                                   <input type="text" class="form-control" id="inlineFormInputName" placeholder="WhatsApp" name="whatsapp" required value="<?php echo $whatsapp;?>"> 
                                                </div>
                                                 <div class="form-group">
                                                     <label for="disabledTextInput">Facebook</label>
                                                   <input type="text" class="form-control" id="inlineFormInputName" placeholder="Facebook" name="facebook" required value="<?php echo $facebook;?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="create_cam text-center">
                                       <button id="createWebsiteBtn" name="submit" type="submit" class="btn btn-lg btn-info">
                                            <span id="payment-button-amount">Save changes</span>
                                        </button>
                                        <div class="field_error">
                                            <?php echo $msg ?>
                                        </div>
                                    </div>
                                      </div>
                                     
                                  </div>
                                </div>
                                    
                                </form>
                                
                             </div>
                             <div class="col-sm-12 col-md-6 col-lg-6">
                                  <form method="post" enctype="multipart/form-data">
                                     <div class="card">
                                      <div class="card-body">
                                           <div class="card mb-3">
                                                <h5 class="card-title">Change password</h5>
                                                 <hr>
                                                <div class="form-group">
                                                     <label for="disabledTextInput">Old Password</label>
                                                   <input type="password" class="form-control" id="inlineFormInputName" placeholder="Old Password" name="old_password" required>
                                                </div>
                                                <div class="form-group">
                                                     <label for="disabledTextInput">New Password</label>
                                                   <input type="password" class="form-control" id="inlineFormInputName" placeholder="New Password" name="new_password" required>
                                                </div>
                                                <div class="form-group">
                                                     <label for="disabledTextInput">Confirm Password</label>
                                                   <input type="password" class="form-control" id="inlineFormInputName" placeholder="Confirm Password" name="confirm_password" required>
                                                </div>
                                                <div class="create_cam text-center">
                                                   <button id="createWebsiteBtn" name="change" type="change" class="btn btn-lg btn-info">
                                                        <span id="payment-button-amount">Change</span>
                                                    </button>
                                                    <div class="field_error">
                                                        <?php echo $msg ?>
                                                    </div>
                                               </div>
                                            </div>
                                      </div>
                                    </div>
                                     
                                 </form>
                             </div>
                       </div>
                   </div>
                </div>
         </form>
    </div>
</div>
<script src="assets/js/jquery-3.7.1.js" type="text/javascript"></script>
<script src="assets/js/dataTables.js" type="text/javascript"></script>

<?php
require('footer.inc.php');
?>