<?php

class VariablesController extends AppController {

    var $name = 'Variables';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');
    var $uses = 'Variable';

    function sueldo_minimo() {
        $this->paginate = array(
            'conditions' => array(
                'NOMBRE' => 'Sueldo Minimo'
            ),
            'limit' => 20,
            'order' => array(
                'FECHA_INI' => 'asc')
        );

        $variables = $this->paginate();
        $this->set('variables', $variables);
    }

    function add_sueldo_minimo() {
        if (!empty($this->data)) {            
            if ($this->Variable->save($this->data)) {
                $this->Session->setFlash('Historial agregado con exito', 'flash_success');
                $this->redirect('sueldo_minimo');
            }
            if (!empty($this->Variable->errorMessage)) {
                $this->Session->setFlash($this->Variable->errorMessage, 'flash_error');
            } else {
                $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
            }
        }
    }

    function delete_sueldo_minimo($id) {
        if ($this->Variable->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('sueldo_minimo');
        }
    }
    
    function unidad_tributaria() {
        $this->paginate = array(
            'conditions' => array(
                'NOMBRE' => 'Unidad Tributaria'
            ),
            'limit' => 20,
            'order' => array(
                'FECHA_INI' => 'asc')
        );

        $variables = $this->paginate();
        $this->set('variables', $variables);
    }

    function add_unidad_tributaria() {
        if (!empty($this->data)) {            
            if ($this->Variable->save($this->data)) {
                $this->Session->setFlash('Historial agregado con exito', 'flash_success');
                $this->redirect('unidad_tributaria');
            }
            if (!empty($this->Variable->errorMessage)) {
                $this->Session->setFlash($this->Variable->errorMessage, 'flash_error');
            } else {
                $this->Session->setFlash("Existen errores corrigalos antes de continuar", 'flash_error');
            }
        }
    }

    function delete_unidad_tributaria($id) {
        if ($this->Variable->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito', 'flash_success');
            $this->redirect('unidad_tributaria');
        }
    }
    

}

?>