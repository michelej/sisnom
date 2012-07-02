<?php

class ContratosController extends AppController {

    var $name = 'Contratos';
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
        $this->Contrato->Empleado->Behaviors->attach('Containable');
        $this->paginate = array(
            'limit' => 20,
            'contain' => array(
                'Contrato' => array(
                    'Cargo', 'Departamento',
                    'conditions' => array(
                        'FECHA_FIN' => NULL),
                )
                ));

        $data = $this->paginate('Empleado', $filtro);
        $this->set('empleados', $data);
    }

    function delete($id) {
        $empleadoid = $this->Contrato->find('first', array('conditions' => array('Contrato.id' => $id), 'fields' => array('Contrato.empleado_id')));
        if ($this->Contrato->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('edit/' . $empleadoid['Contrato']['empleado_id']);
        }
    }

    function edit($id = null) {
        if (empty($this->data)) {
            $this->paginate = array(
                'Contrato' => array(
                    'conditions' => array(
                        'empleado_id' => $id),
                    'limit' => 20,
                    'order' => array(
                        'Contrato.FECHA_INI' => 'asc')
                )
            );
            $contratos = $this->paginate('Contrato');
            $empleado = $this->Contrato->Empleado->find('first', array(
                'conditions' => array(
                    'Empleado.id' => $id
                ),
                'contain' => array(
                    'Grupo'
                )
                    ));

            $this->set(compact('contratos', 'empleado'));
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
        if (!empty($this->data)) {
            if ($this->Contrato->save($this->data)) {
                $this->Session->setFlash('Contrato agregado con exito', 'flash_success');
                $this->redirect('edit/' . $this->data['Contrato']['empleado_id']);
            }
            if (!empty($this->Contrato->errorMessage)) {
                $this->Session->setFlash($this->Contrato->errorMessage, 'flash_error');
            } else {
                $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
            }
        }
        $cargos = $this->Contrato->Cargo->find('list');
        $departamentos = $this->Contrato->Departamento->find('list',array(
            'conditions'=>array(
                'NOT'=>array(
                    'programa_id'=>null
                )
            )
        ));
        $this->set("empleadoId", $this->params['named']['empleadoId']);
        $this->set(compact('cargos', 'departamentos'));
    }

    function finalizar($id = null) {
        $contrato = $this->Contrato->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'id' => $id
            )
                ));
        if (!empty($this->data)) {
            $fecha_fin = $this->data['Contrato']['FECHA_FIN'];
            $this->data = $contrato;
            $this->data['Contrato']['FECHA_FIN'] = $fecha_fin;
            if ($this->Contrato->save($this->data)) {
                $this->Session->setFlash('Contrato agregado con exito', 'flash_success');
                $this->redirect('edit/' . $this->data['Contrato']['empleado_id']);
            }
            if (!empty($this->Contrato->errorMessage)) {
                $this->Session->setFlash($this->Contrato->errorMessage, 'flash_error');
            } else {
                $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
            }
        }
        $this->set('contrato', $contrato);
    }

}

?>