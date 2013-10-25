<?php
//Bootstrap SPF
require 'includes/master.inc.php';

$mustauth=true;
//This loads up $user - $isadmin - $js
require 'includes/user.inc.php';

$title="Dashboard <small>everything starts here<small>";

Template::setBaseDir('./assets/tmpl');

$html = Template::loadTemplate('layout', array(
	'header'=>Template::loadTemplate('header', array('title'=>$title,'user'=>$user,'admin'=>$isadmin,'msg'=>$msg, 'selected'=>'dashboard')),
	'content'=>Template::loadTemplate('dashboard', array('admin'=>$isadmin)),
	'footer'=>Template::loadTemplate('footer',array('time_start'=>$time_start))
));


echo $html;
?>