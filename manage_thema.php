<?php
require('top.inc.php');

$image = '';
$category = '';
$thema_name = '';
$geo = '';
$icon = '';
$thema_number  = '';
$short_desc = '';
$msg = '';
$image_required = 'required';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $id = get_safe_value($con, $_GET['id']);
    $res = mysqli_query($con, "SELECT * FROM thema_list WHERE id='$id' AND status='1'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $category = $row['category'];
        $thema_name = $row['thema_name'];
        $geo = $row['geo'];
        $icon = $row['icon'];
        $thema_number = $row['thema_number'];
        $short_desc = $row['short_desc'];
        $image = $row['image'];
    } else {
        header('location:create_thema.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    $category = get_safe_value($con, $_POST['category']);
    $thema_name = get_safe_value($con, $_POST['thema_name']);
    $geo = get_safe_value($con, $_POST['geo']);
    $icon = get_safe_value($con, $_POST['icon']);
    $thema_number = get_safe_value($con, $_POST['thema_number']);
    $short_desc = get_safe_value($con, $_POST['short_desc']);

    $res = mysqli_query($con, "SELECT * FROM thema_list WHERE thema_name='$thema_name'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        if (isset($_GET['id']) && $_GET['id'] != '') {
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
               if (isset($_FILES['photo']['name']) && $_FILES['photo']['name'] != '') {
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            $max_size = 2 * 1024 * 1024; // 2MB in bytes
            $file_name = $_FILES['photo']['name'];
            $file_tmp = $_FILES['photo']['tmp_name'];
            $file_size = $_FILES['photo']['size'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
            if (in_array($file_ext, $allowed_types)) {
                if ($file_size <= $max_size) {
                    $new_file_name = time() . '_' . $file_name;
                    $file_path = 'images/thema_list/' . $new_file_name;
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
                    $update_sql = "UPDATE thema_list SET category='$category', thema_name='$thema_name', geo='$geo', icon='$icon', thema_number='$thema_number', short_desc='$short_desc', image='$image', status='0' WHERE id='$id'";
                } else {
                    $update_sql = "UPDATE thema_list SET category='$category', thema_name='$thema_name', geo='$geo', icon='$icon', thema_number='$thema_number', short_desc='$short_desc', status='0' WHERE id='$id'";
                }
                mysqli_query($con, $update_sql);
            } else {
                mysqli_query($con, "INSERT INTO thema_list (category, thema_name, geo, icon, thema_number, short_desc, image, status) VALUES ('$category', '$thema_name', '$geo', '$icon', '$thema_number', '$short_desc', '$image', '0')");
            }
            header('location:create_thema.php');
            die();
        }
    }
}
?>

<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>Manage Thema</strong><small></small></div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body card-block">
                            <div class="form-group">
                                <div class="row">
                                     <?php if (empty($category)) { 
                                         ?>
                                    <div class="col-lg-4">
                                        <label for="categories" class="form-control-label">Category & Type</label>
                                       
                                          <select id="categories_id" class="form-control" name="category"  required>
                                             <option>Choose the Category</option>
                                              <?php 
                                                // Fetch categories from the database
                                                $sql = "SELECT id, category_name FROM theme_category WHERE status='1' ORDER BY id DESC";
                                                $result = $con->query($sql);
                                            
                                                while ($row = $result->fetch_assoc()) {
                                                    $selected = ($row['id'] == $category) ? "selected" : "";
                                                    echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['category_name'] . '</option>';
                                                }
                                                ?>
                                        </select>
                                    </div>
                                    <?php
                                        }else{
                                           ?>
                                          <input type="hidden" name="category" value="<?php echo $category ?>">
                                           <?php
                                        }
                                        ?>
                                    <div class="col-lg-4">
                                        <label for="categories" class="form-control-label">Thema name</label>
                                        <input type="text" name="thema_name" placeholder="Enter Thema name" class="form-control" required value="<?php echo $thema_name ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="Image" class="form-control-label">Image <span class="field_error">(Size 2MB in bytes)</span></label>
                                        <input type="file" name="photo" class="form-control" <?php echo $image_required; ?>>
                                        <?php if ($image != '') { ?>
                                            <a href="images/thema_list/<?php echo $image; ?>" target="_blank">View Image</a>
                                        <?php } ?>
                                    </div>
                                     <?php if ($image != '') { ?>
                                            <div class="col-lg-4">
                                                <img src="images/thema_list/<?php echo $image; ?>" class="rounded-circle" style="width: 75px;height: 75px;margin-top: 8px;padding: 5px;border: 2px solid #706363;">
                                            </div>
                                        <?php } ?>
                                        <?php if (empty($icon)) { 
                                         ?>
                                    <div class="col-lg-4">
                                        <label for="categories" class="form-control-label">Geo</label>
                                        <input type="text" name="geo" placeholder="Enter Thema name" class="form-control" required value="<?php echo $geo ?>">
                                    </div>
                                     <?php
                                        }else{
                                           ?>
                                          <input type="hidden" name="geo" value="<?php echo $geo ?>">
                                           <?php
                                        }
                                        ?>
                                    <?php if (empty($icon)) { 
                                         ?>
                                    <div class="col-lg-4">
                                        <label for="categories" class="form-control-label">Icon (fa fa-home script)</label>
                                        <input type="text" name="icon" placeholder="Enter Thema name" class="form-control"  value="<?php echo $icon ?>">
                                    </div>
                                    <?php
                                        }else{
                                           ?>
                                          <input type="hidden" name="icon" value="<?php echo $icon ?>">
                                           <?php
                                        }
                                        ?>
                                        <?php if (empty($thema_number)) { 
                                         ?>
                                    <div class="col-lg-4">
                                        <label for="categories" class="form-control-label">Thema Number</label>
                                        <input type="text" name="thema_number" placeholder="Enter Thema name" class="form-control" required value="<?php echo $thema_number ?>">
                                    </div>
                                     <?php
                                        }else{
                                           ?>
                                          <input type="hidden" name="thema_number" value="<?php echo $thema_number ?>">
                                           <?php
                                        }
                                        ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="categories" class="form-control-label">Description</label>
                                        <textarea type="text" name="short_desc" id="desc" placeholder="Enter short description" class="form-control" required>
                                            <?php echo $short_desc ?>
                                            </textarea>
                                    </div>
                                </div>
                            </div>
                            <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info float-right">
                                <span id="payment-button-amount">Submit</span>
                            </button>
                            <div class="field_error">
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

<script>
$(document).ready(function () {
    $("#categories_id").change(function () {
        var cateID = $(this).val(); // Get selected category ID

        if (cateID) {
            var newUrlcate = "https://game.reapbucks.com/manage_thema.php?id=" + encodeURIComponent(cateID);
            location.assign(newUrlcate); // Redirect to new URL
        }
    });
});
</script>

 <script>
    CKEDITOR.replace('desc', {
        // Custom configuration options
        toolbar: 'Basic'
    });
</script>

<?php
require('footer.inc.php');
?>
<script>
<?php
if (isset($_GET['id'])) {
?>
get_sub_cat('<?php echo $sub_categories_id ?>');
<?php } ?>
</script>
