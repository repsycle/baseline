<?php
//Check if this is called from the application
if(!defined('SPF'))
{
    header('Location:/');
    exit();
}
?>
<div class="container">
<?php
    if ($changes)
    {
        echo '<div class="alert alert-info">
		<strong>Update</strong>
		<br />
		Settings have been saved</div>';
    }
?>

<form method='post' class='form form-vertical' action=''>    
    <ul class="nav nav-pills" id="myTab">
    
<?php
    $i = 0;
    foreach(Options::groups() as $group)
    {
        $active = '';
        if ($i == 0) $active = "active";
        $hash = strtolower(str_replace(" ", "", $group['group']));
        $title = $group['desc'];
        echo '<li class="' . $active . '">
                <a data-toggle="tab" title="' . $title . '" href="#' . $hash . '">' . $group["group"] . '</a>
            </li>';
            
        $i++;     
    }
?>      
    </ul>
    <div id="myTabContent" class="tab-content">
    
<?php
    $i = 0;
    foreach(Options::groups() as $group)
    {
        $active = '';
        if ($i == 0) $active = " active in";
        $hash = strtolower(str_replace(" ", "", $group['group']));
        $title = $group['desc'];
        $name = $group['group'];

        echo '<div id="' . $hash . '" class="tab-pane fade' . $active . '">
                <div class="well">
                    <h3>' . $name . ' <small>' . $title . '</small></h3>
                    <br />';
                    
        $options = (Options::getList(false, $name));
        if (empty($options))
        {
            echo "No results found";
        } else {
            foreach($options as $option=>$value)
            {
                $type = $value['type'];
                $val = $value['value'];
                $label = camelcase2space($option);
                
                echo '<label class="control-label" for="' . $option . '">' . $label . '</label>
                    <div class="controls">';
                    
                if ($type == 'input')
                {
                    echo '<input type="text" class="input-xlarge" id="' . $option . '" name="' . $option . '" value="' . $val . '">';
                }
                
                if ($type == 'textarea')
                {
                    echo '<textarea class="textarea input-xxlarge" id="' . $option . '" name="' . $option . '">' . $val . '</textarea>';
                }
                
                if ($type == 'bool')
                {
		    echo bool_select($val, $option);
                }
                
                if ($type == 'date')
                {
                    echo mdy($val, $option, 'd m y');                                          
                }
                
                echo "</div>";                
            }
        }
        echo '</div></div>
            <div class="clearfix"></div>';
        
        
     //. Options::all($name) . "</div>";
        
        $i++;        
    }
?>



<div class="modal hide fade" id="myModal" style="display: none;">
    <div class="modal-header">
      <button data-dismiss="modal" class="close" type="button">&times;</button>
      <h3>List of available variables, <small>and their values</small></h3>
    </div>
    <div class="modal-body">
<?php
    foreach(Options::groups() as $group)
    {
        $title = $group['desc'];
        $name = $group['group'];
        $groupOptions = Options::getList(false, $name);
        if (!empty($groupOptions))
        {
            echo '<ul class="unstyled">';
            foreach($groupOptions as $variable=>$value)
            {
                echo "<li><strong>Options::get('" . $variable . "');</strong> = " . nl2br($value['value']) . "</li>";
            }
            echo '</ul>';
        }
    }
?>       
    </div>
    <div class="modal-footer">
      <a data-dismiss="modal" class="btn" href="#" style="">Close</a>              
    </div>
</div>



    </div>       
        <div class="controls">
            <button type="submit" name="action" value='Save Changes' class="btn btn-large btn-primary">Save Changes</button>
            &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-inverse btn-large" href="#myModal" data-toggle="modal">Show Available Variables</a>        
        </div>       
    </form>

    <hr />

    <div class="row">
        <div class="span4 pull-left">
            <form method="post" class="form">
                <h3>Add an option (PHP Variable)</h3>
                <br />
                
                <div class="control-group">
                    <input type="text" class="input-large" name="option_name" placeholder="Use camel case like userName">
                </div>
                
                <div class="control-group">
                    <input type="text" class="input-large" name="option_value" placeholder="Default Value">
                </div>
                
                <div class="control-group">
                    <select class="select" name='group' title='Groups of options'>
                        <?php echo get_options('options_groups', 'group', 'group', @$_POST['group']); ?>    
                    </select>
                </div>
                
                <div class="control-group">
                    <select class="select" name='type' title='Type of variable'>
                        <?php echo array2options(Options::types(), @$_POST['type']); ?>
                    </select>
                </div>
                <div class="cnotrol-group">
                    <input type='submit' class='btn btn-large input-xlarge' value='Add Option'>
                    <input type='hidden' name='action' value='add'>
                </div>
            </form>
        </div>        
               
        
        <div class="span4 pull-left">
            <form method="post" class="form">
                <h3>Add Group</h3>
                <br />
                
                <div class="control-group">
                    <input type="text" class="input-large" name="group_name" placeholder="MyGroup Name">
                </div>
                
                <div class="control-group">
                    <input type="text" class="input-large" name="group_desc" placeholder="Description of the group">
                </div>  
                <div class="control-group">
                    <input type='submit' class='btn btn-large input-xlarge' value='Add Group'>
                    <input type='hidden' name='action' value='group_add'>
                </div>
            </form>
        </div>
        
        
        <div class="span4 pull-left">
            <form method="post" class="form">
                <h3>Link option to group</h3>
                <br />                
                <div class="control-group">
                    <select class="select" placeholder="Variable" id='option' name='option' title='Options Variables'>
                        <?php echo get_options('options', 'key', 'key', @$_POST['option']); ?>    
                    </select>
                </div>
                
                <div class="control-group">
                    <select class="select" name='group' id='group' title='Groups of options'>
                        <?php echo get_options('options_groups', 'group', 'group', @$_POST['group']); ?>    
                    </select>
                </div>
                
                <div class="control-group">
                    <select class="select" name='type' id='type' title='Type of variable'>
                        <?php echo array2options(Options::types(), @$_POST['type']); ?>
                    </select>
                </div>
                
                <div class="control-group">
                    <input type='submit' class='btn btn-large input-xlarge' value='Update'>
                    <input type='hidden' name='action' value='update'>
                </div>
            </form>
        </div>       
        
        
        <div class="clearfix"></div>
        <div class="span12">
            <hr />
        </div>        
     
        <div class="span4">            
            <form method="post" class="form">
                <h3>Remove Option</h3>
                <br />               
                
                <div class="control-group">                   
                    <select class="select" placeholder="Variable" id='option' name='option' title='Options Variables'>
                        <?php echo get_options('options', 'key', 'key', @$_POST['option']); ?>    
                    </select>               
                </div>                
                <div class="control-group">
                    <input type='submit' class='btn btn-large input-xlarge' value='Remove'>
                    <input type='hidden' name='action' value='remove'>
                </div>
            </form>
        </div>
        
        <div class="span4">            
            <form method="post" class="form">
                <h3>Remove Group</h3>
                <br />               
                
                <div class="control-group">
                    <select class="select" name='group' id='group' title='Groups of options'>
                        <?php echo get_options('options_groups', 'group', 'group', @$_POST['group']); ?>    
                    </select>
                </div>                
                <div class="control-group">
                    <input type='submit' class='btn btn-large input-xlarge' value='Remove Group'>
                    <input type='hidden' name='action' value='group_remove'>
                </div>
            </form>
        </div> 
    </div>
      
    
</div>