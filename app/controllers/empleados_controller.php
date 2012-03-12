<?php

class EmpleadosController extends AppController {

    var $name = 'Empleados';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');
    var $uses = array('Empleado', 'Contrato');
    
    function index() {
        $this->Empleado->recursive = 1;        
        $data=$this->paginate('Contrato', array('Contrato.FECHA_FIN' => null));        
        $this->set('empleados',$data);
    }

    function add() {
        if (!empty($this->data)) {            
            $this->Contrato->data['Contratos'] = $this->data['Contratos'];
            $this->Contrato->data['Contratos']['FECHA_INI'] = $this->data['Empleado']['INGRESO'];
            $this->loadModel('Cargo');
            $sueldo = $this->Cargo->find($this->Contrato->data['Contratos']['cargo_id']);
            $this->Contrato->data['Contratos']['SUELDO_BASE'] = $sueldo['Cargo']['SUELDO_BASE'];

            if ($this->Empleado->save($this->data['Empleado'])) {
                $this->Contrato->data['Contratos']['empleado_id'] = $this->Empleado->getLastInsertID();
                if ($this->Contrato->save($this->Contrato->data['Contratos'])) {
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
        $empleado=$this->Empleado->Contrato->find('first',array(
            'conditions'=>array('Contrato.FECHA_FIN'=>null,'Contrato.empleado_id'=>$id)));                
        $edad = $this->Empleado->Edad($empleado['Empleado']['FECHANAC']);
        $this->set(compact('empleado', 'edad'));
    }

    function edit($id) {
        $this->Empleado->id = $id;
        
        if (empty($this->data)) {                                    
            $this->data = $this->Empleado->Contrato->find('first',array('conditions'=>array('Contrato.FECHA_FIN'=>null)));
            //echo debug($this->data);
        } else {
            if ($this->Empleado->save($this->data)) {
                $this->Session->setFlash('Empleado Guardado.');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

}