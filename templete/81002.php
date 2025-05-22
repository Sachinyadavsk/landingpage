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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php echo !empty($rows['website_name']) ? $rows['website_name']: 'Coming Soon!';?>
    </title>
    <link rel="stylesheet" href="assets/vendors/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php 
if(!empty($rows)){
    ?>
    <header class="foi-header landing-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light foi-navbar">
                <a class="navbar-brand" href="#Home">
                    <img src="../images/thema_gallery/<?php echo $rows['image']?>"
                        alt="<?php echo $rows['website_name'];?>" style="width:80px">
                </a>
                <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse"
                    data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item active">
                            <a class="nav-link" href="#Home">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#About">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#Features">Features</a>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <!--home page section start-->
            <?php 
                    $section_name = "home";
                    $sql_home = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
                    $result = $con->query($sql_home);
                    $rows_home = $result->fetch_assoc();
                    if(!empty($rows_home)){
                    ?>
                    <div class="header-content" id="Home">
                        <div class="row">
                            <div class="col-md-6">
                                <h1>
                                    <?php echo $rows_home['title'];?>
                                </h1>
                                <p class="text-dark">
                                    <?php echo $rows_home['short_desc'];?>
                                </p>
                                <button class="btn btn-primary mb-4"><a href="<?php echo $rows_home['add_link'];?>" class="text-white"><?php echo $rows_home['button_url_name'];?></a></button>
        
                            </div>
                            <div class="col-md-6">
                                <img src="../images/thema_gallery/<?php echo $rows_home['image']?>"
                                    alt="<?php echo $rows_home['title'];?>" width="388px" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <?php 
                    }else{
                    }
                    ?>
             <!--home page section end-->
        </div>
    </header>
    
    <!--features section start-->
    <?php
    $section_name = "features";
    $sql_features = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
    $result_fs = $con->query($sql_features);
     if(!empty($result_fs)){
    ?>
    <section class="py-1 mb-1">
        <div class="container">
            <h2 class="section-title">Application Features</h2>
            <div class="row">

                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="row">
                        <?php while($rows_features = $result_fs->fetch_assoc()){?>
                        <div class="col-lg-6">
                            <h5>
                                <?php echo $rows_features['title'];?>
                            </h5>
                            <p class="text-dark">
                                <?php echo substr($rows_features['short_desc'], 0, 200); ?>
                            </p>
                            <p class="mb-5"><a href="<?php echo $rows_features['add_link'];?>"
                                    class="text-white mb-5 btn btn-primary"><?php echo $rows_features['button_url_name'];?></a></p>
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-lg-4">
                    <h6 class="text-gray font-os font-weight-semibold">Trusted by the world's best</h6>
                    <div id="landingClientCarousel" class="carousel slide landing-client-carousel" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active">
                                <div class="d-flex flex-wrap justify-content-center">
                                    <?php 
                                        $section_name = "features";
                                        $sql_features = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
                                        $result = $con->query($sql_features);
                                        while($rows_features = $result->fetch_assoc()){
                                        ?>
                                    <div class="clients-logo">
                                        <img src="../images/thema_gallery/<?php echo $rows_features['image']?>"
                                            alt="<?php echo $rows_features['title'];?>" class="img-fluid">
                                    </div>
                                    <?php 
                                          }
                                    ?>

                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="d-flex flex-wrap justify-content-center">
                                    <?php 
                                        $section_name = "features";
                                        $sql_features = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
                                        $result = $con->query($sql_features);
                                        while($rows_features = $result->fetch_assoc()){
                                        ?>
                                    <div class="clients-logo">
                                        <img src="../images/thema_gallery/<?php echo $rows_features['image']?>"
                                            alt="<?php echo $rows_features['title'];?>" class="img-fluid">
                                    </div>
                                    <?php 
                                          }
                                    ?>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="d-flex flex-wrap justify-content-center">
                                    <?php 
                                        $section_name = "features";
                                        $sql_features = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
                                        $result = $con->query($sql_features);
                                        while($rows_features = $result->fetch_assoc()){
                                        ?>
                                    <div class="clients-logo">
                                        <img src="../images/thema_gallery/<?php echo $rows_features['image']?>"
                                            alt="<?php echo $rows_features['title'];?>" class="img-fluid">
                                    </div>
                                    <?php 
                                          }
                                    ?>

                                </div>
                            </div>
                        </div>
                        <ol class="carousel-indicators">
                            <li data-target="#landingClientCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#landingClientCarousel" data-slide-to="1"></li>
                            <li data-target="#landingClientCarousel" data-slide-to="2"></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php }else{}?>
    <!--features section end-->
    
    <!--abouts section start-->
    <?php 
        $section_name = "about";
        $sql_about = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
        $result = $con->query($sql_about);
        $rows_about = $result->fetch_assoc();
        if(!empty($rows_about)){
        ?>
    <section class="py-5 mb-5" id="About">
        <div class="container">
            <div class="row">

                <div class="col-md-6 mb-5 mb-md-0">
                    <img src="../images/thema_gallery/<?php echo $rows_about['image']?>"
                        alt="<?php echo $rows_about['title'];?>" class="img-fluid" width="492px">
                </div>
                <div class="col-md-6">
                    <h2 class="section-title">
                        <?php echo $rows_about['title'];?>
                    </h2>
                    <p class="mb-5">
                        <?php echo substr($rows_about['short_desc'], 0, 475); ?>
                    </p>
                    <p><a href="<?php echo $rows_about['add_link'];?>" class="btn btn-primary"><?php echo $rows_about['button_url_name'];?></a></p>
                </div>
            </div>
        </div>
    </section>
     <?php }else{}?>
    <!--abouts section end-->
    
    <!--gallery section start-->
    <?php 
    $section_name = "gallery";
    $sql_gallery = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
    $result_gy = $con->query($sql_gallery);
    if(!empty($result_gy)){
    ?>
    <section class="py-1 mb-1" id="Features">
        <div class="container">
            <h2>Choose the plan that’s right for yor business</h2>
            <p class="text-muted mb-5">Thank you for your very professional and prompt response. I wished I had found
                you before </p>
            <div class="row">
                <?php 
                    while($rows_gallery = $result_gy->fetch_assoc()){
                    ?>
                <div class="col-lg-4 mb-4">
                    <div class="card pricing-card border-warning">
                        <div class="card-body">
                            <img src="../images/thema_gallery/<?php echo $rows_gallery['image']?>"
                                alt="<?php echo $rows_gallery['title'];?>" class="img-fluid"style="height:width:100%;height:200px">
                                <h5><?php echo $rows_gallery['title'];?></h5>
                                <p><?php echo substr($rows_gallery['short_desc'], 0, 200); ?></p>
                                <p><a href="<?php echo $rows_gallery['add_link'];?>" class="btn btn-primary"><?php echo $rows_gallery['button_url_name'];?></a></p>
                        </div>
                    </div>
                </div>
                <?php 
                      }
                ?>
            </div>
        </div>
    </section>
     <?php }else{}?>
     <!--gallery section end-->
     
     <!--service section start-->
    <?php 
     $section_name = "service";
     $sql_service = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
     $result_seri = $con->query($sql_service);
     if(!empty($result_seri)){
    ?>
    <section class="foi-page-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-5 mb-md-0">
                    <img src="../images/thema_gallery/<?php echo $rows['image']?>"
                        alt="<?php echo $rows['website_name'];?>" alt="faq" class="img-fluid" width="424px">
                </div>
                <div class="col-md-6">
                    <h2 class="feature-faq-title">Awesome Interface</h2>

                    <?php 
                    while($rows_service = $result_seri->fetch_assoc()){
                    ?>
                    <div class="card feature-faq-card">
                        <div class="card-header bg-white" id="featureFaqOneTitle<?php echo $rows_service['id'];?>">
                            <a href="#featureFaqOneCollapse<?php echo $rows_service['id'];?>"
                                class="d-flex align-items-center" data-toggle="collapse">
                                <h5 class="mb-0">
                                    <?php echo $rows_service['title'];?>
                                </h5> <i class="far fa-plus-square ml-auto"></i>
                            </a>
                        </div>
                        <div id="featureFaqOneCollapse<?php echo $rows_service['id'];?>" class="collapse"
                            aria-labelledby="featureFaqOneTitle<?php echo $rows_about['id'];?>">
                            <div class="card-body">
                                <p class="mb-0 text-gray">
                                    <?php echo $rows_service['short_desc'];?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php 
                      }
                   ?>

                </div>
            </div>
        </div>
    </section>
    <?php }else{}?>
    <!--service section start-->
    
    <?php
}else{
    ?>
    <style>
        body {
            background-image: url('coming_soon.jpg');
        }

        h1 {
            text-align: center;
            padding-top: 5%;
            color: white;
        }

        h2 {
            text-align: center;
            padding-top: 1%;
            color: white;
        }
    </style>
    <h1>Coming Soon!</h1>
    <h2>Your next real estate friend</h2> <br>
    <?php
}
?>
    <script src="assets/vendors/jquery/jquery.min.js"></script>
    <script src="assets/vendors/popper.js/popper.min.js"></script>
    <script src="assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>