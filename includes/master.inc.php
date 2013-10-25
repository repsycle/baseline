<?PHP
    // Application flag
    define('SPF', true);

    // https://twitter.com/#!/marcoarment/status/59089853433921537
    date_default_timezone_set('Africa/Johannesburg');

    // Determine our absolute document root
    define('DOC_ROOT', realpath(dirname(__FILE__) . '/../'));

    // Global include files
    require DOC_ROOT . '/includes/functions.inc.php';  // spl_autoload_register() is contained in this file
    require DOC_ROOT . '/includes/class.dbobject.php'; // DBOBject...
    require DOC_ROOT . '/includes/class.objects.php';  // and its subclasses        
    
    // Lets start the function to get the execution time
    $time_start = microtime_float();

    // Fix magic quotes
    if(get_magic_quotes_gpc())
    {
        $_POST    = fix_slashes($_POST);
        $_GET     = fix_slashes($_GET);
        $_REQUEST = fix_slashes($_REQUEST);
        $_COOKIE  = fix_slashes($_COOKIE);
    }

    // Load our config settings
    $Config = Config::getConfig();
    
    // Run the options and install functions, this would be if there are no information present in the db 
    require DOC_ROOT . '/includes/install.inc.php';  // Check for installation and create the tables needed
    require DOC_ROOT . '/includes/options.inc.php';  // Get the options from the DB  

    // Store session info in the database?
    if(Config::get('useDBSessions') === true)
        DBSession::register();

    // Initialize our session
    session_name('spfs');
    session_start();

    // Initialize current user
    $Auth = Auth::getAuth();    
    
    // This dynamically creates the options variables except for the User Settings
    foreach(Options::getList(false, false, "WHERE `group`!='User Settings'") as $option=>$values)
    {
        ${$option} = $values['value'];
    }

    // This dynamically creates the User Variables
    if($Auth->loggedIn()){
        foreach(Options::getList(false, 'User Settings') as $option=>$val)
        {
            ${$option} = Options::userGet($Auth->id, $option);           
        }
    }
    
    // Object for tracking and displaying error messages
    $Error = Error::getError();
?>