<?php

class SueldosController extends AppController {

    var $name = 'Sueldos';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');

    function index() {
        $this->Cargo->recursive = 0;
        $this->paginate = array('limit' => '20');        
        $this->set('sueldos', $this->paginate());                
    }

    function add() {
        if (!empty($this->data)) {            
            if ($this->Sueldo->save($this->data)) {
                $this->Session->setFlash('Sueldo agregado');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    function delete($id) {
        if ($this->Sueldo->delete($id)) {
            $this->Session->setFlash('Sueldo ' . $id . ' eliminado');
            $this->redirect(array('action' => 'index'));
        }
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Sueldo invalido', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('sueldo', $this->Sueldo->read(null, $id));
    }
    
    function edit($id) {
        $this->Sueldo->id = $id;
        if (empty($this->data)) {
            $this->data = $this->Sueldo->read();                        
        } else {
            if ($this->Sueldo->save($this->data)) {
                $this->Session->setFlash('Sueldo Guardado.');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

}

?>
