<?php

class HistorialesController extends AppController {

    var $name = 'Historiales';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');
    var $uses = array('Historial', 'Cargo');

    function index() {
        $this->Historial->Cargo->recursive = -1;
        $this->set('cargos', $this->paginate('Cargo'));
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
        //$this->Historial->cargo_id = $id;
        if (empty($this->data)) {
            $this->Historial->recursive=-1;                        
            $data = $this->Historial->findAllByCargoId($id);
            
            debug($data);
        } else {
            /* if ($this->Cargo->save($this->data)) {
              $this->Session->setFlash('Cargo Guardado.');
              $this->redirect(array('action' => 'index'));
              } */
        }
    }

}

?>
