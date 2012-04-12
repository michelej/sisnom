<?php

class UsersController extends AppController {
    
    var $name = 'Users';    
    
    public function login() {
        $this->layout = 'login';
        if (empty($this->data)) {
            return;
        }        
        $user = Authsome::login($this->data['User']);

        if (!$user) {
            $this->Session->setFlash('Unknown user or wrong password');
            return;
        }

        $user = Authsome::get();
        debug($user);
    }

}

?>