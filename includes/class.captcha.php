<?php

// Lets start to create the class
class Captcha
{
   
   public static function createCode($lenght)
   {
      $string = '';
      $repositry = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'x', 'y', 'z', '2', '3', '4', '5', '6', '7', '8', '9');
      for ($i = 1; $i <= $lenght; $i++)
      {
          shuffle($repositry);
          $string .= $repositry[0];
      }
      
      // Assign the variable
      $_SESSION['security_number']=$string;
   }
   
   public static function createImage($width, $height, $lenght)
   {
      
      // First generate the code
      $code = Captcha::createCode($lenght);
      
      // Create the images
      $img = imagecreatetruecolor($width, $height);
      $bgColor = imagecolorallocate($img,245,245,245);
      ImageFill($img, 0, 0, $bgColor);
  
      $security_number = empty($_SESSION['security_number']) ? 'error' : $_SESSION['security_number'];
      $image_text=$security_number;
      $red=rand(100, 255); 
      $green=rand(100, 255);
      $blue=rand(100, 255);
  
      $text_color=imagecolorallocate($img, 255-$red, 255-$green, 255-$blue);
  
      $text=imagettftext($img, 15, rand(-10,10), rand(10,40), rand(25,30), $text_color, "assets/fonts/courbd.ttf", $image_text);
  	
      imagejpeg($img); 
   }   

}

?>