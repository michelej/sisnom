<?php

class DepartamentosController extends AppController {

    var $name = 'Departamentos';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');
    var $paginate = array(
        'limit' => 20,
        'order' => array(
            'Departamento.NOMBRE' => 'asc'
        )
    );
    
    function index() {
        $this->Departamento->recursive = 0;        
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
