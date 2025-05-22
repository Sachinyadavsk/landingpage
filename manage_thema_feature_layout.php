<?php
require('top.inc.php');

$thema_id ='';
$pro_th_id ='';
$section_name = '';
$title = '';
$short_desc = ''; 
$add_link = ''; 
$button_url_name = ''; 
$image = '';
$msg = '';
// $image_required = 'required';

$prothid = isset($_GET['pro_th_id']) ? get_safe_value($con, $_GET['pro_th_id']) : '';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $id = get_safe_value($con, $_GET['id']);
    $res = mysqli_query($con, "SELECT * FROM Theme_feature_layout WHERE id='$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $thema_id = $row['thema_id'];
        $pro_th_id = $row['pro_th_id'];
        $section_name = $row['section_name'];
        $title = $row['title'];
        $short_desc = $row['short_desc'];
        $add_link = $row['add_link'];
        $button_url_name = $row['button_url_name'];
        $image = $row['image'];
    } else {
        header('location:create_thema_feature_layout.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    $thema_id = get_safe_value($con, $_POST['thema_id']);
    $pro_th_id = get_safe_value($con, $_POST['pro_th_id']);
    $section_name = get_safe_value($con, $_POST['section_name']);
    $title = get_safe_value($con, $_POST['title']);
    $short_desc = get_safe_value($con, $_POST['short_desc']);
    $add_link = get_safe_value($con, $_POST['add_link']);
    $button_url_name = get_safe_value($con, $_POST['button_url_name']);

    // $res = mysqli_query($con, "SELECT * FROM Theme_feature_layout WHERE title='$title'");
    // $check = mysqli_num_rows($res);
    // if ($check > 0) {
    //     if (isset($_GET['id']) && $_GET['id'] != '') {
    //         $getData = mysqli_fetch_assoc($res);
    //         if ($id == $getData['id']) {
    //             // Allowed to proceed for update
    //         } else {
    //             $msg = "Website already exists";
    //         }
    //     } else {
    //         $msg = "Website already exists";
    //     }
    // }

    if ($msg == '') {
            if (isset($_FILES['photo']['name']) && $_FILES['photo']['name'] != '') {
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
                $file_name = $_FILES['photo']['name'];
                $file_tmp = $_FILES['photo']['tmp_name'];
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
                if (in_array($file_ext, $allowed_types)) {
                    $new_file_name = time() . '_' . $file_name;
                    $file_path = 'images/thema_gallery/' . $new_file_name;
                    move_uploaded_file($file_tmp, $file_path);
                    $image = $new_file_name;
                } else {
                    $msg = "Invalid file format. Only JPG, JPEG, PNG, and GIF are allowed.";
                }
            }

  
            if (isset($_GET['id']) && $_GET['id'] != '') {
                if ($image != '') {
                    $update_sql = "UPDATE Theme_feature_layout SET section_name='$section_name', title='$title', short_desc='$short_desc', add_link='$add_link', button_url_name='$button_url_name', thema_id='$thema_id', pro_th_id='$pro_th_id', image='$image', status='1' WHERE id='$id'";
                    header("location: thema_feature_setting.php?id=" . urlencode($prothid));
                } else {
                    $update_sql = "UPDATE Theme_feature_layout SET section_name='$section_name', title='$title', short_desc='$short_desc', add_link='$add_link', button_url_name='$button_url_name', thema_id='$thema_id', pro_th_id='$pro_th_id', status='1' WHERE id='$id'";
                    header("location: thema_feature_setting.php?id=" . urlencode($prothid));
                }
                mysqli_query($con, $update_sql);
            } else {
                mysqli_query($con, "INSERT INTO Theme_feature_layout (section_name, title, short_desc, add_link, button_url_name, thema_id, pro_th_id, image, status) VALUES ('$section_name', '$title', '$short_desc', '$add_link', '$button_url_name', '$thema_id', '$pro_th_id', '$image', '0')");
                header('location:create_thema_feature_layout.php');
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
                    <div class="card-header"><strong>Manage Thema Feature Layout</strong><small></small></div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body card-block">
                            <div class="form-group">
                                <div class="row">
                                    
                                      <?php if (empty($thema_id)) {  ?>
                                    <!-- First Dropdown: Thema List -->
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <label for="categories" class="form-control-label">Thema & Type</label>
                                        <select class="form-control" name="thema_id" id="thema_id" required>
                                            <option value="">Choose the Thema Name</option>
                                            <?php 
                                            $sql = "SELECT id, thema_name FROM thema_list WHERE status='1'";
                                            $result = $con->query($sql);
                                            while ($rows = $result->fetch_assoc()) {
                                                $selected = ($rows['id'] == $thema_id) ? "selected" : "";
                                                echo '<option value="' . $rows['id'] . '" ' . $selected . '>' . $rows['thema_name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php }else{ ?>
                                          <input type="hidden" name="thema_id" value="<?php echo $thema_id ?>">
                                    <?php } ?>
                    
                    
                                   <?php if (empty($pro_th_id)) {  ?>
                                    <!-- Second Dropdown: Project Thema (Dependent) -->
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <label for="categories" class="form-control-label">Project Number</label>
                                        <select class="form-control" name="pro_th_id" id="pro_th_id" required>
                                            <option value="">Choose Project Number</option>
                                            <?php 
                                            if (!empty($thema_id)) {
                                                $sql = "SELECT id, project_number FROM project_thema WHERE thema_id = $thema_id AND status='1'";
                                                $result = $con->query($sql);
                                                while ($rows = $result->fetch_assoc()) {
                                                    $selected = ($rows['id'] == $pro_th_id) ? "selected" : "";
                                                    echo '<option value="' . $rows['id'] . '" ' . $selected . '>' . $rows['project_number'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                     <?php }else{ ?>
                                          <input type="hidden" name="pro_th_id" value="<?php echo $pro_th_id ?>">
                                    <?php } ?>
                                    
                                    
                                     <?php if (empty($section_name)) {  ?>
                                     <div class="col-sm-12 col-md-4 col-lg-4">
                                        <label for="section_name" class="form-control-label">Section Name</label>
                                        <select class="form-control" name="section_name" id="section_name" required>
                                            <option value="">Choose Section Name</option>
                                            <option value="home" <?php echo ($section_name == 'home') ? 'selected' : ''; ?>>Home</option>
                                            <option value="about" <?php echo ($section_name == 'about') ? 'selected' : ''; ?>>About</option>
                                            <option value="service" <?php echo ($section_name == 'service') ? 'selected' : ''; ?>>Service</option>
                                            <option value="gallery" <?php echo ($section_name == 'gallery') ? 'selected' : ''; ?>>Gallery</option>
                                            <option value="blog" <?php echo ($section_name == 'blog') ? 'selected' : ''; ?>>Blog</option>
                                            <option value="features" <?php echo ($section_name == 'features') ? 'selected' : ''; ?>>Features</option>
                                            <option value="testimonials" <?php echo ($section_name == 'testimonials') ? 'selected' : ''; ?>>Testimonials</option>
                                        </select>
                                    </div>
                                    
                                    <?php }else{ ?>
                                          <input type="hidden" name="section_name" value="<?php echo $section_name ?>">
                                    <?php } ?>

                    
                                    <!-- Logo Upload -->
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <label for="Image" class="form-control-label">Image</label>
                                        <input type="file" name="photo" class="form-control">
                                        <?php if (!empty($image)) { ?>
                                            <a href="images/thema_gallery/<?php echo $image; ?>" target="_blank">View Image</a>
                                        <?php } ?>
                                    </div>
                                    
                                    <?php if ($image != '') { ?>
                                            <div class="col-lg-4">
                                                <img src="images/thema_gallery/<?php echo $image; ?>" class="rounded-circle" style="width: 75px;height: 75px;margin-top: 8px;padding: 5px;border: 2px solid #706363;">
                                            </div>
                                    <?php } ?>
                    
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="categories" class="form-control-label">Title</label>
                                        <input type="text" name="title" placeholder="Enter Title Name" class="form-control" value="<?php echo $title ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="categories" class="form-control-label">Button URl Name</label>
                                        <input type="text" name="button_url_name" placeholder="Enter Button URl Name" class="form-control" value="<?php echo $button_url_name ?>">
                                    </div>
                                </div>
                            </div>
                            
                             <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="categories" class="form-control-label">Button URL Link</label>
                                        <input type="text" name="add_link" placeholder="Enter Button URL Link" class="form-control" value="<?php echo $add_link ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="categories" class="form-control-label">Description</label>
                                        <textarea type="text" name="short_desc" id="desc" placeholder="Enter short description" class="form-control">
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

<script>
document.getElementById('thema_id').addEventListener('change', function() {
    let thema_id = this.value;
    let projectDropdown = document.getElementById('pro_th_id');
    
    if (thema_id) {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'fetch_projects.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                projectDropdown.innerHTML = xhr.responseText;
            }
        };
        xhr.send('thema_id=' + thema_id);
    } else {
        projectDropdown.innerHTML = '<option value="">Choose Project Number</option>';
    }
});
</script>

<?php
require('footer.inc.php');
?>

