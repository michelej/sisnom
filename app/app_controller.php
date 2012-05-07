<?php

class AppController extends Controller {

    public $components = array(
        'Authsome.Authsome' => array(
            'model' => 'User'
        ),
        'Session'
    );

    function beforeFilter() {
        $login = $this->Authsome->get();
        $controller = $this->name;
        $action = $this->action;
        if (empty($login) && $this->action != 'login') {
            $this->Session->write('loginRedirect', '/' . $this->params['url']['url']);
            $this->redirect('/users/login');
        }

        if (!empty($login)) {
            if (!$this->tienePermiso($controller, $action)) {
                $this->redirect('/permiso_negado');
            }
        }
    }

    function tienePermiso($controller, $action) {
        $permisos = array(
            'Todos'=>array(
              'Pages','Users'  
            ),
            'Usuario' => array(
                'Empleados'
            ),
            'Administrador' => array(
                '*'
            )
        );

        //debug($controller);
        //debug($action);
        $grupo = Authsome::get('GRUPO');        
        $flag=false;
        foreach ($permisos[$grupo] as $value) {
            if($value=='*'){
                $flag=true;
            }elseif ($value==$controller) {
                $flag=true;
            }
        }
        foreach ($permisos['Todos'] as $value) {
            if($value=='*'){
                $flag=true;
            }elseif ($value==$controller) {
                $flag=true;
            }
        }
        
        return $flag;
    }

}

?>