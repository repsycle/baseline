<?php
$installRan = false; 
// This will check whether the tables and columns exists and create them if they do not exist.

// This magical function will do a number of things. 
// It checks whether the column already exists, if not then it creates it.
// If it does exist, it checks whether the parameters of the columns matches that of specified and then alters it. 
function addColumn($table, $column, $options, $defaults) {
    
    $checkColumn = str_replace('`', '', $column);
       
    // The mysql_query we build to view the column information.
    $query = mysql_query('SHOW COLUMNS FROM ' . $table .  ' like "' . $checkColumn . '"') or die ("You want me to add a column, but the table does not exists.");
     
    // The variables used to loop through the entire result for a match 
    $found = 0;
    $correctColumns = 0;    
       
   // Actuall loop to run through the columns
   while(list($field, $type, $null, $key, $default, $extra) = mysql_fetch_array($query)) {
      
      // If a match is found mark it for after the loop processing.
      if ($field == $checkColumn) {    
        $found = $found + 1;
            
        // We found a matching column cool, now we need to check the type and mark it for post loop processing if needed. 
        if ($type !== $options){
           $correctColumns = $correctColumns + 1;
        }
      }       
   }
  
   // Post loop processing begins here
   if ($found > 0) {
    
      // So we found the column, lets check if it needs modification. 
      if ($correctColumns > 0) {
      
        // Run the modification query so we set it to the type we want. 
        $query = "ALTER TABLE $table MODIFY $column $options $defaults";
        //echo $query;
        mysql_query($query);          
        //echo("UPDATE!, Modified column $column in the $table table ERROR: " . mysql_error() . "<br />");
      }
        
    // No column was found, now we will need to add it. 
    } else {
        
        // The column add query. 
        $query = "ALTER TABLE $table ADD COLUMN $column $options $defaults";
        mysql_query($query);          
        //echo("UPDATE! Added column $column to the $table table ERROR: " . mysql_error() . "<br />");
    }  
}

// This function will create the table if it does not exits
function createTable($table, $column, $primary, $auto, $collate='') {
   if ($table !== '') {
      
      $addAuto = "";
      $addPrim = "";
      
      // Check if it's a primary key
      if ($primary == True) {
         $addPrim = " PRIMARY KEY";
      }
      
      // Check if it's an auto increment
      if ($auto == True) {
        $addAuto = " AUTO_INCREMENT";
      }
      
      $query = "CREATE TABLE IF NOT EXISTS " . $table . " (" . $column . $addPrim . $addAuto . ")" . $collate;
      //echo $query;
      $result = mysql_query($query) or die ("Could not create table " . $table);
      //echo("UPDATE!, Added table " . $table . mysql_error());
   }
}

// If no tales exists, then we need to create as a minimum the options table
$db = Database::getDatabase();
$db->query('SHOW TABLES like "options"');
if(!$db->hasRows())
{
    $query = "CREATE TABLE `options` (
            `key` varchar(255) NOT NULL PRIMARY KEY,
            `value` varchar(255) NOT NULL)";
    mysql_query($query) or die ('Could not create the options table, please ensure the mysql details are correct. SQL ERROR:' . mysql_error());  
}

clearstatcache(); // Clear the stats
$lastEdit = stat('includes/install.inc.php');
$lastEdit = $lastEdit['mtime'];
$fileSize = filesize('includes/install.inc.php');

// Get the options from the db, will by default have a false value
$dbInstallDate = Options::get('installModified');
$dbInstallFilesize = Options::get('installFilesize');

// Force the filesize and modification date to strings to be able to compare it with the DB
settype($lastEdit, 'string');
settype($fileSize, 'string');

// Update version based on the date and / or filesize. This will also work if the db is empty
if (($dbInstallDate !== $lastEdit)
or ($dbInstallFilesize !== $fileSize))
{
 
// Create the activation table and add the columns   
createTable("activation", "id INT(255) NOT NULL", True, True);
addColumn("activation", 'user', "int(255)", "default 0");
addColumn("activation", 'code', "varchar(50)", "default ''");
addColumn("activation", 'active', "tinyint(1)", "default 0");

// Create the sessions table
createTable("sessions", "id varchar(255) NOT NULL", True, False);
addColumn('sessions', 'data', "text", "default NULL");
addColumn('sessions', 'updated_on', "int(10)", "default 0");

// Create the url_cache table
createTable("url_cache", "url varchar(255) NOT NULL", True, false, "ENGINE='MyISAM'");
addColumn("url_cache", 'dt_refreshed', "datetime", "default NULL");
addColumn("url_cache", 'dt_expires', "datetime", "default NULL");
addColumn("url_cache", 'data', "text", "default NULL");

// Create the users table
createTable("users", "id int(11) NOT NULL", True, True);
addColumn("users", 'nid', "varchar(32)", "default NULL");
addColumn("users", 'username', "varchar(65)", "default NULL");
addColumn("users", 'password', "varchar(65)", "default NULL");
addColumn("users", 'level', "ENUM('free', 'user', 'admin', 'moderator')", "default 'user'"); 
addColumn("users", 'email', "varchar(65)", "default NULL");


// Add the options table columns
addColumn("options", '`type`', "ENUM('input', 'date', 'bool', 'hidden', 'textarea')", "default 'input'");
addColumn("options", '`group`', "varchar(65)", "default 'Miscellaneous'");

// This table will be where the settings are kept
createTable("options_groups", "`group` varchar(65) NOT NULL", True, False);
addColumn("options_groups", '`desc`', "varchar(65)", "default NULL");

// This is where we will add the clien'ts ability to add values to the settings.
createTable("options_users", "user_id int(11) NOT NULL", false, false);
addColumn("options_users", '`key`', "varchar(65)", "default NULL");
addColumn("options_users", 'value', "varchar(65)", "default NULL");  

$defaultUser = 'root';
$defaultPass = 'root';
$adminEmail = 'iam@thatguy.co.za';
// Create the default system user
Auth::createNewUser($defaultUser, $defaultPass, $adminEmail); // Add a user, when the username does not exist
Auth::changeGroup($defaultUser, 'admin'); // Promote the user to administrator by running the following snippet*/
$getId = Auth::userId($defaultUser);
Activation::generate($getId, 20);
Activation::activate($getId);

// Set the timestamp and filesize 
Options::add('installModified', $lastEdit, 'hidden', 'Miscellaneous'); // Do not modify these, they need to be static
Options::add('installFilesize', $fileSize, 'hidden', 'Miscellaneous'); // Do not modify these, they need to be static*/

$installRan = true;

} // End of installation action
?>