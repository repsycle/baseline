<?php
//Bootstrap SPF
require 'includes/master.inc.php';

//This loads up $user - $isadmin - $js
require 'includes/user.inc.php';

$title="Contact <small>us, send us an email</small>";
$mustauth=false;
$complete=false;

// Form validation PHP version
$errorClass = array('', '', '', '', '');
$inputValue = array('', '', '', '', '');

// User
if (isset($_POST['contact-email-name']))
{
    $inputValue[0] = $_POST['contact-email-name'];
    if ($Error->length($_POST['contact-email-name'], 2, 16, 'error', 'Name'))
    {        
        $errorClass[0] = 'success'; 
    } else {
        $errorClass[0] = 'error';
    }
} else if (isset($_POST['action'])) {
    $Error->add('error', 'Name cannot be left empty');
    $errorClass[0] = 'error';        
}

// Email verification
if (isset($_POST['from-address']))
{
    $inputValue[1] = $_POST['from-address'];
    if ($Error->email($_POST['from-address'], false))
    {        
        $errorClass[1] = 'success'; 
    } else {
        $errorClass[1] = 'error';
    }
} else if (isset($_POST['action'])) {
    $Error->add('error', 'Email be left empty');
    $errorClass[1] = 'error';        
}

// Message Verification
if (isset($_POST['contact-email-message']))
{
    $inputValue[2] = $_POST['contact-email-message'];
    if ($Error->length($_POST['contact-email-message'], 10, 1000, 'error', 'Message body'))
    {        
        $errorClass[2] = 'success'; 
    } else {
        $errorClass[2] = 'error';
    }
} else if (isset($_POST['action'])) {
    $Error->add('error', 'Message cannot be left empty');
    $errorClass[2] = 'error';        
}

// Instantiontiate the erroring before we need to refresh the page
$msg=$Error->alert();

// Check if the form was submitted without any errors. 
if ((isset($_POST['from-address']))
&& (isset($_POST['contact-email-message']))
&& (isset($_POST['contact-email-name']))
&& (!$Error->ok()))
{    
    // Try to send the email    
    if (send_group_email(
        'admin',
        $_POST['from-address'],
        $_POST['contact-email-name'],
        'Contact Form',
        nl2br($_POST['contact-email-message'])))
    {  
        //$Error->add('info', 'Thank you, your email has been sent!');
        $complete = 'true';
    } else {        
        $Error->add('error', 'Unfortunatel, there was in error in sending your email');
        $complete = 'error';    
    }
}    

Template::setBaseDir('./assets/tmpl');

$html = Template::loadTemplate('layout', array(
	'header'=>Template::loadTemplate('header', array('title'=>$title,'user'=>$user,'admin'=>$isadmin,'msg'=>$msg, 'selected'=>'contact')),
	'content'=>Template::loadTemplate('contact', array('errorClass'=>$errorClass, 'inputValue'=>$inputValue, 'complete'=>$complete)),
	'footer'=>Template::loadTemplate('footer',array('time_start'=>$time_start))
));

echo $html;
?>