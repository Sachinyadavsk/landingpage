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
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title><?php echo !empty($rows['website_name']) ? $rows['website_name']: 'Coming Soon!';?></title>
      <meta name="keywords" content="<?php echo !empty($rows['website_name']) ? $rows['website_name']: 'Coming Soon!';?>">
      <meta name="description" content="<?php echo !empty($rows['website_name']) ? $rows['website_name']: 'Coming Soon!';?>">
      <meta name="author" content="<?php echo !empty($rows['website_name']) ? $rows['website_name']: 'Coming Soon!';?>">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="theme_1m/css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="theme_1m/css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="theme_1m/css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="theme_1m/images/fevicon.html" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="theme_1m/css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="theme_1m/css/font-awesome.css">
      <link rel="stylesheet" href="theme_1m/css/jquery.fancybox.min.css" media="screen">
   </head>
   <!-- body -->
   <body>
       <?php 
if(!empty($rows)){
    ?>
    <div class="main-layout">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="theme_1m/images/loading.gif" alt="#" /></div>
      </div>
      <!-- end loader -->
      <!-- header -->
      <header>
         <!-- header inner -->
         <div  class="head_top" id="home">
            <div class="header">
               <div class="container-fluid">
                  <div class="row">
                     <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                        <div class="full">
                           <div class="center-desk">
                              <div class="logo">
                                 <a href="#home"><img src="<?php echo !empty($rows['image']) ? '../images/thema_gallery/' . $rows['image'] : 'Coming Soon!'; ?>" alt="<?php echo !empty($rows['website_name']) ? $rows['website_name']: 'Coming Soon!';?>" /></a>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                        <nav class="navigation navbar navbar-expand-md navbar-dark ">
                           <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                           <span class="navbar-toggler-icon"></span>
                           </button>
                           <div class="collapse navbar-collapse" id="navbarsExample04">
                              <ul class="navbar-nav mr-auto">
                                 <li class="nav-item">
                                    <a class="nav-link" href="#home"> Home  </a>
                                 </li>
                                 <li class="nav-item">
                                    <a class="nav-link" href="#about">About</a>
                                 </li>
                                 <li class="nav-item">
                                    <a class="nav-link" href="#service">Service</a>
                                 </li>
                              </ul>
                           </div>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
            <!-- end header inner -->
            <!-- end header -->
            <?php 
                    $section_name = "home";
                    $sql_home = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
                    $result = $con->query($sql_home);
                    $rows_home = $result->fetch_assoc();
                    if(!empty($rows_home)){
                   ?>
            <!-- banner -->
            <section class="banner_main" style="margin-top:-140px;">
               <div class="container-fluid">
                  <div class="row d_flex">
                     <div class="col-md-6">
                        <div class="text-bg">
                           <h1><?php echo $rows_home['title'];?></h1>
                           <h6><?php echo $rows_home['short_desc'];?></h6>
                           <a href="<?php echo $rows_home['add_link'];?>"><?php echo $rows_home['button_url_name'];?></a>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="text-img">
                           <figure><img src="../images/thema_gallery/<?php echo $rows_home['image']?>" alt="<?php echo $rows_home['title'];?>"/></figure>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            
              <?php }else{}?>
            
         </div>
      </header>
      <!-- end banner -->
      
      <!-- business -->
        <?php 
            $section_name = "about";
            $sql_about = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
            $result = $con->query($sql_about);
            $rows_about = $result->fetch_assoc();
             if(!empty($rows_about)){
             ?>
      <div class="business" id="about">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <span>Increase your client for</span>
                     <h2><?php echo $rows_about['title'];?></h2>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-10 offset-md-1">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="business_box ">
                           <figure><img src="../images/thema_gallery/<?php echo $rows_about['image']?>" style="width:100%;height:520px" alt="<?php echo $rows_about['title'];?>"/></figure>
                           <p><?php echo $rows_about['short_desc'];?></p>
                           <a class="read_more" href="<?php echo $rows_about['add_link'];?>"><?php echo $rows_about['button_url_name'];?></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
       <?php }else{}?>
      <!-- end business -->
      
      <!-- Projects -->
      <?php 
            $section_name = "service";
            $sql_service = "SELECT * FROM Theme_feature_layout WHERE thema_id='$thema_id' AND pro_th_id='$pro_th_id' AND section_name='$section_name' AND status='1'";
            $result_srv = $con->query($sql_service);
            if(!empty($result_srv)){ ?>
      <div class="projects" id="service">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <span><?php echo $rows['website_name'];?> Service</span>
                     <hr>
                  </div>
               </div>
            </div>
             <?php 
                    while($rows_service = $result_srv->fetch_assoc()){
                    ?>
                     <h2 class="text-center" style="font-size: 40px;margin-bottom: 20px;"><?php echo $rows_service['title'];?></h2>
            <div class="row">
               <div class="col-md-10 offset-md-1">
                  <div class="row">
                     <div class="col-md-6 offset-md-3">
                        <div class="projects_box ">
                           <figure><img src="../images/thema_gallery/<?php echo $rows_service['image']?>" style="width:100%;height:420px" alt="#"/></figure>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="projects_box ">
                           <p><?php echo $rows_service['short_desc'];?></p>
                           <a class="read_more" href="<?php echo $rows_service['add_link'];?>"><?php echo $rows_service['button_url_name'];?></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php 
                      }
                    ?>
         </div>
      </div>
      <?php }else{}?>
      <!-- end projects -->
      
      <!--  footer -->
      <footer>
         <div class="footer">
            <div class="copyright">
               <div class="container">
                  <div class="row">
                     <div class="col-md-12">
                        <p>Copyright <?php echo $endYear = date('Y');?> All Right Reserved By <a href="<?php echo $current_url;?>"> <?php echo $rows['website_name'];?></a></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!-- end footer -->
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
      
      <!-- Javascript files-->
      <script src="theme_1m/js/jquery.min.js"></script>
      <script src="theme_1m/js/popper.min.js"></script>
      <script src="theme_1m/js/bootstrap.bundle.min.js"></script>
      <script src="theme_1m/js/jquery-3.0.0.min.js"></script>
      <script src="theme_1m/js/plugin.js"></script>
      <!-- sidebar -->
      <script src="theme_1m/js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="theme_1m/js/custom.js"></script>
      <script src="theme_1m/js/jquery.fancybox.min.js"></script>
   </body>
</html>

