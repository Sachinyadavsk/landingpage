<?php
require('top.inc.php');
if(isset($_GET['type']) && $_GET['type']!=''){
	$type=get_safe_value($con,$_GET['type']);
	if($type=='delete'){
		$id=get_safe_value($con,$_GET['id']);
		$delete_sql="delete from blog_images where id='$id'";
		mysqli_query($con,$delete_sql);
	}
}
//$sql="select product.*,categories.categories from product,categories where product.categories_id=categories.id $condition order by product.id desc";
$sql="select * from blog_images order by blog_images.id desc";
$res=mysqli_query($con,$sql);
?>
<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card">
				<div class="card-body">
				   <h4 class="box-title">Blog Images</h4>
				   <h4 class="box-link"><a href="manage_blog_images.php">Add Image</a> </h4>
				</div>
				<div class="card-body--">
				   <div class="table-stats order-table ov-h">
					  <table class="table ">
						 <thead>
							<tr>
							   <th class="serial">#</th>
							   <th width="70%">Image</th>
							   <th width="26%"></th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
							$i=1;
							while($row=mysqli_fetch_assoc($res)){?>
							<tr>
							   <td class="serial"><?php echo $i?></td>
							   <td><img src="<?php echo '../images/blog/'.$row['image']?>" alt="" width="100%">
							   <span style="text-transform:none" id="textToCopy<?php echo $i;?>"><?php echo 'https://drive360.in/images/blog/'.$row['image']?></span>
							   </td>
							   </td>
							   <td>
								<?php
								    if($_SESSION['ROLE']=='admin'){
					
							        								echo "<span class='badge badge-edit'><a href='javascript:void(0)' onclick='copyText(".$i.")'>Copy Link</a></span>&nbsp;";

								echo "<span class='badge badge-delete'><a href='?type=delete&id=".$row['id']."'>Delete</a></span>";

							        }else{
						
								echo "<span class='badge badge-edit'><a href='javascript:void(0)' onclick='copyText(".$i.")'>Copy Link</a></span>&nbsp;";
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
<script>
function copyText(index) {
  var text = document.getElementById("textToCopy" + index); // Concatenate index with ID
  var range = document.createRange();
  range.selectNode(text);
  window.getSelection().removeAllRanges();
  window.getSelection().addRange(range);
  document.execCommand("copy");
  window.getSelection().removeAllRanges();
  alert("Text copied " + index + ": " + text.innerText);
}
</script>
<?php
require('footer.inc.php');
?>