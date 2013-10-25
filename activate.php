<?php
//Bootstrap SPF
require 'includes/master.inc.php';

//This loads up $user - $isadmin - $js
require 'includes/user.inc.php';

$title="Activate <small>your account</small>";
$complete = false;
// Form validation PHP version
$errorClass = array('', '');
$inputValue = array('Username', 'Activation Code');
$code = false;
$uid = false;

if ((isset($_GET['action']))
&& (strtolower($_GET['action']) == 'activate')) {
    
    // Check if the required information is being submitted to us  
    if (isset($_GET['id']))
    {        
        $uid = $_GET['id'];
        $inputValue[0] = $_REQUEST['id'];
    } else if (isset($_REQUEST['username']))
    {
        $uid = $_GET['username'];
        $inputValue[0] = $_REQUEST['username'];
    } else {
        $errorClass[0] = 'error';
        $Error->add('error', 'Invalid username.');
    }
    
    if ((isset($_REQUEST['code']))
    && ($_REQUEST['code'] !== $inputValue[1]))   
    {
        $code = $_REQUEST['code'];
        $inputValue[1] = $code;
    } else {
        $errorClass[1] = 'error';
        $Error->add('error', 'Invalid activation code');
    }
}

if ($uid and $code)
{   
    // First check the client's username and get the id if it's not one
    $userId = Auth::userId($uid);    
    $activationCode = Activation::get($userId);
    /*echo $uid . "<br />";
    echo $userId . "<br />";
    echo $activationCode . "<br />";
    echo $code . "<br />";*/
    if ($activationCode !== $code)
    {
        $errorClass[0] = 'error';
        $errorClass[1] = 'error';
        $Error->add('error', 'Activation unsuccessfull, please confirm that the details are correct or follow the link in the activation email sent to you.');    
    }   
}

$msg=$Error->alert();
if ((!$Error->ok())
&& ($uid and $code))
{
    $complete = true;    
    echo Activation::activate($userId);
}

Template::setBaseDir('./assets/tmpl');
$html = Template::loadTemplate('layout', array(
	'header'=>Template::loadTemplate('header', array('title'=>$title,'user'=>$user,'admin'=>$isadmin,'msg'=>$msg, 'selected'=>'activate')),
	'content'=>Template::loadTemplate('activate',array('complete'=>$complete, 'errorClass'=>$errorClass, 'inputValue'=>$inputValue)),
	'footer'=>Template::loadTemplate('footer',array('time_start'=>$time_start))
));

echo $html;
?>