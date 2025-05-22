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
<html lang="en-US" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo !empty($rows['website_name']) ? $rows['website_name']: 'Coming Soon!';?></title>
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo !empty($rows['image']) ? '../images/thema_gallery/' . $rows['image'] : 'Coming Soon!'; ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo !empty($rows['image']) ? '../images/thema_gallery/' . $rows['image'] : 'Coming Soon!'; ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo !empty($rows['image']) ? '../images/thema_gallery/' . $rows['image'] : 'Coming Soon!'; ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo !empty($rows['image']) ? '../images/thema_gallery/' . $rows['image'] : 'Coming Soon!'; ?>">
    <meta name="msapplication-TileImage" content="<?php echo !empty($rows['image']) ? '../images/thema_gallery/' . $rows['image'] : 'Coming Soon!'; ?>">
    <meta name="theme-color" content="#ffffff">
    <link href="assets/css/theme.min.css" rel="stylesheet" />
  </head>

  <body>
      <?php 
if(!empty($rows)){
    ?>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3 d-block" data-navbar-on-scroll="data-navbar-on-scroll">
        <div class="container"><a class="navbar-brand" href="#home"><img src="../images/thema_gallery/<?php echo $rows['image']?>" width="118" alt="<?php echo $rows['website_name'];?>" /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"> </span></button>
          <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto pt-2 pt-lg-0 font-base">
              <li class="nav-item px-2"><a class="nav-link" aria-current="page" href="#about">About Us</a></li>
               <li class="nav-item px-2"><a class="nav-link" href="#services">Service</a></li>
              <li class="nav-item px-2"><a class="nav-link" href="#features">Feature</a></li>
              <li class="nav-item px-2"><a class="nav-link" href="#testimonials">Testimonial</a></li>
              <li class="nav-item px-2"><a class="nav-link" href="#blog">Blog</a></li>
            </ul>
          </div>
        </div>
      </nav>
      
         <!--home Section start-->
         <?php 
                $section_name = "home";
                $sql_home = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
                $result = $con->query($sql_home);
                $rows_home = $result->fetch_assoc();
                if(!empty($rows_home)){
               ?>
      <section class="py-xxl-10 pb-0" id="home" style="padding-top: 7.5rem;">
        <div class="bg-holder bg-size" style="background-image:url(assets/img/gallery/hero-bg.png);background-position:top center;background-size:cover;"></div>
        <!--/.bg-holder-->
        <div class="container">
          <div class="row min-vh-xl-100 min-vh-xxl-25">
            <div class="col-md-5 col-xl-6 col-xxl-7 order-0 order-md-1 text-end"><img class="pt-7 pt-md-0 w-100" src="../images/thema_gallery/<?php echo $rows_home['image']?>" alt="hero-header" /></div>
            <div class="col-md-75 col-xl-6 col-xxl-5 text-md-start text-center py-6">
              <h1 class="fw-light font-base fs-6 fs-xxl-7"><?php echo $rows_home['title'];?></h1>
              <p class="fs-1 mb-5"><?php echo $rows_home['short_desc'];?> </p><a class="btn btn-lg btn-primary rounded-pill" href="<?php echo $rows_home['add_link'];?>" role="button"><?php echo $rows_home['button_url_name'];?></a>
            </div>
          </div>
        </div>
      </section>
      
       <?php }else{}?>
         <!--home Section end-->

      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="py-0" id="services">
        <div class="container">
          <div class="row">
            <div class="col-12 py-3">
              <div class="bg-holder bg-size" style="background-image:url(assets/img/gallery/bg-departments.png);background-position:top center;background-size:contain;"></div>
              <!--/.bg-holder-->
              <h1 class="text-center">OUR SERVICE</h1>
            </div>
          </div>
        </div><!-- end of .container-->
      </section><!-- <section> close ============================-->
      <!-- ============================================-->


        <!--service Section end-->
          <?php 
            $section_name = "service";
            $sql_service = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
            $result_ser = $con->query($sql_service);
            if(!empty($result_ser)){ ?>
      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="py-0">
        <div class="container">
          <div class="row py-5 align-items-center justify-content-center justify-content-lg-evenly">
              <?php 
                    while($rows_service = $result_ser->fetch_assoc()){
                    ?>
            <div class="col-auto col-md-3">
              <div class="d-flex flex-column align-items-center">
                <div class="icon-box text-center"><a class="text-decoration-none" href="<?php echo $rows_service['add_link'];?>">
                    <img class="mb-3 deparment-icon" style="height:100px;width:100px" src="../images/thema_gallery/<?php echo $rows_service['image']?>" alt="<?php echo $rows_service['title'];?>" />
                    <img class="mb-3 deparment-icon-hover" style="height:100px;width:100px" src="../images/thema_gallery/<?php echo $rows_service['image']?>" alt="<?php echo $rows_service['title'];?>" />
                     <h3><?php echo $rows_service['title'];?></h3>
                    <p class="fs-1 fs-xxl-2 text-center"><?php echo substr($rows_service['short_desc'], 0, 125); ?></p>
                    <p><a href="<?php echo $rows_service['add_link'];?>" class="btn btn-lg btn-primary rounded-pill"><?php echo $rows_service['button_url_name'];?></a></p>
                  </a></div>
              </div>
            </div>
            <?php 
                      }
                    ?>
          </div>
        </div><!-- end of .container-->
      </section>
      <!-- <section> close ============================-->
      
       <?php }else{}?>
       
          <!--about Section start-->
             <?php 
                    $section_name = "about";
                    $sql_about = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
                    $result = $con->query($sql_about);
                    $rows_about = $result->fetch_assoc();
                     if(!empty($rows_about)){
                     ?>
      
              <!-- <section> begin ============================-->
              <section class="pb-0" id="about">
                <div class="container">
                  <div class="row">
                    <div class="col-12 py-3">
                      <div class="bg-holder bg-size" style="background-image:url(assets/img/gallery/about-us.png);background-position:top center;background-size:contain;"></div>
                      <!--/.bg-holder-->
                      <h1 class="text-center">ABOUT US</h1>
                    </div>
                  </div>
                </div><!-- end of .container-->
              </section><!-- <section> close ============================-->
              <!-- ============================================-->
      
      

      <section class="py-5">
        <div class="bg-holder bg-size" style="background-image:url(assets/img/gallery/about-bg.png);background-position:top center;background-size:contain;"></div>
        <!--/.bg-holder-->
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-6 order-lg-1 mb-5 mb-lg-0"><img class="fit-cover rounded-circle w-100" src="../images/thema_gallery/<?php echo $rows_about['image']?>" alt="..." /></div>
            <div class="col-md-6 text-center text-md-start">
              <h2 class="fw-bold mb-4"><?php echo $rows_about['title'];?></h2>
              <p><?php echo $rows_about['short_desc'];?></p>
              <div class="py-3"><a href="<?php echo $rows_about['add_link'];?>" class="btn btn-lg btn-outline-primary rounded-pill"><?php echo $rows_about['button_url_name'];?></a> </div>
            </div>
          </div>
        </div>
      </section>
      
      <?php }else{}?>


      <!--features Section end-->
         <?php 
            $section_name = "features";
            $sql_features = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
            $result_fts = $con->query($sql_features);
            if(!empty($result_fts)){ ?>
      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="pb-0" id="features">
        <div class="container">
          <div class="row">
            <div class="col-12 py-3">
              <div class="bg-holder bg-size" style="background-image:url(assets/img/gallery/doctors-us.png);background-position:top center;background-size:contain;"></div>
              <!--/.bg-holder-->
              <h1 class="text-center">OUR FEATURES</h1>
            </div>
          </div>
        </div><!-- end of .container-->
      </section><!-- <section> close ============================-->
      <!-- ============================================-->

      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="py-0">
        <div class="container">
          <div class="row py-5 align-items-center justify-content-center justify-content-lg-evenly">
                <?php 
                    while($rows_features = $result_fts->fetch_assoc()){
                    ?>
            <div class="col-auto col-md-4">
              <div class="d-flex flex-column align-items-center">
                <div class="icon-box text-center"><a class="text-decoration-none" href="<?php echo $rows_features['add_link'];?>">
                    <img class="mb-3 deparment-icon" style="height:100px;width:100px" src="../images/thema_gallery/<?php echo $rows_features['image']?>" alt="<?php echo $rows_features['title'];?>" />
                    <img class="mb-3 deparment-icon-hover" style="height:100px;width:100px" src="../images/thema_gallery/<?php echo $rows_features['image']?>" alt="<?php echo $rows_features['title'];?>" />
                     <h3><?php echo $rows_features['title'];?></h3>
                    <p class="fs-1 fs-xxl-2 text-center"><?php echo substr($rows_features['short_desc'], 0, 125); ?></p>
                    <p><a href="<?php echo $rows_features['add_link'];?>" class="color: #639ebf !important;"><?php echo $rows_features['button_url_name'];?></a></p>
                  </a></div>
              </div>
            </div>
            <?php 
                      }
                    ?>
          </div>
        </div><!-- end of .container-->
      </section>
       <?php }else{}?>
       
       
     <!-- Testimonials Section -->
<?php 
$section_name = "testimonials";
$sql_testimonials = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
$result_tsm = $con->query($sql_testimonials);

if($result_tsm->num_rows > 0) { ?>
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 py-3">
                    <div class="bg-holder bg-size" style="background-image:url(assets/img/gallery/people.png);background-position:top center;background-size:contain;"></div>
                    <h1 class="text-center">PEOPLE WHO LOVE US</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="py-8" id="testimonials">
        <div class="bg-holder bg-size" style="background-image:url(assets/img/gallery/people-bg-1.png);background-position:center;background-size:cover;"></div>
        <div class="container">
            <div class="row align-items-center offset-sm-1">
                <div class="carousel slide" id="carouselPeople" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php 
                        $firstItem = true; // Flag to set first item as active
                        while ($rows_testimonials = $result_tsm->fetch_assoc()) { ?>
                            <div class="carousel-item <?php echo ($firstItem ? 'active' : ''); ?>" data-bs-interval="5000">
                                <div class="row h-100">
                                    <div class="col-sm-3 text-center">
                                        <img src="../images/thema_gallery/<?php echo $rows_testimonials['image']; ?>" class="rounded-circle" alt="<?php echo $rows_testimonials['title']; ?>" style="height: 172px;width: 100%;">
                                    </div>
                                    <div class="col-sm-9 text-center text-sm-start pt-3 pt-sm-0">
                                        <h2><?php echo $rows_testimonials['title']; ?></h2>
                                        <div class="my-2">
                                            <i class="fas fa-star me-2"></i>
                                            <i class="fas fa-star me-2"></i>
                                            <i class="fas fa-star me-2"></i>
                                            <i class="fas fa-star-half-alt me-2"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <p class="fw-normal mb-0"><?php echo $rows_testimonials['short_desc']; ?></p>
                                        <p><a class="btn btn-lg btn-outline-primary rounded-pill" href="<?php echo $rows_testimonials['add_link']; ?>"><?php echo $rows_testimonials['button_url_name']; ?></a></p>
                                    </div>
                                </div>
                            </div>
                        <?php 
                        $firstItem = false; // Disable active class for next items
                        } 
                        ?>
                    </div>
                    
                    <!-- Carousel Indicators -->
                    <div class="row">
                        <div class="position-relative z-index-2 mt-5">
                            <ol class="carousel-indicators">
                                <?php 
                                for ($i = 0; $i < $result_tsm->num_rows; $i++) { ?>
                                    <li data-bs-target="#carouselPeople" data-bs-slide-to="<?php echo $i; ?>" <?php echo ($i == 0 ? 'class="active"' : ''); ?>></li>
                                <?php } ?>
                            </ol>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
<?php } ?>

<!--Blog Section end-->
         <?php 
            $section_name = "blog";
            $sql_blog = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
            $result_bg = $con->query($sql_blog);
            if(!empty($result_bg)){ ?>
      <!-- ============================================-->
      <!-- <section> begin ============================-->
      <section class="py-5">
        <div class="container">
          <div class="row">
            <div class="col-12 py-3">
              <div class="bg-holder bg-size" style="background-image:url(assets/img/gallery/blog-post.png);background-position:top center;background-size:contain;"></div>
              <!--/.bg-holder-->
              <h1 class="text-center">RECENT BLOGPOSTS</h1>
            </div>
          </div>
        </div><!-- end of .container-->
      </section><!-- <section> close ============================-->
      <!-- ============================================-->

      <section id="blog">
        <div class="bg-holder bg-size" style="background-image:url(assets/img/gallery/dot-bg.png);background-position:top left;background-size:auto;"></div>
        <!--/.bg-holder-->
        <div class="container">
          <div class="row">
              <?php 
                    while($rows_blog = $result_bg->fetch_assoc()){
                    ?>
            <div class="col-sm-6 col-lg-3 mb-4">
              <div class="card h-100 shadow card-span rounded-3"><img class="card-img-top rounded-top-3" src="../images/thema_gallery/<?php echo $rows_blog['image']?>" alt="<?php echo $rows_blog['title'];?>" />
                <div class="card-body">
                  <h5 class="font-base fs-lg-0 fs-xl-1 my-3"><?php echo $rows_blog['title'];?></h5>
                   <p><?php echo substr($rows_blog['short_desc'], 0, 125); ?></p>
                  <a class="stretched-link" href="<?php echo $rows_blog['add_link'];?>"><?php echo $rows_blog['button_url_name'];?></a>
                </div>
              </div>
            </div>
             <?php } ?>
          </div>
        </div>
      </section>
       <?php }else{}?>
     
    </main><!-- ===============================================-->
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
    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="vendors/@popperjs/popper.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.min.js"></script>
    <script src="vendors/is/is.min.js"></script>
    <script src="vendors/fontawesome/all.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&amp;family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100&amp;display=swap" rel="stylesheet">
  </body>

</html>