<?php
require('top.inc.php');
isAdmin();
if(isset($_GET['type']) && $_GET['type']!=''){
	$type=get_safe_value($con,$_GET['type']);
	if($type=='delete'){
		$id=get_safe_value($con,$_GET['id']);
		$delete_sql="delete from users where id='$id'";
		mysqli_query($con,$delete_sql);
	}
}

$sql="select * from users order by id desc";
$res=mysqli_query($con,$sql);
?>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Users </h4>
				      <h4 class="box-link"><a href="manage_user.php" class="btn btn-dark">Add Users</a> </h4>
				</div>
				<div class="card-body--">
				     <div class="table table-responsive">
    					  <table class="table display" id="example" style="width:100%">
        						 <thead>
        							<tr>
        							   <th class="serial">#</th>
        							   <th>ID</th>
        							   <th>Name</th>
        							   <th>Email</th>
        							   <th>Mobile</th>
        							   <th>Date</th>
        							   <th></th>
        							</tr>
        						 </thead>
        						 <tbody>
        							<?php 
        							$i=1;
        							while($row=mysqli_fetch_assoc($res)){?>
        							<tr>
        							   <td class="serial"><?php echo $i?></td>
        							   <td>87520<?php echo $row['id']?></td>
        							   <td><?php echo $row['name']?></td>
        							   <td><?php echo $row['email']?></td>
        							   <td><?php echo $row['mobile']?></td>
        							   <td><?php echo $row['created_at']?></td>
        							   <td>
        								<?php
        								echo "<span class='badge badge-edit'><a href='manage_user.php?id=".$row['id']."'>Edit</a></span>&nbsp;";
        								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$row['id']."'>Delete</a></span>";
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
<script src="assets/js/jquery-3.7.1.js" type="text/javascript"></script>
 <script src="assets/js/dataTables.js" type="text/javascript"></script>
<script>
    new DataTable('#example');
</script>
<?php
require('footer.inc.php');
?>