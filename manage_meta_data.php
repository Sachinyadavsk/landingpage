
<?php
require('top.inc.php');

$page = '';
$des = '';
$msg = '';
$image_required = 'required';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $id = get_safe_value($con, $_GET['id']);
    $res = mysqli_query($con, "SELECT * FROM meta_data WHERE id='$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $page = $row['page'];
        $des = $row['data'];
    } else {
        header('location:meta_data.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    $page = get_safe_value($con, $_POST['page']);
    $des = mysqli_real_escape_string($con, $_POST['des']);

    if ($msg == '') {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $update_sql = "UPDATE meta_data SET page='$page', data='$des' WHERE id='$id'";
            if (!mysqli_query($con, $update_sql)) {
                echo "Error updating record: " . mysqli_error($con);
            }
        } else {
            $insert_sql = "INSERT INTO meta_data(page, data) VALUES('$page', '$des')";
            if (!mysqli_query($con, $insert_sql)) {
                echo "Error inserting record: " . mysqli_error($con);
            }
            $id = mysqli_insert_id($con);
        }

        redirect('meta_data.php');
    }
}
?>

<script src="https://cdn.ckeditor.com/4.17.0/standard/ckeditor.js"></script>
<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>Manage Meta Data</strong><small></small></div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body card-block">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <label for="categories" class="form-control-label">Page</label>
                                        <select class="form-control" name="page">
                                            <option value="<?php echo $page; ?>">
                                                <?php echo $page; ?>
                                            </option>
                                            <option value="home">Home</option>
                                            <option value="privacy_policy">Privacy Policy</option>
                                            <option value="team_of_conditions">Terms Conditions</option>
                                            <option value="about">About US</option>
                                            <option value="contact">Contact US</option>
                                            <option value="disclaimer">Disclaimer</option>
                                            <option value="faq">faqS</option>
                                            <option value="blog">Blog</option>
                                            <option value="Entertainment">Entertainment</option>
                                            <option value="funny">Funny</option>
                                            <option value="general_knowledge">General Knowledge</option>
                                            <option value="sports">Sports</option>
                                            <option value="trending">Trending</option>
                                            <option value="details">Details Game</option>
                                            <option value="playgame">Play Game</option>
                                            <option value="result">Result Game</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-10">
                                        <label for="categories" class="form-control-label">Content</label>
                                        <textarea type="text" name="des" id="desc" class="form-control des" rows="10" required><?php echo htmlspecialchars($des); ?></textarea>
                                    </div>
                                    <div class="col-lg-10 mt-2">
                                    <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info float-right">
                                        <span id="payment-button-amount">Submit</span>
                                    </button>
                                    </div>
                                   
                                    <div class="field_error"><?php echo $msg; ?></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require('footer.inc.php');
?>