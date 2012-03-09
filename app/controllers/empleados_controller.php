<?php

class EmpleadosController extends AppController {

    var $name = 'Empleados';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');
    var $uses = array('Empleado', 'Asignacion');
    
    function index() {
        $this->Empleado->recursive = 1;
        $data=$this->paginate('Asignacion', array('Asignacion.FECHA_FIN' => null));
        $this->set('empleados',$data);
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
        $empleado=$this->Empleado->Asignacion->find('first',array(
            'conditions'=>array('Asignacion.FECHA_FIN'=>null,'Asignacion.empleado_id'=>$id)));                
        $edad = $this->Empleado->Edad($empleado['Empleado']['FECHANAC']);
        $this->set(compact('empleado', 'edad'));
    }

    function edit($id) {
        $this->Empleado->id = $id;
        
        if (empty($this->data)) {                                    
            $this->data = $this->Empleado->Asignacion->find('first',array('conditions'=>array('Asignacion.FECHA_FIN'=>null)));
            echo debug($this->data);
        } else {
            if ($this->Empleado->save($this->data)) {
                $this->Session->setFlash('Empleado Guardado.');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

}