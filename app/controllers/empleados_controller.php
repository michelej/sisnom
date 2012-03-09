<?php

class EmpleadosController extends AppController {

    var $name = 'Empleados';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');
    var $uses = array('Empleado', 'Asignacion');
    var $paginate= array(        
        'Asignacion'=>array('conditions' => array('Asignacion.MODALIDAD LIKE' => 'Fijo')),        
        );
    

    function index() {
        //$this->Empleado->recursive = 0;                         

        $this->set('empleados', $this->paginate());
    }

    function add() {
        if (!empty($this->data)) {
            $this->Asignacion->data['Asignaciones'] = $this->data['Asignaciones'];
            $this->Asignacion->data['Asignaciones']['FECHA_INI'] = $this->data['Empleado']['INGRESO'];
            $this->loadModel('Cargo');
            $sueldo = $this->Cargo->find($this->Asignacion->data['Asignaciones']['cargo_id']);
            $this->Asignacion->data['Asignaciones']['SUELDO_BASE'] = $sueldo['Cargo']['SUELDO_BASE'];

            if ($this->Empleado->save($this->data['Empleado'])) {
                $this->Asignacion->data['Asignaciones']['empleado_id'] = $this->Empleado->getLastInsertID();
                if ($this->Asignacion->save($this->Asignacion->data['Asignaciones'])) {
                    $this->Session->setFlash('Empleado agregado');
                    $this->redirect(array('action' => 'index'));
                }
            }
        }
        $this->loadModel('Cargo');
        $this->loadModel('Departamento');
        $cargos = $this->Cargo->find('list');
        $departamentos = $this->Departamento->find('list');
        $this->set(compact('cargos', 'departamentos'));
    }

    function delete($id) {
        if ($this->Empleado->delete($id, true)) {
            $this->Session->setFlash('Empleado ' . $id . ' eliminado');
            $this->redirect(array('action' => 'index'));
        }
    }

    function view($id) {
        if (!$id) {
            $this->Session->setFlash(__('Empleado Invalido', true));
            $this->redirect(array('action' => 'index'));
        }
        $empleado = $this->Empleado->read(null, $id);
        $edad = $this->Empleado->Edad();
        $this->set(compact('empleado', 'edad'));
    }

    function edit($id) {
        $this->Empleado->id = $id;
        if (empty($this->data)) {
            $this->data = $this->Empleado->read();
            $cargos = $this->Empleado->Cargo->find('list');
            $this->set(compact('cargos'));
        } else {
            if ($this->Empleado->save($this->data)) {
                $this->Session->setFlash('Empleado Guardado.');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

}