<?php

class ReportesController extends AppController {

    var $name = 'Reportes';
    var $uses = array('Empleado', 'Contrato', 'Recibo');
   
    function empleados_fijos() {
        $grupo = "Empleado";
        $modalidad = "Fijo";

        $ids = $this->Empleado->Grupo->find('all', array(
            'conditions' => array(
                'NOMBRE' => $grupo
            ),
            'contain' => array(
                'Empleado' => array(
                    'fields' => array(
                        'id'
                    )
                )
            )
                ));
        $id_empleados = Set::extract('/Empleado/id', $ids);

        $ids = $this->Contrato->find('all', array(
            'conditions' => array(
                'MODALIDAD' => $modalidad,
                'empleado_id' => $id_empleados),
            'contain' => array(
                'Empleado' => array(
                    'fields' => array(
                        'id')
                )
            )
                ));

        $id_empleados = Set::extract('/Empleado/id', $ids);

        $this->paginate = array(
            'Empleado' => array(
                'limit' => 20,
                'conditions' => array(
                    'Empleado.id' => $id_empleados,
                ),
                'contain' => array(
                    'Contrato' => array(
                        'order' => array('Contrato.FECHA_INI' => 'asc'),
                        'Cargo', 'Departamento'
                    )
                )
            )
        );

        $data = $this->paginate('Empleado');
        $this->set('empleados', $data);
    }
    
    function obreros_fijos() {
        $grupo = "Obrero";
        $modalidad = "Fijo";

        $ids = $this->Empleado->Grupo->find('all', array(
            'conditions' => array(
                'NOMBRE' => $grupo
            ),
            'contain' => array(
                'Empleado' => array(
                    'fields' => array(
                        'id'
                    )
                )
            )
                ));
        $id_empleados = Set::extract('/Empleado/id', $ids);

        $ids = $this->Contrato->find('all', array(
            'conditions' => array(
                'MODALIDAD' => $modalidad,
                'empleado_id' => $id_empleados),
            'contain' => array(
                'Empleado' => array(
                    'fields' => array(
                        'id')
                )
            )
                ));

        $id_empleados = Set::extract('/Empleado/id', $ids);

        $this->paginate = array(
            'Empleado' => array(
                'limit' => 20,
                'conditions' => array(
                    'Empleado.id' => $id_empleados,
                ),
                'contain' => array(
                    'Contrato' => array(
                        'order' => array('Contrato.FECHA_INI' => 'asc'),
                        'Cargo', 'Departamento'
                    )
                )
            )
        );

        $data = $this->paginate('Empleado');
        $this->set('empleados', $data);
    }

    function contratados() {        
        $modalidad = "Contratado";
                
        $ids = $this->Contrato->find('all', array(
            'conditions' => array(
                'MODALIDAD' => $modalidad),
            'contain' => array(
                'Empleado' => array(
                    'fields' => array(
                        'id')
                )
            )
                ));        
        $id_empleados = Set::extract('/Empleado/id', $ids);

        $this->paginate = array(
            'Empleado' => array(
                'limit' => 20,
                'conditions' => array(
                    'Empleado.id' => $id_empleados,
                ),
                'contain' => array(
                    'Contrato' => array(
                        'order' => array('Contrato.FECHA_INI' => 'asc'),
                        'Cargo', 'Departamento'
                    )
                )
            )
        );

        $data = $this->paginate('Empleado');
        $this->set('empleados', $data);
    }

}

?>