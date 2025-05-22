<?php
require('top.inc.php');

$thema_id = '';
$project_number = '';
$msg = '';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $id = get_safe_value($con, $_GET['id']);
    $res = mysqli_query($con, "SELECT * FROM project_thema WHERE id='$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $thema_id = $row['thema_id'];
        $project_number = $row['project_number'];
    } else {
        header('location:create_project.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    $thema_id = get_safe_value($con, $_POST['thema_id']);
    $project_number = get_safe_value($con, $_POST['project_number']);

    $res = mysqli_query($con, "SELECT * FROM project_thema WHERE project_number='$project_number'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $getData = mysqli_fetch_assoc($res);
            if ($id == $getData['id']) {
                // Allowed to proceed for update
            } else {
                $msg = "project number already exists";
            }
        } else {
            $msg = "project number already exists";
        }
    }


        if ($msg == '') {
            if (isset($_GET['id']) && $_GET['id'] != '') {
                if ($image != '') {
                    $update_sql = "UPDATE project_thema SET thema_id='$thema_id', project_number='$project_number', status='0' WHERE id='$id'";
                } else {
                    $update_sql = "UPDATE project_thema SET thema_id='$thema_id', project_number='$project_number', status='0' WHERE id='$id'";
                }
                mysqli_query($con, $update_sql);
            } else {
                mysqli_query($con, "INSERT INTO project_thema (thema_id, project_number, status) VALUES ('$thema_id', '$project_number', '0')");
            }
            header('location:create_project.php');
            die();
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
                                         <label for="categories" class="form-control-label">Thema & Type</label>
                                            <select class="form-control" name="thema_id" required>
                                                 <option>Choose the Thema Name</option>
                                                  <?php 
                                                    // Fetch categories from the database
                                                    $sql = "SELECT id, thema_name FROM thema_list";
                                                    $result = $con->query($sql);
                                                
                                                    while ($rows = $result->fetch_assoc()) {
                                                        $selected = ($rows['id'] == $thema_id) ? "selected" : "";
                                                        echo '<option value="' . $rows['id'] . '" ' . $selected . '>' . $rows['thema_name'] . '</option>';
                                                    }
                                                    ?>
                                            </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="projects" class="form-control-label">Project Number</label>
                                        <input type="text" name="project_number" placeholder="Enter Project Number" class="form-control" pattern="\d{5}" title="Please enter exactly 5 digits"  required value="<?php echo $project_number ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5);">
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

