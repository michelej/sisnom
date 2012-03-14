<?php

class ContratosController extends AppController {

    var $name = 'Contratos';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');
    

    function index() {
        
        $this->set('empleados', $this->paginate('Empleado'));
    }

    function add() {
        if (!empty($this->data)) {            
            if ($this->Cargo->save($this->data)) {
                $this->Session->setFlash('Cargo agregado');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    function delete($id) {
        $empleadoid=$this->Contrato->find('first',array('conditions'=>array('Contrato.id'=>$id),'fields'=>array('Contrato.empleado_id')));
        if ($this->Contrato->delete($id)) {
            $this->Session->setFlash('Contrato ' . $id . ' eliminado');            
            $this->redirect('edit/'.$empleadoid['Contrato']['empleado_id']);
        }
    }

    function edit($id=null) {
        if (empty($this->data)) {            
            $this->Contrato->Empleado->recursive = -1;
            
            $contratos = $this->Contrato->find('all',array(
                'conditions'=>array('empleado_id'=>$id),
                'order'=>'Contrato.FECHA_INI',
                'recursive'=>'0',
                ));
            
            $empleado = $this->Contrato->Empleado->findById($id);
            $cargos= $this->Contrato->Cargo->find('list');
            $departamentos= $this->Contrato->Departamento->find('list');            
            $this->set(compact('contratos', 'empleado','cargos','departamentos'));
        } else {            
            if ($this->Contrato->save($this->data)) {
                $this->Session->setFlash('Contrato Guardado.');                
                $this->redirect('edit/'.$this->data['Contrato']['empleado_id']);
            }
            $this->Session->setFlash('Error en las FECHAS');  // Mostrar Error
            $this->redirect('edit/'.$this->data['Contrato']['empleado_id']);
        }
    }   

}

?>
