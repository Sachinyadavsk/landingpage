<?php
require('confige.php');

 // current url according set condition
    $current_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $number = basename($current_url);
    $sqldyn = "SELECT * FROM project_thema WHERE project_number ='$number'";
    $resultdyn = $con->query($sqldyn);
    $rowsdyn = $resultdyn->fetch_assoc();
    
    
    $thema_id = $rowsdyn['thema_id'];
    $pro_th_id = $rowsdyn['id'];
    // current url according set condition
    
    // website layout
    $sql = "SELECT * FROM thema_layout WHERE thema_id =' $thema_id' AND pro_th_id='$pro_th_id' AND status='1'";
    $result = $con->query($sql);
    $rows = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo !empty($rows['website_name']) ? $rows['website_name']: 'Coming Soon!';?></title>
  <!-- load CSS -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">
  <link rel="stylesheet" href="thema_2m/css/bootstrap.min.css"> 
  <link rel="stylesheet" href="thema_2m/css/templatemo-style.css">

  <script>
    var renderPage = true;
    if(navigator.userAgent.indexOf('MSIE')!==-1
      || navigator.appVersion.indexOf('Trident/') > 0){
        /* Microsoft Internet Explorer detected in. */
        alert("Please view this in a modern browser such as Chrome or Microsoft Edge.");
        renderPage = false;
    }
  </script>
</head>
<body>
    <?php 
if(!empty($rows)){
    ?>
  <!-- Loader -->
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>
  
  <div class="container">
  <!-- 1st section -->
  <?php 
    $section_name = "home";
    $sql_home = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
    $result_home = $con->query($sql_home);
    $rows_home = $result_home->fetch_assoc();
    if(!empty($rows_home)){ ?>
    
    <section class="row tm-section tm-mb-30">
         <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
          <div class="tm-flex-center pl-5 pr-5 pt-5 pb-5">
            <div class="tm-md-flex-center">
             <h2 class="mb-4 tm-text-color-primary"><?php echo $rows_home['title'];?></h2>
             <p><?php echo $rows_home['short_desc'];?></p>
             <a href="<?php echo $rows_home['add_link'];?>" class="btn btn-primary float-lg-right tm-md-align-center"><?php echo $rows_home['button_url_name'];?></a>
           </div>
         </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 text-xl-right text-md-center text-center mt-5 mt-lg-0 pr-lg-0">
            <img src="../images/thema_gallery/<?php echo $rows_home['image']?>" alt="><?php echo $rows_home['title'];?>" class="img-fluid">
        </div>
   </section>
   
   <?php }else{}?>
   
  <!-- Service Sections Start -->
<?php 
    $section_name = "service";
    $sql_service = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
    $result_svc = $con->query($sql_service);
    $count = 0; 
    if(!empty($rows_home)){
        while ($rows_services = $result_svc->fetch_assoc()) {
            $count++;
            $isImageLeft = $count % 2 == 1; 
            ?>

    <section class="row tm-section tm-mb-30 align-items-center">
        <?php if ($isImageLeft) { ?>
            <!-- Image Left -->
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 p-0 text-center">
                <img src="../images/thema_gallery/<?php echo $rows_services['image']; ?>" alt="<?php echo $rows_services['title']; ?>" class="img-fluid">
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="tm-flex-center p-5">
                    <div class="tm-flex-center tm-flex-col">
                        <h2 class="tm-align-left"><?php echo $rows_services['title']; ?></h2>
                        <p><?php echo $rows_services['short_desc']; ?></p>
                        <a href="<?php echo $rows_services['add_link']; ?>" class="btn btn-primary"><?php echo $rows_services['button_url_name']; ?></a>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <!-- Image Right -->
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="tm-flex-center p-5">
                    <div class="tm-flex-center tm-flex-col">
                        <h2 class="tm-align-left"><?php echo $rows_services['title']; ?></h2>
                        <p><?php echo $rows_services['short_desc']; ?></p>
                        <a href="<?php echo $rows_services['add_link']; ?>" class="btn btn-primary"><?php echo $rows_services['button_url_name']; ?></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 p-0 text-center">
                <img src="../images/thema_gallery/<?php echo $rows_services['image']; ?>" 
                     alt="<?php echo $rows_services['title']; ?>" 
                     class="img-fluid">
            </div>
        <?php } ?>
    </section>

<?php 
        } 
    } else{}
?>
<!-- Service Sections End -->


<!-- 4th Section -->


<!-- Footer -->
<div class="row">
  <div class="col-lg-12">
    <p class="text-center small tm-copyright-text mb-0">Copyright &copy; <span class="tm-current-year"><?php echo $endYear = date('Y');?></span> <?php echo $rows['website_name'];?> | Designed by <a href="<?php echo $current_url;?>" class="tm-text-color-gray" target="_parent">Themes Dynimically</a></p>
  </div>
</div>
</div>
 <?php
}else{
    ?>
       <style>
           body
        	{
        		background-image: url('coming_soon.jpg');
                }
        	h1
        	{
        		text-align: center;
        		padding-top: 5%;
        		color: white;
        	}
        	h2
        	{
        		text-align: center;
        		padding-top: 1%;
        		color: white;
        	}
       </style>
      <h1>Coming Soon!</h1><h2>Your next real estate friend</h2> <br>
    <?php
}
?>

<!-- load JS -->
<script src="thema_2m/js/jquery-3.2.1.slim.min.js"></script>
<script>

  /* DOM is ready
  ------------------------------------------------*/
  $(function(){
    if(renderPage) {
      $('body').addClass('loaded');
    }
    $('.tm-current-year').text(new Date().getFullYear());
  });

</script>
</body>
</html>