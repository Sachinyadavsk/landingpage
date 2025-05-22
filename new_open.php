<?php
require('top.inc.php');

$thema_id = '';
$aff_link = '';
$campaign_name = '';
$project_thema_id = '';
$msg = '';

if (isset($_POST['submit'])) {
    $thema_id = get_safe_value($con, $_POST['thema_id']);
    $aff_link = get_safe_value($con, $_POST['aff_link']);
    $campaign_name = get_safe_value($con, $_POST['campaign_name']);
    $formattedWordurl = str_replace(' ', '_', $campaign_name);
    $project_thema_id = get_safe_value($con, $_POST['project_thema_id']);
    $userid = $_SESSION['ADMIN_ID'];
    
    // thema id start
        $sql_thid = "SELECT * FROM thema_list WHERE thema_number ='$thema_id'";
        $result_thid = $con->query($sql_thid);
        $rows_thid = $result_thid->fetch_assoc();
        $setthid = $rows_thid['id'];
        // print_r($rows_thid);
        // exit();
     // thema id start
     
      // project thema id start
        $sql_ptid = "SELECT id, project_number FROM project_thema WHERE project_number =' $project_thema_id'";
        $result_ptid = $con->query($sql_ptid);
        $rows_ptid = $result_ptid->fetch_assoc();
        $setptid = $rows_ptid['id'];
        
        $sql_ptidimg = "SELECT image FROM thema_layout WHERE pro_th_id =' $setptid'";
        $result_ptimg = $con->query($sql_ptidimg);
        $rows_ptimg = $result_ptimg->fetch_assoc();
        $setptimg = $rows_ptimg['image'];
     // project thema id start
     
    // table  project_thema set conditions
    $project_number_new = rand(14000, 20000);
    mysqli_query($con, "INSERT INTO project_thema (thema_id, project_number, status, user_id, live_status) VALUES ('$setthid', '$project_number_new', '1', '$userid', '1')");
    $project_number_new_id = mysqli_insert_id($con);
    
    // table  thema_layout set conditions
    //  $pro_th_image = 'question_url.png';
     mysqli_query($con, "INSERT INTO thema_layout (website_name, thema_id, pro_th_id, image, status, user_id, live_status) VALUES ('$campaign_name', '$setthid', '$project_number_new_id', '$setptimg', '1', '$userid', '1')");
      $thema_layout_new_id = mysqli_insert_id($con);
     
      // table  Theme_feature_layout set conditions
        $res = mysqli_query($con, "SELECT * FROM Theme_feature_layout WHERE thema_id='$setthid' AND pro_th_id='$setptid'");
        while($row = mysqli_fetch_assoc($res)){
            $section_name = $row['section_name'];
            $title = $row['title'];
            $short_desc = $row['short_desc'];
            $add_link = $row['add_link'];
            $button_url_name = $row['button_url_name'];
            $image = $row['image'];
            
            mysqli_query($con, "INSERT INTO Theme_feature_layout (section_name, title, short_desc, add_link, button_url_name, thema_id, pro_th_id, image, status, user_id, live_status) VALUES ('$section_name', '$title', '$short_desc', '$add_link', '$button_url_name', '$setthid', '$project_number_new_id', '$image', '1', '$userid', '1')");
        }
        
    
    
    
    $source_file = "templete/{$project_thema_id}.php";
    $destination_file = "templete/{$project_number_new}.php";
    $destination_urls = "templete/{$project_number_new}";

    // Check if source file exists before copying
    if (file_exists($source_file)) {
        if (!file_exists($destination_file)) {
            $content = file_get_contents($source_file);
            if ($content !== false && file_put_contents($destination_file, $content)) {
                // File copied successfully
            } else {
                echo "Error creating file.";
            }
        }
    } else {
        echo "Source file does not exist.";
    }
    
   

    // Check if the campaign name already exists
    $res = mysqli_query($con, "SELECT * FROM thema_campaign WHERE campaign_name='$formattedWordurl'");
    $check = mysqli_num_rows($res);

    if ($check > 0) {
        $msg = "Campaign Name already exists";
           $update_sql = "UPDATE Theme_feature_layout SET add_link='$aff_link' WHERE pro_th_id='$setptid'";
           mysqli_query($con, $update_sql);
    } else {
        mysqli_query($con, "INSERT INTO thema_campaign (thema_id, aff_link, campaign_name, project_thema_id, url_link, status, user_id, thema_layout_new_id) VALUES ('$thema_id', '$aff_link', '$formattedWordurl', '$project_number_new_id', '$destination_urls', '1', '$userid', '$thema_layout_new_id')");
        $update_sql = "UPDATE Theme_feature_layout SET add_link='$aff_link' WHERE pro_th_id='$setptid'";
         mysqli_query($con, $update_sql);
        header('location:active_thema.php');
        die();
    }
}


