<?php

class AppController extends Controller {

    public $components = array(
        'Authsome.Authsome' => array(
            'model' => 'User'
        ),
        'Session'
    );
    
    function beforeFilter(){
        $login = $this->Authsome->get();                
        if(empty($login) && $this->action!='login'){
            $this->Session->write('loginRedirect','/'.$this->name.'/'.$this->action);
            $this->redirect('/users/login');
        }                
    }

}

?>