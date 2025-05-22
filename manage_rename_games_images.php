<?php
require('top.inc.php');


$name='';
$id='';
$msg='';
$image_required='required';
if(isset($_REQUEST['id'])&&($_REQUEST['id']!='')){
    $id=$_REQUEST['id'];
								
								$cat_res=mysqli_query($con,"select * from games_images where id='$id'");
								$cat_arr=array();
								while($row=mysqli_fetch_assoc($cat_res)){
								  $cat_arr[]=$row;    
								}
								 foreach($cat_arr as $list){
								  $old_name=$list['image'];
							
								 }
}
if(isset($_POST['submit'])){
	//prx($_POST);
	$new_name=get_safe_value($con,$_POST['name']);

					rename("../images/cars/$old_name","../images/cars/$new_name");
                    mysqli_query($con,"update games_images set image='$new_name' where id='$id'");
                    $id=mysqli_insert_id($con);
                    redirect('games_images.php');
				}
            

?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Rename Games Images</strong><small></small></div>
                        <form method="post" enctype="multipart/form-data">
							<div class="card-body card-block">
							   <div class="form-group">
									
                                    <div class="row">
									
									   <div class="col-lg-10">
										<label for="categories" class=" form-control-label">Old Name</label>
                                        <input type="text" value="<?php echo $old_name ?>" class="form-control" readonly>
									  </div>
									  <div class="col-lg-10">
										<label for="categories" class=" form-control-label">New Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter New Name" required>
									  </div>
								</div>	
							
							   <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info float-right">
							   <span id="payment-button-amount">Submit</span>
							   </button>
							   <div class="field_error"><?php echo $msg?></div>
							</div>
						</form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
		 
		 <script>
			function get_sub_cat(){
				var categories_id=jQuery('#categories_id').val();
                
				jQuery.ajax({
					url:'get_sub_cat.php',
					type:'post',
					data:'categories_id='+categories_id,
					success:function(result){
						jQuery('#sub_categories_id').html(result);
					}
				});
			}
            function get_variants(){
				var id=jQuery('#categories_id').val();
                
				jQuery.ajax({
					url:'get_variants.php',
					type:'post',
					data:'id='+id,
					success:function(result){
						jQuery('#categories_id2').html(result);
					}
				});
			}
		 </script>
         
<?php
require('footer.inc.php');
?>
<script>
<?php
if(isset($_GET['id'])){
?>
get_sub_cat('<?php echo $sub_categories_id?>');
<?php } ?>
</script>