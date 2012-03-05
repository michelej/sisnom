<?php

class EmpleadosController extends AppController {

    var $name = 'Empleados';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');

    function index() {
        $this->Empleado->recursive = 0;
        $this->set('empleados', $this->paginate());

        $this->paginate = array(
            'limit' => '20',
            'order' => array(
                'Empleado.nombre' => 'ASC',
            )
        );
        $empleado = $this->paginate('Empleado');
        $this->set('empleados', $empleado);
    }

    function add() {
        if (!empty($this->data)) {
            if ($this->Empleado->save($this->data)) {
                $this->Session->setFlash('Your post has been saved.');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    function delete($id) {
        if ($this->Empleado->delete($id)) {
            $this->Session->setFlash('The post with id: ' . $id . ' has been deleted.');
            $this->redirect(array('action' => 'index'));
        }
    }

}