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

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="#" />
    <meta name="description" content="<?php echo !empty($rows['website_name']) ? $rows['website_name']: 'Coming Soon!';?>">
    <meta property="og:title" content="<?php echo !empty($rows['website_name']) ? $rows['website_name']: 'Coming Soon!';?>">
    <meta property="og:site_name" content="<?php echo !empty($rows['website_name']) ? $rows['website_name']: 'Coming Soon!';?>">
    <meta property="og:type" content="website">
    <meta property="og:description" content="<?php echo !empty($rows['website_name']) ? $rows['website_name']: 'Coming Soon!';?>">
    <meta property="og:image" content="">
     <meta property="og:url" content="<?php echo !empty($rows['image']) ? '../images/thema_gallery/' . $rows['image'] : 'Coming Soon!'; ?>">
    <meta property="og:image:alt" content="<?php echo !empty($rows['website_name']) ? $rows['website_name']: 'Coming Soon!';?>">
    <link rel="canonical" href="#" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="thema_3m/assets/css/bootstrap.min.css">
    <!-- Custom styles -->
    <link rel="stylesheet" href="thema_3m/assets/css/style.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather:300,400,700|Roboto:300,400,600" rel="stylesheet">
    <!-- Ionic icons -->
    <!-- <link href="assets/css/ionicons.min.css" rel="stylesheet"> -->
    <link href="https://unpkg.com/ionicons@4.2.0/dist/css/ionicons.min.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="shortcut icon" href="#" />           
    <title><?php echo !empty($rows['website_name']) ? $rows['website_name']: 'Coming Soon!';?></title>
</head>

<body>
    <?php 
if(!empty($rows)){
    ?>
    <nav class="navbar fixed-top navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <!--<img src="../images/thema_gallery/</?php echo $rows['image']?>" class="header-logo">&nbsp;-->
                <?php echo $rows['website_name'];?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="icon ion-md-menu"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#hero">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#portfolio">Portfolio</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="hero">
        <div class="container">
            
             <!--home Section start-->
             <?php 
                    $section_name = "home";
                    $sql_home = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
                    $result = $con->query($sql_home);
                    $rows_home = $result->fetch_assoc();
                    if(!empty($rows_home)){
                   ?>
                   
                <div class="heading-content">
                    <h1><?php echo $rows_home['title'];?></h1>
                </div>
                <?php }else{}?>
                 <!--home Section end-->
                 
                 <!--about Section start-->
             <?php 
                    $section_name = "about";
                    $sql_about = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
                    $result = $con->query($sql_about);
                    $rows_about = $result->fetch_assoc();
                     if(!empty($rows_about)){
                     ?>
                     
                    <div class="hero-container margintop-lg">
                        <div class="hero-details hidden-mobile">
                            <span>- Featured Project</span>
                            <a href="#">
                                <h3><?php echo $rows_about['title'];?></h3>
                            </a>
                            <p><?php echo $rows_about['short_desc'];?> </p>
                        </div>
                        <div class="hero-button hidden-mobile">
                            <a href="" class="portfolio-link">See case study <i class="icon ion-md-add-circle"></i></a>
                        </div>
                        <img src="../images/thema_gallery/<?php echo $rows_about['image']?>" alt="<?php echo $rows_about['title'];?>" class="img-fluid" style="width:100%">
                        <div class="mobile-only margintop-sm">
                            <span>- Featured Project</span>
                            <h3><?php echo $rows_about['title'];?></h3>
                            <p><?php echo $rows_about['short_desc'];?></p>
                        </div>
                        <a href="<?php echo $rows_about['add_link'];?>" class="primary-btn mobile-only">See case study <i class="icon ion-md-add-circle"></i></a>
                    </div>
                    
                     <?php }else{}?>
                    <!--about Section end-->
            
        </div>
    </section>
    
    <!--features Section end-->
         <?php 
            $section_name = "features";
            $sql_features = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
            $result_fts = $con->query($sql_features);
            if(!empty($result_fts)){ ?>
            
    <section id="portfolio">
        <div class="container">
            <div class="heading-content">
                <h2>
                   <?php echo $rows['website_name'];?> <?php echo $rows_home['title'];?></h2>
                <p class="margintop-sm"><?php echo $rows_about['short_desc'];?></p>
            </div>
            <div class="row margintop-lg">
                <?php 
                    while($rows_features = $result_fts->fetch_assoc()){
                    ?>
                <div class="col-md-6">
                    <div class="portfolio-container">
                        <div class="portfolio-details">
                            <span>- Featured Project</span>
                            <a href="#">
                                <h3><?php echo $rows_features['title'];?></h3>
                            </a>
                        </div>
                        <div class="portfolio-button">
                            <a href="<?php echo $rows_features['add_link'];?>" class="portfolio-link">See case study <i class="icon ion-md-add-circle"></i></a>
                            <p><?php echo substr($rows_features['short_desc'], 0, 125); ?></p>
                        </div>
                        <img src="../images/thema_gallery/<?php echo $rows_features['image']?>" class="img-fluid"
                            alt="<?php echo $rows_features['title'];?>" style="width:100%;height:400px">
                    </div>
                </div>
                 <?php 
                      }
                    ?>
            </div>
        </div>
    </section>
       <?php }else{}?>
        <!--features Section end-->

    <section id="footer">
        <div class="container">
            <h6><?php echo $rows['website_name'];?> Let's work together.</h6>
            <small><?php echo $rows['website_name'];?> 2025 © Created by <a href="#">Themes Dynimically </a></small>
        </div>
    </section>
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
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="thema_3m/assets/js/jquery-3.3.1.slim.min.js"></script>
    <script src="thema_3m/assets/js/popper.min.js"></script>
    <script src="thema_3m/assets/js/bootstrap.min.js"></script>
</body>

</html>