<?php
//Check if this is called from the application
if(!defined('SPF'))
{
	header('Location:/');	
	exit();
	
}
?>
<div class="hero-unit">
	<h1>Baseline</h1>
		<p>This project is built as a baseline for any website you may want to build. It includes:</p>
		<div class='span'>
			<li>Registration system with email activation system</li>
			<li>A basic contact form, which emails all admin members</li>
		</div>
		<div class='clearfix'></div>
</div>
<?php

if ($install)
{
	echo '<div class="alert alert-info">
		<strong>Update</strong>
		<br />
		Ran the installation script.</div>';
}

if ($update)
{
	echo '<div class="alert alert-info">
		<strong>Update</strong>
		<br />
		Ran the options script to update the options.</div>';
}

?>