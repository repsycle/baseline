<?php
//Check if this is called from the application
if(!defined('SPF'))
{
	header('Location:/');
	exit();
}
?>
<?php
    if ($changes)
    {
        echo '<div class="container">	
		<div class="alert alert-info">
		<strong>Update</strong>
		<br />
		Settings have been saved</div>
	</div>';
    }
?>
<div class="container">	
	<div class="span">		
		<form method='post' class='form form-horizontal well' action=''>			
			<div class="control-group <?php /* echo $errorClass[0]; */ ?>">
				<label class="control-label" for="input01">Email Address</label>
				<div class="controls">
					<input type="text" class="input-xlarge" id="input01" name="user-email" value="<?php echo $inputValue[0]; ?>">
				</div>
				<div class='hide' id='emailWarning'>
					<br />
					<div class="alert alert-error">
						<strong>Warning</strong>
						<br />
						When you change your email address you will need to re-activate your<br />
						account with your new email address!
					</div>
				</div>
			</div>
			<div class="control-group <?php /* echo $errorClass[0]; */ ?>">
				<label class="control-label" for="input02">Password</label>
				<div class="controls">
					<input type="password" class="input-xlarge" id="input02" name="user-password" value="<?php echo $inputValue[1]; ?>">
				</div>
				<div class='hide' id='passwordWarning'> 
					<br />
					<div class="alert alert-error">
						<strong>Warning</strong>
						<br />
						Changing your password will log you out
					</div>
				</div>
			</div>
<!-- Default settings above, now for the dynamic fields -->
<?php	
	$options = (Options::getList(false, 'User Settings'));
        if (!empty($options))
        {       
            foreach($options as $option=>$value)
            {
                $type = $value['type'];
		// Get the user specific values from the Options_users table
                $val = Options::userGet($userId, $option);		
                $label = camelcase2space($option); 
        
                echo '<div class="control-group">' .nl();
		echo '	<label class="control-label" for="' . $option . '">' . $label . '</label>' . nl();
		echo '	<div class="controls">'. nl();
                    
                if ($type == 'input')
                {
                    echo '<input type="text" class="input-xlarge" id="' . $option . '" name="' . $option . '" value="' . $val . '">'. nl();
                }
                
                if ($type == 'textarea')
                {
                    echo '<textarea class="textarea input-xxlarge" id="' . $option . '" name="' . $option . '">' . $val . '</textarea>'. nl();
                }
                
                if ($type == 'bool')
                {
		    echo bool_select($val, $option);
                }
                
                if ($type == 'date')
                {
                    echo mdy($val, $option, 'd m y');                                          
                }
                
                echo "</div></div>". nl();                
            }
        }
?>		
<!-- Finish it off with the save button -->	
			<div class="controls">
				<input type="submit" name='action' class="btn btn-primary btn-large" value="Save Changes">
			</div>
		</form>
	</div>
</div>
