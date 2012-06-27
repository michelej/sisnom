<?php

class User extends AppModel {
    
    var $name='User';
    var $displayField = 'USERNAME';
    var $useTable = 'users';
            
    public function authsomeLogin($type, $credentials = array()) {
        switch ($type) {
            case 'guest':
                // You can return any non-null value here, if you don't
                // have a guest account, just return an empty array
                return array();
            case 'credentials':
                //$password = Authsome::hash($credentials['password']);
                $password = md5($credentials['PASSWORD']);

                // This is the logic for validating the login
                $conditions = array(
                    'User.USERNAME' => $credentials['USERNAME'],
                    'User.PASSWORD' => $password,
                );
                break;
            default:
                return null;
        }

        return $this->find('first', compact('conditions'));
    }

}
?>