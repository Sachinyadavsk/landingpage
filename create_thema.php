
<?php
require('top.inc.php');

if(isset($_GET['type']) && $_GET['type']!=''){
	$type=get_safe_value($con,$_GET['type']);
	
	if($type=='delete'){
		$id=get_safe_value($con,$_GET['id']);
		$delete_sql="delete from thema_list where id='$id'";
		mysqli_query($con,$delete_sql);
	}
	if($type=='status'){
	    $id=get_safe_value($con,$_GET['id']);
		$s=get_safe_value($con,$_GET['status']);
		$s_sql="update thema_list set status='$s' where id='$id'";
		mysqli_query($con,$s_sql);
	}
}

if($_SESSION['ROLE']=='admin'){
    $sql="select * from thema_list order by thema_list.id desc";
}else{
    $sql="select * from thema_list where status='1' order by thema_list.id desc";
}

$res=mysqli_query($con,$sql);
?>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title"><?php if($_SESSION['ROLE']=='admin'){ ?>Thema List <?php }else{ echo 'Offers'; }?></h4>
				   <?php if($_SESSION['ROLE']=='admin'){ ?>
				   <h4 class="box-link"><a href="manage_thema.php" class="btn btn-dark">Add Thema</a> </h4>
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
							   <th>ID</th>
							   <th>Name</th>
							   <th>Geo</th>
							   <th>Category</th>
							   <th>Action</th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
							$i=1;
							while($row=mysqli_fetch_assoc($res)){?>
							<tr>
							   <td><img src="images/thema_list/<?php echo $row['image']?>" class="rounded-circle" alt="<?php echo $row['thema_name']?>" width="50px" height="50px"></td>
							   <td><?php echo $row['thema_number']?></td>
							   <td><?php echo $row['thema_name']?></td>
							   <td><?php echo $row['geo']?></td>
							   <td>
							       <?php 
                                                // Fetch categories from the database
                                                $category_id = $row['category'];
                                                $sql = "SELECT id, category_name FROM theme_category WHERE id =' $category_id' AND status='1'";
                                                $result = $con->query($sql);
                                                if ($rows = $result->fetch_assoc()) {
                                                    echo $rows['category_name'];
                                                }
                                                ?>
							       </td>
							   <td>
								<?php
								    if($_SESSION['ROLE']=='admin'){
								        if($row['status']=='0'){
								echo "<span class='badge badge-warning'style='margin-right:5px;'><a style='color:white' href='?type=status&id=".$row['id']."&status=1'>Pending</a></span>";
							        }else{
								echo "<span class='badge badge-success'style='margin-right:5px;'><a style='color:white' href='?type=status&id=".$row['id']."&status=0'>Approved</a></span>";
							        }
							        								echo "<span class='badge badge-edit'><a href='manage_thema.php?id=".$row['id']."'>Edit</a></span>&nbsp;";

								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$row['id']."'>Delete</a></span>";
								echo "<span class='badge badge-delete' style='font-size: 22px;'><a href='manage_offer_details.php?offer=".$row['thema_number']."'><i class='fa fa-plus-circle me-2'></i></a></span>";

							        }else{
							        	        if($row['status']=='0'){
								echo "<span class='badge badge-warning'style='margin-right:5px;'><a style='color:white'>Pending</a></span>";
							        }else{
								echo "<span class='badge badge-success'style='margin-right:5px;'><a style='color:white'>Approved</a></span>";
							        }
								echo "<span class='badge badge-delete' style='font-size: 22px;'><a href='manage_offer_details.php?offer=".$row['thema_number']."'><i class='fa fa-plus-circle me-2'></i></a></span>";
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