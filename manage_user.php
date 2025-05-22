<?php
require('top.inc.php');

$name = '';
$email  = '';
$password = '';
$image = '';
$mobile = '';
$skype  = '';
$whatsapp = '';
$telegram = '';
$facebook = '';
$msg = '';
$image_required = 'required';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $id = get_safe_value($con, $_GET['id']);
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
        $password = $row['password'];
        $image = $row['image'];
    } else {
        header('location:users.php');
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
    $password = get_safe_value($con, $_POST['password']);

    $ip = $_SERVER['REMOTE_ADDR'];
    $device = $_SERVER['HTTP_USER_AGENT'];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Email duplicate check
    $email_check_sql = "SELECT * FROM users WHERE email='$email'";
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $email_check_sql .= " AND id!='$id'";
    }
    $res_email = mysqli_query($con, $email_check_sql);
    if (mysqli_num_rows($res_email) > 0) {
        $msg = "Email already exists";
    }

    // Mobile duplicate check
    $mobile_check_sql = "SELECT * FROM users WHERE mobile='$mobile'";
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $mobile_check_sql .= " AND id!='$id'";
    }
    $res_mobile = mysqli_query($con, $mobile_check_sql);
    if (mysqli_num_rows($res_mobile) > 0) {
        if ($msg != '') {
            $msg .= " and mobile number also exists";
        } else {
            $msg = "Mobile number already exists";
        }
    }

    // Image Upload
    if ($msg == '') {
        if (isset($_FILES['photo']['name']) && $_FILES['photo']['name'] != '') {
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            $max_size = 2 * 1024 * 1024; // 2MB
            $file_name = $_FILES['photo']['name'];
            $file_tmp = $_FILES['photo']['tmp_name'];
            $file_size = $_FILES['photo']['size'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if (in_array($file_ext, $allowed_types)) {
                if ($file_size <= $max_size) {
                    $new_file_name = time() . '_' . $file_name;
                    $file_path = 'images/users/' . $new_file_name;
                    move_uploaded_file($file_tmp, $file_path);
                    $image = $new_file_name;
                } else {
                    $msg = "File size exceeds the limit of 2MB.";
                }
            } else {
                $msg = "Invalid file format. Only JPG, JPEG, PNG, and GIF are allowed.";
            }
        }

        if ($msg == '') {
            if (isset($_GET['id']) && $_GET['id'] != '') {
                if ($image != '') {
                    $update_sql = "UPDATE users SET name='$name', email='$email', mobile='$mobile', skype='$skype', whatsapp='$whatsapp', telegram='$telegram', facebook='$facebook', image='$image' WHERE id='$id'";
                } else {
                    $update_sql = "UPDATE users SET name='$name', email='$email', mobile='$mobile', skype='$skype', whatsapp='$whatsapp', telegram='$telegram', facebook='$facebook' WHERE id='$id'";
                }
                mysqli_query($con, $update_sql);
            } else {
                mysqli_query($con, "INSERT INTO users (name, email, mobile, skype, whatsapp, telegram, facebook, image, password, ip, device, reset_token, created_at) VALUES ('$name', '$email', '$mobile', '$skype', '$whatsapp', '$telegram', '$facebook', '$image', '$hashed_password', '$ip', '$device', NULL, NOW())");
            }
            header('location:users.php');
            die();
        }
    }
}
?>

<!-- HTML Form -->
<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>Manage User</strong></div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body card-block">
                            <?php if ($image != '') { ?>
                                <p class="text-center"><img src="images/users/<?php echo $image; ?>" class="rounded-circle" style="width: 75px;height: 75px;margin-top: 8px;padding: 5px;border: 2px solid #706363;"></p>
                            <?php } ?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>Nickname</label>
                                        <input type="text" class="form-control" name="name" required value="<?php echo $name; ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" required value="<?php echo $email; ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Phone number</label>
                                        <input type="number" class="form-control" name="mobile" required value="<?php echo $mobile; ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Skype</label>
                                        <input type="text" class="form-control" name="skype" required value="<?php echo $skype; ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Telegram</label>
                                        <input type="text" class="form-control" name="telegram" required value="<?php echo $telegram; ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label>WhatsApp</label>
                                        <input type="text" class="form-control" name="whatsapp" required value="<?php echo $whatsapp; ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Facebook</label>
                                        <input type="text" class="form-control" name="facebook" required value="<?php echo $facebook; ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Image <span class="field_error">(Max 2MB)</span></label>
                                        <input type="file" name="photo" class="form-control" <?php echo $image_required; ?>>
                                        <?php if ($image != '') { ?>
                                            <a href="images/users/<?php echo $image; ?>" target="_blank">View Image</a>
                                        <?php } ?>
                                    </div>
                                    <?php if ($image == '') { ?>
                                        <div class="col-lg-4">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="password" required value="<?php echo $password; ?>">
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <button name="submit" type="submit" class="btn btn-lg btn-info float-right">Submit</button>
                            <div class="field_error mt-3 text-danger">
                                <?php echo $msg ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/jquery-3.7.1.js" type="text/javascript"></script>
<?php require('footer.inc.php'); ?>
