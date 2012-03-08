<?php

class DepartamentosController extends AppController {

    var $name = 'Departamentos';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');

    function index() {
        $this->Departamento->recursive = 0;
        $this->paginate = array('limit' => '20');
        $this->set('departamentos', $this->paginate());        
    }

    function add() {
        if (!empty($this->data)) {            
            if ($this->Departamento->save($this->data)) {
                $this->Session->setFlash('Departamento agregado');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    function delete($id) {
        if ($this->Departamento->delete($id)) {
            $this->Session->setFlash('Departamento ' . $id . ' eliminado');
            $this->redirect(array('action' => 'index'));
        }
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Departamento invalido', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('departamento', $this->Departamento->read(null, $id));
    }
    
    function edit($id) {
        $this->Departamento->id = $id;
        if (empty($this->data)) {
            $this->data = $this->Departamento->read();                        
        } else {
            if ($this->Departamento->save($this->data)) {
                $this->Session->setFlash('Departamento Guardado.');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

}

?>
