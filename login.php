<?PHP
require 'includes/master.inc.php';

if($Auth->loggedIn()) redirect(WEB_ROOT.'/dashboard.php');

if(!empty($_POST['username']))
{
    $authenticate = $Auth->login($_POST['username'], $_POST['password']);
    if($authenticate === true)
    {
        $Error->add('info', "Welcome back ".$_POST['username']."");
        
        if(isset($_REQUEST['r']) && strlen($_REQUEST['r']) > 0)
            redirect($_REQUEST['r']);
        else
            redirect(WEB_ROOT.'/dashboard.php');
    }
    else if ($authenticate === 'inactive')
    {
        $Error->add('error', "Your account is not active yet, please check your email for the activation email and follow the link contained within.");
    }
    else
    {
        $Error->add('error', "We're sorry, you have entered an incorrect username and password. Please try again.");
    }    
}
redirect(WEB_ROOT);
?>