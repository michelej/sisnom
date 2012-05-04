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
            $controller=$this->name;
            $action=$this->action;
            $this->Session->write('loginRedirect','/'.$this->params['url']['url']);
            $this->redirect('/users/login');
        }                
    }

}

?>