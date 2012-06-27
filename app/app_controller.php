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
                'Pages',
                'Users'=>array('login','logout','cambiar_password')
            ),
            'Usuario' => array(
                'Empleados' => array('index', 'view'),
                'Nominas'=>array('index','edit','mostrar'),
                'Cestatickets'=>array('index','edit','mostrar'),
                'Cargos'=>array('index'),
                'Localizaciones'=>array('index'),
                'Departamentos'=>array('index'),
                'Ausencias'=>array('index'),
                'HorasExtras'=>array('index'),
                'Asignaciones'=>array('index'),
                'Deducciones'=>array('index'),
                'Reportes'
                
            ),
            'Operador'=>array(
               '*' 
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