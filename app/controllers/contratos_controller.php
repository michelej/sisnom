<?php

class ContratosController extends AppController {

    var $name = 'Contratos';
    var $components = array('RequestHandler');
    var $helpers = array('Ajax', 'Javascript');
    var $paginate = array(
        'Contrato' => array(
            'limit' => 20,
            'order' => array(
                'Contrato.FECHA_INI' => 'asc')
        )
    );

    function index() {
        $filtro = array();
        if (!empty($this->data)) {
            if ($this->data['Empleado']['Fopcion'] == 1) {
                $filtro = array('Empleado.CEDULA LIKE' => $this->data['Empleado']['valor']);
            }
            if ($this->data['Empleado']['Fopcion'] == 2) {
                $filtro = array('Empleado.NOMBRE LIKE' => $this->data['Empleado']['valor']);
            }
            if ($this->data['Empleado']['Fopcion'] == 3) {
                $filtro = array('Empleado.APELLIDO LIKE' => $this->data['Empleado']['valor']);
            }
        }
        $this->set('empleados', $this->paginate('Empleado', $filtro));
    }

    function delete($id) {
        $empleadoid = $this->Contrato->find('first', array('conditions' => array('Contrato.id' => $id), 'fields' => array('Contrato.empleado_id')));
        if ($this->Contrato->delete($id)) {
            $this->Session->setFlash('Se ha eliminado con exito','flash_success');
            $this->redirect('edit/' . $empleadoid['Contrato']['empleado_id']);
        }
    }

    function edit($id=null) {        
        if (empty($this->data)) {
            $this->Contrato->Empleado->recursive = -1;

            $contratos = $this->paginate('Contrato', array(
                'empleado_id' => $id,
                    ));

            $empleado = $this->Contrato->Empleado->findById($id);
            $cargos = $this->Contrato->Cargo->find('list');
            $departamentos = $this->Contrato->Departamento->find('list');
            $this->set(compact('contratos', 'empleado', 'cargos', 'departamentos'));
        } else {
            if ($this->Contrato->save($this->data)) {
                $this->Session->setFlash('Se ha agregado con exito','flash_success');
                $this->redirect('edit/' . $this->data['Contrato']['empleado_id']);
            }
            $this->Session->setFlash($this->Contrato->errorMessage,'flash_error');  // Mostrar Error
            $this->redirect('edit/' . $this->data['Contrato']['empleado_id']);
        }
    }

}

?>
