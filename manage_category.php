<?php
require('top.inc.php');

$image = '';
$category_name = '';
$short_desc = '';
$msg = '';
$image_required = 'required';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $id = get_safe_value($con, $_GET['id']);
    $res = mysqli_query($con, "SELECT * FROM theme_category WHERE id='$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $category_name = $row['category_name'];
        $short_desc = $row['short_desc'];
        $image = $row['image'];
    } else {
        header('location:create_category.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    $category_name = get_safe_value($con, $_POST['category_name']);
    $short_desc = get_safe_value($con, $_POST['short_desc']);

    $res = mysqli_query($con, "SELECT * FROM theme_category WHERE category_name='$category_name'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $getData = mysqli_fetch_assoc($res);
            if ($id == $getData['id']) {
                // Allowed to proceed for update
            } else {
                $msg = "Category already exists";
            }
        } else {
            $msg = "Category already exists";
        }
    }

    if ($msg == '') {
        if (isset($_FILES['photo']['name']) && $_FILES['photo']['name'] != '') {
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            $file_name = $_FILES['photo']['name'];
            $file_tmp = $_FILES['photo']['tmp_name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if (in_array($file_ext, $allowed_types)) {
                $new_file_name = time() . '_' . $file_name;
                $file_path = 'images/category/' . $new_file_name;
                move_uploaded_file($file_tmp, $file_path);
                $image = $new_file_name;
            } else {
                $msg = "Invalid file format. Only JPG, JPEG, PNG, and GIF are allowed.";
            }
        }

        if ($msg == '') {
            if (isset($_GET['id']) && $_GET['id'] != '') {
                if ($image != '') {
                    $update_sql = "UPDATE theme_category SET category_name='$category_name', short_desc='$short_desc', image='$image', status='0' WHERE id='$id'";
                } else {
                    $update_sql = "UPDATE theme_category SET category_name='$category_name', short_desc='$short_desc', status='0' WHERE id='$id'";
                }
                mysqli_query($con, $update_sql);
            } else {
                mysqli_query($con, "INSERT INTO theme_category (category_name, short_desc, image, status) VALUES ('$category_name', '$short_desc', '$image', '0')");
            }
            header('location:create_category.php');
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
                    <div class="card-header"><strong>Manage Category</strong><small></small></div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body card-block">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="categories" class="form-control-label">Category name</label>
                                        <input type="text" name="category_name" placeholder="Enter Category name" class="form-control" required value="<?php echo $category_name ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="Image" class="form-control-label">Image</label>
                                        <input type="file" name="photo" class="form-control" <?php echo $image_required; ?>>
                                        <?php if ($image != '') { ?>
                                            <a href="images/category/<?php echo $image; ?>" target="_blank">View Image</a>
                                        <?php } ?>
                                    </div>
                                    
                                     <?php if ($image != '') { ?>
                                            <div class="col-lg-4">
                                                <img src="images/category/<?php echo $image; ?>" class="rounded-circle" style="width: 75px;height: 75px;margin-top: 8px;padding: 5px;border: 2px solid #706363;">
                                            </div>
                                        <?php } ?>
                                   
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

 <script>
    CKEDITOR.replace('desc', {
        // Custom configuration options
        toolbar: 'Basic'
    });
</script>

<?php
require('footer.inc.php');
?>

