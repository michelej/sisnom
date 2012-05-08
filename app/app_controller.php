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
        if (empty($login) && $this->action != 'login') {
            $this->Session->write('loginRedirect', '/' . $this->params['url']['url']);
            $this->redirect('/users/login');
        }
        if (!empty($login)) {
            if (!$this->tienePermiso($this->name, $this->action)) {
                $this->redirect('/permiso_negado');
            }
        }
        unset($login);
    }

    function tienePermiso($controller, $action) {
        // Permisos y su grupo de usuarios
        // controlador=>array(acciones)
        // * = todos
        $permisos = array(
            'Todos' => array(
                'Pages', 'Users'
            ),
            'Usuario' => array(
                'Empleados' => array('index', 'view'),
                'Nominas',
            ),
            'Administrador' => array(
                '*'
            )
        );
        $grupo = Authsome::get('GRUPO');
        $flag = false;
        for ($i = 0; $i < 2; $i++) {
            foreach ($permisos[$grupo] as $key => $permiso) {
                if (is_array($permiso)) {
                    if ($key == '*') {
                        $flag = true;
                    } elseif ($key == $controller) {
                        foreach ($permiso as $value) {
                            if ($value == '*') {                                
                                $flag = true;
                            } elseif ($value == $action) {                                
                                $flag = true;
                            }
                        }
                    }
                } else {
                    if ($permiso == '*') {
                        $flag = true;
                    } elseif ($permiso == $controller) {
                        $flag = true;
                    }
                }
            }
            $grupo = 'Todos';
        }

        return $flag;
    }

}

?>