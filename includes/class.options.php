<?PHP
    // The difference between this and settings is that
    // Options is for site variables,
    // Settings is for client settings.
    class Options
    {   
        private static $me;

        public $id;
        public $option;
        public $value;        
        
        public function __construct()
        {
            $this->id        = null;
            $this->option    = null;
            $this->value     = null;
        }        
        
        public static function groupAdd($group, $desc='')
        {
            $db = Database::getDatabase();
            $db->query('REPLACE INTO
                       options_groups
                       (`group`, `desc`)
                       VALUES
                       (:group:, :desc:)',
                       array('group' => $group, 'desc' => $desc));  
        } /* ALIAS */ 
        public static function groupSet($group, $desc='')
        {
            return Options::groupAdd($group, $desc);  
        }
        
        
        public static function groupRemove($group)
        {
            $db = Database::getDatabase();
            $db->query('DELETE FROM options_groups WHERE `group`=:group:', array('group' => $group));
        } /* ALIAS */ 
        public static function groupDelete($group)
        {
            return Options::groupRemove($group);  
        }
        
        public static function groups()
        {
            $db = Database::getDatabase(); 
            $db->query('SELECT `group`, `desc` FROM options_groups');            
            if($db->hasRows())
                return $db->getRows();
            else
                return false;
        }
        
        public static function types()
        {
            $db = Database::getDatabase();
            $db->query("SHOW COLUMNS FROM options LIKE 'type'");
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
        
        // This function gets a list of the information, can be refined to a type or a group
        public static function getList($type=false, $group=false, $sql='')
        {
            $array = array();
            $db = Database::getDatabase();
            
            if ($type!== false)            
                $db->query('SELECT `key`, `value`, `type`, `group` FROM options WHERE `type`=:type: ' . $sql, array('type' => $type));
            elseif ($group !== false)
                $db->query('SELECT `key`, `value`, `type`, `group` FROM options WHERE `group`=:group: ' . $sql, array('group' => $group));
            else
                $db->query('SELECT `key`, `value`, `type`, `group` FROM options ' . $sql);
            
            if($db->hasRows())
            {
                foreach($db->getRows() as $row)
                {
                    if (isset($row['value']))
                    {
                        $array[$row['key']]['value'] = $row['value'];
                    } else  {
                        $array[$row['key']]['value'] = '';
                    }
                    
                    if (isset($row['type']))
                    {                        
                        $array[$row['key']]['type'] = $row['type'];
                    } else {
                        $array[$row['key']]['type'] = ''; 
                    }
                    
                    if (isset($row['group']))
                    {  
                        $array[$row['key']]['group'] = $row['group'];
                    } else {
                        $array[$row['key']]['group'] = '';  
                    }
                }
                return $array;
            } else {
                return $array;
            }
        }
        
        // This is a special function, when you once to add an options but once and not if it changes.
        // This will be used in the Options.inc.php and Install.inc.php
        public static function addOnce($option, $value='', $type=false, $group=false)
        {
            if (!Options::exists($option)){
                Options::add($option, $value, $type, $group);
            }
        }        
        
        // Will generate an array with the available 
        public static function all($group=false)
        {
            $array = array();
            $db = Database::getDatabase();
            if ($group !== false)
                $db->query('SELECT `key` FROM options WHERE `group`=:group:', array('group' => $group));
            else 
                $db->query('SELECT `key` FROM options');
                
            if($db->hasRows())
            {
                foreach($db->getRows() as $row)
                {                    
                    $array[] .= "$" . $row['key'];
                }
                return $array;
            } else {
                return false;
            }
        } /* ALIAS */         
        public static function available($group=false)
        {
            return Options::all($group);
        }
        
        // Get the value with either get or value
        public static function value($option, $group=false, $type=false)
        {            
            $db = Database::getDatabase();
            $db->query('SELECT * FROM options WHERE `key`=:key:', array('key' => $option));
         
            if($db->hasRows())
            {
                $row = $db->getRow();
                return $row['value'];
            } else {
                return false;
            }
        } /* ALIAS */          
        public static function get($option)
        {
            return Options::value($option);
        }
        
        public static function exists($option)
        {
            $db = Database::getDatabase();    
            $db->query('SELECT * FROM options WHERE `key`=:key:', array('key' => $option));
            if (!$db->hasRows())
                return false; 
            else
                return true;
        }
        
        // Add the option
        public static function add($option, $value='', $type=false, $group=false)
        {            
            $db = Database::getDatabase();
            /*if ($value == '') $value = Options::value($option);*/
            if ($type == false) $type = Options::type($option);
            if ($group == false) $group = Options::group($option);
            if (Options::exists($option))
            {
                $db->query('UPDATE
                           options
                           SET
                           `value`=:value:, `type`=:type:, `group`=:group:
                           WHERE
                           `key`=:key:',
                           array('key' => $option, 'value' => $value, 'type' => $type, 'group' => $group));
                /*echo "Update option";*/
            } else {
                $db->query('INSERT INTO
                        options
                        (`key`, `value`, `type`, `group`)
                        VALUES
                        (:key:, :value:, :type:, :group:)',
                        array('key' => $option, 'value' => $value, 'type' => $type, 'group' => $group));
                /*echo "Inserted new option";*/
            }
            return $db->affectedRows();           
           
        } /* ALIAS */
        public static function set($option, $value='', $type=false, $group=false)
        {
            return Options::add($option, $value, $type, $group);
        }
        
        // Set the group of a partucular option
        public static function group($option, $groupName=false)
        {
            if ($groupName == false)
            {
                $db = Database::getDatabase();
                $db->query('SELECT `group` FROM options WHERE `key`=:key:', array('key' => $option));
                $row = $db->getRow();
                return $row['group'];
            } else {
                $db = Database::getDatabase();
                $db->query('UPDATE
                           options
                           SET
                           `group`=:group:
                           WHERE
                           `key`=:key:',
                           array('key' => $option, 'group' => $groupName));
                return $db->affectedRows();    
            }      
        }
        
        // Set the type of a particular option
        public static function type($option, $type=false)
        {
            if ($type == false)
            {
                $db = Database::getDatabase();
                $db->query('SELECT `type` FROM options WHERE `key`=:key:', array('key' => $option));
                $row = $db->getRow();
                return $row['type'];
            } else {
                $db = Database::getDatabase();
                $db->query('UPDATE
                           options
                           SET
                           `type`=:type:
                           WHERE
                           `key`=:key:',
                           array('key' => $option, 'type' => $type));
                return $db->affectedRows();
            }
        } 
        
        // Remove a options from the DB
        public static function remove($option)
        {
            $db = Database::getDatabase();
            $db->query('DELETE FROM options WHERE `key`=:key:', array('key' => $option));
        }
        
        
/* User specific options */
        // Get the value with either get or value
        public static function userValue($userId, $option)
        {            
            $db = Database::getDatabase();
            $db->query('SELECT * FROM options_users WHERE `user_id`=:user_id: and `key`=:key:', array('user_id'=>$userId, 'key' => $option));
         
            if($db->hasRows())
            {
                $row = $db->getRow();
                return $row['value'];
            } else {                
                return false;
            }
        } /* ALIAS */          
        public static function userGet($userId, $option)
        {
            return Options::userValue($userId, $option);
        }
        
        // Check if the user option is already set or not
        public static function userExists($userId, $option)
        {
            $db = Database::getDatabase();    
            $db->query('SELECT * FROM options_users WHERE `user_id`=:user_id: and `key`=:key:', array('user_id'=>$userId, 'key' => $option));
            if (!$db->hasRows())
                return false; 
            else
                return true;
        }
        
        // Add the option
        public static function userAdd($userId, $option, $value='')
        {            
            $db = Database::getDatabase();            
            if (Options::userExists($userId, $option))
            {
                $db->query('UPDATE
                           options_users
                           SET
                           `value`=:value:
                           WHERE
                           `key`=:key: and `user_id`=:user_id:',
                           array('key' => $option, 'value' => $value, 'user_id' => $userId));
                /*echo "Update option";*/
            } else {
                $db->query('INSERT INTO
                        options_users
                        (`user_id`, `key`, `value`)
                        VALUES
                        (:user_id:, :key:, :value:)',
                        array('user_id' => $userId, 'key' => $option, 'value' => $value));
                /*echo "Inserted new option";*/
            }
            return $db->affectedRows();           
           
        } /* ALIAS */
        public static function userSet($userId, $option, $value='')
        {
            return Options::userAdd($userId, $option, $value);
        }        
        
/* User specific options */       
        
        
    }
?>