<?php
//Check if this is called from the application
if(!defined('SPF'))
{
	header('Location:/');	
	exit();
	
}

if ((isset($reset))
&& ($reset == true))
{
?>
<div class="container span6 well">
	<h4>We have reset your account password and sent it to you via email as a backup.
		<br /><br />
		<h3><small>Your new password is</small> <?php echo $password; ?></h3>
	</h4>
</div>
<div style="clear: both;"></div>	
<?php
}

elseif ($complete == false)
{
?>
<div class="container">
	<div class="span">
		<p>Please provide us with either you username or your email address in order for us to send you the password reset link.</p>
		<form method='post' class='form form-horizontal well' action=''>			
			<div class="control-group">
				<label class="control-label" for="input01">Username</label>
				<div class="controls">
					<input type="text" class="input-xlarge" id="input01" placeholder="Username" name="forgot-username" value="<?php echo $inputValue[0]; ?>">
				</div>
			</div>				
			<div class="control-group">
				<label class="control-label" for="input04">Email Address</label>
				<div class="controls">
					<input type="text" class="input-xlarge " placeholder="Email@address.com" id="input04" name="forgot-email" value="<?php echo $inputValue[1]; ?>">
				</div>
			</div>
			<div class="controls">
				<button type="submit" name="action" value='register' class="btn btn-large btn-primary">Request new password</button>
			</div>
		</form>
	</div>
</div>
<?php
// End of main control
} else {
?>
<div class="container span6 well">
	<h4>We sent you an email with the link you can use to reset your account password. Please check your email for the information.</h4>
</div>
<div style="clear: both;"></div>
<?php
}
?>