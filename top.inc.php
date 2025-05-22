<?php
require('confige.php');
require('functions.inc.php');
if(isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN']!=''){

}else{
	header('location:login.php');
	die();
}
?>
<!doctype html>
<html class="no-js" lang="">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Dashboard Page Games</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="assets/css/normalize.css">
   <link rel="stylesheet" href="assets/css/bootstrap.min.css">
   <link rel="stylesheet" href="assets/css/font-awesome.min.css">
   <link rel="stylesheet" href="assets/css/themify-icons.css">
   <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">
   <link rel="stylesheet" href="assets/css/flag-icon.min.css">
   <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
   <link rel="stylesheet" href="assets/css/style.css">
   <link rel="stylesheet" href="assets/css/thema.css">
   <link rel="stylesheet" href="assets/css/dataTables.css">
   <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
   <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
</head>

<body>
   <aside id="left-panel" class="left-panel">
      <nav class="navbar navbar-expand-sm navbar-default">
         <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
               <li class="menu-title">Menu</li>
                   <!--Create the thema name section layout-->
              
               	<?php
				    if($_SESSION['ROLE']=='admin'){ ?>
				          <li class="menu-item-has-children">
                              <a href="create_thema.php"><i class="fa fa-globe me-2"></i>&nbsp;&nbsp; Create Thema</a>
                          </li>
                          <li class="menu-item-has-children">
                              <a href="create_category.php"><i class="fa fa-sitemap me-2"></i>&nbsp;&nbsp; Category</a>
                          </li>
                          
                          
                          <li class="menu-item-has-children">
                              <a href="users.php"><i class="fa fa-users me-2"></i>&nbsp;&nbsp; Users</a>
                          </li>
                         
                          <li class="menu-item-has-children">
                              <a href="create_thema_layout.php"><i class="fa fa-pencil-square-o me-2"></i>&nbsp;&nbsp; Thema Logo</a>
                          </li>
                          
                          <li class="menu-item-has-children">
                              <a href="create_thema_feature_layout.php"><i class="fa fa-th-large me-2"></i>&nbsp;&nbsp; Thema Feature Layout</a>
                          </li>
				        <?php }elseif($_SESSION['ROLE']=='user'){
				            ?>
				            
                            <li class="menu-item-has-children">
                              <a href="create_thema.php"><i class="fa fa-simplybuilt me-2"></i>&nbsp;&nbsp; Offers</a>
                           </li>
				            <?php
				        }
				        ?>
                   <!--Create the thema name section layout-->
               <li class="menu-item-has-children">
                 <a href="active_thema.php"> <i class="fa fa-television me-2"></i> &nbsp;&nbsp;Active Thema Display</a>
               </li>
               <li class="menu-item-has-children">
                 <a href="setting.php"> <i class="fa fa-cog me-2"></i> &nbsp;&nbsp;Setting</a>
               </li>
               <li class="menu-item-has-children">
                 <a href="logout.php"> <i class="fa fa-power-off me-2"></i> &nbsp;&nbsp;Logout</a>
               </li>
              
            </ul>
         </div>
      </nav>
   </aside>
   <div id="right-panel" class="right-panel">
      <header id="header" class="header">
         <div class="top-left">
            <div class="navbar-header">
               <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
            </div>
         </div>
         <div class="top-right">
            <div class="header-menu">
               <div class="user-area dropdown float-right">
                  <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true"
                     aria-expanded="false">
                     <?php echo ucwords($_SESSION['ADMIN_USERNAME'])?>
                  </a>
                  <div class="user-menu dropdown-menu">
                     <a class="nav-link" href="logout.php"><i class="fa fa-power-off"></i>Logout</a>
                  </div>
               </div>
            </div>
         </div>
      </header>