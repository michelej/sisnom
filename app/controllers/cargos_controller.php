<?php

class CargosController extends AppController {

    var $name = 'Cargos';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');

    function index() {        
        $this->paginate = array(
            'limit' => 20,
            
            'contain' => array(
                'Historial' => array(
                    'conditions' => array(
                        'FECHA_FIN' => NULL))
                ));

        $data = $this->paginate();
        $this->set('cargos', $data);
    }

    function add() {
        if (!empty($this->data)) {
            if ($this->Cargo->save($this->data)) {
                $this->Session->setFlash('Cargo agregado con exito', 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash('Existen errores corrigalos antes de continuar', 'flash_error');
        }
    }

    function delete($id) {
        if ($this->Cargo->delete($id)) {
            $this->Session->setFlash('Cargo eliminado', 'flash_success');
            $this->redirect(array('action' => 'index'));
        }
    }

    function edit($id) {
        $this->Cargo->id = $id;
        if (empty($this->data)) {
            $this->data = $this->Cargo->read();
        } else {
            if ($this->Cargo->save($this->data)) {
                $this->Session->setFlash('Cargo Modificado', 'flash_success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash('Existen errores corrigalos antes de continuar', 'flash_error');
        }
    }

    function grupo() {        
        $data = $this->Cargo->agruparSueldos();
        if(empty($data)){
            $this->Session->setFlash('Ninguna Cargo en el sistema tiene un Sueldo Activo en este momento', 'flash_error');
            $this->redirect(array('action' => 'index'));
        }
        $this->set('cargos', $data);
    }

}

?>