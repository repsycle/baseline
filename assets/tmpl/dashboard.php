<?php
//Check if this is called from the application
if(!defined('SPF'))
{
    header('Location:/');
    exit();   
}
?>
<div class="hero-unit">  
    <p>This is where you would create default actions for the user, say hello, show stats. Whatever you like.</p>
    <div class='span'>
      <li><a href='settings.php'>Edit my basic settings</a></li>
      <li><a href='users.php'>Check out who's who in the zoo</a></li>
<?php
    if ($admin == true)
    {
      echo "<li><a href='admin.php'>Hey Admin, go to the admin page</a></li>";
    }
?>
    </div>
    <div class='clearfix'></div>
</div>