// Create campaign in dynamically

if (isset($_GET['offer_id']) && $_GET['offer_id'] != '') {
    $offer = get_safe_value($con, $_GET['offer_id']);
    $res = mysqli_query($con, "SELECT * FROM thema_list WHERE thema_number='$offer' AND status='1'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $thema_name = $row['thema_name'];
        $geo = $row['geo'];
        $image = $row['image'];
        $icon = $row['icon'];
        $thema_number = $row['thema_number'];
        $category = $row['category'];
        $short_desc = $row['short_desc'];
        $id = $row['id'];
    } else {
        header('location:create_thema.php');
        die();
    }
}

// Fetch categories from the database
    $category_id = $row['category'];
    $sql = "SELECT id, category_name FROM theme_category WHERE id =' $category_id' AND status='1'";
    $result = $con->query($sql);
    $rows = $result->fetch_assoc();
?>

<div class="content pb-0">
    <div class="orders">
          <form method="post" enctype="multipart/form-data">
                <div class="row">
                   <div class="col-sm-12 col-md-9 col-lg-9">
                       <div class="row">
                             <div class="col-sm-12 col-md-5 col-lg-5">
                                 <div class="card">
                                  <div class="card-body">
                                     <h5 class="card-title">Create Website</h5>
                                            <div class="form-group">
                                                <label for="disabledTextInput">Offer</label>
                                                <select id="searchable-dropdown" class="form-control" name="thema_id" required>
                                                    <option value="">Select User</option>
                                                    <?php 
                                                    // Fetch categories from the database
                                                    $sql_th = "SELECT thema_number, thema_name FROM thema_list WHERE status='1'";
                                                    $result_th = $con->query($sql_th);
                                                
                                                    while ($rows_th = $result_th->fetch_assoc()) {
                                                        $selected = ($rows_th['thema_number'] == $thema_number) ? "selected" : "";
                                                        echo '<option value="' . $rows_th['thema_number'] . '" ' . $selected . '>' . $rows_th['thema_name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                           
                                            <div class="form-group">
                                                <label for="links">Website Affiliate link</label>
                                                 <input type="text" class="form-control" id="links" placeholder="Website Affiliate link" name="aff_link" required>
                                            </div>
                                            
                                            <div class="form-group">
                                                 <label for="disabledTextInput">Website name</label>
                                               <input type="text" class="form-control" id="inlineFormInputName" placeholder="Website name" name="campaign_name" required>
                                            </div>
                                            
                                  </div>
                                </div>
                             </div>
                             <div class="col-sm-12 col-md-7 col-lg-7">
                                 <div class="card">
                                  <div class="card-body" style="background: #f5f5f7; border-radius: 20px;">
                                     <h5 class="card-title">Offer info</h5>
                                      <div class="row">
                                          <div class="col-sm-12 col-md-3 col-lg-3 text-center">
                                              <img src="images/thema_list/<?php echo $image; ?>" class="rounded-circle_img" alt="<?php echo $thema_name?>" width="100px" height="100px">
                                          </div>
                                          <div class="col-sm-12 col-md-9 col-lg-9">
                                              <h4><?php echo $thema_name?></h4>
                                              <p><?php echo $rows['category_name'];?></p>
                                              <hr>
                                               <p><?php echo substr($short_desc, 0, 125); ?></p>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                             </div>
                       </div>
                       <div class="row">
                             <div class="col-sm-12 col-md-12 col-lg-12">
                                 <div class="card">
                                  <div class="card-body">
                                     <h5 class="card-title">Landings</h5>
                                     <?php 
                                        $sql = "SELECT * FROM project_thema WHERE thema_id =' $id' AND status='1' AND live_status='0' LIMIT 4";
                                        $result_pro = $con->query($sql);
                                        $i=0;
                                        while($rows = $result_pro->fetch_assoc()){
                                            ?>
                                            <div class="projectlist">
                                                <span><input type="radio" name="project_thema_id" value="<?php echo $rows['project_number'];?>" class="projectRadio"> &nbsp; <a href="https://game.reapbucks.com/templete/<?php echo $rows['project_number'];?>" target="_blank"><b><?php echo $rows['project_number'];?></b></a></span><br>
                                                <span>n/a &nbsp; <i class="fa fa-arrows-alt"></i></span><br>
                                            </div>
                                            
                                            <?php 
                                        }
                                     ?>
                                       <div id="demo" class="collapse">
                                            <?php 
                                                $sql = "SELECT * FROM project_thema WHERE thema_id = '$id' AND status='1' AND live_status='0' LIMIT 4, 10";
                                                $result_pro = $con->query($sql);
                                                $i=4;
                                                while($rows = $result_pro->fetch_assoc()){
                                                    ?>
                                                    <div class="projectlist">
                                                        <span><input type="radio" name="project_thema_id" value="<?php echo $rows['project_number'];?>" class="projectRadio"> <a href="https://game.reapbucks.com/templete/<?php echo $rows['project_number'];?>" target="_blank">&nbsp; <b><?php echo $rows['project_number'];?></b></a></span><br>
                                                        <span>n/a &nbsp; <i class="fa fa-arrows-alt"></i></span><br>
                                                    </div>
                                                    
                                                    <?php 
                                                }
                                             ?>
                                        </div>
                                    
                                        <span class="template__show-all-text" data-toggle="collapse" data-target="#demo">
                                           <i class="fa fa-chevron-down"></i> &nbsp; View all landings 
                                        </span>
                                  </div>
                                </div>
                             </div>
                       </div>
                   </div>
                   <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="row">
                             <div class="col-sm-12 col-md-12 col-lg-12">
                                 <div class="card">
                                  <div class="card-body">
                                     <h5 class="card-title">Marks</h5>
                                     <div class="card-container">
                                     <?php 
                                     $sqlshow="select * from thema_list where status='1' order by thema_list.id desc";
                                     $resshow=mysqli_query($con,$sqlshow);
            							$k=1;
            							while($rowshow=mysqli_fetch_assoc($resshow)){?>
            							   <a href="manage_offer_details.php?offer=<?php echo $rowshow['thema_number'];?>">
                                              <div class="card itemlists" style="max-width: 540px;">
                                                  <div class="row no-gutters">
                                                    <div class="col-md-4">
                                                      <img src="images/thema_list/<?php echo $rowshow['image']?>" class="card-img" alt="<?php echo $rowshow['thema_name']?>">
                                                    </div>
                                                    <div class="col-md-8">
                                                      <div class="card-body">
                                                        <h5 class="card-title"><?php echo $rowshow['thema_name']?></h5>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                           </a>
                                    <?php $k++; } ?>
                                    </div>
                                  </div>
                                </div>
                               <div class="create_cam text-center">
                                   <button id="createWebsiteBtn" name="submit" type="submit" class="btn btn-lg btn-info" style="display: none;">
                                        <span id="payment-button-amount">Create Website</span>
                                    </button>
                                    <div class="field_error">
                                        <?php echo $msg ?>
                                    </div>
                                </div>
                             </div>
                       </div>
                   </div>
                </div>
         </form>
    </div>
</div>
<script src="assets/js/jquery-3.7.1.js" type="text/javascript"></script>
<script src="assets/js/dataTables.js" type="text/javascript"></script>
<script>
$(document).ready(function () {
    $("#searchable-dropdown").change(function () {
        var themaNumber = $(this).val(); // Get selected thema_number

        if (themaNumber) {
            var newUrl = "https://game.reapbucks.com/new_open.php?offer_id=" + themaNumber;
            window.location.href = newUrl; // Redirect to new URL
        }
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let radios = document.querySelectorAll(".projectRadio");
    let createButton = document.getElementById("createWebsiteBtn");

    radios.forEach(radio => {
        radio.addEventListener("change", function() {
            createButton.style.display = "block";
            createButton.style.display = "inline";
        });
    });
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.querySelector(".template__show-all-text");
        const icon = toggleBtn.querySelector("i");

        toggleBtn.addEventListener("click", function () {
            if (icon.classList.contains("fa-chevron-down")) {
                icon.classList.remove("fa-chevron-down");
                icon.classList.add("fa-chevron-up");
            } else {
                icon.classList.remove("fa-chevron-up");
                icon.classList.add("fa-chevron-down");
            }
        });
    });
</script>
<script>
    new DataTable('#example');
</script>
<script>
$(document).ready(function(){
  $("#hide").click(function(){
    $("p").hide();
  });
  $("#show").click(function(){
    $("p").show();
  });
});
</script>

<?php
require('footer.inc.php');
?>