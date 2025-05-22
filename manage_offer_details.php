<?php
require('top.inc.php');

if (isset($_GET['offer']) && $_GET['offer'] != '') {
    $offer = get_safe_value($con, $_GET['offer']);
    $res = mysqli_query($con, "SELECT * FROM thema_list WHERE thema_number='$offer' AND status='1'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $thema_name = $row['thema_name'];
        $geo = $row['geo'];
        $image = $row['image'];
        $icon = $row['icon'];
        $thema_number = $row['thema_number'];
        $category = $row['category'];
        $short_desc = $row['short_desc'];
    } else {
        header('location:create_thema.php');
        die();
    }
}


    // Fetch categories from the database
    $category_id = $row['category'];
    $sql = "SELECT id, category_name FROM theme_category WHERE id =' $category_id' AND status='1'";
    $result = $con->query($sql);
    $rows = $result->fetch_assoc();
     
?>

<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <main class="main offer-page">
                <section class="section-main">
                    <article class="article">
                        <div class="offer --border-radius-20">
                            <h3 class="offer__title">Offer info</h3>
                            <div class="offer__info info">
                                <div class="info__product-image"
                                    style="background-image: url(&quot;images/thema_list/<?php echo $image?>&quot;);">
                                </div>
                                <div class="info__container">
                                    <div class="info__part"><span class="info__id"><i class="<?php echo $icon;?>"></i>&nbsp;&nbsp; ID<?php echo $thema_number;?> </span><span
                                            class="info__status --is-active"><span
                                                class="info__status-dot"></span>Active</span></div>
                                    <div class="info__part">
                                        <p class="info__product-name"><?php echo $thema_name;?></p>
                                        <p class="info__niche"><?php echo $rows['category_name'];?></p>
                                    </div>
                                    <div class="info__part"><a class="info__materials" href="#"
                                            target="_blank"><span class="info__materials-icon invert"></span><span
                                                class="info__materials-text">Product <?php echo $rows['category_name'];?></span></a><a
                                            class="info__button btn btn--gradient"
                                            href="new_open.php?offer_id=<?php echo $thema_number;?>"><i class="<?php echo $icon;?>"></i>&nbsp;Create Website</a></div>
                                </div>
                            </div>
                            
                            <div class="rules">
                                <p class="rules__title">Rules</p>
                                <p class="rules__text">
                                <p><?php echo $short_desc;?></p>
                            </div>
                        </div>
                    </article>
                    <aside class="aside --size-l">
                    </aside>
                </section>
            </main>
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