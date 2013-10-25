<?php
//Check if this is called from the application
if(!defined('SPF'))
{
	header('Location:/');	
	exit();	
}

if ($complete)
{
// What to display on success
?>
	<div class="alert alert-info span6">
		<strong>Account activated.</strong>
		<br /><br />
		<p>
			<strong>Thank you, </strong>			
			for taking the time to register an account with us. Feel free to login and get started. 
		</p>
	</div>
	<div class='clearfix'></div>
	
<?php } else {
// What to display on failure	
?>
	<div class='container span6'>
		<form class='well form-vertical' method='get'>
			<p>You can manually active your account by filling in the details below, or go to the email we sent you and active your account using the link.</p>
			<fieldset class="control-group <?php echo $errorClass[0]; ?>">
				<input type="text" class='input-xlarge' name="username" placeholder='Username' value='<?php echo $inputValue[0]; ?>'>
			</fieldset>
			<fieldset class="control-group <?php echo $errorClass[1]; ?>">
				<input type="text" class='input-xlarge' name="code" placeholder='Activation Code' value='<?php echo $inputValue[1]; ?>'>
			</fieldset>
			<fieldset class="control-group">
				<input type="submit" class='btn btn-large btn-primary' name='action' value='Activate'>
			</fieldset>
		</form>
	</div>
	<div class='clearfix'></div>

<?php } ?>