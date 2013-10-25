<?php

//Bootstrap SPF
require 'includes/master.inc.php';

// Set the headers so the image gets created
header("Content-type:image/jpeg");

// Lets check if we should be creating a image and we will only be able to do specific types
if ((isset($_REQUEST['action']))
&& ($_REQUEST['action'] == 'captcha')) // Needs to be empty
{
    header("Content-Disposition:inline ;filename=captcha.jpg");
    Captcha::createImage(100, 50, 5);   
}

// Wallpaper request, I will decide later if we will be allowing only registered users to download
if ((isset($_REQUEST['action']))
&& ($_REQUEST['action'] == 'get_wallpaper')
&& (isset($_REQUEST['width']))
&& (!empty($_REQUEST['width']))
&& (isset($_REQUEST['height']))
&& (!empty($_REQUEST['height']))
&& (isset($_REQUEST['img']))
&& (!empty($_REQUEST['img'])))
{
    $img = new GD();
    set_time_limit(3600);
    $imgSaveName = str_replace('.jpg', "_wallpaper_" . $_REQUEST['width'] . "_" . $_REQUEST['height']. ".jpg",$_REQUEST['img']);
    header("Content-Disposition:inline ;filename=" . $imgSaveName);
    $img->resizeToResolution($_REQUEST['img'], $_REQUEST['width'], $_REQUEST['height']);
}

?>