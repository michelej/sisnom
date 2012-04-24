<?php

class ReportesController extends AppController {

    var $name = 'Reportes';
    var $uses = array('Empleado', 'Contrato');

    function empleados_fijos() {
        $this->paginate = array(
            'Contrato' => array(
                'limit' => 20,
                'conditions' => array(
                    'AND' => array(
                        'MODALIDAD' => 'Fijo',
                        'FECHA_FIN' => NULL),
                ),
                'contain' => array(
                    'Cargo','Departamento',
                    'Empleado' => array(
                        'Grupo'
                    )
                )
            )
        );

        $data = $this->paginate('Contrato');
        $this->set('empleados', $data);
    }

    function empleados_contratados() {
        $this->paginate = array(
            'Contrato' => array(
                'limit' => 20,
                'conditions' => array(
                    'AND' => array(
                        'MODALIDAD' => 'Contratado',
                        'FECHA_FIN' => NULL),
                ),
                'contain' => array(
                    'Cargo','Departamento',
                    'Empleado' => array(
                        'Grupo'
                    )
                )
            )
        );

        $data = $this->paginate('Contrato');
        $this->set('empleados', $data);
    }

}

?>