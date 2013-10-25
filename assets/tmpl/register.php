<?php
//Check if this is called from the application
if(!defined('SPF'))
{
	header('Location:/');	
	exit();
	
}

if (((!empty($errorClass))
    and (!empty($errorClass)))
    and ($complete == false))
{
?>
<div class="container">
	<div class="span">
		<form method='post' class='form form-horizontal well' action=''>
			<input type='hidden' name='callback' value='<?php echo $callback; ?>' />
			<div class="control-group <?php echo $errorClass[0]; ?>">
				<label class="control-label" for="input01">Username</label>
				<div class="controls">
					<input type="text" class="input-xlarge" id="input01" placeholder="Username" name="register-username" value="<?php echo $inputValue[0]; ?>">
				</div>
			</div>
			
			<div class="control-group <?php echo $errorClass[1]; ?>">
				<label class="control-label" for="input02">Password</label>
				<div class="controls">
					<input type="password" class="input-xlarge" id="input02" placeholder="Password" name="register-password" value="<?php echo $inputValue[1]; ?>">
				</div>
			</div>
			
			<div class="control-group <?php echo $errorClass[2]; ?>">
				<label class="control-label" for="input03">Confirm Password</label>
				<div class="controls">
					<input type="password" class="input-xlarge" id="input03" placeholder="Password" name="register-confirm" value="<?php echo $inputValue[2]; ?>">
				</div>
			</div>		
			
			<div class="control-group <?php echo $errorClass[3]; ?>">
				<label class="control-label" for="input04">Email Address</label>
				<div class="controls">
					<input type="text" class="input-xlarge " placeholder="Email@address.com" id="input04" name="register-email" value="<?php echo $inputValue[3]; ?>">
				</div>
			</div>
					
			<div class="control-group <?php echo $errorClass[4]; ?>">
				<label class="control-label" for="input05">Are you human?</label>
				<img src="image.php?action=captcha" alt="Error, unable to load" />   
				<div class="controls">
					<input type="text" class="input-xlarge " placeholder="Enter the code you see above" id="input05" name="register-captcha" value="<?php echo $inputValue[4]; ?>">
				</div>
			</div>	
			
			<div class="controls">
				<button type="submit" name="action" value='register' class="btn btn-large btn-primary">Register</button>
			</div>
		</form>
	</div>
</div>
<?php
// End of main control
} else {
?>
<div class="container span6 well">
	<h4>You have sucessfully registered, please check your email for the activation link.</h4>
</div>
<div style="clear: both;"></div>
<?php
}
?>