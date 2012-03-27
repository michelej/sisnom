<?php

class CargosController extends AppController {

    var $name = 'Cargos';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');    

    function index() {
        $this->paginate=array(
            'recursive'=>0,
            'limit'=>20,
            'order'=>array(
                'Cargo.NOMBRE'=>'asc'
            )
        );
        
        $data=$this->paginate();        
        $this->set('cargos', $data);
    }

    function add() {
        if (!empty($this->data)) {            
            if ($this->Cargo->save($this->data)) {
                $this->Session->setFlash('Cargo agregado con exito','flash_success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash('Existen errores corrigalos antes de continuar','flash_error');
        }
    }

    function delete($id) {
        if ($this->Cargo->delete($id)) {
            $this->Session->setFlash('Cargo eliminado','flash_success');
            $this->redirect(array('action' => 'index'));
        }
    }

    function edit($id) {
        $this->Cargo->id = $id;
        if (empty($this->data)) {
            $this->data = $this->Cargo->read();
        } else {
            if ($this->Cargo->save($this->data)) {
                $this->Session->setFlash('Cargo Modificado','flash_success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash('Existen errores corrigalos antes de continuar','flash_error');
        }
    }   
}
?>