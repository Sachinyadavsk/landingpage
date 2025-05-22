
<?php
require('top.inc.php');

if(isset($_GET['type']) && $_GET['type']!=''){
	$type=get_safe_value($con,$_GET['type']);
	
	if($type=='delete'){
		$id=get_safe_value($con,$_GET['id']);
		$delete_sql="delete from Theme_feature_layout where id='$id'";
		mysqli_query($con,$delete_sql);
	}
	if($type=='status'){
	    $id=get_safe_value($con,$_GET['id']);
		$s=get_safe_value($con,$_GET['status']);
		$s_sql="update Theme_feature_layout set status='$s' where id='$id'";
		mysqli_query($con,$s_sql);
	}
}

// Fetch distinct Thema IDs



if($_SESSION['ROLE']=='admin'){
$thema_sql = "SELECT DISTINCT thema_id FROM Theme_feature_layout";
$thema_res = mysqli_query($con, $thema_sql);
}elseif ($_SESSION['ROLE']=='user') {
$userid=$_SESSION['ADMIN_ID'];
$thema_sql = "SELECT DISTINCT thema_id FROM Theme_feature_layout WHERE user_id='$userid'";
$thema_res = mysqli_query($con, $thema_sql);
}
?>

<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title"><?php echo ($_SESSION['ROLE'] == 'admin') ? 'Thema Feature Layout List' : 'Offers'; ?></h4>
                        <?php if ($_SESSION['ROLE'] == 'admin') { ?>
                            <h4 class="box-link"><a href="manage_thema_feature_layout.php" class="btn btn-dark">Add Thema Feature Layout</a></h4>
                        <?php } ?>
                    </div>

                    <div class="card-body--">
                        <div class="accordion" id="themaAccordion">
                            <?php while ($thema = mysqli_fetch_assoc($thema_res)) {
                                $thema_id = $thema['thema_id'];
                                
                                // Fetch Thema Name
                                $thema_name_query = "SELECT thema_name FROM thema_list WHERE id = '$thema_id' AND status = '1'";
                                $thema_name_res = mysqli_query($con, $thema_name_query);
                                $thema_name = ($row = mysqli_fetch_assoc($thema_name_res)) ? $row['thema_name'] : "Unknown Thema";

                                // Fetch related Project IDs
                                $project_sql = "SELECT DISTINCT pro_th_id FROM Theme_feature_layout WHERE thema_id = '$thema_id'";
                                $project_res = mysqli_query($con, $project_sql);
                            ?>
                                <div class="card">
                                    <div class="card-header" id="heading<?php echo $thema_id; ?>">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $thema_id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $thema_id; ?>">
                                                <?php echo $thema_name; ?>
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapse<?php echo $thema_id; ?>" class="collapse" aria-labelledby="heading<?php echo $thema_id; ?>" data-parent="#themaAccordion">
                                        <div class="card-body">
                                            <div class="accordion" id="projectAccordion<?php echo $thema_id; ?>">
                                                <?php while ($project = mysqli_fetch_assoc($project_res)) {
                                                    $pro_th_id = $project['pro_th_id'];
                                                    
                                                    // Fetch Project Number
                                                    $project_name_query = "SELECT project_number FROM project_thema WHERE id = '$pro_th_id' AND status = '1'";
                                                    $project_name_res = mysqli_query($con, $project_name_query);
                                                    $project_name = ($row_p = mysqli_fetch_assoc($project_name_res)) ? $row_p['project_number'] : "Unknown Project";
                                                    
                                                     $layout_sql_pro = "SELECT * FROM thema_layout WHERE thema_id = '$thema_id' AND pro_th_id = '$pro_th_id' ORDER BY id DESC";
                                                     $layout_res_pro = mysqli_query($con, $layout_sql_pro);
                                                     $layout_res_pro_result = mysqli_fetch_assoc($layout_res_pro);

                                                    // Fetch related Theme_feature_layout records
                                                    $layout_sql = "SELECT * FROM Theme_feature_layout WHERE thema_id = '$thema_id' AND pro_th_id = '$pro_th_id' ORDER BY id DESC";
                                                    $layout_res = mysqli_query($con, $layout_sql);
                                                    
                                                     
                                                ?>
                                                    <div class="card">
                                                        <div class="card-header" id="projectHeading<?php echo $pro_th_id; ?>">
                                                            <h2 class="mb-0" style="display: flex;gap: 45%;">
                                                                <span>
                                                                    <a href="thema_feature_setting.php?id=<?php echo $pro_th_id;?>" class="btn btn-link"> Project Thema Name &nbsp;ID <?php echo $project_name; ?></a>
                                                                <!--<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseProject<?php echo $pro_th_id; ?>" aria-expanded="true" aria-controls="collapseProject<?php echo $pro_th_id; ?>">-->
                                                                <!--     <?php echo $pro_th_id;?> -->
                                                                <!--</button>-->
                                                                </span>
                                                                <span style="font-size: 18px;color: #138496;"> Visit website  &nbsp; <a style="color:blue" href="https://game.reapbucks.com/templete/<?php echo $project_name; ?>" target="_blank"><img src="images/thema_gallery/<?php echo $layout_res_pro_result['image']; ?>" class="rounded-circle" alt="<?php echo $layout['title']; ?>" width="50px" height="50px"> <i class="fa fa-eye" aria-hidden="true"></i></a>
                                                                </span>
                                                            </h2>
                                                        </div>

                                                        
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
 <script src="assets/js/jquery-3.7.1.js" type="text/javascript"></script>
 <script src="assets/js/dataTables.js" type="text/javascript"></script>
<script>
    new DataTable('#example');
</script>
<?php
require('footer.inc.php');
?>