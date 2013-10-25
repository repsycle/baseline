<?php
//Check if this is called from the application
if(!defined('SPF'))
{
    header('Location:/');
    exit();
}
// Function to check if the selected is passed for the particular value 
function selected($name, $selected)
{  
  if ((isset($selected))
  && ($selected == $name))
  {
    echo 'class="active"';    
  }
}

if (!isset($selected)) { $selected = ''; }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php if($title) { echo strip_tags($title); } else { echo "Welcome to demo.co.za"; } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo Options::get('metaDesc'); ?>">
    <meta name="author" content="<?php echo Options::get('metaAuthor'); ?>">
    <meta name="keywords" content="<?php echo Options::get('metaKeyWords'); ?>">
    <!-- FaceBook Meta -->
    <meta property="og:title" content="<?php      if (isset($fb['title']))      { echo $fb['title'];      } else {  echo Options::get('facebookTitle'); } ?>" />
    <meta property="og:type" content="<?php       if (isset($fb['type']))       { echo $fb['type'];       } else {  echo Options::get('facebookType'); } ?>" />
    <meta property="og:url" content="<?php        if (isset($fb['url']))        { echo $fb['url'];        } else {  echo Options::get('facebookUrl'); } ?>" />
    <meta property="og:image" content="<?php      if (isset($fb['image']))      { echo $fb['image'];      } else {  echo Options::get('facebookImage'); } ?>" />
    <meta property="og:site_name" content="<?php  if (isset($fb['site_name']))  { echo $fb['site_name'];  } else {  echo Options::get('facebookSiteName'); } ?>" />
    <meta property="fb:admins" content="<?php     if (isset($fb['admins']))     { echo $fb['admins'];     } else {  echo Options::get('facebookAdminUsers'); } ?>" />
    <!-- possible additional metadata -->
    <?php if (isset($meta)) { echo $meta; } ?>
    
    <!-- Le styles -->
    <link href="assets/css/uploadify.css" rel="stylesheet">
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/prettify.css" rel="stylesheet">      
    <link href="assets/css/custom.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 30px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo Options::get('siteIcon'); ?>">
  </head>

  <body onload="prettyPrint()">
    
    <div class="container">
      <div class="pull-right" style="margin: 0px; padding-top: 10px;">
        <div class="pull-left" style="margin: 0px; padding-top: 50px;">          
          <h1><?php echo (Options::get('prettyName')); ?></h1>
        </div>
        &nbsp;&nbsp;
        <img src="<?php echo Options::get('siteLogo'); ?>" width="100" alt="logo" />
      </div>
    </div>
    
    
    <div class="navbar container navbar-inverse">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <!--<a class="brand" href="#">Thatguy.co.za</a>-->

<?php // Check if the user is logged in and modify what options are presented, in this case the user is lodded in 
if($user) { ?>

                  <ul class="nav pull-right">
                      <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                          <i class='icon-white icon-user'></i> Welcome <?php echo $user; ?> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                          <li><a href="settings.php"><i class="icon-cog"></i>  Settings</a></li>
                          <li class="divider"></li>
                          <li><a href="logout.php"><i class="icon-off"></i>  Sign Out</a></li>
                        </ul>
                  </ul>
        <!-- Old Version using the button
        <div class="btn-group pull-right">
          <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="icon-user"></i> Welcome <?php echo $user; ?>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="settings.php"><i class="icon-cog"></i>  Settings</a></li>
            <li class="divider"></li>
            <li><a href="logout.php"><i class="icon-off"></i>  Sign Out</a></li>
          </ul>
        </div>-->

<?php // The user is not logged in, so lets give them the prompt 
} else { ?>
                    <ul class="nav pull-right">
                      <li><a href="register.php">Register</a></li>
                      <li class="divider-vertical"></li>
                      <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                          <i class='icon-white icon-user'></i> Login <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                          <form action="login.php" id="form_login" style="margin: 0px; padding: 15px 15px 0px 15px;" accept-charset="utf-8" method="post">
                              <fieldset class="control-group">  
                                <input type="text" class="span2" name="username" placeholder="Username">
                              </fieldset>
                              <fieldset class="control-group">
                                <input type="password" class="span2" name="password" placeholder="Passsword" />
                              </fieldset>
                              <fieldset class="control-group">
                                <button type="submit" class="btn btn-primary">Login</button>
                              </fieldset>
                          </form>                              
                          <p class="divider"></p>
                          <li><a href="register.php">Register</a></li>
                          <p class="divider"></p>
                          <li><a href="forgot.php">Forgot password</a></li>       
                        </ul>
                      </li>
                    </ul>
            <!-- Login --><!-- Old method using the button
              <div class="nav pull-right">                
                  <div class="dropdown">                      
                      <a href="#" class="btn dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user"></i>
                        Login
                        <span class="caret"></span>
                      </a>
                      <div class="dropdown-menu">
                          <form action="login.php" id="form_login" style="margin: 0px; padding: 15px 15px 0px 15px;" accept-charset="utf-8" method="post">
                              <fieldset class="control-group">  
                                <input type="text" class="span2" name="username" placeholder="Username">
                              </fieldset>
                              <fieldset class="control-group">
                                <input type="password" class="span2" name="password" placeholder="Passsword" />
                              </fieldset>
                              <fieldset class="control-group">
                                <button type="submit" class="btn btn-primary">Login</button>
                              </fieldset>
                          </form>                              
                          <p class="divider"></p>
                          <li><a href="register.php">Register</a></li>
                          <p class="divider"></p>
                          <li><a href="forgot.php">Forgot password</a></li>                             
                      </div>
                  </div>
              </div><!-- Login -->
<?php } ?>
              
          <div class="nav-collapse">
            <ul class="nav">
              <li <?php selected('home', $selected); ?>>
                <a href="index.php"><i class="icon-home icon-white"></i> Home</a>
              </li>
              
<!-- This is to create the menu based on the type of account they have  -->             
<?php if ($user) { ?>
              <li <?php selected('users', $selected); ?>>
                <a href="users.php"><i class="icon-user icon-white"></i> Users</a>
              </li>              
  <!-- Is both a user and an admin -->
  <?php if ($admin) { ?>                 
              <!--<li class="divider-vertical"></li>-->
              <li <?php selected('admin', $selected); ?>>
                <a href="admin.php"><i class="icon-cog icon-white"></i> Admin</a>
              </li>
  <?php } ?>
  <!-- Is both a user and an admin -->
  
<!-- Guests -->
<?php } else { ?>
              <li <?php selected('contact', $selected); ?>>
                <a href="contact.php"><i class="icon-comment icon-white"></i> Contact</a> 
              </li>
           

<?php } ?>
<!-- Guests -->
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>        
    <div class="container">

<?php

  // display the title of the page 
  if (($title) && ($title !== ''))
  {
   echo '<div class="page-header">
          <h1>
            ' . $title . '
          </h1>
        </div>';
  }

  // Display the error messages 
  if ($msg) 
  {
    echo "<div class='row'>
            <div class='span6'>              
            " . $msg . "
            </div>
          </div>";
  }
  
  
?>