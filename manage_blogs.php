<?php
require('top.inc.php');

// Function to compress images
function compress_image($source, $destination, $quality) {
    $check = getimagesize($source);
    if ($check !== false) {
        $imageFileType = strtolower(pathinfo($destination, PATHINFO_EXTENSION));

        // Compress JPEG images
        if ($imageFileType == 'jpg' || $imageFileType == 'jpeg') {
            $image = imagecreatefromjpeg($source);
            imagejpeg($image, $destination, $quality);
        }
        // Compress PNG images
        elseif ($imageFileType == 'png') {
            $image = imagecreatefrompng($source);
            imagepng($image, $destination, 9); // Compression level for PNG is 0-9
        }
        // Free memory
        imagedestroy($image);
    } else {
        return false;
    }
    return true;
}

$dat = $tit = $des = $pic = $url = $added_by = $keywords = $descriptions = $msg = '';
$image_required = 'required';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $id = get_safe_value($con, $_GET['id']);
    $res = mysqli_query($con, "SELECT * FROM blogs WHERE id='$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $dat = $row['datee'];
        $tit = $row['title'];
        $keywords = $row['keywords'];
        $descriptions = $row['descriptions'];
        $des = $row['description'];
        $pic = $row['image1'];
        $url = $row['url'];
        $added_by = $row['added_by'];
    } else {
        header('location:blogs.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    $dat = get_safe_value($con, $_POST['dat']);
    $tit = get_safe_value($con, $_POST['tit']);
    $keywords = get_safe_value($con, $_POST['keywords']);
    $descriptions = get_safe_value($con, $_POST['descriptions']);
    $des = $_POST['des'];
    $added_by = get_safe_value($con, $_POST['added_by']);
    $url = get_safe_value($con, $_POST['url']);
    
    if ($msg == '') {
        $target_dir = "../images/blogs/";
        $photo = '';

        // If an image is uploaded
        if ($_FILES['pic']['name'] != '') {
            $photo = basename($_FILES['pic']['name']);
            $ext = strtolower(pathinfo($photo, PATHINFO_EXTENSION));
            $valid_ext = array('png', 'jpg', 'jpeg');
            $photo = rand(111111, 999999) . $photo;
            if (in_array($ext, $valid_ext)) {
                $target_file = $target_dir . $photo;

                // Compress the image before moving it to the target directory
                if (compress_image($_FILES['pic']['tmp_name'], $target_file, 30)) {
                    if (isset($_GET['id']) && $_GET['id'] != '') {
                        // Update query
                        $update_sql = "UPDATE blogs SET datee='$dat', title='$tit', description='$des', image1='$photo', keywords='$keywords', descriptions='$descriptions', url='$url', added_by='$added_by', status='0' WHERE id='$id'";
                        mysqli_query($con, $update_sql);
                    } else {
                        // Insert query
                        mysqli_query($con, "INSERT INTO blogs (datee, title, image1, description, keywords, descriptions, url, added_by, status) VALUES ('$dat', '$tit', '$photo', '$des', '$keywords', '$descriptions', '$url', '$added_by', '0')");
                        $id = mysqli_insert_id($con);
                    }
                    redirect('blogs.php');
                } else {
                    $msg = "Image compression failed.";
                }
            } else {
                $msg = "Invalid image format. Only JPG, JPEG, and PNG are allowed.";
            }
        } else {
            // If no image is uploaded (for updating without changing the image)
            if (isset($_GET['id']) && $_GET['id'] != '') {
                $update_sql = "UPDATE blogs SET datee='$dat', title='$tit', description='$des', keywords='$keywords', descriptions='$descriptions', url='$url', added_by='$added_by', status='0' WHERE id='$id'";
                mysqli_query($con, $update_sql);
            }
            redirect('blogs.php');
        }
    }
}
?>

<script src="https://cdn.ckeditor.com/4.17.0/standard/ckeditor.js"></script>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Manage Blog</strong><small></small></div>
                        <form method="post" enctype="multipart/form-data">
							<div class="card-body card-block">
							   <div class="form-group">
									<div class="row">
  
                                <div class="col-lg-10">
										<label for="categories" class=" form-control-label">Date</label>
                                        <input type="date" name="dat" value="<?php echo $dat;?>" class="form-control" required>
									  </div>
																
                                      <div class="col-lg-10">
										<label for="categories" class=" form-control-label">Title</label>
                                        <input type="text" name="tit" value="<?php echo $tit;?>" class="form-control" required>
									  </div>
									  	  <?php if($pic!=''){?>
                                      <div class="col-lg-10">
										<label for="categories" class=" form-control-label">Image</label>
                                        <input type="file" name="pic" value="<?php echo $pic;?>" class="form-control">
                                        <p>*Image dimensions should be 1000 x 500 pixels for better view</p>
									  </div>
                                      
								<?php }else{?>
								
								<div class="col-lg-10">
										<label for="categories" class=" form-control-label">Image</label>
                                        <input type="file" name="pic" class="form-control" required>
                                        <p>*Image dimensions should be 1000 x 500 pixels for better view</p>
									  </div>
								<?php }?>
                                      <div class="col-lg-10">
										<label for="categories" class=" form-control-label">Blog</label>
                                        <textarea type="text" name="des" id="desc" class="form-control des" required><?php echo $des;?></textarea>
									  </div>
								
								<div class="col-lg-10">
										<label for="categories" class=" form-control-label">Meta Keywords</label>
                                        <input type="text" name="keywords" value="<?php echo $keywords;?>" class="form-control">
									  </div>
									  <div class="col-lg-10">
										<label for="categories" class=" form-control-label">Meta description</label>
                                        <input type="text" name="descriptions" value="<?php echo $descriptions;?>" class="form-control">
									  </div>
									   <div class="col-lg-10">
										<label for="categories" class=" form-control-label">Url</label>
                                        <input type="text" name="url" value="<?php echo $url;?>" class="form-control" required>
									  </div>
									  <div class="col-lg-10">
										<label for="categories" class=" form-control-label">Added By</label>
                                        <input type="text" name="added_by" value="<?php echo $added_by;?>" class="form-control" required>
									  </div>
							   <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block col-lg-10">
							   <span id="payment-button-amount">Submit</span>
							   </button>
							   <div class="field_error"><?php echo $msg?></div>
							</div>
                                 </div>
                                 </div>
						</form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
		 
<script>
    function copyText(index) {
  var text = document.getElementById("textToCopy"+index);
  var range = document.createRange();
  range.selectNode(text);
  window.getSelection().removeAllRanges();
  window.getSelection().addRange(range);
  document.execCommand("copy");
  window.getSelection().removeAllRanges();
  alert("Text copied: " + text.innerText);
}
</script>
     <script>
    CKEDITOR.replace('desc', {
        // Custom configuration options
        toolbar: 'Basic'
    });
</script>
 
<?php
require('footer.inc.php');
?>
