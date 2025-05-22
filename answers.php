<?php
require('top.inc.php');

if(isset($_GET['type']) && $_GET['type']!=''){
	$type=get_safe_value($con,$_GET['type']);
	
	if($type=='delete'){
		$id=get_safe_value($con,$_GET['id']);
		$delete_sql="delete from answers where id='$id'";
		mysqli_query($con,$delete_sql);
	}
	if($type=='status'){
	    $id=get_safe_value($con,$_GET['id']);
		$s=get_safe_value($con,$_GET['status']);
		$s_sql="update answers set status='$s' where id='$id'";
		mysqli_query($con,$s_sql);
	}
}

$sql="select * from answers order by answers.id desc";
$res=mysqli_query($con,$sql);
?>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Answers </h4>
				   <h4 class="box-link"><a href="manage_answers.php" class="btn btn-dark">Add Answers</a> </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					   <table class="table display" id="example" style="width:100%">
						 <thead>
							<tr>
							   <th>#</th>
							   <th>Question</th>
							   <th>Answer</th>
							   <th>Correct</th>
							   <th></th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
							$i=1;
							while($row=mysqli_fetch_assoc($res)){?>
							<tr>
							   <td><?php echo $i?></td>
							   <td><?php echo $row['question_id']?></td>
							   <td><?php echo $row['answer']?></td>
							   <td><?php echo $row['is_correct']?></td>
							   <td>
								<?php
								    if($_SESSION['ROLE']=='admin'){
								        if($row['status']=='0'){
								echo "<span class='badge badge-warning'style='margin-right:5px;'><a href='?type=status&id=".$row['id']."&status=1'>Pending</a></span>";
							        }else{
								echo "<span class='badge badge-success'style='margin-right:5px;'><a href='?type=status&id=".$row['id']."&status=0'>Approved</a></span>";
							        }
							        								echo "<span class='badge badge-edit'><a href='manage_answers.php?id=".$row['id']."'>Edit</a></span>&nbsp;";

								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$row['id']."'>Delete</a></span>";

							        }else{
							        	        if($row['status']=='0'){
								echo "<span class='badge badge-warning'style='margin-right:5px;'><a>Pending</a></span>";
							        }else{
								echo "<span class='badge badge-success'style='margin-right:5px;'><a>Approved</a></span>";
							        }
								echo "<span class='badge badge-edit'><a href='manage_answers.php?id=".$row['id']."'>Edit</a></span>&nbsp;";
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