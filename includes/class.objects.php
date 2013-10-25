<?PHP
    // Stick your DBOjbect subclasses in here (to help keep things tidy).

    class User extends DBObject
    {
        public function __construct($id = null)
        {
            parent::__construct('users', array('nid', 'username', 'password', 'level', 'email'), $id);
        }
    }
    
    class Users extends DBObject
    {
        public function __construct($id = null)
        {
            parent::__construct('users', array('username', 'level', 'email'));
        }
        
        public static function types()
        {
            $db = Database::getDatabase();
            $db->query("SHOW COLUMNS FROM users LIKE 'level'");
            $row = $db->getRow();
            $type = $row['Type'];            
            preg_match('/enum\((.*)\)$/', $type, $matches);
            $vals = explode(',', $matches[1]);
            if (is_array($vals))
            {                
                return str_replace("'", '', $vals);
            } else {
                return false;
            }          
        }
    }