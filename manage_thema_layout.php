<?php
require('top.inc.php');

$image = '';
$website_name = '';
$thema_id ='';
$pro_th_id ='';
$msg = '';
$image_required = 'required';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $id = get_safe_value($con, $_GET['id']);
    $res = mysqli_query($con, "SELECT * FROM thema_layout WHERE id='$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $website_name = $row['website_name'];
        $thema_id = $row['thema_id'];
        $pro_th_id = $row['pro_th_id'];
        $image = $row['image'];
    } else {
        header('location:create_thema_layout.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    $website_name = get_safe_value($con, $_POST['website_name']);
    $thema_id = get_safe_value($con, $_POST['thema_id']);
    $pro_th_id = get_safe_value($con, $_POST['pro_th_id']);

    $res = mysqli_query($con, "SELECT * FROM thema_layout WHERE website_name='$website_name'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $getData = mysqli_fetch_assoc($res);
            if ($id == $getData['id']) {
                // Allowed to proceed for update
            } else {
                $msg = "Website already exists";
            }
        } else {
            $msg = "Website already exists";
        }
    }

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
                    $update_sql = "UPDATE thema_layout SET website_name='$website_name', thema_id='$thema_id', pro_th_id='$pro_th_id', image='$image', status='1' WHERE id='$id'";
                        $update_sql_thema = "UPDATE thema_campaign SET campaign_name='$website_name' WHERE thema_layout_new_id='$id'";
                        mysqli_query($con, $update_sql_thema);
                     header("location: manage_thema_layout.php?id=" . urlencode($id));
                } else {
                    $update_sql = "UPDATE thema_layout SET website_name='$website_name', thema_id='$thema_id', pro_th_id='$pro_th_id', status='1' WHERE id='$id'";
                       $update_sql_thema = "UPDATE thema_campaign SET campaign_name='$website_name' WHERE thema_layout_new_id='$id'";
                        mysqli_query($con, $update_sql_thema);
                     header("location: manage_thema_layout.php?id=" . urlencode($id));
                }
                mysqli_query($con, $update_sql);
            } else {
                mysqli_query($con, "INSERT INTO thema_layout (website_name, thema_id, pro_th_id, image, status) VALUES ('$website_name', '$thema_id', '$pro_th_id', '$image', '0')");
                  header('location:create_thema_layout.php');
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
                    <div class="card-header"><strong>Manage Thema Logo</strong><small></small></div>
                   <?php if (!empty($id)) {
                        // Fetch Project Number
                       
                        
                        $layout_sql_pro = "SELECT * FROM thema_layout WHERE id = '$id' ORDER BY id DESC";
                         $layout_res_pro = mysqli_query($con, $layout_sql_pro);
                         $layout_res_pro_result = mysqli_fetch_assoc($layout_res_pro);
                         $pro_th_ids= $layout_res_pro_result['pro_th_id'];
                         
                          $project_name_query = "SELECT project_number FROM project_thema WHERE id = '$pro_th_ids' AND status = '1'";
                          $project_name_res = mysqli_query($con, $project_name_query);
                          $project_name = ($row_p = mysqli_fetch_assoc($project_name_res)) ? $row_p['project_number'] : "Unknown Project";
                         
                         ?>
                         <h4 class="mb-0" style="display: flex;gap: 41%;margin: 10px;">
                            <span>
                              Project Thema Name &nbsp;ID <?php echo $project_name; ?> 
                            </span>
                            <span style="font-size: 18px;color: #138496;"> Visit website  &nbsp; <a style="color:blue" href="https://game.reapbucks.com/templete/<?php echo $project_name; ?>" target="_blank"><img src="images/thema_gallery/<?php echo $layout_res_pro_result['image']; ?>" class="rounded-circle" alt="" width="50px" height="50px"> <i class="fa fa-eye" aria-hidden="true"></i></a>
                            </span>
                       </h4>
                         <?php
                    }
                    ?>
                    
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
                    
                                        <!-- Website Name -->
                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                            <label for="website" class="form-control-label">Website Name</label>
                                            <input type="text" name="website_name" placeholder="Enter Website Name" class="form-control" required value="<?php echo $website_name ?>">
                                        </div>
                                        
                                        
                                    <!-- Logo Upload -->
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <label for="Image" class="form-control-label">Logo</label>
                                        <input type="file" name="photo" class="form-control" <?php echo $image_required; ?>>
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

