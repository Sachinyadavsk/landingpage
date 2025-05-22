<?php
include 'confige.php';

if (isset($_POST['thema_id'])) {
    $thema_id = intval($_POST['thema_id']); // Ensure it's an integer to prevent SQL injection

    $query = "SELECT id, project_number FROM project_thema WHERE thema_id = $thema_id AND status='1'";
    $result = mysqli_query($con, $query);

    $options = "<option value=''>Choose Project Number</option>";
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= "<option value='{$row['id']}'>{$row['project_number']}</option>";
    }

    echo $options;
}
?>
