<?php

class User extends AppModel {
    var $useTable = 'users';
    
    
    public function authsomeLogin($type, $credentials = array()) {
        switch ($type) {
            case 'guest':
                // You can return any non-null value here, if you don't
                // have a guest account, just return an empty array
                return array('it' => 'works');
            case 'credentials':
                $password = Authsome::hash($credentials['password']);

                // This is the logic for validating the login
                $conditions = array(
                    'User.username' => $credentials['username'],
                    'User.password' => $password,
                );
                break;
            default:
                return null;
        }

        return $this->find('first', compact('conditions'));
    }

}
?>