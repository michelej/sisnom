<?php

class NominasController extends AppController {

    var $name = 'Nominas';

    function index() {
        $filtro = array();
        if (!empty($this->data)) {
            if (!empty($this->data['AÑO']) && empty($this->data['Fopcion'])) {
                $filtro = array('Nomina.FECHA_INI LIKE' => "%" . $this->data['AÑO'] . "%");
            }
            if (!empty($this->data['Fopcion']) && empty($this->data['AÑO'])) {
                $filtro = array('MONTH(Nomina.FECHA_INI)' => $this->data['Fopcion']);
            }
            if (!empty($this->data['Fopcion']) && !empty($this->data['AÑO'])) {
                $filtro = array('MONTH(Nomina.FECHA_INI)' => $this->data['Fopcion'], 'Nomina.FECHA_INI LIKE' => "%" . $this->data['AÑO'] . "%");
            }
        }
        $this->paginate = array(
            'recursive' => -1,
            'limit' => 20,
            'order' => array(
                'FECHA_INI' => 'desc'
            ),
        );

        $data = $this->paginate('Nomina', $filtro);
        $this->set('nominas', $data);
    }

    function add() {
        if (!empty($this->data)) {
            if ($this->Nomina->save($this->data['Nomina'])) {
                $this->Session->setFlash('Nomina creada con exito', 'flash_success');
                $this->Nomina->generarNomina($this->Nomina->getLastInsertId());
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
        // TODO: Verificar si existen cambios depues de creada la nomina ??????
        // quitar esto de aqui
        $this->Nomina->Empleado->Behaviors->attach('Containable');
        $nomina = $this->Nomina->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'id' => $id)
                ));

        $fecha_ini = formatoFechaBeforeSave($nomina['Nomina']['FECHA_INI']);
        $fecha_fin = formatoFechaBeforeSave($nomina['Nomina']['FECHA_FIN']);
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
                        'Cargo', 'Departamento',
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
        $this->Nomina->Empleado->Behaviors->attach('Containable');
        $nomina = $this->Nomina->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'id' => $id)
                ));

        $fecha_ini = formatoFechaBeforeSave($nomina['Nomina']['FECHA_INI']);
        $fecha_fin = formatoFechaBeforeSave($nomina['Nomina']['FECHA_FIN']);
        // PURA MAGIA!!!
        $conditions = array(
            'joins' => array(
                array(
                    'table' => 'empleados_nominas',
                    'alias' => 'EmpleadosNominas',
                    'type' => 'INNER',
                    'conditions' => array(
                        'EmpleadosNominas.empleado_id = Empleado.id',
                        'EmpleadosNominas.nomina_id' => $id
                    )
                )
            ),
            'limit' => 10,
            'contain' => array(
                'Contrato' => array(
                    'Cargo', 'Departamento',
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
        );
        $empleados = $this->Nomina->Empleado->find('all', $conditions);        
        $this->set('empleados', $empleados);
        $this->render('pantalla', 'nomina');
    }

}

?>
