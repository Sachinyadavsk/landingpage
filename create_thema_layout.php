<?php
require('top.inc.php');

if(isset($_GET['type']) && $_GET['type']!=''){
	$type=get_safe_value($con,$_GET['type']);
	
	if($type=='delete'){
		$id=get_safe_value($con,$_GET['id']);
		$delete_sql="delete from thema_layout where id='$id'";
		mysqli_query($con,$delete_sql);
	}
	if($type=='status'){
	    $id=get_safe_value($con,$_GET['id']);
		$s=get_safe_value($con,$_GET['status']);
		$s_sql="update thema_layout set status='$s' where id='$id'";
		mysqli_query($con,$s_sql);
	}
}
// Fetch distinct thema IDs


if($_SESSION['ROLE']=='admin'){
$thema_sql = "SELECT DISTINCT thema_id FROM thema_layout ORDER BY thema_id DESC";
$thema_res = mysqli_query($con, $thema_sql);
}elseif ($_SESSION['ROLE']=='user') {
$userid=$_SESSION['ADMIN_ID'];
$thema_sql = "SELECT DISTINCT thema_id FROM thema_layout WHERE user_id='$userid' ORDER BY thema_id DESC";
$thema_res = mysqli_query($con, $thema_sql);
}
?>




<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title"><?php echo ($_SESSION['ROLE'] == 'admin') ? 'Thema Logo List' : 'Offers'; ?></h4>
                        <?php if ($_SESSION['ROLE'] == 'admin') { ?>
                            <h4 class="box-link"><a href="manage_thema_layout.php" class="btn btn-dark">Add Thema Logo</a></h4>
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

                                            <div class="accordion" id="projectAccordion<?php echo $thema_id; ?>">
                                            <div class="card-body">
                                                <div class="table table-responsive">
					                                   <table class="table display" id="example" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Image</th>
                                                                <th>Project Thema</th>
                                                                <th>Website Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            // Fetch Layouts related to the current `thema_id`
                                                            $layout_sql = "SELECT * FROM thema_layout WHERE thema_id='$thema_id' ORDER BY id DESC";
                                                            $layout_res = mysqli_query($con, $layout_sql);
                                                            while ($layout_row = mysqli_fetch_assoc($layout_res)) {
                                                                $pro_th_id = $layout_row['pro_th_id'];
                                
                                                                // Fetch Project Thema Name
                                                                $pro_sql = "SELECT project_number FROM project_thema WHERE id='$pro_th_id' AND status='1'";
                                                                $pro_res = mysqli_query($con, $pro_sql);
                                                                $project = mysqli_fetch_assoc($pro_res);
                                                                $project_name = $project ? $project['project_number'] : 'N/A';
                                                            ?>
                                                                <tr>
                                                                    <td>
                                                                        <img src="images/thema_gallery/<?php echo $layout_row['image']; ?>" 
                                                                             class="rounded-circle" 
                                                                             alt="<?php echo $layout_row['website_name']; ?>" width="50px" height="50px">
                                                                    </td>
                                                                    <td>
                                                                        <a href="https://game.reapbucks.com/templete/<?php echo $project_name; ?>" style="color:blue;text-decoration-line: underline;">
                                                                            <?php echo $project_name; ?>
                                                                        </a>
                                                                    </td>
                                                                    <td><?php echo $layout_row['website_name']; ?></td>
                                                                    <td>
                                                                        <?php if ($_SESSION['ROLE'] == 'admin') { ?>
                                                                            <?php if ($layout_row['status'] == '0') { ?>
                                                                                <span class='badge badge-warning'>
                                                                                    <a href='?type=status&id=<?php echo $layout_row['id']; ?>&status=1' style='color:white'>Pending</a>
                                                                                </span>
                                                                            <?php } else { ?>
                                                                                <span class='badge badge-success'>
                                                                                    <a href='?type=status&id=<?php echo $layout_row['id']; ?>&status=0' style='color:white'>Approved</a>
                                                                                </span>
                                                                            <?php } ?>
                                                                            <span class='badge badge-edit'>
                                                                                <a href='manage_thema_layout.php?id=<?php echo $layout_row['id']; ?>'>Edit</a>
                                                                            </span>
                                                                            <span class='badge badge-delete'>
                                                                                <a href='?type=delete&id=<?php echo $layout_row['id']; ?>'>Delete</a>
                                                                            </span>
                                                                        <?php } else { ?>
                                                                            <span class='badge <?php echo ($layout_row['status'] == '0') ? 'badge-warning' : 'badge-success'; ?>'>
                                                                                <?php echo ($layout_row['status'] == '0') ? 'Pending' : 'Approved'; ?>
                                                                            </span>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    </div>
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