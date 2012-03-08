<?php

class CargosController extends AppController {

    var $name = 'Cargos';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');

    function index() {
        $this->Cargo->recursive = 0;
        $this->paginate = array('limit' => '20');
        $this->set('cargos', $this->paginate());                
    }

    function add() {
        if (!empty($this->data)) {
            debug($this->data);
            if ($this->Cargo->saveAll($this->data)) {
                $this->Session->setFlash('Cargo agregado');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    function delete($id) {
        if ($this->Cargo->delete($id)) {
            $this->Session->setFlash('Cargo ' . $id . ' eliminado');
            $this->redirect(array('action' => 'index'));
        }
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Cargo invalido', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('cargo', $this->Cargo->read(null, $id));
    }
    
    function edit($id) {
        $this->Cargo->id = $id;
        if (empty($this->data)) {
            $this->data = $this->Cargo->read();                        
        } else {
            if ($this->Cargo->save($this->data)) {
                $this->Session->setFlash('Cargo Guardado.');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

}

?>
