<?php

class EmpleadosController extends AppController {

    var $name = 'Empleados';    
    var $components = array('RequestHandler');

    function index() {
        $this->Empleado->recursive = 0;
        $this->set('empleados', $this->paginate());

        $this->paginate = array(
            'limit' => '20',
            'order' => array(
                'Empleado.nombre' => 'ASC',                
            )
        );
        $empleado = $this->paginate('Empleado');
        $this->set('empleados', $empleado);
    }

}