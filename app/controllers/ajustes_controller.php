<?php

class AjustesController extends AppController {

    var $name = 'Ajustes';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');

    function index() {
        $filtro = array();
        if (!empty($this->data)) {
            if ($this->data['Fopcion'] == 1) {
                $filtro = array('Empleado.CEDULA LIKE' => $this->data['valor']);
            }
            if ($this->data['Fopcion'] == 2) {
                $filtro = array('Empleado.NOMBRE LIKE' => "%" . $this->data['valor'] . "%");
            }
            if ($this->data['Fopcion'] == 3) {
                $filtro = array('Empleado.APELLIDO LIKE' => "%" . $this->data['valor'] . "%");
            }
        }
        $this->paginate = array(
            'limit' => 20,
            'contain' => array(
                'Grupo',
                'Contrato' => array(
                    'Cargo', 'Departamento',
                    'order' => array(
                        'Contrato.FECHA_INI' => 'asc'),
                )
                ));

        $data = $this->paginate('Empleado', $filtro);
        $this->set('empleados', $data);
    }

    function edit($id = null) {
        if (empty($this->data)) {
            $this->paginate = array(
                'Ajuste' => array(
                    'conditions' => array(
                        'empleado_id' => $id),
                    'limit' => 20,
                    'order' => array(
                        'Ajuste.FECHA_INI' => 'asc')
                )
            );
            $ajustes = $this->paginate('Ajuste');
            $empleado = $this->Ajuste->Empleado->find('first', array(
                'conditions' => array(
                    'Empleado.id' => $id
                ),
                'contain' => array(
                    'Grupo'
                )
                    ));

            $this->set(compact('ajustes', 'empleado'));
        } else {
            if ($this->Contrato->save($this->data)) {
                $this->Session->setFlash('Se ha agregado con exito', 'flash_success');
                $this->redirect('edit/' . $this->data['Contrato']['empleado_id']);
            }
            $this->Session->setFlash($this->Contrato->errorMessage, 'flash_error');  // Mostrar Error
            $this->redirect('edit/' . $this->data['Contrato']['empleado_id']);
        }
    }

    function add() {
        $this->set("empleadoId", $this->params['named']['empleadoId']);
        if (!empty($this->data)) {
            if ($this->Ajuste->save($this->data['Ajuste'])) {
                $id = $this->Ajuste->getLastInsertID();
                $data = $this->Ajuste->Empleado->find('first', array(
                    'conditions' => array(
                        'Empleado.id' => $this->params['named']['empleadoId']),
                    'fields' => array(
                        'Empleado.grupo_id'),
                    'contain' => array(
                        'Grupo' => array(
                            'fields' => array(
                                'nombre'
                            )
                        ),
                        'Contrato' => array(
                            'order' => 'FECHA_INI DESC'
                        )
                    )
                        ));

                $grupo = $data['Grupo']['nombre'];
                if (empty($data['Contrato'])) {
                    $grupo = "Empleado";
                } else {
                    if ($data['Contrato']['0']['MODALIDAD'] == 'Contratado') {
                        $grupo = 'Contratados';
                    }
                }

                $asig = $this->Ajuste->Asignacion->ordenDeAsignaciones($grupo);
                $dedu = $this->Ajuste->Deduccion->ordenDeDeducciones($grupo);

                foreach ($asig as $value) {
                    $this->Ajuste->habtmAdd('Asignacion', $id, $value['id']);
                }
                foreach ($dedu as $value) {
                    $this->Ajuste->habtmAdd('Deduccion', $id, $value['id']);
                }

                $this->Session->setFlash('Ajuste agregado con exito', 'flash_success');
                $this->redirect('edit/' . $this->data['Ajuste']['empleado_id']);
            }
            if (!empty($this->Ajuste->errorMessage)) {
                $this->Session->setFlash($this->Ajuste->errorMessage, 'flash_error');
            } else {
                $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
            }
        }
    }

    function edit_ajustes($id = null) {
        if (!empty($this->data)) {
            foreach ($this->data['Asignacion'] as $key => $asignacion) {
                if ($asignacion == 1) {
                    $this->Ajuste->habtmAdd('Asignacion', $id, $key);
                }
                if ($asignacion == 0) {
                    $this->Ajuste->habtmDelete('Asignacion', $id, $key);
                }
            }
            foreach ($this->data['Deduccion'] as $key => $deduccion) {
                if ($deduccion == 1) {
                    $this->Ajuste->habtmAdd('Deduccion', $id, $key);
                } else {
                    $this->Ajuste->habtmDelete('Deduccion', $id, $key);
                }
            }
            $this->Session->setFlash('Se ha modificado con exito', 'flash_success');
            $this->redirect('edit/' . $this->data['empleado_id']);
        }

        $this->paginate = array(
            'Ajuste' => array(
                'type' => 'first',
                'conditions' => array('Ajuste.id' => $id),
                'contain' => array('Asignacion', 'Deduccion'))
        );

        $ajuste = $this->paginate('Ajuste');
        $asignaciones = $this->Ajuste->Asignacion->find('all', array('recursive' => -1));
        $deducciones = $this->Ajuste->Deduccion->find('all', array('recursive' => -1));
        $this->set(compact('ajuste', 'asignaciones', 'deducciones'));
    }

    function delete($id) {
        $empleadoid = $this->Ajuste->find('first', array(
            'conditions' => array(
                'Ajuste.id' => $id
            ),
            'fields' => array(
                'Ajuste.empleado_id')));

        if ($this->Ajuste->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('edit/' . $empleadoid['Ajuste']['empleado_id']);
        }
    }

    function view($id) {
        $ajuste = $this->Ajuste->find('first', array(
            'conditions' => array(
                'Ajuste.id' => $id
            ),
            'contain' => array(
                'Asignacion', 'Deduccion'
            )
                ));
        $asignaciones = $this->Ajuste->Asignacion->find('all', array('recursive' => -1));
        $deducciones = $this->Ajuste->Deduccion->find('all', array('recursive' => -1));
        $this->set(compact('ajuste', 'asignaciones', 'deducciones'));
    }

}

?>