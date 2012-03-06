<?php
class EmpleadosController extends AppController {

    var $name = 'Empleados';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');

    function index() {
        $this->Empleado->recursive = 0;
        $this->set('empleados', $this->paginate());        
        $this->paginate = array('limit' => '20');
        $empleado = $this->paginate('Empleado');
        $this->set('empleados', $empleado);
    }

    function add() {
        if (!empty($this->data)) {
            if ($this->Empleado->save($this->data)) {
                $this->Session->setFlash('Empleado agregado');
                $this->redirect(array('action' => 'index'));
            }
        }
        $cargos = $this->Empleado->Cargo->find('list');
        $this->set(compact('cargos'));
    }

    function delete($id) {
        if ($this->Empleado->delete($id)) {
            $this->Session->setFlash('Empleado ' . $id . ' eliminado');
            $this->redirect(array('action' => 'index'));
        }
    }

    function view($id) {
        if (!$id) {
            $this->Session->setFlash(__('Empleado Invalido', true));
            $this->redirect(array('action' => 'index'));
        }
        $empleado = $this->Empleado->read(null, $id);
        $edad = $this->Empleado->Edad();
        $this->set(compact('empleado', 'edad'));
    }

    function edit($id) {
        $this->Empleado->id = $id;
        if (empty($this->data)) {            
            $this->data = $this->Empleado->read();                        
            $cargos = $this->Empleado->Cargo->find('list');
            $this->set(compact('cargos'));
        } else {
            if ($this->Empleado->save($this->data)) {
                $this->Session->setFlash('Empleado Guardado.');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

}