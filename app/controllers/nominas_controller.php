<?php

class NominasController extends AppController {

    var $name = 'Nominas';

    function index() {
        $this->paginate = array(
            'recursive' => -1,
            'limit' => 20,
            'order' => array(
                'FECHA_INI' => 'asc'
            ),
        );

        $data = $this->paginate('Nomina');
        $this->set('nominas', $data);
    }

    function add() {
        if (!empty($this->data)) {
            if ($this->Nomina->save($this->data['Nomina'])) {
                $this->Session->setFlash('Nomina creada con exito', 'flash_success');
                $this->redirect('index');
            }
            $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
        }
    }

    function delete($id) {
        if ($this->Nomina->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('index');
        }
    }

    function edit($id = null) {
        $this->Nomina->Empleado->Behaviors->attach('Containable');
        $nomina = $this->Nomina->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'id' => $id)
                ));
        
        $fecha_ini=  formatoFechaBeforeSave($nomina['Nomina']['FECHA_INI']);
        $fecha_fin= formatoFechaBeforeSave($nomina['Nomina']['FECHA_FIN']);
        // PURA MAGIA!!!
        $this->paginate = array(
            'Empleado' => array(
                'joins' => array(
                    array(
                        'table' => 'empleados_nominas',
                        'alias' => 'EmpleadosNominas',
                        'type' => 'INNER',
                        'conditions' => array(
                            'EmpleadosNominas.empleado_id = Empleado.id'
                        )
                    )
                ),
                'limit' => 10,
                'contain' => array(
                    'Contrato' => array(
                        'Cargo','Departamento',
                        'conditions' => array(
                            'OR' => array(
                                'FECHA_FIN > ' => $fecha_ini,
                                'FECHA_FIN' => NULL,
                            ),
                            'AND' => array(
                                'FECHA_INI < ' => $fecha_fin,
                            )
                        )                        
                    )                    
                )
            )
        );
        $empleados = $this->paginate('Empleado', array('EmpleadosNominas.nomina_id' => $id));
        $this->set(compact('empleados', 'nomina'));
    }

    function generar($id) {
        $this->Nomina->generarNomina($id);
        $this->redirect('edit/' . $id);
    }

}

?>
