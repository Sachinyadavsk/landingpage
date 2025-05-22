
<?php
require('top.inc.php');

if(isset($_GET['type']) && $_GET['type']!=''){
	$type=get_safe_value($con,$_GET['type']);
	
	if($type=='delete'){
		$id=get_safe_value($con,$_GET['id']);
		$delete_sql="delete from theme_category where id='$id'";
		mysqli_query($con,$delete_sql);
	}
	if($type=='status'){
	    $id=get_safe_value($con,$_GET['id']);
		$s=get_safe_value($con,$_GET['status']);
		$s_sql="update theme_category set status='$s' where id='$id'";
		mysqli_query($con,$s_sql);
	}
}

$sql="select * from theme_category order by theme_category.id desc";
$res=mysqli_query($con,$sql);
?>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title"><?php if($_SESSION['ROLE']=='admin'){ ?>Category List <?php }else{ echo 'Offers'; }?></h4>
				   <?php if($_SESSION['ROLE']=='admin'){ ?>
				   <h4 class="box-link"><a href="manage_category.php" class="btn btn-dark">Add Category</a> </h4>
				   <?php 
				   }
				   else{ }?>
				</div>
				<div class="card-body--">
				   <div class="table table-responsive">
					  <table class="table display" id="example" style="width:100%">
						 <thead>
							<tr>
							   <th></th>
							   <th>Name</th>
							   <th>Action</th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
							$i=1;
							while($row=mysqli_fetch_assoc($res)){?>
							<tr>
							   <td><img src="images/category/<?php echo $row['image']?>" class="rounded-circle" alt="<?php echo $row['category_name']?>" width="50px" height="50px"></td>
							   <td><?php echo $row['category_name']?></td>
							   <td>
								<?php
								    if($_SESSION['ROLE']=='admin'){
								        if($row['status']=='0'){
								echo "<span class='badge badge-warning'style='margin-right:5px;'><a style='color:white' href='?type=status&id=".$row['id']."&status=1'>Pending</a></span>";
							        }else{
								echo "<span class='badge badge-success'style='margin-right:5px;'><a style='color:white' href='?type=status&id=".$row['id']."&status=0'>Approved</a></span>";
							        }
							        								echo "<span class='badge badge-edit'><a href='manage_category.php?id=".$row['id']."'>Edit</a></span>&nbsp;";

								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$row['id']."'>Delete</a></span>";

							        }else{
							        	        if($row['status']=='0'){
								echo "<span class='badge badge-warning'style='margin-right:5px;'><a style='color:white'>Pending</a></span>";
							        }else{
								echo "<span class='badge badge-success'style='margin-right:5px;'><a style='color:white'>Approved</a></span>";
							        }
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