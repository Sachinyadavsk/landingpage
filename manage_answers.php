<?php
require('top.inc.php');

$question_id = '';
$is_correct = '';
$answer = '';
$msg = '';

if (isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $id = get_safe_value($con, $_GET['id']);
    $res = mysqli_query($con, "SELECT * FROM answers WHERE id='$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $question_id = $row['question_id'];
        $is_correct = $row['is_correct'];
        $answer = $row['answer'];
    } else {
        header('location:answers.php');
        die();
    }
}

if (isset($_POST['submit'])) {
    $question_id = get_safe_value($con, $_POST['question_id']);
    $is_correct = get_safe_value($con, $_POST['is_correct']);
    $answer = get_safe_value($con, $_POST['answer']);

    $res = mysqli_query($con, "SELECT * FROM answers WHERE answer='$answer'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $getData = mysqli_fetch_assoc($res);
            if ($id == $getData['id']) {
                // Allowed to proceed for update
            } else {
                $msg = "Answer already exists";
            }
        } else {
            $msg = "Answer already exists";
        }
    }

        
        if ($msg == '') {
            if (isset($_GET['id']) && $_GET['id'] != '') {
                if ($image != '') {
                    $update_sql = "UPDATE answers SET question_id='$question_id', is_correct='$is_correct', answer='$answer', status='0' WHERE id='$id'";
                } else {
                    $update_sql = "UPDATE answers SET question_id='$question_id', is_correct='$is_correct', answer='$answer', status='0' WHERE id='$id'";
                }
                mysqli_query($con, $update_sql);
            } else {
                mysqli_query($con, "INSERT INTO answers (question_id, is_correct, answer, status) VALUES ('$question_id', '$is_correct', '$answer', '0')");
            }
            header('location:answers.php');
            die();
        }
    
}
?>

<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>Manage Answers</strong><small></small></div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body card-block">
                            <div class="form-group">
                                <div class="row">
                                  <div class="col-lg-4">
                                        <label for="categories" class="form-control-label">Question Type</label>
                                        <select class="form-control" name="question_id" id="question_ids" required>
                                            <option value="">Select a Question Type</option>
                                            <?php
                                            $sql = "SELECT * FROM questions";
                                            $result = mysqli_query($con, $sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $selected = ($row['id'] == $question_id) ? 'selected' : '';
                                                echo "<option value='{$row['id']}' {$selected}>{$row['question']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="answer" class="form-control-label">Answer</label>
                                        <input type="text" name="answer" placeholder="Enter answer name" class="form-control" required value="<?php echo $answer ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="is_correct" class="form-control-label">Correct</label>
                                        <select name="is_correct" class="form-control" required>
                                        <option value="">Select a Correct</option>
                                            <option value="0" <?php echo $is_correct == '0' ? 'selected' : ''; ?>>False</option>
                                            <option value="1" <?php echo $is_correct == '1' ? 'selected' : ''; ?>>True</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                           
                            <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info float-right">
                                <span id="payment-button-amount">Submit</span>
                            </button>
                            <div class="field_error">
                                <?php echo $msg ?>
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

