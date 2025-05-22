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
$thid = isset($_GET['id']) ? get_safe_value($con, $_GET['id']) : '';

if($_SESSION['ROLE']=='admin'){
$thema_sql = "SELECT DISTINCT pro_th_id FROM thema_layout WHERE pro_th_id='$thid' ORDER BY pro_th_id DESC";
$thema_res = mysqli_query($con, $thema_sql);
}elseif ($_SESSION['ROLE']=='user') {
$userid=$_SESSION['ADMIN_ID'];
$thema_sql = "SELECT DISTINCT pro_th_id FROM thema_layout WHERE user_id='$userid' AND pro_th_id='$thid' ORDER BY pro_th_id DESC";
$thema_res = mysqli_query($con, $thema_sql);
}
?>




<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">
                            <?php echo ($_SESSION['ROLE'] == 'admin') ? 'Thema Feature Layout Section' : 'Thema Feature Layout Section'; ?>
                        </h4>
                    </div>

                    <div class="card-body--">
                        <div class="accordion" id="themaAccordion">
                            <?php while ($thema = mysqli_fetch_assoc($thema_res)) {
                             $pro_th_id = $thema['pro_th_id'];

                                // Fetch Project Number
                                $project_name_query = "SELECT project_number FROM project_thema WHERE id = '$pro_th_id' AND status = '1'";
                                $project_name_res = mysqli_query($con, $project_name_query);
                                $project_name = ($row_p = mysqli_fetch_assoc($project_name_res)) ? $row_p['project_number'] : "Unknown Project";
                                
                                $layout_sql_pro = "SELECT * FROM thema_layout WHERE pro_th_id = '$pro_th_id' ORDER BY id DESC";
                                 $layout_res_pro = mysqli_query($con, $layout_sql_pro);
                                 $layout_res_pro_result = mysqli_fetch_assoc($layout_res_pro);
                                                    
                               // Fetch related Project IDs (Ensure table name matches your database)
                                    $layout_sql = "SELECT * FROM Theme_feature_layout WHERE pro_th_id = '$pro_th_id' ORDER BY id DESC";
                                    $layout_res = mysqli_query($con, $layout_sql);
                                ?>
                            <div class="card">
                                <div class="card-header" id="heading<?php echo $pro_th_id; ?>">
                                     <h2 class="mb-0" style="display: flex;gap: 45%;">
                                        <span>
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#collapse<?php echo $pro_th_id; ?>" aria-expanded="true"
                                            aria-controls="collapse<?php echo $pro_th_id; ?>">
                                            Project Thema Name &nbsp;ID <?php echo $project_name; ?>  
                                        </button>
                                        </span>
                                        <span style="font-size: 18px;color: #138496;"> Visit website  &nbsp; <a style="color:blue" href="https://game.reapbucks.com/templete/<?php echo $project_name; ?>" target="_blank"><img src="images/thema_gallery/<?php echo $layout_res_pro_result['image']; ?>" class="rounded-circle"  width="50px" height="50px"> <i class="fa fa-eye" aria-hidden="true"></i></a>
                                        </span>
                                    </h2>
                                </div>

                                <div id="collapse<?php echo $pro_th_id; ?>" class="collapse"
                                    aria-labelledby="heading<?php echo $pro_th_id; ?>" data-parent="#themaAccordion">
                                    <div class="accordion" id="projectAccordion<?php echo $pro_th_id; ?>">
                                        <div class="card-body">
                                            <div class="table table-responsive">
                                                <table class="table display" id="example" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Image</th>
                                                            <th>Name</th>
                                                            <th>Menu / Section Name</th>
                                                            <th>Link</th>
                                                            <th>Button Name</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                                            $current_section = ""; // Track the current section to group entries
                                                                            while ($layout = mysqli_fetch_assoc($layout_res)) { 
                                                                                // Check if we need to display the section name (only for the first occurrence in the group)
                                                                                $show_section = ($layout['section_name'] != $current_section) ? $layout['section_name'] : "";
                                                                                $current_section = $layout['section_name']; // Update current section
                                                                            ?>
                                                        <tr>
                                                            <td>
                                                                <?php if (!empty($layout['image'])) { ?>
                                                                <img src="images/thema_gallery/<?php echo $layout['image']; ?>"
                                                                    class="rounded-circle"
                                                                    alt="<?php echo $layout['title']; ?>" width="50px"
                                                                    height="50px">
                                                                <?php }else{ ?>
                                                                <img src="images/question_url.png"
                                                                    class="rounded-circle" alt="" width="50px"
                                                                    height="50px">
                                                                <?php } ?>


                                                            </td>
                                                            <td>
                                                                <?php echo $layout['title']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo (!empty($show_section)) ? "<strong>$show_section</strong>" : "?"; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $layout['add_link']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo !empty($layout['button_url_name']) ? $layout['button_url_name']: 'Read More';?>
                                                            </td>
                                                            <td>
                                                                <?php if ($_SESSION['ROLE'] == 'admin') {
                                                                    if ($layout['status'] == '0') {
                                                                        echo "<span class='badge badge-warning' style='margin-right:5px;'><a style='color:white' href='?type=status&id=".$layout['id']."&status=1'>Pending</a></span>";
                                                                    } else {
                                                                        echo "<span class='badge badge-success' style='margin-right:5px;'><a style='color:white' href='?type=status&id=".$layout['id']."&status=0'>Approved</a></span>";
                                                                    }
                                                                   echo "<span class='badge badge-edit'><a href='manage_thema_feature_layout.php?id=".$layout['id']."&pro_th_id=".$thid."'>Edit</a></span>&nbsp;";
                                                                    echo "<span class='badge badge-delete'><a href='?type=delete&id=".$layout['id']."'>Delete</a></span>";
                                                                } else {
                                                                    echo ($layout['status'] == '0') ? "<span class='badge badge-warning' style='margin-right:5px;' style='color:white'>Pending</span>" : "<span class='badge badge-success' style='margin-right:5px;' style='color:white'>Approved</span>";
                                                                     echo "<span class='badge badge-edit'><a href='manage_thema_feature_layout.php?id=".$layout['id']."&pro_th_id=".$thid."'>Edit</a></span>&nbsp;";
                                                                    echo "<span class='badge badge-delete'><a href='?type=delete&id=".$layout['id']."'>Delete</a></span>";
                                                                } ?>
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Open the first accordion item by default
    let firstAccordion = document.querySelector(".accordion .collapse");
    if (firstAccordion) {
        firstAccordion.classList.add("show");
    }

    // Handle click event for accordions
    let accordions = document.querySelectorAll(".accordion .btn-link");
    accordions.forEach(button => {
        button.addEventListener("click", function () {
            let target = this.getAttribute("data-target");

            // Hide all collapse elements
            document.querySelectorAll(".accordion .collapse").forEach(collapse => {
                if ("#" + collapse.id !== target) {
                    collapse.classList.remove("show");
                }
            });

            // Toggle the clicked one
            let selectedAccordion = document.querySelector(target);
            if (selectedAccordion) {
                selectedAccordion.classList.toggle("show");
            }
        });
    });
});

</script>
<script src="assets/js/jquery-3.7.1.js" type="text/javascript"></script>
<script src="assets/js/dataTables.js" type="text/javascript"></script>
<script>
    new DataTable('#example');
</script>
<?php
require('footer.inc.php');
?>