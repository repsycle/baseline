<?php
//Bootstrap SPF
require 'includes/master.inc.php';

//This loads up $user - $isadmin - $js
require 'includes/user.inc.php';

$complete = false;
$reset = false;
$detail = false;
$newPassword = '';

/// Checking //

// Form validation PHP version
$inputValue = array('', '');

// Page specific info
$title='I forgot my password <small>oh no</small>';
$meta=''; // Possibly add page unique meta data


// Validate the form fields
// Username verification
if (isset($_POST['action']))
{
    if ((isset($_POST['forgot-username']))
	&& ($_POST['forgot-username'] !== ''))
    {
	$detail = $_POST['forgot-username'];
	$inputValue[0] = $_POST['forgot-username'];
    }
    elseif ((isset($_POST['forgot-email']))
	    && ($_POST['forgot-email'] !== ''))
    {
	$detail = $_POST['forgot-email'];
	$inputValue[1] = $_POST['forgot-email'];
    } else {
	$Error->add('error', 'You will need to provide us with either a username or email address to reset your password');
    }
     
    // Check if the details provided exists and whether they would be allowed to reset their password.    
    if ((isset($detail))
    &&(Auth::resetPasswordCheck($detail) == false))
    {	
	$Error->add('error', 'No account found with the username or email address specified!');
    }
}

// Instantiontiate the erroring before we need to refresh the page
$msg=$Error->alert();

// Check if the form was submitted without any errors. 
if ((isset($detail))
&& (Auth::resetPasswordCheck($detail) !== false))
{    
    $userId = Auth::resetPasswordCheck($detail);    
    $activationCode = Activation::get($userId);
    $complete = true;
    $u = new User($userId);
    
    $link = full_url_to_script('forgot.php') . "?action=resetpassword&code=" . Activation::get($userId) . "&uid=" . $userId;
    
    // Select the Email tempalte and replace the relevant values    
    Emailtemplate::setBaseDir('./assets/email_templates');
    $html = Emailtemplate::loadTemplate('forgot', array('title'=>'Reset Password Email',
                                                            'prettyName'=>Options::get('prettyName'),
                                                            'name'=>$u->username,
                                                            'siteName'=>Options::get('emailName'),
                                                            'link'=>$link,
                                                            'footerLink'=>Options::get('siteName'),
                                                            'footerEmail'=>Options::get('emailInfo')));

    // Replace the relevant values and send the HTML email
    send_html_mail(array($u->username=>$u->email),
                        'Reset Password Email',
                        $html,
                        array(Options::get('siteName')=>Options::get('emailAdmin')));
}

// Otherwise if the email link is followed lets reset the password and email it to the user.
if ((isset($_GET['action']))
&& ($_GET['action'] == 'resetpassword')
&& (isset($_GET['uid']))
&& (isset($_GET['code']))
and (Activation::get($_GET['uid']) == $_GET['code']))
{
    $u = new User($_GET['uid']);
    $userId = $u->id;
    $newPassword = Auth::generateStrongPassword(6, false, 'ld');    
    Auth::changePassword($userId, $newPassword);
    $reset = true;
    
    // Select the Email tempalte and replace the relevant values    
    Emailtemplate::setBaseDir('./assets/email_templates');
    $html = Emailtemplate::loadTemplate('reset', array('title'=>'Password Successfully Reset',
                                                            'prettyName'=>Options::get('prettyName'),
                                                            'name'=>$u->username,
                                                            'siteName'=>Options::get('emailName'),
                                                            'password'=>$newPassword,
                                                            'footerLink'=>Options::get('siteName'),
                                                            'footerEmail'=>Options::get('emailInfo')));

    // Replace the relevant values and send the HTML email
    send_html_mail(array($u->username=>$u->email),
                        'New Password',
                        $html,
                        array(Options::get('siteName')=>Options::get('emailAdmin')));
}

Template::setBaseDir('./assets/tmpl');

$html = Template::loadTemplate('layout', array(
	'header'=>Template::loadTemplate('header', array('title'=>$title,'user'=>$user,'admin'=>$isadmin,'msg'=>$msg, 'meta'=>$meta, 'selected'=>'forgot')),
	'content'=>Template::loadTemplate('forgot', array('inputValue'=>$inputValue, 'complete'=>$complete, 'reset'=>$reset, 'password'=>$newPassword)),
	'footer'=>Template::loadTemplate('footer',array('time_start'=>$time_start))
));

echo $html;
?>