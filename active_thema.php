
<?php
require('top.inc.php');

if(isset($_GET['type']) && $_GET['type']!=''){
	$type=get_safe_value($con,$_GET['type']);
	
	if($type=='delete'){
		$id=get_safe_value($con,$_GET['id']);
		$delete_sql="delete from thema_campaign where id='$id'";
		mysqli_query($con,$delete_sql);
	}
	if($type=='status'){
	    $id=get_safe_value($con,$_GET['id']);
		$s=get_safe_value($con,$_GET['status']);
		$s_sql="update thema_campaign set status='$s' where id='$id'";
		mysqli_query($con,$s_sql);
	}
}
if($_SESSION['ROLE']=='admin'){
$sql="select * from thema_campaign order by thema_campaign.id desc";
$res=mysqli_query($con,$sql);
}elseif ($_SESSION['ROLE']=='user') {
$userid=$_SESSION['ADMIN_ID'];
$sql="select * from thema_campaign where user_id='$userid' and status='1' order by thema_campaign.id desc";
$res=mysqli_query($con,$sql);
}

?>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title"><?php if($_SESSION['ROLE']=='admin'){ ?>Active Thema List <?php }else{ echo 'Active thema List'; }?></h4>
				</div>
				<div class="card-body--">
				   <div class="table table-responsive">
					  <table class="table display" id="example" style="width:100%">
						 <thead>
							<tr>
							    <th>ID</th>
							   <th>Product</th>
							   <th>Name</th>
							   <th>Links</th>
							   <th>Action</th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
							$i=1;
							while($row=mysqli_fetch_assoc($res)){?>
							<tr>
							    <td><?php echo $i;?></td>
							   <td><?php 
                                                // Fetch categories from the database
                                                $thema_id = $row['thema_id'];
                                                $sql = "SELECT id, thema_name FROM thema_list WHERE thema_number ='$thema_id'";
                                                $result = $con->query($sql);
                                                if ($rows = $result->fetch_assoc()) {
                                                    echo $rows['thema_name'];
                                                }
                                                ?></td>
							   <td><?php echo $row['campaign_name']?></td>
							   <td><a target="_blank" href="https://game.reapbucks.com/<?php echo $row['url_link']?>">https://game.reapbucks.com/<?php echo $row['campaign_name']?></a></td>
							   <td>
								<?php
								    if($_SESSION['ROLE']=='admin'){
								        if($row['status']=='0'){
								echo "<span class='badge badge-warning'style='margin-right:5px;'><a style='color:white' href='?type=status&id=".$row['id']."&status=1'>Pending</a></span>";
							        }else{
								echo "<span class='badge badge-success'style='margin-right:5px;'><a style='color:white' href='?type=status&id=".$row['id']."&status=0'>Approved</a></span>";
							        }
							        echo "<span class='badge badge-primary'><a style='color:white' href='manage_thema_layout.php?id=".$row['thema_layout_new_id']."'>Thema Logo Edit </a></span>&nbsp;";
							        echo "<span class='badge badge-info'><a style='color:white' href='thema_feature_setting.php?id=".$row['project_thema_id']."'>Thema Feature Edit</a></span>&nbsp;";
								echo "<span class='badge badge-danger'><a style='color:white' href='?type=delete&id=".$row['id']."'>Delete</a></span>";
								
								
							        }else{
							          if($row['status']=='0'){
								echo "<span class='badge badge-warning'style='margin-right:5px;color:white'><a>Pending</a></span>";
							        }else{
								echo "<span class='badge badge-success'style='margin-right:5px;color:white'><a>Approved</a></span>";
							        }
							       echo "<span class='badge badge-primary'><a style='color:white' href='manage_thema_layout.php?id=".$row['thema_layout_new_id']."'>Thema Logo Edit </a></span>&nbsp;";
							        echo "<span class='badge badge-info'><a style='color:white' href='thema_feature_setting.php?id=".$row['project_thema_id']."'>Thema Feature Edit</a></span>&nbsp;";
							        }
								?>
							   </td>
							</tr>
							<?php $i++; } ?>
						 </tbody>
					  </table>
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