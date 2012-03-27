<?php

class DepartamentosController extends AppController {

    var $name = 'Departamentos';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');
    
    function index() {
        $this->paginate=array(
            'recursive'=>0,
            'limit'=>20,
            'order'=>array(
                'Departamento.NOMBRE'=>'asc'
            )
        );
        $data=$this->paginate();
        $this->set('departamentos', $data);        
    }

    function add() {
        if (!empty($this->data)) {            
            if ($this->Departamento->save($this->data)) {
                $this->Session->setFlash('Departamento agregado con exito','flash_success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
        }
    }

    function delete($id) {
        if ($this->Departamento->delete($id)) {
            $this->Session->setFlash('Departamento eliminado','flash_success');
            $this->redirect(array('action' => 'index'));
        }
    }
   
    function edit($id) {
        $this->Departamento->id = $id;
        if (empty($this->data)) {
            $this->data = $this->Departamento->read();                        
        } else {
            if ($this->Departamento->save($this->data)) {
                $this->Session->setFlash('Departamento Modificado','flash_success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
        }
    }

}
?>