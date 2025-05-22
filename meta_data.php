<?php
require('top.inc.php');

if(isset($_GET['type']) && $_GET['type']!=''){
	$type=get_safe_value($con,$_GET['type']);
	
	if($type=='delete'){
		$id=get_safe_value($con,$_GET['id']);
		$delete_sql="delete from meta_data where id='$id'";
		mysqli_query($con,$delete_sql);
	}

}
$sql="select * from meta_data order by meta_data.id desc";
$res=mysqli_query($con,$sql);
?>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-link"><a href="manage_meta_data.php" class="btn btn-dark">Add Meta Data</a> </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table">
						 <thead>
							<tr>
							   <th class="serial">#</th>
							   <th>Page</th>
							   <th>Content</th>
							   <th colspan="2"></th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
							$i=1;
							while($row=mysqli_fetch_assoc($res)){?>
							<tr>
							   <td class="serial"><?php echo $i?></td>
                               <td><?php echo $row['page']?></td>
                               <td><?php echo htmlspecialchars($row['data']);?></td>
							   <td class="blog_layouts">
								<?php
								    if($_SESSION['ROLE']=='admin'){
							        echo "<span class='badge badge-edit'><a href='manage_meta_data.php?id=".$row['id']."'>Edit</a></span>&nbsp;";

								echo "<span class='badge badge-delete'><a href='meta_data.php?type=delete&id=".$row['id']."'>Delete</a></span>";

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

<?php
require('footer.inc.php');
?>