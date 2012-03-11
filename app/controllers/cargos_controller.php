<?php

class CargosController extends AppController {

    var $name = 'Cargos';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');
    var $paginate = array(
        'limit' => 25,
        'order' => array(
            'Cargo.NOMBRE' => 'asc'
        )
    );

    function index() {
        $this->Cargo->recursive = 0;        
        $this->set('cargos', $this->paginate());
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
        if ($this->Cargo->delete($id)) {
            $this->Session->setFlash('Cargo ' . $id . ' eliminado');
            $this->redirect(array('action' => 'index'));
        }
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
